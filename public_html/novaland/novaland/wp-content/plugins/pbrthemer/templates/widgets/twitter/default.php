<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     Wordpress Opal Team <opalwordpress@gmail.com, support@prestabrain.com>
 * @copyright  Copyright (C) 2015 prestabrain.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://0www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */
if( $title )
	echo ($before_title)  . trim( $title ) . $after_title;
?>
<div class="widget-twitter block">
	<div class="block_content">
		<div id="pbr-twitter<?php echo esc_attr( $user ); ?>" class="pbr-twitter">
			<a class="twitter-timeline" data-dnt="true" width="<?php echo esc_attr( $width ); ?>px" height="<?php echo esc_attr( $height ); ?>px" data-chrome="<?php echo esc_attr( $chrome ); ?>" data-border-color="<?php echo esc_attr( $border_color ); ?>"  data-tweet-limit="<?php echo esc_attr($limit); ?>" data-link-color="<?php echo esc_attr( $link_color ); ?>"  data-show-replies="<?php echo esc_attr( $show_replies ); ?>" href="https://twitter.com/<?php echo esc_attr( $user ); ?>"  data-widget-id="<?php echo esc_attr( $twitter_id ); ?>">Tweets by @<?php echo esc_html( $user ); ?></a>
			<?php print trim($js); ?>
		</div>	
	</div>
</div>
<script type="text/javascript">
	(function($) {
		// Customize twitter feed
		var hideTwitterAttempts = 0;
		function hideTwitterBoxElements() {
		 setTimeout( function() {
		  if ( $('[id*=pbr-twitter<?php echo esc_js( $user ); ?>]').length ) {
		   $('#pbr-twitter<?php echo esc_js( $user ); ?> iframe').each( function(){
		    var ibody = $(this).contents().find( 'body' );
			var show_scroll = <?php echo esc_js( $show_scrollbar ); ?>; 
			var height =  <?php echo esc_js( $height ); ?>+'px'; 
		    if ( ibody.find( '.timeline .stream .h-feed li.tweet' ).length ) {
				ibody.find( '.e-entry-title' ).css( 'color', '<?php echo esc_js( $text_color ); ?>' );
				ibody.find( '.header .p-nickname' ).css( 'color', '<?php echo esc_js( $mail_color ); ?>' );
				ibody.find( '.p-name' ).css( 'color', '<?php echo esc_js( $name_color ); ?>' );
				if(show_scroll == 1){
					ibody.find( '.timeline .stream' ).css( 'max-height', height );
					ibody.find( '.timeline .stream' ).css( 'overflow-y', 'auto' );	
					ibody.find( '.timeline .twitter-timeline' ).css( 'height', 'inherit !important' );	
				}
		    } else {
		     $(this).hide();
		    }
		   });
		  }
		  hideTwitterAttempts++;
		  if ( hideTwitterAttempts < 3 ) {
		   hideTwitterBoxElements();
		  }
		 }, 1500);
		}
		// somewhere in your code after html page load
		hideTwitterBoxElements();
	})(jQuery);
</script>

