<?php
$featured = get_post_meta( get_the_ID(), OPALESTATE_PROPERTY_PREFIX.'featured', true );
?>
<?php if( $featured != 0 ) { ?>
    
<?php } ?>
