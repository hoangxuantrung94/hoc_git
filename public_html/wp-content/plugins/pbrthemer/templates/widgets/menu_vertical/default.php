<?php

$nav_menu = ( $menu !='' ) ? wp_get_nav_menu_object( $menu ) : false;


if(!$nav_menu) return false;
$postion_class = ($position=='left')?'menu-left':'menu-right';
$args = array(  'menu' => $nav_menu,
                'container_class' => 'collapse navbar-collapse navbar-ex1-collapse vertical-menu '.$postion_class,
                'menu_class' => 'nav navbar-nav megamenu',
                'fallback_cb' => '',
                'walker' => class_exists("Pbr_Themer_Megamenu_Vertical") ? new Pbr_Themer_Megamenu_Vertical($nav_menu->term_id):null );

if ( $title ) {
    echo ($before_title)  . trim( $title ) . $after_title;
}
?>
<?php wp_nav_menu($args); ?>
