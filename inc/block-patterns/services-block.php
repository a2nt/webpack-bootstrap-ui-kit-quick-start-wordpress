<?php
/**
 * Banner block
 */
return [
    'title'       => 'Services block',
    'categories'  => ['themed'],
    'description' => 'Services Pattern',
    'content'     => file_get_contents(get_template_directory().'/inc/block-templates/'.basename(__FILE__, '.php').'.html')
];
