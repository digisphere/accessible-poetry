jQuery(document).ready(function($){
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