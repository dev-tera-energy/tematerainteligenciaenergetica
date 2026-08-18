<?php
/**
 * Extensões do Twig.
 *
 * Só o mínimo: as views devem continuar passivas. Nada aqui busca dado,
 * apenas traduz o que o PHP já resolveu para o formato que o markup precisa.
 *
 * @package Tera
 */

declare( strict_types = 1 );

add_filter(
	'timber/twig',
	static function ( $twig ) {
		/**
		 * Traduz a chave semântica da marca no nome Lucide.
		 * Uso: {{ 'eficiencia'|icone }} devolve 'zap'.
		 */
		$twig->addFilter(
			new Twig\TwigFilter(
				'icone',
				static function ( string $chave ): string {
					$mapa = tera_icones();

					return $mapa[ $chave ] ?? $chave;
				}
			)
		);

		/**
		 * Tempo de leitura em minutos, a partir do conteúdo bruto.
		 * Uso: {{ post.content|leitura }} min
		 */
		$twig->addFilter(
			new Twig\TwigFilter(
				'leitura',
				static function ( string $conteudo ): int {
					return tera_tempo_leitura( $conteudo );
				}
			)
		);

		/**
		 * Caminho de um logo oficial. Nunca redesenhe o meandro à mão.
		 * Uso: {{ logo('wordmark', 'gradiente') }}
		 */
		$twig->addFunction(
			new Twig\TwigFunction(
				'logo',
				static function ( string $variante = 'wordmark', string $cor = 'gradiente' ): string {
					return TERA_URI . '/dist/logos/tera-' . $variante . '-' . $cor . '.svg';
				}
			)
		);

		/**
		 * Path do meandro decorativo: linha-rio contínua.
		 * Onda de amplitude alta para hero e capa, filete para divisores.
		 *
		 * @param int $largura   Largura do viewBox.
		 * @param int $altura    Altura do viewBox.
		 * @param int $periodos  Número de meias-ondas.
		 * @param int $amplitude Amplitude vertical.
		 */
		$twig->addFunction(
			new Twig\TwigFunction(
				'meandro',
				static function ( int $largura = 1800, int $altura = 200, int $periodos = 9, int $amplitude = 60 ): string {
					$meio     = $altura / 2;
					$segmento = $largura / $periodos;
					$path     = 'M0,' . round( $meio, 1 );
					$x        = 0;
					$sobe     = true;

					for ( $i = 0; $i < $periodos; $i++ ) {
						$controle = round( $x + $segmento * 0.5, 1 );
						$proximo  = round( $x + $segmento, 1 );
						$pico     = round( $sobe ? $meio - $amplitude : $meio + $amplitude, 1 );

						$path .= ' C' . $controle . ',' . $pico . ' ' . $controle . ',' . $pico . ' ' . $proximo . ',' . round( $meio, 1 );

						$x    = $x + $segmento;
						$sobe = ! $sobe;
					}

					return $path;
				}
			)
		);

		return $twig;
	}
);
