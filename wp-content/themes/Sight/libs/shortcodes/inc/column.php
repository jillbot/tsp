<script type="text/javascript">

jQuery(document).ready( function($) {
	$('#submit').click(function(){
		var size = $('#column-size').val();
		var content = $('#column-content').val();	
		var position = $('#column-position').val();	
		var shortcode = '[column';
		shortcode += ' col="'+ size +'"';
		
		if(position == 'first') shortcode += ' position="first"';
		if(position == 'last') shortcode += ' position="last"';
			
		shortcode += ']';
		
		if(content !== '')
			shortcode += content;
		else
			shortcode += "Column content...";		

		shortcode += '[/column]';
		
		window.send_to_editor(shortcode);
		event.preventDefault();
		return false;
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
<ul class="form_table">
	<li><label>Size</label>
        <div class="right"><select name="column-size" id="column-size" size="1">
            <option value="1/2" selected="selected">1/2</option>
			<option value="1/3">1/3</option>
			<option value="1/4">1/4</option>
			<option value="2/3">2/3</option>
			<option value="3/4">3/4</option>
        </select></div>
   		<div class="clear"></div>
    </li>
	
	<li><label>Content</label>
        <div class="right"><textarea name="column-content" id="column-content" rows="6"></textarea></div>
   		<div class="clear"></div>
    </li>
	
	<li><label>Position</label>
        <div class="right"><select name="column-position" id="column-position" size="1">
            <option value="first" selected="selected">First</option>
			<option value="middle">Middle</option>
			<option value="last">Last</option>
        </select></div>
   		<div class="clear"></div>
    </li>
	
	<?php echo $mbclass.$button; ?>
</ul>	
</form>