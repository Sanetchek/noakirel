document.addEventListener('DOMContentLoaded', () => {
  const menu = document.getElementById('mobile-menu');
  const overlay = document.getElementById('mobile-menu-overlay');
  const menuToggle = document.querySelector('.menu-toggle');
  const body = document.body;

  if (menuToggle && menu && overlay) {
    menuToggle.addEventListener('click', () => {
      const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
      menuToggle.setAttribute('aria-expanded', !isExpanded);
      menuToggle.classList.toggle('active');
      menu.classList.toggle('active');
      overlay.classList.toggle('active');
      body.classList.toggle('no-scroll');
    });

    overlay.addEventListener('click', () => {
      menu.classList.remove('active');
      overlay.classList.remove('active');
      menuToggle.setAttribute('aria-expanded', 'false');
      menuToggle.classList.remove('active');
      body.classList.remove('no-scroll');
    });
  }
});