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

  // Add checkbox before payment button
  // add_action('woocommerce_review_order_before_submit', 'add_confirm_mailing_updates_checkbox');
  function add_confirm_mailing_updates_checkbox() {
    $user_id = get_current_user_id();
    if (get_email_updates_status($user_id)) return
    ?>
    <p class="form-row form-row-wide">
      <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
        <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="confirm_mailing_updates" id="confirm_mailing_updates" value="1">
        <span class="woocommerce-confirm-mailing-updates-checkbox-text"><?php esc_html_e('מאשר רישום לקבלת דיוור ועדכונים', 'noakirel'); ?></span>
      </label>
    </p>
    <?php
  }
  add_action('woocommerce_checkout_after_terms_and_conditions', 'add_confirm_mailing_updates_checkbox');


  // Ensure checkbox is included in posted data
  add_filter('woocommerce_checkout_posted_data', 'include_confirm_mailing_updates_in_posted_data');
  function include_confirm_mailing_updates_in_posted_data($data) {
    if (isset($_POST['confirm_mailing_updates'])) {
      $data['confirm_mailing_updates'] = sanitize_text_field($_POST['confirm_mailing_updates']);
    }
    return $data;
  }

  // Process checkout data
  add_action('woocommerce_checkout_order_processed', 'capture_confirm_mailing_updates_data', 10, 3);
  function capture_confirm_mailing_updates_data($order_id, $posted_data, $order) {
    if (!isset($posted_data['confirm_mailing_updates']) || $posted_data['confirm_mailing_updates'] != '1') {
      return;
    }

    $user = $order->get_user();
    $order_user_email = $user ? $user->user_email : sanitize_email($posted_data['billing_email']);
    $order_user_displayname = $user ? $user->display_name : sanitize_text_field($posted_data['billing_first_name']);

    $data = [
      'Email' => $order_user_email,
      'First Name' => $order_user_displayname,
      'Confirm Email Updates' => 'TRUE',
    ];

    $email = [get_option('admin_email')];

    $result = advanced_storage_submission($data, 'Checkout Subscription', $email);

    if ($result) {
      $user_id = $user ? $user->ID : 0;
      if ($user) {
        update_user_meta($user_id, 'email_updates', 1);
      }
    }
  }

  remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
  remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

  /**
   * Retrieve and return the total number of products.
   *
   * This function checks if the current view is a product category, shop, or product tag page.
   * If so, it retrieves the total number of products found in the current query and returns
   * it as a string enclosed in parentheses.
   *
   * @global WP_Query $wp_query WordPress Query object.
   * @return string The total number of products in the current query, formatted as a string.
   */

  function display_product_count() {
    if ( is_product_category() || is_shop() || is_product_tag() ) {
      global $wp_query;
      $total = $wp_query->found_posts;
      return '(' . esc_html( $total ) . ')';
    }
  }
}