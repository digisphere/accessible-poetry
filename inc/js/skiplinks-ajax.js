jQuery( document ).ready(function($) {
	var data = {
		action: 'acp_skiplinks_output',
	    security : acpsAjax.security,
	};
	$.post(acpsAjax.ajaxurl, data, function(response) {
		$("body").prepend(response);
		$(".skiplinks").each(function(){
			var addTabindexTo = $(this).attr('href');
			$(addTabindexTo).attr('tabindex', '0');
		});
		$(".skiplinks").click(function(event){
			var skipTo="#"+this.href.split('#')[1];
			$(skipTo).attr('tabindex', -1).on('blur focusout', function () {
				$(this).removeAttr('tabindex');
			}).focus();
		});
 	});
	
});
