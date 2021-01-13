<?php
/**
 * WP Bootstrap Starter Theme Customizer
 *
 * @package WP_Bootstrap_Starter
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function themeslug_sanitize_checkbox($checked)
{
    // Boolean check.
    return ( ( isset($checked) && true == $checked ) ? true : false );
}

function addField($wp_customize, $name, $title, $options = [])
{
    $name = explode('.', $name);

    $wp_customize->add_setting($name[1]);
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, $name[1], array_merge([
        'label'    => $title,
        'settings' => $name[1],
        'section'    => $name[0],
        'type'     => 'text',
    ], $options)));
}

function wp_bootstrap_starter_customize_register($wp_customize)
{
    /*Banner*/
    $wp_customize->add_section('header_image', [
        'title' => __('Header Banner', 'wp-bootstrap-starter'),
        'priority' => 30,
    ]);


    $wp_customize->add_control('header_img', [
        'label' => __('Header Image', 'wp-bootstrap-starter'),
        'section' => 'header_images',
        'type' => 'text',
    ]);

    addField($wp_customize, 'header_image.header_banner_title_setting', 'Banner Title');
    addField($wp_customize, 'header_image.header_banner_tagline_setting', 'Banner Tagline');
    addField($wp_customize, 'header_image.header_banner_link_setting', 'Banner Link', ['type' => 'url']);
    addField($wp_customize, 'header_image.header_banner_visibility', 'Remove Header Banner', ['type' => 'checkbox']);

    // Home Blocks
    $wp_customize->add_section('home_blocks', [
        'title' => 'Home Blocks',
        'priority' => 30,
    ]);

    // Block #1
    addField($wp_customize, 'home_blocks.home_blocks_block1_title', 'Block #1 Title');
    addField($wp_customize, 'home_blocks.home_blocks_block1_text', 'Block #1 Text', ['type' => 'textarea']);
    addField($wp_customize, 'home_blocks.home_blocks_block1_link', 'Block #1 Link', ['type' => 'url']);

    addField($wp_customize, 'home_blocks.home_blocks_block2_title', 'Block #2 Title');
    addField($wp_customize, 'home_blocks.home_blocks_block2_text', 'Block #2 Text', ['type' => 'textarea']);
    addField($wp_customize, 'home_blocks.home_blocks_block2_link', 'Block #2 Link', ['type' => 'url']);

    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'refresh';
    $wp_customize->get_control('header_textcolor')->section = 'site_name_text_color';
    $wp_customize->get_control('background_image')->section = 'site_name_text_color';
    $wp_customize->get_control('background_color')->section = 'site_name_text_color';

    addField($wp_customize, 'title_tagline.header_banner_callus_setting', 'Call us');
}

add_action('customize_register', 'wp_bootstrap_starter_customize_register');

add_action('wp_head', 'wp_bootstrap_starter_customizer_css');
function wp_bootstrap_starter_customizer_css()
{
}


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */

function wp_bootstrap_starter_customize_preview_js()
{
    wp_enqueue_script(
        'wp_bootstrap_starter_customizer',
        get_template_directory_uri() . '/inc/assets/js/customizer.js',
        ['customize-preview'],
        '20201126',
        true
    );
}
add_action('customize_preview_init', 'wp_bootstrap_starter_customize_preview_js');

/**
 * Add custom blocks
 */
function wp_bootstrap_customize_blocks()
{
    wp_enqueue_script(
        'gutenberg-notice-block-editor',
        get_template_directory_uri() . '/inc/assets/js/custom-blocks.js',
        ['wp-blocks', 'wp-element']
    );

    wp_enqueue_style(
        'gutenberg-notice-block-editor',
        get_template_directory_uri() . '/inc/assets/css/custom-blocks.css'
    );

    wp_enqueue_script(
        'app-cms',
        get_template_directory_uri() . '/client/dist/js/app_cms.js',
	    false,
        filemtime(get_template_directory().'/client/dist/js/app_cms.js')
    );

    wp_enqueue_style(
        'app-cms',
        get_template_directory_uri() . '/client/dist/css/app_cms.css',
	    false,
        filemtime(get_template_directory().'/client/dist/css/app_cms.css')
    );
}

add_action('enqueue_block_editor_assets', 'wp_bootstrap_customize_blocks');

function list_dir($path)
{
    return array_diff(scandir($path), ['.','..']);
}

function wp_bootstrap_register_custom_block_types()
{
    // from meta data
    unregister_block_type('core/button');
    unregister_block_type('core/buttons');

    $block_folders = list_dir(get_template_directory(). '/inc/blocks');
    foreach ($block_folders as $block_folder) {
        register_block_type_from_metadata(
            get_template_directory(). '/inc/blocks/' . $block_folder.'/block.json'
        );
    }

    $core_block_patterns = list_dir(get_template_directory(). '/inc/block-patterns');

    foreach ($core_block_patterns as $core_block_pattern) {
        register_block_pattern(
            'themed/' . $core_block_pattern,
            require get_template_directory(). '/inc/block-patterns/' . $core_block_pattern
        );
    }

    register_block_pattern_category('themed', ['label' => 'Design Patterns']);
}
add_action('init', 'wp_bootstrap_register_custom_block_types');

if (in_array('advanced-bootstrap-blocks/advanced-bootstrap-blocks.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    // do stuff only if the Advanced Bootstrap Blocks plugin is active
    function advancedbootstrapblocks_register_page_template()
    {
        $post_type_object = get_post_type_object('page');
        $isFluid = get_theme_mod('understrap_container_type') === 'container-fluid';

        // default page template
        $post_type_object->template = [
            ['core/heading',
                [ 'className' => 'display-4', 'level' => 1, 'placeholder' => 'Hello, World!', ],
                []
            ],
            [ 'core/paragraph',
                ['className' => 'lead', 'placeholder' => 'Lorem ipsum dolor sit amet.', ],
                []
            ],
        ];
    }

    add_action('init', 'advancedbootstrapblocks_register_page_template');
}

/*function bt_custom_button_classes( $classes, $attributes ) {
    return [ 'btn btn-primary', 'btn btn-warning', 'btn btn-danger', 'btn btn-secondary' ];
}
add_filter( 'wp_bootstrap_blocks_button_classes', 'bt_custom_button_classes', 10, 2 );*/
