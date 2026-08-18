# Estrutura de Pastas

> Complementa o mapa resumido de `AGENTS.md` com explicações de propósito. Não repete o mapa — adiciona profundidade.

```
terainteligenciaenergetica/
│
├── .agents/               # Configurações de agentes e servidores MCP
│   └── mcp_config.json    # Declaração do servidor MCP local (wp-local)
├── AGENTS.md              # Fonte de verdade (leia primeiro)
├── CLAUDE.md              # Ponteiro → AGENTS.md
├── README.md              # Resumo rápido do projeto
├── style.css              # Cabeçalho obrigatório do tema WP
├── functions.php          # Bootstrap: Timber init + carregamento de inc/
├── screenshot.png         # Imagem de preview na tela de temas
│
├── front-page.php         # ┐
├── single.php             # │ Stubs de 1 linha — o WordPress os encontra
├── archive.php            # │ pela hierarquia nativa e cada um delega
├── page.php               # │ para o controller correspondente em
├── search.php             # │ controllers/ via require_once.
├── 404.php                # │
├── index.php              # ┘
│
├── controllers/           # Controllers PHP (lógica real, um por rota)
│   ├── front-page.php     # Home institucional one-page
│   ├── single.php         # Artigo individual do blog
│   ├── archive.php        # Arquivo por categoria/tag
│   ├── page.php           # Página estática WP
│   ├── search.php         # Busca
│   ├── 404.php            # Página não encontrada
│   └── index.php          # Listagem do blog (/conteudo/)
│
├── inc/                   # Model / lógica de negócio e configuração do tema
│   ├── setup.php          # Suportes do tema, menus, tamanhos de imagem
│   ├── assets.php         # Enfileiramento de CSS/JS
│   ├── context.php        # Contexto global e de listagens
│   ├── content.php        # Dados editoriais e conteúdo institucional
│   ├── site-data.php      # Dados estruturais do site
│   ├── twig.php           # Filtros e funções customizadas Twig
│   └── forms.php          # Handlers de formulários
│
├── views/                 # Views Twig (passivas)
│   ├── base.twig          # Layout base
│   ├── pages/             # Telas completas
│   └── partials/          # Componentes reutilizáveis
│
├── src/                   # Código-fonte (CSS, JS)
├── dist/                  # CSS compilado e logos
├── composer.json          # Dependências PHP (Timber ^2.5)
├── package.json           # Dependências de build (Tailwind v4)
└── docs/                  # Cofre Obsidian — segundo cérebro
```

## Notas Importantes

- **Stubs na raiz ≠ controllers em `controllers/`**. Os stubs existem apenas para a hierarquia nativa do WordPress. Toda lógica vive nos controllers. Ao criar uma nova rota, crie o controller em `controllers/` **e** o stub correspondente na raiz.
- **`style.css` (raiz)** ≠ **`dist/main.css`**. O da raiz é apenas o cabeçalho de metadados do tema WordPress. O de `dist/` é o CSS compilado real.
- **`vendor/`** e **`node_modules/`** nunca devem ser commitados.

## Links
- [[index|← Voltar ao índice]]
- [[arquitetura]] — como essas pastas se conectam no fluxo
