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
/**
 * Enable/distable related posts
 */
if ( 1 != fullhouse_fnc_theme_options( 'blog-show-related-post', 1 ) ) {
    return;
}

$categories = get_the_category();
$category__in = array();

foreach ( $categories as $category ) {
    $category__in[] = $category->cat_ID;
}

$tags = get_the_tags();
$tag__in = array();

if ( $tags ) {
    foreach ( $tags as $tag ) {
        $tag__in[] = $tag->term_id;
    }
}

$related_count = fullhouse_fnc_theme_options( 'blog-items-show', 4 );

$args = array(
    'posts_per_page' => $related_count,
    'post__not_in'   => array( get_the_ID() ),
);

if ( $category__in ) {
    $args['tax_query'][] = array(
        'taxonomy' => 'category',
        'fields'   => 'term_id',
        'terms'    => $category__in
    );
}

if ( $tag__in ) {
    $args['tax_query'][] = array(
        'taxonomy' => 'post_tag',
        'fields'   => 'term_id',
        'terms'    => $tag__in
    );
}

if ( isset($args['tax_query']) && count( $args['tax_query'] ) >= 2  ) {
    $args['tax_query']['relation'] = 'OR';
}

$related_posts = new WP_Query( $args );

$class_column = floor( 12/$related_count );
?>
<div id="related-posts" class="related-posts">
    <div class="row">
        <?php if ( $related_posts->have_posts() ) : ?>
            <div class="col-md-12"><h3 class="related-post-title"><?php esc_html_e( 'Related Post ', 'fullhouse' ); ?></h3></div>
            <?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
                <div class="col-sm-<?php echo esc_attr($class_column); ?>">
                    <article class="post">
                        <?php
                        if ( has_post_thumbnail() ) {
                            ?>
                                <figure class="entry-thumb">
                                    <a href="<?php the_permalink(); ?>" title="" class="entry-image zoom-2">
                                        <?php the_post_thumbnail();  ?>
                                    </a>
                                    <!-- vote    -->
                                </figure>
                            <?php
                        }
                        ?>
                        <div class="entry-content">
                            <?php if (get_the_title()) { ?>
                                <h5 class="entry-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h5>
                            <?php  } ?>
                        </div>
                    </article>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata();?>
        <?php endif; ?>
    </div>
    
</div>
