(function () {
  if (!document.body.classList.contains('dm-single-post-polish')) return;

  const progress = document.querySelector('.dm-reading-progress span');
  function updateProgress() {
    if (!progress) return;
    const doc = document.documentElement;
    const scrollTop = window.scrollY || doc.scrollTop || 0;
    const height = Math.max(1, doc.scrollHeight - window.innerHeight);
    progress.style.width = Math.min(100, Math.max(0, (scrollTop / height) * 100)) + '%';
  }
  window.addEventListener('scroll', updateProgress, { passive: true });
  window.addEventListener('resize', updateProgress);
  updateProgress();

  const content = document.querySelector('.dm-post-reading-main, .entry-content, .post-content, article .content, main article');
  if (!content) return;

  content.querySelectorAll('p, div').forEach(function (el) {
    const txt = (el.textContent || '').trim().toLowerCase();
    if (txt.startsWith('key takeaway:') || txt.includes('key takeaway:')) {
      el.classList.add('dm-key-takeaway-box');
    }
  });

  const headings = Array.from(content.querySelectorAll('h2, h3')).filter(function (h) {
    return h.textContent.trim().length > 0 && !h.closest('.dm-post-continue, .dm-post-related');
  }).slice(0, 18);

  const tocCard = document.querySelector('[data-dm-post-toc-card]');
  const toc = document.querySelector('[data-dm-post-toc]');

  if (toc && headings.length >= 3) {
    headings.forEach(function (heading, index) {
      if (!heading.id) heading.id = 'dm-section-' + (index + 1) + '-' + heading.textContent.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
      const a = document.createElement('a');
      a.href = '#' + heading.id;
      a.textContent = heading.textContent.trim();
      if (heading.tagName.toLowerCase() === 'h3') a.className = 'dm-post-toc-h3';
      toc.appendChild(a);
    });
    if (tocCard) tocCard.hidden = false;
  }
})();
