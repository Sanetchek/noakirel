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
}