<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?>
</div><!-- #page -->

<?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- #content -->
    <?php get_template_part( 'footer-widget' ); ?>
	<footer id="Footer" class="site-footer footer <?php echo wp_bootstrap_starter_bg_class(); ?>" role="contentinfo">
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <?= get_bloginfo('name') ?><br/>
                        206 Sedgwick Dr., Syracuse, NY 13203<br/>
                        <b>1-888-428-6249 • 315-423-3055</b><br/>
                        <a class="mailto" href="mailto:info@atmsystems.biz" target="_blank">info@ATMSystems.biz</a>
                    </div>
                    <div class="col-md-6 text-right site-info">
                        &copy; <?= date('Y') ?> <?= '<a href="'.home_url().'" class="home-link">'.get_bloginfo('name').'</a>' ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">&nbsp;</div>
	</footer>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>