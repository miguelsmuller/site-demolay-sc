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
                        <h1 class="article-title">Biblioteca de arquivo</h1>
                    </header>
                    <div class="article-entry">

<div class="row">
    <div class="archive-arquivo-search">
        <h1 class="heading">Procurar arquivo</h1>
        <form action="<?php bloginfo('url'); ?>" method="get" accept-charset="utf-8" role="search" >
            <div class="input-group">
                <input type="text" name="s" id="search" class="form-control" value="<?php the_search_query(); ?>" placeholder="Critério de pesquisa">
                <span class="input-group-btn">
                    <input class="btn btn-theme" type="submit" value="Procurar Arquivo">
                </span>
            </div>
            <input type="hidden" name="post_type[]" value="arquivo" />
        </form>
    </div>
</div>

<div class="row">
    <div class="archive-arquivo-last">
        <h1 class="heading">Últimos Arquivos</h1>
        <?php
            $query_ultimos_arquivos = new WP_Query(array(
                'post_type'      => 'arquivo',
                'orderby'        => 'date',
                'order'          => 'DESC',
                'posts_per_page' => 5
            ));
            echo '<ul class="well list-unstyled">';
            while ( $query_ultimos_arquivos->have_posts() ) : $query_ultimos_arquivos->the_post();
                echo '<li class="">';
                echo '<table style="width: 100%;">
                <tr>
                <td>'.get_the_title().'</td>
                <td style="width: 55px;">
                    <span style="margin-left: 10px;">
                    <a href="' . get_permalink() . 'action/view" target="_blank"><span class="icon-eye"></span></a> |
                    <a href="' . get_permalink() . 'action/down" target="_blank"><span class="icon-cloud-download"></span></a>
                    </span>
                </td>
                </tr>
                </table>';
                echo '</li>';
            endwhile;
            echo '</ul>';
        ?>
    </div>
    <div class="archive-arquivo-popular">
        <h1 class="heading">Arquivos Populares</h1>
        <?php
            $query_arquivos_populares = new WP_Query(array(
                'post_type'      => 'arquivo',
                'orderby'        => 'meta_value_num',
                'meta_key'       => 'file_qtdown',
                'order'          => 'DESC',
                'posts_per_page' => 5
            ));
            echo '<ul class="well list-unstyled">';
            while ( $query_arquivos_populares->have_posts() ) : $query_arquivos_populares->the_post();
            echo '<li class="">';
                echo '<table style="width: 100%;">
                <tr>
                <td>'.get_the_title().'</td>
                <td style="width: 55px;">
                    <span style="margin-left: 10px;">
                    <a href="' . get_permalink() . 'action/view" target="_blank"><span class="icon-eye"></span></a> |
                    <a href="' . get_permalink() . 'action/down" target="_blank"><span class="icon-cloud-download"></span></a>
                    </span>
                </td>
                </tr>
                </table>';
                echo '</li>';


            endwhile;
            echo '</ul>';
        ?>
    </div>
</div>
<div class="row">
    <div class="archive-arquivo-category">
        <h1 class="heading">
            <span class="title">Arquivos por categoria</span>
            <span class="bottom"></span>
        </h1>
        <?php
            $args = array(
                'taxonomy'          => 'arquivo-categoria',
                'hide_empty'        => false,
                'title_li'          => ''
            );
            echo '<ul class="well list-unstyled">';
                wp_list_categories( $args );
            echo '</ul>';
        ?>
    </div>
    <div class="archive-arquivo-period">
        <h1 class="heading">
            <span class="title">Arquivos por gestão</span>
            <span class="bottom"></span>
        </h1>
        <?php
            $args = array(
                'taxonomy'          => 'arquivo-periodo',
                'hide_empty'        => false,
                'title_li'          => ''
            );
            echo '<ul class="well list-unstyled">';
                wp_list_categories( $args );
            echo '</ul>';
        ?>
    </div>
</div>
<div class="row">
    <div class="archive-arquivo-reference">
        <h1 class="heading">
            <span class="title">Referências mais usadas</span>
            <span class="bottom"></span>
        </h1>
        <?php
            echo '<div class="tab-pane fade active in widget-tagcloud" id="tags">';
            $args = array(
                'orderby'   => 'count',
                'order'     => 'DESC',
                'taxonomy'  => 'arquivo-referencia'
            );
            wp_tag_cloud($args);
            echo '</div>';
        ?>
    </div>
</div>

                    </div>
                </article>
            </div>

        </main>

        <!-- SIDEBAR COLUMNS -->
        <?php get_sidebar(); ?>
    </div>

</section>

<?php get_footer(); ?>