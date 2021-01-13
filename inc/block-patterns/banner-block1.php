<?php
/**
 * Banner block
 */
return [
    'title'       => 'Banner block #1',
    'categories'  => ['themed'],
    'description' => 'Banner #1 Pattern',
    'content'     => file_get_contents(get_template_directory().'/inc/block-templates/'.basename(__FILE__, '.php').'.html')
];
