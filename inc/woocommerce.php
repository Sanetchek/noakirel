<?php
/**
 * Add WooCommerce support
 *
 * @return void
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')) ) ) {
  /**
   * Add Woocommerce Support to site
   *
   * Adds support for various WooCommerce features:
   * - `woocommerce` - The base Woocommerce integration.
   * - `wc-product-gallery-lightbox` - Enables the lightbox when viewing product images.
   * - `wc-product-gallery-slider` - Enables the product image slider.
   *
   * @since 1.0.0
   * @return void
   */
  function add_woocommerce_support()
  {
    // Add Woocommerce Support to site
    add_theme_support('woocommerce');
    // add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
  }
  add_action('after_setup_theme', 'add_woocommerce_support');

  /**
   * AJAX handler to update cart quantity.
   *
   * Expects POST data:
   * - `cart_item_key`: The cart item key.
   * - `quantity`: The new quantity.
   *
   * Returns a JSON response:
   * - Success: `{"success": true}`
   * - Error: `{"success": false}`
   */
  function custom_update_cart_quantity() {
    if (isset($_POST['cart_item_key']) && isset($_POST['quantity'])) {
      $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
      $quantity = intval($_POST['quantity']);

      if ($quantity > 0) {
        WC()->cart->set_quantity($cart_item_key, $quantity);
        WC()->cart->calculate_totals();
        wp_send_json_success();
      } else {
        wp_send_json_error();
      }
    }
    wp_send_json_error();
  }
  add_action('wp_ajax_update_cart_quantity', 'custom_update_cart_quantity');
  add_action('wp_ajax_nopriv_update_cart_quantity', 'custom_update_cart_quantity');

  // Add contact form to checkout
  add_action('woocommerce_checkout_after_customer_details', function() {
    echo do_shortcode('[contact-form-7 id="5a61448" title="Checkout mail list"]');
  });

  /**
   * Add conversion script to thank you page.
   *
   * @param int $order_id The order ID.
   */
  function add_conversion_script_to_thankyou_page($order_id) {
    $order = wc_get_order($order_id);
    $subtotal = $order->get_subtotal() - $order->get_total_discount(); // Product subtotal minus discounts
    $total = $subtotal / 1.8; // Divide subtotal by 1.8
    $extID = $order_id; // Order ID
    ?>
    <script type="text/javascript" src="https://track.wesell.co.il/conversionFirstParty/6n0AKLFgU18/oKo6kK9jnMw/json?total=<?php echo esc_js($total); ?>&extID=<?php echo esc_js($extID); ?>"></script>
    <?php
  }
  add_action('woocommerce_thankyou', 'add_conversion_script_to_thankyou_page');
}