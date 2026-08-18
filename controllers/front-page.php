<?php
/**
 * Controller: Home.
 *
 * A home é uma página única (one-page): hero, números, prévia de
 * conteúdo, serviços + FAQ, método, missão/visão/valores, sobre,
 * boletim e diagnóstico, todas seções ancoradas (#servicos, #metodo...).
 * A view é passiva: recebe só o que já está pronto para exibir.
 *
 * @package Tera
 */

declare( strict_types = 1 );

$context = Timber\Timber::context();

$context['servicos'] = tera_servicos();
$context['numeros']  = tera_numeros();
$context['faqs']     = tera_faqs();
$context['etapas']   = tera_etapas();
$context['normas']   = tera_normas();
$context['valores']  = tera_valores();

$context['inscrito'] = isset( $_GET['inscrito'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
$context['enviado']  = isset( $_GET['enviado'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

// Prévia de conteúdo: os 3 posts mais recentes viram destaque + 2 laterais.
$recentes = Timber\Timber::get_posts(
	array(
		'post_status'    => 'publish',
		'posts_per_page' => 3,
	)
);
$lista = iterator_to_array( $recentes );

$context['post_destaque']  = $lista[0] ?? null;
$context['posts_laterais'] = array_slice( $lista, 1, 2 );

$context['categorias'] = Timber\Timber::get_terms(
	array(
		'taxonomy'   => 'category',
		'hide_empty' => true,
		'orderby'    => 'term_order',
	)
);

Timber\Timber::render( 'pages/home.twig', $context );
