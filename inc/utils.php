<?php
function crb_get_fragment_name($section)
{
    return str_replace('_', '-', $section['_type']);
}

function crb_render_sections($key = 'crb_home_sections', $location = 'sections', $post_id = 0)
{
    if (! $post_id) {
        $post_id = get_the_ID();
    }

    if ($sections = carbon_get_post_meta($post_id, $key)) {
        $render_home_sections = $key === 'crb_home_sections';

        if ($render_home_sections) :
            ?>
            <div class="section__widgets">
                <div class="widgets-main">
                    <ul>
            <?php
        endif;

        foreach ($sections as $index => $section) {
            $fragment_name = crb_get_fragment_name($section);

            $section['index'] = $index;

            crb_render_fragment($location . '/' . $fragment_name, $section);
        }

        if ($render_home_sections) :
            ?>
                    </ul>
                </div><!-- /.widgets-main -->
            </div><!-- /.section__widgets -->
            <?php
        endif;
    }
}

add_filter('wp_generate_attachment_metadata', 'crb_add_image_longdesc', 10, 2);
function crb_add_image_longdesc($metadata, $attachment_id)
{
    if (! wp_attachment_is('image', $attachment_id)) {
        return $metadata;
    }

    $description_id = wp_insert_post(array(
        'post_author'           => 0,
        'post_title'            => $metadata['file'],
        'post_status'           => 'publish',
        'post_type'             => 'crb_image_desc',
    ));

    if ($description_id !== 0 && ! is_wp_error($description_id)) {
        add_post_meta($description_id, '_crb_image_description_attachment_id', $attachment_id);
    }

    return $metadata;
}

function crb_get_image_accessibility_atts($image_id)
{
    $result = array(
        'long_desc_url' => '',
        'alt_text' => '',
    );

    if (! $image_id) {
        return $result;
    }

    $result['alt_text'] = get_post_meta($image_id, '_wp_attachment_image_alt', true);

    $associated_desc_post = get_posts(array(
        'post_type' => 'crb_image_desc',
        'numberposts' => 1,
        'meta_query' => array(
            array(
                'key' => '_crb_image_description_attachment_id',
                'value' => $image_id,
            ),
        )
    ));

    if (! empty($associated_desc_post)) {
        $associated_desc_post = reset($associated_desc_post);
        $result['long_desc_url'] = get_permalink($associated_desc_post->ID);
    }

    return $result;
}

function crb_esc_phone_number($phone_number)
{
    return preg_replace('/\D/', '', $phone_number);
}

function crb_replace_asterisk($text, $before = '<em>', $after = '</em>')
{
    return preg_replace('~\*(.+?)\*~', $before . '${1}' . $after, $text);
}

add_filter('wp_nav_menu_items', 'crb_edit_nav', 10, 2);
function crb_edit_nav($items, $args)
{
    if (! $args->theme_location === 'main-menu') {
        return $items;
    }

    ob_start();
    ?>
    <li>
        <a href="<?php echo home_url('/'); ?>">
            <em class="fas fa-school"></em>
        </a>
    </li>
    <?php
    $first_item = ob_get_clean();

    $items = $first_item . $items;

    return $items;
}

add_filter('the_content', 'crb_add_atts_to_images');
function crb_add_atts_to_images($content)
{
    if (is_admin() || ! $content) {
        return $content;
    }

    $dom = new DomDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($content);

    $images = $dom->getElementsByTagName('img');

    foreach ($images as $image) {
        $image_class = $image->getAttribute('class');
        $image_id = crb_esc_phone_number($image_class);
        $atts = crb_get_image_accessibility_atts($image_id);
        $image->setAttribute('longdesc', $atts['long_desc_url']);
    }

    return $dom->saveHTMl();
}


function crb_get_the_excerpt($post_id = 0, $length = 150)
{
    if (! $post_id) {
        $post_id = get_the_ID();
    }


    $content = get_post_field('post_content', $post_id, 'display');

    if (! $content) {
        return;
    }

    if (strlen($content) > $length) {
        $content = substr($content, 0, $length);
        $content = trim($content);
        $content .= ' ...';
    }

    return $content;
}

require_once(CRB_THEME_DIR . 'inc/compatibility.php');
