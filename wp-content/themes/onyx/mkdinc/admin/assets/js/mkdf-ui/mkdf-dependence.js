(function($){
	$(document).ready(function() {
		mkdfInitSelectChange();
	});

	function mkdfInitSelectChange() {
		$(document).on('change', 'select.dependence', function (e) {
			var optionSelected = $("option:selected", this);
			var valueSelected = this.value.replace(/ /g, '');
			console.log($($(this).data('show-'+valueSelected)).length);
			$($(this).data('hide-'+valueSelected)).fadeOut();
			$($(this).data('show-'+valueSelected)).fadeIn();
		});
	}
})(jQuery);
