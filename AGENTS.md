# AGENTS.md — Fonte de Verdade

> Este arquivo é a **única fonte de verdade** do projeto.
> Todos os agentes de IA devem lê-lo antes de qualquer ação.
> O segundo cérebro (`docs/`) complementa — nunca repete — o que está aqui.

---

## Projeto

**Tera Inteligência Energética** — site institucional.

## Stack

| Camada       | Tecnologia            | Versão   |
| ------------ | --------------------- | -------- |
| CMS          | WordPress             | latest   |
| Templating   | Timber                | ^2.5     |
| Views        | Twig                  | (via Timber) |
| CSS          | Tailwind CSS          | ^4.3     |
| CLI CSS      | @tailwindcss/cli       | ^4.3     |
| Pkg manager  | Yarn                  | —        |
| Ambiente     | Local Sites (Local WP) | —        |

## Arquitetura MVC

O tema (importado do Claude Design — protótipo `Site Tera.dc.html`) é um **one-page institucional + blog** e segue MVC; ver [`README.md`](./README.md) para o mapa completo protótipo → tema. A home (`front-page.php`) concentra todas as seções institucionais ancoradas por `#id` (`#servicos`, `#metodo`, `#sobre`, `#boletim`, `#contato`); não existem páginas WordPress separadas para elas. O conteúdo editorial (artigos, boletins, cases...) são posts normais, listados em `/conteudo/`.

- **Controller (PHP)** — um arquivo por rota, dentro de `controllers/` (`controllers/front-page.php`, `controllers/single.php`, etc.). Monta o contexto e chama `Timber::render()`. Nenhuma marcação vive aqui. Na raiz do tema existem **stubs de 1 linha** (ex: `front-page.php` → `require controllers/front-page.php`) que o WordPress encontra pela hierarquia nativa e que delegam imediatamente para o controller real.
- **Model (`inc/`)** — `inc/site-data.php` e `inc/content.php` guardam o conteúdo institucional (serviços, etapas, valores, FAQ, números) como arrays PHP; `inc/context.php` monta o contexto global e o de listagens. `inc/setup.php`, `inc/assets.php`, `inc/twig.php` e `inc/forms.php` cuidam de configuração do tema, enfileiramento de CSS/JS, extensões Twig e formulários (via `admin-post.php`).
- **View (`views/*.twig`)** — passiva: `views/base.twig` é o layout, `views/pages/*.twig` são as telas (`home`, `blog`, `artigo`, `busca`, `pagina-generica`), `views/partials/*.twig` os componentes reutilizáveis.
- **Componentes de marca (`src/css/main.css`)** — classes como `.tera-btn`, `.tera-card`, `.t-eyebrow`, `.tera-tag`, `.tera-step`, `.tera-nav`, `.tera-field`/`.tera-input` são portadas quase literalmente do design system do Claude Design, para manter fidelidade visual; usadas junto com utilities do Tailwind nas views.

## Mapa de Arquivos

| Preciso…                          | Vá para                          |
| --------------------------------- | -------------------------------- |
| Configurar o tema WordPress       | `style.css` (cabeçalho do tema)  |
| Bootstrap do tema / carregar Timber e `inc/` | `functions.php`        |
| Roteamento / Controllers          | `controllers/*.php`              |
| Dados institucionais (serviços, FAQ, valores...) | `inc/content.php`, `inc/site-data.php` |
| Contexto global do Timber          | `inc/context.php`                |
| Enfileiramento de CSS/JS           | `inc/assets.php`                 |
| Extensões Twig (filtros/funções)   | `inc/twig.php`                   |
| Processamento de formulários       | `inc/forms.php`                  |
| Configuração MCP (agentes de IA)   | `.agents/mcp_config.json`        |
| Layout base (head/navbar/footer)   | `views/base.twig`                |
| Telas (uma por rota)               | `views/pages/*.twig`             |
| Componentes reutilizáveis          | `views/partials/*.twig`          |
| Input do Tailwind                  | `src/css/main.css`               |
| Scripts (navbar, reveal, ícones)   | `src/js/*.js`                    |
| CSS compilado (output)             | `dist/main.css`                  |
| Logos da marca (SVG)               | `dist/logos/`                    |
| Dependências PHP                  | `composer.json`                  |
| Dependências JS/CSS               | `package.json`                   |
| Documentação detalhada            | `docs/` (cofre Obsidian)         |

## Comandos

```bash
# Compilar Tailwind em modo watch
yarn dev

# Compilar Tailwind minificado (produção)
yarn build

# Instalar dependências PHP
composer install

# Instalar dependências JS
yarn install
```

## Servidor MCP WordPress (`wp-local`)

O projeto dispõe de um servidor MCP local configurado para permitir que agentes de IA interajam diretamente com a instância do WordPress.

- **Configuração:** `.agents/mcp_config.json`
- **Servidor:** `C:\Users\lucas\Local Sites\site-tera\wp-mcp-server\index.js`
- **Autenticação:** Baseada em Application Passwords no `.env` do diretório do servidor (`WP_URL`, `WP_USER`, `WP_APP_PASSWORD`).

### Ferramentas MCP Disponíveis

| Ferramenta | Descrição | Parâmetros Principais |
| :--- | :--- | :--- |
| `create_wp_post` | Cria e publica posts via WP REST API | `title` (string), `content` (string HTML/texto), `excerpt` (string opcional) |

> **Orientação para Agentes:** Quando for solicitado criar, publicar ou manipular dados no WordPress via MCP, utilize a ferramenta `create_wp_post` do servidor `wp-local`.


## Convenções de Código

1. **Idioma** — comentários, commits e documentação em **português brasileiro**.
2. **PHP** — seguir padrões do WordPress; usar Timber/Twig para views.
3. **Twig** — um template por arquivo em `views/`. Partials em `views/partials/`.
4. **Tailwind** — utility-first. Classes diretamente no HTML/Twig. Custom tokens via `@theme` quando necessário.
5. **Nomeação de arquivos** — `kebab-case` para templates e docs. `camelCase` ou WordPress-style para PHP.
6. **Sem dependências desnecessárias** — não instale pacotes sem necessidade clara.

## Regra de Ouro para Documentação

> **Não repita — referencie.**

- `AGENTS.md` contém stack, mapa e convenções.
- `docs/` contém arquitetura, decisões e guias detalhados.
- Cada doc em `docs/` deve **referenciar** `AGENTS.md` quando precisar de informações que já existem aqui — nunca copiar.
- Agentes devem consultar `docs/regras-para-agentes.md` antes de criar ou editar documentação.

## Segundo Cérebro (docs/)

A pasta `docs/` é um cofre Obsidian com documentação atômica interligada por `[[wikilinks]]`. Ponto de entrada: `docs/index.md`.

Os agentes devem:
1. Ler `AGENTS.md` (este arquivo) primeiro.
2. Consultar `docs/index.md` para navegar o segundo cérebro.
3. Seguir `docs/regras-para-agentes.md` ao criar ou editar docs.
