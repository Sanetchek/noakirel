<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>
<footer>

<div class="footer_wrapper">
	<div class="footer_wrapper_info">
		<div class="footer_wrapper_info_logo">
			<?php
				$social = get_field('social', 'option');

				if ( $social ) :
				  $logo = $social['logo'];
				  $description = $social['description'];
				  $facebook = $social['facebook'];
				  $instagram = $social['instagram'];
				  $tiktok = $social['tik_tok'];
				?>
				  <?php if ( $logo ) : ?>
				    <img src="<?= esc_url( $logo ) ?>" alt="logo">
				  <?php endif; ?>

				  <?php if ( $description ) : ?>
				    <p><?= esc_html( $description ) ?></p>
				  <?php endif; ?>

				  <div class="footer_wrapper_info_logo_social">
				    <?php if ( $facebook ) : ?>
				      <a href="<?= esc_url( $facebook ) ?>" target="_blank" rel="noopener"><img src="/wp-content/uploads/2025/04/Vector-1.png" alt="Facebook"></a>
				    <?php endif; ?>
				    <?php if ( $instagram ) : ?>
				      <a href="<?= esc_url( $instagram ) ?>" target="_blank" rel="noopener"><img src="/wp-content/uploads/2025/04/Group.png" alt="Instagram"></a>
				    <?php endif; ?>
				    <?php if ( $tiktok ) : ?>
				      <a href="<?= esc_url( $tiktok ) ?>" target="_blank" rel="noopener"><img src="/wp-content/uploads/2025/04/Vector-1-2.png" alt="TikTok"></a>
				    <?php endif; ?>
				  </div>
				<?php endif; ?>

				<?php
        $product_id = 77;
        $product = wc_get_product($product_id);
        ?>

        <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
           data-quantity="1"
           class="btn_add add_to_cart_button ajax_add_to_cart"
           data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
           data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
           aria-label="<?php echo esc_html( $product->add_to_cart_description() ); ?>"
           rel="nofollow">

           <span class="btn-text">קנו עכשיו</span>
           <span class="btn-icon">
             <span class="icon-cart"><img src="https://noakirel.co/wp-content/uploads/2025/04/Link.svg" alt="asd"></span>
             <span class="icon-check" style="display:none;">✔️</span>
           </span>
        </a>
		</div>

		<div class="footer_wrapper_info_links">
			<h2>SIGNATURE BY NOA KIREL</h2>
			<?php
				wp_nav_menu( array(
					'menu'            => 'Footer',
					'container'       => 'nav',
					'menu_class'      => 'main-menu',
				) );
			?>
		</div>

		<div class="footer_wrapper_info_links">
			<?php
				wp_nav_menu( array(
					'menu'            => 'Terms',
					'container'       => 'nav',
					'menu_class'      => 'main-menu',
				) );
			?>
		</div>
		<div class="footer_wrapper_info_links">
			<h2>ניוזלטר</h2>
			<p>הישאר מעודכן עם הקולקציות החדשות, המוצרים וההצעות הבלעדיות.</p>
			<form class="form" action="#" method="post">
				<input type="email" name="" value="" placeholder="האימייל שלך">
				<button class="send" type="button" name="button">
					<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
					  <path d="M9.375 12.1875L4.6875 7.5L9.375 2.8125" stroke="#0B0B0B" stroke-width="0.9375" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</button>
			</form>
		</div>
	</div>

	<div class="footer_wrapper_copyright">
		<span>2025 © </span>
		<span>Made with </span>
	 	<a href="https://bsx.co.il/" target="_blank"> <img src="/wp-content/uploads/2025/05/logo2.png" alt="log"></a>
	</div>
</div>

</footer>


<?php do_action( 'storefront_before_footer' ); ?>


<?php wp_footer(); ?>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>



