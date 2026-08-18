<?php
/**
 * Controller: artigo individual.
 *
 * Busca o próprio post, sua categoria principal (formato editorial) e até
 * três posts relacionados da mesma categoria para a seção "Continue lendo".
 *
 * @package Tera
 */

declare( strict_types = 1 );

$context = Timber\Timber::context();
$post    = Timber\Timber::get_post();

$categorias = $post->terms( 'category' );
$categoria_principal = $categorias[0] ?? null;

$context['post']      = $post;
$context['categoria'] = $categoria_principal;
$context['leitura']   = tera_tempo_leitura( $post->post_content );

$context['relacionados'] = Timber\Timber::get_posts(
	array(
		'post_status'    => 'publish',
		'posts_per_page' => 3,
		'post__not_in'   => array( $post->ID ),
		'category__in'   => $categoria_principal ? array( $categoria_principal->id ) : array(),
	)
);

Timber\Timber::render( 'pages/artigo.twig', $context );
