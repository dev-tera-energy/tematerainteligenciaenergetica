/* Navbar: a borda inferior só aparece depois do scroll.
   Alterna a classe .tera-nav--scrolled definida no design system. */
(function () {
  var nav = document.querySelector('[data-tera-nav]');
  if (!nav) return;

  var threshold = 8;
  var ticking = false;

  function apply() {
    nav.classList.toggle('tera-nav--scrolled', window.scrollY > threshold);
    ticking = false;
  }

  window.addEventListener(
    'scroll',
    function () {
      if (ticking) return;
      ticking = true;
      window.requestAnimationFrame(apply);
    },
    { passive: true }
  );

  apply();
})();
