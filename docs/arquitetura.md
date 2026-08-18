# Arquitetura

> Este documento explica **como** as peças se conectam. Para saber **quais** são as peças (stack, versões, mapa de arquivos), consulte `AGENTS.md`.

## Fluxo de Renderização

```
Requisição HTTP
      │
      ▼
  WordPress (core)
      │  Identifica o template via hierarchy
      ▼
  front-page.php (stub na raiz — 1 linha)
      │  require_once controllers/front-page.php
      ▼
  controllers/front-page.php
      │  Monta contexto via Timber::context()
      │  Consulta dados via Timber::get_posts() / funções de inc/
      ▼
  Timber::render('pages/home.twig', $context)
      │  Timber processa o template Twig
      │  Injeta variáveis do contexto WordPress
      ▼
  views/pages/home.twig (+ base.twig + partials/)
      │  Gera HTML com classes Tailwind
      │  wp_head() / wp_footer() carregam assets
      ▼
  HTML final + dist/main.css (Tailwind compilado)
```

## Papel de Cada Camada

### WordPress Core
Gerencia rotas, autenticação, banco de dados e o loop de conteúdo. O tema **não** sobrescreve o core — apenas consome sua API via Timber.

### Stubs (raiz) → Controllers (`controllers/`)
Os stubs na raiz são arquivos de 1 linha que o WordPress encontra pela hierarquia nativa. Delegam imediatamente para o controller real em `controllers/`. Isso mantém a raiz limpa sem quebrar a mecânica nativa do WordPress.

### Timber + Twig
Separa lógica (PHP) de apresentação (Twig). O PHP em `controllers/` monta o contexto; o Twig em `views/` renderiza. Isso garante:
- Views limpas sem lógica de negócio
- Reutilização via `{% include %}` e `{% extends %}`
- Contexto tipado e previsível

### Tailwind CSS
Compilado via `@tailwindcss/cli`. O input é `src/css/main.css`, que escaneia `.php` e `.twig` para gerar `dist/main.css`. O enfileiramento em `inc/assets.php` usa cache-busting via `filemtime()`.

## Diagrama de Dependências

```
composer.json    → Timber (PHP)
package.json     → Tailwind CSS (build-time)
functions.php    → inicializa Timber + carrega inc/
inc/assets.php   → enfileira dist/main.css + scripts de src/js/
src/css/main.css → configura scan de classes (@source) + tokens + componentes
```

## Links
- [[index|← Voltar ao índice]]
- [[estrutura-de-pastas]] — detalhes de cada pasta
- [[guia-de-desenvolvimento]] — como criar novos templates
