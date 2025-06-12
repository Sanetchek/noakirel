<?php
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'noakirel' ) ) );
    return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
    <div class="checkout-side-details">
        <div id="customer_details">
            <h1>פרטי משלוח</h1>
            <div class="checkout-address-wrapper">
                <div class="col-1">
                    <?php do_action( 'woocommerce_checkout_billing' ); ?>
                </div>
                <div class="col-2">
                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                </div>
            </div>
            <div class="woocommerce-shipping-methods-wrapper">
                <h2><?= __('אפשרויות משלוח', 'noakirel') ?></h2>
                <div class="shipping-method-options">
                    <?php wc_cart_totals_shipping_html(); ?>
                </div>
            </div>
            <div class="checkout-payment-methods-wrapper">
                <?php
                $available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
                if (!empty($available_gateways)) {
                    echo '<h2>'  . __('אפשרויות תשלום', 'noakirel') . '</h2>';
                    echo '<ul class="checkout-payment-methods">';
                    foreach ($available_gateways as $gateway) : ?>
                        <li class="wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>">
                            <input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio payment_method_radio payment_method_<?php echo esc_attr( $gateway->id ); ?>" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />

                            <label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>">
                                <?php echo $gateway->get_title(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>

                                <?php if ($gateway->id === 'tranzila') : ?>
                                    <?php $payment_methods = get_field('footer_payments_method', 'option'); ?>
                                    <?php if ($payment_methods) : ?>
                                        <div class="tranzila_wrapper_payment">
                                            <?php foreach ($payment_methods as $payment_method) : ?>
                                                <?php echo liteimage($payment_method['image'], [
                                                    'thumb' => [0, 20],
                                                ]); ?>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif ?>
                                <?php endif ?>
                                <?php // echo $gateway->get_icon(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>
                            </label>
                        </li>
                    <?php endforeach;
                    echo '</ul>';
                } else {
                    echo '<li>';
                    wc_print_notice(apply_filters('woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__('Sorry, it seems that there are no available payment methods. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce') : esc_html__('Please fill in your details above to see available payment methods.', 'woocommerce')), 'notice');
                    echo '</li>';
                }
                ?>
            </div>
        </div>
    </div>

    <div class="checkout-side-cart">
        <div id="checkout-cart">
            <h2><?php _e( 'סיכום הזמנה', 'noakirel' ); ?></h2>

            <?php if ( WC()->cart->get_cart_contents_count() > 0 ) : ?>
                <div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                    <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                        $_product   = $cart_item['data'];
                        if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 ) continue;
                        $product_permalink = $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '';
                        ?>
                        <div class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                            <div class="cart-item-wrapper">
                                <div class="product-thumbnail">
                                    <?php echo $_product->get_image(); ?>
                                </div>
                                <div class="product-name" data-title="<?php esc_attr_e( 'Product', 'noakirel' ); ?>">
                                    <?php
                                    if ( ! $product_permalink ) {
                                        echo wp_kses_post( $_product->get_name() );
                                    } else {
                                        echo wp_kses_post( sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ) );
                                    }
                                    ?>
                                    <div class="product-quantity-inline">
                                        <button type="button" class="quantity-plus" data-cart_item_key="<?php echo esc_attr( $cart_item_key ); ?>" data-product_id="<?php echo esc_attr( $cart_item['product_id'] ); ?>">
                                            <svg class='qty-plus-btn' width='24' height='24' role='img' aria-label='<?php esc_attr_e( 'Plus Quantity', 'noakirel' ); ?>'>
                                                <use href='<?php echo esc_url(sprite('qty-plus')); ?>'></use>
                                            </svg>
                                        </button>
                                        <input type="number"
                                            id="quantity_<?php echo esc_attr( $cart_item_key ); ?>"
                                            class="quantity-input"
                                            value="<?php echo intval( $cart_item['quantity'] ); ?>"
                                            min="1"
                                            data-cart_item_key="<?php echo esc_attr( $cart_item_key ); ?>"
                                            data-product_id="<?php echo esc_attr( $cart_item['product_id'] ); ?>"
                                            aria-label="<?php esc_attr_e( 'Quantity', 'noakirel' ); ?>">
                                        <button type="button" class="quantity-minus" data-cart_item_key="<?php echo esc_attr( $cart_item_key ); ?>" data-product_id="<?php echo esc_attr( $cart_item['product_id'] ); ?>">
                                            <svg class='qty-minus-btn' width='24' height='24' role='img' aria-label='<?php esc_attr_e( 'Minus Quantity', 'noakirel' ); ?>'>
                                                <use href='<?php echo esc_url(sprite('qty-minus')); ?>'></use>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="product-remove-inline">
                                        <a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>"
                                        class="remove"
                                        aria-label="<?php esc_attr_e( 'Remove this item', 'noakirel' ); ?>"
                                        data-product_id="<?php echo esc_attr( $cart_item['product_id'] ); ?>"
                                        data-cart_item_key="<?php echo esc_attr( $cart_item_key ); ?>"
                                        data-product_sku="<?php echo esc_attr( $_product->get_sku() ); ?>">
                                            <?php _e( 'הסרה', 'noakirel' ); ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-price" data-title="<?php esc_attr_e( 'Price', 'noakirel' ); ?>">
                                    <?php echo wc_price( $_product->get_price() ); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p class="woocommerce-cart-empty"><?php esc_html_e( 'Your cart is currently empty.', 'noakirel' ); ?></p>
            <?php endif; ?>

            <div class="checkout-coupon-wrapper">
                <div class="checkout-loader">
                    <div class="spinner"></div>
                </div>

                <div class="coupon-entry">
                    <h3><?php _e( 'קוד קופון:', 'noakirel' ); ?></h3>
                    <?php if ( get_option( 'woocommerce_enable_coupons' ) === 'yes' ) : ?>
                        <div class="checkout_coupon woocommerce-form-coupon">
                            <div class="checkout_coupon_wrapper">
                                <input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( '* הכנס קוד קופון', 'noakirel' ); ?>" id="coupon_code" value="" />
                                <button type="button" class="button apply-coupon-button" data-nonce="<?php echo wp_create_nonce( 'apply-coupon' ); ?>" value="<?php esc_attr_e( 'Apply coupon', 'noakirel' ); ?>"><?php esc_html_e( 'הפעלה', 'noakirel' ); ?></button>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="applied-coupons-wrapper">
                        <?php display_coupon_code(); ?>
                    </div>
                </div>

                <div class="custom-order-summary">
                    <?php display_checkout_summary(); ?>
                </div>

                <div class="woocommerce-payment-methods-wrapper">
                    <?php do_action( 'woocommerce_review_order_before_payment' ); ?>
                    <div id="payment" class="woocommerce-checkout-payment-wrapper">
                        <div class="form-row place-order">
                            <p class="form-row">
                                <!-- <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                                <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="confirm_mailing_updates" id="confirm_mailing_updates" value="1">
                                    <span class="woocommerce-confirm-mailing-updates-checkbox-text"><?php echo __('מאשר רישום לקבלת דיוור ועדכונים', 'noakirel') ?></span>
                                </label> -->

                            </p>


                            <noscript>
                                <?php
                                /* translators: $1 and $2 opening and closing emphasis tags respectively */
                                printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ), '<em>', '</em>' );
                                ?>
                                <br/><button type="submit" class="button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>"><?php esc_html_e( 'Update totals', 'woocommerce' ); ?></button>
                            </noscript>

                            <?php wc_get_template( 'checkout/terms.php' ); ?>

                            <?php do_action( 'woocommerce_review_order_before_submit' ); ?>

                            <?php
                            $subtotal = wp_strip_all_tags( wc_price( WC()->cart->get_subtotal() + WC()->cart->get_shipping_total() ) );
                            $total = wp_strip_all_tags(wc_price(WC()->cart->total));
                            $text = __('לתשלום', 'noakirel');

                            $order_button_html = '<span class="subtotal-price">' . $text . ' ' . esc_html($total) . '</span>';

                            if ( WC()->cart->get_discount_total() > 0 ) {
                                $order_button_html = '<span class="subtotal-price">' . $text . ' ' . esc_html($total) . '</span> <span class="total-price">' . esc_html($subtotal) . '</span>';
                            }

                            echo apply_filters(
                                'woocommerce_order_button_html',
                                '<button type="submit" class="button alt' . esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '') . '" name="woocommerce_checkout_place_order" id="place_order">'
                                . $order_button_html .
                                '</button>'
                            );
                            ?>


                            <?php do_action( 'woocommerce_review_order_after_submit' ); ?>

                            <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
                        </div>
                        <?php
                        if ( ! wp_doing_ajax() ) {
                            do_action( 'woocommerce_review_order_after_payment' );
                        }
                        ?>
                    </div>
                    <?php do_action( 'woocommerce_review_order_after_payment' ); ?>
                </div>
            </div>
        </div>
    </div>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        // Apply coupon
        $('.apply-coupon-button').on('click', function(e) {
            e.preventDefault();

            var $button = $(this);
            var $wrapper = $button.closest('.checkout_coupon_wrapper');
            var couponCode = $wrapper.find('input[name="coupon_code"]').val();
            var nonce = $button.data('nonce');

            if (!couponCode) {
                alert('<?php esc_html_e( "נא להזין קוד קופון.", "woocommerce" ); ?>');
                return;
            }

            $button.prop('disabled', true).text('<?php esc_html_e( "מיישם...", "woocommerce" ); ?>');

            $.ajax({
                type: 'POST',
                url: wc_checkout_params.ajax_url,
                data: {
                    action: 'woocommerce_apply_coupon',
                    coupon_code: couponCode,
                    security: nonce
                },
                beforeSend: function() {
                    $('.checkout-loader').addClass('show');
                },
                success: function(response) {
                    // Clear any existing messages
                    $('.woocommerce-message').remove();
                    // Fetch updated coupon display
                    $.get('<?php echo esc_url( wc_get_checkout_url() ); ?>', function(data) {
                        var $newCoupons = $(data).find('.applied-coupons-wrapper').html();
                        var $newSummary = $(data).find('.custom-order-summary').html();
                        var $newPayment = $(data).find('.woocommerce-checkout-payment-wrapper').html();
                        $('.applied-coupons-wrapper').html($newCoupons);
                        $('.custom-order-summary').html($newSummary);
                        $('.woocommerce-checkout-payment-wrapper').html($newPayment);
                        // Show success message
                        $('.coupon-entry').before('<div class="woocommerce-message" role="alert"><?php esc_html_e( "קוד קופון הוחל בהצלחה.", "woocommerce" ); ?></div>');
                        setTimeout(function() {
                            $('.woocommerce-message').fadeOut('slow', function() { $(this).remove(); });
                        }, 3000); // Remove message after 3 seconds

                        // Clear the input field
                        $wrapper.find('input[name="coupon_code"]').val('');
                        $button.prop('disabled', false).text('<?php esc_html_e( "הפעלה", "woocommerce" ); ?>');
                        $('.checkout-loader').removeClass('show');
                    });
                },
                error: function(xhr) {
                    console.log('AJAX Error:', xhr.status, xhr.responseText);
                    alert('<?php esc_html_e( "שגיאה ביישום הקופון. אנא נסה שוב.", "woocommerce" ); ?>');
                    $button.prop('disabled', false).text('<?php esc_html_e( "הפעלה", "woocommerce" ); ?>');
                }
            });
        });

        // Remove coupon
        $('body').on('click', '.remove-coupon', function(e) {
            e.preventDefault();

            var $link = $(this);
            var couponCode = $link.data('coupon');
            var nonce = $link.data('nonce');

            if (!couponCode || !nonce) {
                alert('<?php esc_html_e( "Missing coupon or nonce.", "woocommerce" ); ?>');
                return;
            }

            $link.text('<?php esc_html_e( "מסיר...", "woocommerce" ); ?>');
            const data = {
                action: 'checkout_remove_coupon',
                coupon: couponCode,
                security: nonce
            };

            $.ajax({
                type: 'POST',
                url: wc_checkout_params.ajax_url,
                data,
                beforeSend: function() {
                    $('.checkout-loader').addClass('show');
                },
                success: function(response) {
                    if (response.success) {
                        // Clear any existing messages
                        $('.woocommerce-message').remove();
                        $.get('<?php echo esc_url( wc_get_checkout_url() ); ?>', function(data) {
                            var $newCoupons = $(data).find('.applied-coupons-wrapper').html();
                            var $newSummary = $(data).find('.custom-order-summary').html();
                            var $newPayment = $(data).find('.woocommerce-checkout-payment-wrapper').html();
                            $('.applied-coupons-wrapper').html($newCoupons);
                            $('.custom-order-summary').html($newSummary);
                            $('.woocommerce-checkout-payment-wrapper').html($newPayment);
                            // Show success message
                            $('.coupon-entry').before('<div class="woocommerce-message" role="alert"><?php esc_html_e( "קופון הוסר בהצלחה.", "woocommerce" ); ?></div>');
                            setTimeout(function() {
                                $('.woocommerce-message').fadeOut('slow', function() { $(this).remove(); });
                            }, 3000);
                            $('.checkout-loader').removeClass('show');
                        });
                    } else {
                        alert(response.data && response.data.message ? response.data.message : '<?php esc_html_e( "שגיאה בהסרת הקופון.", "woocommerce" ); ?>');
                        $link.text('×');
                    }
                },
                error: function(xhr) {
                    console.log('AJAX Error:', xhr.status, xhr.responseText);
                    alert('<?php esc_html_e( "שגיאה בהסרת הקופון. אנא נסה שוב.", "woocommerce" ); ?>');
                    $link.text('×');
                }
            });
        });

        $('.shipping_method').on('change', function() {
            $.ajax({
                type: 'POST',
                url: wc_checkout_params.ajax_url,
                data: {
                    action: 'woocommerce_update_order_review',
                    security: wc_checkout_params.update_order_review_nonce,
                    shipping_method: [$(this).val()]
                },
                beforeSend: function() {
                    $('.shipping_method').prop('disabled', true);
                    $('.checkout-payment-methods-wrapper input').prop('disabled', true);
                    $('.checkout-loader').addClass('show');
                },
                success: function(response) {
                    // Update the order review
                    jQuery.get('<?php echo esc_url( wc_get_checkout_url() ); ?>', function (data) {
                        var $newCoupons = $(data).find('.applied-coupons-wrapper').html();
                        var $newSummary = $(data).find('.custom-order-summary').html();
                        var $newPayment = $(data).find('.woocommerce-checkout-payment-wrapper').html();
                        var $newPaymentMethod = $(data).find('.checkout-payment-methods-wrapper').html();
                        $('.applied-coupons-wrapper').html($newCoupons);
                        $('.custom-order-summary').html($newSummary);
                        $('.woocommerce-checkout-payment-wrapper').html($newPayment);
                        $('.checkout-payment-methods-wrapper').html($newPaymentMethod);
                        $('.checkout-loader').removeClass('show');
                        $('.shipping_method').prop('disabled', false);
                        $('.checkout-payment-methods-wrapper input').prop('disabled', false);
                    });
                },
                error: function(xhr) {
                    console.log('Error:', xhr.status, xhr.responseText);
                }
            });
        });

        // Handle plus button click
        $('.quantity-plus').on('click', function () {
            let input = $(this).siblings('.quantity-input');
            let newQty = parseInt(input.val()) + 1;
            updateCart(input, newQty);
        });

        // Handle minus button click
        $('.quantity-minus').on('click', function () {
            let input = $(this).siblings('.quantity-input');
            let newQty = parseInt(input.val()) - 1;
            if (newQty >= 1) { // Prevent quantity from going below 1
                updateCart(input, newQty);
            }
        });

        // Handle manual input change
        $('.quantity-input').on('change', function () {
            let newQty = parseInt($(this).val());
            if (newQty >= 1) { // Ensure quantity is at least 1
                updateCart($(this), newQty);
            } else {
            $(this).val(1); // Reset to 1 if invalid
                updateCart($(this), 1);
            }
        });

        // Function to update cart via AJAX
        function updateCart(input, quantity) {
            let cart_item_key = input.data('cart_item_key');
            let product_id = input.data('product_id');
            const inputQuantity = $(input).closest('.product-quantity-inline').find('.quantity-input');
            $(inputQuantity).val(quantity); // Update the input value

            $.ajax({
            type: 'POST',
            url: wc_checkout_params.ajax_url,
            data: {
                action: 'update_cart_quantity',
                cart_item_key: cart_item_key,
                quantity: quantity
            },
            beforeSend: function () {
                $('.product-quantity-inline input, .product-quantity-inline button').prop('disabled', true);
                $('.checkout-loader').addClass('show');
            },
            success: function (response) {
                // Clear any existing messages
                    $('.woocommerce-message').remove();
                    // Fetch updated coupon display
                    $.get('<?php echo esc_url( wc_get_checkout_url() ); ?>', function(data) {
                        var $newSummary = $(data).find('.custom-order-summary').html();
                        var $newPayment = $(data).find('.woocommerce-checkout-payment-wrapper').html();
                        $('.custom-order-summary').html($newSummary);
                        $('.woocommerce-checkout-payment-wrapper').html($newPayment);

                        $('.product-quantity-inline input, .product-quantity-inline button').prop('disabled', false);
                        $('.checkout-loader').removeClass('show');
                    });
            },
            error: function () {
                alert('Error updating cart. Please try again.');
            }
            });
        }
    });
</script>