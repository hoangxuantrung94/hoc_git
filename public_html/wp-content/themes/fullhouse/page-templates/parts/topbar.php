<section id="pbr-topbar" class="pbr-topbar">
	<div class="container clearfix">

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                 <div class="left-top-bar">
                    <?php dynamic_sidebar( 'left-top-bar' ); ?>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="right-top-bar pull-right">
                    <?php dynamic_sidebar( 'right-top-bar' ); ?>
                </div>
            </div>
            
        </div>
        <!-- .row -->
                
        <div class="pull-left hidden-xs hidden-sm">
            
            <?php 
                 // WPML - Custom Languages Menu
            	fullhouse_fnc_wpml_language_buttons();
            ?>
            <?php if(has_nav_menu( 'topmenu' )): ?>
 
            <nav class="pbr-topmenu" role="navigation">
                <?php
                    $args = array(
                        'theme_location'  => 'topmenu',
                        'menu_class'      => 'pbr-menu-top list-inline list-square',
                        'fallback_cb'     => '',
                        'menu_id'         => 'main-topmenu'
                    );
                    wp_nav_menu($args);
                ?>
            </nav>
   
            <?php endif; ?>                            
        </div>
            

	</div>	
</section>