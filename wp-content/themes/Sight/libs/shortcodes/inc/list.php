<script type="text/javascript">
jQuery(function($){ 
	$('#submit').click(function(){
		
		var shortcode = '<ul class="'+ $('#list-type').val() +'">';
		
		if ( $('#list-text').val() !== '' ){
			$.each($('#list-text').val().split('\n'), function(index, value) { 
			  shortcode += '<li>' + value +'</li>';
			});
		}else{
			shortcode += '<li>Sample Item #1</li><li>Sample Item #2</li><li>Sample Item #3</li>';
		}
		
		shortcode += '</ul>';
		
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
		<div class="right"><select name="list-type" id="list-type" size="1">
            <option value="plist lcheck" selected="selected">Check</option>
			<option value="plist larrow">Arrow</option>
			<option value="plist lstar">Star</option>
        </select></div>
		<div class="clear"></div>
	</li>
    <li>
        <label>List Text</label>
        <div class="right"><textarea name="list-text" id="list-text" rows="6" /></textarea><br /><small>Separated by a new-line (press Enter).</small></div>
		
		<div class="clear"></div>
    </li>
	
	<?php echo $button; ?>
</ul>	
</form>