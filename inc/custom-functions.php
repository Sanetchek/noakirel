<?php

/**
 * Returns the URL to a specific asset within the theme.
 *
 * @param string $source The relative path to the asset from the theme root.
 * @return string The full URL to the asset.
 */
function assets($source = '')
{
	return get_template_directory_uri() . '/assets/' . $source;
}

/**
 * Returns the URL to a specific icon within the sprite sheet.
 *
 * @param string $icon_id The identifier of the icon within the sprite sheet.
 * @return string The full URL to the icon in the sprite sheet.
 */
function sprite($icon_id = '') {
	return get_template_directory_uri() . '/assets/images/sprite.svg#' . $icon_id;
}


/**
 * Returns an HTML image element for the given attachment ID, or nothing if no ID is given.
 *
 * @param int $img The attachment ID of the image to display.
 * @param string $thumb The image size to use. Default is 'large'.
 * @param array $attr Additional attributes to add to the image element.
 * @return string The image element HTML.
 */
function get_image($img = '', $thumb = 'large', $attr = [])
{
	return wp_get_attachment_image($img, $thumb, '', $attr);
}


/**
 * Echoes an image based on the given attachment ID, or nothing if no ID is given.
 *
 * @param int $img The attachment ID of the image to display.
 * @param string $thumb The size of the image to display.
 * @param array $attr An array of attributes to add to the image tag.
 */
function show_image($img = '', $thumb = 'large', $attr = [])
{
	if ($img) {
		echo wp_get_attachment_image($img, $thumb, '', $attr);
	}
}

/**
 * Includes a template part with the given name and arguments.
 *
 * @param string $file_name The name of the template part to include.
 * @param array $args An array of arguments to pass to the template part.
 */
function part($file_name = '', $args = []) {
	get_template_part( "template-parts/{$file_name}", '', $args );
}

/**
 * Displays the site header logo as an anchor link to the homepage.
 *
 * Retrieves the logo URL from an ACF field or defaults to a specified asset path.
 * Outputs an HTML anchor element containing the logo image linking to the homepage.
 *
 * @param string $acf_logo_field The ACF field name for the logo. Defaults to 'header_logo'.
 */
function show_header_logo($acf_logo_field = 'header_logo') {
	$logo = get_field($acf_logo_field, 'option') ?? assets('images/logo.svg');
	?>
	<a href="<?php echo esc_url(home_url('/')); ?>" class="header-logo" aria-label="<?php esc_attr_e('Go to homepage', 'noakirel'); ?>">
		<img src="<?php echo esc_url($logo); ?>" alt="<?php esc_attr_e('Site logo', 'noakirel'); ?>">
	</a>
	<?php
}

/**
 * Outputs a hamburger menu toggle button.
 *
 * The button is an aria-enabled toggle button that controls the visibility of the
 * main menu. The button contains three span elements that make up the hamburger
 * menu icon.
 */
function show_burger_menu() {
	?>
	<button class="menu-toggle" aria-controls="main-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle menu', 'noakirel'); ?>">
		<span class="screen-reader-text"><?php esc_html_e('Menu', 'noakirel'); ?></span>
		<span class="hamburger-bar" aria-hidden="true"></span>
		<span class="hamburger-bar" aria-hidden="true"></span>
		<span class="hamburger-bar" aria-hidden="true"></span>
	</button>
	<?php
}

/**
 * Outputs links to the site search, favorites, and user profile pages.
 *
 * @param bool $is_show Whether to show the links. Defaults to false.
 */
function show_header_links($is_show = false) {
	if (!$is_show) return;
	?>
	<a href="#" class="header-search" aria-label="Search the site">
		<svg class="header-search-icon" width="22" height="22" role="img" aria-label="Search icon">
			<use href="<?php echo esc_url(sprite('search')); ?>"></use>
		</svg>
	</a>
	<a href="/favorites" class="header-favorites" aria-label="View favorites">
		<svg class="header-favorites-icon" width="24" height="20" role="img" aria-label="Favorites icon">
			<use href="<?php echo esc_url(sprite('heart')); ?>"></use>
		</svg>
	</a>
	<a href="/my-account" class="header-profile" aria-label="View user profile">
		<svg class="header-profile-icon" width="24" height="20" role="img" aria-label="Profile icon">
			<use href="<?php echo esc_url(sprite('user')); ?>"></use>
		</svg>
	</a>
	<?php
}

