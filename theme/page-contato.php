<?php
/*
Template Name: Página de Contato
*/
?>
<?php get_header(); ?>

<!-- PAGE CONTENT -->
<section id="content" class="container">
    <div class="row">

        <!-- MAIN COLUMN -->
        <main class="content-page" role="main">

            <div class="content-page-item">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d28462.33469734458!2d-48.70546964999999!3d-26.91010075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1spt-BR!2s!4v1399318570434" width="100%" height="250" frameborder="0" style="border:0" scrolling="no"></iframe>
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
                    </article>
                <?php endwhile; ?>
            </div>

        </main>

        <!-- SIDEBAR COLUMNS -->
        <?php get_sidebar(); ?>
    </div>

</section>

<?php get_footer(); ?>