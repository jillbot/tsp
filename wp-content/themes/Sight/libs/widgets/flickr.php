<?php
add_action('widgets_init', 'flickr_load_widgets');

function flickr_load_widgets()
{
	register_widget('Flickr_Widget');
}

class Flickr_Widget extends WP_Widget {
	
	function Flickr_Widget()
	{
		$widget_ops = array('classname' => 'flickr_widget', 'description' => 'The most recent photos from flickr.');

		$control_ops = array('id_base' => 'flickr-widget');

		$this->WP_Widget('flickr-widget', '&rArr; PressLayer: Flickr', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);

		$title = apply_filters('widget_title', $instance['title']);
		$flick_id = $instance['flick_id'];
		$number = $instance['number'];
		
		echo $before_widget;

		if($title) {
			echo $before_title.$title.$after_title;
		}
		
		if($flick_id && $number) {
		?>
		
		<script>
			var $j = jQuery.noConflict();
			$j(document).ready(function(){ 
				$j('#basicuse').jflickrfeed({
					limit: <?php echo $number;?>,
					qstrings: {
						id: '<?php echo $flick_id;?>'
					},
					itemTemplate: '<a href="{{link}}" target="_blank" class="flickr_item"><img src="{{image_s}}" alt="{{title}}" /></a>'
				});
			});
			</script>
		<div class='flickr_wrapper'>
			<div class="flr_wrapper_inner">	
				<div id="basicuse"  class='flr_inner'>
			
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<?php
		}
		
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['flick_id'] = $new_instance['flick_id'];
		$instance['number'] = $new_instance['number'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Photostream', 'flick_id' => '92432230@N02', 'number' => 12);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('flick_id'); ?>">Flick ID:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('flick_id'); ?>" name="<?php echo $this->get_field_name('flick_id'); ?>" value="<?php echo $instance['flick_id']; ?>" />
			<p style="font-size:11px"><a href="http://idgettr.com/" target="_blank">Get your Flickr id?</a></p>
		</p>


		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">Number of photos to show:</label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $instance['number']; ?>" />
		</p>
		
	<?php
	}
}
?>