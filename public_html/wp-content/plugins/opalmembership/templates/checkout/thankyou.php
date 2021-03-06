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

if ( $payment ) : ?>

	<?php if ( $payment->has_status( 'failed' ) ) : ?>

		<p class="opalmembership-notice opalmembership-notice-error"><?php _e( 'Unfortunately your payment cannot be processed as the originating bank/merchant has declined your transaction.', 'opalmembership' ); ?></p>

		<p><?php
			if ( is_user_logged_in() )
				_e( 'Please attempt your purchase again or go to your account page.', 'opalmembership' );
			else
				_e( 'Please attempt your purchase again.', 'opalmembership' );
		?></p>

		<p>
			<a href="<?php echo esc_url( $payment->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'opalmembership' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My Account', 'opalmembership' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>

		<p class="opalmembership-notice opalmembership-notice-success"><?php echo apply_filters( 'opalmembership_thankyou_payment_received_text', __( 'Thank you. Your payment has been received.', 'opalmembership' ), $payment ); ?></p>

		<ul class="payment_details">
			<li class="payment">
				<?php _e( 'Payment Number:', 'opalmembership' ); ?>
				<strong><?php echo $payment->get_payment_number(); ?></strong>
			</li>
			<li class="date">
				<?php _e( 'Date:', 'opalmembership' ); ?>
				<strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $payment->payment_date ) ); ?></strong>
			</li>
			<li class="total">
				<?php _e( 'Total:', 'opalmembership' ); ?>
				<strong><?php echo $payment->get_formatted_payment_total(); ?></strong>
			</li>
			<?php if ( $gateway = $payment->get_gateway() ) : ?>
			<li class="method">
				<?php _e( 'Payment Method:', 'opalmembership' ); ?>
				<strong><?php echo opalmembership_get_gateways_by_key( $gateway ); ?></strong>
			</li>
			<?php endif; ?>
		</ul>
		<div class="clear"></div>

	<?php endif; ?>

	<?php do_action( 'opalmembership_thankyou_' . $payment->get_gateway() , $payment->id ); ?>
	<?php do_action( 'opalmembership_thankyou', $payment->id ); ?>

<?php else : ?>

	<p class="opalmembership-notice opalmembership-notice-success"><?php echo apply_filters( 'opalmembership_thankyou_payment_received_text', __( 'Thank you. Your payment has been received.', 'opalmembership' ), null ); ?></p>

<?php endif; ?>
