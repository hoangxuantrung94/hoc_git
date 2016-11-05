<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     WpOpal Team <wpopal@gmail.com >
 * @copyright  Copyright (C) 2015 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */

if( !class_exists("Fullhouse_PBR_bootstrap_navwalker") ){
class Fullhouse_PBR_bootstrap_navwalker extends Walker_Nav_Menu {
    
   /**
     * __construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct() {
        add_filter('nav_menu_css_class' , array($this, 'special_nav_class'), 10 , 2);
    }
    
    /**
     * special_nav_class function.
     * 
     * @access public
     * @param mixed $classes
     * @param mixed $item
     * @return void
     */
    public function special_nav_class($classes, $item){
        if(in_array('current-menu-item', $classes)){
            $classes[] = 'active ';
        }
        return $classes;
    }
    
    /**
     * start_lvl function.
     * 
     * @access public
     * @param mixed &$output
     * @param mixed $depth
     * @return void
     */
    public function start_lvl( &$output, $depth=0 ,$args = array() ) {

        $indent = str_repeat( "\t", $depth );
        $output    .= "\n$indent<ul class=\"dropdown-menu\">\n";

    }

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     *
     * @since 3.0.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    /**
     * start_el function.
     * 
     * @access public
     * @param mixed &$output
     * @param mixed $item
     * @param int $depth (default: 0)
     * @param array $args (default: array())
     * @param int $id (default: 0)
     * @return void
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $li_attributes = '';
        $class_names = $value = '';

    

 
        $classes[] = ($args->has_children) ? 'dropdown' : '';
        $classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
        $classes[] = 'menu-item-' . $item->ID;
        $classes[] = 'level-'.$depth;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );



         $megacontent = '';
        if( $this->hasMega($item, $depth) ) {
         
            $megacontent = $this->genMegaMenuByConfig( $item , $depth );
            $class_names .= ' aligned-' . $item->alignment;
            $args->has_children = true; 
        }


        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';




        $output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_url( $item->url        ) .'"' : '';
        $attributes .= ($args->has_children)         ? ' class="dropdown-toggle" ' : '';


         if( $args->has_children ){
            $attributes .= ' data-hover="dropdown" data-toggle="dropdown"';
        }  

        $hascaret =  $this->hasMega($item, $depth);


        $text_customize = '';
        if( isset($item->text_customize) && !empty($item->text_customize) ){
            switch ( $item->text_customize ) {
                case 'text_new':
                    $text_customize  = esc_html__('New', 'fullhouse');
                    break;

                case 'text_hot':
                    $text_customize  = esc_html__('Hot', 'fullhouse');
                    break;

                case 'text_featured':
                    $text_customize  = esc_html__('Featured', 'fullhouse');
                    break;

                default:
                    $text_customize  = '';
                    break;
            }
            $text_customize  = ! empty( $item->text_customize ) ? '<span class="text-label ' . str_replace( '_', '-', $item->text_customize )  . '">'.$text_customize.'</span>' : '';
        }



        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $text_customize;
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= ($args->has_children)||$hascaret ? ' <b class="caret"></b></a>' : '</a>';
        $item_output .= $args->after;


     


            $item_output .= $megacontent;
   

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        //$output.='<li class="divider"></li>';
    }

    /**
     * display_element function.
     * 
     * @access public
     * @param mixed $element
     * @param mixed &$children_elements
     * @param mixed $max_depth
     * @param int $depth (default: 0)
     * @param mixed $args
     * @param mixed &$output
     * @return void
     */
    public function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {



        if ( !$element )
            return;

        $id_field = $this->db_fields['id'];


         if( $this->hasMega($element, $depth) ) {
              $children_elements[$element->$id_field] = array();
         }


        if ( is_array( $args[0] ) ) 
            $args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
        else if ( is_object( $args[0] ) ) 
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] ); 
        $cb_args = array_merge( array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'start_el'), $cb_args);

        $id = $element->$id_field;

        if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

            foreach( $children_elements[ $id ] as $child ){

                if ( !isset($newlevel) ) {
                    $newlevel = true;
                    $cb_args = array_merge( array(&$output, $depth), $args);
                    call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
                }
                $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
            }
                unset( $children_elements[ $id ] );
        }

        if ( isset($newlevel) && $newlevel ){
            $cb_args = array_merge( array(&$output, $depth), $args);
            call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
        }

        $cb_args = array_merge( array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'end_el'), $cb_args);

    }

    /**
     *
     */
    public function hasMega($item, $depth ){  
        return isset($item->megamenu_profile)&&$item->megamenu_profile; 

    }

    /**
     *
     */
    public function genMegaMenuByConfig( $item, $depth ){

        global $pbrmegamenu; 

        $post = get_post( $item->megamenu_profile ); $pbrmegamenu = 'true';
        $content = do_shortcode( $post->post_content ); 
        $pbrmegamenu  = null;
        $width  = $item->width ? 'style="width:'.$item->width.'px"':"";
        return '<div class="dropdown-menu" '.$width.'><div class="dropdown-menu-inner">'.$content.'</div></div>'; 
    }
}}