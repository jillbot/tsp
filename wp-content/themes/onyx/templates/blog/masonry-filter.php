<?php
global $mkd_page_id;
global $mkd_options;
global $mkd_template_name;

$blog_style = "1";
if(isset($mkd_options['blog_style'])){
	$blog_style = $mkd_options['blog_style'];
}

$filter = "no";

if(isset($mkd_options['blog_masonry_filter'])){
	$filter = $mkd_options['blog_masonry_filter'];
}

$show_filter_title = "no";

if(isset($mkd_options['blog_masonry_enable_filter_title'])){
	$show_filter_title = $mkd_options['blog_masonry_enable_filter_title'];
}

$blog_masnory_filter_class = "";

if (isset($mkd_options['blog_masonry_filter_disable_separator']) && !empty($mkd_options['blog_masonry_filter_disable_separator'])){
	if($mkd_options['blog_masonry_filter_disable_separator'] == "yes"){
		$blog_masnory_filter_class = "without_separator";
	} else {
		$blog_masnory_filter_class = "";
	}
}


$page_category = get_post_meta($mkd_page_id, "mkd_choose-blog-category", true);
if(is_category()){
	$page_category = get_query_var( 'cat' );
}
if ($page_category == "" && !is_category()) {
                $args = array(
                    'parent' => 0
                );
                $categories = get_categories( $args );
            } else {
                $args = array(
                    'parent' => $page_category
                );
                $categories = get_categories( $args );
            }
if ($filter == "yes" && count($categories) > 0) {	?>

			<div class="filter_outer filter_blog">
				<div class="filter_holder <?php echo esc_attr($blog_masnory_filter_class); ?>">
					<ul>
                        <?php if($show_filter_title == "yes"){ ?>
                            <li class='filter_title'><span><?php _e('Sort Blog:', 'mkd'); ?></span></li>
                       <?php }?>
						<li class="filter" data-filter="*"><span><?php _e('All', 'mkd'); ?></span></li>
						<?php foreach ($categories as $category) { ?>
							 <li class="filter" data-filter="<?php echo ".category-" . esc_attr($category->slug); ?>"><span><?php echo esc_html($category->name); ?></span></li>
						<?php } ?>
					</ul>
				</div>
			</div>

      <?php  }
?>
