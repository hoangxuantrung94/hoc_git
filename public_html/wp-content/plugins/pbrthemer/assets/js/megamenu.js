
(function ($) {
	$(document).ready( function(){

		$('.inline-menu li').click( function(e){  
			$(this).parent().children('.active').removeClass('active' );
			$(this).toggleClass('active');
			e.stopPropagation();
		} );

		$('.inline-menu li').each( function(){
			var $this = $(this);

			var $profile = $('.megamenu_profile' , this );


			if( $profile.val() != "" ){
				$this.addClass('hasmega');
			}
			$profile.change( function() {  
				if( $profile.val() != "" ){
					$this.addClass('hasmega');
				}else {
					$this.removeClass('hasmega');
				}

			} );
			$('em',$this).click( function(e){   
				$($this).parent().children('.active').removeClass('active' );
				e.stopPropagation();
			} );

		}  );
		
	} );
})(jQuery);