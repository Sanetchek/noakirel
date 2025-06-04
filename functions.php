<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'noakirel' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';
require 'inc/wordpress-shims.php';
require 'inc/custom-functions.php';
require 'inc/woocommerce.php';
require 'inc/acf.php';
require 'inc/hooks.php';

add_action( 'wp_enqueue_scripts', 'my_custom_assets', 20 );

function my_custom_assets() {
	// Swiper CSS
	wp_enqueue_style(
		'swiper-css',
		'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css',
		array(),
		'9.0.0'
	);

	// Swiper JS
	wp_enqueue_script(
		'swiper-js',
		'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js',
		array(),
		'9.0.0',
		true
	);

	wp_enqueue_style(
		'theme-custom',
		get_template_directory_uri() . '/assets/css/custom.css',
		array( 'storefront-style' ),
		'1.0'
	);

	wp_enqueue_script(
		'theme-homepage',
		get_template_directory_uri() . '/assets/js/homepage.js',
		array( 'jquery', 'swiper-js' ),
		'1.0',
		true
	);

	if ( is_checkout() ) {
		wp_enqueue_style( 'checkout-style', get_stylesheet_directory_uri() . '/assets/css/checkout-style.css', array(), '1.0', 'all' );
	}

	// Noakirel Styles (LTR or RTL)
	if ( is_rtl() ) {
		wp_enqueue_style(
			'noakirel-custom-style-rtl',
			get_stylesheet_directory_uri() . '/assets/css/noakirel-styles-rtl.css',
			array(),
			'1.0',
			'all'
		);
	} else {
		wp_enqueue_style(
			'noakirel-custom-style',
			get_stylesheet_directory_uri() . '/assets/css/noakirel-styles.css',
			array(),
			'1.0',
			'all'
		);
	}

	wp_enqueue_script(
		'noakirel-scripts',
		get_template_directory_uri() . '/assets/js/scripts.min.js',
		array( 'jquery', 'swiper-js' ),
		'1.0',
		true
	);
}

add_action( 'wp_ajax_woocommerce_apply_coupon', 'custom_apply_coupon' );
add_action( 'wp_ajax_nopriv_woocommerce_apply_coupon', 'custom_apply_coupon' );

function custom_apply_coupon() {
    check_ajax_referer( 'apply-coupon', 'security' );

    $coupon_code = isset( $_POST['coupon_code'] ) ? wc_clean( $_POST['coupon_code'] ) : '';

    if ( empty( $coupon_code ) ) {
			wp_send_json_error( array( 'message' => __( 'No coupon code provided.', 'noakirel' ) ) );
    }

    if ( WC()->cart->apply_coupon( $coupon_code ) ) {
      wp_send_json_success();
    } else {
			wp_send_json_error( array( 'message' => __( 'Invalid or expired coupon.', 'noakirel' ) ) );
    }
}

add_action( 'wp_ajax_checkout_remove_coupon', 'custom_remove_coupon' );
add_action( 'wp_ajax_nopriv_checkout_remove_coupon', 'custom_remove_coupon' );

function custom_remove_coupon() {
	check_ajax_referer( 'checkout_remove_coupon', 'security' );

	$coupon = isset( $_POST['coupon'] ) ? sanitize_text_field( $_POST['coupon'] ) : '';

	if ( empty( $coupon ) ) {
		wp_send_json_error( array( 'message' => __( 'No coupon code provided.', 'noakirel' ) ) );
	}

	$result = WC()->cart->remove_coupon( $coupon );

	if ( $result ) {
		wp_send_json_success();
	} else {
		wp_send_json_error( array( 'message' => __( 'Failed to remove coupon.', 'noakirel' ) ) );
	}
}

add_action( 'wp_enqueue_scripts', 'enqueue_checkout_scripts', 30 );
function enqueue_checkout_scripts() {
    if ( is_checkout() ) {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'wc-cart', WC()->plugin_url() . '/assets/js/frontend/cart.min.js', array( 'jquery' ), WC_VERSION, true );
        wp_localize_script( 'wc-cart', 'wc_add_to_cart_params', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'wc_ajax_url' => WC_AJAX::get_endpoint( '%%endpoint%%' )
        ));
    }
}

