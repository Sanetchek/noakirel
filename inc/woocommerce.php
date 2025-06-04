<?php
/**
 * Add WooCommerce support
 *
 * @return void
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')) ) ) {
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
   * Sequential order number function
   *
   * This function is fired by the 'woocommerce_new_order' action hook.
   * It will assign a sequential order number to the order.
   *
   * @param int $order_id The ID of the order.
   *
   * @return void
   */
  function custom_sequential_order_number($order_id) {
    if (get_post_meta($order_id, '_custom_order_number', true)) {
      return; // Already set
    }

    $last_order_number = get_option('custom_last_order_number', 1000); // Start from 1000
    $new_order_number = $last_order_number + 1;

    update_post_meta($order_id, '_custom_order_number', $new_order_number);
    update_option('custom_last_order_number', $new_order_number);
  }
  add_action('woocommerce_new_order', 'custom_sequential_order_number', 10, 1);

  /**
   * Adds a custom order number column to the orders screen.
   *
   * @param array $columns The existing columns.
   * @return array The new columns.
   */
  function add_custom_order_number_column($columns) {
    $new_columns = [];

    foreach ($columns as $key => $column) {
      if ($key === 'order_number') {
        $new_columns['custom_order_number'] = __('Order #', 'noakirel');
      } else {
        $new_columns[$key] = $column;
      }
    }

    return $new_columns;
  }
  add_filter('manage_edit-shop_order_columns', 'add_custom_order_number_column');

  /**
   * Displays the custom order number in the custom order number column.
   *
   * @param string $column The name of the column being displayed.
   */
  function show_custom_order_number_column($column) {
    global $post;
    if ($column === 'custom_order_number') {
      $custom_order_number = get_post_meta($post->ID, '_custom_order_number', true);
      echo $custom_order_number ? esc_html($custom_order_number) : $post->ID;
    }
  }
  add_action('manage_shop_order_posts_custom_column', 'show_custom_order_number_column');

  /**
   * Returns the custom order number for the given order ID.
   *
   * @param int $order_id The ID of the order.
   * @return int|false The custom order number for the given order ID, or false if the order ID is invalid.
   */
  function get_custom_order_number($order_id) {
    $order = wc_get_order($order_id);
    if (!$order) {
      return false; // Invalid order ID
    }

    $custom_order_number = $order->get_meta('_custom_order_number');
    return $custom_order_number ? $custom_order_number : $order->get_id();
  }
}