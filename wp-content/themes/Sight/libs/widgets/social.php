<?php
add_action('widgets_init', 'social_load_widget');

function social_load_widget()
{
	register_widget('Social_Widget');
}

class Social_Widget extends WP_Widget {
	
	function Social_Widget()
	{
		$widget_ops = array('classname' => 'widget_socials', 'description' => 'Simple Socials Widget');

		$control_ops = array('id_base' => 'social-widget');

		$this->WP_Widget('social-widget', '&rArr; PressLayer: Socials', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		global $theme, $wpdb;
		extract($args);
		
		$title = $instance['title'];
		$text = $instance['text'];
		$facebook = $instance['facebook'];
		$twitter = $instance['twitter'];
		$rss_feed = $instance['rss_feed'];
		$flickr = $instance['flickr'];
		$youtube = $instance['youtube'];
		$vimeo = $instance['vimeo'];
		$linkedin = $instance['linkedin'];
		$tumblr = $instance['tumblr'];
		$dribbble = $instance['dribbble'];
		$google_plus = $instance['google_plus'];
		$pinterest = $instance['pinterest'];
		$instagram = $instance['instagram'];
		
		echo $before_widget;
		?>
		<!-- BEGIN WIDGET -->
		<?php
		if($title) {
			echo $before_title.$title.$after_title;
		}
		?>
		<div class="social_wrapper">
		<?php if($text!=''){?>
		<p><?php echo $text;?></p>
		<?php }?>
		<div class="social_inner">
			<?php if($facebook!=''){?><a href="<?php echo $facebook;?>" class="facebook" title="Facebook"></a><?php } ?>
			<?php if($twitter!=''){?><a href="https://twitter.com/<?php echo $twitter;?>" class="twitter" title="Twitter"></a><?php } ?>
			<?php if($rss_feed!=''){?><a href="<?php echo $rss_feed;?>" class="rss" title="RSS Feed"></a><?php } ?>
			<?php if($flickr!=''){?><a href="http://www.flickr.com/photos/<?php echo $flickr;?>" class="flickr" title="Flickr"></a><?php } ?>
			<?php if($youtube!=''){?><a href="http://www.youtube.com/<?php echo $youtube;?>" class="youtube" title="Youtube"></a><?php } ?>
			<?php if($vimeo!=''){?><a href="http://vimeo.com/<?php echo $vimeo;?>" class="vimeo" title="Vimeo"></a><?php } ?>
			<?php if($linkedin!=''){?><a href="<?php echo $linkedin;?>" class="linkedin" title="Linkedin"></a><?php } ?>
			<?php if($tumblr!=''){?><a href="<?php echo $tumblr;?>" class="tumblr" title="Tumblr"></a><?php } ?>
			<?php if($dribbble!=''){?><a href="http://dribbble.com/<?php echo $dribbble;?>" class="dribbble tooltip" title="Dribbble"></a><?php } ?>
			<?php if($google_plus!=''){?><a href="<?php echo $google_plus;?>" class="google_plus" title="Google_plus"></a><?php } ?>
			<?php if($pinterest!=''){?><a href="http://pinterest.com/<?php echo $pinterest;?>" class="pinterest" title="Pinterest"></a><?php } ?>
			<?php if($instagram!=''){?><a href="http://instagram.com/<?php echo $instagram;?>" class="instagram" title="Instagram"></a><?php } ?>
		
		<div class="clear"></div>
		</div></div>
		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['text'] = $new_instance['text'];
		$instance['facebook'] = $new_instance['facebook'];
		$instance['twitter'] = $new_instance['twitter'];
		$instance['rss_feed'] = $new_instance['rss_feed'];
		$instance['flickr'] = $new_instance['flickr'];
		$instance['youtube'] = $new_instance['youtube'];
		$instance['vimeo'] = $new_instance['vimeo'];
		$instance['linkedin'] = $new_instance['linkedin'];
		$instance['tumblr'] = $new_instance['tumblr'];
		$instance['dribbble'] = $new_instance['dribbble'];
		$instance['google_plus'] = $new_instance['google_plus'];
		$instance['pinterest'] = $new_instance['pinterest'];
		$instance['instagram'] = $new_instance['instagram'];
		
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Social Network');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>">Text for intro:</label>
			<textarea class="widefat" style="width: 216px; height:100px" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" ><?php echo $instance['text']; ?></textarea>
			
		</p>
		
		
		<p>
			<label for="<?php echo $this->get_field_id('facebook'); ?>">Facebook URL:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" value="<?php echo $instance['facebook']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('twitter'); ?>">Twitter Username:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" value="<?php echo $instance['twitter']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('rss_feed'); ?>">RSS Feed URL:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('rss_feed'); ?>" name="<?php echo $this->get_field_name('rss_feed'); ?>" value="<?php echo $instance['rss_feed']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('flickr'); ?>">Flickr Username:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('flickr'); ?>" name="<?php echo $this->get_field_name('flickr'); ?>" value="<?php echo $instance['flickr']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('youtube'); ?>">Youtube Username:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" value="<?php echo $instance['youtube']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('vimeo'); ?>">Vimeo Username:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('vimeo'); ?>" name="<?php echo $this->get_field_name('vimeo'); ?>" value="<?php echo $instance['vimeo']; ?>" type="text" />
		</p>

		
		<p>
			<label for="<?php echo $this->get_field_id('linkedin'); ?>">Linkedin URL:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" value="<?php echo $instance['linkedin']; ?>" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('tumblr'); ?>">Tumblr URL:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('tumblr'); ?>" name="<?php echo $this->get_field_name('tumblr'); ?>" value="<?php echo $instance['tumblr']; ?>" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('dribbble'); ?>">Dribbble Username:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('dribbble'); ?>" name="<?php echo $this->get_field_name('dribbble'); ?>" value="<?php echo $instance['dribbble']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('google_plus'); ?>">Google plus URL:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('google_plus'); ?>" name="<?php echo $this->get_field_name('google_plus'); ?>" value="<?php echo $instance['google_plus']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('pinterest'); ?>">Pinterest Username:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('pinterest'); ?>" name="<?php echo $this->get_field_name('pinterest'); ?>" value="<?php echo $instance['pinterest']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('instagram'); ?>">Instagram Username:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" value="<?php echo $instance['instagram']; ?>" type="text" />
		</p>
		
	<?php }
}

?>