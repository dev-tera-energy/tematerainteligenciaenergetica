<?php
/**
 * Conteúdo editorial das seções institucionais.
 *
 * Princípio herdado do protótipo: conteúdo não é apresentação.
 * Texto, listas e dados vivem aqui; os arquivos .twig só exibem.
 *
 * Cada função abaixo é o ponto de troca para ACF no futuro:
 * substitua o corpo por get_field() mantendo o mesmo formato de retorno,
 * e nenhuma view precisa mudar.
 *
 * @package Tera
 */

declare( strict_types = 1 );

/**
 * Os dois serviços vendáveis, abaixo do guarda-chuva de inteligência energética.
 *
 * @return array<int, array<string, mixed>>
 */
function tera_servicos(): array {
	return array(
		array(
			'variante' => 'principal',
			'badge'    => 'Serviço principal',
			'icone'    => 'eficiencia',
			'titulo'   => 'Eficiência energética',
			'resumo'   => 'Diagnóstico técnico do seu consumo para identificar onde a energia é desperdiçada e propor medidas com retorno financeiro claro.',
			'itens'    => array(
				'Diagnóstico energético e análise de faturas',
				'Correção de fator de potência e ajuste de demanda',
				'Retrofit de iluminação e motores eficientes',
				'Plano de ação com payback e medição de resultados',
			),
		),
		array(
			'variante' => 'secundario',
			'badge'    => 'Análise tarifária',
			'icone'    => 'tarifa',
			'titulo'   => 'Tarifa certa para o seu horário',
			'resumo'   => 'Estudo do perfil de consumo hora a hora para saber se a Tarifa Branca vale a pena e conduzir a mudança junto à distribuidora.',
			'itens'    => array(
				'Análise do consumo por posto horário',
				'Comparativo Convencional e Branca com economia estimada',
				'Recomendação de remanejamento de cargas',
				'Apoio na solicitação de troca junto à distribuidora',
			),
		),
	);
}

/**
 * Etapas do trabalho, da fatura ao resultado comprovado.
 *
 * @return array<int, array<string, string>>
 */
function tera_etapas(): array {
	return array(
		array(
			'badge'  => 'ETAPA 01',
			'titulo' => 'Levantamento',
			'texto'  => 'Análise das faturas dos últimos doze meses e do perfil de uso.',
		),
		array(
			'badge'  => 'ETAPA 02',
			'titulo' => 'Diagnóstico',
			'texto'  => 'Visita técnica e medições nos principais pontos de consumo.',
		),
		array(
			'badge'  => 'ETAPA 03',
			'titulo' => 'Plano de ação',
			'texto'  => 'Medidas priorizadas por retorno financeiro, com payback de cada uma.',
		),
		array(
			'badge'  => 'ETAPA 04',
			'titulo' => 'Verificação',
			'texto'  => 'Medimos e comprovamos a economia real, o resultado que aparece na conta.',
		),
	);
}

/**
 * Base metodológica exibida como tags mono.
 *
 * @return array<int, string>
 */
function tera_normas(): array {
	return array(
		'Diagnóstico energético',
		'ISO 50002:2014',
		'Medição e verificação',
		'Análise tarifária ANEEL',
	);
}

/**
 * Barra de números-âncora entre o hero e o conteúdo.
 * O total de textos publicados é contado a partir dos posts reais.
 *
 * @return array<int, array<string, string>>
 */
function tera_numeros(): array {
	$publicados = (int) ( wp_count_posts()->publish ?? 0 );

	return array(
		array(
			'valor'  => 'até 30%',
			'rotulo' => 'de redução na conta de energia',
		),
		array(
			'valor'  => (string) $publicados,
			'rotulo' => 'textos publicados no blog',
		),
		array(
			'valor'  => 'ISO 50002',
			'rotulo' => 'metodologia de diagnóstico',
		),
		tera_boletim_ativo()
			? array(
				'valor'  => 'mensal',
				'rotulo' => 'boletim de tarifa e regulação',
			)
			: array(
				'valor'  => '2',
				'rotulo' => 'frentes: eficiência e tarifa',
			),
	);
}

/**
 * Perguntas frequentes.
 *
 * @return array<int, array<string, string>>
 */
function tera_faqs(): array {
	return array(
		array(
			'pergunta' => 'O que é um projeto de eficiência energética?',
			'resposta' => 'É um diagnóstico técnico que identifica onde a energia é desperdiçada no seu estabelecimento e propõe medidas para reduzir o consumo mantendo o mesmo funcionamento. Cada medida vem com estimativa de economia e tempo de retorno.',
		),
		array(
			'pergunta' => 'Preciso fazer obra ou parar minha operação?',
			'resposta' => 'Não necessariamente. Boa parte da economia vem de ajustes de baixo ou nenhum custo, como correção de fator de potência e revisão da modalidade tarifária.',
		),
		array(
			'pergunta' => 'Como sei se a Tarifa Branca vale a pena para mim?',
			'resposta' => 'A Tera analisa seu perfil de consumo e mostra, com números, se a mudança reduz sua conta antes de qualquer decisão.',
		),
		array(
			'pergunta' => 'Atendem qual região?',
			'resposta' => 'A Tera é sediada em Manaus e atende comércios e pequenas e médias indústrias da região.',
		),
	);
}

/**
 * Valores da empresa.
 *
 * @return array<int, array<string, string>>
 */
function tera_valores(): array {
	return array(
		array(
			'titulo' => 'Compromisso social',
			'texto'  => 'Energia deve melhorar vidas, não apenas gerar lucro.',
		),
		array(
			'titulo' => 'Inteligência',
			'texto'  => 'Toda decisão deve ser baseada em dados.',
		),
		array(
			'titulo' => 'Inovação contínua',
			'texto'  => 'Nunca parar de aprender, nunca parar de evoluir.',
		),
		array(
			'titulo' => 'Ética',
			'texto'  => 'Construir relações transparentes.',
		),
	);
}
