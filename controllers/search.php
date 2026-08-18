<?php
/**
 * Controller: resultado de busca.
 * Reaproveita o template de listagem de conteúdo.
 *
 * @package Tera
 */

declare( strict_types = 1 );

$contexto = tera_contexto_listagem(
	array(
		's' => get_search_query(),
	)
);

$contexto['destaque']        = null;
$contexto['posts_restantes'] = iterator_to_array( $contexto['posts'] );
$contexto['termo_busca']     = get_search_query();

Timber\Timber::render( 'pages/busca.twig', $contexto );
