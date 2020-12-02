<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php

    // WordPress 5.2 wp_body_open implementation
if (function_exists('wp_body_open')) {
    wp_body_open();
} else {
    do_action('wp_body_open');
}

?>

<div id="Page" class="site wrapper">
    <a class="skip-link screen-reader-text" href="#content"><?= esc_html_e('Skip to content', 'wp-bootstrap-starter') ?></a>
    <?php if (!is_page_template('blank-page.php') && !is_page_template('blank-page-with-container.php')) : ?>
    <header id="Header" class="site-header header navbar-static-top <?= wp_bootstrap_starter_bg_class() ?>" role="banner">
        <div id="HeaderBar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <a id="Logo" class="logo" href="<?= esc_url(home_url('/')) ?>">
                            <img
                                    src="<?= ResourcesURL() ?>/img/logo.png"
                                    alt="<?= esc_attr(get_bloginfo('name')) ?>"
                                    width="326"
                            />
                        </a>
                    </div>
                    <div class="col-sm-6 text-right">
                        <h3 class="slogan"><?= esc_attr(get_bloginfo('description')) ?></h3>
                        <h2 class="call-us"><?= get_theme_mod('header_banner_callus_setting') ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <nav id="Navigation" class="navbar navbar-expand-xl p-0">
            <div class="container">
                <button
                    class="navbar-toggler" type="button"
                    data-toggle="collapse" data-target="#main-nav" aria-controls=""
                    aria-expanded="false" aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <?php
                wp_nav_menu(array(
                'theme_location'    => 'primary',
                'container'       => 'div',
                'container_id'    => 'main-nav',
                'container_class' => 'collapse navbar-collapse',
                'menu_id'         => false,
                'menu_class'      => 'navbar-nav',
                'depth'           => 3,
                'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
                'walker'          => new wp_bootstrap_navwalker()
                ));
                ?>
            </div>
        </nav>
    </header>
        <?php if (is_front_page() && !get_theme_mod('header_banner_visibility')) : ?>
        <div id="Page-sub-header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <?php if (has_header_image()) {?>
                            <img src="<?= header_image() ?>" alt="<?= esc_attr(get_theme_mod('header_banner_title_setting')) ?>" />
                        <?php } ?>
                    </div>
                    <div class="col-sm-8">
                        <div class="banner-content">
                            <h1>
                                <?= esc_attr(get_theme_mod('header_banner_title_setting')) ?>
                            </h1>
                            <p>
                                <?= nl2li(esc_textarea(get_theme_mod('header_banner_tagline_setting'))) ?>
                            </p>
                            <?php if (get_theme_mod('header_banner_link_setting')) : ?>
                                <a
                                        href="<?= esc_attr(get_theme_mod('header_banner_link_setting')) ?>"
                                        class="btn btn-danger"
                                        target="_blank"
                                >
                                    Shop ATMs
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <div id="MainContent" class="site-content">
        <div class="container-fluid">
            <div class="row">
    <?php endif; ?>
