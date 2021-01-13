<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field\Field;

Block::make(__('Gravity Form', 'crb'))
    ->add_fields(array(
        Field::make('gravity_form', 'crb_gravity_form', __('Gravity Form', 'crb')),
    ))
    ->set_description(__('A simple Gravity Form.', 'crb'))
    ->set_category('formatting')
    ->set_icon('editor-textcolor')
    ->set_keywords([ __('block', 'crb'), __('form', 'crb'), __('gravity', 'crb') ])
    ->set_render_callback('crb_render_accordion');

function crb_render_accordion($block)
{
    if (empty($block['crb_gravity_form'])) {
        return;
    }
    ?>
    <div class="gravity-form">
        <?php gravity_form($block['crb_gravity_form'], true, true, false, null, true); ?>
    </div><!-- /.gravity-form -->
    <?php
}
