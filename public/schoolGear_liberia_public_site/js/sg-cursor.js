(function () {
  'use strict';
  // Only for devices with a real mouse; skip touch screens and reduced-motion users
  if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  function init() {
    if (document.querySelector('.sg-cursor-dot')) return;
    var dot = document.createElement('div');
    var ring = document.createElement('div');
    dot.className = 'sg-cursor-dot';
    ring.className = 'sg-cursor-ring';
    dot.setAttribute('aria-hidden', 'true');
    ring.setAttribute('aria-hidden', 'true');
    document.body.appendChild(dot);
    document.body.appendChild(ring);
    document.documentElement.classList.add('sg-cursor-on');

    var hovering = false;
    var INTERACTIVE = 'a, button, label, summary, select, [role="button"], input[type="submit"], input[type="button"], input[type="checkbox"], input[type="radio"], .btn, [data-hover]';
    var TEXTFIELD = 'input:not([type="submit"]):not([type="button"]):not([type="checkbox"]):not([type="radio"]), textarea, [contenteditable="true"]';

    window.addEventListener('mousemove', function (e) {
      var overText = e.target.closest && e.target.closest(TEXTFIELD);
      dot.classList.toggle('sg-cursor-hidden', !!overText);
      ring.classList.toggle('sg-cursor-hidden', !!overText);
      if (overText) return;
      dot.style.opacity = 1;
      ring.style.opacity = 1;
      dot.style.transform = 'translate3d(' + (e.clientX - 4) + 'px,' + (e.clientY - 4) + 'px,0)';
      ring.style.transform = 'translate3d(' + (e.clientX - 20) + 'px,' + (e.clientY - 20) + 'px,0) scale(' + (hovering ? 1.5 : 1) + ')';
    }, { passive: true });

    // Event delegation: also works for elements added later
    document.addEventListener('mouseover', function (e) {
      if (e.target.closest && e.target.closest(INTERACTIVE)) { hovering = true; ring.classList.add('sg-cursor-hover'); }
    });
    document.addEventListener('mouseout', function (e) {
      if (e.target.closest && e.target.closest(INTERACTIVE)) { hovering = false; ring.classList.remove('sg-cursor-hover'); }
    });
    document.documentElement.addEventListener('mouseleave', function () {
      dot.style.opacity = 0; ring.style.opacity = 0;
    });
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
