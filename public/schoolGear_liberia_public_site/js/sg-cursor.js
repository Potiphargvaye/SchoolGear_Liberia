(function () {
  'use strict';

  var INTERACTIVE = 'a, button, label, summary, select, [role="button"], input[type="submit"], input[type="button"], input[type="checkbox"], input[type="radio"], .btn, [data-hover]';
  var TEXTFIELD = 'input:not([type="submit"]):not([type="button"]):not([type="checkbox"]):not([type="radio"]), textarea, [contenteditable="true"]';

  function init() {
    if (document.querySelector('.sg-cursor-dot')) return;

    var root = document.documentElement;
    var dot = document.createElement('div');
    var ring = document.createElement('div');
    dot.className = 'sg-cursor-dot';
    ring.className = 'sg-cursor-ring';
    dot.setAttribute('aria-hidden', 'true');
    ring.setAttribute('aria-hidden', 'true');
    document.body.appendChild(dot);
    document.body.appendChild(ring);

    var hovering = false;
    var lastTouch = 0;
    var hideTimer = null;

    function place(x, y, scale) {
      dot.style.transform = 'translate3d(' + (x - 4) + 'px,' + (y - 4) + 'px,0)';
      ring.style.transform = 'translate3d(' + (x - 20) + 'px,' + (y - 20) + 'px,0) scale(' + scale + ')';
    }
    function show() {
      dot.classList.remove('sg-cursor-hidden');
      ring.classList.remove('sg-cursor-hidden');
      dot.style.opacity = 1;
      ring.style.opacity = 1;
    }
    function hide() {
      dot.style.opacity = 0;
      ring.style.opacity = 0;
    }
    function setHover(el) {
      hovering = !!(el && el.closest && el.closest(INTERACTIVE));
      ring.classList.toggle('sg-cursor-hover', hovering);
    }
    function overText(el) {
      return !!(el && el.closest && el.closest(TEXTFIELD));
    }

    /* ---------- Mouse (desktop) ---------- */
    window.addEventListener('mousemove', function (e) {
      // Ignore the fake mouse events phones send right after a touch
      if (Date.now() - lastTouch < 600) return;
      root.classList.add('sg-cursor-on');   // hide the native cursor only for real mice
      if (overText(e.target)) {
        dot.classList.add('sg-cursor-hidden');
        ring.classList.add('sg-cursor-hidden');
        return;
      }
      show();
      setHover(e.target);
      place(e.clientX, e.clientY, hovering ? 1.5 : 1);
    }, { passive: true });

    document.documentElement.addEventListener('mouseleave', hide);

    /* ---------- Touch (phones and tablets) ---------- */
    function onTouch(e) {
      lastTouch = Date.now();
      root.classList.remove('sg-cursor-on'); // never hide the native cursor on touch
      var t = (e.touches && e.touches[0]) || (e.changedTouches && e.changedTouches[0]);
      if (!t) return;
      clearTimeout(hideTimer);
      if (overText(e.target)) { hide(); return; }
      show();
      setHover(e.target);
      place(t.clientX, t.clientY, hovering ? 1.9 : 1.5);
    }
    function endTouch() {
      lastTouch = Date.now();
      clearTimeout(hideTimer);
      hideTimer = setTimeout(hide, 350);
    }
    document.addEventListener('touchstart', onTouch, { passive: true });
    document.addEventListener('touchmove', onTouch, { passive: true });
    document.addEventListener('touchend', endTouch, { passive: true });
    document.addEventListener('touchcancel', endTouch, { passive: true });
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();