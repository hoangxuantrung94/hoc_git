<?php 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if( $limit < $column){
	$limit = $column;
}
if( class_exists("Opalestate_Query") ):

	if(is_front_page()){
	    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
	}
	else{
	    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	}
	$query = Opalestate_Query::get_agents( array("posts_per_page"=>$limit, 'paged' => $paged), $onlyfeatured );

	$colclass = !empty($column) ? 12/$column : 4;
?>
<div class="widget widget-estate-property">
	<?php if(!empty($title)){ ?>
		<h4 class="widget-title text-center">
			<span><?php echo trim($title); ?></span>
			<?php if(trim($description)!=''){ ?>
	            <span class="widget-desc">
	                <?php echo trim($description); ?>
	            </span>
	        <?php } ?>
		</h4>
	<?php } ?>
	
	<div class="widget-content">
		<div class="opalesate-recent-property opalestate-rows">
			<?php if( $query->have_posts() ): ?> 
				<div class="row">
					<?php $cnt=0; while ( $query->have_posts() ) : $query->the_post(); 
						$cls = '';
						if( $cnt++%$column==0 ){
							$cls .= ' first-child';
						}
					?>
					<div class="col-lg-<?php echo esc_attr($colclass); ?> col-md-<?php echo esc_attr($colclass); ?> col-sm-6 <?php echo esc_attr($cls); ?>">
	                	<?php echo Opalestate_Template_Loader::get_template_part( 'content-agent-list' ); ?>
	            	</div>
					<?php   endwhile; ?>
				</div>
				<?php if( isset($pagination) && $pagination ): ?>
					<div class="w-pagination"><?php fullhouse_fnc_pagination_nav( $limit, $query->found_posts,$query->max_num_pages ); ?></div>
				<?php endif; ?> 
			<?php else: ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>	
		</div>
	</div>	
</div>	
<?php endif; ?>
<?php wp_reset_query(); ?>