function display_coupon_code() {
	if (WC()->cart->get_applied_coupons()) : ?>
		<div class="applied-coupons">
			<ul>
				<?php foreach (WC()->cart->get_applied_coupons() as $code) : ?>
					<li>
						<span class="coupon-code-wrapper">
							<span class="coupon-code-label"><?php echo __('קופון:', 'noakirel') ?></span>
							<button type="button" class="remove-coupon" data-coupon="<?php echo esc_attr($code); ?>" data-nonce="<?php echo wp_create_nonce('checkout_remove_coupon'); ?>" aria-label="<?php esc_attr_e('Remove coupon', 'noakirel'); ?>">
								<span class="remove-coupon-icon">
									<svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M1.03684 7.98241L7.96317 0.988899" stroke="white" stroke-linecap="round" />
										<path d="M1.03711 0.98877L7.96343 7.98228" stroke="white" stroke-linecap="round" />
									</svg>
								</span>
								<span class="coupon-code"><?php echo esc_html($code); ?> </span>
							</button>
						</span>
						<span class="coupon-amount"> - <?php echo wc_price(WC()->cart->get_coupon_discount_amount($code, false)); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif;
}

function display_checkout_summary() {
	?>
	<div class="custom-order-summary">
		<div class="custom-order-subtotal custom-order-width">
			<span class="custom-order-label"><?php _e( 'תשלום', 'noakirel' ); ?>:</span>
			<span class="custom-order-amount"><?php echo wc_price( WC()->cart->get_subtotal() ); ?></span>
		</div>
		<?php if ( WC()->cart->get_discount_total() > 0 ) : ?>
			<div class="custom-order-discount custom-order-width">
				<span class="custom-order-label"><?php _e( 'לאחר הנחת קוד קופון', 'noakirel' ); ?>:</span>
				<span class="custom-order-amount"><?php echo WC()->cart->get_cart_contents_total()  ? wc_price( WC()->cart->get_cart_contents_total() ) : wc_price( WC()->cart->total ); ?></span>
			</div>
		<?php endif; ?>
		<?php
		$chosen_method = WC()->session->get('chosen_shipping_methods')[0];
		$packages = WC()->shipping()->get_packages();
		$package = $packages[0];
    $available_methods = $package['rates'];
		foreach ( $available_methods as $rate_id => $rate ) :
			if ( $rate_id === $chosen_method ) : ?>
				<div class="custom-order-shipping-wrapper custom-order-width">
					<div class="custom-order-shipping">
						<span class="custom-order-label"><?php _e( 'משלוח', 'noakirel' ); ?>:</span>
						<span class="custom-order-amount"><?php echo ($rate->get_cost() == 0) ? '' : wc_price($rate->get_cost()); ?></span>
					</div>
					<div class="custom-order-shipping-label">
						<?php echo esc_html( $rate->get_label() ); ?>
					</div>
				</div>
			<?php endif;
		endforeach; ?>

		<div class="custom-order-total-wrapper">
			<div class="custom-order-total custom-order-width">
				<span class="custom-order-total-label"><?php _e( 'תשלום סופי', 'noakirel' ); ?></span>
				<span class="custom-order-total-amount"><?php echo WC()->checkout->get_value( 'order_total' ) ? wc_price( WC()->cart->get_total() ) : wc_price( WC()->cart->total ); ?></span>
			</div>
			<div class="custom-order-tax custom-order-width"><?php _e( 'מחיר כולל מע״מ', 'noakirel' ); ?></div>
		</div>
	</div>
	<?php
}

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';
	require 'inc/nux/class-storefront-nux-starter-content.php';
}

 add_action('template_redirect', 'custom_redirect_woo_thankyou');
 function custom_redirect_woo_thankyou() {
 	if (is_wc_endpoint_url('order-received')) {
 		remove_all_actions('woocommerce_thankyou');
 		add_action('woocommerce_thankyou', 'custom_thankyou_template', 10);
 	}
 }

 function custom_thankyou_template($order_id) {
 	$order = wc_get_order($order_id);
 	if (!$order) return;

 	?>
 	<div style="background: #fff url('<?= get_stylesheet_directory_uri(); ?>/images/thankyou-bg.jpg') no-repeat center top; background-size: cover; min-height: 100vh; display: flex; align-items: center; justify-content: center; direction: rtl; text-align: center; font-family: Arial, sans-serif;">
 		<div style="background: #fff; padding: 40px; max-width: 500px; border-radius: 10px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
 			<h1 style="font-size: 24px; color: #2f1d1b; margin-bottom: 20px;">
 				ההזמנה בוצעה בהצלחה
 			</h1>
 			<p style="font-size: 16px; color: #333;">
 				הזמנה מספר <strong>#<?= $order->get_order_number(); ?></strong> נוצרה בהצלחה.<br>
 				פרטי ההזמנה מופיעים בחשבון האישי שלך.
 			</p>
 			<a href="<?= esc_url( $order->get_view_order_url() ); ?>" style="display: inline-block; margin-top: 25px; color: #2f1d1b; font-weight: bold; text-decoration: underline;">
 				צפייה בהזמנה
 			</a>
 		</div>
 	</div>
 	<?php
 }

 add_action('wp_head', function () {
     ?>
     <style>
     #billing_address_2::placeholder {
         color: #616161 !important;
         opacity: 1 !important;
     }
     #billing_address_2 {
         direction: rtl !important;
         text-align: right !important;
     }
     </style>
     <?php
 });

 add_filter( 'woocommerce_email_classes', 'add_customer_failed_order_email_class_hebrew' );

