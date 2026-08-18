<?php
/**
 * Enfileiramento de CSS e JS.
 *
 * O CSS é um único arquivo compilado pelo Tailwind (dist/main.css).
 * O JS são módulos pequenos, sem dependência de framework: navbar (borda
 * ao scroll), reveal (fade ao rolar), icons (Lucide) e smooth-scroll
 * (rolagem suave em links de âncora). Para adicionar um novo, crie o
 * arquivo em src/js/ e inclua o nome no array do foreach abaixo.
 *
 * @package Tera
 */

declare( strict_types = 1 );

/**
 * Versão baseada no mtime do arquivo, para cache busting sem plugin.
 *
 * @param string $caminho_relativo Caminho a partir da raiz do tema.
 * @return string
 */
function tera_asset_version( string $caminho_relativo ): string {
	$absoluto = TERA_DIR . '/' . ltrim( $caminho_relativo, '/' );

	return file_exists( $absoluto ) ? (string) filemtime( $absoluto ) : TERA_VERSION;
}

add_action(
	'wp_enqueue_scripts',
	static function (): void {
		wp_enqueue_style(
			'tera-main',
			TERA_URI . '/dist/main.css',
			array(),
			tera_asset_version( 'dist/main.css' )
		);

		// Lucide: biblioteca oficial de ícones da marca.
		wp_enqueue_script(
			'lucide',
			'https://unpkg.com/lucide@0.544.0/dist/umd/lucide.js',
			array(),
			'0.544.0',
			true
		);

		foreach ( array( 'navbar', 'reveal', 'icons', 'smooth-scroll' ) as $modulo ) {
			wp_enqueue_script(
				'tera-' . $modulo,
				TERA_URI . '/src/js/' . $modulo . '.js',
				'icons' === $modulo ? array( 'lucide' ) : array(),
				tera_asset_version( 'src/js/' . $modulo . '.js' ),
				true
			);
		}
	}
);

/**
 * Preconnect para o Google Fonts. As três famílias da marca
 * (Plus Jakarta Sans, Inter, JetBrains Mono) são importadas pelo CSS.
 */
add_action(
	'wp_head',
	static function (): void {
		echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
		echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
	},
	1
);
