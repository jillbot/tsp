<script type="text/javascript">

jQuery(function($){ 
	$('#submit').click(function(){
			
		var shortcode = '';
		
		var new_group = $('#tab-new-group').val();
		var tab_headings = $('#tab-headings').val();
		var position = $('#tab-position').val();
		var content = $('#tab-content').val();
		
		if( new_group == 'yes' ){
			shortcode += '[tabs headings=\"'+ tab_headings +'\" ]';
		}
		
		shortcode += '[tab';
		
		shortcode += ' position="' + position + '"';
		shortcode += ']';
		
		shortcode += content;
		
		shortcode += '[/tab]';
		
		if( new_group == 'yes' ){
			shortcode += "\n[/tabs]";
		}
		
		window.send_to_editor(shortcode);
		event.preventDefault();
		return false;
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
<ul class="form_table">
	<li>
		<label>New Tab Group</label>
		<div class="right"><select name="tab-new-group" id="tab-new-group" size="1">
            <option value="no" selected="selected">No</option>
            <option value="yes">Yes</option>
        </select></div>
		<div class="clear"></div>
	</li>
	<li><label>Headings</label>
       <div class="right"><input type="text" name="tab-headings" value="" id="tab-headings" />
			<p>Separated by a comma. Example: Tab 1, Tab 2, Tab 3.</p>
		</div>
   		<div class="clear"></div>
    </li>
	
	<li><label>Position</label>
        <div class="right"><input type="text" name="tab-position" value="" id="tab-position" />
		<p>Example: 1 would be the first tab and 2 would be the second tab.</p>
		</div>
   		<div class="clear"></div>
    </li>
	
	<li><label>Content</label>
        <div class="right"><textarea name="tab-content" id="tab-content" rows="6" /></textarea></div>
   		<div class="clear"></div>
    </li>
	<?php echo $button; ?>
</ul>	
</form>