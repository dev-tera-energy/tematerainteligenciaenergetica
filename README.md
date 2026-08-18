# Tema Tera (Timber + Twig + Tailwind v4)

Implementação do protótipo `Site Tera.dc.html` (Claude Design) como tema WordPress com renderização 100% no servidor.

## Arquitetura

O site é um **one-page institucional + blog**: a home concentra todas as seções institucionais (hero, serviços, método, missão/valores, sobre, boletim, diagnóstico) ancoradas por `#id`; o conteúdo editorial vive em posts normais do WordPress, listados em `/conteudo/` e abertos em `single.php`.

- **Controller (PHP)** — um arquivo por rota, na pasta `controllers/` (`controllers/front-page.php`, `controllers/single.php`, `controllers/archive.php`, etc.). Cada um monta o contexto com `Timber::context()` e chama `Timber::render()`. Nenhuma marcação vive aqui.
- **Model (`inc/`)** — `site-data.php` e `content.php` guardam o conteúdo institucional (serviços, etapas, valores, FAQ, números) como arrays PHP. `context.php` monta o contexto global e o de listagens. Trocar por ACF no futuro é só reescrever o corpo dessas funções: os controllers e as views não mudam.
- **View (`views/*.twig`)** — puramente passiva. Sem `<?php`, sem WP_Query, só variáveis e loops sobre o que chegou do controller.
- **Componentes de marca (`src/css/main.css`)** — os tokens e classes (`.tera-btn`, `.tera-card`, `.t-eyebrow`, `.tera-tag`, `.tera-step`, `.tera-nav`, `.tera-field`/`.tera-input`) são portados quase literalmente do design system do projeto Claude Design, para manter fidelidade visual.

## Instalação

```
composer install
yarn install
yarn build   # ou yarn dev, para recompilar ao salvar
```

Ative o tema no painel do WordPress:
1. As categorias editoriais e a página `/conteudo/` vinculada à listagem de posts são configuradas automaticamente.
2. Cadastre o menu principal em Aparência → Menus, na posição "Navegação principal" (sem menu cadastrado, a navbar usa o fallback em `tera_nav_fallback()`, com âncoras para as seções da home).

## Mapa: protótipo → tema

| Seção/tela do protótipo (`Site Tera.dc.html`) | Onde vive |
|---|---|
| Home (`pgHome`: hero, serviços, método, sobre, boletim, contato) | `front-page.php` → `controllers/front-page.php` → `views/pages/home.twig`, seções `#inicio` `#servicos` `#metodo` `#sobre` `#boletim` `#contato` |
| Blog / conteúdo (`pgBlog`) | `index.php`, `archive.php`, `search.php` → `controllers/index.php` → `views/pages/blog.twig`, `busca.twig` |
| Artigo (`pgArtigo`) | `single.php` → `controllers/single.php` → `views/pages/artigo.twig` |

## O que mudou de estado de React (SPA) para SSR nativo

- **Navegação por âncora/página** (`goHome`/`jump('servicos')` etc.) → links reais (`<a href="#servicos">`, `href="{{ home_url }}#servicos"` fora da home), com animação suave de subida/descida controlada em `src/js/smooth-scroll.js`.
- **Navbar com borda ao scroll** → `src/js/navbar.js` (progressive enhancement puro; funciona sem JS, só sem a transição de borda).
- **Accordion do FAQ** → `<details>/<summary>` nativo em `home.twig`, sem JavaScript algum.
- **Filtro de categoria do blog** → links reais para a categoria (`get_category_link`), cada filtro é uma URL indexável.
- **Formulários de diagnóstico e boletim** → POST nativo para `admin-post.php` (`inc/forms.php`), com redirect e query string (`?enviado=1`, `?inscrito=1`) fazendo o papel do `useState` do protótipo.
- **Reveal ao rolar** → `src/js/reveal.js`, com `IntersectionObserver` e respeito a `prefers-reduced-motion`.

## Conteúdo ainda como rascunho

Os textos de blog do protótipo eram propostas de pauta, não posts reais. Publique-os como posts do WordPress nas categorias correspondentes; o tema não tem dados de blog fixos, tudo vem do `WP_Query`. O número de "textos publicados" na barra de estatísticas da home é contado automaticamente (`wp_count_posts()`).
