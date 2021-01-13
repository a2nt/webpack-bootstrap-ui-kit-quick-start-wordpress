<?php
/**
* Template Name: Customers
 */

get_header(); ?>

    <section id="primary" class="content-area col-sm-12">
        <div id="main" class="site-main" role="main">
            <div class="container">
                <?php
                while (have_posts()) :
                    the_post();

                    get_template_part('template-parts/content', 'page');

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                endwhile; // End of the loop.
                ?>

                <?php
                /***
                 * Display pods
                 */
                $ID = get_the_ID();
                $pods = pods('customer', []);

                $i = 1;
                echo '<div class="row">';
                while ($pods->fetch()) {
                    echo <<<EOL
<div class="col-sm-3">
	<a class="customer" href="{$pods->display('url')}" target="_blank">
		<figure class="wp-block-image size-large">
			<img src="{$pods->display('image')}" alt="{$pods->display('post_title')}"/>
		</figure>
	</a>
</div>
EOL;
                    $i++;
                }
                echo '</div>';

                /* end of pods */
                ?>
            </div>
        </div><!-- #main -->
    </section><!-- #primary -->

<?php
get_footer();
