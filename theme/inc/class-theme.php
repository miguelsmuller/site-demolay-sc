<?php
if ( ! defined( 'ABSPATH' ) ) exit;

include dirname(__FILE__).'/../assets/components/Aqua-Resizer/aq_resizer.php';

include 'class-featured-picture.php';
include 'class-post-type-area.php';

define('SISDM_API', 'https://webservice.demolay.org.br/');

/**
 * Criação dos menus, Configuração dos Thumbnails e dos ativação dos formatos de posts
 */
add_action( 'after_setup_theme', 'after_setup_theme' );
function after_setup_theme() {
    register_nav_menus(array(
        'menu-principal'    => 'Menu Principal',
        'menu-rodape'       => 'Menu Rodapé'
    ));

    add_theme_support( 'html5', array( 'gallery', 'caption' ) );

    add_theme_support('post-thumbnails', array( 'post' ));
    set_post_thumbnail_size( 500, 380, array( 'top', 'center') );
}


/**
 * Criação dos menus, Configuração dos Thumbnails e dos ativação dos formatos de posts
 */
add_action( 'init', 'init_wp' );
function init_wp() {
    update_option('thumbnail_size_w', 150);
    update_option('thumbnail_size_h', 150);
    update_option('thumbnail_crop', 1 );
    update_option('medium_size_w', 300);
    update_option('medium_size_h', 300);
    update_option('large_size_w', 1024);
    update_option('large_size_h', 1024);

    add_image_size('slide', '754', '270', array( 'top', 'center') );
}


/**
 * Registra uma área de widgets e desabilita alguns widgets padrões
 */
add_action( 'widgets_init', 'widgets_init' );
function widgets_init() {
    register_sidebar( array(
        'name'          => 'Sidebar Principal',
        'id'            => 'sidebar-principal',
        'description'   => 'Sidebar principal',
        'before_widget' => '<div class="panel panel-default">',
        'before_title'  => '<div class="panel-heading">',
        'after_title'   => '</div><div class="panel-body">',
        'after_widget'  => '</div></div>'
    ));

    register_sidebar( array(
        'name'          => 'Sidebar Interna',
        'id'            => 'sidebar-interna',
        'description'   => 'Sidebar Interna',
        'before_widget' => '<div class="panel panel-default">',
        'before_title'  => '<div class="panel-heading">',
        'after_title'   => '</div><div class="panel-body">',
        'after_widget'  => '</div></div>'
    ));

    unregister_widget( 'WP_Widget_Pages' );
    unregister_widget( 'WP_Widget_Calendar' );
    unregister_widget( 'WP_Widget_Archives' );
    unregister_widget( 'WP_Widget_Links' );
    unregister_widget( 'WP_Widget_Meta' );
    unregister_widget( 'WP_Widget_Categories' );
    unregister_widget( 'WP_Widget_Recent_Posts' );
    unregister_widget( 'WP_Widget_Recent_Comments' );
    unregister_widget( 'WP_Widget_RSS' );
    unregister_widget( 'WP_Widget_Tag_Cloud' );
}


/**
 * Carrega os arquivos JS's e CSS's do tema
 */
add_action('wp_enqueue_scripts', 'enqueue_scripts' );
function enqueue_scripts(){
	$template_dir = get_bloginfo('template_directory');

	// COMMON STYLE AND SCRIPT
	wp_register_script( 'common-js', $template_dir .'/assets/js/javascript.min.js', array('jquery'), null, true );
	wp_localize_script(
		'common-js',
		'common_params',
		array(
			'site_url'  => esc_url( site_url() )
		)
	);
	wp_enqueue_script( 'common-js' );
	wp_enqueue_style( 'common-css', $template_dir .'/assets/css/style.css' );

    if ( is_home() ) {
        wp_enqueue_script( 'instafeed', get_bloginfo('template_directory').'/assets/components/instafeed.js/instafeed.min.js', false, null, true);
    }
    if ( is_single() || is_page() ) {
        wp_enqueue_script('lightbox', get_bloginfo('template_directory').'/assets/components/lightbox/src/js/lightbox.js', false, '', true );
        wp_enqueue_style('lightbox', get_bloginfo('template_directory').'/assets/components/lightbox/src/css/lightbox.css');
    }
}

/**
 * Função quer permite a página infinita
 */
