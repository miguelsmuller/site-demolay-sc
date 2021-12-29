<?php get_header(); ?>

<!-- HOME FEATURED -->
<section id="home-featured" class="container">
    <div class="row">
        <div class="home-featured-carousel">
            <div id="slider-front-page" class="carousel slide" data-ride="carousel">
                <?php get_template_part( 'loop-front-page', 'slide' ); ?>
            </div>
        </div>
        <div class="home-featured-events">
            <?php
                if( false == get_option( 'quant_eventos_index' ) ) {
                    $quant_eventos = get_option( 'quant_eventos_index' );
                }else{
                    $quant_eventos = '6';
                }
            ?>
            <?php $instance = "title=Próximos Eventos&quant=$quant_eventos"; ?>
            <?php $args = ''; ?>
            <?php the_widget('Class_Widget_Evento', $instance, $args); ?>
        </div>
    </div>
</section>

<!-- PAGE CONTENT -->
<section id="content" class="container">
    <div class="row">

        <!-- MAIN COLUMN -->
        <main class="content-page" role="main">
            <div class="content-page-item">
                <h1 class="content-page-title">Notícias Estaduais:</h1>
                <?php if ( have_posts() ) : ?>
                    <ol id="article-list" class="list-post">
                        <?php get_template_part( 'loop-front-page', get_post_format() ); ?>
                    </ol>
                <?php else : ?>
                <?php endif; ?>
            </div>
        </main>

        <!-- SIDEBAR COLUMNS -->
        <?php get_sidebar(); ?>
    </div>

</section>

<!-- INSTAGRAM -->
<section id="instagram" class="">
    <div id="instafeed"></div>
</section>
<?php get_footer(); ?>
