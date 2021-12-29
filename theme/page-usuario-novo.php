<?php
include get_template_directory().'/inc-system/assets/recaptcha/recaptchalib.php';

$retorno    = '';
if (!empty($_POST)) {
    $privatekey = get_field('key_recaptcha_secret', 'option');

    $resp = recaptcha_check_answer ($privatekey,
        $_SERVER["REMOTE_ADDR"],
        $_POST["recaptcha_challenge_field"],
        $_POST["recaptcha_response_field"]);

    if (!$resp->is_valid) {

        $retorno = '<div class="alert alert-danger" style="margin-bottom: 10px; margin-top: 10px;">
                        <div class="container">
                            <strong>Capcha Error</strong> Os caracteres de validação não conferem.
                        </div>
                    </div>';

    } else {
        $cid     = $_POST['txt_cid'];
        $nome    = $_POST['txt_nome'];
        $apelido = $_POST['txt_apelido'];
        $email   = $_POST['txt_email'];

        $user_id = username_exists( $cid );
        if ( !$user_id and email_exists($email) == false ) {

          $key = get_field('api_key_google', 'option');
            $url = SISDM_API . 'memberforevents/'  .$cid;
            $context = stream_context_create(array(
                'http' => array(
                    'header' => 'Authorization: Basic '. $key
                )
            ));
            $data = file_get_contents($url, false, $context);

            $xmlObj = simplexml_load_string($data);
            $arrXml = objectsIntoArray($xmlObj);

            if ($arrXml['regularity'] == 'Sim') {
                $random_password = wp_generate_password( $length=8, $include_standard_special_chars=false );
                $user_id         = wp_create_user( $cid, $random_password, $email );

                if (is_int($user_id)) {
                    update_user_meta($user_id, 'first_name', $nome);
                    update_user_meta($user_id, 'nickname', $apelido);
                    wp_update_user( array( 'ID' => $user_id, 'display_name' => $apelido ) );

                    $headers[] = 'From: DeMolaySC <nao-responda@demolaysc.com.br>';
                    $headers[] = 'Content-Type: text/html';

                    $mensagem = '<table cellspacing="0" cellpadding="0" style="border-collapse:collapse;width:620px"><tbody><tr><td style="font-size:16px;font-family:tahoma,verdana,arial,sans-serif;background:#800000;color:#ffffff;font-weight:bold;vertical-align:baseline;letter-spacing:-0.03em;text-align:left;padding:5px 20px"><a style="text-decoration:none" href="http://www.demolaysc.com.br/" target="_blank"><span style="background:#800000;color:#ffffff;font-weight:bold;font-family:tahoma,verdana,arial,sans-serif;vertical-align:middle;font-size:16px;letter-spacing:-0.03em;text-align:left;vertical-align:baseline">DeMolay Santa Catarina</span></a></td></tr></tbody></table>';

                    $mensagem .= "<table cellspacing='0' cellpadding='0' width='620px' style='border-collapse:collapse'>
                        <tbody>
                            <tr>
                                <td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;width:620px'>

                                    Seu cadastro de usuário para acesso a informações restritas foi feito com sucesso<br />
                                    Para que você possa acessar use as seguintes credenciais de acesso:<br />
                                    <b><i>CID: </i></b> $cid <br />
                                    <b><i>Senha: </i></b> $random_password <br />

                                </td>
                            </tr>
                        </tbody>
                    </table>";

                    $statusEnvio = wp_mail($email, '[Não Responda] DeMolaySC - Credenciais de acesso ', $mensagem, $headers );

                    $retorno = '<div class="alert alert-success" style="margin-bottom: 10px; margin-top: 10px;">
                                <div class="container">
                                    <strong>Cadastro realizado</strong> Verifique a senha de acesso em seu email.
                                </div>
                            </div>';
                }
            } else {
                $retorno = '<div class="alert alert-danger" style="margin-bottom: 10px; margin-top: 10px;">
                            <div class="container">
                                <strong>CID Inválida</strong> Verique pendências referentes a CID informada.
                            </div>
                        </div>';
            }

        }else{

            $retorno = '<div class="alert alert-danger" style="margin-bottom: 10px; margin-top: 10px;">
                            <div class="container">
                                <strong>Email existente</strong> É necessário escolher um email que não esteja em uso.
                            </div>
                        </div>';
        }
    }
}
?>

<?php get_header(); ?>

<!-- PAGE CONTENT -->
<section id="content" class="container">
    <div class="row">

        <!-- MAIN COLUMN -->
        <main class="content-page" role="main">

            <div class="content-page-item">
                <img src="<?php bloginfo('template_directory'); ?>/assets/images/page-usuario-novo.jpg" class="img-responsive">
            </div>

            <!-- ARTICLE CONTAINER -->
            <div class="content-page-item">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" class="article article-full">
                        <header>
                            <h1 class="article-title"><?php the_title(); ?></h1>
                        </header>
                        <div class="article-entry">
                            <?php the_content(); ?>
                        </div>
                        <div class="article-entry">
                            <form action="" method="post" class="customForm validate">

                                <?php echo $retorno; ?>

                                <div class="row">
                                    <div class="form-group col-xs-6">
                                        <label for="txt_cid">CID:</label>
                                        <input type="text" class="form-control input-theme" id="txt_cid" name="txt_cid">
                                        <p class="help-block">Seu login será feito com o número da CID.</p>
                                    </div>

                                    <div class="form-group col-xs-6">
                                        <label for="txt_apelido">Apelido:</label>
                                        <input type="text" class="form-control input-theme" id="txt_apelido" name="txt_apelido">
                                        <p class="help-block">Nome que será vísivel nas páginas</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <label for="txt_nome">Nome Completo:</label>
                                        <input type="text" class="form-control input-theme" id="txt_nome" name="txt_nome">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <label for="txt_email">E-mail:</label>
                                        <input type="text" class="form-control input-theme" id="txt_email" name="txt_email">
                                        <p class="help-block">Sua senha será enviada para esse email.</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-6">
                                        <?php
                                            $publickey = get_field('key_recaptcha_public', 'option');
                                            echo recaptcha_get_html($publickey);
                                        ?>
                                    </div>
                                    <div class="form-group col-xs-6">
                                        <input type="submit" name="cmdEnviar" value="Realizar Cadastro" class="btn btn-lg btn-block btn-theme" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        </main>

        <!-- SIDEBAR COLUMNS -->
        <?php get_sidebar(); ?>
    </div>

</section>

<?php get_footer(); ?>
