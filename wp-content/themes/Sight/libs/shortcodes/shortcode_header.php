<?php
function add_generator_button() {
	echo '<a href="#TB_inline?width=550&height=600&inlineId=generator-wrap" class="thickbox button-primary" title="' . __( 'Insert shortcode', 'presslayer' ) . '" data-page="content" data-target="">+ Shortcodes</a>';
}

add_action( 'media_buttons', 'add_generator_button', 100 );

function generator_popup() {
?>
<div id="generator-wrap" style="display:none">
<script type="text/javascript">
jQuery(document).ready(function($){

	$('#select-shortcode').change(function() {
		var key = $(this).find('option:selected').val();
		
		$.ajax({
			url: 'admin-ajax.php',
			data: $('#shortcode_selector').serialize()+'&action=shortcode_load_ajax&do='+key,
			type: 'POST',
			dataType: "html",
			success: function(response) {
				$('#shortcode_loaded').html(response);
			}
		});
		$("#shortcode_loaded").empty();
        $("#shortcode_loaded").show();
		$("#shortcode_loaded").append('<div class="shortcode_loader"></div>');
		
	});
});
</script>
	<form id="shortcode_selector" action="/" method="get" accept-charset="utf-8">
<ul class="form_table"><li style="background-color:#eee;"><label>&nbsp;</label>
<div class="right">
		<select name="select-shortcode" id="select-shortcode">
			<option value="none" selected="selected">== Select shortcode ==</option>
			<?php
			//Background images reader
			$shortcode_path = get_stylesheet_directory() . '/libs/shortcodes/inc/';
			$shortcodes = array();
			
			if ( is_dir($shortcode_path) ) {
				if ($shortcode_file_dir = opendir($shortcode_path) ) { 
					while ( ($shortcode_file = readdir($shortcode_file_dir)) !== false ) {
						$ext = stristr ($shortcode_file,'.');
						if($ext=='.php') {
							$key = str_replace($ext,'',$shortcode_file);
							$label = ucwords(str_replace(array('_','-'), ' ', $key));
							?>
							<option value="<?php echo $key;?>"><?php echo $label;?></option>
							<?php
						}
					}    
				}
			}
			
			?>
		</select>
	</div><div class="clear"></div>	
	</li>	
</ul>		
	</form>	
	<div id="shortcode_loaded" class="shortcode_wrapper"></div>
	
</div>

<?php  } ?>