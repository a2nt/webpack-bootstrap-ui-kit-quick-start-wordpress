<?php

use Carbon_Fields\Container\Container;
use Carbon_Fields\Field\Field;

Container::make('post_meta', __('Custom Data', 'crb'))
    ->where('post_type', '=', 'page')
    ->where('post_template', '=', 'templates/page-home.php')
    ->add_tab(__('Sections', 'crb'), [
        Field::make('complex', 'crb_home_sections', '')
            ->set_layout('tabbed-vertical')
            ->setup_labels(array(
                'plural_name' => __('Block', 'crb'),
                'singular_name' => __('Block', 'crb'),
            ))
            ->add_fields('image_block', 'Image Block', [
                Field::make('image', 'image', 'Image')
                    ->help_text(__('Recommended image size is width by height pixels. Larger images will be resized.', 'crb')),
                Field::make('textarea', 'text', 'Text'),
                Field::make('text', 'link_label', 'Link Label')
                    ->set_width(33),
                Field::make('text', 'link_url', 'Link URL')
                    ->set_width(33),
                Field::make('checkbox', 'link_new_tab', 'Open in New Tab')
                    ->set_width(33),
                Field::make('color', 'background', 'Background')
                    ->set_palette([ '#1c7a85', '#c5c5c5', '#821445', '#4a8200', '#fff' ]),
            ]),
        ]);
