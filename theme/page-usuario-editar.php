<?php get_header(); ?>

<!-- PAGE CONTENT -->
<section id="content" class="container">
    <div class="row">

        <!-- MAIN COLUMN -->
        <main class="content-page" role="main">

            <div class="content-page-item">
                <img src="<?php bloginfo('template_directory'); ?>/assets/images/page-usuario-editar.jpg" class="img-responsive">
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
                        <?php
                            $current_user = wp_get_current_user();

                            $url = SISDM_API . 'memberforevents/' .$current_user->user_login;
                            $key = get_field('api_key_google', 'option');
                            $context = stream_context_create(array(
                                'http' => array(
                                    'header' => 'Authorization: Basic '. $key
                                )
                            ));

                            if (false !== ($data = @file_get_contents($url, false, $context))){
                                $xmlObj = simplexml_load_string($data);
                                $arrXml = objectsIntoArray($xmlObj);
                        ?>
<div class="row">
    <div class="form-group col-md-2">
        <label for="txt_cid">CID:</label>
        <p class="form-control-static"><?php echo $current_user->user_login; ?></p>
    </div>
    <div class="form-group col-md-2">
        <label for="txt_regular">Regular:</label>
        <p class="form-control-static"><span class="label label-success"><?php echo $arrXml['regularity']; ?></span></p>
    </div>
    <div class="form-group col-md-4">
        <label for="txt_nome">Nome Completo:</label>
        <p class="form-control-static"><?php echo $current_user->user_firstname; ?></p>
    </div>
    <div class="form-group col-md-4">
        <label for="txt_email">E-mail:</label>
        <p class="form-control-static"><?php echo $current_user->user_email ; ?></p>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
            <li class="active"><a href="#pessoal" data-toggle="tab">Pessoal</a></li>
            <li><a href="#capitulo" data-toggle="tab">Capítulo</a></li>
            <li><a href="#convento" data-toggle="tab">Convento</a></li>
            <li><a href="#corte" data-toggle="tab">Corte</a></li>
        </ul>
    </div>
    <div class="col-md-9">
        <div class="tab-content">
            <div class="tab-pane active" id="pessoal">
                <div class="form-group">
                    <label for="txt_aniversario">Aniversário:</label>
                    <p class="form-control-static"><?php echo $arrXml['birthday']; ?></p>
                </div>
                <div class="form-group">
                    <label for="txt_telefone">Telefone:</label>
                    <p class="form-control-static">
                        (<?php echo $arrXml['phone']['DDD_celular']; ?>) <?php echo $arrXml['phone']['celular']; ?> ou
                        (<?php echo $arrXml['phone']['DDD_homePhone']; ?>) <?php echo $arrXml['phone']['homePhone']; ?>
                    </p>
                </div>
                <div class="form-group">
                    <label for="txt_aniversario">Grau:</label>
                    <p class="form-control-static"><?php echo $arrXml['degree']; ?></p>
                </div>
                <div class="form-group">
                    <label for="txt_aniversario">Grau Cavalaria:</label>
                    <p class="form-control-static"><?php echo $arrXml['knight']; ?></p>
                </div>
                <div class="form-group">
                    <label for="txt_aniversario">Maçom:</label>
                    <p class="form-control-static"><?php echo $arrXml['macom']; ?></p>
                </div>
                                                        </div>
                                                        <div class="tab-pane" id="capitulo">
                <div class="form-group">
                    <label for="txt_aniversario">Capítulo:</label>
                    <p class="form-control-static"><?php echo $arrXml['chapter']; ?> Nº<?php echo $arrXml['chapterNumber']; ?></p>
                </div>
                                                        </div>
                                                        <div class="tab-pane" id="convento">
                <div class="form-group">
                    <label for="txt_aniversario">Convento:</label>
                    <p class="form-control-static"><?php echo $arrXml['convent']; ?> Nº<?php echo $arrXml['conventNumber']; ?></p>
                </div>
                                                        </div>
                                                        <div class="tab-pane" id="corte">
                <div class="form-group">
                    <label for="txt_aniversario">Corte:</label>
                    <p class="form-control-static"><?php echo $arrXml['court']; ?> Nº<?php echo $arrXml['courtNumber']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
                        <?php
                            }else{
                                echo '<div class="alert alert-danger" role="alert">Não foi possível estabelecer um conexão com o SISDM</div>';
                            }
                        ?>
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
