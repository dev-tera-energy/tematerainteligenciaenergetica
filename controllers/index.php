<?php
/**
 * Controller: listagem do blog ("Conteúdo").
 *
 * Serve a página de posts configurada em Ajustes > Leitura e o filtro
 * por categoria (formato editorial), resolvido inteiramente por URL,
 * sem JavaScript: /conteudo/categoria/boletim/.
 *
 * @package Tera
 */

declare( strict_types = 1 );

$contexto = tera_contexto_listagem();

$destaque = $contexto['posts'][0] ?? null;
if ( $destaque ) {
	$contexto['destaque']      = $destaque;
	$contexto['posts_restantes'] = array_slice( iterator_to_array( $contexto['posts'] ), 1 );
} else {
	$contexto['posts_restantes'] = array();
}

Timber\Timber::render( 'pages/blog.twig', $contexto );
