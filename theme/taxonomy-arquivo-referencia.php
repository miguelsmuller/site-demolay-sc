<?php get_header(); ?>

<!-- PAGE CONTENT -->
<section id="content" class="container">
    <div class="row">

        <!-- MAIN COLUMN -->
        <main class="content-page" role="main">

            <!-- ARTICLE CONTAINER -->
            <div class="content-page-item">
                <article id="post-<?php the_ID(); ?>" class="article article-full">
                    <header>
                        <?php $term = get_term_by( 'slug', get_query_var( 'term' ), 'arquivo-referencia' ); ?>
                        <h1 class="article-title">Biblioteca - ReferĂȘncia "<?php echo $term->name ?>"</h1>
                        <h4><?php echo $term->description ; ?></h4>
                    </header>
                    <div class="article-entry">






<?php
$termchildren = get_term_children( $term->term_id, 'arquivo-referencia' );
if ( count($termchildren) >= 1) {
?>
<div class="row">
    <div class="archive-generic">
        <h1 class="heading">Sub-categorias de "<?php echo $term->name ?>"</h1>
        <?php
            $args = array(
                'taxonomy'          => 'arquivo-referencia',
                'hide_empty'        => false,
                'title_li'          => '',
                'child_of'          => $term->term_id
            );
            echo '<ul class="well list-unstyled">';
                wp_list_categories( $args );
            echo '</ul>';
        ?>
    </div>
</div>
<?php
}
?>




<?php
$loop = new WP_Query(array(
    'post_type' => 'arquivo',
    'tax_query' => array( array(
        'taxonomy' => 'arquivo-referencia',
        'field' => 'slug',
        'terms' => $term->slug,
        'include_children' => true)),
    'paged'   => $paged,
    'orderby' => 'title',
    'order'   => 'ASC'
));
if ( $loop->have_posts() ) {
?>
<div class="row">
    <div class="archive-generic">
        <h1 class="heading">Arquivos em "<?php echo $term->name ?>"</h1>
        <ul class="list-unstyled">
            <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <?php
            //DADOS BĂSICOS DA PUBLICAĂĂO
            $id        = $post->ID;
            $title     = get_the_title();
            $permalink = get_permalink();

            //META DADOS DA PUBLICAĂĂO
            $post_meta   = get_post_meta($post->ID);
            $file_qtdown = empty($post_meta['file_qtdown'][0]) ? '0' : $post_meta['file_qtdown'][0];

            //ALGUMAS
            $permalink_visualizar = get_permalink().'action/view';
            $permalink_download   = get_permalink().'action/down';

            if (get_post_status( $post->ID ) == 'draft') {
                $links = "<p>Esse download se encontra indisponĂ­vel no momento.</p>";
                $conteudo = "";
            } else {
                if ( ((  get_post_status( $post->ID ) == 'private'  ) && (is_user_logged_in())) || (  get_post_status( $post->ID ) != 'private') ){
                    $links = "<div class='clearfix' style='margin-top: 12px;'>
                                <span class='pull-right'>
                                <a class='btn btn-theme' href='$permalink_visualizar' target='_blank'>Visualizar</a>
                                <a class='btn btn-theme' href='$permalink_download'>Download</a></span>
                                </div>";
                    $conteudo = get_the_content();
                }else{
                    $links = "<p>VocĂȘ precisa ser um membro registrado para poder acessar esse arquivo.</p>";
                    $conteudo = "";
                }
            }
            ?>
            <li class="well">
                <ul class="list-unstyled">
                    <li><h5 class="nomargin"><?php the_title(); ?></h5></li>
                    <li><?php echo $conteudo; ?></li>
                    <li><?php echo $links; ?></li>
                </ul>
            </li>
        <?php endwhile; wp_reset_query(); ?>
        </ul>
    </div>
</div>
<?php
}
?>









                    </div>
                </article>
            </div>

        </main>

        <!-- SIDEBAR COLUMNS -->
        <?php get_sidebar(); ?>
    </div>

</section>

<?php get_footer(); ?>