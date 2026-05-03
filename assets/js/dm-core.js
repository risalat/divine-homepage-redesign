(function () {
  const roots = document.querySelectorAll('.dm-home, .dm-global-chrome');
  if (!roots.length) return;

  roots.forEach(function (root) {
    const toggle = root.querySelector('.dm-menu-toggle');
    const nav = root.querySelector('.dm-primary-nav');

    if (toggle && nav) {
      toggle.addEventListener('click', function () {
        const isOpen = root.classList.toggle('dm-nav-open');
        toggle.setAttribute('aria-expanded', String(isOpen));
      });
    }

    root.querySelectorAll('a[href^="#"]').forEach(function (link) {
      link.addEventListener('click', function (event) {
        const target = document.querySelector(link.getAttribute('href'));
        if (!target) return;
        event.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    });
  });
})();
