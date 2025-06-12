document.addEventListener('DOMContentLoaded', () => {
  const gallery = document.querySelector('#hero2_gallery');
  const observer = new MutationObserver(() => {
    const hero2Gallery = new Swiper('#hero2_gallery', {
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

  const hero2Collection = new Swiper('.home2-collection-list', {
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
      1200: {
        slidesPerView: 4,
      },
      992: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 2,
      },
    },
  });
});