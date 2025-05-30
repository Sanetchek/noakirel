const swiper = new Swiper('.signature-swiper', {
  loop: true,
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
});

const reviewsSwiper = new Swiper('.reviews-swiper', {
	loop: true,
	spaceBetween: 40,
	pagination: {
		el: '.swiper-pagination',
		clickable: true,
	},
	autoplay: {
		delay: 15000,
		disableOnInteraction: false,
	},
	breakpoints: {
		0: {
			slidesPerView: 1,
		},
		768: {
			slidesPerView: 2,
		},
		1024: {
			slidesPerView: 3,
		}
	}
});


document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('label.woocommerce-form__label span').forEach(el => {
    if (el.textContent.trim() === 'I would like to receive exclusive emails with discounts and product information') {
      el.textContent = 'הרשם לניוזלטר שלנו לקבלת עדכונים חמים';
    }
  });

  if (document.querySelector('.wp-block-woocommerce-checkout')) {
    console.log('Block Checkout detected — translation script skipped.');
    return;
  }

  let lastRun = 0;

  function translateText() {
    const now = Date.now();
    if (now - lastRun < 300) return;
    lastRun = now;

    document.querySelectorAll('.ins-step-title').forEach(el => {
      if (el.textContent.trim() === 'Delivery') el.textContent = 'משלוח';
      if (el.textContent.trim() === 'Payment') el.textContent = 'תשלום';
    });

    document.querySelectorAll('button.ins-btns-step-next.checkout').forEach(button => {
      if (button.textContent.includes('Proceed to')) {
        button.textContent = 'המשך למילוי פרטים';
      }
    });

    const secondBtn = document.getElementById('ins-shipping-button');
    if (secondBtn && secondBtn.textContent.includes('Proceed to')) {
      secondBtn.textContent = 'המשך לתשלום';
    }

    const additionalTitle = document.querySelector('.woocommerce-additional-fields h3');
    if (additionalTitle && additionalTitle.textContent.includes('Additional information')) {
      additionalTitle.textContent = 'מידע נוסף';
    }

    const orderNotesLabel = document.querySelector('label[for="order_comments"]');
    if (orderNotesLabel && orderNotesLabel.textContent.includes('Order notes')) {
      orderNotesLabel.innerHTML = 'הערות להזמנה <span class="optional">(אופציונלי)</span>';
    }

    const textarea = document.getElementById('order_comments');
    if (textarea && textarea.placeholder.includes('Notes about your order')) {
      textarea.placeholder = 'הערות להזמנה, לדוגמה: זמן אספקה או הוראות מיוחדות';
    }

    const cartHeader = document.querySelector('.ins-checkout-header-title');
    if (cartHeader && cartHeader.textContent.includes('Your cart')) {
      cartHeader.textContent = 'עגלת קניות';
    }

    const placeOrderBtn = document.getElementById('place_order');
    if (placeOrderBtn && placeOrderBtn.textContent.includes('Place Order')) {
      placeOrderBtn.textContent = 'בצע הזמנה';
      placeOrderBtn.value = 'בצע הזמנה';
      placeOrderBtn.setAttribute('data-value', 'בצע הזמנה');
    }

    const cartEmpty = document.querySelector('.ins-cart-empty.ins-show span');
    if (cartEmpty && cartEmpty.textContent.includes('Your cart is empty')) {
      cartEmpty.innerHTML = 'העגלה שלך ריקה. <br> נא לעבור ל <a href="https://noakirel.co/shop">החנות</a>';
    }

    const contactTitle = document.querySelector('.ins-contact-wrap h3');
    if (contactTitle && contactTitle.textContent.trim() === 'Contact') {
      contactTitle.textContent = 'איש קשר';
    }

    const shippingAddressTitle = document.querySelector('.ins-shipping-wrap h3');
    if (shippingAddressTitle && shippingAddressTitle.textContent.trim() === 'Shipping address') {
      shippingAddressTitle.textContent = 'כתובת למשלוח';
    }

    const deliveryChargeTitle = document.querySelector('.shipping.active h3');
    if (deliveryChargeTitle && deliveryChargeTitle.textContent.trim() === 'Delivery charge') {
      deliveryChargeTitle.textContent = 'דמי משלוח';
    }

    const shippingSection = document.querySelector('.shipping.active');
    if (shippingSection && shippingSection.textContent.includes('There are no shipping options available')) {
      shippingSection.innerHTML = shippingSection.innerHTML.replace(
        /There are no shipping options available.*?help\./s,
        'אין אפשרויות משלוח זמינות. אנא ודא שהזנת את הכתובת בצורה נכונה או צור איתנו קשר לקבלת עזרה.'
      );
    }

    const orderSummaryTitle = document.querySelector('.ins-cart-summery .ins-order-summery-head h3');
    if (orderSummaryTitle && orderSummaryTitle.textContent.trim() === 'Order Summary') {
      orderSummaryTitle.textContent = 'סיכום הזמנה';
    }

    const subtotalLabel = document.querySelector('.ins-order-summery-subtotal .ins-total-title');
    if (subtotalLabel && subtotalLabel.textContent.trim() === 'Subtotal') {
      subtotalLabel.textContent = 'סיכום ביניים';
    }

    const totalLabel = document.querySelector('.total.order-total .ins-total-title');
    if (totalLabel && totalLabel.textContent.trim() === 'Total') {
      totalLabel.textContent = 'סה״כ';
    }

    const paymentMethodTitle = document.querySelector('#order_review h3');
    if (paymentMethodTitle && paymentMethodTitle.textContent.trim() === 'Payment Method') {
      paymentMethodTitle.textContent = 'אמצעי תשלום';
    }

    const privacyText = document.querySelector('.woocommerce-privacy-policy-text p');
    if (privacyText && privacyText.textContent.includes('Your personal data will be used')) {
      privacyText.innerHTML = 'הנתונים האישיים שלך ישמשו לעיבוד ההזמנה שלך, לתמיכה בחוויית המשתמש באתר זה ולמטרות אחרות המפורטות ב<a href="https://noakirel.co/?page_id=3" class="woocommerce-privacy-policy-link" target="_blank">מדיניות פרטיות</a>.';
    }

    const shippingBlock = document.querySelector('.ins-delivery-wrap.shipping.active');
    if (shippingBlock) {
      Array.from(shippingBlock.childNodes).forEach(node => {
        if (node.nodeType === Node.TEXT_NODE && node.textContent.trim() === 'Shipping') {
          node.textContent = 'משלוח';
        }
      });

      if (shippingBlock.innerHTML.includes('There are no shipping options available')) {
        shippingBlock.innerHTML = shippingBlock.innerHTML.replace(
          /There are no shipping options available.*?help\./s,
          'אין אפשרויות משלוח זמינות. אנא ודא שהכתובת שלך הוזנה כראוי, או צור איתנו קשר לקבלת עזרה.'
        );
      }
    }

    const cartTotalsBlock = document.querySelector('.cart_totals');
    if (cartTotalsBlock) {
      const cartTotalsTitle = cartTotalsBlock.querySelector('h2');
      if (cartTotalsTitle && cartTotalsTitle.textContent.trim() === 'Cart totals') {
        cartTotalsTitle.textContent = 'סיכום עגלה';
      }

      const rows = cartTotalsBlock.querySelectorAll('table.shop_table tr');

      rows.forEach(row => {
        const header = row.querySelector('th');
        if (!header) return;

        const text = header.textContent.trim();

        if (text === 'Subtotal') {
          header.textContent = 'סיכום ביניים';
        } else if (text === 'Shipping') {
          header.textContent = 'משלוח';
          const shippingCell = row.querySelector('td');
          if (shippingCell && shippingCell.textContent.includes('There are no shipping options available')) {
            shippingCell.innerHTML = 'אין אפשרויות משלוח זמינות. אנא ודא שהכתובת שלך הוזנה כראוי, או צור איתנו קשר לקבלת עזרה.';
          }
        } else if (text === 'Total') {
          header.textContent = 'סה״כ';
        }
      });

      const checkoutBtn = cartTotalsBlock.querySelector('a.checkout-button');
      if (checkoutBtn && checkoutBtn.textContent.includes('Proceed to checkout')) {
        checkoutBtn.textContent = 'להמשך לתשלום';
      }
    }

    const cartHeading = document.querySelector('.ins-cart-item-heading');
    if (cartHeading) {
      const title = cartHeading.querySelector('.ins-cart-item-heading-title');
      const price = cartHeading.querySelector('.ins-cart-item-heading-price');
      const quantity = cartHeading.querySelector('.ins-cart-item-heading-quantity');
      const total = cartHeading.querySelector('.ins-cart-item-heading-total');

      if (title && title.textContent.trim() === 'Product') {
        title.textContent = 'מוצר';
      }
      if (price && price.textContent.trim() === 'Price') {
        price.textContent = 'מחיר';
      }
      if (quantity && quantity.textContent.trim() === 'Quantity') {
        quantity.textContent = 'כמות';
      }
      if (total && total.textContent.trim() === 'Subtotal') {
        total.textContent = 'סיכום ביניים';
      }
    }
  }

  const mobileBar = document.querySelector('.ins-mobile-bar');

  if (mobileBar) {
    const cartTotalText = mobileBar.querySelector('.ins-mobile-cart-total span');
    if (cartTotalText && cartTotalText.textContent.includes('Cart Total')) {
      cartTotalText.innerHTML = 'סך הכל<br> <strong>' + cartTotalText.querySelector('strong').innerHTML + '</strong>';
    }

    const checkoutBtn = mobileBar.querySelector('.ins-mobile-checkout');
    if (checkoutBtn && checkoutBtn.textContent.trim() === 'Checkout') {
      checkoutBtn.textContent = 'לתשלום';
    }
  }


  translateText();
  const observer = new MutationObserver(translateText);
  observer.observe(document.body, {
    childList: true,
    subtree: true
  });
});


