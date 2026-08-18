<?php
/**
 * Configuração do tema: suportes, menus, tamanhos de imagem e limpeza.
 *
 * @package Tera
 */

declare( strict_types = 1 );

/**
 * Onde o Timber procura os templates Twig.
 * Um único diretório: toda apresentação vive em /views.
 */
add_filter(
	'timber/locations',
	static function ( array $paths ): array {
		$paths['tera'] = array( TERA_DIR . '/views' );

		return $paths;
	}
);




add_action(
	'after_setup_theme',
	static function (): void {
		load_theme_textdomain( 'tera', TERA_DIR . '/languages' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'editor-styles' );
		add_theme_support(
			'html5',
			array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
		);

		// O tema controla toda a tipografia e a paleta. Nada de opções soltas no editor.
		add_theme_support( 'disable-custom-colors' );
		add_theme_support( 'disable-custom-font-sizes' );
		add_theme_support( 'disable-custom-gradients' );

		register_nav_menus(
			array(
				'principal' => __( 'Navegação principal', 'tera' ),
			)
		);

		// Capa dos cards de conteúdo (proporção 8:5, igual ao protótipo).
		add_image_size( 'tera-card', 720, 450, true );
		// Abertura do artigo.
		add_image_size( 'tera-hero', 1640, 600, true );
	}
);

/**
 * Garante as categorias editoriais, a página de /conteudo/ e posts de demonstração.
 */