<a href="https://wa.me/972522819685?text=יש לי שאלה" class="whatsapp-share" target="_blank" aria-label="שתף בוואטסאפ">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 175.216 175.552" style="width:50px;height:50px" data-node-item="2822"><defs data-node-item="2823"><linearGradient id="b" x1="85.915" x2="86.535" y1="32.567" y2="137.092" gradientUnits="userSpaceOnUse" data-node-item="2824"><stop offset="0" stop-color="#57d163" data-node-item="2825"></stop><stop offset="1" stop-color="#23b33a" data-node-item="2826"></stop></linearGradient><filter id="a" width="1.115" height="1.114" x="-.057" y="-.057" color-interpolation-filters="sRGB" data-node-item="2827"><feGaussianBlur stdDeviation="3.531" data-node-item="2828"></feGaussianBlur></filter></defs><path fill="#b3b3b3" d="m54.532 138.45 2.235 1.324c9.387 5.571 20.15 8.518 31.126 8.523h.023c33.707 0 61.139-27.426 61.153-61.135.006-16.335-6.349-31.696-17.895-43.251A60.75 60.75 0 0 0 87.94 25.983c-33.733 0-61.166 27.423-61.178 61.13a60.98 60.98 0 0 0 9.349 32.535l1.455 2.312-6.179 22.558zm-40.811 23.544L24.16 123.88c-6.438-11.154-9.825-23.808-9.821-36.772.017-40.556 33.021-73.55 73.578-73.55 19.681.01 38.154 7.669 52.047 21.572s21.537 32.383 21.53 52.037c-.018 40.553-33.027 73.553-73.578 73.553h-.032c-12.313-.005-24.412-3.094-35.159-8.954zm0 0" filter="url(#a)" data-node-item="2829"></path><path fill="#fff" d="m12.966 161.238 10.439-38.114a73.42 73.42 0 0 1-9.821-36.772c.017-40.556 33.021-73.55 73.578-73.55 19.681.01 38.154 7.669 52.047 21.572s21.537 32.383 21.53 52.037c-.018 40.553-33.027 73.553-73.578 73.553h-.032c-12.313-.005-24.412-3.094-35.159-8.954z" data-node-item="2830"></path><path fill="url(#linearGradient1780)" d="M87.184 25.227c-33.733 0-61.166 27.423-61.178 61.13a60.98 60.98 0 0 0 9.349 32.535l1.455 2.312-6.179 22.559 23.146-6.069 2.235 1.324c9.387 5.571 20.15 8.518 31.126 8.524h.023c33.707 0 61.14-27.426 61.153-61.135a60.75 60.75 0 0 0-17.895-43.251 60.75 60.75 0 0 0-43.235-17.929z" data-node-item="2831"></path><path fill="url(#b)" d="M87.184 25.227c-33.733 0-61.166 27.423-61.178 61.13a60.98 60.98 0 0 0 9.349 32.535l1.455 2.313-6.179 22.558 23.146-6.069 2.235 1.324c9.387 5.571 20.15 8.517 31.126 8.523h.023c33.707 0 61.14-27.426 61.153-61.135a60.75 60.75 0 0 0-17.895-43.251 60.75 60.75 0 0 0-43.235-17.928z" data-node-item="2832"></path><path fill="#fff" fill-rule="evenodd" d="M68.772 55.603c-1.378-3.061-2.828-3.123-4.137-3.176l-3.524-.043c-1.226 0-3.218.46-4.902 2.3s-6.435 6.287-6.435 15.332 6.588 17.785 7.506 19.013 12.718 20.381 31.405 27.75c15.529 6.124 18.689 4.906 22.061 4.6s10.877-4.447 12.408-8.74 1.532-7.971 1.073-8.74-1.685-1.226-3.525-2.146-10.877-5.367-12.562-5.981-2.91-.919-4.137.921-4.746 5.979-5.819 7.206-2.144 1.381-3.984.462-7.76-2.861-14.784-9.124c-5.465-4.873-9.154-10.891-10.228-12.73s-.114-2.835.808-3.751c.825-.824 1.838-2.147 2.759-3.22s1.224-1.84 1.836-3.065.307-2.301-.153-3.22-4.032-10.011-5.666-13.647" data-node-item="2833"></path></svg>
</a>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    AOS.init({
      duration: 1000,
      once: true
    });
  });

	document.addEventListener('DOMContentLoaded', () => {
	  const translations = {
	    'Product': 'מוצר',
	    'Price': 'מחיר',
	    'Quantity': 'כמות',
	    'Subtotal': 'סיכום ביניים',
	    'Shipping': 'משלוח',
	    'Shipping charge': 'דמי משלוח',
	    'Total': 'סה״כ',
	    'Order Summary': 'סיכום הזמנה',
	    'Contact': 'איש קשר',
	    'Shipping address': 'כתובת למשלוח',
	    'Payment Method': 'אמצעי תשלום',
	    'Proceed to checkout': 'להמשך לתשלום',
	    'Place Order': 'בצע הזמנה',
	    'Your cart is empty': 'העגלה שלך ריקה',
	    'Apply coupon': 'הפעל קופון',
	    'Update cart': 'עדכן עגלה',
	    'Empty Cart': 'רוקן עגלה',
	    'Cart totals': 'סיכום עגלה',
	    'Delivery': 'משלוח',
	    'Payment': 'תשלום',
	    'Ship to a different address?': 'משלוח לכתובת אחרת?',
	    'Additional information': 'מידע נוסף',
	    'Order notes': 'הערות להזמנה',
	    'Coupon code': 'קוד קופון',
	    'Proceed to': 'המשך ל',
	    'Apartment, suite, unit, etc.': 'דירה, סוויטה, יחידה וכו\'',
	    '(optional)': '(אופציונלי)',
	    'Continue to fill details': 'המשך למילוי פרטים',
	    'Name:': 'שם:',
	    'Phone:': 'טלפון:'
	  };

	  function translateAttributes(el) {
	    ['title', 'alt', 'placeholder', 'aria-label', 'value', 'data-value'].forEach(attr => {
	      const val = el.getAttribute(attr);
	      if (val) {
	        Object.entries(translations).forEach(([eng, heb]) => {
	          if (val.includes(eng)) {
	            el.setAttribute(attr, val.replace(eng, heb));
	          }
	        });
	      }
	    });
	  }

	  function applyTranslations() {
	    const elements = document.querySelectorAll('body *');

	    elements.forEach(el => {
	      translateAttributes(el);

	      if (el.children.length === 0 && el.textContent.trim()) {
	        Object.entries(translations).forEach(([eng, heb]) => {
	          if (el.textContent.includes(eng)) {
	            el.innerHTML = el.innerHTML.replace(new RegExp(eng, 'g'), heb);
	          }
	        });
	      }
	    });
	  }

	  applyTranslations();

	  const observer = new MutationObserver(() => {
	    applyTranslations();
	  });

	  observer.observe(document.body, {
	    childList: true,
	    subtree: true
	  });
	});


	document.addEventListener('DOMContentLoaded', function () {
	  const input = document.querySelector('#billing_address_2');
	  if (input && input.value.trim() === '') {
	    input.value = 'דירה, סוויטה, יחידה';
	    input.classList.add('placeholder-simulation');

	    input.addEventListener('focus', function () {
	      if (input.value === 'דירה, סוויטה, יחידה') {
	        input.value = '';
	      }
	    });

	    input.addEventListener('blur', function () {
	      if (input.value.trim() === '') {
	        input.value = 'דירה, סוויטה, יחידה';
	      }
	    });
	  }
	});



	document.addEventListener('DOMContentLoaded', function () {
	  const observer = new MutationObserver(function (mutations) {
	    mutations.forEach(function (mutation) {
	      mutation.addedNodes.forEach(function (node) {
	        if (node.nodeType === 1 && node.classList.contains('woocommerce-notices-wrapper')) {
	          const notice = node.querySelector('.woocommerce-error, .woocommerce-message, .woocommerce-info');
	          if (notice) {
	            notice.style.transition = 'opacity 0.5s ease';
	            notice.style.opacity = '1';

	            setTimeout(() => {
	              notice.style.opacity = '0';
	              setTimeout(() => {
	                notice.style.display = 'none';
	              }, 500);
	            }, 3000);
	          }
	        }
	      });
	    });
	  });

	  observer.observe(document.body, {
	    childList: true,
	    subtree: true
	  });
	});

	// jQuery(function($) {
	//   $('.ajax_add_to_cart').on('click', function() {
	//     $('.loader-container').show();
	//
	//     setTimeout(function() {
	//       $('.ins-checkout-layout').addClass('active');
	//     }, 1000);
	//   });
	//
	//   $(document.body).on('added_to_cart', function() {
	//     $('.loader-container').fadeOut(150);
	//   });
	// });


