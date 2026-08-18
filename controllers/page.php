<?php
/**
 * Controller genérico de página.
 * Usado para páginas comuns do editor que não têm template próprio.
 *
 * @package Tera
 */

declare( strict_types = 1 );

if ( is_page( 'conteudo' ) || ( (int) get_option( 'page_for_posts' ) === get_the_ID() ) ) {
	require_once __DIR__ . '/index.php';
	return;
}

$context = Timber\Timber::context();
$context['post'] = Timber\Timber::get_post();

Timber\Timber::render( 'pages/pagina-generica.twig', $context );
