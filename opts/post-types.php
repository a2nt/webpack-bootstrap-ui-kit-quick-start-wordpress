<?php

register_post_type('crb_image_desc', array(
    'labels' => array(
        'name' => __('Image Descriptions', 'crb'),
        'singular_name' => __('Image Description', 'crb'),
        'add_new' => __('Add New', 'crb'),
        'add_new_item' => __('Add new Image Description', 'crb'),
        'view_item' => __('View Image Description', 'crb'),
        'edit_item' => __('Edit Image Description', 'crb'),
        'new_item' => __('New Image Description', 'crb'),
        'view_item' => __('View Image Description', 'crb'),
        'search_items' => __('Search Image Descriptions', 'crb'),
        'not_found' =>  __('No Image Descriptions found', 'crb'),
        'not_found_in_trash' => __('No Image Descriptions found in trash', 'crb'),
    ),
    'public' => true,
    'exclude_from_search' => true,
    'show_ui' => false,
    'capability_type' => 'post',
    'hierarchical' => false,
    '_edit_link' => 'post.php?post=%d',
    'rewrite' => array(
        'slug' => 'image-descrition',
        'with_front' => false,
    ),
    'query_var' => true,
    'menu_icon' => 'dashicons-admin-post',
    'supports' => array( 'title', 'editor', 'page-attributes' ),
));
