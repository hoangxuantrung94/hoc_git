<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author      Team <opalwordpress@gmail.com >
 * @copyright  Copyright (C) 2015  prestabrain.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */

if(!class_exists('Pbr_Themer_Megamenu_Config')){
    class Pbr_Themer_Megamenu_Config extends Walker_Nav_Menu  {
        /**
         * @see Walker_Nav_Menu::start_lvl()
         * @since 3.0.0
         *
         * @param string $output Passed by reference.
         */
        public function start_lvl( &$output, $depth = 0, $args = array() ) {}
        /**
         * @see Walker_Nav_Menu::end_lvl()
         * @since 3.0.0
         *
         * @param string $output Passed by reference.
         */
        public function end_lvl( &$output, $depth = 0, $args = array() ) {}

        /**
         * @see Walker::start_el()
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $item Menu item data object.
         * @param int $depth Depth of menu item. Used for padding.
         * @param object $args
         */
        public function start_el(&$output, $item, $depth=0, $args=array(),$current_object_id=0) {
            global $_wp_nav_menu_max_depth;
            $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

            ob_start();
            $item_id = esc_attr( $item->ID );
            $removed_args = array(
                'action',
                'customlink-tab',
                'edit-menu-item',
                'menu-item',
                'page-tab',
                '_wpnonce',
            );

            $original_title = '';
            if ( 'taxonomy' == $item->type ) {
                $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
                if ( is_wp_error( $original_title ) )
                    $original_title = false;
            } elseif ( 'post_type' == $item->type ) {
                $original_object = get_post( $item->object_id );
                $original_title = $original_object->post_title;
            }

            $classes = array(
                'menu-item menu-item-depth-' . $depth,
                'menu-item-' . esc_attr( $item->object ),
                'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
            );

            $title = $item->title;

            if ( ! empty( $item->_invalid ) ) {
                $classes[] = 'menu-item-invalid';
                /* translators: %s: title of menu item which is invalid */
                $title = sprintf( __( '%s (Invalid)', "pbrthemer" ), $item->title );
            } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
                $classes[] = 'pending';
                /* translators: %s: title of menu item in draft status */
                $title = sprintf( __('%s (Pending)', "pbrthemer"), $item->title );
            }

            $title = empty( $item->label ) ? $title : $item->label;

            ?>
            <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
                <dl class="menu-item-bar">
                    <dt class="menu-item-handle">
                        <span class="item-title"><?php echo esc_html( $title ); ?></span>
                        <span class="item-controls">
                            <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                            <span class="item-order hide-if-js">
                                <a href="<?php
                                    echo wp_nonce_url(
                                        add_query_arg(
                                            array(
                                                'action' => 'move-up-menu-item',
                                                'menu-item' => $item_id,
                                            ),
                                            remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                        ),
                                        'move-menu_item'
                                    );
                                ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up'); ?>">&#8593;</abbr></a>
                                |
                                <a href="<?php
                                    echo wp_nonce_url(
                                        add_query_arg(
                                            array(
                                                'action' => 'move-down-menu-item',
                                                'menu-item' => $item_id,
                                            ),
                                            remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                        ),
                                        'move-menu_item'
                                    );
                                ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down'); ?>">&#8595;</abbr></a>
                            </span>
                            <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item'); ?>" href="<?php
                                echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                            ?>"><?php _e( 'Edit Menu Item', "pbrthemer" ); ?></a>
                        </span>
                    </dt>
                </dl>

                <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
                    <?php if( 'custom' == $item->type ) : ?>
                        <p class="field-url description description-wide">
                            <label for="edit-menu-item-url-<?php echo $item_id; ?>">
                                <?php _e( 'URL', "pbrthemer" ); ?><br />
                                <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                            </label>
                        </p>
                    <?php endif; ?>
                    <p class="description description-thin">
                        <label for="edit-menu-item-title-<?php echo $item_id; ?>">
                            <?php _e( 'Navigation Label', "pbrthemer" ); ?><br />
                            <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                        </label>
                    </p>
                    <p class="description description-thin">
                        <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
                            <?php _e( 'Title Attribute', "pbrthemer" ); ?><br />
                            <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                        </label>
                    </p>
                    <p class="field-link-target description">
                        <label for="edit-menu-item-target-<?php echo $item_id; ?>">
                            <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
                            <?php _e( 'Open link in a new window/tab', "pbrthemer" ); ?>
                        </label>
                    </p>
                    <p class="field-css-classes description description-thin">
                        <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
                            <?php _e( 'CSS Classes (optional)', "pbrthemer" ); ?><br />
                            <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                        </label>
                    </p>
                    <p class="field-xfn description description-thin">
                        <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
                            <?php _e( 'Link Relationship (XFN)', "pbrthemer" ); ?><br />
                            <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                        </label>
                    </p>
                    <p class="field-description description description-wide">
                        <label for="edit-menu-item-description-<?php echo $item_id; ?>">
                            <?php _e( 'Description', "pbrthemer" ); ?><br />
                            <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                            <span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.', "pbrthemer"); ?></span>
                        </label>
                    </p>
                    <?php
                    /*
                     * This is the added field
                     */
                    ?>
                    <?php if( $depth == 0 ) {  ?>
                    <?php do_action('pbr_megamenu_item_config_toplevel',$item, $depth ); ?>
                    <?php } ?>
                    <?php do_action('pbr_megamenu_item_config',$item, $depth ); ?>

                    <?php
                    /*
                     * end added field
                     */
                    ?>
                    <div class="menu-item-actions description-wide submitbox">
                        <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
                            <p class="link-to-original">
                                <?php printf( __('Original: %s', "pbrthemer"), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                            </p>
                        <?php endif; ?>
                        <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
                        echo wp_nonce_url(
                            add_query_arg(
                                array(
                                    'action' => 'delete-menu-item',
                                    'menu-item' => $item_id,
                                ),
                                remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                            ),
                            'delete-menu_item_' . $item_id
                        ); ?>"><?php _e('Remove', "pbrthemer"); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
                            ?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel', "pbrthemer"); ?></a>
                    </div>

                    <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
                    <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
                    <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
                    <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
                    <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
                    <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
                </div><!-- .menu-item-settings-->
                <ul class="menu-item-transport"></ul>
            <?php
            $output .= ob_get_clean();
        }
    }
}

