<?php 
/**
 * Class Fullhouse Opalestate
 *
 */
class Fullhouse_Opalestate{

    /**
     * Constructor to create an instance of this for processing logics render content and modules.
     */
	public function __construct(){
		add_action( 'customize_register',  array( $this, 'registerCustomizer' ), 9 );
        add_action( 'wp_enqueue_scripts', array( $this, 'loadThemeStyles' ), 15 );
    }

	/**
	 * Add settings to the Customizer.
	 *
	 * @static
	 * @access public
	 * @since Fullhouse 1.0
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer object.
	 */
	public function registerCustomizer( $wp_customize ){
		$wp_customize->add_panel( 'panel_opalestate', array(
    		'priority' => 70,
    		'capability' => 'edit_theme_options',
    		'theme_supports' => '',
    		'title' => esc_html__( 'fullhouse', 'fullhouse' ),
    		'description' =>esc_html__( 'Make default setting for page, general', 'fullhouse' ),
    	) );

        /**
         * General Setting
         */
        $wp_customize->add_section( 'opalestate_general_settings', array(
            'priority' => 1,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => esc_html__( 'General Setting', 'fullhouse' ),
            'description' => '',
            'panel' => 'panel_opalestate',
        ) );


        /**
         * Archive Page Setting
         */
        $wp_customize->add_section( 'opalestate_archive_settings', array(
            'priority' => 2,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => esc_html__( 'Archive Page Setting', 'fullhouse' ),
            'description' => 'Configure categories, search, properties page setting',
            'panel' => 'panel_opalestate',
        ) );

         ///  Archive layout setting
        $wp_customize->add_setting( 'pbr_theme_options[opalestate-archive-layout]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 'mainright',
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( new Fullhouse_Layout_DropDown( $wp_customize,  'pbr_theme_options[opalestate-archive-layout]', array(
            'settings'  => 'pbr_theme_options[opalestate-archive-layout]',
            'label'     => esc_html__('Archive Layout', 'fullhouse'),
            'section'   => 'opalestate_archive_settings',
            'priority' => 1

        ) ) );

       //sidebar archive left
        $wp_customize->add_setting( 'pbr_theme_options[opalestate-archive-left-sidebar]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 'sidebar-left',
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( new Fullhouse_Sidebar_DropDown( $wp_customize,  'pbr_theme_options[opalestate-archive-left-sidebar]', array(
            'settings'  => 'pbr_theme_options[opalestate-archive-left-sidebar]',
            'label'     => esc_html__('Archive Left Sidebar', 'fullhouse'),
            'section'   => 'opalestate_archive_settings' ,
             'priority' => 3
        ) ) );

          //sidebar archive right
        $wp_customize->add_setting( 'pbr_theme_options[opalestate-archive-right-sidebar]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 'sidebar-right',
            'checked' => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        $wp_customize->add_control( new Fullhouse_Sidebar_DropDown( $wp_customize,  'pbr_theme_options[opalestate-archive-right-sidebar]', array(
            'settings'  => 'pbr_theme_options[opalestate-archive-right-sidebar]',
            'label'     => esc_html__('Archive Right Sidebar', 'fullhouse'),
            'section'   => 'opalestate_archive_settings',
             'priority' => 4 
        ) ) );

        /**
    	 * Property Single Setting
    	 */
    	$wp_customize->add_section( 'opalestate_single_settings', array(
    		'priority' => 12,
    		'capability' => 'edit_theme_options',
    		'theme_supports' => '',
    		'title' => esc_html__( 'Single Property Page Setting', 'fullhouse' ),
    		'description' => 'Configure single property page',
    		'panel' => 'panel_opalestate',
    	) );
        ///  single layout setting
        $wp_customize->add_setting( 'pbr_theme_options[opalestate-single-layout]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 'mainright',
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        //Select layout
        $wp_customize->add_control( new Fullhouse_Layout_DropDown( $wp_customize,  'pbr_theme_options[opalestate-single-layout]', array(
            'settings'  => 'pbr_theme_options[opalestate-single-layout]',
            'label'     => esc_html__('Property Detail Layout', 'fullhouse'),
            'section'   => 'opalestate_single_settings',
            'priority' => 1
        ) ) );

       
        $wp_customize->add_setting( 'pbr_theme_options[opalestate-single-left-sidebar]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 1,
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        //Sidebar left
        $wp_customize->add_control( new Fullhouse_Sidebar_DropDown( $wp_customize,  'pbr_theme_options[opalestate-single-left-sidebar]', array(
            'settings'  => 'pbr_theme_options[opalestate-single-left-sidebar]',
            'label'     => esc_html__('Property Detail Left Sidebar', 'fullhouse'),
            'section'   => 'opalestate_single_settings',
            'priority' => 2 
        ) ) );

         $wp_customize->add_setting( 'pbr_theme_options[opalestate-single-right-sidebar]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'   => 'sidebar-right',
            'sanitize_callback' => 'sanitize_text_field'
        ) );

        //Sidebar right
        $wp_customize->add_control( new Fullhouse_Sidebar_DropDown( $wp_customize,  'pbr_theme_options[opalestate-single-right-sidebar]', array(
            'settings'  => 'pbr_theme_options[opalestate-single-right-sidebar]',
            'label'     => esc_html__('Property Detail Right Sidebar', 'fullhouse'),
            'section'   => 'opalestate_single_settings',
            'priority' => 3 
        ) ) );


        /* 
         * Custom single property breadcrumb background image 
         */
         $wp_customize->add_setting('pbr_theme_options[image-property-breadcrumb]', array(
            'default'    => '',
            'type'       => 'option',
            'capability' => 'manage_options',
            'sanitize_callback' => 'esc_url_raw',
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'pbr_theme_options[image-property-breadcrumb]', array(
            'label'    => esc_html__('Single Property Breadcrumb Background', 'fullhouse'),
            'section'  => 'opalestate_single_settings',
            'settings' => 'pbr_theme_options[image-property-breadcrumb]',
            'priority' => 4,
        ) ) );

        /* 
         * Custom single agent breadcrumb background image 
         */
         $wp_customize->add_setting('pbr_theme_options[image-agent-breadcrumb]', array(
            'default'    => '',
            'type'       => 'option',
            'capability' => 'manage_options',
            'sanitize_callback' => 'esc_url_raw',
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'pbr_theme_options[image-agent-breadcrumb]', array(
            'label'    => esc_html__('Single Agent Breadcrumb Background', 'fullhouse'),
            'section'  => 'opalestate_single_settings',
            'settings' => 'pbr_theme_options[image-agent-breadcrumb]',
            'priority' => 4,
        ) ) );

	}

    /**
     * Load opalestate styles follow theme skin actived
     *
     * @static
     * @access public
     * @since Fullhouse 1.0
     */
    public function loadThemeStyles() {
        $current = fullhouse_fnc_theme_options( 'skin','default' );
        if(isset($_GET['pbr-skin']) && $_GET['pbr-skin']) {
            $current = $_GET['pbr-skin'];
        }else{
            $current = fullhouse_fnc_theme_options( 'skin','default' );
        }
        if($current == 'default'){
            $path =  get_template_directory_uri() .'/css/opalestate.css';
        }else{
            $path =  get_template_directory_uri() .'/css/skins/'.$current.'/opalestate.css';
        }
        wp_enqueue_style( 'fullhouse-opalestate', $path , 'fullhouse-opalestate-front' , FULLHOUSE_THEME_VERSION, 'all' );
    }

}

new Fullhouse_Opalestate();