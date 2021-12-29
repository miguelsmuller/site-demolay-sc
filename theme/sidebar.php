<aside class="content-sidebar" role="complementary">
    <?php
    if (is_home()){
        dynamic_sidebar( 'sidebar-principal' );
    }else{
        dynamic_sidebar( 'sidebar-interna' );
    }
    ?>
</aside>