/* Ícones: Lucide é a biblioteca oficial da Tera.
   Aplica os padrões de traço da marca em todo [data-lucide] do DOM. */
(function () {
  function hydrate() {
    if (!window.lucide) return;
    window.lucide.createIcons({
      attrs: {
        'stroke-width': 2,
        'stroke-linecap': 'round',
        'stroke-linejoin': 'round',
      },
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', hydrate);
  } else {
    hydrate();
  }
})();