function pbr_megamenu_profiles(){
   $args = array(
      'posts_per_page'   => 15,
      'offset'           => 0,
      'category'         => '',
      'category_name'    => '',
      'orderby'          => 'post_date',
      'order'            => 'DESC',
      'include'          => '',
      'exclude'          => '',
      'meta_key'         => '',
      'meta_value'       => '',
      'post_type'        => 'megamenu_profile',
      'post_mime_type'   => '',

      'post_parent'      => '',
 
      'suppress_filters' => true 
    );
    return get_posts( $args );  
}


if(!function_exists('pbr_custom_nav_update')){
    add_action('wp_update_nav_menu_item', 'pbr_custom_nav_update',10, 3);
    function pbr_custom_nav_update($menu_id, $menu_item_db_id, $args ) {
      $fields = array( 'text_customize', 'megamenu_profile', 'alignment', 'width' );
      foreach( $fields as $field ){
        if(!isset($_POST['menu-item-'.$field][$menu_item_db_id])){
            $_POST['menu-item-'.$field][$menu_item_db_id] = "";
        }
        $custom_value = $_POST['menu-item-'.$field][$menu_item_db_id];
        update_post_meta( $menu_item_db_id, $field, $custom_value );
      }
    }
}

/*
 * Adds value of new field to $item object that will be passed to     Walker_Nav_Menu_Edit_Custom
 */

if(!function_exists('pbr_custom_nav_item')){
    add_filter( 'wp_setup_nav_menu_item','pbr_custom_nav_item' );
    function pbr_custom_nav_item($menu_item) {
        $fields = array( 'text_customize', 'megamenu_profile', 'alignment', 'width' );
        foreach( $fields as $field ){
            $menu_item->{$field} = get_post_meta( $menu_item->ID, $field, true );
        }
     //  echo '<pre>'.print_r( $menu_item ,1 );die; 
        return $menu_item;
    }
}


