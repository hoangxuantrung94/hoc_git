<?php
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    $package$
 * @author     Opal  Team <info@wpopal.com >
 * @copyright  Copyright (C) 2014 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/support/forum.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $current_user;

wp_get_current_user();
$user_id = $current_user->ID;

$package_activation = get_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_activation', true );
$package_id = (int)get_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_id', true );
$payment_id = (int)get_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'payment_id', true );
$package_expired = get_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_expired', true );
$package_expired  = date( 'Y-m-d H:i:s', strtotime($package_expired) ); 
 
if( $package_id ) :
	$package = opalmembership_package( $package_id );
	$payment =  opalmembership_payment( $payment_id );

	$package_activation = date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $package_activation  ) );
	$package_expired = date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $package_expired  ) );

	if( $package ): ?>
	<div class="panel panel-default"><div class="panel-body">
		<h3><?php _e( 'Lastest Payment', 'opalmembership' ) ; ?></h3>
		<ul>
			<li><span><?php _e( 'Payment ID', 'opalmembership' );?></span>: <a href="<?php echo esc_url( opalmembership_get_payment_history_detail_page_uri( $payment->id )); ?>">
				<?php echo $payment->get_payment_number(); ?></a> </li>
			<li><span><?php _e( 'Purchased Date', 'opalmembership' );?></span>: <?php echo $payment->payment_date; ?></li>
			<li><span><?php _e( 'Total', 'opalmembership' );?></span>: <?php echo $payment->get_formatted_payment_total(); ?></li>
			<li><span><?php _e( 'Status', 'opalmembership' );?></span>: <?php echo $payment->get_status_name(); ?></li>	
		</ul>
		<p><a href="<?php echo esc_url( opalmembership_get_payment_history_page_uri() ); ?>" class="btn btn-link"><?php _e('View more payments', 'opalmembership' );?></a></p>
	</div>	</div>

	<div class="panel panel-default"><div class="panel-body">
		<h3><?php _e( 'Current Package', 'opalmembership') ; ?></h3>
		<div class="membership-content">
			<ul>
				<li><span><?php _e( 'Membership', 'opalmembership' );?></span>: <?php echo esc_html( $package->post_title ); ?> </li>
				<li><span><?php _e( 'Activion Date', 'opalmembership' );?></span>: <?php echo esc_html( $package_activation ); ?></li>
				<li><span><?php _e( 'Expired On', 'opalmembership' );?></span>: <?php echo esc_html( $package_expired ); ?></li>
				<?php do_action( 'opalmembership_current_package_summary_after', $package_id, $payment_id ); ?>
			</ul>
		</div>
		<p>
			<?php _e( 'Would you like to upgrade your membership?', 'opalmembership' );?>
			<a href="<?php echo opalmembership_get_membership_page_uri();?>"><?php _e( 'Please, Click to this link to see plans', 'opalmembership' );?></a>
		</p>
	</div>	</div>
	<?php endif; ?>
<?php else : ?>

<div class="alert alert-warning">
	<p><?php _e( 'You have not purchased any package now.', 'opalmembership' ); ?></p>
	<p><a href="<?php echo opalmembership_get_membership_page_uri();?>"><?php _e( 'Click to this link to see plans', 'opalmembership' );?></a></p>
</div>

<?php endif; ?>