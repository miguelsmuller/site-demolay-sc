<?php get_header(); ?>

<?php
if (is_date()){
    $titulo = 'Notícias Publicadas no período de '. get_the_time('F \d\e\ Y');
}elseif (is_category()){
    $categoria = single_cat_title("", false);
    $titulo = 'Notícias publicadas na categoria '. $categoria;
}elseif (is_tag()){
    $categoria = single_cat_title("", false);
    $titulo = 'Notícias publicadas com a tag '. $categoria;
}else{
    $titulo = 'Notícias Publicadas';
}
?>

<!-- PAGE CONTENT -->
<section id="content" class="container">
    <div class="row">

        <!-- MAIN COLUMN -->
        <main class="content-page" role="main">

            <!-- ARTICLE CONTAINER -->
            <div class="content-page-item">
                <h1 class="content-page-title"><?php echo $titulo; ?></h1>
                <?php
                    $args = array( 'paged'=> $paged );
                    $args['name'] = '';
                    $args['pagename'] = '';

                    global $wp_query;
                    $args = array_merge( $wp_query->query_vars, $args );
                    //$loop_posts = new WP_Query( $args );
                    query_posts( $args );

                    global $wp_query;
                    $total_results = $wp_query->found_posts;
                ?>

                <?php if ( have_posts() ) : ?>
                    <ol id="article-list" class="list-post">
                        <?php //get_template_part( 'content', get_post_format() ); ?>
                        <?php //get_template_part( 'loop', 'content' ); ?>
                        <?php get_template_part( 'loop-front-page', get_post_format() ); ?>
                    </ol>
                <?php else : ?>
                <?php endif; ?>

                <button id="load-more" type="button" class="btn btn-primary btn-block btn-theme btn-lg" data-loading-text="Carregando  ..." data-template="loop-front-page" data-post-type="post" data-posts-per-page="<?php echo get_option( 'posts_per_page' ) ?>" data-max-page="<?php echo $wp_query->max_num_pages; ?>" autocomplete="off">Carregar mais notícias</button>


            </div>

        </main>

        <!-- SIDEBAR COLUMNS -->
        <?php get_sidebar(); ?>
    </div>

</section>

<?php get_footer(); ?>