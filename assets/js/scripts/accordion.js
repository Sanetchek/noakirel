document.addEventListener('DOMContentLoaded', function() {
  const accordionTitles = document.querySelectorAll('.accordion-title');

  accordionTitles.forEach(title => {
    title.addEventListener('click', function() {
      const container = this.closest('.accordion-item');
      const isOpen = this.classList.contains('active');

      document.querySelectorAll('.accordion-item').forEach(item => {
        item.classList.remove('active');
      });

      // Toggle the clicked item
      if (!isOpen) {
        container.classList.add('active');
      }
    });
  });
});