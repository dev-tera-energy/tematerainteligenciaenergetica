<?php
/**
 * Controller: 404.
 *
 * @package Tera
 */

declare( strict_types = 1 );

$context = Timber\Timber::context();

Timber\Timber::render( '404.twig', $context );
