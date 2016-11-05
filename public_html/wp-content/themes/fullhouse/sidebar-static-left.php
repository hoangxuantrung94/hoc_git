<div class="sidebar-static-left scroll">

	<div class="staticbar-action"></div>
	<div class="inner">
		

		<?php if ( is_active_sidebar( 'static-sidebar-left' ) ) : ?>
		<div id="static-left-top" class="sidebar-container clearfix" role="complementary">
			<div class="sidebar-inner">
				<div class="widget-area">
					<?php dynamic_sidebar( 'static-sidebar-left' ); ?>
				</div><!-- .widget-area -->
			</div><!-- .sidebar-inner -->
		</div><!-- #tertiary -->

	<?php else : ?>
	<?php esc_html_e( 'Please drag and drop widget on this position Static Left', 'fullhouse' ); ?>	
	<?php endif; ?>
	</div>
</div>	