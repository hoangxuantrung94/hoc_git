<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     Wordpress Opal Team <opalwordpress@gmail.com >
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

if($page_url): ?>
	<iframe src="http<?php echo (is_ssl())? 's' : ''; ?>://www.facebook.com/plugins/likebox.php?href=<?php echo urlencode($page_url); ?>&amp;width=<?php echo esc_attr( $width ); ?>&amp;colorscheme=<?php echo esc_attr( $color_scheme ); ?>&amp;show_faces=<?php echo esc_attr($show_faces); ?>&amp;stream=<?php echo esc_attr( $show_stream ); ?>&amp;header=<?php echo esc_attr( $show_header ); ?>&amp;height=<?php echo esc_attr( $height ); ?>&amp;force_wall=true<?php if($show_faces == 'true'): ?>&amp;connections=8<?php endif; ?>" 
		style="border:none; overflow:hidden; width:<?php echo esc_attr( $width ); ?>px; height: <?php echo esc_attr( $height ); ?>px;">
	</iframe>
<?php endif;
?>