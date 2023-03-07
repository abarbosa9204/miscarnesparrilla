<?php

/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 */

/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if (version_compare($GLOBALS['wp_version'], '4.7-alpha', '<')) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentyseventeen_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyseventeen
	 * If you're building a theme based on Twenty Seventeen, use a find and replace
	 * to change 'twentyseventeen' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('twentyseventeen');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enables custom line height for blocks
	 */
	add_theme_support('custom-line-height');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	add_image_size('twentyseventeen-featured-image', 2000, 1200, true);

	add_image_size('twentyseventeen-thumbnail-avatar', 100, 100, true);

	// Set the default content width.
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus(
		array(
			'menu_header' => 'menu_header',
			'top'    => __('Top Menu', 'twentyseventeen'),
			'social' => __('Social Links Menu', 'twentyseventeen'),
		)
	);
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
			'navigation-widgets',
		)
	);

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://wordpress.org/support/article/post-formats/
	 */
	add_theme_support(
		'post-formats',
		array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'audio',
		)
	);

	// Add theme support for Custom Logo.
	add_theme_support(
		'custom-logo',
		array(
			'width'      => 250,
			'height'     => 250,
			'flex-width' => true,
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
	 */
	add_editor_style(array('assets/css/editor-style.css', twentyseventeen_fonts_url()));

	// Load regular editor styles into the new block-based editor.
	add_theme_support('editor-styles');

	// Load default block styles.
	add_theme_support('wp-block-styles');

	// Add support for responsive embeds.
	add_theme_support('responsive-embeds');

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets'     => array(
			// Place three core-defined widgets in the sidebar area.
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),

			// Add the core-defined business info widget to the footer 1 area.
			'sidebar-2' => array(
				'text_business_info',
			),

			// Put two core-defined widgets in the footer 2 area.
			'sidebar-3' => array(
				'text_about',
				'search',
			),
		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts'       => array(
			'home',
			'about'            => array(
				'thumbnail' => '{{image-sandwich}}',
			),
			'contact'          => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'blog'             => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'homepage-section' => array(
				'thumbnail' => '{{image-espresso}}',
			),
		),

		// Create the custom image attachments used as post thumbnails for pages.
		'attachments' => array(
			'image-espresso' => array(
				'post_title' => _x('Espresso', 'Theme starter content', 'twentyseventeen'),
				'file'       => 'assets/images/espresso.jpg', // URL relative to the template directory.
			),
			'image-sandwich' => array(
				'post_title' => _x('Sandwich', 'Theme starter content', 'twentyseventeen'),
				'file'       => 'assets/images/sandwich.jpg',
			),
			'image-coffee'   => array(
				'post_title' => _x('Coffee', 'Theme starter content', 'twentyseventeen'),
				'file'       => 'assets/images/coffee.jpg',
			),
		),

		// Default to a static front page and assign the front and posts pages.
		'options'     => array(
			'show_on_front'  => 'page',
			'page_on_front'  => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods'  => array(
			'panel_1' => '{{homepage-section}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
		),

		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus'   => array(
			// Assign a menu to the "top" location.
			'top'    => array(
				'name'  => __('Top Menu', 'twentyseventeen'),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
					'page_contact',
				),
			),

			// Assign a menu to the "social" location.
			'social' => array(
				'name'  => __('Social Links Menu', 'twentyseventeen'),
				'items' => array(
					'link_yelp',
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_email',
				),
			),
		),
	);

	/**
	 * Filters Twenty Seventeen array of starter content.
	 *
	 * @since Twenty Seventeen 1.1
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters('twentyseventeen_starter_content', $starter_content);

	add_theme_support('starter-content', $starter_content);
}
add_action('after_setup_theme', 'twentyseventeen_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function twentyseventeen_content_width()
{

	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod('page_layout');

	// Check if layout is one column.
	if ('one-column' === $page_layout) {
		if (twentyseventeen_is_frontpage()) {
			$content_width = 644;
		} elseif (is_page()) {
			$content_width = 740;
		}
	}

	// Check if is single post and there is no sidebar.
	if (is_single() && !is_active_sidebar('sidebar-1')) {
		$content_width = 740;
	}

	/**
	 * Filters Twenty Seventeen content width of the theme.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters('twentyseventeen_content_width', $content_width);
}
add_action('template_redirect', 'twentyseventeen_content_width', 0);

/**
 * Register custom fonts.
 */
function twentyseventeen_fonts_url()
{
	$fonts_url = '';

	/*
	 * translators: If there are characters in your language that are not supported
	 * by Libre Franklin, translate this to 'off'. Do not translate into your own language.
	 */
	$libre_franklin = _x('on', 'Libre Franklin font: on or off', 'twentyseventeen');

	if ('off' !== $libre_franklin) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		$query_args = array(
			'family'  => urlencode(implode('|', $font_families)),
			'subset'  => urlencode('latin,latin-ext'),
			'display' => urlencode('fallback'),
		);

		$fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
	}

	return esc_url_raw($fonts_url);
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed.
 * @return array URLs to print for resource hints.
 */