</script>

<style>
  .add_to_cart_button {
    position: relative;
    overflow: hidden;
    display: flex !important;
    align-items: center;
    justify-content: center;
    padding: 12px 24px;
    background: linear-gradient(0deg, #C4982F -203.49%, #C29730 -128.98%, #F9F293 6.06%, #805020 155.07%, #644A17 262.17%) !important;
    border: none;
    color: white;
    font-weight: bold;
    cursor: pointer;
    border-radius: 8px;
    width: 100%;
    max-width: 300px;
  }

  .add_to_cart_button .btn-icon {
    position: relative;
    display: inline-block;
    z-index: 2;
  }

  .add_to_cart_button .btn-icon .icon-cart img {
    position: relative;
    transition: transform 0.3s ease;
  }

  .add_to_cart_button.is-animating .icon-cart img {
    animation: rotateAndShift 1s linear forwards;
  }

  @keyframes rotateAndShift {
    0% { transform: rotate(45deg); right: -15px; }
    10% { transform: rotate(75deg); right: -28px; }
    20% { transform: rotate(105deg); right: -41px; }
    30% { transform: rotate(135deg); right: -54px; }
    40% { transform: rotate(165deg); right: -67px; }
    50% { transform: rotate(195deg); right: -80px; }
    60% { transform: rotate(225deg); right: -93px; }
    70% { transform: rotate(255deg); right: -106px; }
    80% { transform: rotate(285deg); right: -119px; }
    90% { transform: rotate(315deg); right: -130px; }
    100% { transform: rotate(345deg); right: -140px; }
  }

  .add_to_cart_button .btn-text {
    position: relative;
    z-index: 1;
    color: var(--red, #2D0009);
    font-family: Ubuntu;
    font-size: 12px;
    font-weight: 400;
    letter-spacing: 0.673px;
    -webkit-text-stroke: 0.2px #2D0009;
  }

  .add_to_cart_button.is-animating::before {
    content: '';
    position: absolute;
    top: 0;
    left: 30%;
    width: 40%;
    height: 100%;
    background: linear-gradient(to right, transparent, #C29730, transparent);
    z-index: 2;
    pointer-events: none;
    animation: coverText 1s forwards;
  }

  @keyframes coverText {
    0% { left: 30%; }
    100% { left: 100%; }
  }

  .add_to_cart_button::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 24px;
    height: 24px;
    background: url('/wp-content/uploads/2025/05/right.svg') no-repeat center center;
    background-size: contain;
    transform: translate(-50%, -50%);
    opacity: 0;
    transition: opacity 0.3s ease 1s;
    z-index: 3;
  }

  .add_to_cart_button.anim-done::after {
    opacity: 1;
  }

  .add_to_cart_button.is-animating .btn-text {
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease;
  }

  .add_to_cart_button:before {
    content: none;
  }

  .add_to_cart_button.anim-done .icon-cart img {
    display: none;
  }
	.btn_add {
	  position: relative;
	  color: var(--red, #2D0009);
	  text-align: center;
	  font-size: 13.6px;
	  font-style: normal;
	  font-weight: 400;
	  line-height: 20.81px;
	  letter-spacing: 1.02px;
	  padding: 10px 30px 10px 60px;
	  border: 1px solid rgba(45, 0, 9, 0.70);
	  width: 100%;
	  max-width: 180px;
	  display: flex;
	  align-items: center;
	  justify-content: center;
	  transition: all .3s;
	  width: 100%;
	  gap: 20px;
	  padding: 10px;
		max-width: 280px !important;
	  outline: none !important;
	  border: none !important;
	}

.btn_add:before {
	content: none;
}

.btn_add {
  position: relative;
  color: var(--red, #2D0009);
  text-align: center;
  font-size: 13.6px;
  font-style: normal;
  font-weight: 400;
  line-height: 20.81px;
  letter-spacing: 1.02px;
  padding: 10px 30px 10px 60px;
  border: 1px solid rgba(45, 0, 9, 0.70);
  width: 100%;
  max-width: 180px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all .3s;
  width: 100%;
  gap: 20px;
  padding: 10px;
}

.perfume_wrapper_info a.ajax_add_to_cart span {
	margin: 0 !important;
	font-size: inherit;
	font-weight: inherit;
}
</style>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.add_to_cart_button').forEach(function(btn) {
      btn.addEventListener('click', () => {
        btn.classList.remove('anim-done', 'is-animating');
        void btn.offsetWidth;
        btn.classList.add('is-animating');
        setTimeout(() => {
          btn.classList.add('anim-done');
        }, 1000);
      });
    });
  });




</script>




</body>
</html>
