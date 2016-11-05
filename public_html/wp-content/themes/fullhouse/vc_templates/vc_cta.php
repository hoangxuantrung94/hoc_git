<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Cta
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->buildTemplate( $atts, $content );
?>
<section
	class="pbr-calltoaction vc_cta3-container <?php echo esc_attr( implode( ' ', $this->getTemplateVariable( 'container-class' ) ) ); ?>">
	<div class="vc_general <?php echo esc_attr( implode( ' ', $this->getTemplateVariable( 'css-class' ) ) ); ?>"<?php
	if ( $this->getTemplateVariable( 'inline-css' ) ) {
		echo ' style="' . esc_attr( implode( ' ', $this->getTemplateVariable( 'inline-css' ) ) ) . '"';
	}
	?>>
		<?php echo trim( $this->getTemplateVariable( 'icons-top' ) ); ?>
		<?php echo trim( $this->getTemplateVariable( 'icons-left' ) ); ?>
		<div class="vc_cta3_content-container">
			<?php echo ( $this->getTemplateVariable( 'actions-top' ) ); ?>
			<?php echo ( $this->getTemplateVariable( 'actions-left' ) ); ?>
			<div class="vc_cta3-content">
				<div class="vc_cta3-content-header">
					<?php echo trim( $this->getTemplateVariable( 'heading2' ) ); ?>
					<?php echo trim( $this->getTemplateVariable( 'heading1' ) ); ?>
				</div>
				<?php echo trim( $this->getTemplateVariable( 'content' ) ); ?>
			</div>
			<?php echo trim( $this->getTemplateVariable( 'actions-bottom' ) ); ?>
			<?php echo trim( $this->getTemplateVariable( 'actions-right' ) ); ?>
		</div>
		<?php echo trim( $this->getTemplateVariable( 'icons-bottom' ) ); ?>
		<?php echo trim( $this->getTemplateVariable( 'icons-right' ) ); ?>
	</div>
</section><?php echo trim( $this->endBlockComment( $this->getShortcode() ) ); ?>

