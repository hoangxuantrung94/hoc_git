<?php
$columns = fullhouse_fnc_theme_options( 'blog-archive-column', 1 );
if ( 1 == $columns ) {
	// Start the Loop.
	while ( have_posts() ) { the_post();
		/*
		 * Include the post format-specific template for the content. If you want to
		 * use this in a child theme, then include a file called called content-___.php
		 * (where ___ is the post format) and that will be used instead.
		 */
		get_template_part( 'content', get_post_format() );
	} // endwhile
} else {
	global $wp_query;
	$bscol = floor( 12 / $columns );
	$index = 1;
	?>
	<section class="pbr-grid-posts layout-grid-1">
		<div class="post-item">
			<div class="row">
				<?php
				// Start the Loop.
				while ( have_posts() ) { the_post(); ?>

					<div class="col-sm-<?php echo esc_attr($bscol); ?>">
						<?php get_template_part( 'content', get_post_format() ); ?>
					</div>

					<?php if ( ( $index % $columns == 0 ) && 
							   ( $index != $wp_query->post_count ) ) { ?>
							</div><!-- .row -->
						</div><!-- .post-item -->
						<div class="post-item">
							<div class="row">
					<?php } // endif

					$index++; // increase index by 1
				} // endwhile
				?>
			</div> <!-- .row -->
		</div> <!-- .post-item -->
	</section>
<?php
} // endif
