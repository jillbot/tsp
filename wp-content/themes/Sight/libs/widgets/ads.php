<?php
add_action('widgets_init', 'ads_load_widgets');

function ads_load_widgets()
{
	register_widget('Ads_Widget');
}

class Ads_Widget extends WP_Widget {
	
	function Ads_Widget()
	{
		$widget_ops = array('classname' => 'ads', 'description' => 'Ads widget let you display Twitter updates.');

		$control_ops = array('id_base' => 'ads-widget');

		$this->WP_Widget('ads-widget', '&rArr; PressLayer: Advertising', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		$image = $instance['image'];
		$url = $instance['url'];
		$code = $instance['code'];
		
		echo $before_widget;
		
		if($code!=''){
			echo stripslashes($code);
		}else{
			if($image!=''){?>
			<a href="<?php echo $url;?>" target="_blank"><img src="<?php echo $image;?>" alt="Ads" /></a>
			<?php }
		}

		
		echo $after_widget;
	}
	
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['image'] = strip_tags($new_instance['image']);
		$instance['url'] = $new_instance['url'];
		$instance['code'] = $new_instance['code'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('image' => get_template_directory_uri().'/images/tf_300x250_v2.gif', 'url' => 'http://www.presslayer.com', 'code' => '');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('image'); ?>">Banner image:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" value="<?php echo $instance['image']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('url'); ?>">URL:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" value="<?php echo $instance['url']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('code'); ?>">Adsense code:</label>
			<textarea class="widefat" style="width: 216px; height:100px" id="<?php echo $this->get_field_id('code'); ?>" name="<?php echo $this->get_field_name('code'); ?>"><?php echo $instance['code']; ?></textarea>
			<p>If you want to display Google ads or equivalent advertising</p>
		</p>

	<?php
	}
}
?>