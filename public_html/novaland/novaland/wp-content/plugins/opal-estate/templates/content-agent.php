<?php global $property, $post; 
	$property = opalesetate_property( get_the_ID() );

// 	echo '<Pre>'.print_r( $property ,1 );die; 
	$args = array( 'post_id' => get_the_ID() );
?> 
<article itemscope itemtype="https://schema.org/RealEstateAgent" <?php post_class(); ?>>
	
	<header>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>	
	
	<div class="agent-box">
		<div class="<?php echo apply_filters('opalestate_row_container_class', 'row opal-row');?>">
			<div class="col-lg-6"> <?php echo Opalestate_Template_Loader::get_template_part( 'single-agent/box' ); ?> </div>
			<div class="col-lg-6"> <?php echo Opalestate_Template_Loader::get_template_part( 'single-agent/form', $args ); ?> </div>
		</div>
	</div> 	
	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s', 'opalestate' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'opalestate' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
 
	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</article><!-- #post-## -->