function twentyseventeen_resource_hints($urls, $relation_type)
{
	if (wp_style_is('twentyseventeen-fonts', 'queue') && 'preconnect' === $relation_type) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter('wp_resource_hints', 'twentyseventeen_resource_hints', 10, 2);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentyseventeen_widgets_init()
{
	register_sidebar(
		array(
			'name'          => __('Blog Sidebar', 'twentyseventeen'),
			'id'            => 'sidebar-1',
			'description'   => __('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'twentyseventeen'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __('Footer 1', 'twentyseventeen'),
			'id'            => 'sidebar-2',
			'description'   => __('Add widgets here to appear in your footer.', 'twentyseventeen'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __('Footer 2', 'twentyseventeen'),
			'id'            => 'sidebar-3',
			'description'   => __('Add widgets here to appear in your footer.', 'twentyseventeen'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'twentyseventeen_widgets_init');

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function twentyseventeen_excerpt_more($link)
{
	if (is_admin()) {
		return $link;
	}

	$link = sprintf(
		'<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url(get_permalink(get_the_ID())),
		/* translators: %s: Post title. Only visible to screen readers. */
		sprintf(__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen'), get_the_title(get_the_ID()))
	);
	return ' &hellip; ' . $link;
}
add_filter('excerpt_more', 'twentyseventeen_excerpt_more');

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function twentyseventeen_javascript_detection()
{
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action('wp_head', 'twentyseventeen_javascript_detection', 0);

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function twentyseventeen_pingback_header()
{
	if (is_singular() && pings_open()) {
		printf('<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo('pingback_url')));
	}
}
add_action('wp_head', 'twentyseventeen_pingback_header');

/**
 * Display custom color CSS.
 */
function twentyseventeen_colors_css_wrap()
{
	if ('custom' !== get_theme_mod('colorscheme') && !is_customize_preview()) {
		return;
	}

	require_once get_parent_theme_file_path('/inc/color-patterns.php');
	$hue = absint(get_theme_mod('colorscheme_hue', 250));

	$customize_preview_data_hue = '';
	if (is_customize_preview()) {
		$customize_preview_data_hue = 'data-hue="' . $hue . '"';
	}
?>
	<style type="text/css" id="custom-theme-colors" <?php echo $customize_preview_data_hue; ?>>
		<?php echo twentyseventeen_custom_colors_css(); ?>
	</style>
<?php
}
add_action('wp_head', 'twentyseventeen_colors_css_wrap');



function mcp_manager()
{
	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM wp_menus WHERE MenuStatus = 1", OBJECT);
	foreach ($results as $menus) {
		$folderView = $menus->FolderView;
		$menuSlug = $menus->MenuSlug;
		if ($menus->MenuType == 1) {
			add_menu_page(
				$menus->PageTitle, //Titulo de la pagina
				$menus->MenuTitle, // Titulo del menu
				$menus->Capability, // Capability
				$menus->MenuSlug, //slug
				function () use ($folderView, $menuSlug) {
					home_render_view($folderView, $menuSlug);
				},
				get_template_directory() . '/assets/icons/' . $menus->IconUrl, //icono,
				null
			);
		}
		if ($menus->MenuType == 2) {
			$folderView = $menus->FolderView;
			$menuSlug = $menus->MenuSlug;
			add_submenu_page(
				$menus->parentSlug, //Titulo de la pagina
				$menus->PageTitle, //Titulo de la pagina
				$menus->MenuTitle, // Titulo del menu
				$menus->Capability, // Capability
				$menus->MenuSlug, //slug				
				function () use ($folderView, $menuSlug) {
					home_render_view($folderView, $menuSlug);
				}
				//$menus->FunctionMenu, //function del contenido*/
			);
		}
	}
}
add_action('admin_menu', 'mcp_manager');

function home_render_view($folderView, $menuSlug)
{
	require_once(get_template_directory() . '/inc/templates/views/' . $folderView . '/' . $menuSlug . '.php');
}

require_once(get_template_directory() . '/inc/templates/libs/app.php');

//Mercadeo
add_action('wp_ajax_marketing_advertising', 'marketing_advertising');
add_action('wp_ajax_nopriv_marketing_advertising', 'marketing_advertising');

//Calidad
add_action('wp_ajax_quality', 'quality');
add_action('wp_ajax_nopriv_quality', 'quality');

//PQR
add_action('wp_ajax_pqr', 'pqr');
add_action('wp_ajax_nopriv_pqr', 'pqr');

//Talento Humano
add_action('wp_ajax_human_talent', 'human_talent');
add_action('wp_ajax_nopriv_human_talent', 'human_talent');

//Costos y presupuestos
add_action('wp_ajax_cost_budget', 'cost_budget');
add_action('wp_ajax_nopriv_cost_budget', 'cost_budget');

// Function Mercadeo
function marketing_advertising()
{
	echo process_request($_POST);
	die;
}
// Function Calidad
function quality()
{
	echo process_request($_POST);
	die;
}

// Function PQR
function pqr()
{
	echo process_request($_POST);
	die;
}

// Function Talento Humano
function human_talent()
{
	echo process_request($_POST);
	die;
}

// Function Costos y presupuestos
function cost_budget()
{
	echo process_request($_POST);
	die;
}

function process_request($request, $files = null)
{
	$app = new App($request, $files);
	return json_encode($app);
}

function aw_scripts()
{
	// Register the script
	wp_register_script('aw-custom', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), '1.1', true);
	// Localize the script with new data
	$script_data_array = array(
		'ajaxurl' => admin_url('admin-ajax.php'),
	);
	wp_localize_script('aw-custom', 'aw', $script_data_array);
	// Enqueued script with localized data.
	wp_enqueue_script('aw-custom');
}

add_action('wp_enqueue_scripts', 'aw_scripts');

add_action('wp_ajax_marketing_upload_files', 'marketing_upload_files');
add_action('wp_ajax_nopriv_marketing_upload_files', 'marketing_upload_files');

/**
 * Cargar ficheros del módulo de Mercadeo
 */
function marketing_upload_files()
{
	echo process_request($_POST, $_FILES);
	die;
}

add_action('wp_ajax_quality_upload_files', 'quality_upload_files');
add_action('wp_ajax_nopriv_quality_upload_files', 'quality_upload_files');

/**
 * Cargar ficheros del módulo de Calidad
 */
function quality_upload_files()
{
	echo process_request($_POST, $_FILES);
	die;
}

add_action('wp_ajax_pqr_upload_files', 'pqr_upload_files');
add_action('wp_ajax_nopriv_pqr_upload_files', 'pqr_upload_files');

/**
 * Cargar ficheros del módulo de PQR
 */
function pqr_upload_files()
{
	echo process_request($_POST, $_FILES);
	die;
}


add_action('wp_ajax_human_talent_upload_files', 'human_talent_upload_files');
add_action('wp_ajax_nopriv_human_talent_upload_files', 'human_talent_upload_files');

/**
 * Cargar ficheros del módulo de Talento Humano
 */
function human_talent_upload_files()
{
	echo process_request($_POST, $_FILES);
	die;
}

add_action('wp_ajax_cost_budget_upload_files', 'cost_budget_upload_files');
add_action('wp_ajax_nopriv_cost_budget_upload_files', 'cost_budget_upload_files');

/**
 * Cargar ficheros del módulo de Talento Humano
 */
function cost_budget_upload_files()
{
	echo process_request($_POST, $_FILES);
	die;
}


/**
 * Related posts
 *
 * @global object $post
 * @param array $args
 * @return
 */
function wcr_related_posts($args = array())
{
	global $post;

	// default args
	$args = wp_parse_args($args, array(
		'post_id' => !empty($post) ? $post->ID : '',
		'taxonomy' => 'category',
		'limit' => 5,
		'post_type' => !empty($post) ? $post->post_type : 'post',
		'orderby' => 'date',
		'order' => 'DESC'
	));

	// check taxonomy
	if (!taxonomy_exists($args['taxonomy'])) {
		return;
	}

	// post taxonomies
	$taxonomies = wp_get_post_terms($args['post_id'], $args['taxonomy'], array('fields' => 'ids'));

	if (empty($taxonomies)) {
		return;
	}

	// query
	$related_posts = get_posts(array(
		'post__not_in' => (array) $args['post_id'],
		'post_type' => $args['post_type'],
		'tax_query' => array(
			array(
				'taxonomy' => $args['taxonomy'],
				'field' => 'term_id',
				'terms' => $taxonomies
			),
		),
		'posts_per_page' => $args['limit'],
		'orderby' => $args['orderby'],
		'order' => $args['order']
	));

	include(locate_template('related-posts-template.php', false, false));

	wp_reset_postdata();
}


/*****functions comments */
function wpbeginner_remove_comment_url($arg)
{
	$arg['url'] = '';
	return $arg;
}
add_filter('comment_form_default_fields', 'wpbeginner_remove_comment_url');

function wpb_comment_reply_text($link)
{
	$link = str_replace('Reply', 'Respuesta', $link);
	return $link;
}
add_filter('comment_reply_link', 'wpb_comment_reply_text');

/*****end functions comments */

/**
 * Enqueues scripts and styles.
 */
function twentyseventeen_scripts()
{
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style('twentyseventeen-fonts', twentyseventeen_fonts_url(), array(), null);

	// Theme stylesheet.
	wp_enqueue_style('twentyseventeen-style', get_stylesheet_uri(), array(), '20221101');

	// Theme block stylesheet.
	wp_enqueue_style('twentyseventeen-block-style', get_theme_file_uri('/assets/css/blocks.css'), array('twentyseventeen-style'), '20220912');

	// Load the dark colorscheme.
	if ('dark' === get_theme_mod('colorscheme', 'light') || is_customize_preview()) {
		wp_enqueue_style('twentyseventeen-colors-dark', get_theme_file_uri('/assets/css/colors-dark.css'), array('twentyseventeen-style'), '20191025');
	}

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if (is_customize_preview()) {
		wp_enqueue_style('twentyseventeen-ie9', get_theme_file_uri('/assets/css/ie9.css'), array('twentyseventeen-style'), '20161202');
		wp_style_add_data('twentyseventeen-ie9', 'conditional', 'IE 9');
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style('twentyseventeen-ie8', get_theme_file_uri('/assets/css/ie8.css'), array('twentyseventeen-style'), '20161202');
	wp_style_add_data('twentyseventeen-ie8', 'conditional', 'lt IE 9');

	// Load the html5 shiv.
	wp_enqueue_script('html5', get_theme_file_uri('/assets/js/html5.js'), array(), '20161020');
	wp_script_add_data('html5', 'conditional', 'lt IE 9');

	wp_enqueue_script('twentyseventeen-skip-link-focus-fix', get_theme_file_uri('/assets/js/skip-link-focus-fix.js'), array(), '20161114', true);

	$twentyseventeen_l10n = array(
		'quote' => twentyseventeen_get_svg(array('icon' => 'quote-right')),
	);

	if (has_nav_menu('top')) {
		wp_enqueue_script('twentyseventeen-navigation', get_theme_file_uri('/assets/js/navigation.js'), array('jquery'), '20210122', true);
		$twentyseventeen_l10n['expand']   = __('Expand child menu', 'twentyseventeen');
		$twentyseventeen_l10n['collapse'] = __('Collapse child menu', 'twentyseventeen');
		$twentyseventeen_l10n['icon']     = twentyseventeen_get_svg(
			array(
				'icon'     => 'angle-down',
				'fallback' => true,
			)
		);
	}

	wp_enqueue_script('twentyseventeen-global', get_theme_file_uri('/assets/js/global.js'), array('jquery'), '20211130', true);

	wp_enqueue_script('jquery-scrollto', get_theme_file_uri('/assets/js/jquery.scrollTo.js'), array('jquery'), '2.1.3', true);

	wp_localize_script('twentyseventeen-skip-link-focus-fix', 'twentyseventeenScreenReaderText', $twentyseventeen_l10n);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'twentyseventeen_scripts');

/**
 * Enqueues styles for the block-based editor.
 *
 * @since Twenty Seventeen 1.8
 */
function twentyseventeen_block_editor_styles()
{
	// Block styles.
	wp_enqueue_style('twentyseventeen-block-editor-style', get_theme_file_uri('/assets/css/editor-blocks.css'), array(), '20220912');
	// Add custom fonts.
	wp_enqueue_style('twentyseventeen-fonts', twentyseventeen_fonts_url(), array(), null);
}
add_action('enqueue_block_editor_assets', 'twentyseventeen_block_editor_styles');

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentyseventeen_content_image_sizes_attr($sizes, $size)
{
	$width = $size[0];

	if (740 <= $width) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if (is_active_sidebar('sidebar-1') || is_archive() || is_search() || is_home() || is_page()) {
		if (!(is_page() && 'one-column' === get_theme_mod('page_options')) && 767 <= $width) {
			$sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter('wp_calculate_image_sizes', 'twentyseventeen_content_image_sizes_attr', 10, 2);

/**
 * Filters the `sizes` value in the header image markup.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function twentyseventeen_header_image_tag($html, $header, $attr)
{
	if (isset($attr['sizes'])) {
		$html = str_replace($attr['sizes'], '100vw', $html);
	}
	return $html;
}
add_filter('get_header_image_tag', 'twentyseventeen_header_image_tag', 10, 3);

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string[]     $attr       Array of attribute values for the image markup, keyed by attribute name.
 *                                 See wp_get_attachment_image().
 * @param WP_Post      $attachment Image attachment post.
 * @param string|int[] $size       Requested image size. Can be any registered image size name, or
 *                                 an array of width and height values in pixels (in that order).
 * @return string[] The filtered attributes for the image markup.
 */
function twentyseventeen_post_thumbnail_sizes_attr($attr, $attachment, $size)
{
	if (is_archive() || is_search() || is_home()) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'twentyseventeen_post_thumbnail_sizes_attr', 10, 3);

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 * @return string The template to be used: blank if is_home() is true (defaults to index.php),
 *                otherwise $template.
 */
function twentyseventeen_front_page_template($template)
{
	return is_home() ? '' : $template;
}
add_filter('frontpage_template', 'twentyseventeen_front_page_template');

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Twenty Seventeen 1.4
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function twentyseventeen_widget_tag_cloud_args($args)
{
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	$args['format']   = 'list';

	return $args;
}
add_filter('widget_tag_cloud_args', 'twentyseventeen_widget_tag_cloud_args');

/**
 * Gets unique ID.
 *
 * This is a PHP implementation of Underscore's uniqueId method. A static variable
 * contains an integer that is incremented with each call. This number is returned
 * with the optional prefix. As such the returned value is not universally unique,
 * but it is unique across the life of the PHP process.
 *
 * @since Twenty Seventeen 2.0
 *
 * @see wp_unique_id() Themes requiring WordPress 5.0.3 and greater should use this instead.
 *
 * @param string $prefix Prefix for the returned ID.
 * @return string Unique ID.
 */
function twentyseventeen_unique_id($prefix = '')
{
	static $id_counter = 0;
	if (function_exists('wp_unique_id')) {
		return wp_unique_id($prefix);
	}
	return $prefix . (string) ++$id_counter;
}

if (!function_exists('wp_get_list_item_separator')) :
	/**
	 * Retrieves the list item separator based on the locale.
	 *
	 * Added for backward compatibility to support pre-6.0.0 WordPress versions.
	 *
	 * @since 6.0.0
	 */
	function wp_get_list_item_separator()
	{
		/* translators: Used between list items, there is a space after the comma. */
		return __(', ', 'twentyseventeen');
	}
endif;

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path('/inc/custom-header.php');

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path('/inc/template-tags.php');

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path('/inc/template-functions.php');

/**
 * Customizer additions.
 */
require get_parent_theme_file_path('/inc/customizer.php');

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path('/inc/icon-functions.php');

/**
 * Block Patterns.
 */
require get_template_directory() . '/inc/block-patterns.php';
function quitar_menus()
{


	$user = wp_get_current_user(); //Obtenemos los datos del usuario actual
	if ($user->has_cap('read')) { // Si es que el usuario no tiene rol de administrador
		remove_menu_page('index.php'); // Removemos el ítem Entradas
		remove_menu_page('profile.php'); // Removemos el ítem comentarios
		remove_menu_page('about.php'); // Removemos el ítem comentarios

	}
}
add_action('admin_menu', 'quitar_menus');
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar()
{
	if ((!current_user_can('administrator') && !is_admin()) && (!current_user_can('super_administrator'))) {
		show_admin_bar(false);
	}
}
add_action('wp_logout', 'cerrar_sesion');
function cerrar_sesion()
{
	wp_redirect(home_url());
	exit();
}

function my_event_arbol_cb()
{
	// Check for nonce security
	$nonce = sanitize_text_field($_POST['nonce']);
	global $wpdb;
	$queryArchivos = "";
	$orderBy = "";
	$carpeta = "";
	switch ($_POST["id"]) {
		case "1":
			$queryArchivos = "SELECT am_id AS id,am_description AS description,
									t.mime_icon,t.mime_icon_color,t.mime_extension,am_url AS ulr FROM wpl_advertising_markenting q
									INNER JOIN  wpl_mime_type t ON q.mime_row_id=t.mime_row_id";
			$orderBy = " AND am_status=1  ORDER BY am_description";
			$carpeta = "MERCADEO";
			break;
		case "2":
			$queryArchivos = "SELECT qu_id AS id,qu_description AS description,
								t.mime_icon,t.mime_icon_color,t.mime_extension,qu_url as url FROM wpl_quality q
								INNER JOIN  wpl_mime_type t ON q.mime_row_id=t.mime_row_id";
			$orderBy = " AND qu_status=1  ORDER BY qu_description";
			$carpeta = "CALIDAD";
			break;
		case "3":
			$queryArchivos = "SELECT pqr_id AS id,pqr_description AS description,
								t.mime_icon,t.mime_icon_color,t.mime_extension,pqr_url as url FROM wpl_pqr q
								INNER JOIN  wpl_mime_type t ON q.mime_row_id=t.mime_row_id";
			$orderBy = " AND pqr_status=1  ORDER BY pqr_description";
			$carpeta = "PQR";
			break;
	}
	$niveles1 = $wpdb->get_results("
		SELECT * FROM (SELECT DISTINCT  subfolder_n1_row_id,subfolder_n1_name
		FROM  vw_wpl_folders WHERE folder_row_id=" . $_POST["id"] . ") AS nivel1
		ORDER BY subfolder_n1_row_id
	");
	foreach ((array) $niveles1 as $nivel1) {
		if ($nivel1->subfolder_n1_row_id > 0) {
			$parentid = "#";
			$icon = "fa fa-folder fa-1x";
			$selected = false;
			$opened = false;
			$arregloRetorno[] = array(
				"id" => $nivel1->subfolder_n1_row_id,
				"parent" => $parentid,
				"text" => $nivel1->subfolder_n1_name,
				"state" => array("selected" => $selected, "opened" => $opened),
				"icon" => $icon,
				"a_attr"  => ["class" => "not-icon"]
			);
			//se consultan los archivos
			$archivosNivel1 = $wpdb->get_results($queryArchivos . "
													WHERE folder_row_id=" . $_POST["id"] . " 
													AND subfolder_n1_row_id=" . $nivel1->subfolder_n1_row_id . " 
													AND subfolder_n2_row_id IS NULL
													AND subfolder_n3_row_id IS NULL
													AND subfolder_n4_row_id IS NULL
													AND subfolder_n5_row_id IS NULL
													 " . $orderBy);
			foreach ((array) $archivosNivel1 as $archivoNivel1) {
				$parentid = $nivel1->subfolder_n1_row_id;
				$icon = $archivoNivel1->mime_icon;
				$selected = false;
				$opened = false;
				$arregloRetorno[] = array(
					"id" => $archivoNivel1->id . $carpeta,
					"parent" => $parentid,
					"text" => '<a class="me-2" target="_blank" href="' . $archivoNivel1->url . '" title="Descargar" download="">' . $archivoNivel1->description . '</a>',
					"state" => array("selected" => $selected, "opened" => $opened),
					"icon" => $icon,
					"a_attr"  => ["onclick" => "downloadFile('" . $archivoNivel1->url . "',true,'" . $archivoNivel1->mime_extension . "')", "class" => 'icon-' . str_replace('.', '', $archivoNivel1->mime_extension)]
				);
			}
		}
		$niveles2 = $wpdb->get_results("SELECT DISTINCT subfolder_n2_row_id ,subfolder_n2_name
	  FROM  vw_wpl_folders WHERE folder_row_id=" . $_POST["id"] . " AND subfolder_n1_row_id=" . $nivel1->subfolder_n1_row_id . " 
	  ORDER BY subfolder_n2_row_id");
		foreach ((array) $niveles2 as $nivel2) {
			if ($nivel2->subfolder_n2_row_id > 0) {
				$parentid = $nivel1->subfolder_n1_row_id;
				$icon = "fa fa-folder fa-1x icon-folder";
				$selected = false;
				$opened = false;
				$id = $nivel1->subfolder_n1_row_id . "@" . $nivel2->subfolder_n2_row_id;
				$arregloRetorno[] = array(
					"id" => $id,
					"parent" => $parentid,
					"text" => $nivel2->subfolder_n2_name,
					"state" => array("selected" => $selected, "opened" => $opened),
					"icon" => $icon,
					"a_attr"  => ["class" => "not-icon"],
				);
				//se consultan los archivos
				$archivosNivel2 = $wpdb->get_results($queryArchivos . "
						WHERE folder_row_id=" . $_POST["id"] . " 
						AND subfolder_n1_row_id=" . $nivel1->subfolder_n1_row_id . " 
						AND subfolder_n2_row_id=" . $nivel2->subfolder_n2_row_id . "
						AND subfolder_n3_row_id IS NULL
						AND subfolder_n4_row_id IS NULL
						AND subfolder_n5_row_id IS NULL " . $orderBy);
				foreach ((array) $archivosNivel2 as $archivoNivel2) {
					$parentid = $id;
					$icon = $archivoNivel2->mime_icon;
					$selected = false;
					$opened = false;
					$arregloRetorno[] = array(
						"id" => $archivoNivel2->id . $carpeta,
						"parent" => $parentid,
						"text" => '<a class="me-2" target="_blank" href="' . $archivoNivel2->url . '" title="Descargar" download="">' . $archivoNivel2->description . '</a>',
						"state" => array("selected" => $selected, "opened" => $opened),
						"a_attr"  => ["onclick" => "downloadFile('" . $archivoNivel2->url . "',true,'" . $archivoNivel2->mime_extension . "')", "class" => 'icon-' . str_replace('.', '', $archivoNivel2->mime_extension)],
						"icon" => $icon
					);
				}
			}
			$niveles3 = $wpdb->get_results("SELECT DISTINCT subfolder_n3_row_id ,subfolder_n3_name
			FROM  vw_wpl_folders WHERE folder_row_id=" . $_POST["id"] . " AND subfolder_n1_row_id=" . $nivel1->subfolder_n1_row_id . " 
			AND subfolder_n2_row_id=" . $nivel2->subfolder_n2_row_id . "
			ORDER BY subfolder_n3_row_id");
			//if(count((array)$niveles2)>0){
			foreach ((array) $niveles3 as $nivel3) {
				if ($nivel3->subfolder_n3_row_id > 0) {
					$parentid = $nivel1->subfolder_n1_row_id . "@" . $nivel2->subfolder_n2_row_id;
					$icon = "fa fa-folder fa-1x";
					$selected = false;
					$opened = false;
					$id = $nivel1->subfolder_n1_row_id . "@" . $nivel2->subfolder_n2_row_id . "@" . $nivel3->subfolder_n3_row_id;
					$arregloRetorno[] = array(
						"id" => $id,
						"parent" => $parentid,
						"text" => $nivel3->subfolder_n3_name,
						"state" => array("selected" => $selected, "opened" => $opened),
						"icon" => $icon,
						"a_attr"  => ["class" => "not-icon"]
					);
					//se consultan los archivos
					$archivosNivel3 = $wpdb->get_results($queryArchivos . "
										WHERE folder_row_id=" . $_POST["id"] . " 
										AND subfolder_n1_row_id=" . $nivel1->subfolder_n1_row_id . " 
										AND subfolder_n2_row_id=" . $nivel2->subfolder_n2_row_id . "
										AND subfolder_n3_row_id=" . $nivel3->subfolder_n3_row_id . "
										AND subfolder_n4_row_id IS NULL
										AND subfolder_n5_row_id IS NULL " . $orderBy);
					foreach ((array) $archivosNivel3 as $archivoNivel3) {
						$parentid = $id;
						$icon = $archivoNivel3->mime_icon;
						//$icon="fa fa-folder fa-1x";
						$selected = false;
						$opened = false;
						$arregloRetorno[] = array(
							"id" => $archivoNivel3->id . $carpeta,
							"parent" => $parentid,
							"text" => '<a class="me-2" target="_blank" href="' . $archivoNivel3->url . '" title="Descargar" download="">' . $archivoNivel3->description . '</a>',
							"state" => array("selected" => $selected, "opened" => $opened),
							"a_attr"  => ["onclick" => "downloadFile('" . $archivoNivel3->url . "',true,'" . $archivoNivel3->mime_extension . "')", "class" => 'icon-' . str_replace('.', '', $archivoNivel3->mime_extension)],
							"icon" => $icon
						);
					}
				}
				$niveles4 = $wpdb->get_results("SELECT DISTINCT subfolder_n4_row_id ,subfolder_n4_name
			FROM  vw_wpl_folders WHERE folder_row_id=" . $_POST["id"] . " AND subfolder_n1_row_id=" . $nivel1->subfolder_n1_row_id . " 
			AND subfolder_n2_row_id=" . $nivel2->subfolder_n2_row_id . " AND subfolder_n3_row_id=" . $nivel3->subfolder_n3_row_id . "
			ORDER BY subfolder_n4_row_id");
				//if(count((array)$niveles2)>0){
				foreach ((array) $niveles4 as $nivel4) {
					if ($nivel4->subfolder_n4_row_id > 0) {
						$parentid = $nivel1->subfolder_n1_row_id . "@" . $nivel2->subfolder_n2_row_id . "@" . $nivel3->subfolder_n3_row_id;
						$icon = "fa fa-folder fa-1x";
						$selected = false;
						$opened = false;
						$id = $nivel1->subfolder_n1_row_id . "@" . $nivel2->subfolder_n2_row_id . "@" . $nivel3->subfolder_n3_row_id . "@" . $nivel4->subfolder_n4_row_id;
						$arregloRetorno[] = array(
							"id" => $id,
							"parent" => $parentid,
							"text" => $nivel4->subfolder_n4_name,
							"state" => array("selected" => $selected, "opened" => $opened),
							"icon" => $icon,
							"a_attr"  => ["class" => "not-icon"]
						);
						//se consultan los archivos
						$archivosNivel4 = $wpdb->get_results($queryArchivos . "
										WHERE folder_row_id=" . $_POST["id"] . " 
										AND subfolder_n1_row_id=" . $nivel1->subfolder_n1_row_id . " 
										AND subfolder_n2_row_id=" . $nivel2->subfolder_n2_row_id . "
										AND subfolder_n3_row_id=" . $nivel3->subfolder_n3_row_id . "
										AND subfolder_n4_row_id=" . $nivel3->subfolder_n4_row_id . "
										AND subfolder_n5_row_id IS NULL " . $orderBy);
						foreach ((array) $archivosNivel4 as $archivoNivel4) {
							$parentid = $id;
							$icon = $archivoNivel4->mime_icon;
							//$icon="fa fa-folder fa-1x";
							$selected = false;
							$opened = false;
							$arregloRetorno[] = array(
								"id" => $archivoNivel4->id . $carpeta,
								"parent" => $parentid,
								"text" => '<a class="me-2" target="_blank" href="' . $archivoNivel4->url . '" title="Descargar" download="">' . $archivoNivel4->description . '</a>',
								"state" => array("selected" => $selected, "opened" => $opened),
								"a_attr"  => ["onclick" => "downloadFile('" . $archivoNivel4->url . "',true,'" . $archivoNivel4->mime_extension . "')", "class" => 'icon-' . str_replace('.', '', $archivoNivel4->mime_extension)],
								"icon" => $icon
							);
						}
					}
					$niveles5 = $wpdb->get_results("SELECT DISTINCT subfolder_n5_row_id ,subfolder_n5_name
			FROM  vw_wpl_folders WHERE folder_row_id=" . $_POST["id"] . " AND subfolder_n1_row_id=" . $nivel1->subfolder_n1_row_id . " 
			AND subfolder_n2_row_id=" . $nivel2->subfolder_n2_row_id . " AND subfolder_n3_row_id=" . $nivel3->subfolder_n3_row_id . "
			AND subfolder_n4_row_id=" . $nivel3->subfolder_n4_row_id . "
			ORDER BY subfolder_n5_row_id");
					//if(count((array)$niveles2)>0){
					foreach ((array) $niveles5 as $nivel5) {
						if ($nivel5->subfolder_n5_row_id > 0) {
							$parentid = $nivel1->subfolder_n1_row_id . "@" . $nivel2->subfolder_n2_row_id . "@" . $nivel3->subfolder_n3_row_id . "@" . $nivel4->subfolder_n4_row_id;
							$icon = "fa fa-folder fa-1x";
							$selected = false;
							$opened = false;
							$id = $nivel1->subfolder_n1_row_id . "@" . $nivel2->subfolder_n2_row_id . "@" . $nivel3->subfolder_n3_row_id . "@" . $nivel4->subfolder_n4_row_id . "@" . $nivel5->subfolder_n5_row_id;
							$arregloRetorno[] = array(
								"id" => $id,
								"parent" => $parentid,
								"text" => $nivel3->subfolder_n3_name,
								"state" => array("selected" => $selected, "opened" => $opened),
								"icon" => $icon,
								"a_attr"  => ["class" => "not-icon"]
							);
							//se consultan los archivos
							$archivosNivel5 = $wpdb->get_results($queryArchivos . "
										WHERE folder_row_id=" . $_POST["id"] . " 
										AND subfolder_n1_row_id=" . $nivel1->subfolder_n1_row_id . " 
										AND subfolder_n2_row_id=" . $nivel2->subfolder_n2_row_id . "
										AND subfolder_n3_row_id=" . $nivel3->subfolder_n3_row_id . "
										AND subfolder_n4_row_id=" . $nivel3->subfolder_n4_row_id . "
										AND subfolder_n5_row_id=" . $nivel3->subfolder_n5_row_id . "
										" . $orderBy);
							foreach ((array) $archivosNivel5 as $archivoNivel5) {
								$parentid = $id;
								$icon = $archivoNivel4->mime_icon;
								//$icon="fa fa-folder fa-1x";
								$selected = false;
								$opened = false;
								$arregloRetorno[] = array(
									"id" => $archivoNivel5->id . $carpeta,
									"parent" => $parentid,
									"text" => '<a class="me-2" target="_blank" href="' . $archivoNivel5->url . '" title="Descargar" download="">' . $archivoNivel5->description . '</a>',
									"state" => array("selected" => $selected, "opened" => $opened),
									"a_attr"  => ["onclick" => "downloadFile('" . $archivoNivel5->url . "',true,'" . $archivoNivel5->mime_extension . "')", "class" => 'icon-' . str_replace('.', '', $archivoNivel5->mime_extension)],
									"icon" => $icon
								);
							}
						}
					}
				}
			}
		}
	}
	echo json_encode($arregloRetorno);
	wp_die();
}
add_action('wp_ajax_nopriv_event-arbol', 'my_event_arbol_cb');
add_action('wp_ajax_event-arbol', 'my_event_arbol_cb');
function my_load_scripts()
{
	wp_enqueue_script('my_js', get_theme_file_uri('js/eventos.js'), array('jquery'));

	wp_localize_script('my_js', 'ajax_var', array(
		'url'    => admin_url('admin-ajax.php'),
		'nonce'  => wp_create_nonce('my-ajax-nonce'),
		'action' => 'event-arbol',
	));
}

add_action('wp_enqueue_scripts', 'my_load_scripts');
require_once get_stylesheet_directory() . '/inc/better-comments.php';
