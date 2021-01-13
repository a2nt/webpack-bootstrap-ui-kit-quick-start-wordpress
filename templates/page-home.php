<?php
/**
* Template Name: Home
 */

get_header(); ?>

    <section id="primary" class="content-area col-sm-12">
        <div id="main" class="site-main" role="main">

            <?php
            while (have_posts()) :
                the_post();

                get_template_part('template-parts/content', 'page');

                // blocks

                $blocks = carbon_get_the_post_meta('crb_home_sections');

                echo '<div class="blocks"><div class="container"><div class="row">';
                foreach ($blocks as $b) {
                    echo '<div class="col-sm-6"><div class="block" style="background:'.$b['background'].'">';

                    $image_atts = crb_get_image_accessibility_atts($b['image']);

                    echo '<img width="546" height="364" src="'
                    .esc_url(crb_get_image_thumbnail($b['image'], 546, 364))
                    .'" alt="'.esc_attr($image_atts['alt_text']).'" />';

                    echo '<div class="block__text">'.$b['text'].'</div>';

                    if ($b['link_url']) {
                        echo '<a class="block__link btn btn-primary stretched-link"'
                        .' href="'.$b['link_url'].'"'.($b['link_new_tab'] ? 'target="_blank"' : '')
                        .'>'
                            .($b['link_label'] ?: 'Learn More')
                        .'</a>';
                    }

                    echo '</div></div>';
                }
                echo '</div></div></div>';
                //

                get_template_part('template-parts/content', 'pods');

                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
            endwhile; // End of the loop.
            ?>

        </div><!-- #main -->
    </section><!-- #primary -->

<?php
get_footer();