add_action('wp_ajax_infinite_scroll', 'wp_infinite_scroll');
add_action('wp_ajax_nopriv_infinite_scroll', 'wp_infinite_scroll');
function wp_infinite_scroll(){
    $template        = $_POST['template'];
    $post_type       = $_POST['post_type'];
    $posts_per_page  = $_POST['posts_per_page'];
    $paged           = $_POST['paged'];

    query_posts(array('post_type' => $post_type, 'posts_per_page' => $posts_per_page, 'paged' => $paged,));
    get_template_part( $template );

    exit;
}


/**
 * Remove o CSS e o JS do CF7 onde não tem necessidade
 */
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );
add_action( 'wp_head', 'cf_register_assets' );
function cf_register_assets() {
	if ( is_page( 'contact-us' ) ) {
		wpcf7_enqueue_scripts();
		wpcf7_enqueue_styles();
	}
}


/**
 * Mensagem de atualização de navegador inseguro
 */
add_filter( 'navigator_insecure', 'navigator_insecure' );
function navigator_insecure( $msg ){
    return 'Parece que está a usar uma versão não segura do <a href="%update_url%" class="alert-link">%name%</a>. Para melhor navegar no nosso site, por favor atualize o seu browser.<br/><a href="%update_url%" class="alert-link">Clique aqui para ser direcionado para atualização do %name% agora.</a>';
}


/**
 * Mensagem de atualização de navegador desatualizado
 */
add_filter( 'navigator_upgrade', 'navigator_upgrade' );
function navigator_upgrade( $msg ){
    return 'Parece que está a usar uma versão antiga do <a href="%s" class="alert-link"%name%</a>. Para melhor navegar no nosso site, por favor atualize o seu browser.<br/><a href="%update_url%" class="alert-link">Clique aqui para ser direcionado para atualização do %name% agora.</a>';
}


/**
 * Determina a imagem que será usada no fundo da página de login
 */
add_filter( 'change_login_bg', 'change_login_bg' );
function change_login_bg( $img ){
    return get_bloginfo( 'template_directory' ) . '/assets/images/image-login-background.png';
}


/**
 * Determina a imagem que será usada como logo na página de login
 */
add_filter( 'change_login_logo', 'change_login_logo' );
function change_login_logo( $img ){
    return get_bloginfo( 'template_directory' ) . '/assets/images/image-login.png';
}


/**
 * Cria um formulário pra ser usada pra configuração do tema
 */
add_action( 'admin_init', 'admin_init' );
function admin_init()
{
    /**
     * Endereçamento
     */
    add_settings_section(
        'section-address',             // ID usado para identificar esta secção e com a qual se registrar opções
        'Endereço de correspondência', // Título a ser exibido na página de administração
        null,                          // Callback usado para tornar a descrição da seção
        'page-config-theme'            // Página em que para adicionar esta seção de opções
    );
    add_settings_field(
        'address',                      // ID usado para identificar o campo ao longo do tema
        'Endereço de correspondência:', //Label do elemento na interface de opção
        function () {
            $config_theme = get_option( 'config_theme' );
            $html =  '<textarea id="address" name="config_theme[address]" rows="6" cols="70">' . $config_theme['address'] . '</textarea>';
            echo $html;
        },
        'page-config-theme', // A página em que esta opção será exibida
        'section-address'    // O nome da secção à qual pertence este campo
    );

    /**
     * Lideranças
     */
    add_settings_section(
        'section-leadership',
        'Lideranças desse grande capítulo',
        null,
        'page-config-theme'
    );
    add_settings_field(
        'gme',
        'Grande Mestre Estadual:',
        function () {
            $config_theme = get_option( 'config_theme' );
            $html = '<input type="text" id="gme" name="config_theme[gme]" value="'. $config_theme['gme'] .'" class="regular-text">';
            echo $html;
        },
        'page-config-theme',
        'section-leadership'
    );
    add_settings_field(
        'mce',
        'MCE:',
        function () {
            $config_theme = get_option( 'config_theme' );
            $html = '<input type="text" id="mce" name="config_theme[mce]" value="'. $config_theme['mce'] .'" class="regular-text">';
            echo $html;
        },
        'page-config-theme',
        'section-leadership'
    );
    add_settings_field(
        'mcea',
        'MCEA:',
        function () {
            $config_theme = get_option( 'config_theme' );
            $html = '<input type="text" id="mcea" name="config_theme[mcea]" value="'. $config_theme['mcea'] .'" class="regular-text">';
            echo $html;
        },
        'page-config-theme',
        'section-leadership'
    );


    /**
     * Lideranças
     */
    add_settings_section(
        'section-social',
        'Informações sobre redes sociais',
        null,
        'page-config-theme'
    );
    add_settings_field(
        'facebook-page',
        'Página do Facebook:',
        function () {
            $config_theme = get_option( 'config_theme' );
            $html = '<input type="text" id="facebook-page" name="config_theme[facebook-page]" value="'. $config_theme['facebook-page'] .'" class="regular-text">';
            echo $html;
        },
        'page-config-theme',
        'section-social'
    );
    add_settings_field(
        'facebook-id',
        'ID do Facebook:',
        function () {
            $config_theme = get_option( 'config_theme' );
            $html = '<input type="text" id="facebook-id" name="config_theme[facebook-id]" value="'. $config_theme['facebook-id'] .'" class="regular-text">';
            echo $html;
        },
        'page-config-theme',
        'section-social'
    );
    add_settings_field(
        'instagram-user',
        'Usuario do Instagram:',
        function () {
            $config_theme = get_option( 'config_theme' );
            $html = '<input type="text" id="instagram-user" name="config_theme[instagram-user]" value="'. $config_theme['instagram-user'] .'" class="regular-text">';
            echo $html;
        },
        'page-config-theme',
        'section-social'
    );


    register_setting(
        'page-config-theme',
        'config_theme',
        function( $input ) {
            $output = array();

            foreach( $input as $key => $val ) {

                if( isset ( $input[$key] ) ) {
                    $output[$key] = strip_tags( stripslashes( $input[$key] ), '<br><br/><br />' );
                }
                //if( isset ( $input[$key] ) ) {
                    //$output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
                //}
            }
            return apply_filters( 'sandbox_theme_sanitize_social_options', $output, $input );
        }
    );
}