if(!function_exists('pbr_add_extra_fields_menu_config')){
    add_action( 'pbr_megamenu_item_config' , 'pbr_add_extra_fields_menu_config' );
    function pbr_add_extra_fields_menu_config($item, $depth=0){   
        $item_id = esc_attr( $item->ID );
    ?>
        <p class="field-addclass description description-wide">
            <label for="edit-menu-item-text_customize-<?php echo esc_attr($item_id); ?>">
                <?php  echo __( 'Label', "pbrthemer" ); ?><br />
                <select name="menu-item-text_customize[<?php echo esc_attr($item_id); ?>]">
                  <option value="" <?php selected( esc_attr($item->text_customize), '' ); ?>><?php _e('None', "pbrthemer"); ?></option>
                  <option value="text_new" <?php selected( esc_attr($item->text_customize), 'text_new' ); ?>><?php _e('New', "pbrthemer"); ?></option>
                  <option value="text_hot" <?php selected( esc_attr($item->text_customize), 'text_hot' ); ?>><?php _e('Hot', "pbrthemer"); ?></option>
                  <option value="text_featured" <?php selected( esc_attr($item->text_customize), 'text_featured' ); ?>><?php _e('Featured', "pbrthemer"); ?></option>
                </select>
            </label>
        </p>
    <?php
    }
}

function pbr_megamenu_item_config_toplevel( $item ){
      $item_id = esc_attr( $item->ID );
      $posts_array = pbr_megamenu_profiles();
?>
      <p class="field-addclass description description-wide">
          <label for="edit-menu-item-megamenu_profile-<?php echo esc_attr($item_id); ?>"> 
              <?php _e(  'Megamenu Profile' ); ?> <br>
               <select name="menu-item-megamenu_profile[<?php echo esc_attr($item_id); ?>]">
                <option value=""><?php _e( 'Disable', "pbrthemer" ); ?></option>
                <?php foreach( $posts_array as $_post ){  ?>
                  <option  value="<?php echo esc_attr($_post->ID);?>" <?php selected( esc_attr($item->megamenu_profile), $_post->ID ); ?> ><?php echo esc_html($_post->post_title); ?></option>
                  <?php } ?>
              </select>
          </label>

          <a href="<?php echo  esc_url( admin_url( 'edit.php?post_type=megamenu_profile') ); ?>" target="_blank" title="<?php _e( 'Profiles Management', "pbrthemer" ); ?>"><?php _e( 'Profiles Management', "pbrthemer" ); ?></a>
          <div><?php _e( 'If enabled megamenu, its submenu will be disabled', "pbrthemer" ); ?></div>
      </p>

       <p class="field-width description description-wide">   
        <label  for="edit-menu-item-width-<?php echo esc_attr($item_id); ?>"><?php _e( 'Width:', "pbrthemer" ); ?> <br>
            <input type="text"  name="menu-item-width[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item->width); ?>">
        </label>
       </p>

      <?php 
        $aligns = array(
              'left' => __('Left', "pbrthemer"),
              'right' => __('Right', "pbrthemer"),
              'fullwidth' => __('Fullwidth', "pbrthemer")
          ); 
      ?> 
      <p class="field-alignment description description-wide">   
          <label  for="edit-menu-item-alignment-<?php echo esc_attr($item_id); ?>"><?php _e( 'Alignment:', "pbrthemer" ); ?> <br>
          <select name="menu-item-alignment[<?php echo esc_attr($item_id); ?>]">
              <?php foreach( $aligns as $key => $align ){ ?>
              <option <?php selected( esc_attr($item->alignment), $key ); ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_html($align); ?></option>
              <?php } ?>
          </select></label>
      </p>
<?php 
}

add_action( 'pbr_megamenu_item_config_toplevel', 'pbr_megamenu_item_config_toplevel' );

?>
<?php
 /**
  * $Desc
  *
  * @version    $Id$
  * @package    wpbase
  * @author      Team <opalwordpress@gmail.com >
  * @copyright  Copyright (C) 2015 prestabrain.com. All Rights Reserved.
  * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
  *
  * @website  http://www.wpopal.com
  * @support  http://www.wpopal.com/questions/
  */


 

