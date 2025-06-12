<?php

/**
 * Adds a link to the footer of the page which allows users to contact us via WhatsApp.
 *
 * The link is only visible when the user is on the Hebrew version of the site.
 */
function add_whatsapp_link_to_footer() {
  $number = get_field('footer_whatsapp_number', 'option');
  $text = get_field('footer_whatsapp_text_message', 'option');
  ?>
  <a href="https://wa.me/<?= $number ?>?text=<?= $text ?>"
    class="whatsapp-share footer-whatsapp-link"
    target="_blank"
    rel="noopener noreferrer"
    aria-label="<?php esc_attr_e('Share on WhatsApp', 'noakirel'); ?>"
    lang="he"
    dir="rtl">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 175.216 175.552" width="24" height="24" role="img" aria-label="<?php esc_attr_e('WhatsApp icon', 'noakirel'); ?>">
      <defs>
        <linearGradient id="whatsappGradient" x1="85.915" x2="86.535" y1="32.567" y2="137.092" gradientUnits="userSpaceOnUse">
          <stop offset="0" stop-color="#57d163"/>
          <stop offset="1" stop-color="#23b33a"/>
        </linearGradient>
        <filter id="whatsappShadow" width="1.115" height="1.114" x="-.057" y="-.057" color-interpolation-filters="sRGB">
          <feGaussianBlur stdDeviation="3.531"/>
        </filter>
      </defs>
      <path fill="#b3b3b3" d="m54.532 138.45 2.235 1.324c9.387 5.571 20.15 8.518 31.126 8.523h.023c33.707 0 61.139-27.426 61.153-61.135.006-16.335-6.349-31.696-17.895-43.251A60.75 60.75 0 0 0 87.94 25.983c-33.733 0-61.166 27.423-61.178 61.13a60.98 60.98 0 0 0 9.349 32.535l1.455 2.312-6.179 22.558z" filter="url(#whatsappShadow)"/>
      <path fill="#fff" d="m12.966 161.238 10.439-38.114a73.42 73.42 0 0 1-9.821-36.772c.017-40.556 33.021-73.55 73.578-73.55 19.681.01 38.154 7.669 52.047 21.572s21.537 32.383 21.53 52.037c-.018 40.553-33.027 73.553-73.578 73.553h-.032c-12.313-.005-24.412-3.094-35.159-8.954z"/>
      <path fill="url(#whatsappGradient)" d="M87.184 25.227c-33.733 0-61.166 27.423-61.178 61.13a60.98 60.98 0 0 0 9.349 32.535l1.455 2.312-6.179 22.559 23.146-6.069 2.235 1.324c9.387 5.571 20.15 8.518 31.126 8.524h.023c33.707 0 61.14-27.426 61.153-61.135a60.75 60.75 0 0 0-17.895-43.251 60.75 60.75 0 0 0-43.235-17.929z"/>
      <path fill="url(#whatsappGradient)" d="M87.184 25.227c-33.733 0-61.166 27.423-61.178 61.13a60.98 60.98 0 0 0 9.349 32.535l1.455 2.313-6.179 22.558 23.146-6.069 2.235 1.324c9.387 5.571 20.15 8.517 31.126 8.523h.023c33.707 0 61.14-27.426 61.153-61.135a60.75 60.75 0 0 0-17.895-43.251 60.75 60.75 0 0 0-43.235-17.928z"/>
      <path fill="#fff" fill-rule="evenodd" d="M68.772 55.603c-1.378-3.061-2.828-3.123-4.137-3.176l-3.524-.043c-1.226 0-3.218.46-4.902 2.3s-6.435 6.287-6.435 15.332 6.588 17.785 7.506 19.013 12.718 20.381 31.405 27.75c15.529 6.124 18.689 4.906 22.061 4.6s10.877-4.447 12.408-8.74 1.532-7.971 1.073-8.74-1.685-1.226-3.525-2.146-10.877-5.367-12.562-5.981-2.91-.919-4.137.921-4.746 5.979-5.819 7.206-2.144 1.381-3.984.462-7.76-2.861-14.784-9.124c-5.465-4.873-9.154-10.891-10.228-12.73s-.114-2.835.808-3.751c.825-.824 1.838-2.147 2.759-3.22s1.224-1.84 1.836-3.065.307-2.301-.153-3.22-4.032-10.011-5.666-13.647"/>
    </svg>
    <span class="screen-reader-text"><?php _e('Contact us via WhatsApp', 'noakirel'); ?></span>
  </a>
  <?php
}
add_action('wp_footer', 'add_whatsapp_link_to_footer');

/**
 * Replace the default icon with a custom one
 */
add_filter('ins_get_svg_icon_pro', function($svg) {
  return '<svg class="header-cart-icon" width="26" height="26" fill="currentColor" role="img" aria-label="Cart icon"><use href="' . esc_url(sprite('cart')) . '"></use></svg>';
});


/**
 * Injects the mobile menu HTML and the tracking script into the footer.
 *
 * The mobile menu is created using the `wp_nav_menu` function, with the main menu slug.
 * The script is injected from the W Sell service.
 *
 * @since 1.0.0
 */
function footer_injection() {
  ?>
  <div id="mobile-menu-overlay" class="mobile-menu-overlay"></div>
  <div id="mobile-menu" class="mobile-menu">
    <div class="mobile-menu-content">
      <nav>
        <?php
        wp_nav_menu([
          'menu' => 'Main menu',
          'container' => false,
          'menu_class' => 'mobile-header-menu',
          'menu_id' => 'mobile-main-menu',
          'fallback_cb' => false,
        ]);
        ?>
      </nav8>
    </div>
  </div>

  <script type="text/javascript" src="https://track.wesell.co.il/script/tracking/firstPartyCookie/0wZzSoFGzjQ"></script>
  <?php
}
add_action('wp_footer', 'footer_injection');

/**
 * Disable automatic line breaks in contact form 7
 */
add_filter('wpcf7_autop_or_not', '__return_false');