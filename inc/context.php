<?php
/**
 * Contexto global do Timber.
 *
 * Tudo o que aparece em toda página (navegação, contato, assinatura) é
 * injetado aqui uma única vez. A home é uma página única (one-page) com
 * seções ancoradas; por isso servicos_url/metodo_url/etc. sempre apontam
 * para "home_url() + #âncora", funcionando a partir de qualquer página.
 *
 * @package Tera
 */

declare( strict_types = 1 );

add_filter(
	'timber/context',
	static function ( array $context ): array {
		$menu_principal = Timber\Timber::get_menu( 'principal' );

		$context['site_nome']      = get_bloginfo( 'name' );
		$context['site_url']      = home_url( '/' );
		$context['eh_home']       = is_front_page();
		$context['ano']           = (int) current_time( 'Y' );
		$context['assinatura']    = tera_assinatura();
		$context['contato']       = tera_contato();
		$context['icones']        = tera_icones();
		$context['boletim_ativo'] = tera_boletim_ativo();

		$context['blog_url']     = get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/conteudo/' );
		$context['artigos_tecnicos_url'] = tera_categoria_url( 'artigo-tecnico' ) ?: $context['blog_url'];
		$context['servicos_url'] = home_url( '/#servicos' );
		$context['metodo_url']   = home_url( '/#metodo' );
		$context['sobre_url']    = home_url( '/#sobre' );
		$context['boletim_url']  = home_url( '/#boletim' );
		$context['contato_url']  = home_url( '/#contato' );

		// Menu do WordPress quando cadastrado; array de fallback quando não.
		$context['menu']         = $menu_principal;
		$context['nav_fallback'] = tera_nav_fallback();

		return $context;
	}
);

/**
 * Monta o contexto de uma listagem de posts (página "Conteúdo").
 * Usado por index.php, archive.php e search.php, que só diferem no cabeçalho.
 *
 * @param array<string, mixed> $args Argumentos extras de WP_Query.
 * @return array<string, mixed>
 */
function tera_contexto_listagem( array $args = array() ): array {
	$contexto = Timber\Timber::context();

	$padrao = array(
		'post_status'    => 'publish',
		'posts_per_page' => (int) get_option( 'posts_per_page' ),
		'paged'          => max( 1, (int) get_query_var( 'paged' ) ),
	);

	$contexto['posts']      = Timber\Timber::get_posts( array_merge( $padrao, $args ) );
	$contexto['categorias'] = Timber\Timber::get_terms(
		array(
			'taxonomy'   => 'category',
			'hide_empty' => true,
			'orderby'    => 'term_order',
		)
	);
	$contexto['categoria_atual'] = get_queried_object_id();
	$contexto['posts_total']     = (int) ( wp_count_posts()->publish ?? 0 );

	return $contexto;
}
