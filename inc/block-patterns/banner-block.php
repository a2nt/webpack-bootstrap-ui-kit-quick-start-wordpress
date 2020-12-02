<?php
/**
 * Banner block
 */
return [
    'title'       => 'Banner block',
    'categories'  => ['themed'],
    'description' => 'Banner Pattern',
    'content'     => file_get_contents(get_template_directory().'/inc/block-templates/'.basename(__FILE__, '.php').'.html')
];
