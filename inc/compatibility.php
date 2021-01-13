<?php

// image
function crb_get_image_thumbnail($attachment_id, $width, $height, $crop = true)
{
    $width = absint($width);
    $height = absint($height);

    $upload_dir = wp_upload_dir();
    $attachment = wp_get_attachment_metadata($attachment_id);
    $attachment_path = get_attached_file($attachment_id);
    $attachment_realpath = crb_normalize_path($attachment_path);
    if (! $attachment || ! $attachment_path || ! file_exists($attachment_realpath)) {
        return wp_get_attachment_url($attachment_id);
    }

    // Replace everithing after the last "/"
    $attachment_subdirectory = 'cache/' . preg_replace('/\/?[^\/]+\z/', '', $attachment['file']);

    $filename = basename($attachment_realpath);

    $crop_name = '-cropped';

    // Match the ".extension" and prepend the width, height, and cropping status
    $filename = preg_replace('/(\.[^\.]+)$/', '-' . $width . 'x' . $height . $crop_name . '$1', $filename);

    $filepath = $upload_dir['basedir'] . '/' . $attachment_subdirectory . '/' . $filename;
    $filepath = crb_normalize_path($filepath);

    $fileurl = trailingslashit($upload_dir['baseurl']) . $attachment_subdirectory . '/' . $filename;

    if (file_exists($filepath)) {
        return $fileurl;
    }

    $editor = wp_get_image_editor($attachment_realpath);
    if (is_wp_error($editor)) {
        return '';
    }
    $editor->resize($width, $height, $crop);
    $editor->save($filepath);

    return $fileurl;
}

// helpers

/**
 * Normalizes a path's slashes according to the current OS
 * This solves mixed slashes that are sometimes returned by core functions
 *
 * @param  string $path
 * @return string
 */
function crb_normalize_path($path)
{
    return preg_replace('~[/' . preg_quote('\\', '~') . ']~', DIRECTORY_SEPARATOR, $path);
}

/**
 * Truncates a string to a certain word count.
 * @param  string  $input Text to be shortalized. Any HTML will be stripped.
 * @param  integer $words_limit number of words to return
 * @param  string $end the suffix of the shortalized text
 * @return string
 */
function crb_shortalize($input, $words_limit = 15, $end = '...')
{
    return wp_trim_words($input, $words_limit, $end);
}

/**
 * Crawls the taxonomy tree up to top level taxonomy ancestor and returns
 * that taxonomy as object.
 * @param  int $term_id
 * @param  string $taxonomy Taxonomy slug
 * @return mixed object with the ancestor or false if the term or taxonomy don't exist
 */
function crb_taxonomy_ancestor($term_id, $taxonomy)
{
    $term_obj = get_term_by('id', $term_id, $taxonomy);
    if (!$term_obj) {
        return false;
    }
    while ($term_obj->parent!=0) {
        $term_obj = get_term_by('id', $term_obj->parent, $taxonomy);
    }
    return get_term_by('id', $term_obj->term_id, $taxonomy);
}

/**
 * Shortcut for get_post_meta.
 * @param  string $key
 * @param  integer $id required if the function is not called in loop context
 * @return string custom field if it exist
 */
function crb_get_meta($key, $id = null)
{
    if (!isset($id)) {
        global $post;
        if (empty($post->ID)) {
            return null;
        }
        $id = $post->ID;
    }
    return get_post_meta($id, $key, true);
}

/**
 * Gets all pages / posts which have the specified custom field. Does not check
 * whether it has any value - just for existence.
 * @param  string $meta_key
 * @return array
 */
