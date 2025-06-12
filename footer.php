<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>
</main>

<footer>

	<div class="footer_wrapper">
		<div class="footer_wrapper_info">
			<div class="footer_wrapper_info_logo">
				<?php
					$logo = get_field('footer_logo', 'option');
					$description = get_field('footer_description', 'option');
					$facebook = get_field('footer_facebook_url', 'option');
					$instagram = get_field('footer_instagram_url', 'option');
					$tiktok = get_field('footer_tiktok_url', 'option');
					?>
					<?php if ($logo) : ?>
						<?php echo liteimage($logo, [
							'thumb' => [0, 78],
						]); ?>
					<?php else: ?>
						<a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo" aria-label="<?php esc_attr_e('Go to homepage', 'noakirel'); ?>">
							<img src="<?php echo esc_url(assets('images/logo.svg')); ?>" alt="<?php esc_attr_e('Site logo', 'noakirel'); ?>">
						</a>
					<?php endif; ?>

					<?php if ( $description ) : ?>
						<p><?= esc_html( $description ) ?></p>
					<?php endif; ?>

					<div class="footer_wrapper_info_logo_social">
						<?php if ( $facebook ) : ?>
							<a href="<?= esc_url( $facebook ) ?>" target="_blank" rel="noopener">
								<svg class='facebook-icon' width='12' height='22' role='img' aria-label='Facebook icon'>
									<use href='<?php echo esc_url(sprite('facebook')); ?>'></use>
								</svg>
							</a>
						<?php endif; ?>
						<?php if ( $instagram ) : ?>
							<a href="<?= esc_url( $instagram ) ?>" target="_blank" rel="noopener">
								<svg class='instagram-icon' width='22' height='21' role='img' aria-label='Instagram icon'>
									<use href='<?php echo esc_url(sprite('instagram')); ?>'></use>
								</svg>
							</a>
						<?php endif; ?>
						<?php if ( $tiktok ) : ?>
							<a href="<?= esc_url( $tiktok ) ?>" target="_blank" rel="noopener">
								<svg class='tiktok-icon' width='18' height='20' role='img' aria-label='TikTok icon'>
									<use href='<?php echo esc_url(sprite('tiktok')); ?>'></use>
								</svg>
							</a>
						<?php endif; ?>
					</div>
			</div>

			<div class="footer_wrapper_info_links">
				<?php
					wp_nav_menu( array(
						'menu'            => 'Footer',
						'container'       => 'nav',
						'menu_class'      => 'footer-menu',
					) );
				?>
			</div>

			<div class="footer_wrapper_info_links">
				<?php
					wp_nav_menu( array(
						'menu'            => 'Footer 2',
						'container'       => 'nav',
						'menu_class'      => 'footer-menu',
					) );
				?>
			</div>

			<div class="footer_wrapper_info_links">
				<?php
					wp_nav_menu( array(
						'menu'            => 'Terms',
						'container'       => 'nav',
						'menu_class'      => 'footer-menu',
					) );
				?>
			</div>
		</div>
	</div>

	<div class="footer_wrapper_copyright" dir="ltr">
		<div class="footer_wrapper_copyright_text">
			<span>© 2025, Made with </span>
			<a href="https://bsx.co.il/" target="_blank">
				<svg class='bsx-link' width='56' height='22' role='img' aria-label='<?= __('Go to bsx.co.il', 'noakirel') ?>'>
					<use href='<?php echo esc_url(sprite('bsx_logo')); ?>'></use>
				</svg>
			</a>
		</div>

		<?php $payment_methods = get_field('footer_payments_method', 'option'); ?>
		<?php if ($payment_methods) : ?>
			<div class="footer_wrapper_payment">
				<?php foreach ($payment_methods as $payment_method) : ?>
					<?php echo liteimage($payment_method['image'], [
						'thumb' => [0, 25],
					]); ?>
				<?php endforeach; ?>
			</div>
		<?php endif ?>
	</div>

</footer>

<?php do_action( 'storefront_before_footer' ); ?>
<?php wp_footer(); ?>
</body>
</html>