if(!function_exists('pbr_custom_nav_edit_walker')){
    add_filter( 'wp_edit_nav_menu_walker', 'pbr_custom_nav_edit_walker',10,2 );
    function pbr_custom_nav_edit_walker($walker,$menu_id) {
        return 'Pbr_Themer_Megamenu_Config';
    }
}

function pbr_themer_megamenu_megamenu(){ 
    wp_enqueue_style( 'megamenu_css', PBR_THEMER_PLUGIN_THEMER_URL.'assets/css/megamenu.css');
    wp_enqueue_script('megamenu_js', PBR_THEMER_PLUGIN_THEMER_URL.'assets/js/megamenu.js');   
}
add_action( 'admin_init', 'pbr_themer_megamenu_megamenu' );

function pbr_create_megamenu_profiles(){   
  $labels = array(
    'name' => __( 'Megamenu', "pbrthemer" ),
    'singular_name' => __( 'Megamenu', "pbrthemer" ),
    'add_new' => __( 'Add Profile', "pbrthemer" ),
    'add_new_item' => __( 'Add Profile', "pbrthemer" ),
    'edit_item' => __( 'Edit Profile', "pbrthemer" ),
    'new_item' => __( 'New Profile', "pbrthemer" ),
    'view_item' => __( 'View Profile', "pbrthemer" ),
    'search_items' => __( 'Search Profile', "pbrthemer" ),
    'not_found' => __( 'No Profiles found', "pbrthemer" ),
    'not_found_in_trash' => __( 'No Profiles found in Trash', "pbrthemer" ),
    'parent_item_colon' => __( 'Parent Profile:', "pbrthemer" ),
    'menu_name' => __( 'Megamenu', "pbrthemer" ),
  );

  $args = array(
      'labels' => $labels,
      'hierarchical' => true,
      'description' => 'List Footer',
      'supports' => array( 'title', 'editor' ),
      'public' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'menu_position' => 5,
      'show_in_nav_menus' => false,
      'publicly_queryable' => false,
      'exclude_from_search' => false,
      'has_archive' => false,
      'query_var' => true,
      'can_export' => true,
      'rewrite' => false
  );
  register_post_type( 'megamenu_profile', $args );

  if( isset($_GET['reset']) && isset($_GET['group']) && $_GET['group'] ){  
       delete_option( 'megamenu_data_saved_'.$_GET['group'] );
  }
  if( isset($_POST['megamenu_data_saved']) ){   
      update_option( 'megamenu_data_saved_'.$_POST['menu-group'], $_POST['megamenu_profile'] );
  }
}

add_action('init','pbr_create_megamenu_profiles');

/**
 *
 */
