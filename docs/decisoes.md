# Decisões Técnicas (ADR)

> Registro cronológico de decisões arquiteturais. Cada entrada é imutável após criada — novas decisões que revertem anteriores devem ser registradas como novas entradas.

---

## ADR-001 — Timber + Twig como engine de templates

- **Data:** 2025 (setup inicial)
- **Status:** Aceita
- **Contexto:** WordPress mistura PHP com HTML nos templates tradicionais, dificultando manutenção e separação de responsabilidades.
- **Decisão:** Usar Timber v2 + Twig para separar lógica (PHP) de apresentação (Twig).
- **Consequências:** Views limpas e reutilizáveis. Dependência do pacote `timber/timber` via Composer.

---

## ADR-002 — Tailwind CSS v4 com CLI

- **Data:** 2025 (setup inicial)
- **Status:** Aceita
- **Contexto:** Necessidade de um sistema CSS produtivo sem overhead de configuração complexa.
- **Decisão:** Usar Tailwind v4 com `@tailwindcss/cli`. Input em `tailwind.css`, output em `assets/css/style.css`.
- **Consequências:** Build simples via `yarn dev`. Sem PostCSS explícito. Scan de classes configurado com `@source` no input CSS.

---

## ADR-003 — Local Sites como ambiente de desenvolvimento

- **Data:** 2025 (setup inicial)
- **Status:** Aceita
- **Contexto:** Necessidade de ambiente WordPress local rápido e sem configuração manual de servidor.
- **Decisão:** Usar Local Sites (Local WP) para desenvolvimento local.
- **Consequências:** Setup simplificado. Caminho do tema em `~/Local Sites/site-tera/app/public/wp-content/themes/`.

---

## ADR-004 — Cofre Obsidian como segundo cérebro

- **Data:** 2025 (setup documentação)
- **Status:** Aceita
- **Contexto:** Agentes de IA precisam de contexto estruturado e navegável. Humanos precisam de documentação viva.
- **Decisão:** Usar a pasta `docs/` como cofre Obsidian com documentação atômica interligada por `[[wikilinks]]`.
- **Consequências:** Documentação navegável em grafo. Compatível com Obsidian e com leitura direta em markdown.

---

## ADR-005 — AGENTS.md como fonte de verdade única

- **Data:** 2025 (setup documentação)
- **Status:** Aceita
- **Contexto:** Múltiplos agentes de IA (Antigravity, Claude, etc.) precisam de um ponto de entrada canônico para evitar informações conflitantes.
- **Decisão:** `AGENTS.md` na raiz contém stack, convenções e mapa de arquivos. Demais docs referenciam — nunca repetem.
- **Consequências:** Um único lugar para atualizar informações de stack. Docs em `docs/` focam em profundidade e decisões.

---

## ADR-006 — Arquitetura MVC com Controllers e Stubs na Raiz

- **Data:** 2026-08
- **Status:** Aceita
- **Contexto:** A raiz do tema continha múltiplos arquivos PHP misturando responsabilidades de roteamento e bootstrap. Ao mesmo tempo, o WordPress exige que os templates da hierarquia nativa existam na raiz para resolver as rotas sem filtros frágeis de template.
- **Decisão:** Manter toda a lógica e chamadas `Timber::render()` dentro da pasta `controllers/` e usar stubs de 1 linha na raiz (`require_once __DIR__ . '/controllers/...'`), além de mapear automaticamente a rota `/conteudo/` para a listagem do blog.
- **Consequências:** Raiz limpa e organizada, conformidade total com a hierarquia nativa do WordPress e separação clara entre Controller (PHP) e View (Twig).

---

## ADR-007 — Servidor MCP Local para Operações no WordPress por Agentes

- **Data:** 2026-08
- **Status:** Aceita
- **Contexto:** Agentes de IA precisam interagir de forma segura e padronizada com o banco e conteúdo do WordPress local sem depender exclusivamente de interfaces gráficas ou scripts pontuais.
- **Decisão:** Disponibilizar servidor MCP (`wp-local`) declarado em `.agents/mcp_config.json`, utilizando REST API autenticada via Application Passwords para manipulação de posts e dados.
- **Consequências:** Automação padronizada de tarefas de conteúdo e testes por qualquer agente compatível com o Model Context Protocol.

---

## ADR-008 — Boletim (newsletter) desligado via feature flag

- **Data:** 2026-08
- **Status:** Aceita
- **Contexto:** Neste primeiro momento a Tera não vai produzir edições do boletim (newsletter por e-mail). A seção `#boletim` da home, o formulário de inscrição, o link no menu, o card na sidebar do blog e o CTA no artigo já existiam prontos e não deviam ser apagados — só escondidos até haver conteúdo para enviar.
- **Decisão:** `tera_boletim_ativo()` (`inc/site-data.php`) retorna `false` e controla, a partir de um único ponto, tudo relacionado ao boletim: item de menu (`tera_nav_fallback()`), seção `#boletim` e card de assinatura em `views/pages/home.twig`, card na sidebar de `views/pages/blog.twig`, CTA em `views/pages/artigo.twig`, link no rodapé (`views/partials/footer.twig`) e a estatística correspondente na barra de números (`tera_numeros()`, que troca "mensal · boletim de tarifa e regulação" por "2 · frentes: eficiência e tarifa" enquanto a flag estiver desligada). O processamento do formulário em `inc/forms.php` (`admin_post_tera_boletim`) permanece intacto, só sem UI que aponte para ele.
- **Não confundir com:** a categoria editorial "Boletim" (`inc/setup.php`, junto com artigo-técnico/case/vídeo/glossário/nota) é um formato de post do blog — cobre publicações tipo "boletim tarifário" como texto avulso. Ela não depende dessa flag e continua ativa.
- **Consequências:** Para reativar tudo de uma vez, basta trocar o `return false;` por `return true;` em `tera_boletim_ativo()` — nenhuma view precisa mudar.

---


```markdown
## ADR-NNN — [Título]

- **Data:** AAAA-MM
- **Status:** Proposta | Aceita | Substituída por ADR-NNN
- **Contexto:** [Por que essa decisão foi necessária]
- **Decisão:** [O que foi decidido]
- **Consequências:** [Impactos positivos e negativos]
```

## Links
- [[index|← Voltar ao índice]]
