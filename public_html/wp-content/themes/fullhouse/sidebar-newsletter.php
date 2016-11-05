

<?php 

if ( ! is_active_sidebar( 'newsletter' ) ) {
	return;
}
?>
<section id="pbr-newsletter" class="pbr-newsletter">
	<div class="container">
		<div>
			<?php dynamic_sidebar( 'newsletter' ); ?>
		</div>
	</div>	
</section>	
 