<script type="text/javascript">

jQuery(document).ready( function($) {
	$('#submit').click(function(){
		var shortcode = '[dropcap style="'+ $('#dropcap-style').val() +'"';
		shortcode += ' text="'+ $('#dropcap-text').val() +'"]';
	
		
		window.send_to_editor(shortcode);
		event.preventDefault();
		return false;
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
<ul class="form_table">
    <li>
		<label>Style</label>
		<div class="right"><select name="dropcap-style" id="dropcap-style">
          <option value="1" selected="selected">Style-1</option>
          <option value="2">Style-2</option>
		  <option value="3">Style-3</option>
		  <option value="4">Style-4</option>
		  <option value="5">Style-5</option>
        </select></div>
		<div class="clear"></div>
	</li>
	<li>
        <label>Text</label>
        <div class="right"><input type="text" name="dropcap-text" value="" id="dropcap-text" /></div>
		<div class="clear"></div>
    </li>
	
	 <li>
        <label>&nbsp;</label>
       <div class="right"><input type="button" id="submit" class="button-primary" value=" Insert shortcode" name="submit" /></div>
		<div class="clear"></div>
    </li>
</ul>	
</form>