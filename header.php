<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php do_action( 'storefront_before_site' ); ?>

<div id="page" class="hfeed site">
	<?php do_action( 'storefront_before_header' ); ?>

	<header id="masthead" class="site-header" role="banner" style="<?php storefront_header_styles(); ?>">
		<div class="header-inner">
			<button class="menu-toggle" aria-controls="main-menu" aria-expanded="false">
				<span class="hamburger-bar"></span>
				<span class="hamburger-bar"></span>
				<span class="hamburger-bar"></span>
			</button>

			<div class="cart_home">
				<?php
					wp_nav_menu( array(
						'menu'            => 'Main menu',
						'container'       => 'nav',
						'container_class' => 'main-menu-wrapper',
						'menu_class'      => 'main-menu',
					) );
				?>
				<?php echo do_shortcode('[instantio-cart-icon]'); ?>
			</div>
		</div>
		<div class="logo_mobile">
			<a href="/"><img src="/wp-content/uploads/2025/05/Isolation_Mode-2.svg" alt="sss"></a>
		</div>
	</header>
	<script>
	document.addEventListener('DOMContentLoaded', function () {
		const toggleButton = document.querySelector('.menu-toggle');
		const menuWrapper = document.querySelector('.main-menu-wrapper');
		const menuLinks = document.querySelectorAll('.main-menu-wrapper a[href^="#"]');

		if (toggleButton && menuWrapper) {
			toggleButton.addEventListener('click', function () {
				menuWrapper.classList.toggle('active');
				toggleButton.classList.toggle('active');
			});

			menuLinks.forEach(function (link) {
				link.addEventListener('click', function () {
					menuWrapper.classList.remove('active');
					toggleButton.classList.remove('active');
				});
			});
		}
	});
	</script>



	<?php
	do_action( 'storefront_before_content' );
	?>


		<?php
		do_action( 'storefront_content_top' );
