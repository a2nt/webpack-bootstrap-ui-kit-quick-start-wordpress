<?php

/*use Carbon_Fields\Container\Container;
use Carbon_Fields\Field\Field;

$socials = CrbSocials::set_fields();

Container::make('theme_options', __('Theme Options', 'crb'))
    ->set_page_file('crbn-theme-options.php')
    ->add_tab(__('Header', 'crb'), array(
        Field::make('text', 'crb_header_logo_text', __('Logo Text', 'crb'))
            ->help_text(__('Wrap in asterisks for special styles: *Example Text*', 'crb')),
        Field::make('textarea', 'crb_header_text', __('Text', 'crb')),
        Field::make('text', 'crb_header_phone_number', __('Phone Number', 'crb')),
    ))
    ->add_tab(__('Footer', 'crb'), array(
        Field::make('map', 'crb_footer_map', __('Map', 'crb')),
        Field::make('rich_text', 'crb_footer_text', __('Text', 'crb')),
        Field::make('complex', 'crb_footer_links_top', __('Links on Top', 'crb'))
            ->set_layout('tabbed-vertical')
            ->setup_labels(array(
                'plural_name' => __('Links', 'crb'),
                'singular_name' => __('Link', 'crb'),
            ))
            ->add_fields(array(
                Field::make('text', 'label', __('Label', 'crb'))
                    ->set_width(33),
                Field::make('text', 'url', __('URL', 'crb'))
                    ->set_width(33),
                Field::make('checkbox', 'new_tab', __('Open in New Tab', 'crb'))
                    ->set_width(33),
            )),
        Field::make('text', 'crb_footer_phone_number', __('Phone Number', 'crb')),
        Field::make('rich_text', 'crb_footer_copyright', __('Copyright', 'crb')),
        Field::make('complex', 'crb_footer_links_bottom', __('Links at the Bottom', 'crb'))
            ->set_layout('tabbed-vertical')
            ->setup_labels(array(
                'plural_name' => __('Links', 'crb'),
                'singular_name' => __('Link', 'crb'),
            ))
            ->add_fields(array(
                Field::make('text', 'label', __('Label', 'crb'))
                    ->set_width(33),
                Field::make('text', 'url', __('URL', 'crb'))
                    ->set_width(33),
                Field::make('checkbox', 'new_tab', __('Open in New Tab', 'crb'))
                    ->set_width(33),
            ))
    ))
    ->add_tab(__('Socials', 'crb'), $socials)
    ->add_tab(__('Misc', 'crb'), array(
        Field::make('text', 'crb_google_maps_api_key', __('Google Maps API Key', 'crb'))
            ->help_text(sprintf(
                __('You can generate your own key, by visiting %s and clicking on the "GET A KEY" button there.', 'crb'),
                sprintf(
                    '<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">%s</a>',
                    _x('Get API Key', 'Google Maps Docs', 'crb')
                )
            )),
        Field::make('header_scripts', 'crb_header_script', __('Header Script', 'crb')),
        Field::make('footer_scripts', 'crb_footer_script', __('Footer Script', 'crb')),
    ));
*/
