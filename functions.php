<?php
/**
 * WP Bootstrap Starter functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WP_Bootstrap_Starter
 */

define('CRB_THEME_DIR', get_template_directory() . DIRECTORY_SEPARATOR);

function theme_header_metadata()
{
    $path = get_stylesheet_directory_uri();
    echo
        '<link rel="shortcut icon" type="image/x-icon" href="'.$path.'/client/dist/icons/favicon.ico" />'
        .'<link rel="apple-touch-icon" href="'.$path.'/client/dist/icons/apple-touch-icon.png" />'
        .'<link rel="apple-touch-icon-precomposed" href="'.$path.'/client/dist/icons/apple-touch-icon-precomposed.png" />'
        .'<meta name="msapplication-TileImage" content="'.$path.'/client/dist/icons/mstile-144x144.png" />';
}

add_action('wp_head', 'theme_header_metadata');

if (! function_exists('wp_bootstrap_starter_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function wp_bootstrap_starter_setup()
    {
        // Autoload dependencies
        $autoload_dir = CRB_THEME_DIR . 'vendor/autoload.php';
        if (! is_readable($autoload_dir)) {
            wp_die(__('Please, run <code>composer install</code> to download and install the theme dependencies.', 'crb'));
        }

        require_once(CRB_THEME_DIR . 'vendor/autoload.php');
        \Carbon_Fields\Carbon_Fields::boot();


        // Additional libraries and includes
        require_once(CRB_THEME_DIR . 'inc/admin-login.php');
        require_once(CRB_THEME_DIR . 'inc/blocks.php');
        require_once(CRB_THEME_DIR . 'inc/boot-blocks.php');
        require_once(CRB_THEME_DIR . 'inc/comments.php');
        require_once(CRB_THEME_DIR . 'inc/title.php');
        require_once(CRB_THEME_DIR . 'inc/gravity-forms.php');
        require_once(CRB_THEME_DIR . 'inc/utils.php');
        require_once(CRB_THEME_DIR . 'inc/CrbSocials.php');

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on WP Bootstrap Starter, use a find and replace
         * to change 'wp-bootstrap-starter' to the name of your theme in all the template files.
         */
        load_theme_textdomain('wp-bootstrap-starter', CRB_THEME_DIR . 'languages');


        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => esc_html__('Primary', 'wp-bootstrap-starter'),
        ));

        // theme supports
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('html5', array(
            'comment-form',
            'comment-list',
            'caption',
        ));
        remove_theme_support('core-block-patterns');
        add_theme_support('customize-selective-refresh-widgets');
        add_theme_support('yoast-seo-breadcrumbs');

        // Attach custom shortcodes
        require_once(CRB_THEME_DIR . 'opts/shortcodes.php');

        // Add Actions
        add_action('carbon_fields_register_fields', 'crb_attach_theme_options');

        function wp_boostrap_starter_add_editor_styles()
        {
            add_editor_style('client/dist/css/app_editor.css');
        }
        add_action('admin_init', 'wp_boostrap_starter_add_editor_styles');

        // Add Filters
        add_filter('excerpt_more', 'crb_excerpt_more');
        add_filter('excerpt_length', 'crb_excerpt_length', 999);
        add_filter('crb_theme_favicon_uri', function () {
            return get_template_directory_uri() . '/client/dist/icons/favicon.ico';
        });
        add_filter('carbon_fields_map_field_api_key', 'crb_get_google_maps_api_key');
    }
endif;
add_action('after_setup_theme', 'wp_bootstrap_starter_setup');


function crb_attach_theme_options()
{
    # Attach fields
    require_once(CRB_THEME_DIR . 'opts/theme-options.php');
    require_once(CRB_THEME_DIR . 'opts/post-meta.php');
    require_once(CRB_THEME_DIR . 'opts/blocks.php');
}

function crb_excerpt_more()
{
    return '...';
}

function crb_excerpt_length()
{
    return 55;
}

function crb_get_google_maps_api_key()
{
    return carbon_get_theme_option('crb_google_maps_api_key');
}

add_filter('carbon_fields_map_field_api_key', 'crb_get_google_maps_api_key');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wp_bootstrap_starter_content_width()
{
    $GLOBALS['content_width'] = apply_filters('wp_bootstrap_starter_content_width', 1155);
}
add_action('after_setup_theme', 'wp_bootstrap_starter_content_width', 0);

function ResourcesURL()
{
    return get_template_directory_uri().'/client/dist';
}

