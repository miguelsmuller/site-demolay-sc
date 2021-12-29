<?php get_header(); ?>

<!-- PAGE CONTENT -->
<section id="content" class="container">
    <div class="row">

        <!-- MAIN COLUMN -->
        <main class="content-page" role="main">

            <!-- ARTICLE CONTAINER -->
            <div class="content-page-item">
                <article id="" class="article article-full">
                    <?php
                        global $wp_query;
                        $total_results = $wp_query->found_posts;
                    ?>
                    <header>
                        <h1 class="article-title">Resultado da busca para "<?php the_search_query(); ?>"</h1>
                        <h5><?php echo $total_results; ?> itens encontrados</h5>
                    </header>

                    <div class="archive-arquivo-search">
                        <h1 class="heading">Redefinir busca</h1>
                        <form action="<?php bloginfo('url'); ?>" method="get" accept-charset="utf-8" role="search" >
                            <div class="input-group">
                                <div class="input-group-btn">

                                    <?php $query_types = get_query_var('post_type'); ?>
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Opções de pesquisa <span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-menu-content">
                                        <li><input type="checkbox" id="eventos" name="post_type[]" value="evento" <?php if (in_array('evento', $query_types)) { echo 'checked="checked"'; } ?> /> <label for="eventos">Eventos</label></li>
                                        <li><input type="checkbox" id="noticias" name="post_type[]" value="post" <?php if (in_array('post', $query_types)) { echo 'checked="checked"'; } ?> /> <label for="noticias">Notícias</label></li>
                                        <li><input type="checkbox" id="paginas" name="post_type[]" value="page" <?php if (in_array('page', $query_types)) { echo 'checked="checked"'; } ?> /> <label for="paginas">Páginas Internas</label></li>
                                        <li><input type="checkbox" id="arquivos" name="post_type[]" value="arquivo" <?php if (in_array('arquivo', $query_types)) { echo 'checked="checked"'; } ?> /> <label for="arquivos">Arquivos da Biblioteca</label></li>
                                    </ul>

                                </div>
                                <input type="text" class="form-control" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="Critério de pesquisa">
                                <span class="input-group-btn">
                                    <button class="btn btn-theme" type="submit">Procurar publicação</button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <ol class="list-search">
                        <?php if (have_posts()) : while (have_posts()) : the_post();  ?>
                            <li>
                                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                                    <?php
                                    switch (get_post_type()) {
                                        case 'page':
                                            $post_name = "Página interna";
                                            break;
                                        case 'post':
                                            $post_name = "Notícia";
                                            break;
                                        case 'arquivo':
                                            $post_name = "Arquivo da Biblioteca";
                                            break;
                                        case 'evento':
                                            $post_name = "Evento";
                                            break;
                                    }
                                    ?>
                                    [<?php echo $post_name; ?>] <?php get_the_title() ?><a href="<?php the_permalink() ?>"><?php the_title(); ?></a> <span class="date">(<?php the_time('d/m/Y'); ?>)</span>
                                    <hr>

                                </article>
                            </li>
                        <?php endwhile; else: ?>
                        <?php endif; ?>
                    </ol>
                </article>

            </div>

        </main>

        <!-- SIDEBAR COLUMNS -->
        <?php get_sidebar(); ?>
    </div>

</section>

<?php get_footer(); ?>