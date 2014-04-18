<?php
add_action('widgets_init', 'recent_posts_load');

function recent_posts_load()
{
	register_widget('Recent_Posts');
}

class Recent_Posts extends WP_Widget {
	
	function Recent_Posts()
	{
		$widget_ops = array('classname' => 'recent_posts', 'description' => 'Get latest posts from your blog.');

		$control_ops = array('id_base' => 'recent_posts');

		$this->WP_Widget('recent_posts', '&rArr; PressLayer: Recent Posts', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		global $theme;
		extract($args);
		
		$title = $instance['title'];
		$categories = $instance['categories'];
		$post_count = $instance['post_count'];
		$title_length = $instance['title_length'];
		$show_excerpt = $instance['show_excerpt'];
		$excerpt_length = $instance['excerpt_length'];
		$show_time = $instance['show_time'];
		
		
		echo $before_widget;
		?>
		<!-- BEGIN WIDGET -->
		<?php
		if($title) echo $before_title.$title.$after_title;
		
		echo recent_post($categories, $post_count, $title_length, $show_excerpt, $excerpt_length, $show_time);

		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		$instance['title'] = $new_instance['title'];
		$instance['categories'] = $new_instance['categories'];
		$instance['post_count'] = $new_instance['post_count'];
		$instance['title_length'] = $new_instance['title_length'];
		$instance['show_excerpt'] = $new_instance['show_excerpt'];
		$instance['excerpt_length'] = $new_instance['excerpt_length'];
		$instance['show_time'] = $new_instance['show_time'];

		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Recent Posts', 'categories' => 'all', 'post_count' => 3, 'title_length' => 5, 'show_excerpt' => 'on', 'excerpt_length' => 10, 'show_time' => 'on');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" type="text" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('categories'); ?>">Post Category:</label> 
			<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>All categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('post_count'); ?>">Number of posts:</label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('post_count'); ?>" name="<?php echo $this->get_field_name('post_count'); ?>" value="<?php echo $instance['post_count']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('title_length'); ?>">Length of title (words):</label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('title_length'); ?>" name="<?php echo $this->get_field_name('title_length'); ?>" value="<?php echo $instance['title_length']; ?>" type="text" />
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_excerpt'], 'on'); ?> id="<?php echo $this->get_field_id('show_excerpt'); ?>" name="<?php echo $this->get_field_name('show_excerpt'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_excerpt'); ?>">Show excerpt</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('excerpt_length'); ?>">Length of excerpt (words):</label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('excerpt_length'); ?>" name="<?php echo $this->get_field_name('excerpt_length'); ?>" value="<?php echo $instance['excerpt_length']; ?>" type="text" />
		</p>

		
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_time'], 'on'); ?> id="<?php echo $this->get_field_id('show_time'); ?>" name="<?php echo $this->get_field_name('show_time'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_time'); ?>">Show Time</label>
		</p>
		
	<?php }
}

?>