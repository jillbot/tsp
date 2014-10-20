<?php
add_action('widgets_init', 'newsletter_load_widgets');

function newsletter_load_widgets()
{
	register_widget('Newsletter_Widget');
}

class Newsletter_Widget extends WP_Widget {
	
	function Newsletter_Widget()
	{
		$widget_ops = array('classname' => 'widget_newsletter', 'description' => 'Newsletter widget let you display Twitter updates.');

		$control_ops = array('id_base' => 'newsletter-widget');

		$this->WP_Widget('newsletter-widget', '&rArr; PressLayer: Newsletter', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		
		$color = $instance['color'];
		$title = $instance['title'];
		$text = $instance['text'];
		$feedburner = $instance['feedburner'];
		
		?>
		
		<div class="widget widget_newsletter white_box <?php echo $color;?>">

		<div class="border_b">
			<div class="newsletter_inner">
			
			<h3><?php echo $title; ?></h3>
				<p><?php echo $text; ?></p>
				
				<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $feedburner; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
					
					<input type="text" placeholder="<?php _e('Email address','presslayer');?>" name="email" class="letter_email" />
					<input type="submit" name="submit" value="<?php _e('Subscribe','presslayer');?>" class="letter_submit" />
					<input type="hidden" value="<?php echo $feedburner; ?>" name="uri" />
					<input type="hidden" name="loc" value="en_US" />
				</form>
			</div>	
		</div></div>
		
		
		<?php

	}
	
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['color'] = strip_tags($new_instance['color']);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = $new_instance['text'];
		$instance['feedburner'] = $new_instance['feedburner'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('color'=>'default','title' => 'Newsletter', 'text' => 'Sign up to receive email updates and to hear what\'s going on with our company!', 'feedburner' => 'presslayer');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('color'); ?>">Box color:</label> 
			<select id="<?php echo $this->get_field_id('color'); ?>" name="<?php echo $this->get_field_name('color'); ?>" class="widefat follow" style="width:100%;">
				<option value='default' <?php if ('default' == $instance['color']) echo 'selected="selected"'; ?>>Default</option>
				<option value='red' <?php if ('red' == $instance['color']) echo 'selected="selected"'; ?>>Red</option>
				<option value='turquoise' <?php if ('turquoise' == $instance['color']) echo 'selected="selected"'; ?>>Turquoise</option>
				<option value='green' <?php if ('green' == $instance['color']) echo 'selected="selected"'; ?>>Green</option>
				<option value='blue' <?php if ('blue' == $instance['color']) echo 'selected="selected"'; ?>>Blue</option>
				<option value='violet' <?php if ('violet' == $instance['color']) echo 'selected="selected"'; ?>>Violet</option>
				<option value='orange' <?php if ('orange' == $instance['color']) echo 'selected="selected"'; ?>>Orange</option>
				<option value='carot' <?php if ('carot' == $instance['color']) echo 'selected="selected"'; ?>>Carot</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>">Text for intro:</label>
			<textarea class="widefat" style="width: 216px; height:100px" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $instance['text']; ?></textarea>

		</p>

		
		<p>
			<label for="<?php echo $this->get_field_id('feedburner'); ?>">Feedburner ID:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('feedburner'); ?>" name="<?php echo $this->get_field_name('feedburner'); ?>" value="<?php echo $instance['feedburner']; ?>" type="text" />
			<p style="font-size:11px"><a href="http://feedburner.google.com/" target="_blank">Register Feedburn ID?</a></p>
		</p>
		
		
	<?php
	}
}
?>