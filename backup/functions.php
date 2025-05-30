<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
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

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */
 add_action( 'wp_enqueue_scripts', 'my_custom_styles', 20 );

 function my_custom_styles() {
 	wp_enqueue_style( 'theme-custom', get_template_directory_uri() . '/assets/css/custom.css', array('storefront-style'), '1.0' );
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
         color: #43454b !important;
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
    $fields['billing']['billing_postcode']['label'] = 'מיקוד (אופציונלי)';

    return $fields;
}


add_filter( 'woocommerce_checkout_blocks_enabled', '__return_false' );
