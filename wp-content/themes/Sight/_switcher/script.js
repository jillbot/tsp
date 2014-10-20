(function($) {
	
	// Example skins
	$( "#predefined_skins a" ).each(function( index ) {
		$(this).css('background-color', '#' + $(this).data('primary_color'));  
	});
	$('#predefined_skins a').click(function(e) {
		e.preventDefault();									  
		$(this).parent().find('a').removeClass('selected');
		$(this).addClass('selected');
		
		var skin = $(this).attr('id');
		var primary_color = $(this).data('primary_color');
		var color = $(this).data('color');
		var pattern = $(this).data('pattern');
		
		// Set default value
		$('#header_logo').attr('src', template+'/images/logo_' + skin + '.png');
		$('link#skin-css').attr('href', template+'/css/' + skin + '.css');
		$('body').css('background-image', 'url(' + template + '/images/bg/' + pattern + '.png)');
		
		return false;
	});
	
	// Background color
	$('#custom_bg_color').miniColors({
		change: function(hex, rgba) {
			$('body').css('background-color', hex);
		}
	});
	
	// Background pattern
	$( "#custom_bg_image img" ).each(function( index ) {
		var pattern =  $(this).data('img');									  
		$(this).css('background-image',  'url(' + template + '/images/bg/'+ pattern +'.png)');  
	});
	
	$('#custom_bg_image img').click(function(e) {
		var pattern =  $(this).data('img');	
		e.preventDefault();
		$('body').css('background-image', 'url(' + template + '/images/bg/' + pattern + '.png)');
		$(this).parent().find('img').removeClass('selected');
		$(this).addClass('selected');
		
	});
	
	// Reset
	$('#reset_style').click(function(e) {
		setTimeout('location.reload(true);', 0);
	});
	
	// Control panel
	$('#panel_control').click(function(){
		if ( $(this).hasClass('control-open') ) {
			$('#pl_control_panel').animate( { left: 0 }, {easing: 'easeOutCirc'}, 300);
			$(this).removeClass('control-open');
			$(this).addClass('control-close');
		} else {
			$('#pl_control_panel').animate( { left: -301 },{easing: 'easeOutCirc'}, 300 );
			$(this).removeClass('control-close');
			$(this).addClass('control-open');
		}
		return false;
	});	

})(jQuery);	