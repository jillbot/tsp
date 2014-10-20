<?php global $theme_url, $pl_data; ?>
<link rel='stylesheet' id='demo-style'  href='<?php echo $theme_url;?>/_switcher/style.css' type='text/css' media='all' />

<link rel='stylesheet' id='demo-minicolor'  href='<?php echo $theme_url;?>/_switcher/miniColors/jquery.miniColors.css' type='text/css' media='all' />

<script type="text/javascript">
var template = '<?php echo $theme_url;?>';
</script>
<div id="pl_control_panel">
	<div id="panel_control" class="control-open"></div>
	<div class="padd">
		<div class="input" id="predefined_skins">
		<h4>Color Schemes</h4>
		<a href="" id="skin1" data-primary_color="e74c3c" data-color="fafafa" data-pattern="noise_pattern_with_crosslines"></a>
		<a href="" id="skin2" data-primary_color="2ecc71" data-color="fafafa" data-pattern="bg0"></a>
		<a href="" id="skin3" data-primary_color="3498db" data-color="fafafa" data-pattern="bg1"></a>
		<a href="" id="skin4" data-primary_color="9b59b6" data-color="fafafa" data-pattern="bg2"></a>
		<a href="" id="skin5" data-primary_color="f39c12" data-color="fafafa" data-pattern="bg3"></a>
		<a href="" id="skin6" data-primary_color="d35400" data-color="fafafa" data-pattern="retina_wood"></a>
		<a href="" id="skin7" data-primary_color="1abc9c" data-color="fafafa" data-pattern="purty_wood"></a>
		<div class="clear"></div>
		</div>
		<div class='input'>
			<h4>Background</h4>
			<input type='text' value='#<?php echo $pl_data['body_background'];?>' name='custom_bg_color' id='custom_bg_color'/>
			
		</div>

		<div class='input'>
			<h4>Example Patterns</h4>
			<div id='custom_bg_image' class="custom_bg_image">
				<img src='<?php echo $theme_url;?>/_switcher/images/_blank.png' data-img="bg0" alt="demo" />
				<img src='<?php echo $theme_url;?>/_switcher/images/_blank.png' data-img="bg1" alt="demo" />
				<img src='<?php echo $theme_url;?>/_switcher/images/_blank.png' data-img="bg2" alt="demo" />
				<img src='<?php echo $theme_url;?>/_switcher/images/_blank.png' data-img="bg3" alt="demo" />
				<img src='<?php echo $theme_url;?>/_switcher/images/_blank.png' data-img="retina_wood" alt="demo" />
				<img src='<?php echo $theme_url;?>/_switcher/images/_blank.png' data-img="bg4" alt="demo" />
				<img src='<?php echo $theme_url;?>/_switcher/images/_blank.png' data-img="bg5" alt="demo" />
				<img src='<?php echo $theme_url;?>/_switcher/images/_blank.png' data-img="white_brick_wall" alt="demo" />
				<img src='<?php echo $theme_url;?>/_switcher/images/_blank.png' data-img="rip_jobs" alt="demo" />
				<img src='<?php echo $theme_url;?>/_switcher/images/_blank.png' data-img="purty_wood" alt="demo" />
				<div class="clear"></div>
			</div>
		</div>
		<br />
		<input type="button" id="reset_style" value="Reset" />
		
	
		
		<!--- end -->
	</div>	
</div>	

<script src="<?php echo $theme_url;?>/_switcher/miniColors/jquery.miniColors.min.js"></script>
<script src="<?php echo $theme_url;?>/_switcher/script.js"></script>