function add_customer_failed_order_email_class_hebrew( $email_classes ) {

	class WC_Email_Customer_Failed_Order_Hebrew extends WC_Email {

		public function __construct() {
			$this->id             = 'customer_failed_order';
			$this->title          = 'הזמנה נכשלה (לקוח)';
			$this->description    = 'מייל ללקוח כאשר תשלום נכשל.';
			$this->customer_email = true;

			$this->template_html  = 'emails/customer-failed-order.php';
			$this->template_plain = 'emails/plain/customer-failed-order.php';
			$this->template_base  = get_stylesheet_directory() . '/woocommerce/';

			add_action( 'woocommerce_order_status_failed', [ $this, 'trigger' ], 10, 2 );

			parent::__construct();
		}

		public function trigger( $order_id, $order = false ) {
			if ( ! $order instanceof WC_Order ) {
				$order = wc_get_order( $order_id );
			}

			if ( ! $order ) return;

			$this->object    = $order;
			$this->recipient = $order->get_billing_email();

			if ( ! $this->is_enabled() || ! $this->get_recipient() ) return;

			$this->send(
				$this->get_recipient(),
				$this->get_subject(),
				$this->get_content(),
				$this->get_headers(),
				$this->get_attachments()
			);
		}

		public function get_default_subject() {
			return 'הזמנה מספר {order_number} נכשלה';
		}

		public function get_default_heading() {
			return 'ההזמנה שלך נכשלה';
		}

		public function get_content_html() {
			return wc_get_template_html( $this->template_html, array(
				'order'         => $this->object,
				'email_heading' => $this->get_heading(),
				'sent_to_admin' => false,
				'plain_text'    => false,
				'email'         => $this,
			), '', $this->template_base );
		}

		public function get_content_plain() {
			return wc_get_template_html( $this->template_plain, array(
				'order'         => $this->object,
				'email_heading' => $this->get_heading(),
				'sent_to_admin' => false,
				'plain_text'    => true,
				'email'         => $this,
			), '', $this->template_base );
		}
	}

	$email_classes['WC_Email_Customer_Failed_Order_Hebrew'] = new WC_Email_Customer_Failed_Order_Hebrew();

	return $email_classes;
}


add_action('woocommerce_single_product_summary', 'add_free_pickup_note', 25);
function add_free_pickup_note() {
    echo '<p style="font-size: 0.9em;">כתובת: השרון 5, איירפורט סיטי. בניין גליל קרגו. ניתן להגיע עד השעה 13:00- ללא צורך בתיאום מראש</p>';
}


add_action('wp_footer', function () {
    ?>
    <script>
        function fixInsErrorMessages() {
            document.querySelectorAll('.ins-error-message').forEach(el => {
                const match = el.textContent.match(/^(.*)\s+is required$/);
                if (match) {
                    const fieldName = match[1].trim();
                    el.textContent = `${fieldName} הוא שדה חובה`;
                }
            });
        }

        function translateNewsletterLabel() {
            const labelDivs = document.querySelectorAll('.wc-block-components-checkbox__label div');

            labelDivs.forEach(function (el) {
                if (el.textContent.trim() === 'I would like to receive exclusive emails with discounts and product information') {
                    el.textContent = 'אני רוצה לקבל מיילים בלעדיים עם הנחות ומידע על מוצרים';
                }
            });
        }

        const observer = new MutationObserver(() => {
            fixInsErrorMessages();
            translateNewsletterLabel();
        });

        observer.observe(document.body, { childList: true, subtree: true });

        document.addEventListener('DOMContentLoaded', function () {
            fixInsErrorMessages();
            translateNewsletterLabel();
        });
    </script>
    <?php
});

