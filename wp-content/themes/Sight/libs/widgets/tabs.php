<?php
add_action('widgets_init', 'tab_widget_load');

function tab_widget_load()
{
	register_widget('Tab_Widget');
}

class Tab_Widget extends WP_Widget {
	
	function Tab_Widget()
	{
		$widget_ops = array('classname' => 'tab_widget', 'description' => 'Popular posts, comments and tags tabbed widget.');

		$control_ops = array('id_base' => 'tab_widget');

		$this->WP_Widget('tab_widget', '&rArr; PressLayer: Tab', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		global $options;
		extract($args);
		
		// Common
		$show_post = $instance['show_post'];
		$show_comment = $instance['show_comment'];
		$show_tag = $instance['show_tag'];
		
		// Post
		$post_title = trim($instance['post_title']);
		$categories = $instance['categories'];
		$post_count = $instance['post_count'];
		$title_length = $instance['title_length'];
		$show_excerpt = $instance['show_excerpt'];
		$excerpt_length = $instance['excerpt_length'];
		$show_time = $instance['show_time'];
		
		// Comment
		$comment_title = trim($instance['comment_title']);
		$comment_count = $instance['comment_count'];
		$comment_length = $instance['comment_length'];
		$show_comment_time = $instance['show_comment_time'];
		
		// Tag
		$tag_title = trim($instance['tag_title']);
		$tag_count = trim($instance['tag_count']);
		
		echo $before_widget;
	
		?>
		
		<script type="text/javascript">
		jQuery(document).ready(function($){	
			$('#tab_wrapper_<?php echo $args['widget_id'];?>').each(function() {
				$(this).find(".tab_content").hide();
				$(this).find("ul.tab_menu li:first").addClass("active").show(); 
				$(this).find(".tab_content:first").show();
			});
			
			$("ul.tab_menu li").click(function(e) {
				$(this).parents('#tab_wrapper_<?php echo $args['widget_id'];?>').find("ul.tab_menu li").removeClass("active"); 
				$(this).addClass("active");
				$(this).parents('#tab_wrapper_<?php echo $args['widget_id'];?>').find(".tab_content").hide();
		
				var activeTab = $(this).find("a").attr("href");
				$(this).parents('#tab_wrapper_<?php echo $args['widget_id'];?>').find(activeTab).fadeIn();
				
				e.preventDefault();
			});
			
			$("ul.tab_menu li a").click(function(e) {
				e.preventDefault();
			})
		});
		</script>
		
		<!-- BEGIN WIDGET -->
		<div class="tab_wrapper" id="tab_wrapper_<?php echo $args['widget_id'];?>">
			
			<ul class="tab_menu"><?php if($show_post == 'on'): ?><li class="tab_post"><a href="#post_tab"><?php echo $post_title; ?></a></li><?php endif; ?><?php if($show_comment == 'on'): ?><li  class="tab_comment"><a href="#comment_tab"><?php echo $comment_title; ?></a></li><?php endif; ?><?php if($show_tag == 'on'): ?><li class="tab_tag"><a href="#tag_tab"><?php echo $tag_title; ?></a></li><?php endif; ?></ul>
			<div class="clear"></div>
			<div class="tabs_container">
			
				<?php if($show_post == 'on'): ?>
					<div id="post_tab" class="tab_content recent_posts">
					<?php echo recent_post($categories, $post_count, $title_length, $show_excerpt, $excerpt_length, $show_time);?>
					</div>
				<?php endif; ?>
				
				<?php if($show_comment == 'on'): ?>
				<div id="comment_tab" class="tab_content recent_comments">
					<?php echo recent_comment($comment_count, $comment_length, $show_comment_time); ?>
				</div>
				<?php endif; ?>
				
				<?php if($show_tag == 'on'): ?>
				<div id="tag_tab" class="tab_content">
					<div class="tagcloud">
					<?php
					$tags = get_tags(array('number' => $tag_count, 'pad_counts'=> true ,'orderby' => 'count', 'order' => 'DESC'));
					foreach ((array) $tags as $tag) {
					?>
					<?php echo '<a href="' . get_tag_link ($tag->term_id) . '" rel="tag">' . $tag->name .' ('. $tag->count  . ')</a>';	?>
					<?php } ?>
					
					<div class="clear"></div>
					</div>
					
				</div>
				<?php endif; ?>
				
			</div>
		
		</div>
		<!-- END WIDGET -->
		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		
		// Common
		$instance['show_post'] = $new_instance['show_post'];
		$instance['show_comment'] = $new_instance['show_comment'];
		$instance['show_tag'] = $new_instance['show_tag'];
		
		// Post
		$instance['post_title'] = $new_instance['post_title'];
		$instance['categories'] = $new_instance['categories'];
		$instance['post_count'] = $new_instance['post_count'];
		$instance['title_length'] = $new_instance['title_length'];
		$instance['show_excerpt'] = $new_instance['show_excerpt'];
		$instance['excerpt_length'] = $new_instance['excerpt_length'];
		$instance['show_time'] = $new_instance['show_time'];
		
		// Comment
		$instance['comment_title'] = $new_instance['comment_title'];
		$instance['comment_count'] = $new_instance['comment_count'];
		$instance['comment_length'] = $new_instance['comment_length'];
		$instance['show_comment_time'] = $new_instance['show_comment_time'];
		
		// Tag
		$instance['tag_title'] = $new_instance['tag_title'];
		$instance['tag_count'] = $new_instance['tag_count'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('show_post' => 'on','show_comment' => 'on','show_tag' => 'on', 'post_title' => 'Posts', 'categories' => 'all', 'post_count' => 3, 'title_length' => 5, 'show_excerpt' => 'on', 'excerpt_length' => 10, 'show_time' => 'on','comment_title' => 'Comments','comment_count' => 5,'comment_length' => 10, 'show_comment_time' => 'on','tag_title' => 'Tags', 'tag_count' => 20 );
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_post'], 'on'); ?> id="<?php echo $this->get_field_id('show_post'); ?>" name="<?php echo $this->get_field_name('show_post'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_post'); ?>">Show post</label>
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_comment'], 'on'); ?> id="<?php echo $this->get_field_id('show_comment'); ?>" name="<?php echo $this->get_field_name('show_comment'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_post'); ?>">Show comment</label>
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_tag'], 'on'); ?> id="<?php echo $this->get_field_id('show_tag'); ?>" name="<?php echo $this->get_field_name('show_tag'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_tag'); ?>">Show tag</label>
		</p>
		
