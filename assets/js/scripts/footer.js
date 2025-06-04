document.addEventListener('DOMContentLoaded', function () {
  AOS.init({
    duration: 1000,
    once: true
  });

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

  document.querySelectorAll('.add_to_cart_button').forEach(function (btn) {
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