/**
 * Renders a link to a product's thumbnail image.
 *
 * The function takes a product ID as its argument and returns an HTML string
 * containing a link to the product's thumbnail image. The link is wrapped in an
 * anchor element with the class `product-thumb-wrapper`.
 *
 * If the product has a thumbnail image, it is displayed as the first image in
 * the link. If the product has additional gallery images, the first gallery
 * image is displayed as the second image in the link, which is displayed when
 * the user hovers over the link.
 *
 * @param int $product_id The ID of the product to render the thumbnail link for.
 * @return string The HTML string containing the link to the product's thumbnail
 *                image.
 */
function render_product_thumbnail_link( $product_id, $thumb = [0, 370] ) {
	if ( ! $product_id ) return;

	$product = wc_get_product( $product_id );
	if ( ! $product ) return;

	$thumbnail_id = $product->get_image_id();
	$gallery_ids = $product->get_gallery_image_ids();
	$product_name = $product->get_name();

	ob_start(); ?>
	<a
		href="<?php echo esc_url( get_permalink( $product_id ) ); ?>"
		class="product-thumb-wrapper"
		aria-label="<?php echo esc_attr( $product_name ); ?>"
	>
		<?php if ( $thumbnail_id ) : ?>
			<?php echo liteimage( $thumbnail_id, [
				'thumb' => $thumb,
				'args'  => [
					'class' => 'product-thumb-first',
					'loading' => 'eager',
				],
			] ); ?>
		<?php else : ?>
			<img
				src="<?php echo esc_url( wc_placeholder_img_src() ); ?>"
				alt="<?php echo esc_attr( $product_name ); ?>"
				class="product-thumb-first"
			/>
		<?php endif; ?>

		<?php if ( ! empty( $gallery_ids ) ) : ?>
			<?php echo liteimage( $gallery_ids[0], [
				'thumb' => $thumb,
				'args'  => [ 'class' => 'product-thumb-hovered' ],
			] ); ?>
		<?php endif; ?>
	</a>
	<?php
	return ob_get_clean();
}

/**
 * Renders an HTML string for a product item in the homepage template.
 *
 * The function takes a product ID as its argument and returns an HTML string
 * containing a product item element with a thumbnail image, title, and price.
 *
 * @param int $product_id The ID of the product to render the item for.
 * @return string The HTML string containing the product item element.
 */
function render_home2_product_item( $product_id, $thumb = [0, 370] ) {
	if ( ! $product_id ) return;

	$product = wc_get_product( $product_id );
	if ( ! $product ) return;

	ob_start(); ?>
	<div class="home2-product-item">
		<div class="home2-product-image">
			<?php echo render_product_thumbnail_link( $product_id, $thumb ); ?>
		</div>
		<h3 class="home2-product-title">
			<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>">
				<?php echo esc_html( $product->get_name() ); ?>
			</a>
		</h3>
		<div class="home2-product-price">
			<?php echo $product->get_price_html(); ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Renders an accordion element for a product page.
 *
 * The function takes an array of items as its argument and returns an HTML string
 * containing an accordion element with a title and content for each item in the
 * array. The first item in the array is expanded by default.
 *
 * @param array $list An array of items to render in the accordion.
 * @return string The HTML string containing the accordion element.
 */
function display_product_accordion($list) {
	ob_start(); // Start output buffering

	if ($list) :
	?>
		<div class="accordion" role="presentation">
			<?php foreach ($list as $key => $item) : ?>
				<?php $first = ($key === 0); ?>
				<div class="accordion-item <?php echo $first ? 'active' : ''; ?>" role="region">
					<button class="accordion-title"
							aria-expanded="<?php echo $first ? 'true' : 'false'; ?>"
							aria-controls="accordion-content-<?php echo sanitize_title($item['title']); ?>">
						<span class="accordion-title-text"><?= esc_html($item['title']) ?></span>
						<span class="accordion-icon-plus">
							<svg class="accordion-icon" width="12" height="12" role="img" aria-label="<?php echo esc_attr__('Expansion Icon', 'noakirel'); ?>">
								<use href="<?php echo esc_url(sprite('plus')); ?>"></use>
							</svg>
						</span>
						<span class="accordion-icon-minus">
							<svg class="accordion-icon" width="12" height="12" role="img" aria-label="<?php echo esc_attr__('Close Icon', 'noakirel'); ?>">
								<use href="<?php echo esc_url(sprite('minus')); ?>"></use>
							</svg>
						</span>
					</button>
					<div class="accordion-content"
							id="accordion-content-<?php echo sanitize_title($item['title']); ?>"
							role="region"
							aria-hidden="<?php echo $first ? 'false' : 'true'; ?>">
						<p><?= $item['text'] ?></p>
					</div>
				</div>
				<?php
			endforeach; ?>
		</div>
	<?php
	endif;

	return ob_get_clean(); // Return the buffered output
}