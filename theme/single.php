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
                            <ul class="article-info">
                                <li>
                                    <span class="icon-calendar"></span> <?php the_time('d/m/Y'); ?>
                                </li>
                                <li>
                                    <span class="icon-books"></span> <?php the_category(', '); ?>
                                </li>
                                <li>
                                    <span class="icon-tag"></span>
                                    <?php
                                    the_tags('');

                                    ?>
                                </li>
                                <li>
                                    <span class="icon-comment"></span> <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a>
                                </li>
                            </ul>
                        </header>
                        <div class="article-entry">
                            <?php
                            $mostrar_thumbnail = get_post_meta( get_the_ID(), 'mostrar_thumbnail', True);
                            $mostrar_thumbnail = ( empty($mostrar_thumbnail) or ($mostrar_thumbnail == 0)) ? False : True;

                            if ($mostrar_thumbnail == false){
                                the_post_thumbnail('post-thumbnail', array('class' => "article-thumbnails"));
                            }
                            ?>
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