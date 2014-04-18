/**
 * All Types Meta Box Class JS
 *
 * JS used for the custom metaboxes and other form items.
 *
 * Copyright 2011 - 2013 Ohad Raz (admin@bainternet.info)
 * @since 1.0
 */

var $ =jQuery.noConflict();

var Ed_array = Array;
jQuery(document).ready(function($) {

  //editor rezise fix
  $(window).resize(function() {
    $.each(Ed_array, function() {
      var ee = this;
      $(ee.getScrollerElement()).width(100); // set this low enough
      width = $(ee.getScrollerElement()).parent().width();
      $(ee.getScrollerElement()).width(width); // set it to
      ee.refresh();
    });
  });
});



jQuery(document).ready(function($){
	var my_original_editor = window.send_to_editor;
	$('.pl_upload_button').live("click",function() {
			formfield = $(this).prev('input').attr('name');
			tb_show($(this).attr('title'), 'media-upload.php?TB_iframe=true');
			window.send_to_editor = function(content) {
			imgurl = $(content).html('a').attr('href');
			$('#' + formfield).val(imgurl);
			
			tb_remove();
			window.send_to_editor = my_original_editor;
		};
		return false;
	});

});