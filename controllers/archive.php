<?php
/**
 * Controller: arquivo por categoria (formato editorial).
 * Reaproveita o mesmo template de listagem do blog, sem o card de destaque:
 * numa categoria filtrada, o primeiro post do filtro não deve saltar para
 * "Em destaque" como se fosse a curadoria geral.
 *
 * @package Tera
 */

declare( strict_types = 1 );

$contexto = tera_contexto_listagem();

$contexto['destaque']        = null;
$contexto['posts_restantes'] = iterator_to_array( $contexto['posts'] );
$contexto['titulo_arquivo']  = single_cat_title( '', false );

Timber\Timber::render( 'pages/blog.twig', $contexto );
