<!-- content-pods -->
<?php

    /***
     * Display pods
     */
    $ID = get_the_ID();
    $pods = pods('block', [
            'block_owner_page' => $ID
    ]);

    $i = 1;
    while ($pods->fetch()) {
        if ((int) $pods->field('block_owner_page')['ID'] !== $ID) {
            continue;
        }

        $bg = $pods->display('banner_bg') ?: '';
        $color = $pods->display('banner_color') ?: '';
        echo <<<EOL
<div class="container-fluid block-item block-item__banner-block{$i}" style="color:{$color};background:{$bg}'">
    <div class="container block-item__inner-container">
        <div class="row">
            <div class="col-md-8">
                    <h2 class="display-4 block-title">{$pods->display('post_title')}</h2>
                    <div class="typogaphy">
                        {$pods->display('post_content')}
                    </div>
            </div>

            <div class="col-md-4 text-right">
                    <a class="btn btn-danger" href="{$pods->display('block_button_link')}" role="button">{$pods->display('block_button_label')}</a>
            </div>
        </div>
EOL;
        echo '</div>';
        if ($pods->display('hover_text')) {
            echo '<div class="block-hover-text"><div class="container typography">'.$pods->display('hover_text').'</div></div>';
        }
        echo '</div>';
        $i++;
    }

    $pods = pods('service_block', [
            'owner_page' => $ID
    ]);

    $i = 1;
    while ($pods->fetch()) {
        if ((int) $pods->field('owner_page')['ID'] !== $ID) {
            continue;
        }
        echo <<<EOL
<div class="container-fluid block-item block-item__services-block">
    <div class="container block-item__inner-container">
        <h2 class="display-4 text-center block-title">{$pods->display('post_title')}</h2>
        <div class="typogaphy">
            {$pods->display('post_content')}
        </div>
        <div class="row">
EOL;

        $services = $pods->field('services');
        foreach ($services as $service) {
            $pod = pods('service', $service['ID']);
            echo <<<EOL
<div class="col col-md-3 sub-block">
<figure class="wp-block-image size-large"><img src="{$pod->display('image')}" alt=""/></figure>
<h3 class="display-5 text-center sub-block-title">{$pod->display('post_title')}</h3>
EOL;
            if ($pod->display('link')) {
                echo '<a href="'.$pod->display('link').'" class="stretched-link"><span class="sr-only">'
                     .$pod->display('post_title')
                     .'</span></a>';
            }
            echo '</div>';
        }

        echo '</div></div>';
        $i++;
    }

    /* end of pods */
