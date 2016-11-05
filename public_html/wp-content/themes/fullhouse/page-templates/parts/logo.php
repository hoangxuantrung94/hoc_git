 <?php if( fullhouse_fnc_theme_options('logo') ):  ?>
<div class="logo pbr-logo">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <img src="<?php echo fullhouse_fnc_theme_options('logo'); ?>" alt="<?php bloginfo( 'name' ); ?>">
    </a>
</div>
<?php else: ?>
	<?php $header = apply_filters( 'fullhouse_fnc_get_header_layout', null ); ?>
    <div class="logo pbr-logo logo-theme">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
             <img src="<?php echo get_template_directory_uri() . '/images/logo'.$header.'.png'; ?>" alt="<?php bloginfo( 'name' ); ?>" />
        </a>
    </div>
<?php endif; ?>