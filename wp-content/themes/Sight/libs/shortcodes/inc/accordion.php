
<script type="text/javascript">

jQuery(document).ready( function() {
	$ = jQuery.noConflict();
	// Add block
	$("#add_block").click(function () {
       $('#accordion_block').append('<ul class="form_table sub_block"><li class="delete_btn"><input type="button" class="button-secondary delete_btn" value="Delete" /><input type="hidden" class="index"/></li><li><label>Header</label><div class="right"><input type="text" class="header" /></div><div class="clear"></div></li><li><label>Text</label><div class="right"><textarea class="content" rows="6" /></textarea></div><div class="clear"></div></li></ul>');
    });
	
	// Remove block
	$('.delete_btn').live('click', function(e) {
		e.preventDefault();
		$(this).parents().parents('.sub_block').remove();
	});

	$('#submit').click(function(){
		
		var shortcode = '[accordion]';
		
		// Star accordion item
		$('form#form').find('input.index').each(function(i) {
			shortcode += '[accord_item header="'+ $(this).parents().parents('.sub_block').find('input.header').val()+'"]';
			shortcode +=  $(this).parents().parents('.sub_block').find('textarea.content').val()+'[/accord_item]';

		});
		// End accordion item
		
		shortcode += '[/accordion]';

		window.send_to_editor(shortcode);
		event.preventDefault();
		return false;

	});

}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
<div id="accordion_block"></div>
<ul class="form_table">	
 <li><label>&nbsp;</label>
        <div class="right"><input type="button" id="add_block" name="add_block" class="button-secondary" value="Add accordion item +" /></div>
		<div class="clear"></div>
	</li>	
</ul>

<ul class="form_table">		
<hr />
	<?php echo $button; ?>
</ul>	
</form>