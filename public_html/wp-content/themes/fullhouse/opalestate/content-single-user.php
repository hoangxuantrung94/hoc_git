<?php global $property, $post; 
 
	$args = array( 'post_id' => get_the_ID() );
?> 
<article id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/RealEstateAgent" <?php post_class(); ?>>
	
	<header class="hide">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>  
	
	<div class="agent-box">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6"> <?php echo Opalestate_Template_Loader::get_template_part( 'single-agent/box' ); ?> </div>
			<div class="col-lg-6 col-md-6 col-sm-6"> <?php echo Opalestate_Template_Loader::get_template_part( 'single-agent/form', $args ); ?> </div>
		</div>
	</div> 	
	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s', 'fullhouse' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'fullhouse' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
 
	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</article><!-- #post-## -->
<?php do_action( 'opalestate_single_content_agent_after' ); ?>