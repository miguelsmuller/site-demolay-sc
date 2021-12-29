<?php get_header(); ?>

<!-- PAGE CONTENT -->
<section id="content" class="container">
    <div class="row">

        <!-- MAIN COLUMN -->
        <main class="content-page" role="main">

            <!-- ARTICLE CONTAINER -->
            <div class="content-page-item">
                <h1 class="content-page-title">Próximos eventos</h1>

<?php if ( have_posts() ) : ?>
    <!-- <ul class="event-list"> -->
    <ul class="event-list event-list-grid" >
        <?php while ( have_posts() ) : the_post(); ?>
            <li class="event-list-item">
                <a href="<?php the_permalink() ?>">
                    <article id="post-<?php the_ID(); ?>" class="well">
                        <?php
                        $date_inicio = DateTime::createFromFormat('Ymd', get_field('data_inicio'));
                        ?>
                        <h1 class="event-list-date"><?php echo $date_inicio->format('d/m/Y');?></h1>
                        <h2 class="event-list-info"><?php the_title(); ?></h2>
                    </article>
                </a>
            </li>
        <?php endwhile; ?>
    <!-- </ul> -->
    </ul>
<?php else : ?>
    <?php get_template_part( 'no-results', 'index' ); ?>
<?php endif; ?>

            </div>

        </main>

        <!-- SIDEBAR COLUMNS -->
        <?php get_sidebar(); ?>
    </div>

</section>

<?php get_footer(); ?>