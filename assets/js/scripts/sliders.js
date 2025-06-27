document.addEventListener('DOMContentLoaded', () => {
  const gallery = document.querySelector('#hero2_gallery');

  if (gallery) {
    const observer = new MutationObserver(() => {
      new Swiper('#hero2_gallery', {
        loop: true,
        autoplay: {
          delay: 3500,
          disableOnInteraction: false,
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
      });
      observer.disconnect();
    });

    observer.observe(gallery, {
      childList: true,
      subtree: true
    });
  }

  new Swiper('.home2-collection-list', {
    loop: true,
    slidesPerView: 1,
    spaceBetween: 20,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      768: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 3,
      },
      1200: {
        slidesPerView: 4,
      },
    },
  });

  new Swiper('#shop_gallery', {
    loop: true,
    slidesPerView: 1,
    navigation: {
      nextEl: '.swiper-shop-next',
      prevEl: '.swiper-shop-prev',
    },
  });
});
