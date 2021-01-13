<?php
/**
 * Banner block
 */
return [
    'title'       => 'Banner block #2',
    'categories'  => ['themed'],
    'description' => 'Banner #2 Pattern',
    'content'     => file_get_contents(get_template_directory().'/inc/block-templates/'.basename(__FILE__, '.php').'.html')
];
