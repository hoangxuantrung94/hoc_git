<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     WPOpal  Team <opalwordpress@gmail.com>
 * @copyright  Copyright (C) 2015 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */
wp_enqueue_script( 'prettyphoto' );
wp_enqueue_style( 'prettyphoto' );
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$_id = fullhouse_fnc_makeid();
$_count = 0;
$args = array(
	'post_type' => 'gallery',
	'posts_per_page' => $number,
	'post_status' => 'publish',
);
$query = new WP_Query($args);
?>
<div class="widget pbr-gallery <?php echo esc_attr($el_class); ?>">
	<?php if($query->have_posts()){ ?>
		<?php if($title!=''){ ?>
			<h3 class="widget-title">
				<span><?php echo trim($title); ?></span>
			</h3>
		<?php } ?>
 		<div class="widget-content">		
			<?php $_count=0; while($query->have_posts()):$query->the_post(); $_count++; global $post; ?>
			<?php 
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			?>	
				<?php if($_count % $columns == 1) echo '<div class="row space-30">'; ?>
					<div class="item col-sm-<?php echo floor(12/$columns) ?> col-xs-12">
						<div class="image">
							<?php the_post_thumbnail('thumbnail'); ?>
							<div class="mask"><a class="prettyphoto hidden-xs" rel="prettyPhoto[rel-gallery]" href="<?php echo esc_url_raw($image[0]); ?>"><i class="fa fa-search"></i></a></div>
						</div>
					</div>
				<?php if($_count % $columns == 0 || $_count == $query->found_posts) echo '</div>'; ?>
			<?php endwhile; ?>
		</div>	
	<?php } ?>
</div>
<?php wp_reset_postdata(); ?>