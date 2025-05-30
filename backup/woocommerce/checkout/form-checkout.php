<?php
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
    return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

    <?php if ( $checkout->get_checkout_fields() ) : ?>
        <div id="customer_details">
            <h1>פרטי משלוח</h1>
            <div class="col-1">
                <?php do_action( 'woocommerce_checkout_billing' ); ?>
            </div>
            <div class="col-2">
                <?php do_action( 'woocommerce_checkout_shipping' ); ?>
            </div>
            <div class="woocommerce-shipping-methods-wrapper">
                <h2>אפשרויות משלוח</h2>
                <div class="shipping-method-options">
                    <?php wc_cart_totals_shipping_html(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div id="checkout-cart">
        <h2 style="font-size: 40px;margin-bottom: 56px;font-weight: 700;"><?php _e( 'סיכום הזמנה', 'woocommerce' ); ?></h2>

        <?php if ( WC()->cart->get_cart_contents_count() > 0 ) : ?>
            <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                <tbody>
                    <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                        $_product   = $cart_item['data'];
                        if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 ) continue;
                        $product_permalink = $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '';
                        ?>
                        <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                            <td class="product-thumbnail">
                                <?php echo $_product->get_image(); ?>
                            </td>
                            <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
                                <?php
                                if ( ! $product_permalink ) {
                                    echo wp_kses_post( $_product->get_name() );
                                } else {
                                    echo wp_kses_post( sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ) );
                                }
                                ?>
                                <div class="product-quantity-inline" style="margin-top: 5px;">
                                    <?php echo intval( $cart_item['quantity'] ); ?>
                                </div>
                                <div class="product-remove-inline" style="margin-top: 5px;">
                                    <a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>"
                                        class="remove"
                                        aria-label="<?php esc_attr_e( 'Remove this item', 'woocommerce' ); ?>"
                                        data-product_id="<?php echo esc_attr( $cart_item['product_id'] ); ?>"
                                        data-cart_item_key="<?php echo esc_attr( $cart_item_key ); ?>"
                                        data-product_sku="<?php echo esc_attr( $_product->get_sku() ); ?>">
                                        <?php _e( 'הסרה', 'woocommerce' ); ?>
                                    </a>
                                </div>
                            </td>
                            <td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
                                <?php echo wc_price( $_product->get_price() ); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p class="woocommerce-cart-empty"><?php esc_html_e( 'Your cart is currently empty.', 'woocommerce' ); ?></p>
        <?php endif; ?>

        <!-- Coupon entry section without a nested form -->
        <div class="coupon-entry">
            <h3><?php _e( 'קוד קופון:', 'your-theme-textdomain' ); ?></h3>
            <?php if ( get_option( 'woocommerce_enable_coupons' ) === 'yes' ) : ?>
                <div class="checkout_coupon woocommerce-form-coupon">
                    <div class="checkout_coupon_wrapper">
                        <input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( '* הכנס קוד קופון', 'woocommerce' ); ?>" id="coupon_code" value="" />
                        <button type="button" class="button apply-coupon-button" data-nonce="<?php echo wp_create_nonce( 'apply-coupon' ); ?>" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'הפעלה', 'woocommerce' ); ?></button>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ( WC()->cart->get_applied_coupons() ) : ?>
                <div class="applied-coupons">
                    <h4><?php _e( 'קופונים מופעלים:', 'woocommerce' ); ?></h4>
                    <ul>
                        <?php foreach ( WC()->cart->get_applied_coupons() as $code ) : ?>
                            <li>
                                <?php echo esc_html( $code ); ?>
                                <a href="<?php echo esc_url( add_query_arg( 'remove_coupon', urlencode( $code ), wc_get_checkout_url() ) ); ?>" class="remove-coupon" aria-label="<?php esc_attr_e( 'Remove coupon', 'woocommerce' ); ?>">×</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <div class="custom-order-summary" style="background: #fff;padding-top: 20px;margin-top: 20px;font-size: 15px;line-height: 1.6;border-top: 1px solid #eee;max-width: 370px;">
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span><?php _e( 'תשלום', 'woocommerce' ); ?>:</span>
                    <span><?php echo wc_price( WC()->cart->get_subtotal() ); ?></span>
                </li>
                <?php if ( WC()->cart->get_discount_total() > 0 ) : ?>
                    <li style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span><?php _e( 'לאחר הנחת קוד קופון', 'woocommerce' ); ?>:</span>
                        <span><?php echo WC()->checkout->get_value( 'order_total' ) ? wc_price( WC()->cart->get_total() ) : wc_price( WC()->cart->total ); ?></span>
                    </li>
                <?php endif; ?>
                <?php
                $packages = WC()->shipping()->get_packages();
                foreach ( $packages as $i => $package ) {
                    $chosen_method = WC()->session->get( "chosen_shipping_methods" )[ $i ] ?? '';
                    foreach ( $package['rates'] as $rate_id => $rate ) {
                        if ( $rate_id === $chosen_method ) {
                            $label = $rate->get_label();
                            $cost  = $rate->get_cost();
                            ?>
                            <li style="margin: 15px 0 5px; font-weight: bold;">
                                <?php echo esc_html( $label ); ?>
                            </li>
                            <?php if ( $cost > 0 ) : ?>
                                <li style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                    <span><?php _e( 'עלות משלוח', 'woocommerce' ); ?>:</span>
                                    <span><?php echo wc_price( $cost ); ?></span>
                                </li>
                            <?php endif; ?>
                            <li style="color: #666; font-size: 14px;">
                                <?php
                                switch ( $label ) {
                                    case 'איסוף עצמי':
                                        echo 'איירפורט סיטי. כתובת: החרש 5, בניין גיל קרגו.<br>ניתן להגיע עד השעה 13:00 – ללא צורך בתיאום מראש.';
                                        break;
                                    case 'שליח עד הבית':
                                        echo 'שליח יגיע עד הבית תוך 3-5 ימי עסקים.';
                                        break;
                                    default:
                                        echo 'שיטת משלוח נבחרה.';
                                        break;
                                }
                                ?>
                            </li>
                            <?php
                        }
                    }
                }
                ?>
                <li style="display: flex; justify-content: space-between; margin-top: 15px; border-top: 1px solid #ccc; padding-top: 10px; font-weight: bold; font-size: 16px;">
                    <span><?php _e( 'תשלום סופי', 'woocommerce' ); ?></span>
                    <span><?php echo WC()->checkout->get_value( 'order_total' ) ? wc_price( WC()->cart->get_total() ) : wc_price( WC()->cart->total ); ?></span>
                </li>
                <li style="text-align: left; font-size: 13px; color: #888;"><?php _e( 'מחיר כולל מע”מ', 'woocommerce' ); ?></li>
            </ul>
        </div>

        <div class="woocommerce-payment-methods-wrapper">
            <?php do_action( 'woocommerce_review_order_before_payment' ); ?>
            <div id="payment" class="woocommerce-checkout-payment">
                <?php if ( WC()->cart->needs_payment() ) : ?>
                    <ul class="wc_payment_methods payment_methods methods">
                        <?php
                        if ( ! empty( $available_gateways = WC()->payment_gateways()->get_available_payment_gateways() ) ) {
                            foreach ( $available_gateways as $gateway ) {
                                wc_get_template( 'checkout/payment-method.php', [ 'gateway' => $gateway ] );
                            }
                        } else {
                            echo '<li>' . esc_html__( 'No payment methods available. Please contact support.', 'woocommerce' ) . '</li>';
                        }
                        ?>
                    </ul>
                <?php endif; ?>
                <div class="form-row place-order">
                    <?php wc_get_template( 'checkout/terms.php' ); ?>
                </div>
            </div>
            <?php do_action( 'woocommerce_review_order_after_payment' ); ?>
        </div>
    </div>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.apply-coupon-button').on('click', function(e) {
            e.preventDefault();

            var $button = $(this);
            var $wrapper = $button.closest('.checkout_coupon_wrapper');
            var couponCode = $wrapper.find('input[name="coupon_code"]').val();
            var nonce = $button.data('nonce');

            if (!couponCode) {
                alert('<?php esc_html_e( "אנא הזן קוד קופון.", "woocommerce" ); ?>');
                return;
            }

            $button.prop('disabled', true).text('<?php esc_html_e( "מגיש מועמדות...", "woocommerce" ); ?>');

            $.ajax({
                type: 'POST',
                url: '<?php echo esc_url( wc_get_checkout_url() ); ?>',
                data: {
                    coupon_code: couponCode,
                    apply_coupon: 1,
                    security: nonce
                },
                success: function(response) {
                    location.reload(); // Reload to reflect updated totals
                },
                error: function() {
                    alert('<?php esc_html_e( "שגיאה ביישום קופון. אנא נסה שוב.", "woocommerce" ); ?>');
                    $button.prop('disabled', false).text('<?php esc_html_e( "הפעלה", "woocommerce" ); ?>');
                }
            });
        });
    });
</script>