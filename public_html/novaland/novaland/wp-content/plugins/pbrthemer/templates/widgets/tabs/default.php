<ul class="nav nav-tabs">
	<?php if($show_popular_posts == 'true'): ?>
		<li class="active">
			<a href="#tab-popular" data-toggle="tab"><?php esc_html_e('Popular', 'shopstars' ); ?></a>
		</li>
	<?php endif; ?>
	<?php if($show_recent_posts == 'true'): ?>
		<li <?php if($show_popular_posts != 'true') echo 'class="active"'; ?>>
			<a href="#tab-recent" data-toggle="tab"><?php esc_html_e('Recent', 'shopstars' ); ?></a>
		</li>
	<?php endif; ?>
	<?php if($show_comments == 'true'): ?>
		<li <?php if($show_popular_posts != 'true' && $show_recent_posts != 'true' ) echo 'class="active"'; ?>>
			<a href="#tab-comments" data-toggle="tab"><?php esc_html_e('Comments', 'shopstars' ); ?></a>
		</li>
	<?php endif; ?>
</ul>

<!-- Tab panes -->
<div class="tab-content widget-content">
	<?php if($show_popular_posts == 'true'): ?>
		<div class="tab-pane active" id="tab-popular">
			<?php
			$popular_posts = new WP_Query('showposts='.$posts.'&meta_key=pbr_post_views_count&orderby=meta_value_num&order=DESC');
			if($popular_posts->have_posts()): ?>
			<div class="post-widget media-post-layout">
				<?php while($popular_posts->have_posts()): $popular_posts->the_post(); ?>
				<article class="item-post media">
					<?php if(has_post_thumbnail()): ?>
						<a href="<?php the_permalink(); ?>" class="image pull-left">
							<?php the_post_thumbnail( 'widget' ); ?>
						</a>
					<?php endif; ?>
					<div class="media-body">
						<h6 class="entry-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h6>
						<p>
							<span class="post-date">
								<i class="fa fa-calendar-o"></i>
								<?php the_time( 'd M Y' ); ?>
							</span>
							<span class="post-author">
								<i class="fa fa-user"></i> <?php the_author_posts_link(); ?>
							</span>
						</p>
					</div>
				</article>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<?php if($show_recent_posts == 'true'): ?>
		<div class="tab-pane" id="tab-recent">
			<?php
			$recent_posts = new WP_Query('showposts='.$tags_count);
			if($recent_posts->have_posts()):
			?>
			<div class="post-widget media-post-layout">
				<?php while($recent_posts->have_posts()): $recent_posts->the_post(); ?>
				<article class="item-post media">
					<?php if(has_post_thumbnail()): ?>
						<a href="<?php the_permalink(); ?>" class="image pull-left">
							<?php the_post_thumbnail( 'widget' ); ?>
						</a>
					<?php endif; ?>
					<div class="media-body">
						<h6 class="entry-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h6>
						<p>
							<span class="post-date">
								<i class="fa fa-calendar-o"></i>
								<?php the_time( 'd M Y' ); ?>
							</span>
							<span class="post-author">
								<i class="fa fa-user"></i> <?php the_author_posts_link(); ?>
							</span>
						</p>
					</div>
				</article>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<?php if($show_comments == 'true'): ?>
		<div class="tab-pane" id="tab-comments">
			<div class="post-widget comment-widget media-post-layout">
				<?php
				$number = $instance['comments'];
				$all_comments=get_comments( array('status' => 'approve', 'number'=>$number) );
				if(is_array( $all_comments)){
					foreach($the_comments as $comment) { ?>
					<article class="item-post media">
						<div class="image pull-left">
							<?php echo get_avatar($comment, '52'); ?>
						</div>
						<div class="media-body">
							<h6 class="entry-title">
								<?php echo strip_tags($comment->comment_author); ?> <?php esc_html__('says', 'pbrthemer' ); ?>:
							</h6>
							<p class="comment-text">
								<a class="comment-text-side" href="<?php echo esc_url( get_permalink($comment->ID) ); ?>#comment-<?php echo esc_attr( $comment->comment_ID ); ?>" title="<?php echo strip_tags($comment->comment_author); ?> on <?php echo esc_html( $comment->post_title ); ?>">
									<?php echo pbr_string_limit_words(strip_tags($comment->com_excerpt), 12); ?>...
								</a>
							</p>
						</div>
					</article>
					<?php } 
				}?>
			</div>
		</div>
	<?php endif; ?>
</div>
