<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     Wordpress Opal Team <opalwordpress@gmail.com, support@prestabrain.com>
 * @copyright  Copyright (C) 2015 prestabrain.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */

// Display the widget title
if ( $title ) {
    echo ($before_title)  . trim( $title ) . $after_title;
}

$args = array(
	'post_type' => 'post',
	'posts_per_page' => $number_post
);

$query = new WP_Query($args);
if($query->have_posts()):
?>
<div class="post-widget post-stick-layout widget-content">
<?php
	while($query->have_posts()):$query->the_post();
?>
	<?php if($query->current_post==0) : ?>
		<article class="item-post media item-big">
			<?php if(has_post_thumbnail()){ ?>
				<a href="<?php the_permalink(); ?>" class="image pull-left">
					<?php the_post_thumbnail( 'widget' ); ?>
				</a>
			<?php } ?>
			<div class="clearfix"></div>
			<h6 class="entry-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h6>
				<div class="clearfix"></div>
			<div class="media-body">
				<div class="entry-description"><?php the_excerpt(); ?></div>
			</div>	
			<div class="post-meta">	
				<span class="post-date">
					<i class="fa fa-clock-o hidden"></i>
					<?php the_time( 'M, d Y' ); ?>
				</span>
				<span class="post-comment hidden">
					<i class="fa fa-comments"></i>
					<?php comments_popup_link(esc_html__(' 0 comment', 'pbrthemer'), esc_html__(' 1 comment', 'pbrthemer'), esc_html__(' % comments', 'pbrthemer')); ?>
				</span>
			</div>

		</article>
	<?php else: ?>
		<article class="item-post media item-small">
			<div class="media-body">
				<h6 class="entry-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h6>
			</div>	
			<div class="post-meta">	
				<span class="post-date">
					<i class="fa fa-clock-o hidden"></i>
					<?php the_time( 'M, d Y' ); ?>
				</span>
				<span class="post-comment hidden">
					<i class="fa fa-comments"></i>
					<?php comments_popup_link(esc_html__(' 0 comment', 'pbrthemer'), esc_html__(' 1 comment', 'pbrthemer'), esc_html__(' % comments', 'pbrthemer')); ?>
				</span>
			</div>
		</article>
	<?php endif; ?>	

<?php endwhile; ?>
<?php wp_reset_postdata(); ?>
</div>
<?php endif; ?>
