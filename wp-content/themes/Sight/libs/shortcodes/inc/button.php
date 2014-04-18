<script type="text/javascript">
// executes this when the DOM is ready
jQuery(document).ready( function($) {
	
	// handles the click event of the submit button
	$('#submit').click(function(){
	
		var shortcode = '[button';
		
		shortcode += ' color="'+ $('#button-color').val() +'"';
		shortcode += ' size="'+ $('#button-size').val() +'"';
		shortcode += ' width="'+ $('#button-width').val() +'"';
		shortcode += ' url="'+ $('#button-url').val() +'"';
		shortcode += ' target="'+ $('#button-target').val() +'"';
		shortcode += ' text="'+ $('#button-text').val() +'"';
		
		shortcode += ']';

		
		window.send_to_editor(shortcode);
		
		// Prevent default action
		event.preventDefault();
		return false;
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
<ul class="form_table">
	<li>
		<label>Button color</label>
		<div class="right"><select name="button-color" id="button-color">
            <option value="normal" selected="selected">Normal</option>
            <option value="turquoise">Turquoise</option>
			<option value="green">Green</option>
		    <option value="blue">Blue</option>
			<option value="red">Red</option>
			<option value="violet">Violet</option>
			<option value="orange">Orange</option>
			<option value="carot">Carot</option>
			<option value="gray">Gray</option>
        </select></div>
		<div class="clear"></div>
	</li>
	
	<li>
		<label>Button size</label>
		<div class="right"><select name="button-size" id="button-size">
            <option value="normal" selected="selected">Normal</option>
			<option value="small" >Small</option>
			<option value="big">Big</option>
        </select></div>
		<div class="clear"></div>
	</li>
	<li>
		<label>Button width</label>
		<div class="right"><select name="button-width" id="button-width">
            <option value="normal" selected="selected">Normal</option>
			<option value="full" >Full wdith</option>
        </select></div>
		<div class="clear"></div>
	</li>
	
	<li><label>Link</label>
        <div class="right"><input type="text" name="button-url" value="" id="button-url" /></div>
   		<div class="clear"></div>
    </li>
	
	<li>
		<label>Target</label>
		<div class="right"><select name="button-target" id="button-target" size="1">
            <option value="none" selected="selected">None</option>
            <option value="_blank">New Window</option>
        </select></div>
		<div class="clear"></div>
	</li>
	
    <li>
        <label>Text Link</label>
        <div class="right"><input type="text" name="button-text" value="" id="button-text" /></div>
		<div class="clear"></div>
    </li>
	
	 <?php 
	echo $button;
	?>
</ul>	
</form>