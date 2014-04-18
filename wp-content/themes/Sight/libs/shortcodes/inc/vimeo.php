<script type="text/javascript">

jQuery(document).ready( function($) {
	$('#submit').click(function(){
		
		var shortcode = '[v='+$('#vimeo-id').val()+' height='+ $('#vimeo-height').val() +']';
		
		window.send_to_editor(shortcode);
		event.preventDefault();
		return false;
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
<ul class="form_table">
	<li><label>Vimeo ID</label>
        <div class="right"><input type="text" name="vimeo-id" value="18058390" id="vimeo-id" /></div>
   		<div class="clear"></div>
    </li>
	
	<li>
        <label>Height</label>
        <div class="right"><input type="text" name="vimeo-height" id="vimeo-height" value="400"  /></div>
		<div class="clear"></div>
    </li>
	
	<?php echo $button; ?>
</ul>	
</form>