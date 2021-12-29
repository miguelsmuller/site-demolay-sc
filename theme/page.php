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
                            <?php the_content(); ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <!-- RELATED ITENS CONTAINER -->
            <div class="content-page-item content-page-item-clean">
                <?php get_template_part( 'loop-related', get_post_format() ); ?>
            </div>

            <!-- COMENTS -->
            <?php
            if ( comments_open() || '0' != get_comments_number() ) {
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">Comentários</div>
                <div class="panel-body">
                    <?php
                            comments_template();
                    ?>
                </div>
            </div>
            <?php
            }
            ?>
        </main>

        <!-- SIDEBAR COLUMNS -->
        <?php get_sidebar(); ?>
    </div>

</section>

<?php get_footer(); ?>