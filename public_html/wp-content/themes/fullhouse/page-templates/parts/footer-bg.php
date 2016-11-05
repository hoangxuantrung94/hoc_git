<?php if( fullhouse_fnc_theme_options('footer-bg') ):  ?>

<img class="footer-wrapper-bg" src="<?php echo fullhouse_fnc_theme_options('footer-bg'); ?>" alt="<?php bloginfo( 'name' ); ?>" />

<?php else: ?>

<img class="footer-wrapper-bg" src="<?php echo get_template_directory_uri() . '/images/footer-bg.jpg'; ?>" alt="<?php bloginfo( 'name' ); ?>" />

<?php endif; ?>