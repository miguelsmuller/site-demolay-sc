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
                            <?php
                            $data_inicio = DateTime::createFromFormat('Ymd', get_field('data_inicio'));
                            $data_termino = DateTime::createFromFormat('Ymd', get_field('data_termino'));
                            ?>
                            <h4><?php echo $data_inicio->format('d/m/Y'); ?> até <?php echo $data_termino->format('d/m/Y'); ?></h4>
                        </header>
                        <div class="article-entry">
                            <?php
                                $thumbnail  = get_field('thumbnail');
                                $img_url    = wp_get_attachment_url( $thumbnail['id'],'full' );
                                $image      = aq_resize( $img_url, 855, 380, true );
                                if($image) echo '<img class="img-responsive img-thumbnail" src="<?php echo $image; ?>" title="" alt="" />';
                            ?>
                            <?php the_field('descricao'); ?>
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