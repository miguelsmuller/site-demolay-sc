<?php
    $slides = new WP_Query( array(
        'post_type'      => 'slide',
        'post_status'    => 'publish',
        'posts_per_page' => '3',
        'orderby'        => 'date',
        'order'          => 'DESC'
    ) );
?>

<ol class="carousel-indicators">
    <?php
        $attr_item = 'active';
        $actual_slide = 0;
    ?>
    <?php if ( $slides->have_posts() ) : while ( $slides->have_posts() ) : $slides->the_post(); ?>
        <li data-target="#slider-front-page" data-slide-to="<?php echo $actual_slide; ?>" class="<?php echo $attr_item; ?>"></li>
        <?php
            $attr_item = '';
            $actual_slide += 1;
        ?>
    <?php endwhile; else : endif; ?>
</ol>

<div class="carousel-inner">
    <?php
        $attr_item = 'active';
    ?>
    <?php if ( $slides->have_posts() ) : while ( $slides->have_posts() ) : $slides->the_post(); ?>
        <?php
            if (get_field('tipo_destino') == 'interno'){
                $destino = get_field('destino_interno');
                $destino = get_permalink( $destino->ID );
            }else{
                $destino = get_field('destino_externo');
            }
            if($destino == '') $destino = '#';

            $nova_janela = get_field('nova_janela');
            $nova_janela = isset($nova_janela[0]) ? 'sim' : 'nao';
            $nova_janela = $nova_janela == 'sim' ? ' target="_blank"' : '';

        ?>
        <div class="item <?php echo($attr_item); ?>">
            <a href="<?php echo $destino; ?>" <?php echo $nova_janela; ?>>
                <?php
                $thumbnail = get_field('thumbnail');

                if( $thumbnail ) {
                    $new_url = wp_get_attachment_image_src( $thumbnail['id'], 'slide' );
                    $img_url = $new_url[0];
                    echo '<img width="100%" src="'. $img_url .'" />';
                }
                ?>
            </a>
        </div>
        <?php
            $attr_item = '';
        ?>
    <?php endwhile; else : endif; ?>
</div>
