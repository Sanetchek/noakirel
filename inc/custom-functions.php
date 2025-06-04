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