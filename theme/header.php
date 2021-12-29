<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php wp_title( '|', true, 'right' ); ?></title>

    <link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/assets/images/icons/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php bloginfo('template_directory'); ?>/assets/images/icons/favicon-144.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php bloginfo('template_directory'); ?>/assets/images/icons/favicon-114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php bloginfo('template_directory'); ?>/assets/images/icons/favicon-72.png">
    <link rel="apple-touch-icon-precomposed" href="<?php bloginfo('template_directory'); ?>/assets/images/icons/favicon-57.png">

    <?php wp_head();?>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-50804179-1', 'demolaysc.com.br');
        ga('send', 'pageview');
    </script>
</head>
<body <?php body_class(); ?>>

    <?php do_action( 'after_body' ); ?>

    <!-- STRIPE BAR -->
    <section id="stripe-top"></section>

    <!-- MENU TOP -->
    <section id="menu-top">
        <div class="container">
            <?php
            $config_user = get_option( 'config_user' );
            if ( !is_user_logged_in() ) {
                $page_new_user = isset( $config_user['pageNewUser'] ) ? $config_user['pageNewUser'] : '';
                echo '<span>Você não está logado. <a href="#" data-toggle="modal" data-target="#login-box">Fazer login agora</a> ou <a href="'. get_permalink( $page_new_user ) .'">Não é cadastrado.</a></span>';

            }else{
                $current_user = wp_get_current_user();
                $page_edit_user = isset( $config_user['pageEditUser'] ) ? $config_user['pageEditUser'] : '';
                echo '<span>Seja bem vindo de volta '. $current_user->display_name . ' <a href="'. get_permalink( $page_edit_user ) .'">Veja seu perfil</a> ou <a href="'. wp_logout_url(home_url()) .'" title="Logout">Sair do modo logado.</a></span>';
            }
            ?>
        </div>
    </section>

    <!-- LOGIN -->
    <?php
    if ( !is_user_logged_in() ) {
    ?>
    <section id="login-box" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="loginform" name="loginform" method="post" action="<?php echo wp_login_url(); ?>" role="form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Área Restrita</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="user_login">Usuário</label>
                            <input type="text" class="form-control" style="border-radius:0px" name="log" id="user_login" placeholder="CID">
                        </div>
                        <div class="form-group">
                            <label for="user_pass">Senha <a href="<?php echo wp_lostpassword_url( get_bloginfo('url') ); ?>">(Perdi a senha)</a></label>
                            <input type="password" class="form-control" style="border-radius:0px" name="pwd" id="user_pass" placeholder="Senha">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary">Acessar conteúdo restrito</button>
                        <input type="hidden" name="redirect_to" value="<?php echo get_actual_url(); ?>">
                    </div>
                </div>
            </form>
        </div>
    </section>
    <?php
    }
    ?>

    <!-- HEADER -->
    <header id="header-main" class="container">
        <div id="header-main-image">
            <a href="<?php bloginfo('url') ?>">
                <img src="<?php bloginfo('template_directory'); ?>/assets/images/gcesc-logo.png">
            </a>
        </div>

        <div id="header-main-extra">
            <a href="<?php bloginfo('url') ?>">
                <img src="<?php bloginfo('template_directory'); ?>/assets/images/gcesc-logo-text-black.png">
            </a>
            <nav id="navigation-main" class="navbar navbar-inverse" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="navbar-collapse collapse navbar-ex1-collapse">
                    <?php
                    $args = array(
                        'theme_location' => 'menu-principal',
                        'container'      => false,
                        'menu_class'     => 'nav navbar-nav',
                        'fallback_cb'    => 'fallbackNoMenu',
                        'walker'         => new MenuBootstrapRestrict()
                    );
                    wp_nav_menu($args);
                    ?>
                </div>
            </nav>

            <div id="header-main-search">
                <form action="<?php echo get_bloginfo( 'url' ) ?>" method="get" accept-charset="utf-8">
                    <fieldset>
                        <div class="form-group">
                            <input type="text" name="s" id="search" class="form-control" value="<?php the_search_query(); ?>" placeholder="Busca rápida ">
                            <input type="hidden" name="post_type[]" value="post" />
                            <input type="hidden" name="post_type[]" value="page" />
                        </div>

                    </fieldset>
                </form>
            </div>

        </div>

    </header>
