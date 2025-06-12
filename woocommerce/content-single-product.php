<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'noakirel-single-product', $product ); ?>>

<?php
// Get main product image (thumbnail)
$thumbnail_id = $product->get_image_id();

// Get gallery images
$gallery_image_ids = $product->get_gallery_image_ids();
?>

<div class="two-columns">
	<div class="column-side noa-single-summary">
		<div class="noa-product-summary">
			<?php
			// Display product title
			woocommerce_template_single_title();

			// Display product price
			woocommerce_template_single_price();
			?>
			<form class="cart" action="<?php echo esc_url($product->add_to_cart_url()); ?>" method="post" enctype="multipart/form-data">
					<input type="hidden" name="quantity" value="1" />
					<button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt noa-single-add-to-cart">
						<?php echo __('הוסף לעגלה ', 'noakirel') ?>
						<svg class='cart-icon' width='26' height='26' role='img' aria-label='<?php echo __('הוסף לעגלה ', 'noakirel') ?>'>
							<use href='<?php echo esc_url(sprite('cart')); ?>'></use>
						</svg>
					</button>
			</form>

			<?php
			$list = [];

			$content_text = get_the_content();
			if (!empty($content_text)) {
					$list[] = [
							'title' => __('תיאור', 'noakirel'),
							'text' => $content_text
					];
			}

			$ingredients_text = get_field('ingredients');
			if (!empty($ingredients_text)) {
					$list[] = [
							'title' => __('מרכיבים', 'noakirel'),
							'text' => $ingredients_text
					];
			}
			?>
			<?php if ($list) : ?>
				<div class="faq-section" role="region" aria-label="<?php echo esc_attr__('Frequently Asked Questions', 'noakirel'); ?>">
					<?php echo display_product_accordion($list); ?>
				</div>
			<?php endif ?>
		</div>
	</div>

	<div class="column-side noa-single-images">
		<?php if ($thumbnail_id) : ?>
			<?php echo liteimage($thumbnail_id, [
				'thumb' => [1050, 0],
				'max' => ['992' => [992, 0], '768' => [768, 0], '480' => [480, 0], '320' => [320, 0]],
				'args' => ['class' => 'product-image main-image'],
			]); ?>
		<?php endif; ?>
		<?php if ($gallery_image_ids) : ?>
			<?php foreach ($gallery_image_ids as $image_id) : ?>
				<div class="gallery-image-item">
					<?php if ($image_id) : ?>
						<?php $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: __('Image', 'textdomain'); ?>
						<?php echo liteimage($image_id, [
							'thumb' => [1050, 0],
							'max' => ['992' => [992, 0], '768' => [768, 0], '480' => [480, 0], '320' => [320, 0]],
							'args' => ['class' => 'product-image gallery-image'],
						]); ?>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