add_action('wp_footer', function () {
    if (is_checkout()) :
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        function insertCustomTermsCheckbox() {
            const placeOrderBtn = document.querySelector('.wc-block-components-checkout-place-order-button');
            if (!placeOrderBtn || document.querySelector('#custom_terms_checkbox')) return;

            const wrapper = document.createElement('div');
            wrapper.style.margin = '20px 0';

            wrapper.innerHTML = `
                <label style="display:flex; gap:10px; align-items: center;">
                    <input type="checkbox" id="custom_terms_checkbox" />
                    <span>אני מאשר/ת את <a href="/תנאי-שימוש" target="_blank">תנאי השימוש</a> ואת <a href="/privacy-policy" target="_blank">מדיניות הפרטיות</a></span>
                </label>
                <div id="custom_terms_error" style="color:red; display:none;">יש לאשר את התנאים לפני ביצוע ההזמנה.</div>
            `;

            placeOrderBtn.closest('.wc-block-checkout__actions_row').before(wrapper);

            placeOrderBtn.addEventListener('click', function (e) {
                const checkbox = document.querySelector('#custom_terms_checkbox');
                const error = document.querySelector('#custom_terms_error');
                if (!checkbox.checked) {
                    e.preventDefault();
                    error.style.display = 'block';
                    checkbox.scrollIntoView({ behavior: 'smooth' });
                } else {
                    error.style.display = 'none';
                }
            });
        }

        const observer = new MutationObserver(insertCustomTermsCheckbox);
        observer.observe(document.body, { childList: true, subtree: true });

        insertCustomTermsCheckbox(); // initial run
    });
    </script>
    <?php
    endif;
});

add_action('wp_footer', function () {
    if (is_checkout()) :
    ?>
    <style>
        .wp-block-woocommerce-checkout-terms-block {
            display: none !important;
        }
    </style>
    <?php
    endif;
});

add_action('wp_footer', function () {
	if (!is_checkout()) return;
	?>
	<script>
		document.addEventListener('DOMContentLoaded', () => {
			const translations = {
				"Contact information": "פרטי קשר",
				"We'll use this email to send you details and updates about your order.": "נשתמש במייל הזה לשליחת פרטי ההזמנה ועדכונים.",
				"You are currently checking out as a guest.": "את/ה מבצע/ת את ההזמנה כאורח.",
				"Enter the address where you want your order delivered.": "הזן כתובת למשלוח ההזמנה.",
				"Shipping options": "אפשרויות משלוח",
				"Payment options": "אפשרויות תשלום",
				"Use same address for billing": "השתמש באותה כתובת גם לחיוב",
				"Add a note to your order": "הוסף הערה להזמנה",
				"There are no payment methods available. This may be an error on our side. Please contact us if you need any help placing your order.":
					"אין אמצעי תשלום זמינים כרגע. אנא צור קשר אם אתה זקוק לעזרה."
			};

			const translateTextNodes = () => {
				const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, null, false);
				while (walker.nextNode()) {
					const node = walker.currentNode;
					const trimmed = node.nodeValue.trim();
					if (translations[trimmed]) {
						node.nodeValue = node.nodeValue.replace(trimmed, translations[trimmed]);
					}
				}
			};

			translateTextNodes();

			const observer = new MutationObserver(translateTextNodes);
			observer.observe(document.body, { childList: true, subtree: true });
		});
	</script>
	<?php
});

add_filter( 'woocommerce_checkout_fields', 'custom_clean_checkout_fields' );

function custom_clean_checkout_fields( $fields ) {

    unset( $fields['billing']['billing_country'] );
    unset( $fields['shipping']['shipping_country'] );

    $fields['billing'] = array_filter(
        $fields['billing'],
        function( $key ) {
            return in_array( $key, [
                'billing_first_name',
                'billing_last_name',
                'billing_email',
                'billing_phone',
                'billing_address_1',
                'billing_address_2',
                'billing_city',
                'billing_postcode',
            ] );
        },
        ARRAY_FILTER_USE_KEY
    );

    $fields['billing']['billing_postcode']['required'] = false;
    $fields['billing']['billing_address_2']['required'] = false;

    $fields['billing']['billing_first_name']['label'] = 'שם פרטי';
    $fields['billing']['billing_last_name']['label'] = 'שם משפחה';
    $fields['billing']['billing_email']['label'] = 'כתובת אימייל';
    $fields['billing']['billing_phone']['label'] = 'טלפון';
    $fields['billing']['billing_address_1']['label'] = 'כתובת';
    $fields['billing']['billing_address_2']['label'] = 'דירה / קומה (אופציונלי)';
    $fields['billing']['billing_city']['label'] = 'עיר';
    $fields['billing']['billing_postcode']['label'] = 'מיקוד';

    return $fields;
}


add_filter( 'woocommerce_checkout_blocks_enabled', '__return_false' );