function pbr_add_megamenu_setting_page(){
    $selectenav =  isset($_GET['group']) && $_GET['group'] ? $_GET['group']:2;
    $items = wp_get_nav_menu_items( $selectenav, array('menu_item_parent'=>0) ); 
    $group = $selectenav;  
    $megaData = get_option( 'megamenu_data_saved_'.$group );

  
?>
<div class="wrap wrap-reports">
   <h1><?php _e( 'Megamenu Assignment' , "pbrthemer" );?></h1>
  
  <form method="post" action="<?php echo  esc_url( admin_url( 'edit.php?post_type=megamenu_profile&page=megamenu-setting&group='.$group) ); ?>">

         <div class="manage-menus">
                <div class="pull-left">
                  <input type="hidden" value="edit" name="action">
                  <label class="selected-menu" for="menu"><?php echo __('Menu Group', "pbrthemer"); ?>:</label>
                 <?php $menus = pbr_get_menugroups()  ; ?>
                  <select class="form-control" name="menu-group" id="menugroup"  onchange="location.href='<?php echo  esc_url( admin_url( 'edit.php?post_type=megamenu_profile&page=megamenu-setting&group=') ); ?>'+this.value">
                    <?php foreach($menus as $gmenu => $label) :  ?>
                    <option value="<?php echo esc_attr( $gmenu );?>"  <?php if( $selectenav == $gmenu ) { ?>selected="selected"<?php } ?>><?php echo esc_html( $label ); ?></option>
                    <?php endforeach; ?>
                  </select>   
                </div>
                <div class="pull-left">   
                   <input type="hidden" value="1" name="megamenu_data_saved">
                   <input type="hidden" value="reset" id="" name="megamenu_data_mode">
                   
                   <?php submit_button(); ?>
                </div>  
                <div class="pull-left">

                   <?php if( $group ) { ?>
                   <p class="submit"> <a href="<?php echo  esc_url( admin_url( 'edit.php?post_type=megamenu_profile&page=megamenu-setting&reset=1&group='.$group) ); ?>"><?php _e( 'Reset', "pbrthemer" );?></a></p>
                   <?php } ?>
                </div>  
          </div>

      <div id="menu-management">
            <div id="post-body">
                  <div id="post-body-content">
                  <h3>Menu Structure</h3>
                          <ul class="inline-menu">
                           <?php  
                            
                            $posts_array = pbr_megamenu_profiles();
       
                            $aligns = array(
                                'left' => __('Left', "pbrthemer"),
                                'right' => __('Right', "pbrthemer"),
                                'fullwidth' => __('Fullwidth', "pbrthemer")
                            ); 


                            foreach( $items as $item ){ 
                              if( $item->menu_item_parent==0){

                                $data = array(
                                    'width'      => '',
                                    'post_id'    => '',
                                    'alignment'  => ''
                                );



                                if( isset($megaData[$item->ID]) && is_array($megaData[$item->ID]) ){
                                   $data = array_merge( $data, $megaData[$item->ID] );
                                } // echo '<pre>'.print_r( $data, 1 );die; 
                            ?>
                           <li class="menu-item">

                            <span><?php echo esc_html($item->title); ?></span>

                            <dl class="menu-item-wrap"><dt class="menu-item-inner ">
                                <em><?php _e( 'Close' , "pbrthemer" ); ?></em>
                              <div>
                                <label><?php _e(  'Megamenu Profile' ); ?></label>
                                <select class="megamenu_profile" name="megamenu_profile[<?php echo esc_attr($item->ID); ?>][post_id]">
                                  <option value=""><?php _e( 'Disable', "pbrthemer" ); ?></option>
                                  <?php foreach( $posts_array as $_post ){  ?>
                                    <option <?php if( $data['post_id'] == $_post->ID) {?> selected="selected"<?php } ?> value="<?php echo esc_attr($_post->ID);?>"><?php echo esc_html($_post->post_title); ?></option>
                                    <?php } ?>
                                </select>
                              </div>

                              <div>   
                                <label><?php _e( 'Width:', "pbrthemer" ); ?> </label>
                                    <input type="text" name="megamenu_profile[<?php echo esc_attr($item->ID); ?>][width]" value="<?php echo esc_attr( $data['width'] ); ?>">
                                
                               </div>

                              <?php 
                                $aligns = array(
                                      'left' => __('Left', "pbrthemer"),
                                      'right' => __('Right', "pbrthemer"),
                                      'fullwidth' => __('Fullwidth', "pbrthemer")
                                  ); 

                              ?> 
                              <div>   
                                <label><?php _e( 'Alignment:', "pbrthemer" ); ?> </label>
                                      <select name="megamenu_profile[<?php echo esc_attr($item->ID); ?>][alignment]">
                                          <?php foreach( $aligns as $key => $align ){ ?>
                                          <option <?php if( $data['alignment'] == $key ) {?> selected="selected"<?php } ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_html($align); ?></option>
                                          <?php } ?>
                                      </select>
                               
                               </div>


                           </dt></dl>

                         </li>

                          <?php } } ?> 
                        </ul>
                  </div>
             </div>                     
       </div> 
       

</form>

</div>  
<?php }


function pbr_add_megamenu_setting() {
   // add_submenu_page(  'edit.php?post_type=megamenu_profile',  __( 'Setting', "pbrthemer" ), __( 'Assigment', "pbrthemer" ), 'manage_options', 'megamenu-setting',  'pbr_add_megamenu_setting_page'  );
}
add_action( 'admin_menu',  'pbr_add_megamenu_setting'  , 20 ); 