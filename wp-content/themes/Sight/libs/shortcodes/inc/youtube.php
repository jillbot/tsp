<script type="text/javascript">
jQuery(document).ready( function($) {
	$('#submit').click(function(){

		var shortcode = '[y='+$('#youtube-id').val()+' height='+ $('#youtube-height').val() +']';
		
		window.send_to_editor(shortcode);
		event.preventDefault();
		return false;
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
<ul class="form_table">
	<li><label>Youtube ID</label>
        <div class="right"><input type="text" name="youtube-id" value="YE7VzlLtp-4" id="youtube-id" /></div>
   		<div class="clear"></div>
    </li>
	
	<li>
        <label>Height</label>
        <div class="right"><input type="text" name="youtube-height" id="youtube-height" value="400"  /></div>
		<div class="clear"></div>
    </li>
	
	<?php echo $button; ?>
</ul>	
</form>