document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('#shipping_method .shipping_method').forEach(radio => {
    // Handle initial state
    const li = radio.closest('li');
    if (radio.checked) {
      li.classList.add('active');
    }

    // Handle change events
    radio.addEventListener('change', function () {
      // Remove 'active' from all li elements
      document.querySelectorAll('#shipping_method li').forEach(item => {
        item.classList.remove('active');
      });
      // Add 'active' to the closest li of the checked radio
      if (this.checked) {
        this.closest('li').classList.add('active');
      }
    });
  });

  updatePaymentMethodActiveState(); // Run on load

  document.querySelectorAll('.checkout-payment-methods .payment_method_radio').forEach(radio => {
    radio.addEventListener('change', updatePaymentMethodActiveState);
  });

  // Run again after WooCommerce updates the checkout
  jQuery(document.body).on('updated_checkout', function () {
    updatePaymentMethodActiveState();
  });
});

function updatePaymentMethodActiveState() {
  document.querySelectorAll('.checkout-payment-methods li').forEach(item => {
    item.classList.remove('active');
  });

  document.querySelectorAll('.checkout-payment-methods .payment_method_radio').forEach(radio => {
    if (radio.checked) {
      radio.closest('li').classList.add('active');
    }
  });
}

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const href = this.getAttribute('href');
    if (href && href !== '#') {
      const target = document.querySelector(href);
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth'
        });
      }
    }
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const header = document.getElementById('masthead');
  const stickyClass = 'is-sticky';

  window.addEventListener('scroll', function () {
    if (window.scrollY > 0) {
      header.classList.add(stickyClass);
    } else {
      header.classList.remove(stickyClass);
    }
  });
});

document.addEventListener('DOMContentLoaded', function () {
  const cartEmpty = document.querySelector('.ins-cart-empty.ins-show span');
  if (cartEmpty) {
    const text = cartEmpty.innerHTML;
    const firstLine = text.split('<br>')[0];
    cartEmpty.innerHTML = firstLine;
  }
});
