<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WpOpal
 * @subpackage fullhouse
 * @since fullhouse 1.0
 */
$footer_profile =  apply_filters( 'fullhouse_fnc_get_footer_profile', 'default' ); 
?>

		</section><!-- #main -->
		<?php do_action( 'fullhouse_template_main_after' ); ?>
		
		<div class="footer-wrapper">
			
			<?php get_template_part( 'page-templates/parts/footer-bg' ); ?>
					
			<footer id="pbr-footer" class="pbr-footer" role="contentinfo">
				<?php if( $footer_profile ) : ?>
				<div class="inner">
					<div class="pbr-footer-profile">
						<?php fullhouse_fnc_render_post_content( $footer_profile ); ?>
					</div>
				</div>
				<?php else: ?>
				<div class="inner">
					<?php get_sidebar( 'footer' ); ?>
				</div>
				<?php endif; ?>
					
			</footer><!-- #colophon -->
			<div class="pbr-copyright">
				<div class="container">
					<a href="#" class="scrollup"><span class="fa fa-angle-up"></span></a>
					<div class="site-info">
						<?php do_action( 'fullhouse_fnc_credits' ); ?>
						<a href="<?php echo esc_url( esc_html__( 'https://wordpress.org/', 'fullhouse' ) ); ?>"><?php printf( esc_html__( 'Copyright &copy; 2016 - Fullhouse - All rights reserved. Powered by %s', 'fullhouse' ), 'WordPress' ); ?></a>
					</div><!-- .site-info -->
				</div>	
			</div>

		</div>
		<!-- .footer-wrapper -->
		
	
		<?php do_action( 'fullhouse_template_footer_after' ); ?>
		<?php get_sidebar( 'offcanvas' );  ?>
	</div>
</div>
	<!-- #page -->

<?php wp_footer(); ?>
</body>
</html>