/**
 * Cria um item do menu para o formulário criado
 */
add_action( 'admin_menu', 'admin_menu' );
function admin_menu()
{
    $page = add_submenu_page(
        'options-general.php',// $parent_slug
        'Outras configurações',// $page_title
        'Outras configurações',// $menu_title
        'administrator',// $capability
        'config-theme',// $menu_slug
        function () {
            ?>
            <div class="wrap">
                <div id="icon-options-general" class="icon32"></div>
                <h2>Configurações Gerais</h2>
                <form method="post" action="options.php">
                    <?php
                    settings_fields( 'page-config-theme' );
                    do_settings_sections( 'page-config-theme' );
                    submit_button();
                    ?>
                </form>
            </div>
            <?php
        }
    );
}


/**
 * PRECISA DE UM COMENTÁRIO
 */
add_action( 'admin_menu', 'remove_links_menu' );
function remove_links_menu() {
    remove_menu_page('edit-comments.php');
}


/**
 * PRECISA DE UM COMENTÁRIO
 */
add_action('init', 'modify_post_type');
function modify_post_type() {
    //REGISTER TAXONOMY ARQUIVO-PERIODO
    register_taxonomy('arquivo-periodo',array('arquivo'),
        array(
            'labels'  => array(
                'name'         => 'Período dos arquivos',
                'menu_name'    => 'Períodos dos Arquivos',
                'search_items' => 'Buscar período',
                'all_items'    => 'Todas os períodos',
                'edit_item'    => 'Editar período',
                'update_item'  => 'Atualizar período',
                'add_new_item' => 'Adicionar período'
            ),
            'public'        => false,
            'show_ui'       => true,
            'show_tagcloud' => false,
            'hierarchical'  => true,
            'rewrite'       => array( 'slug' => 'arquivo-periodo', 'with_front' => false ),
            'query_var'     => true,
    ));
}


/**
 * PRECISA DE UM COMENTÁRIO
 */
add_action('add_meta_boxes', 'add_meta_boxe_post');
function add_meta_boxe_post() {
    add_meta_box(
        'postOption',
        'Opções da Imagem Destacada:',
        function(){
            global $post;
            wp_nonce_field('nonce_action', 'nonce_name');

            $mostrar_thumbnail = get_post_meta( get_the_ID(), 'mostrar_thumbnail', True);
            $mostrar_thumbnail = ( empty($mostrar_thumbnail) or ($mostrar_thumbnail == 0)) ? False : True;

            ?>
            <div id="extrafields">
                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row"><label for="mostrar_thumbnail">Mostrar a imagem destacada apenas na listagem de notícias: </label></th>
                            <td>
                                <input type="checkbox" id="mostrar_thumbnail" name="mostrar_thumbnail" <?php checked( $mostrar_thumbnail, True ); ?> />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php
        },
        'post',
        'side',
        'low'
    );
}


/**
 * PRECISA DE UM COMENTÁRIO
 */
