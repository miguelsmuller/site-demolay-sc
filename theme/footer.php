    <?php $configTema = get_option( 'config_theme' ); ?>

    <!-- FOOTER FIRST -->
    <footer id="footer-first">
        <div class="container">
            <div class="row">

                <div class="footer-address">
                    <img src="<?php echo get_bloginfo( 'template_directory' ) ?>/assets/images/gcesc-logo-text-white.png" alt="Grande Capítulo de Santa Catarina">
                    <p><?php echo $configTema['address']; ?></p>
                </div>

                <div class="footer-menu">
                    <?php
                    $menuOptions = array(
                        'theme_location' => 'menu-rodape',
                        'container'      => false,
                        'menu_class'     => 'rodape-menu',
                    );
                    wp_nav_menu($menuOptions);
                    ?>
                </div>

                <div class="footer-lideranca">
                    <?php
                    echo '<ul>';
                        echo '<li>';
                            echo '<span class="role">Grande Mestre Estadual</span>';
                            echo '<br/>'. $configTema['gme'];
                        echo '</li>';
                        echo '<li>';
                            echo '<span class="role">Mestre Conselheiro Estadual</span>';
                            echo '<br/>'. $configTema['mce'];
                        echo '</li>';
                        echo '<li>';
                            echo '<span class="role">Mestre Conselheiro Estadual Adjunto</span>';
                            echo '<br/>'. $configTema['mcea'];
                        echo '</li>';
                    echo '</ul>';
                    ?>
                </div>
            </div>
        </div>
    </footer>

    <!-- FOOTER SECOND -->
    <footer id="footer-second">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <p class="footer-copyright"><?php echo copyright(); ?> Todos os direitos reservados ao Grande Capítulo do Estado de Santa Catarina. Este material não pode ser publicado, transmitido por broadcast, reescrito ou redistribuição sem prévia autorização.</p>
                </div>
                <div class="col-md-4">
                    <a href="http://www.devim.com.br" target="_blank">
                        <img class="footer-logo-devim" src="<?php echo get_bloginfo( 'template_directory' ) ?>/assets/images/logo-devim.png" alt="Devim - Desenvolvimento e Gestão Web">
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>