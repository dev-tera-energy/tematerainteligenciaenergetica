/* smooth-scroll.js
 * Intercepta cliques em links de âncora (#id) e anima o scroll via JS,
 * ignorando a propriedade CSS scroll-behavior (que tem suporte inconsistente).
 *
 * Curva: ease-in-out cúbico — aceleração suave na saída, desaceleração suave na chegada.
 * Duração máxima: 800ms (ajustada proporcionalmente à distância percorrida).
 * Offset: altura da navbar fixa (--nav-h = 76px), evitando que o título fique atrás do header.
 */
(function () {
  var NAV_H  = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--nav-h') || '76', 10);
  var MAX_MS = 800;
  var MIN_MS = 200;

  /* Curva cúbica ease-in-out: t deve estar entre 0 e 1. */
  function ease(t) {
    return t < 0.5
      ? 4 * t * t * t
      : 1 - Math.pow(-2 * t + 2, 3) / 2;
  }

  function scrollTo(target, duration) {
    var startY = window.scrollY;
    var rect   = target.getBoundingClientRect();
    var endY   = startY + rect.top - NAV_H;
    var diff   = endY - startY;
    var startT = null;

    /* Se já está no lugar (diferença < 2px), não anima. */
    if (Math.abs(diff) < 2) return;

    function step(timestamp) {
      if (!startT) startT = timestamp;
      var elapsed  = timestamp - startT;
      var progress = Math.min(elapsed / duration, 1);
      window.scrollTo(0, startY + diff * ease(progress));
      if (progress < 1) requestAnimationFrame(step);
    }

    requestAnimationFrame(step);
  }

  document.addEventListener('click', function (e) {
    var link = e.target.closest('a[href]');
    if (!link) return;

    var href = link.getAttribute('href');

    /* Aceita tanto '#secao' quanto '/outra-pagina#secao'. */
    var hashIndex = href.indexOf('#');
    if (hashIndex === -1) return;

    var hash = href.slice(hashIndex);
    var path = href.slice(0, hashIndex);

    /* Ignora links para outras páginas (path diferente da atual). */
    if (path && path !== window.location.pathname && path !== window.location.href.split('#')[0]) return;

    var id     = hash.slice(1); /* remove o '#' */
    var target = id ? document.getElementById(id) : document.documentElement;
    if (!target) return;

    e.preventDefault();

    /* Duração proporcional à distância, entre MIN_MS e MAX_MS. */
    var dist     = Math.abs(target.getBoundingClientRect().top - NAV_H);
    var duration = Math.min(MAX_MS, Math.max(MIN_MS, dist * 0.5));

    scrollTo(target, duration);

    /* Atualiza a URL sem disparar scroll nativo. */
    if (id) history.pushState(null, '', hash);
  });
})();
