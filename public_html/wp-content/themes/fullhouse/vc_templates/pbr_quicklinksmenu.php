<?php 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


?>
 <?php
 		$menu = ( $menu !='' ) ? wp_get_nav_menu_object( $menu ) : false;

        $args = array(
            'menu'  => $menu,
            'container_class' => '',
            'menu_class'      => 'list-inline bullets'
        );
      
    ?>
<div class="widget-quicklink-menu clearfix hidden-xs">
	<h5 class="quicklink-heading pull-left"><?php echo esc_html( $title ); ?></h5>
	<div class="quicklink-content pull-left"><?php wp_nav_menu($args); ?></div>
</div>