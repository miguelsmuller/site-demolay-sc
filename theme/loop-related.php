<?php
$tags = wp_get_post_tags($post->ID);
if ($tags) {
    $tag_ids = array();
    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;

    $posts = new WP_Query( array(
        'tag__in'      => $tag_ids,
        'post__not_in' => array($post->ID),
        'showposts'    => 3,
        'orderby'      => 'rand'
    ) );
    ?>

    <?php if ( $posts->have_posts() ) : ?>

    <div class="row">
        <ol class="list-post list-post-min">
            <?php while ( $posts->have_posts() ) :$posts-> the_post(); ?>
                <li class="list-post-column">
                    <article id="post-<?php the_ID(); ?>" class="article article-y">

                            <a href="<?php the_permalink() ?>">
                                <?php
                                if ( has_post_thumbnail() ) {
                                    the_post_thumbnail('post-thumbnail', array('class' => "article-thumbnails"));
                                } else {
                                    echo '<img src="'. get_bloginfo('template_directory') .'/assets/images/imagem-nao-disponivel.png" class="article-thumbnails" alt="Imagem não disponível">';
                                }
                                ?>
                            </a>

                        <header class="article-entry">
                            <a href="<?php the_permalink() ?>">
                                <h2 class="article-title">
                                    <?php the_title(); ?>
                                </h2>
                            </a>
                        </header>
                    </article>
                </li>
            <?php endwhile; ?>
        </ol>
    </div>

    <?php else : ?>
    <?php endif; ?>
<?php
}
?>