<?php while ( have_posts() ) : the_post(); ?>
    <!-- POST ITEM -->
    <li class="list-post-row">
        <article id="post-<?php the_ID(); ?>" class="article article-x clearfix">
            <div class="article-thumbnails">
                <a href="<?php the_permalink() ?>">
                    <?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail('post-thumbnail', array('class' => "img-responsive"));
                    } else {
                        echo '<img src="'. get_bloginfo('template_directory') .'/assets/images/imagem-nao-disponivel.png" class="img-responsive wp-post-image" alt="Imagem não disponível">';
                    }
                    ?>
                </a>
            </div>
            <div class="article-entry">
                <header>
                    <h2 class="article-title">
                        <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                    </h2>
                </header>
                <?php the_excerpt(); ?>
            </div>
        </article>
    </li>
<?php endwhile; ?>