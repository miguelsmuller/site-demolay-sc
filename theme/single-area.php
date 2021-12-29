<?php get_header(); ?>

<!-- PAGE CONTENT -->
<section id="content" class="container">
    <div class="row">

        <!-- MAIN COLUMN -->
        <main class="content-page" role="main">

            <!-- ARTICLE CONTAINER -->
            <div class="content-page-item">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" class="article article-full">
                        <header>
                            <h1 class="article-title"><?php the_title(); ?></h1>
                        </header>
                        <div class="article-entry">

                            <?php if( have_rows('membros') ): ?>
                            <ul class="staff-list">

                                <?php while( have_rows('membros') ): the_row();

                                    // vars
                                    $cid                = get_sub_field('cid');
                                    $image_perfil       = get_sub_field('image_perfil');
                                    $nome               = get_sub_field('nome');
                                    $cargo              = get_sub_field('cargo');
                                    $capitulo           = get_sub_field('capitulo');
                                    $e_macom            = get_sub_field('e_macom');
                                    $loja_maconica      = get_sub_field('loja_maconica');
                                    $mail_institucional = get_sub_field('mail');
                                    $perfil_facebook    = get_sub_field('facebook');

                                    ?>

                                    <li class="row staff-member">

<div class="col-md-3">
    <?php
    $img_url    = wp_get_attachment_url( $image_perfil['id'],'full' );
    $image      = aq_resize( $img_url, 500, 500, true );
    if (!$image) {
        $image = get_bloginfo('template_directory') . '/assets/images/avatar-nao-disponivel.png';
    }
    ?>
    <img class="img-responsive img-thumbnail" src="<?php echo $image; ?>" title="<?php echo $image_perfil['alt'] ?>" alt="<?php echo $image_perfil['alt'] ?>" />
</div>
<div class="col-md-9">
    <h1><?php echo $cargo; ?></h1>
    <h2><?php echo $nome; ?></h2>
    <span>CID: <?php echo $cid; ?></span><br />
    <span>Capítulo: <?php echo $capitulo ?></span><br />
    <?php if ($e_macom == TRUE){ ?>
    <span>Loja: <?php echo $loja_maconica ?></span><br />
    <?php } ?>
    <span>E-Mail: <a href="mailto:<?php echo antispambot( $mail_institucional ) ?>"><?php echo antispambot( $mail_institucional ) ?></a></span><br />
    <span>Facebook: <a href="<?php echo $perfil_facebook ?>" target="_blank"><?php echo $perfil_facebook ?></a></span><br />
</div>


                                    </li>

                                <?php endwhile; ?>

                            </ul>
                            <?php endif; ?>

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