<?php
/**
 * Processamento de formulários: diagnóstico e boletim.
 *
 * Ambos os POSTs vão para admin-post.php (padrão nativo do WordPress,
 * sem plugin de formulário). Sucesso redireciona de volta à página de
 * origem com uma query string que a view usa para trocar de estado
 * (?enviado=1 / ?inscrito=1), o mesmo padrão de "sent"/"subscribed"
 * do protótipo em React.
 *
 * @package Tera
 */

declare( strict_types = 1 );

/**
 * Recebe o pedido de diagnóstico e envia por e-mail para o time comercial.
 */
function tera_processar_diagnostico(): void {
	check_admin_referer( 'tera_diagnostico' );

	$nome     = sanitize_text_field( wp_unslash( $_POST['nome'] ?? '' ) );
	$empresa  = sanitize_text_field( wp_unslash( $_POST['empresa'] ?? '' ) );
	$whatsapp = sanitize_text_field( wp_unslash( $_POST['whatsapp'] ?? '' ) );
	$email    = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$perfil   = sanitize_text_field( wp_unslash( $_POST['perfil'] ?? '' ) );
	$conta    = sanitize_text_field( wp_unslash( $_POST['valor_conta'] ?? '' ) );

	$destino = get_option( 'admin_email' );
	$corpo   = "Novo pedido de diagnóstico\n\n"
		. "Nome: {$nome}\nEmpresa: {$empresa}\nWhatsApp: {$whatsapp}\n"
		. "E-mail: {$email}\nPerfil: {$perfil}\nValor médio da conta: {$conta}\n";

	wp_mail( $destino, 'Novo pedido de diagnóstico · site Tera', $corpo );

	wp_safe_redirect( add_query_arg( 'enviado', '1', wp_get_referer() ?: home_url( '/diagnostico/' ) ) );
	exit;
}
add_action( 'admin_post_tera_diagnostico', 'tera_processar_diagnostico' );
add_action( 'admin_post_nopriv_tera_diagnostico', 'tera_processar_diagnostico' );

/**
 * Recebe a inscrição no boletim.
 * Ponto de troca: substitua o corpo por uma chamada à API do provedor de
 * e-mail (Mailchimp, Brevo etc.) mantendo o mesmo redirecionamento.
 */
function tera_processar_boletim(): void {
	check_admin_referer( 'tera_boletim' );

	$email = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );

	if ( is_email( $email ) ) {
		do_action( 'tera/boletim_inscricao', $email );
	}

	wp_safe_redirect( add_query_arg( 'inscrito', '1', wp_get_referer() ?: home_url( '/boletim/' ) ) );
	exit;
}
add_action( 'admin_post_tera_boletim', 'tera_processar_boletim' );
add_action( 'admin_post_nopriv_tera_boletim', 'tera_processar_boletim' );