add_action(
	'init',
	static function (): void {
		$categorias = array(
			'artigo-tecnico' => 'Artigo técnico',
			'boletim'        => 'Boletim',
			'case'           => 'Case',
			'video'          => 'Vídeo',
			'glossario'      => 'Glossário',
			'nota'           => 'Nota',
		);

		$cat_ids = array();
		foreach ( $categorias as $slug => $nome ) {
			$termo = get_term_by( 'slug', $slug, 'category' );
			if ( ! $termo ) {
				$inserido = wp_insert_term( $nome, 'category', array( 'slug' => $slug ) );
				if ( ! is_wp_error( $inserido ) ) {
					$cat_ids[ $slug ] = (int) $inserido['term_id'];
				}
			} else {
				$cat_ids[ $slug ] = (int) $termo->term_id;
			}
		}

		// Cria a página "Conteúdo" se ainda não existir
		$conteudo_page = get_page_by_path( 'conteudo' );
		if ( ! $conteudo_page ) {
			$page_id = wp_insert_post(
				array(
					'post_title'   => 'Conteúdo',
					'post_name'    => 'conteudo',
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_content' => '',
				)
			);
			if ( $page_id && ! is_wp_error( $page_id ) ) {
				update_option( 'page_for_posts', (int) $page_id );
			}
		} elseif ( (int) get_option( 'page_for_posts' ) !== (int) $conteudo_page->ID ) {
			update_option( 'page_for_posts', (int) $conteudo_page->ID );
		}

		// Popula posts de demonstração se houver apenas o post padrão de instalação
		if ( (int) ( wp_count_posts()->publish ?? 0 ) <= 1 && ! empty( $cat_ids ) ) {
			$artigos_iniciais = array(
				array(
					'titulo'    => 'Tarifa Branca: quando vale a pena migrar e como calcular a economia',
					'slug'      => 'tarifa-branca-quando-vale-a-pena',
					'categoria' => $cat_ids['artigo-tecnico'] ?? null,
					'conteudo'  => '<p>A Tarifa Branca é uma opção tarifária que oferece valores diferentes para a energia consumida dependendo do horário do dia. Para estabelecimentos com consumo concentrado fora do horário de ponta (17h30 às 20h30 em Manaus), a economia na fatura pode ultrapassar 15%.</p><h2>Como funciona a divisão de postos horários</h2><p>A energia é cobrada em três faixas: ponta, intermediária e fora de ponta. A análise técnica do perfil de carga compara o consumo hora a hora com a tarifa convencional para garantir que a mudança trará redução real de custos.</p><p>Antes de solicitar a migração junto à distribuidora, é fundamental simular o comportamento das faturas dos últimos 12 meses.</p>',
				),
				array(
					'titulo'    => 'Boletim Tarifário Amazonas Energia — Estrutura e Bandeiras',
					'slug'      => 'boletim-tarifario-amazonas-energia',
					'categoria' => $cat_ids['boletim'] ?? null,
					'conteudo'  => '<p>Acompanhamento mensal das tarifas homologadas pela ANEEL para o estado do Amazonas. Entenda as variações de encargos setoriais, bandeiras tarifárias e o impacto direto nos custos operacionais da sua empresa.</p><h2>Bandeiras tarifárias no mês</h2><p>Com as condições hidrológicas favoráveis no Sistema Interligado Nacional, a bandeira verde permanece acionada, sem custo adicional para os consumidores atendidos em baixa e média tensão.</p>',
				),
				array(
					'titulo'    => 'Case: Redução de 24% na fatura de refrigeração comercial',
					'slug'      => 'case-reducao-refrigeracao-comercial',
					'categoria' => $cat_ids['case'] ?? null,
					'conteudo'  => '<p>Estudo de caso em rede varejista de Manaus com substituição de motores, adequação dos horários de degelo e correção do fator de potência.</p><h2>Resultados obtidos</h2><p>O diagnóstico energético identificou oportunidades de baixo investimento com payback de apenas 4 meses, gerando uma economia mensal recorrente superior a R$ 8.500,00.</p>',
				),
				array(
					'titulo'    => 'Fator de Potência: como eliminar a cobrança por energia reativa',
					'slug'      => 'fator-de-potencia-energia-reativa',
					'categoria' => $cat_ids['artigo-tecnico'] ?? null,
					'conteudo'  => '<p>Se o fator de potência da sua instalação estiver abaixo de 0,92, a concessionária cobra uma penalidade mensal por excedente reativo. Essa cobrança pode representar até 20% do valor total da fatura.</p><h2>Instalação de bancos de capacitores</h2><p>Com dimensionamento correto e instalação de banco de capacitores automáticos, a multa é 100% eliminada já na fatura seguinte à instalação.</p>',
				),
				array(
					'titulo'    => 'Demanda Contratada vs. Demanda Medida: evite multas por ultrapassagem',
					'slug'      => 'demanda-contratada-vs-medida',
					'categoria' => $cat_ids['glossario'] ?? null,
					'conteudo'  => '<p>Para clientes do Grupo A (alta e média tensão), a demanda contratada é um valor fixo pago mensalmente. Se o consumo de pico ultrapassar a margem de tolerância de 5%, a ultrapassagem é cobrada com tarifa dobrada.</p><p>O ajuste fino da demanda contratada com base no histórico de 12 meses evita pagar por capacidade ociosa ou multas recorrentes.</p>',
				),
			);

			foreach ( $artigos_iniciais as $art ) {
				$existe = get_page_by_path( $art['slug'], OBJECT, 'post' );
				if ( ! $existe ) {
					$post_id = wp_insert_post(
						array(
							'post_title'   => $art['titulo'],
							'post_name'    => $art['slug'],
							'post_content' => $art['conteudo'],
							'post_status'  => 'publish',
							'post_type'    => 'post',
						)
					);
					if ( $post_id && ! is_wp_error( $post_id ) && $art['categoria'] ) {
						wp_set_post_categories( (int) $post_id, array( (int) $art['categoria'] ) );
					}
				}
			}
		}
	}
);

/**
 * O tema é SSR puro. Sem emoji script, sem oEmbed discovery,
 * sem generator meta: menos requisição, menos superfície.
 */
add_action(
	'init',
	static function (): void {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
	}
);

/**
 * Tempo estimado de leitura, em minutos. Usado nos metadados dos cards.
 *
 * @param string $conteudo Conteúdo bruto do post.
 * @return int Minutos, mínimo de 1.
 */
function tera_tempo_leitura( string $conteudo ): int {
	$palavras = str_word_count( wp_strip_all_tags( $conteudo ) );

	return max( 1, (int) ceil( $palavras / 200 ) );
}

/**
 * URL de uma categoria editorial pelo slug, ou string vazia se não existir.
 *
 * @param string $slug Slug da categoria (ex.: 'artigo-tecnico').
 * @return string
 */
function tera_categoria_url( string $slug ): string {
	$termo = get_term_by( 'slug', $slug, 'category' );

	if ( ! $termo instanceof WP_Term ) {
		return '';
	}

	$link = get_category_link( $termo->term_id );

	return is_wp_error( $link ) ? '' : $link;
}
