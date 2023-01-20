<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
register_nav_menus(
    array(
        'menu_header' => 'menu_header'
    )
);

add_theme_support('post-thumbnails');

add_image_size("slider_mini_thumbs", 65, 65, true);
add_image_size("slider_small_thumbs", 224, 190, true);
add_image_size("slider_thumbs", 960, 360, true);
add_image_size("list_articles_thumbs", 350, 250, true);
add_image_size("foto_actitud_thumbs", 460, 289, true);

function digwp_bloginfo_shortcode($atts)
{
    extract(shortcode_atts(array(
        'key' => '',
    ), $atts));
    return get_bloginfo($key);
}

add_shortcode('bloginfo', 'digwp_bloginfo_shortcode');

add_filter('get_user_option_admin_color', 'update_user_option_admin_color', 5);

function update_user_option_admin_color($color_scheme)
{
    $color_scheme = 'vida';

    return $color_scheme;
}

//add_action('publish_post', 'emailNotification');
function quitar_menus()
{
    global $menu, $submenu, $user_ID;
    $the_user = new WP_User($user_ID);
    if ($the_user->user_login == "contacto@equitel.com.co") {
        $restricted = array(__('Integrantes'),  __('Tools'), __('Users'), __('Settings'), __('Plugins'), __('Tutoriales'), __('Oportunidades'), __('Seguridad'), __('Conectate'));
        end($menu);
        while (prev($menu)) {
            $value = explode(' ', $menu[key($menu)][0]);
            if (in_array($value[0] != NULL ? $value[0] : "", $restricted)) {
                unset($menu[key($menu)]);
            }
        }
        $restricted_str = 'page=integrantes|page=tuto|page=sistemaGestion|page=solicitud';
        $result = preg_match('/(.*?)\/wp-admin\/admin.php\??(' . $restricted_str . ')??((' . $restricted_str . '){1})(.*?)/', $_SERVER['REQUEST_URI']);

        if ($result != 0 && $result != FALSE) {
            wp_redirect(get_option('siteurl') . '/wp-admin/');
            exit(0);
        }
    }
}
function limit_posts_per_archive_page()
{
    if (is_category())
        $limit = 4;
    elseif (is_tag()) $limit = 10;
    elseif (is_month()) $limit = 10;
    else $limit = get_option('posts_per_page');
    set_query_var('posts_per_archive_page', $limit);
}
add_filter('pre_get_posts', 'limit_posts_per_archive_page');


add_action('admin_menu', 'quitar_menus');
function so_screen_layout_columns($columns)
{
    $columns['dashboard'] = 2;
    return $columns;
}
//add_filter( 'screen_layout_columns', 'so_screen_layout_columns' );

function so_screen_layout_dashboard()
{
    return 2;
}
//add_filter( 'get_user_option_screen_layout_dashboard', 'so_screen_layout_dashboard' ); 

add_action('phpmailer_init', 'send_smtp_email');
function send_smtp_email($phpmailer)
{
    // Define que estamos enviando por SMTP
    $phpmailer->isSMTP();

    // La dirección del HOST del servidor de correo SMTP p.e. smtp.midominio.com
    $phpmailer->Host = "smtp.gmail.com";

    // Uso autenticación por SMTP (true|false)
    $phpmailer->SMTPAuth = true;

    // Puerto SMTP - Suele ser el 25, 465 o 587
    $phpmailer->Port = "587";

    // Usuario de la cuenta de correo
    $phpmailer->Username = "novedadesit@equitel.com.co";

    // Contraseña para la autenticación SMTP
    $phpmailer->Password = "GoogleEquitel2017";

    // El tipo de encriptación que usamos al conectar - ssl (deprecated) o tls
    $phpmailer->SMTPSecure = "tls";

    $phpmailer->From = "tucuenta@decorreo.com";
    $phpmailer->FromName = "Equitel al Dia";
    $phpmailer->smtpConnect(
        array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
                "allow_self_signed" => true
            )
        )
    );
}

add_menu_page( 
    __( 'Simple', 'simple-wp' ),
    __( 'Simple', 'simple-wp' ), 
    'administrator', 
    'simplewp',
    'simple_dashboard'
);
// subpagina
add_submenu_page( 'simplewp',
               __( 'Ingresos', 'simple-wp' ),
               __( 'Ingresos', 'simple-wp' ), 
              'administrator', 'simplewp-ingresos',
              'simple_ingresos' 
);
?>