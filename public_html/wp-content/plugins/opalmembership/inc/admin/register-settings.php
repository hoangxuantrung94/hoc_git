<?php
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opalmembership
 * @author     Opal  Team <info@wpopal.com >
 * @copyright  Copyright (C) 2016 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/support/forum.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Opalmembership_Plugin_Settings {

	/**
	 * Option key, and option page slug
	 * @var string
	 */
	private $key = 'opalmembership_settings';

	/**
	 * Array of metaboxes/fields
	 * @var array
	 */
	protected $option_metabox = array();

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor
	 * @since 1.0
	 */
	public function __construct() {

		add_action( 'admin_init', array( $this, 'init' ) );

		//Customize CMB2 URL
		add_filter( 'cmb2_meta_box_url', array( $this, 'opalmembership_update_cmb_meta_box_url' ) );

		//Custom CMB2 Settings Fields
		add_action( 'cmb2_render_opalmembership_title', 'opalmembership_title_callback', 10, 5 );
		add_action( 'cmb2_render_opalmembership_enabled_gateways', 'opalmembership_enabled_gateways_callback', 10, 5 );
		add_action( 'cmb2_render_opalmembership_default_gateway', 'opalmembership_default_gateway_callback', 10, 5 );
//		add_action( 'cmb2_render_email_preview_buttons', 'opalmembership_email_preview_buttons_callback', 10, 5 );
		// add_action( 'cmb2_render_system_info', 'opalmembership_system_info_callback', 10, 5 );
		// add_action( 'cmb2_render_api', 'opalmembership_api_callback', 10, 5 );
		add_action( 'cmb2_render_license_key', 'opalmembership_license_key_callback', 10, 5 );
		add_action( "cmb2_save_options-page_fields", array( $this, 'settings_notices' ), 10, 3 );

		// Include CMB CSS in the head to avoid FOUC
		add_action( "admin_print_styles-opalmembership_properties_page_opalmembership-settings", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );

	}

	/**
	 * Register our setting to WP
	 * @since  1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );

	}


	/**
	 * Filter CMB2 URL
	 *
	 * @description: Required for CMB2 to properly load CSS/JS
	 *
	 * @param $url
	 *
	 * @return mixed
	 */
	public function opalmembership_update_cmb_meta_box_url( $url ) {
		//Path to Opalmembership's CMB
		return OPALMEMBERSHIP_PLUGIN_URL . '/inc/vendors/cmb2/libraries/';
	}

	/**
	 * Retrieve settings tabs
	 *
	 * @since 1.0
	 * @return array $tabs
	 */
	public function opalmembership_get_settings_tabs() {

		$settings = $this->opalmembership_settings( null );

		$tabs             = array();
		$tabs['general']  = __( 'General', 'opalmembership' );
		$tabs['gateways'] = __( 'Payment Gateways', 'opalmembership' );
		// $tabs['display']  = __( 'Display Options', 'opalmembership' );
		$tabs['emails']   = __( 'Emails', 'opalmembership' );

		if ( ! empty( $settings['addons']['fields'] ) ) {
	//		$tabs['addons'] = __( 'Add-ons', 'opalmembership' );
		}

		if ( ! empty( $settings['licenses']['fields'] ) ) {
		//	$tabs['licenses'] = __( 'Licenses', 'opalmembership' );
		}

		//$tabs['advanced']    = __( 'Advanced', 'opalmembership' );
		//$tabs['api']         = __( 'API', 'opalmembership' );
		//$tabs['system_info'] = __( 'System Info', 'opalmembership' );

		return apply_filters( 'opalmembership_settings_tabs', $tabs );
	}


	/**
	 * Admin page markup. Mostly handled by CMB2
	 * @since  1.0
	 */
	public function admin_page_display() {

		$active_tab = isset( $_GET['tab'] ) && array_key_exists( $_GET['tab'], $this->opalmembership_get_settings_tabs() ) ? $_GET['tab'] : 'general';

		?>

		<div class="wrap opalmembership_settings_page cmb2_options_page <?php echo $this->key; ?>">
			<h2 class="nav-tab-wrapper">
				<?php
				foreach ( $this->opalmembership_get_settings_tabs() as $tab_id => $tab_name ) {

					$tab_url = esc_url( add_query_arg( array(
						'settings-updated' => false,
						'tab'              => $tab_id
					) ) );

					$active = $active_tab == $tab_id ? ' nav-tab-active' : '';

					echo '<a href="' . esc_url( $tab_url ) . '" title="' . esc_attr( $tab_name ) . '" class="nav-tab' . $active . '">';
					echo esc_html( $tab_name );

					echo '</a>';
				}
				?>
			</h2>

			<?php
				/**
				 * Before render form
				 */
				do_action( 'opalmembership_before_render_setting_fields', $active_tab, $this->key );

				/**
				 * render setting form
				 */
				cmb2_metabox_form( $this->opalmembership_settings( $active_tab ), $this->key );

				/**
				 * after render form
				 */
				do_action( 'opalmembership_before_render_setting_fields', $active_tab, $this->key );
			?>

		</div><!-- .wrap -->

		<?php
	}

	/**
	 * Define General Settings Metabox and field configurations.
	 *
	 * Filters are provided for each settings section to allow add-ons and other plugins to add their own settings
	 *
	 * @param $active_tab active tab settings; null returns full array
	 *
	 * @return array
	 */
	public function opalmembership_settings( $active_tab = null ) {

		$list_tags = '<td>
				<p class="tags-description">Use the following tags to automatically add booking information to the emails. Tags labeled with an asterisk (*) can be used in the email subject as well.</p>
				<div class="rtb-template-tags-box">
					<strong>{payment_number}</strong> Email of the user who made the booking
				</div>
				<div class="rtb-template-tags-box">
					<strong>{payment_link}</strong> Email of the user who made the booking
				</div>
				<div class="rtb-template-tags-box">
					<strong>{package_membership}</strong> Email of the user who made the booking
				</div>

				<div class="rtb-template-tags-box">
					<strong>{user_email}</strong> Email of the user who made the booking
				</div>
				<div class="rtb-template-tags-box">
					<strong>{user_name}</strong> * Name of the user who made the booking
				</div>
			
				<div class="rtb-template-tags-box">
					<strong>{date}</strong> * Date and time of the booking
				</div>

				<div class="rtb-template-tags-box">
					<strong>{site_name}</strong> The name of this website
				</div>
				<div class="rtb-template-tags-box">
					<strong>{site_link}</strong> A link to this website
				</div>
				<div class="rtb-template-tags-box">
					<strong>{current_time}</strong> Current date and time
				</div></td>';

		$list_tags = apply_filters( 'opalmembership_email_tags', $list_tags );
				
		$opalmembership_settings = array(
			/**
			 * General Settings
			 */
			'general'     => array(
				'id'         => 'options_page',
				'opalmembership_title' => __( 'General Settings', 'opalmembership' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
				'fields'     => apply_filters( 'opalmembership_settings_general', array(
						array(
							'name' => __( 'General Settings', 'opalmembership' ),
							'desc' => '<hr>',
							'type' => 'opalmembership_title',
							'id'   => 'opalmembership_title_general_settings_1'
						),

						array(
							'name'    => __( 'Grid Column', 'opalmembership' ),
							'desc'    => __( 'Set number of grid column to display list of membership package', 'opalmembership' ),
							'id'      => 'gridcols',
							'type'    => 'text_small',
							'default' => 3
						),

						array(
							'name'    => __( 'Membership Packages Page', 'opalmembership' ),
							'desc'    => __( 'This is the page show list of packages. The <code>[opalmembership_packages]</code> shortcode should be on this page.', 'opalmembership' ),
							'id'      => 'membership_page',
							'type'    => 'select',
							'options' => opalmembership_cmb2_get_post_options( array(
								'post_type'   => 'page',
								'numberposts' => - 1
							) ),
							'default'	=> 0
						),

						array(
							'name'    => __( 'Dashboard Page', 'opalmembership' ),
							'desc'    => __( 'This is the page show up account manager. The <code>[opalmembership_dashboard]</code> shortcode should be on this page.', 'opalmembership' ),
							'id'      => 'dashboard_page',
							'type'    => 'select',
							'options' => opalmembership_cmb2_get_post_options( array(
								'post_type'   => 'page',
								'numberposts' => - 1
							) ),
							'default'	=> 0
						),
						array(
							'name'    => __( 'Register Page', 'opalmembership' ),
							'desc'    => __( 'This is the page show up register form. The <code>[opalmembership_register_form]</code> shortcode should be on this page.', 'opalmembership' ),
							'id'      => 'register_page',
							'type'    => 'select',
							'options' => opalmembership_cmb2_get_post_options( array(
								'post_type'   => 'page',
								'numberposts' => - 1
							) ),
							'default'	=> 0
						),
						array(
							'name'    => __( 'Login user after register completed', 'opalmembership' ),
							'desc'    => __( 'This option will loggin user after they register completed, if it checked.', 'opalmembership' ),
							'id'      => 'login_user',
							'type'    => 'checkbox',
							'default'	=> 1
						),
						array(
							'name'    => __( 'Login Page', 'opalmembership' ),
							'desc'    => __( 'This is the page show up login form. The <code>[opalmembership_login_form]</code> shortcode should be on this page.', 'opalmembership' ),
							'id'      => 'login_page',
							'type'    => 'select',
							'options' => opalmembership_cmb2_get_post_options( array(
								'post_type'   => 'page',
								'numberposts' => - 1
							) ),
							'default'	=> 0
						),
						array(
							'name'    => __( 'Success Page', 'opalmembership' ),
							'desc'    => __( 'This is the page donators are sent to after completing their donations. The <code>[opalmembership_receipt]</code> shortcode should be on this page.', 'opalmembership' ),
							'id'      => 'success_page',
							'type'    => 'select',
							'options' => opalmembership_cmb2_get_post_options( array(
								'post_type'   => 'page',
								'numberposts' => - 1
							) ),
							'default'	=> 0
						),
						
						array(
							'name'    => __( 'CheckOut Page', 'opalmembership' ),
							'desc'    => __( 'This page shows a complete donation history for the current user. The <code>[opalmembership_checkout]</code> shortcode should be on this page.', 'opalmembership' ),
							'id'      => 'checkout_page',
							'type'    => 'select',
							'options' => opalmembership_cmb2_get_post_options( array(
								'post_type'   => 'page',
								'numberposts' => - 1
							) ),
							'default'	=> 0
						),
						array(
							'name'    => __( 'Payment History Page', 'opalmembership' ),
							'desc'    => __( 'This page shows a complete payments history for the current user. The <code>[opalmembership_history]</code> shortcode should be on this page.', 'opalmembership' ),
							'id'      => 'history_page',
							'type'    => 'select',
							'options' => opalmembership_cmb2_get_post_options( array(
								'post_type'   => 'page',
								'numberposts' => - 1
							) ),
							'default'	=> 0
						),
						array(
							'name'    => __( 'Enable Guest Checkout', 'opalmembership' ),
							'desc'    => __( 'This option allow guest checkout without login your site.', 'opalmembership' ),
							'id'      => 'enable_guest_checkout',
							'type'    => 'checkbox',
							'default'	=> 0
						),
						array(
							'name'    => __( 'Base Country', 'opalmembership' ),
							'desc'    => __( 'Where does your site operate from?', 'opalmembership' ),
							'id'      => 'base_country',
							'type'    => 'select',
							'options' => opalmembership_get_country_list(),
							'default'	=> 'US'
						),
						array(
							'name' => __( 'Currency Settings', 'opalmembership' ),
							'desc' => '<hr>',
							'type' => 'opalmembership_title',
							'id'   => 'opalmembership_title_general_settings_2'
						),
						array(
							'name'    => __( 'Currency', 'cmb' ),
							'desc'    => 'Choose your currency. Note that some payment gateways have currency restrictions.',
							'id'      => 'currency',
							'type'    => 'select',
							'options' => opalmembership_get_currencies(),
							'default' => 'USD',
						),
						array(
							'name'    => __( 'Currency Position', 'cmb' ),
							'desc'    => 'Choose the position of the currency sign.',
							'id'      => 'currency_position',
							'type'    => 'select',
							'options' => array(
								'before' => __( 'Before - $10', 'opalmembership' ),
								'after'  => __( 'After - 10$', 'opalmembership' )
							),
							'default' => 'before',
						),
						array(
							'name'    => __( 'Thousands Separator', 'opalmembership' ),
							'desc'    => __( 'The symbol (typically , or .) to separate thousands', 'opalmembership' ),
							'id'      => 'thousands_separator',
							'type'    => 'text_small',
							'default' => ',',
						),
						array(
							'name'    => __( 'Decimal Separator', 'opalmembership' ),
							'desc'    => __( 'The symbol (usually , or .) to separate decimal points', 'opalmembership' ),
							'id'      => 'decimal_separator',
							'type'    => 'text_small',
							'default' => '.',
						),

						array(
							'name'    => __( 'Decimal Numbers', 'opalmembership' ),
							'desc'    => __( 'The symbol (usually , or .) to separate decimal points', 'opalmembership' ),
							'id'      => 'price_num_decimals',
							'type'    => 'text_small',
							'default' => '2'
						),
					)
				)
			),
			/**
			 * Payment Gateways
			 */
			'gateways'    => array(
				'id'         => 'options_page',
				'opalmembership_title' => __( 'Payment Gateways', 'opalmembership' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key ) ),
				'fields'     => apply_filters( 'opalmembership_settings_gateways', array(
						array(
							'name' => __( 'Gateways Settings', 'opalmembership' ),
							'desc' => '<hr>',
							'id'   => 'opalmembership_title_gateway_settings_1',
							'type' => 'opalmembership_title'
						),
						array(
							'name' => __( 'Test Mode', 'opalmembership' ),
							'desc' => __( 'While in test mode no live transactions are processed. To fully use test mode, you must have a sandbox (test) account for the payment gateway you are testing.', 'opalmembership' ),
							'id'   => 'test_mode',
							'type' => 'checkbox',
							'default' => '1'
						),
						array(
							'name' => __( 'Enabled Gateways', 'opalmembership' ),
							'desc' => __( 'Choose the payment gateways you would like enabled.', 'opalmembership' ),
							'id'   => 'gateways',
							'type' => 'opalmembership_enabled_gateways',
							'default' => '1'
						),
						array(
							'name' => __( 'Default Gateway', 'opalmembership' ),
							'desc' => __( 'This is the gateway that will be selected by default.', 'opalmembership' ),
							'id'   => 'default_gateway',
							'type' => 'opalmembership_default_gateway',
							'default' => '1'
						),

					)
				)
			),
			/** Display Settings */
			'display'     => array(
				'id'         => 'options_page',
				'opalmembership_title' => __( 'Display Settings', 'opalmembership' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key ) ),
				'fields'     => apply_filters( 'opalmembership_settings_display', array(
						array(
							'name' => __( 'Display Settings', 'opalmembership' ),
							'desc' => '<hr>',
							'id'   => 'opalmembership_title_display_settings_1',
							'type' => 'opalmembership_title'
						),
						array(
							'name' => __( 'Disable CSS', 'opalmembership' ),
							'desc' => __( 'Enable this option if you would like to disable all of Opalmembership\'s included CSS stylesheets.', 'opalmembership' ),
							'id'   => 'disable_css',
							'type' => 'checkbox'
						),
						array(
							'name' => __( 'Enable Floating Labels', 'opalmembership' ),
							'desc' => sprintf( __( 'Enable this option if you would like to enable <a href="%s" target="_blank">floating labels</a> in Opalmembership\'s donation forms.<br>Be aware that if you have the "Disable CSS" option enabled, you will need to style the floating labels yourself.', 'opalmembership' ), esc_url( "http://bradfrost.com/blog/post/float-label-pattern/" ) ),
							'id'   => 'enable_floatlabels',
							'type' => 'checkbox'
						),
						array(
							'name' => __( 'Disable Welcome Screen', 'opalmembership' ),
							'desc' => sprintf( __( 'Enable this option if you would like to disable the Opalmembership Welcome screen every time Opalmembership is activated and/or updated. You can always access the Welcome Screen <a href="%s">here</a> if you want in the future.', 'opalmembership' ), esc_url( admin_url( 'index.php?page=opalmembership-about' ) ) ),
							'id'   => 'disable_welcome',
							'type' => 'checkbox'
						),
						array(
							'name' => __( 'Post Types', 'opalmembership' ),
							'desc' => '<hr>',
							'id'   => 'opalmembership_title_display_settings_2',
							'type' => 'opalmembership_title'
						),
						array(
							'name' => __( 'Disable Form Single Views', 'opalmembership' ),
							'desc' => __( 'By default, all forms have single views enabled which create a specific URL on your website for that form. This option disables the singular and archive views from being publicly viewable. Note: you will need to embed forms using a shortcode or widget if enabled.', 'opalmembership' ),
							'id'   => 'disable_forms_singular',
							'type' => 'checkbox'
						),
						array(
							'name' => __( 'Disable Form Archives', 'opalmembership' ),
							'desc' => __( 'Archives pages list all the forms you have created. This option will disable only the form\'s archive page(s). The single form\'s view will remain in place. Note: you will need to refresh your permalinks after this option has been enabled.', 'opalmembership' ),
							'id'   => 'disable_forms_archives',
							'type' => 'checkbox'
						),
						array(
							'name' => __( 'Disable Form Excerpts', 'opalmembership' ),
							'desc' => __( 'The excerpt is an optional summary or description of a donation form; in short, a summary as to why the user should opalmembership.', 'opalmembership' ),
							'id'   => 'disable_forms_excerpt',
							'type' => 'checkbox'
						),
						array(
							'name' => __( 'Disable Form Featured Image', 'opalmembership' ),
							'desc' => __( 'The Featured Image is an image that is chosen as the representative image for donation form. The display of this image is largely up to the theme. If you do not wish to use the featured image you can disable it using this option.', 'opalmembership' ),
							'id'   => 'disable_form_featured_img',
							'type' => 'checkbox'
						),
						array(
							'name' => __( 'Disable Single Form Sidebar', 'opalmembership' ),
							'desc' => __( 'The sidebar allows you to add additional widget to the Opalmembership single form view. If you don\'t plan on using the sidebar you may disable it with this option.', 'opalmembership' ),
							'id'   => 'disable_form_sidebar',
							'type' => 'checkbox'
						),
						array(
							'name' => __( 'Taxonomies', 'opalmembership' ),
							'desc' => '<hr>',
							'id'   => 'opalmembership_title_display_settings_3',
							'type' => 'opalmembership_title'
						),
						array(
							'name' => __( 'Enable Form Categories', 'opalmembership' ),
							'desc' => __( 'Check this option if you would like to categorize your donation forms. This option enables the form\'s category taxonomy.', 'opalmembership' ),
							'id'   => 'enable_categories',
							'type' => 'checkbox'
						),
						array(
							'name' => __( 'Enable Form Tags', 'opalmembership' ),
							'desc' => __( 'Check this option if you would like to tag your donation forms. This option enables the form\'s tag taxonomy.', 'opalmembership' ),
							'id'   => 'enable_tags',
							'type' => 'checkbox'
						),
					)
				)

			),
			/**
			 * Emails Options
			 */
			'emails'      => array(
				'id'         => 'options_page',
				'title' => __( 'Opalticket Email Settings', 'opalmembership' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key ) ),
				'fields'     => apply_filters( 'opalmembership_settings_emails', array(
						array(
							'name' => __( 'Email Settings', 'opalmembership' ),
							'desc' => '<hr>',
							'id'   => 'opalmembership_title_email_settings_1',
							'type' => 'title'
						),
						array(
							'id'      => 'from_name',
							'name'    => __( 'From Name', 'opalmembership' ),
							'desc'    => __( 'The name donation receipts are said to come from. This should probably be your site or shop name.', 'opalmembership' ),
							'default' => get_bloginfo( 'name' ),
							'type'    => 'text'
						),
						array(
							'id'      => 'from_email',
							'name'    => __( 'From Email', 'opalmembership' ),
							'desc'    => __( 'Email to send donation receipts from. This will act as the "from" and "reply-to" address.', 'opalmembership' ),
							'default' => get_bloginfo( 'admin_email' ),
							'type'    => 'text'
						),
						array(
							'id'      => 'mail_message_success',
							'name'    => __( 'Success Message', 'opalmembership' ),
							'type'    => 'textarea_small',
							'desc'	=> __( 'Enter the message to display when a payment request is made.', 'opalmembership' ),
							'default' => trim(preg_replace('/\t+/', '','
								Thanks, your payment request is waiting to be confirmed. Updates will be sent to the email address you provided.'))
						),
						array(
							'name' => __( 'Email Templates (Template Tags)', 'opalmembership' ),
							'desc' => $list_tags.'<br><hr>',
							'id'   => 'opalmembership_title_email_settings_2',
							'type' => 'title'
						),
						array(
							'name' => __( 'Notification For Membership Expired', 'opalmembership' ),
							'desc' => '<hr>',
							'id'   => 'opalmembership_title_email_settings_3',
							'type' => 'title'
						),
					
						array(
							'id'      			=> 'expired_email_subject',
							'name'    			=> __( 'Email Subject', 'opalmembership' ),
							'type'    			=> 'text',
							'desc'				=> __( 'The email subject for admin notifications.', 'opalmembership' ),
							'attributes'  		=> array(
		        										'placeholder' 		=> 'Your package is expired',
		        										'rows'       	 	=> 3,
		    										),
							'default'			=> __( 'Your membership is expired', 'opalmembership' )	

						),
						array(
							'id'      => 'expired_email_body',
							'name'    => __( 'Email Body', 'opalmembership' ),
							'type'    => 'wysiwyg',
							'desc'	=> __( 'Enter the email an admin should receive when an initial payment request is made.', 'opalmembership' ),
							'default' => opalmembership_default_expired_email_body(),
						),	
						//------------------------------------------
						array(
							'name' => __( 'New Payment - New Membership Purchase', 'opalmembership' ),
							'desc' => '<hr>',
							'id'   => 'opalmembership_title_email_settings_4',
							'type' => 'title'
						),
						array(
							'id'      		=> 'newpayment_email_subject',
							'name'    		=> __( 'Email Subject', 'opalmembership' ),
							'type'    		=> 'text',
							'desc'			=> __( 'The email subject a user should receive when they make an initial booking request.', 'opalmembership' ),
							'attributes'  	=> array(
		        									'placeholder' 		=> __('New membership package purchased - Payment {payment_number}','opalmembership'),
		        									'rows'       	 	=> 3,
		    									),
							'default'	=> __('New membership package purchased - Payment {payment_number}','opalmembership')
						),
						array(
							'id'      	=> 'newpayment_email_body',
							'name'    	=> __( 'Email Body', 'opalmembership' ),
							'type'    	=> 'wysiwyg',
							'desc'		=> __( 'Enter the email a user should receive when they make an initial payment request.', 'opalmembership' ),
							'default' 	=> opalmembership_default_newpayment_email_body()


						),
						//=======================================
						array(
							'name' => __( 'Membership Confirmed  - Actived Membership', 'opalmembership' ),
							'desc' => '<hr>',
							'id'   => 'opalmembership_title_email_settings_5',
							'type' => 'title'
						),
						
						array(
							'id'      		=> 'confirmed_email_subject',
							'name'   		=> __( 'Email Subject', 'opalmembership' ),
							'type'    		=> 'text',
							'default' 		=> __('Your Payment - ID {payment_number} is Confirmed', 'opalmembership' ),
							'desc'			=> __( 'The email subject a user should receive when their booking has been confirmed.', 'opalmembership' ),
							'attributes'  	=> array(
		        									'placeholder' 		=> __('Your Payment - ID {payment_number} is Confirmed' , 'opalmembership' ),
		        									'rows'       	 	=> 3,
		    									)
						),
						array(
							'id'      => 'confirmed_email_body',
							'name'    => __( 'Email Body', 'opalmembership' ),
							'type'    => 'wysiwyg',
							'desc'	=> __( 'Enter the email a user should receive when their booking has been confirmed.', 'opalmembership' ),
							'default' => opalmembership_default_confirmed_email_body()
						),
						//-----------------------------------------------
						array(
							'name' => __( 'Membership canceled', 'opalmembership' ),
							'desc' => '<hr>',
							'id'   => 'opalmembership_title_email_settings_6',
							'type' => 'title'
						),
						
						array(
							'id'      		=> 'cancelled_email_subject',
							'name'    		=> __( 'Email Subject', 'opalmembership' ),
							'type'    		=> 'text',
							'desc'			=> __( 'The email subject a user should receive when their booking has been rejected.', 'opalmembership' ),
							'attributes'  	=> array(
		        									'placeholder' 		=> 'Membership Cancelled on {site_name}',
		        									'rows'       	 	=> 3,
		    									),
							'default'		=> __('Membership Cancelled on {site_name}','opalmembership')
						),
						array(
							'id'      => 'cancelled_email_body',
							'name'    => __( 'Email Body', 'opalmembership' ),
							'type'    => 'wysiwyg',
							'desc'	=> __( 'Enter the email a user should receive when their booking has been rejected.', 'opalmembership' ),
							'default' => opalmembership_default_cancelled_email_body()
						),
						//-----------------------------------------------
						array(
							'name' => __( 'Membership Refunded', 'opalmembership' ),
							'desc' => '<hr>',
							'id'   => 'opalmembership_title_email_settings_7',
							'type' => 'title'
						),
						
						array(
							'id'      		=> 'refunded_email_subject',
							'name'    		=> __( 'Email Subject', 'opalmembership' ),
							'type'    		=> 'text',
							'desc'			=> __( 'The email subject a user should receive when their booking has been rejected.', 'opalmembership' ),
							'attributes'  	=> array(
		        									'placeholder' 		=> 'Membership Refunded on {site_name}',
		        									'rows'       	 	=> 3,
		    									),
							'default'		=> __('Membership Refunded on {site_name}','opalmembership')
						),
						array(
							'id'      => 'refunded_email_body',
							'name'    => __( 'Email Body', 'opalmembership' ),
							'type'    => 'wysiwyg',
							'desc'	=> __( 'Enter the email a user should receive when their booking has been refunded.', 'opalmembership' ),
							'default' => opalmembership_default_refunded_email_body()
						),
					)
				)
			),// end mail
			/** Extension Settings */
			'addons'      => array(
				'id'         => 'options_page',
				'opalmembership_title' => __( 'Opalmembership Add-ons Settings', 'opalmembership' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
				'fields'     => apply_filters( 'opalmembership_settings_addons', array() )
			),
			/** Licenses Settings */
			'licenses'    => array(
				'id'         => 'options_page',
				'opalmembership_title' => __( 'Opalmembership Licenses', 'opalmembership' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
				'fields'     => apply_filters( 'opalmembership_settings_licenses', array()
				)
			),
			/** Advanced Options */
			'advanced'    => array(
				'id'         => 'options_page',
				'opalmembership_title' => __( 'Advanced Options', 'opalmembership' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
				'fields'     => apply_filters( 'opalmembership_settings_advanced', array(
						array(
							'name' => __( 'Session Control', 'opalmembership' ),
							'desc' => '<hr>',
							'id'   => 'opalmembership_title_session_control_1',
							'type' => 'opalmembership_title'
						),
						array(
							'id'      => 'session_lifetime',
							'name'    => __( 'Session Lifetime', 'opalmembership' ),
							'desc'    => __( 'Opalmembership will start a new session per user once they have donated. This option controls the lifetime a user\'s session is kept alive. An active session allows users to view donation receipts on your site without having to be logged in.', 'opalmembership' ),
							'type'    => 'select',
							'options' => array(
								'86400'  => __( '24 Hours', 'opalmembership' ),
								'172800' => __( '48 Hours', 'opalmembership' ),
								'259200' => __( '72 Hours', 'opalmembership' ),
								'604800' => __( '1 Week', 'opalmembership' ),
							)
						),
						array(
							'name' => __( 'Data Control', 'opalmembership' ),
							'desc' => '<hr>',
							'id'   => 'opalmembership_title_data_control_2',
							'type' => 'opalmembership_title'
						),
						array(
							'name' => __( 'Remove All Data on Uninstall?', 'opalmembership' ),
							'desc' => __( 'Check this box if you would like Opalmembership to completely remove all of its data when the plugin is deleted.', 'opalmembership' ),
							'id'   => 'uninstall_on_delete',
							'type' => 'checkbox'
						),
						array(
							'name' => __( 'Filter Control', 'opalmembership' ),
							'desc' => '<hr>',
							'id'   => 'opalmembership_title_filter_control',
							'type' => 'opalmembership_title'
						),
						array(
							'name' => __( 'Disable <code>the_content</code> filter', 'opalmembership' ),
							'desc' => sprintf( __( 'If you are seeing extra social buttons, related posts, or other unwanted elements appearing within your forms then you can disable WordPress\' content filter. <a href="%s" target="_blank">Learn more</a> about the_content filter.', 'opalmembership' ), esc_url( 'https://codex.wordpress.org/Plugin_API/Filter_Reference/the_content' ) ),
							'id'   => 'disable_the_content_filter',
							'type' => 'checkbox'
						),
						array(
							'name' => __( 'Script Loading', 'opalmembership' ),
							'desc' => '<hr>',
							'id'   => 'opalmembership_title_script_control',
							'type' => 'opalmembership_title'
						),
						array(
							'name' => __( 'Load Scripts in Footer?', 'opalmembership' ),
							'desc' => __( 'Check this box if you would like Opalmembership to load all frontend JavaScript files in the footer.', 'opalmembership' ),
							'id'   => 'scripts_footer',
							'type' => 'checkbox'
						)
					)
				)
			),
			/** API Settings */
			'api'         => array(
				'id'         => 'options_page',
				'opalmembership_title' => __( 'API', 'opalmembership' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
				'show_names' => false, // Hide field names on the left
				'fields'     => apply_filters( 'opalmembership_settings_system', array(
						array(
							'id'   => 'api',
							'name' => __( 'API', 'opalmembership' ),
							'type' => 'api'
						)
					)
				)
			),
			/** Licenses Settings */
			'system_info' => array(
				'id'         => 'options_page',
				'opalmembership_title' => __( 'System Info', 'opalmembership' ),
				'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
				'fields'     => apply_filters( 'opalmembership_settings_system', array(
						array(
							'id'   => 'system_info',
							'name' => __( 'System Info', 'opalmembership' ),
							'desc' => __( 'Please copy and paste this information in your ticket when contacting support.', 'opalmembership' ),
							'type' => 'system_info'
						)
					)
				)
			),
		);

		//Return all settings array if necessary
		if ( $active_tab === null || ! isset( $opalmembership_settings[ $active_tab ] ) ) {
			return apply_filters( 'opalmembership_registered_settings', $opalmembership_settings );
		}

		// Add other tabs and settings fields as needed
		return apply_filters( 'opalmembership_registered_settings', $opalmembership_settings[ $active_tab ] );

	}

	/**
	 * Show Settings Notices
	 *
	 * @param $object_id
	 * @param $updated
	 * @param $cmb
	 */
	public function settings_notices( $object_id, $updated, $cmb ) {

		//Sanity check
		if ( $object_id !== $this->key ) {
			return;
		}

		if ( did_action( 'cmb2_save_options-page_fields' ) === 1 ) {
			settings_errors( 'opalmembership-notices' );
		}

		add_settings_error( 'opalmembership-notices', 'global-settings-updated', __( 'Settings updated.', 'opalmembership' ), 'updated' );

	}


	/**
	 * Public getter method for retrieving protected/private variables
	 *
	 * @since  1.0
	 *
	 * @param  string $field Field to retrieve
	 *
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {

		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'fields', 'opalmembership_title', 'options_page' ), true ) ) {
			return $this->{$field};
		}
		if ( 'option_metabox' === $field ) {
			return $this->option_metabox();
		}

		throw new Exception( 'Invalid property: ' . $field );
	}


}

// Get it started
$Opalmembership_Settings = new Opalmembership_Plugin_Settings();

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 *
 * @param  string $key Options array key
 *
 * @return mixed        Option value
 */
function opalmembership_get_option( $key = '', $default = false ) {
	global $opalmembership_options;
	$value = ! empty( $opalmembership_options[ $key ] ) ? $opalmembership_options[ $key ] : $default;
	$value = apply_filters( 'opalmembership_get_option', $value, $key, $default );

	return apply_filters( 'opalmembership_get_option_' . $key, $value, $key, $default );
}


/**
 * Update an option
 *
 * Updates an opalmembership setting value in both the db and the global variable.
 * Warning: Passing in an empty, false or null string value will remove
 *          the key from the opalmembership_options array.
 *
 * @since 1.0
 *
 * @param string          $key   The Key to update
 * @param string|bool|int $value The value to set the key to
 *
 * @return boolean True if updated, false if not.
 */
function opalmembership_update_option( $key = '', $value = false ) {

	// If no key, exit
	if ( empty( $key ) ) {
		return false;
	}

	if ( empty( $value ) ) {
		$remove_option = opalmembership_delete_option( $key );

		return $remove_option;
	}

	// First let's grab the current settings
	$options = get_option( 'opalmembership_settings' );

	// Let's let devs alter that value coming in
	$value = apply_filters( 'opalmembership_update_option', $value, $key );

	// Next let's try to update the value
	$options[ $key ] = $value;
	$did_update      = update_option( 'opalmembership_settings', $options );

	// If it updated, let's update the global variable
	if ( $did_update ) {
		global $opalmembership_options;
		$opalmembership_options[ $key ] = $value;
	}

	return $did_update;
}

/**
 * Remove an option
 *
 * Removes an opalmembership setting value in both the db and the global variable.
 *
 * @since 1.0
 *
 * @param string $key The Key to delete
 *
 * @return boolean True if updated, false if not.
 */
function opalmembership_delete_option( $key = '' ) {

	// If no key, exit
	if ( empty( $key ) ) {
		return false;
	}

	// First let's grab the current settings
	$options = get_option( 'opalmembership_settings' );

	// Next let's try to update the value
	if ( isset( $options[ $key ] ) ) {

		unset( $options[ $key ] );

	}

	$did_update = update_option( 'opalmembership_settings', $options );

	// If it updated, let's update the global variable
	if ( $did_update ) {
		global $opalmembership_options;
		$opalmembership_options = $options;
	}

	return $did_update;
}


/**
 * Get Settings
 *
 * Retrieves all Opalmembership plugin settings
 *
 * @since 1.0
 * @return array Opalmembership settings
 */
function opalmembership_get_settings() {

	$settings = get_option( 'opalmembership_settings' );

	return (array) apply_filters( 'opalmembership_get_settings', $settings );

}

/**
 * Gateways Callback
 *
 * Renders gateways fields.
 *
 * @since 1.0
 *
 * @global $opalmembership_options Array of all the Opalmembership Options
 * @return void
 */
function opalmembership_enabled_gateways_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

	$id                = $field_type_object->field->args['id'];
	$field_description = $field_type_object->field->args['desc'];
	$gateways          = opalmembership_get_payment_gateways();

	echo '<ul class="cmb2-checkbox-list cmb2-list">';

	foreach ( $gateways as $key => $option ) :

		if ( is_array( $escaped_value ) && array_key_exists( $key, $escaped_value ) ) {
			$enabled = '1';
		} else {
			$enabled = null;
		}

		echo '<li><input name="' . $id . '[' . $key . ']" id="' . $id . '[' . $key . ']" type="checkbox" value="1" ' . checked( '1', $enabled, false ) . '/>&nbsp;';
		echo '<label for="' . $id . '[' . $key . ']">' . $option['admin_label'] . '</label></li>';

	endforeach;

	if ( $field_description ) {
		echo '<p class="cmb2-metabox-description">' . $field_description . '</p>';
	}

	echo '</ul>';


}

/**
 * Gateways Callback (drop down)
 *
 * Renders gateways select menu
 *
 * @since 1.0
 *
 * @param $field_object , $escaped_value, $object_id, $object_type, $field_type_object Arguments passed by CMB2
 *
 * @return void
 */
function opalmembership_default_gateway_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

	$id                = $field_type_object->field->args['id'];
	$field_description = $field_type_object->field->args['desc'];
	$gateways          = opalmembership_get_enabled_payment_gateways();

	echo '<select class="cmb2_select" name="' . $id . '" id="' . $id . '">';

	//Add a field to the Opalmembership Form admin single post view of this field
	if ( $field_type_object->field->object_type === 'post' ) {
		echo '<option value="global">' . __( 'Global Default', 'opalmembership' ) . '</option>';
	}

	foreach ( $gateways as $key => $option ) :

		$selected = isset( $escaped_value ) ? selected( $key, $escaped_value, false ) : '';


		echo '<option value="' . esc_attr( $key ) . '"' . $selected . '>' . esc_html( $option['admin_label'] ) . '</option>';

	endforeach;

	echo '</select>';

	echo '<p class="cmb2-metabox-description">' . $field_description . '</p>';

}

/**
 * Opalmembership Title
 *
 * Renders custom section titles output; Really only an <hr> because CMB2's output is a bit funky
 *
 * @since 1.0
 *
 * @param       $field_object , $escaped_value, $object_id, $object_type, $field_type_object
 *
 * @return void
 */
function opalmembership_title_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

	$id                = $field_type_object->field->args['id'];
	$title             = $field_type_object->field->args['name'];
	$field_description = $field_type_object->field->args['desc'];

	echo '<hr>';

}

/**
 * Gets a number of posts and displays them as options
 *
 * @param  array $query_args Optional. Overrides defaults.
 * @param  bool  $force      Force the pages to be loaded even if not on settings
 *
 * @see: https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-field-types
 * @return array An array of options that matches the CMB2 options array
 */
function opalmembership_cmb2_get_post_options( $query_args, $force = false ) {

	$post_options = array( '' => '' ); // Blank option

	if ( ( ! isset( $_GET['page'] ) || 'opalmembership-settings' != $_GET['page'] ) && ! $force ) {
		return $post_options;
	}

	$args = wp_parse_args( $query_args, array(
		'post_type'   => 'page',
		'numberposts' => 10,
	) );

	$posts = get_posts( $args );

	if ( $posts ) {
		foreach ( $posts as $post ) {

			$post_options[ $post->ID ] = $post->post_title;

		}
	}

	return $post_options;
}


/**
 * Modify CMB2 Default Form Output
 *
 * @param string @args
 *
 * @since 1.0
 */

add_filter( 'cmb2_get_metabox_form_format', 'opalmembership_modify_cmb2_form_output', 10, 3 );

function opalmembership_modify_cmb2_form_output( $form_format, $object_id, $cmb ) {

	//only modify the opalmembership settings form
	if ( 'opalmembership_settings' == $object_id && 'options_page' == $cmb->cmb_id ) {

		return '<form class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"><input type="hidden" name="object_id" value="%2$s">%3$s<div class="opalmembership-submit-wrap"><input type="submit" name="submit-cmb" value="' . __( 'Save Settings', 'opalmembership' ) . '" class="button-primary"></div></form>';
	}

	return $form_format;

}


/**
 * Opalmembership License Key Callback
 *
 * @description Registers the license field callback for EDD's Software Licensing
 * @since       1.0
 *
 * @param array $field_object , $escaped_value, $object_id, $object_type, $field_type_object Arguments passed by CMB2
 *
 * @return void
 */
if ( ! function_exists( 'opalmembership_license_key_callback' ) ) {
	function opalmembership_license_key_callback( $field_object, $escaped_value, $object_id, $object_type, $field_type_object ) {

		$id                = $field_type_object->field->args['id'];
		$field_description = $field_type_object->field->args['desc'];
		$license_status    = get_option( $field_type_object->field->args['options']['is_valid_license_option'] );
		$field_classes     = 'regular-text opalmembership-license-field';
		$type              = empty( $escaped_value ) ? 'text' : 'password';

		if ( $license_status === 'valid' ) {
			$field_classes .= ' opalmembership-license-active';
		}

		$html = $field_type_object->input( array(
			'class' => $field_classes,
			'type'  => $type
		) );

		//License is active so show deactivate button
		if ( $license_status === 'valid' ) {
			$html .= '<input type="submit" class="button-secondary opalmembership-license-deactivate" name="' . $id . '_deactivate" value="' . __( 'Deactivate License', 'opalmembership' ) . '"/>';
		} else {
			//This license is not valid so delete it
			opalmembership_delete_option( $id );
		}

		$html .= '<label for="opalmembership_settings[' . $id . ']"> ' . $field_description . '</label>';

		wp_nonce_field( $id . '-nonce', $id . '-nonce' );

		echo $html;
	}
}


/**
 * Display the API Keys
 *
 * @since       2.0
 * @return      void
 */
function opalmembership_api_callback() {

	if ( ! current_user_can( 'manage_opalmembership_settings' ) ) {
		return;
	}

	do_action( 'opalmembership_tools_api_keys_before' );

	require_once OPALMEMBERSHIP_PLUGIN_DIR . 'inc/admin/class-api-keys-table.php';

	$api_keys_table = new Opalmembership_API_Keys_Table();
	$api_keys_table->prepare_items();
	$api_keys_table->display();
	?>
	<p>
		<?php printf(
			__( 'API keys allow users to use the <a href="%s">Opalmembership REST API</a> to retrieve donation data in JSON or XML for external applications or devices, such as <a href="%s">Zapier</a>.', 'opalmembership' ),
			'https://opalmembershipwp.com/documentation/opalmembership-api-reference/',
			'https://opalmembershipwp.com/addons/zapier/'
		); ?>
	</p>

	<style>
		.opalmembership_properties_page_opalmembership-settings .opalmembership-submit-wrap {
			display: none; /* Hide Save settings button on System Info Tab (not needed) */
		}
	</style>
	<?php

	do_action( 'opalmembership_tools_api_keys_after' );
}

// add_action( 'opalmembership_settings_tab_api_keys', 'opalmembership_api_callback' );

/**
 * Hook Callback
 *
 * Adds a do_action() hook in place of the field
 *
 * @since 1.0
 *
 * @param array $args Arguments passed by the setting
 *
 * @return void
 */
function opalmembership_hook_callback( $args ) {
	do_action( 'opalmembership_' . $args['id'] );
}