function nl2li($str, $ordered = 0, $type = "1")
{
    if ($ordered) {
        $tag = 'ol';
        $tag_type = "type=$type";
    } else {
        $tag = 'ul';
        $tag_type = null;
    }

    return str_replace("\n", "</li><br />\n<li>", "<$tag $tag_type><li>" . $str ."</li></$tag>");
}
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wp_bootstrap_starter_widgets_init()
{
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'wp-bootstrap-starter'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'wp-bootstrap-starter'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    register_sidebar(array(
        'name'          => esc_html__('Footer 1', 'wp-bootstrap-starter'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here.', 'wp-bootstrap-starter'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    register_sidebar(array(
        'name'          => esc_html__('Footer 2', 'wp-bootstrap-starter'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Add widgets here.', 'wp-bootstrap-starter'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    register_sidebar(array(
        'name'          => esc_html__('Footer 3', 'wp-bootstrap-starter'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Add widgets here.', 'wp-bootstrap-starter'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'wp_bootstrap_starter_widgets_init');
add_action('wp_enqueue_scripts', 'nwd_modern_jquery');

function nwd_modern_jquery()
{
    global $wp_scripts;
    if (is_admin()) {
        return;
    }
    $wp_scripts->registered['jquery-core']->src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js';
    $wp_scripts->registered['jquery']->deps = ['jquery-core'];
}


/**
 * Enqueue scripts and styles.
 */
function wp_bootstrap_starter_scripts()
{
    // load bootstrap css
    wp_enqueue_style('wp-bootstrap-starter-fontawesome-cdn', 'https://use.fontawesome.com/releases/v5.15.1/css/all.css');
    wp_enqueue_script('jquery');

    wp_enqueue_style(
        'wp-bootstrap-starter-'.get_theme_mod('preset_color_scheme_setting'),
        get_template_directory_uri() . '/client/dist/css/app.css',
        false,
        filemtime(CRB_THEME_DIR.'client/dist/css/app.css')
    );
    wp_enqueue_script(
        'wp-bootstrap-starter-themejs',
        get_template_directory_uri() . '/client/dist/js/app.js',
        array(),
        filemtime(CRB_THEME_DIR.'client/dist/js/app.js'),
        true
    );

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'wp_bootstrap_starter_scripts');


/**
 * Add Preload for CDN scripts and stylesheet
 */
function wp_bootstrap_starter_preload($hints, $relation_type)
{
    if ('preconnect' === $relation_type && get_theme_mod('cdn_assets_setting') === 'yes') {
        $hints[] = [
            'href'        => 'https://ajax.googleapis.com/',
            'crossorigin' => 'anonymous',
        ];
        $hints[] = [
            'href'        => 'https://use.fontawesome.com/',
            'crossorigin' => 'anonymous',
        ];
    }
    return $hints;
}

add_filter('wp_resource_hints', 'wp_bootstrap_starter_preload', 10, 2);



function wp_bootstrap_starter_password_form()
{
    global $post;
    $label = 'pwbox-'.(empty($post->ID) ? rand() : $post->ID);
    $o = '<form action="' . esc_url(home_url('wp-login.php?action=postpass', 'login_post')) . '" method="post">
    <div class="d-block mb-3">' . __("To view this protected post, enter the password below:", "wp-bootstrap-starter") . '</div>
    <div class="form-group form-inline"><label for="' . $label . '" class="mr-2">' . __("Password:", "wp-bootstrap-starter") . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" class="form-control mr-2" /> <input type="submit" name="Submit" value="' . esc_attr__("Submit", "wp-bootstrap-starter") . '" class="btn btn-primary"/></div>
    </form>';
    return $o;
}
add_filter('the_password_form', 'wp_bootstrap_starter_password_form');



/**
 * Implement the Custom Header feature.
 */
require CRB_THEME_DIR . 'inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require CRB_THEME_DIR . 'inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require CRB_THEME_DIR . 'inc/extras.php';

/**
 * Customizer additions.
 */
require CRB_THEME_DIR . 'inc/customizer.php';

/**
 * Load plugin compatibility file.
 */
require CRB_THEME_DIR . 'inc/plugin-compatibility/plugin-compatibility.php';

/**
 * Load custom WordPress nav walker.
 */
if (! class_exists('wp_bootstrap_navwalker')) {
    require_once(CRB_THEME_DIR . 'inc/wp_bootstrap_navwalker.php');
}

remove_filter('the_content', 'wpautop');
add_filter('the_content', 'crb_fix_empty_paragraphs_in_blocks');
function crb_fix_empty_paragraphs_in_blocks($content)
{
    global $wp_version;

    if (version_compare($wp_version, '5.2', '<') && has_blocks()) {
        return $content;
    }

    return wpautop($content);
}
