<script type="text/javascript">
jQuery(document).ready( function($) {
	$('#submit').click(function(){

		var shortcode = '[alert type="'+ $('#alert-type').val() +'"';
		shortcode += ' text="' + $('#alert-text').val() + '"]';
		
		window.send_to_editor(shortcode);
		event.preventDefault();
		return false;
		
	});

}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
<ul class="form_table">

	<li>
		<label>Type</label>
		<div class="right"><select name="alert-type" id="alert-type" size="1">
            <option value="box_ok" selected="selected">Success</option>
            <option value="box_info">Info</option>
            <option value="box_error">Error</option>
            <option value="box_alert">Warning</option>
        </select></div>
		<div class="clear"></div>
	</li>
    <li>
        <label>Text</label>
        <div class="right"><textarea name="alert-text" id="alert-text" rows="6" /></textarea></div>
		<div class="clear"></div>
    </li>
	
	<?php echo $button; ?>
</ul>	
</form>