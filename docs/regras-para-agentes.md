# Regras para Agentes de IA

> Como agentes devem interagir com este cofre. Para convenções de código, veja `AGENTS.md`.

## Antes de Qualquer Ação

1. Leia `AGENTS.md` (fonte de verdade).
2. Consulte `docs/index.md` para navegar o cofre.
3. Leia este arquivo para regras de documentação.

## Princípio Central: Não Repita — Referencie

- Se a informação já existe em `AGENTS.md`, **referencie** com texto como: _"Para detalhes de stack, veja `AGENTS.md`."_
- Se a informação já existe em outro doc do cofre, use `[[wikilink]]`.
- **Nunca** copie blocos de texto entre arquivos.

## Criar um Novo Documento

Criar somente quando:
- O assunto **não cabe** em nenhum doc existente.
- O conteúdo é substancial (>3 parágrafos). Conteúdo curto deve ser adicionado a um doc existente.

Formato obrigatório:
1. **Nome:** `kebab-case.md`
2. **Título:** H1 com nome descritivo
3. **Cabeçalho:** Blockquote indicando o que o doc cobre e referenciando docs relacionados
4. **Links:** Seção final com `[[wikilinks]]` para docs relacionados e `[[index|← Voltar ao índice]]`
5. **Atualizar `index.md`:** Adicionar o link do novo doc ao MOC

## Editar um Documento Existente

- Preserve o cabeçalho (blockquote) e a seção de links.
- Adicione conteúdo na seção temática correta.
- Não altere ADRs existentes em `decisoes.md` — crie novas entradas.

## Formato de Referências Cruzadas

- Entre docs do cofre: `[[nome-do-doc]]` ou `[[nome-do-doc|texto exibido]]`
- Para AGENTS.md: `` `AGENTS.md` `` (texto simples, pois está fora do cofre)
- Para arquivos de código: caminho relativo à raiz do tema (ex: `views/index.twig`)

## Economia de Tokens

- Seja conciso. Prefira tabelas e listas a parágrafos longos.
- Use diagramas ASCII ou mermaid para fluxos — valem mais que texto.
- Não inclua exemplos de código óbvios. Inclua apenas quando a sintaxe for não-intuitiva.

## Links
- [[index|← Voltar ao índice]]
