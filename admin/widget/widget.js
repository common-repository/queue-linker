(function($) {
	$(function() {
		$('.widget.ui-draggable[id*="queue"]').each(function() {
      $(this).addClass('queue-widget');
		});
	});
})(jQuery);