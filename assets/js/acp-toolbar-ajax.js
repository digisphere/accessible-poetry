jQuery(document).ready(function($){
	var data = {
		action: 'acp_toolbar_ajax',
	    security : acptAjax.security,
	};
	$.post(acptAjax.ajaxurl, data, function(response) {
		$("body").prepend(response);
		
		// toolbar
		acp_toolbar();
		
		// font size changer
		acp_fontsize();
		
		// contrast
		acp_contrast();
		
		// links underline
		acp_underline();
		
		// links highlight
		acp_highlight();
		
		// readable font
		acp_readable();
		
		// animation
		acp_animation();
	});
});