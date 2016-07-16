<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $mkd_options;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$products_list_type = 'type1';
if(isset($mkd_options['woo_products_list_type'])){
	$products_list_type = $mkd_options['woo_products_list_type'];
}

$product_image_src =  wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');

$woo_products_enable_lighbox_icon_yes_no = "yes";

if(isset($mkd_options['woo_products_enable_lighbox_icon'])){
	$woo_products_enable_lighbox_icon_yes_no =  $mkd_options['woo_products_enable_lighbox_icon'];
}

$hide_separator = "no";
if(isset($mkd_options['woo_products_title_separator_hide_title_separator'])){
	$hide_separator = $mkd_options['woo_products_title_separator_hide_title_separator'];
}

?>

<?php switch($products_list_type) { 
	
	case 'type1': ?>
	<li <?php post_class(); ?>>
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
			<div class="top-product-section">
				<a href="<?php the_permalink(); ?>">
					<span class="image-wrapper">
					<?php
						/**
						 * woocommerce_before_shop_loop_item_title hook
						 *
						 * @hooked woocommerce_show_product_loop_sale_flash - 10
						 * @hooked woocommerce_template_loop_product_thumbnail - 10
						 */
						do_action( 'woocommerce_before_shop_loop_item_title' );
					?>
					</span>
				</a>
				<?php do_action('mkd_woocommerce_after_product_image'); ?>
			</div>
			<div class="product_info_box">
				<span class="product-categories">
					<?php echo wp_kses($product->get_categories(), array(
						'a' => array(
							'href' => true,
							'rel' => true,
							'class' => true,
							'title' => true,
							'id' => true
						)
					)); ?>
				</span>
				<a href="<?php the_permalink(); ?>" class="product-category">            
					<span class="product-title"><?php the_title(); ?></span>
				</a>
				<?php if($hide_separator == "no") { ?>
					<div class="separator_holder"><span class="separator medium"></span></div>
				<?php } ?>
				<div class="shop_price_lightbox_holder">
					<?php
						/**
						 * woocommerce_after_shop_loop_item_title hook
						 *
						 * @hooked woocommerce_template_loop_rating - 5
						 * @hooked woocommerce_template_loop_price - 10
						 */
						do_action( 'woocommerce_after_shop_loop_item_title' );
					?>
					<?php if($woo_products_enable_lighbox_icon_yes_no == "yes") { ?>
						<div class="shop_lightbox">
							<a class="product_lightbox" title="<?php echo esc_attr(the_title()); ?>" href="<?php echo esc_url($product_image_src[0]); ?>" data-rel="prettyPhoto[single_pretty_photo]">
								<span class="fa-search"></span>
							</a>
						</div>
					<?php } ?>
				</div>				
			</div>
			<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</li>

<?php break; 
case 'type4': ?>  
	<li <?php post_class(); ?>>				
		
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>	
			
			<div class="top-product-section">
				<a class="product_image_overlay" href="<?php the_permalink(); ?>"></a>
				<?php if(isset($mkd_options['woo_products_enable_lighbox_icon']) && $mkd_options['woo_products_enable_lighbox_icon'] == "yes") {?>
					<div class="product_hover_wrapper"> <!--	This div is used for lightbox icon(lighbox icon is showing on hover) -->
						<div class="product_hover_wrapper_inner">
							<div class="shop_lightbox">
								<a class="product_lightbox" title="<?php echo esc_attr(the_title()); ?>" href="<?php echo esc_url($product_image_src[0]); ?>" data-rel="prettyPhoto[single_pretty_photo]">
									<span class="icon_plus"></span>
								</a>
							</div>
						</div>	
					</div>
				<?php } ?>	
				
				<a href="<?php the_permalink(); ?>">
					<span class="image-wrapper">
						<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
					</span>
				</a>
				
			</div>
			<div class="product_info_box">
				<div class="info_left_section">
					<span class="product-categories">
						<?php echo wp_kses($product->get_categories(), array(
							'a' => array(
								'href' => true,
								'rel' => true,
								'class' => true,
								'title' => true,
								'id' => true
							)
						)); ?>
					</span>
					<a href="<?php the_permalink(); ?>" class="product-category">
						<span class="product-title"><?php the_title(); ?></span>
						<?php if($hide_separator == "no") { ?>
							<div class="separator_holder"><span class="separator medium"></span></div>
						<?php } ?>	
						<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>							
					</a>
				</div>
				<div class="info_right_section">
					<?php do_action('mkd_woocommerce_after_product_image'); ?>
				</div>	
			</div>
			<?php  do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</li>	
<?php break; } ?>