add_action('save_post', 'save_meta_post');
function save_meta_post( $post_id ) {
    if (get_post_type($post_id) !== 'post')
    return $post_id;

    // Antes de dar inicio ao salvamento precisamos verificar 3 coisas:
    // Verificar se a publicação é salva automaticamente
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    //Verificar o valor nonce criado anteriormente, e finalmente
    if( !isset( $_POST['nonce_name'] ) || !wp_verify_nonce($_POST['nonce_name'], 'nonce_action') ) return;
    //Verificar se o usuário atual tem acesso para salvar a pulicação
    if( !current_user_can( 'edit_post' ) ) return;

    // MOSTRAR_THUMB_SINGLE
    $valueChk = isset( $_POST['mostrar_thumbnail'] ) && $_POST['mostrar_thumbnail'] ? 1 : 0;
        update_post_meta( $post_id, 'mostrar_thumbnail', $valueChk );
}


/**
 * PRECISA DE UM COMENTÁRIO
 */
add_filter('wp_authenticate_user', 'auth_login',10,2);
function auth_login ($user, $password) {
    if (!is_numeric($user)){
        return $user;
    }

    $key = get_field('api_key_google', 'option');
    $url = SISDM_API . 'memberforevents/' .$current_user->user_login;
    $context = stream_context_create(array(
        'http' => array(
            'header' => 'Authorization: Basic '. $key
        )
    ));
    $data = file_get_contents($url, false, $context);
    if (false !== ($data = @file_get_contents($url, false, $context))){
        $xmlObj = simplexml_load_string($data);
        $arrXml = objectsIntoArray($xmlObj);

        if ($arrXml['regularity'] == 'Sim') {
            return $user;
        }else{
            return new WP_Error('cid_broke','CID irregular junto ao SISDM');
        }
    }else{
        return new WP_Error('sisdm_broke','Não foi possivel se conectar ao SISDM');
    }
}


/**
 * PRECISA DE UM COMENTÁRIO
 */
add_filter( 'wp_get_attachment_link' , 'filter_wp_get_attachment_link' );
function filter_wp_get_attachment_link( $attachment_link )
{
    $attachment_link = str_replace("attachment-thumbnail", "img-rounded img-polaroid attachment-thumbnail", $attachment_link);
    return $attachment_link;
}


/**
 * PRECISA DE UM COMENTÁRIO
 */
function do_pagination( $args = array() ) {
    global $wp_query;

    $defaults = array(
        'big_number' => 999999999,
        'base'       => str_replace( 999999999, '%#%', get_pagenum_link( 999999999 ) ),
        'format'     => '?paged=%#%',
        'current'    => max( 1, get_query_var( 'paged' ) ),
        'total'      => $wp_query->max_num_pages,
        'prev_next'  => true,
        'end_size'   => 1,
        'mid_size'   => 2,
        'type'       => 'list'
    );

    $args = wp_parse_args( $args, $defaults );
    extract( $args, EXTR_SKIP );

    if ( $total == 1 ) return;

    $paginate_links = apply_filters( 'paginacao', paginate_links( array(
        'base'      => $base,
        'format'    => $format,
        'current'   => $current,
        'total'     => $total,
        'prev_next' => $prev_next,
        'end_size'  => $end_size,
        'mid_size'  => $mid_size,
        'type'      => $type
    ) ) );

    echo preg_replace( "/<ul class='page-numbers/", "<ul class='pagination", $paginate_links);
}


/**
 * PRECISA DE UM COMENTÁRIO
 */
function list_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);
?>
    <li id="comment-<?php comment_ID() ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?>>

    <div class="comment-avatar">
        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
    </div>

    <div class="comment-body">
        <?php if ( $comment->comment_approved == '0' ) : ?>
            <em class="label label-warning label-awaiting-moderation">Esse comentário está aguardando moderação.</em>
        <?php endif; ?>
        <?php
            $name = '<cite class="fn">'. get_comment_author_link() .'</cite>';
            $time = human_time_diff( get_comment_date('U'), current_time('timestamp') ) . ' atrás';
            $time = '<a href="'. htmlspecialchars( get_comment_link( $comment->comment_ID ) ) . '">'. $time . '</a>';
            echo $name .' • '. $time ;
        ?>

        <?php edit_comment_link( '(Edit)', '  ', '' );?>

        <?php comment_text(); ?>

        <div class="reply">
        <?php
            $argsMerge = array_merge( $args, array(
                                        'add_below' => 'div-comment',
                                        'depth' => $depth,
                                        'max_depth' => $args['max_depth'] )
            );
            $replyLink = get_comment_reply_link( $argsMerge );
            echo $replyLink;
        ?>
        </div>
    </div>
<?php
}
