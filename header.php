<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php do_action('storefront_before_site'); ?>

<!-- Skip Link for Accessibility -->
<a class="skip-link screen-reader-text" href="#main_content"><?= __('Skip to content', 'noakirel') ?></a>

<div id="page" class="hfeed site">
	<?php do_action('storefront_before_header'); ?>

	<header id="masthead" class="site-header" role="banner" style="<?php storefront_header_styles(); ?>">
		<div class="container">
			<div class="header-inner">
				<?php if (wp_is_mobile()) : ?>
					<?php
					show_burger_menu();
					show_header_logo('header_logo_mobile');
					?>
				<?php else : ?>
					<nav class="header-menu-wrapper" role="navigation" aria-label="Main Navigation">
						<?php
						wp_nav_menu([
							'menu' => 'Main menu',
							'container' => false,
							'menu_class' => 'header-menu',
							'menu_id' => 'main-menu',
							'fallback_cb' => false,
						]);
						?>
					</nav>
					<?php show_header_logo('header_logo'); ?>
				<?php endif; ?>

				<div class="header-actions">
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
					<?php echo do_shortcode('[instantio-cart-icon]'); ?>
				</div>
			</div>
		</div>
	</header>

	<?php do_action('storefront_before_content'); ?>
	<main id="main_content" class="main-content">
		<?php do_action('storefront_content_top'); ?>