<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

// Get the queried object (e.g., product category term or shop page)
$queried_object = get_queried_object();
$object_id = is_a( $queried_object, 'WP_Term' ) ? 'product_cat_' . $queried_object->term_id : ( is_shop() ? wc_get_page_id( 'shop' ) : null );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' ); ?>

<div class="shop-header">
	<div class="two-columns">
		<div class="column-side">
			<?php
				$image_id = get_field( 'image', $object_id );
				$link = get_field( 'link', $object_id );
				display_shop_head_image($link, $image_id);
			?>
		</div>

		<div class="column-side">
			<?php $gallery = get_field( 'gallery', $object_id ); ?>
			<?php if ($gallery) : ?>
				<div id="shop_gallery" class="shop-gallery swiper-container" role="region" aria-label="<?= __('Image gallery', 'noakirel') ?>">
					<div class="swiper-wrapper">
						<?php foreach ($gallery as $item) : ?>
							<div class="swiper-slide">
								<?php
									$image_id = $item['image'];
									$link = $item['link'];
									display_shop_head_image($link, $image_id);
								?>
							</div>
						<?php endforeach ?>
					</div>
					<div class="swiper-shop-prev">
						<svg width="13" height="22" viewBox="0 0 13 22" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M0.448108 11.9809L9.84921 21.3555C10.4472 21.9522 11.4168 21.9522 12.0146 21.3555C12.6123 20.7594 12.6123 19.7926 12.0146 19.1965L3.69603 10.9014L12.0143 2.6065C12.6121 2.01014 12.6121 1.04339 12.0143 0.44727C11.4165 -0.14909 10.447 -0.14909 9.84896 0.44727L0.447865 9.82208C0.148974 10.1203 -0.000302315 10.5107 -0.000302315 10.9013C-0.000302315 11.2921 0.149265 11.6828 0.448108 11.9809Z" fill="#1F1F1F" />
						</svg>
					</div>
        			<div class="swiper-shop-next">
						<svg width="14" height="22" viewBox="0 0 14 22" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12.5831 9.82234L3.18204 0.447678C2.58402 -0.148973 1.61443 -0.148973 1.0167 0.447678C0.418914 1.0438 0.418914 2.01064 1.0167 2.60671L9.33522 10.9019L1.01694 19.1967C0.419156 19.7931 0.419156 20.7598 1.01694 21.356C1.61472 21.9523 2.58426 21.9523 3.18229 21.356L12.5834 11.9811C12.8823 11.6829 13.0316 11.2925 13.0316 10.9019C13.0316 10.5111 12.882 10.1204 12.5831 9.82234Z" fill="#1F1F1F" />
						</svg>
					</div>
				</div>
			<?php endif ?>
		</div>
	</div>
</div>

<?php echo '<div class="container">'; ?>

<h1 class="shop-title"><?= __('בשמים', 'noakirel') ?> <span class="product-count"><?php echo display_product_count() ?></span></h1>
<p class="shop-description"><?= __('קולקציית הבשמים של נועה קירל', 'noakirel') ?></p>

<?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	echo '<div class="clearfix"></div>';
	echo '<div class="products three-columns">';

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	echo '</div>';

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

// echo '</div>';
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );


get_footer( 'shop' );
