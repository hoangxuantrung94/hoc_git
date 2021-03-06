<?php

loco_require_lib('compiled/gettext.php');

/**
 * Wrapper for array forms of parsed PO data
 */
class Loco_gettext_Data extends LocoPoIterator implements JsonSerializable {
        
    
    /**
     * @return Loco_gettext_Data
     */
    public static function load( Loco_fs_File $file ){
        
        $type = strtoupper( $file->extension() );
        
        // parse PO
        if( 'PO' === $type || 'POT' === $type ){
            $po = self::fromSource( $file->getContents() );
        }
        // parse MO
        else if( 'MO' === $type ){
            $po = self::fromBinary( $file->getContents() );
        }
        // else file type not parsable. not currently sniffing file header - use the right file extension.
        else {
            // translators: Error thrown when attemping to parse a file that is not PO, POT or MO
            throw new Loco_error_Exception( sprintf( __('%s is not a Gettext file'), $file->basename() ) );
        }
        
        return $po;
    }



    /**
     * @param string assumed PO source
     * @return Loco_gettext_Data
     */
    public static function fromSource( $src ){
        return new Loco_gettext_Data( loco_parse_po($src) );
    }



    /**
     * @param string assumed MO bytes
     * @return Loco_gettext_Data
     */
    public static function fromBinary( $bin ){
        return new Loco_gettext_Data( loco_parse_mo($bin) );
    }



    /**
     * Create a dummy/empty instance 
     * @return Loco_gettext_Data
     */
    public static function dummy(){      
        return new Loco_gettext_Data( array( array('source'=>'','target'=>'') ) );
    }


    /**
     * Compile messages to binary MO format
     * @return string MO file source
     */
    public function msgfmt(){
        $mo = new LocoMo( $this, $this->getHeaders() );
        $opts = Loco_data_Settings::get();
        if( $opts->gen_hash ){
            $mo->enableHash();
        }
        if( $opts->use_fuzzy ){
            $mo->useFuzzy();
        }
        return $mo->compile();
    }



    /**
     * @return array
     */
    public function jsonSerialize(){
        $po = $this->getArrayCopy();
        // exporting headers non-scalar so js doesn't have to parse them
        try {
            $headers = $this->getHeaders();
            $po[0]['target'] = $headers->getArrayCopy();
        }
        // suppress header errors when serializing
        // @codeCoverageIgnoreStart
        catch( Exception $e ){ }
        // @codeCoverageIgnoreEnd
        return $po;
    }



    /**
     * Export to JSON for JavaScript editor
     * @return string
     */
    public function exportJson(){
        return json_encode( $this->jsonSerialize() );
    }



    /**
     * Create a signature for use in comparing source strings between documents
     * @return string
     */
    public function getSourceDigest(){
        $data = $this->getHashes();
        return md5( implode("\1",$data) );
    }

    
    
    /**
     * @return Loco_gettext_Data
     */
    public function localize( Loco_Locale $locale, array $custom = null ){
        $date = gmdate('Y-m-d H:i').'+0000'; // <- forcing UCT
        $headers = $this->getHeaders();
        // headers that must always be set if absent
        $defaults = array (
            'Project-Id-Version' => '',
            'Report-Msgid-Bugs-To' => '',
            'POT-Creation-Date' => $date,
        );
        // Project-Id-Version permitted to 
        // headers that must always override when localizing
        $required = array (
            'PO-Revision-Date' => $date,
            'Last-Translator' => '',
            'Language-Team' => $locale->getName(),
            'Language' => (string) $locale,
            'Plural-Forms' => $locale->getPluralFormsHeader(),
            'MIME-Version' => '1.0',
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Content-Transfer-Encoding' => '8bit',
            'X-Generator' => 'Loco https://localise.biz/',
            //'X-WordPress' => sprintf('Loco Translate %s, WP %s', loco_plugin_version(), $GLOBALS['wp_version'] ),
        );
        // set actual last translator from WordPress login when possible
        if( function_exists('wp_get_current_user') && ( $user = wp_get_current_user() ) ){
            $name = $user->get('display_name') or $name = 'nobody';
            $email = $user->get('user_email') or $email = 'nobody@localhost';
            $required['Last-Translator'] = apply_filters( 'loco_current_translator', sprintf('%s <%s>',$name,$email), $name, $email );
        }
        // only set absent or empty headers from default list
        foreach( $defaults as $key => $value ){
            if( ! $headers[$key] ){
                $headers[$key] = $value;
            }
        }
        // add required headers with custom ones overriding
        if( is_array($custom) ){
            $required = array_merge( $required, $custom );
        }
        foreach( $required as $key => $value ){
            $headers[$key] = $value;
        }
        // avoid non-empty POT placeholders that won't have been set from $defaults
        if( 'PACKAGE VERSION' === $headers['Project-Id-Version'] ){
            $headers['Project-Id-Version'] = '';
        }
        // header message must be un-fuzzied if it was formerly a POT file
        return $this->initPo();
    }



    /**
     * @return Loco_gettext_Data
     */
    public function templatize(){
        $date = gmdate('Y-m-d H:i').'+0000'; // <- forcing UCT
        $headers = $this->getHeaders();
        $required = array (
            'Project-Id-Version' => 'PACKAGE VERSION',
            'Report-Msgid-Bugs-To' => '',
            'POT-Creation-Date' => $date,
            'PO-Revision-Date' => 'YEAR-MO-DA HO:MI+ZONE',
            'Last-Translator' => 'FULL NAME <EMAIL@ADDRESS>',
            'Language-Team' => '',
            'Language' => '',
            'Plural-Forms' => 'nplurals=INTEGER; plural=EXPRESSION;',
            'MIME-Version' => '1.0',
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Content-Transfer-Encoding' => '8bit',
            'X-Generator' => 'Loco https://localise.biz/',
        );
        foreach( $required as $key => $value ){
            $headers[$key] = $value;
        }

        return $this->initPot();
    }



    /**
     * Remap proprietary base path when PO file is moving to another location.
     * 
     * @param Loco_fs_File the file that was originally extracted to (POT)
     * @param Loco_fs_File the file that must now target references relative to itself
     * @param string vendor name used in header keys
     * @return bool whether base header was alterered
     */
    public function rebaseHeader( Loco_fs_File $origin, Loco_fs_File $target, $vendor ){
        $base = $target->getParent();
        $head = $this->getHeaders();
        $key = 'X-'.$vendor.'-Basepath';
        if( $key = $head->normalize($key) ){
            $oldRelBase = $head[$key];    
            $oldAbsBase = new Loco_fs_Directory($oldRelBase);
            $oldAbsBase->normalize( $origin->getParent() );
            $newRelBase = $oldAbsBase->getRelativePath($base);
            // new base path is relative to $target location 
            $head[$key] = $newRelBase;
            return true;
        }
        return false;
    }



    /**
     * @param string date format as Gettext states "YEAR-MO-DA HO:MI+ZONE"
     * @return int
     */
    public static function parseDate( $podate ){
        if( method_exists('DateTime', 'createFromFormat') ){
            $objdate = DateTime::createFromFormat('Y-m-d H:iO', $podate);
            if( $objdate instanceof DateTime ){
                return $objdate->getTimestamp();
            }
        }
        return strtotime($podate);
    }

} 
