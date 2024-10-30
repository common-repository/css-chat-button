(function( $ ) {
	'use strict';
	$( document ).ready(function() {
		// console.log( "ready!" );
		// glob_pos:
		var selector_glob_pos = "input[name=css-chat-button-settings\\[glob_pos\\]]";
		$("form "+selector_glob_pos).on('change', function() {
			var glob_pos = $(selector_glob_pos+":checked", 'form').val();

			if(glob_pos == "bottom-right"){
				$('#pad_r').closest('tr').show();
				$('#pad_l').closest('tr').hide();
			}
			else if(glob_pos == "bottom-left"){
				$('#pad_r').closest('tr').hide();
				$('#pad_l').closest('tr').show();
			}
		}).trigger( "change" );

		// scale:
		$("form input[name=css-chat-button-settings\\[scale\\]]").on('change keyup keypress', function(e) {
			var target = $("form #css-chat-button-scale_px")
			, full_px=target.data("full")
			, scale = parseInt( $( this ).val() )
			;
			target.text(full_px*(scale?scale:0)/100)
		}).trigger( "change" );

		// color hover:
		var selector_colorh = "input[name=css-chat-button-settings\\[colorh\\]]";
		$("form "+selector_colorh).on('change', function() {
			var colorh = $(selector_colorh+":checked", 'form').val();
			if(colorh == "1"){
				$('.hover_color').show();
			}
			else{
				$('.hover_color').hide();
			}
		}).trigger( "change" );

		$(".css-chat-button .colors0").on('click', function() {
			$(".css-chat-button #colorb" ).val('#25D366').css('background-color', '#25D366').colorPicker(); 
			$(".css-chat-button #colorf" ).val('#FFFFFF').css('background-color', '#FFFFFF').colorPicker(); 
			$(".css-chat-button #colorbh").val('#103928').css('background-color', '#103928').colorPicker(); 
			$(".css-chat-button #colorfh").val('#DCF8C6').css('background-color', '#DCF8C6').colorPicker(); 
		});
	});

})( jQuery );
