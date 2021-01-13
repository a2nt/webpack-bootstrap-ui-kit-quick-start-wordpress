<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<!-- content-page -->
<?php
if (!is_front_page()) {
    ?><div id="MainTypo" class="typography"><?php
} ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    $enable_vc = get_post_meta(get_the_ID(), '_wpb_vc_js_status', true);
    if (!$enable_vc && !is_front_page()) {
        ?>
    <header class="entry-header">
        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
    </header><!-- .entry-header -->
    <?php } ?>

    <?php
    if (!is_front_page() && function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb('<p id="breadcrumbs" class="breadcrumbs">', '</p>');
    }
    ?>

    <?php
        // Display Popup
    if (get_the_ID() === 227) {
        echo <<<EOL
<div id="Popup" class="popup-wrapper meta-lightbox-overlay meta-lightbox-theme-default meta-lightbox-effect-fade meta-lightbox-open">
    <span class="a meta-lightbox-close fas fa fa-times close jsMetaLightboxUI-close-inline"><span class="sr-only">X</span></span>
    <div class="meta-lightbox-wrap">
        <div class="popup-content meta-lightbox-content meta-lightbox-inline">
            <div class="popup-body">
                <h2>Are you interested in upgrading or replacing your existing ATM machine?</h2>
                <p>Call to find out how easy it is to swap out machines.<br>
                    Call 1-888-428-6249 today!</p>

                <p>or <a href="https://bestatmsystems.com/contact-us/">send us a note</a> and we’ll call you.</p>
            </div>
        </div>
    </div>
</div>
EOL;
    }
    ?>

    <?php if (strlen(get_the_content())) { ?>
    <div class="entry-content">
        <div class="container entry-container">
            <div class="typography">
                <?php
                /***
                 * Display content field
                 */
                    the_content();

                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'wp-bootstrap-starter'),
                        'after'  => '</div>',
                    ));
                ?>
            </div>
        </div>
    </div><!-- .entry-content -->
    <?php } ?>

    <?php if (get_edit_post_link() && !$enable_vc) : ?>
        <footer class="entry-footer">
            <?php
                edit_post_link(
                    sprintf(
                        /* translators: %s: Name of current post */
                        esc_html__('Edit %s', 'wp-bootstrap-starter'),
                        the_title('<span class="screen-reader-text">"', '"</span>', false)
                    ),
                    '<span class="edit-link">',
                    '</span>'
                );
            ?>
        </footer><!-- .entry-footer -->
    <?php endif; ?>
</article><!-- #post-## -->
    <?php
    if (!is_front_page()) {
        ?>
    </div>
    <?php } ?>