		<hr />
		<h3>Post</h3>
		<p>
			<label for="<?php echo $this->get_field_id('post_title'); ?>">Post title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('post_title'); ?>" name="<?php echo $this->get_field_name('post_title'); ?>" value="<?php echo $instance['post_title']; ?>" type="text" />
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
			<label for="<?php echo $this->get_field_id('show_time'); ?>">Show time</label>
		</p>
		
		<h3>Comments</h3>
		
		<p>
			<label for="<?php echo $this->get_field_id('comment_title'); ?>">Comment title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('comment_title'); ?>" name="<?php echo $this->get_field_name('comment_title'); ?>" value="<?php echo $instance['comment_title']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('comment_count'); ?>">Number of comments:</label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('comment_count'); ?>" name="<?php echo $this->get_field_name('comment_count'); ?>" value="<?php echo $instance['comment_count']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('comment_length'); ?>">Length of comment (words):</label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('comment_length'); ?>" name="<?php echo $this->get_field_name('comment_length'); ?>" value="<?php echo $instance['comment_length']; ?>" type="text" />
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_comment_time'], 'on'); ?> id="<?php echo $this->get_field_id('show_comment_time'); ?>" name="<?php echo $this->get_field_name('show_comment_time'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_comment_time'); ?>">Show comment time</label>
		</p>
		
		<h3>Tags</h3>
		
		<p>
			<label for="<?php echo $this->get_field_id('tag_title'); ?>">Tag title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('tag_title'); ?>" name="<?php echo $this->get_field_name('tag_title'); ?>" value="<?php echo $instance['tag_title']; ?>" type="text" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('tag_count'); ?>">Tag count:</label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('tag_count'); ?>" name="<?php echo $this->get_field_name('tag_count'); ?>" value="<?php echo $instance['tag_count']; ?>" type="text" />
		</p>

		
	<?php }
}
?>