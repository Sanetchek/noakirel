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
					$social = get_field('social', 'option');

					if ( $social ) :
						$logo = $social['logo'];
						$description = $social['description'];
						$facebook = $social['facebook'];
						$instagram = $social['instagram'];
						$tiktok = $social['tik_tok'];
					?>
						<?php if ( $logo ) : ?>
							<img src="<?= esc_url( $logo ) ?>" alt="logo">
						<?php endif; ?>

						<?php if ( $description ) : ?>
							<p><?= esc_html( $description ) ?></p>
						<?php endif; ?>

						<div class="footer_wrapper_info_logo_social">
							<?php if ( $facebook ) : ?>
								<a href="<?= esc_url( $facebook ) ?>" target="_blank" rel="noopener"><img src="/wp-content/uploads/2025/04/Vector-1.png" alt="Facebook"></a>
							<?php endif; ?>
							<?php if ( $instagram ) : ?>
								<a href="<?= esc_url( $instagram ) ?>" target="_blank" rel="noopener"><img src="/wp-content/uploads/2025/04/Group.png" alt="Instagram"></a>
							<?php endif; ?>
							<?php if ( $tiktok ) : ?>
								<a href="<?= esc_url( $tiktok ) ?>" target="_blank" rel="noopener"><img src="/wp-content/uploads/2025/04/Vector-1-2.png" alt="TikTok"></a>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php
					$product_id = 77;
					$product = wc_get_product($product_id);
					?>

					<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
						data-quantity="1"
						class="btn_add add_to_cart_button ajax_add_to_cart"
						data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
						data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
						aria-label="<?php echo esc_html( $product->add_to_cart_description() ); ?>"
						rel="nofollow">

						<span class="btn-text">קנו עכשיו</span>
						<span class="btn-icon">
							<span class="icon-cart"><img src="https://noakirel.co/wp-content/uploads/2025/04/Link.svg" alt="asd"></span>
							<span class="icon-check" style="display:none;">✔️</span>
						</span>
					</a>
			</div>

			<div class="footer_wrapper_info_links">
				<h2>SIGNATURE BY NOA KIREL</h2>
				<?php
					wp_nav_menu( array(
						'menu'            => 'Footer',
						'container'       => 'nav',
						'menu_class'      => 'main-menu',
					) );
				?>
			</div>

			<div class="footer_wrapper_info_links">
				<?php
					wp_nav_menu( array(
						'menu'            => 'Terms',
						'container'       => 'nav',
						'menu_class'      => 'main-menu',
					) );
				?>
			</div>
			<div class="footer_wrapper_info_links">
				<h2>ניוזלטר</h2>
				<p>הישאר מעודכן עם הקולקציות החדשות, המוצרים וההצעות הבלעדיות.</p>
				<form class="form" action="#" method="post">
					<input type="email" name="" value="" placeholder="האימייל שלך">
					<button class="send" type="button" name="button">
						<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
							<path d="M9.375 12.1875L4.6875 7.5L9.375 2.8125" stroke="#0B0B0B" stroke-width="0.9375" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</button>
				</form>
			</div>
		</div>

		<div class="footer_wrapper_copyright">
			<span>2025 © </span>
			<span>Made with </span>
			<a href="https://bsx.co.il/" target="_blank"> <img src="/wp-content/uploads/2025/05/logo2.png" alt="log"></a>
		</div>
	</div>

</footer>

<?php do_action( 'storefront_before_footer' ); ?>
<?php wp_footer(); ?>
</body>
</html>
