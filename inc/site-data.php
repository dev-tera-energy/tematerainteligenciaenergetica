<?php
/**
 * Dados institucionais: fonte única de verdade para contato e navegação.
 *
 * @package Tera
 */

declare( strict_types = 1 );

/**
 * Contato e localização.
 *
 * @return array<string, string>
 */
function tera_contato(): array {
	return array(
		'email'        => 'contato@terainteligenciaenergetica.com.br',
		'whatsapp'     => '(92) 98141-7366',
		'whatsapp_url' => 'https://wa.me/5592981417366',
		'local'        => 'Manaus · Amazonas',
		'cidade'       => 'Manaus/AM',
	);
}

/**
 * Liga/desliga o boletim (newsletter) em todo o site: seção da home,
 * link no menu, no rodapé e nos CTAs de artigo/blog. Neste primeiro
 * momento a Tera não produz boletins — mude para `true` para reativar
 * tudo de uma vez, sem mexer nas views.
 */
function tera_boletim_ativo(): bool {
	return false;
}

/**
 * Navegação principal (âncoras da home). Usa o menu do WordPress quando
 * existir; este array é o fallback, para que o tema funcione recém-ativado,
 * sem cadastro nenhum. Os links levam para seções da home — se a página
 * atual não for a home, o Twig prefixa com a home_url().
 *
 * @return array<int, array<string, string>>
 */
function tera_nav_fallback(): array {
	$itens = array(
		array(
			'label' => 'Serviços',
			'url'   => '#servicos',
		),
		array(
			'label' => 'Método',
			'url'   => '#metodo',
		),
		array(
			'label' => 'Boletim',
			'url'   => '#boletim',
		),
		array(
			'label' => 'Diagnóstico',
			'url'   => '#contato',
		),
	);

	if ( ! tera_boletim_ativo() ) {
		$itens = array_values( array_filter( $itens, static fn( array $item ): bool => '#boletim' !== $item['url'] ) );
	}

	return $itens;
}

/**
 * Assinatura da marca. Aparece no rodapé.
 */
function tera_assinatura(): string {
	return 'Energia inteligente para um futuro sustentável.';
}

/**
 * Vocabulário semântico de ícones da marca: chave de contexto -> nome Lucide.
 * Preferir a chave ao nome cru mantém a correspondência entre contexto e símbolo.
 *
 * @return array<string, string>
 */
function tera_icones(): array {
	return array(
		'eficiencia' => 'zap',
		'tarifa'     => 'circle-dollar-sign',
		'check'      => 'check',
	);
}