function crb_get_content_by_meta_key($meta_key)
{
    global $wpdb;
    $result = $wpdb->get_col('
		SELECT DISTINCT(post_id)
		FROM ' . $wpdb->postmeta . '
		WHERE meta_key = "' . $meta_key . '"
	');
    if (empty($result)) {
        return array();
    }
    return $result;
}

/**
 * For Blog Section ( "Posts page", "Archive", "Search" or "Single post" )
 * returns the ID of the "Page for Posts" or 0 if it's not setup
 *
 * For single page or the front page, returns the ID of the page.
 *
 * In all other cases(404, single pages on CPT), returns false.
 *
 * @return int|bool The ID of the current page context, 0 or false.
 */
function crb_get_page_context()
{
    $page_ID = false;

    if (is_page()) {
        $page_ID = get_the_ID();
    } elseif (is_home() || is_archive() || is_search() || ( is_single() && get_post_type() == 'post' )) {
        $page_ID = get_option('page_for_posts');
    }

    return apply_filters('crb_get_page_context', $page_ID);
}

/**
 * Removes leading protocol from a URL address
 *
 * @param string $url URL (http://example.com)
 * @return string The URL without protocol(//example.com)
 */
function crb_strip_url_protocol($url)
{
    return preg_replace('~^https?:~i', '', $url);
}

/**
 * Checks whether a URL address is from the current site
 *
 * @param string $src [required] The URL address that will be checked.
 * @param string $home_url [required] The URL address to the homepage of the site.
 * @return bool
 */
function crb_is_external_url($src, $home_url)
{
    $separator = '~';
    $regex_quoted_home_url = preg_quote($home_url, $separator);
    $internal_url_reg = $separator . '^' . $regex_quoted_home_url . $separator . 'i';

    return !preg_match($internal_url_reg, $src);
}

/**
 * Generates a version for the given file.
 *
 * Checks if the given file actually exists and returns its
 * last modified time. Otherwise, returns false.
 *
 * @see crb_strip_url_protocol()
 * @see crb_is_external_url()
 *
 * @param string [required] $src The URL to the file, which version should be returned.
 * @return int|bool The last modified time of the given file or false.
 */
function crb_generate_file_version($src)
{
    # Normalize both URLs in order to avoid problems with http, https
    # and protocol-less cases
    $src = crb_strip_url_protocol($src);
    $home_url = crb_strip_url_protocol(site_url('/'));

    # Default version
    $version = false;

    if (!crb_is_external_url($src, $home_url)) {
        # Generate the absolute path to the file
        $file_path = str_replace(
            array($home_url, '/'),
            array(ABSPATH, DIRECTORY_SEPARATOR),
            $src
        );

        # Check if the given file really exists
        if (file_exists($file_path)) {
            # Use the last modified time of the file as a version
            $version = filemtime($file_path);
        }
    }

    # Return version
    return $version;
}

/**
 * Enqueues a single JS file
 *
 * @see crb_generate_file_version()
 *
 * @param string $handle [required] Name used as a handle for the JS file
 * @param string $src    [required] The URL to the JS file, which should be enqueued
 * @param array  $dependencies [optional] An array of files' handle names that this file depends on
 * @param bool $in_footer [optional] Whether to enqueue in footer or not. Defaults to false
 */
function crb_enqueue_script($handle, $src, $dependencies = array(), $in_footer = false)
{
    wp_enqueue_script($handle, $src, $dependencies, crb_generate_file_version($src), $in_footer);
}

/**
 * Enqueues a single CSS file
 *
 * @see crb_generate_file_version()
 *
 * @param string $handle [required] Name used as a handle for the CSS file
 * @param string $src    [required] The URL to the CSS file, which should be enqueued
 * @param array  $dependencies [optional] An array of files' handle names that this file depends on
 * @param string $media  [optional] String specifying the media for which this stylesheet has been defined. Defaults to all.
 */
function crb_enqueue_style($handle, $src, $dependencies = array(), $media = 'all')
{
    wp_enqueue_style($handle, $src, $dependencies, crb_generate_file_version($src), $media);
}

/**
 * Removes empty paragraphes from content when using shortcodes
 *
 * @param string $content
 */
add_filter('the_content', 'crb_shortcode_empty_paragraph_fix');
add_filter('crb_content', 'crb_shortcode_empty_paragraph_fix', 11);
function crb_shortcode_empty_paragraph_fix($content)
{
    $array = array(
        '<p>['    => '[',
        ']</p>'   => ']',
        ']<br />' => ']',
        ']<br>'   => ']',
    );

    $content = strtr($content, $array);

    return $content;
}

/**
 * Displays the favicon, if it exists
 */
add_action('wp_head', 'crb_display_favicon', 5);
add_action('login_head', 'crb_display_favicon', 5);
add_action('admin_head', 'crb_display_favicon', 5);
function crb_display_favicon()
{
    if (function_exists('has_site_icon') && has_site_icon()) {
        // allow users to override the favicon using the WordPress Customizer
        return;
    }

    # Theme and favicon URI
    $theme_uri = get_template_directory_uri();
    $favicon_uri = apply_filters('crb_theme_favicon_uri', $theme_uri . '/images/favicon.ico');

    # Determine version based on file modified time.
    # If the $version is false, the file does not exist
    $version = crb_generate_file_version($favicon_uri);

    # Display the favicon only if it exists
    if ($version) {
        # Add the version string to the favicon URI
        $favicon_uri = add_query_arg('ver', $version, $favicon_uri);

        echo '<link rel="shortcut icon" href="' . $favicon_uri . '" />' . "\n";
    }
}

/**
 * Filter the default bloginfo description.
 */
add_filter('bloginfo', 'crb_filter_default_bloginfo_description', 10, 2);
function crb_filter_default_bloginfo_description($output, $show)
{
    if ($show !== 'description') {
        return $output;
    }

    $output = str_replace('Just another WordPress site', '', $output);

    return $output;
}

/**
 * A safer alternative of $_REQUEST - only for $_GET and $_POST
 * @param  string $key the name of the requested parameter
 * @return the requested parameter value
 */
function crb_request_param($key = '')
{
    $value = false;
    if (!$key) {
        return $value;
    }

    if (isset($_POST[$key])) {
        $value = $_POST[$key];
    } elseif (isset($_GET[$key])) {
        $value = $_GET[$key];
    }

    return $value;
}

/**
 * Display dynamic sidebar with options.
 *
 * @see dynamic_sidebar()
 * @global $wp_registered_sidebars
 *
 * @param int|string $index Optional, default is 1. Index, name or ID of dynamic sidebar.
 * @return bool True, if widget sidebar was found and called. False if not found or not called.
 */
function crb_dynamic_sidebar($index = 1, $options = array())
{
    global $wp_registered_sidebars;

    // Get the sidebar index the same way as the dynamic_sidebar() function
    if (is_int($index)) {
        $index = "sidebar-$index";
    } else {
        $index = sanitize_title($index);
        foreach ((array) $wp_registered_sidebars as $key => $value) {
            if (sanitize_title($value['name']) == $index) {
                $index = $key;
                break;
            }
        }
    }

    // Bail if this sidebar doesn't exist
    if (empty($wp_registered_sidebars[$index])) {
        return false;
    }

    // Get the current sidebar options
    $sidebar = $wp_registered_sidebars[$index];

    // Update the sidebar options
    $wp_registered_sidebars[$index] = wp_parse_args($options, $sidebar);

    // Display the sidebar
    $status = dynamic_sidebar($index);

    // Restore the original sidebar options
    $wp_registered_sidebars[$index] = $sidebar;

    return $status;
}

/**
 * Redirects if the current user is not logged in. Be careful with the $redirect -
 * may cause infinite redirection loop if the redirect requires login as well
 *
 * @param  string $redirect URL
 */
function crb_require_login($redirect = '')
{
    if (!is_user_logged_in()) {
        $redirect = ($redirect) ? $redirect : home_url('/');
        wp_redirect($redirect);
        exit;
    }
}

/**
 * Redirects if the current user is not of the specified level. Admins are always alowed.
 * May cause infinite redirection loop if the function is called on the $redirect URL.
 *
 * @param  string $level required user capability
 * @param  string $redirect URL address to redirect when the user doesn't have the required capability
 */
function crb_require_user_level($level, $redirect = '')
{
    $u = wp_get_current_user();
    if (empty($u->ID) || !( crb_user_is($u->ID, 'administrator') && crb_user_is($u->ID, $level) )) {
        $redirect = ($redirect) ? $redirect : home_url('/');
        wp_redirect($redirect);
        exit;
    }
}

/**
 * Escape User input from WYSIWYG editors.
 *
 * Calls all filters usually executed on `the_content`.
 *
 * @param  string $content The content that needs to be escaped.
 * @return string The escaped content.
 */
function crb_content($content)
{
    return apply_filters('crb_content', $content);
}

/**
 * Attach all Hooks from `the_content` on `crb_content`.
 */
add_filter('crb_content', 'wptexturize');
add_filter('crb_content', 'wpautop');
add_filter('crb_content', 'shortcode_unautop');
add_filter('crb_content', 'prepend_attachment');
add_filter('crb_content', 'wp_filter_content_tags');
add_filter('crb_content', 'do_shortcode', 12);
add_filter('crb_content', 'convert_smilies', 20);

/**
 * Attach embed shortcodes
 * @see https://developer.wordpress.org/reference/classes/wp_embed/ The WP_Embed constructor initializes these filters to the_content
 */
function crb_attach_embed_filters()
{
    global $wp_embed;

    if (! $wp_embed) {
        return;
    }

    add_filter('crb_content', [ $wp_embed, 'autoembed' ]);
    add_filter('crb_content', [ $wp_embed, 'run_shortcode' ]);
}

crb_attach_embed_filters();
