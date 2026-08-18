# Guia de Desenvolvimento

> Workflows práticos. Para comandos rápidos, veja `AGENTS.md`. Para entender o fluxo, veja [[arquitetura]].

## Pré-requisitos

- Local Sites (Local WP) rodando com o site ativo
- `composer install` executado (Timber disponível)
- `yarn install` executado (Tailwind CLI disponível)

## Desenvolvimento Local

1. Abra o terminal na raiz do tema.
2. Execute `yarn dev` — inicia o Tailwind em modo watch.
3. Edite templates em `views/` ou PHP em `*.php`.
4. Recarregue o navegador — o CSS é recompilado automaticamente.

## Criar uma Nova Rota ou Página

1. Crie o controller PHP em `controllers/` (ex.: `controllers/page-sobre.php`):
   ```php
   <?php
   $context = Timber\Timber::context();
   $context['post'] = Timber\Timber::get_post();
   Timber\Timber::render( 'pages/sobre.twig', $context );
   ```
2. Crie o stub de 1 linha na raiz do tema (ex.: `page-sobre.php`):
   ```php
   <?php require_once __DIR__ . '/controllers/page-sobre.php';
   ```
3. Crie a view Twig em `views/pages/sobre.twig` estendendo `base.twig`.
4. Crie a página correspondente no painel do WordPress se necessário.

## Criar um Partial (Componente Reutilizável)

1. Crie o arquivo em `views/partials/` (ex: `views/partials/card.twig`).
2. Inclua onde necessário: `{% include 'partials/card.twig' with { post: post } %}`.

## Criar um Novo Template de Seção

1. Crie o arquivo em `views/` (ex: `views/section-hero.twig`).
2. Inclua no template pai: `{% include 'section-hero.twig' %}`.

## Adicionar JavaScript

1. Crie o arquivo em `src/js/` (ex: `src/js/meu-modulo.js`) — vanilla, sem dependência de framework.
2. Adicione o nome do módulo (sem `.js`) ao array `foreach` em `inc/assets.php`. O enfileiramento, versionamento (`filemtime`) e dependência do Lucide (quando aplicável) já são tratados pelo loop existente — não crie um novo `wp_enqueue_script` manual.

## Links
- [[index|← Voltar ao índice]]
- [[arquitetura]] — entender o fluxo antes de criar
- [[estrutura-de-pastas]] — onde colocar cada arquivo
