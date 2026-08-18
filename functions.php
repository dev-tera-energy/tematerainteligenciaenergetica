<?php
/**
 * Tera Inteligência Energética · bootstrap do tema.
 *
 * Arquitetura MVC:
 *   controller  -> arquivos de template na raiz (index.php, single.php, page.php...)
 *   model       -> inc/site-data.php e inc/content.php (dados) + WP_Query via Timber
 *   view        -> views/*.twig (passivas: só exibem o que o PHP injeta)
 *
 * Nenhuma lógica de negócio mora neste arquivo. Ele apenas carrega o Timber
 * e os módulos de inc/.
 *
 * @package Tera
 */

declare( strict_types = 1 );

define( 'TERA_VERSION', '1.0.0' );
define( 'TERA_DIR', get_template_directory() );
define( 'TERA_URI', get_template_directory_uri() );

$tera_autoload = TERA_DIR . '/vendor/autoload.php';

if ( ! file_exists( $tera_autoload ) ) {
	add_action(
		'admin_notices',
		static function (): void {
			echo '<div class="notice notice-error"><p><strong>Tema Tera:</strong> rode <code>composer install</code> na pasta do tema. O Timber não foi encontrado.</p></div>';
		}
	);

	return;
}

require_once $tera_autoload;

Timber\Timber::init();

require_once TERA_DIR . '/inc/setup.php';
require_once TERA_DIR . '/inc/assets.php';
require_once TERA_DIR . '/inc/site-data.php';
require_once TERA_DIR . '/inc/content.php';
require_once TERA_DIR . '/inc/context.php';
require_once TERA_DIR . '/inc/twig.php';
require_once TERA_DIR . '/inc/forms.php';
