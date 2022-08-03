<?php
/*
 * Template Name: Thanks Page
 */
    get_header();
?>
    <main class="site-wrapper">
        <section class="content-section light-section" data-name="Article" data-description="Without image, Long Content">
            <div class="container">
                <div class="fow flex-row flex-align-center">
                    <div class="col">
                        <div class="typo-wrapper">
                            <?php echo acf_the_global_field('thank_you_page_content') ?>
                            <div class="banner-cta">
                                <a href="<?php echo do_shortcode('[funnel_account_button_url]'); ?>" class="button border-width-2 border border-color-1"><?php _e('Login Now','trust'); ?> ></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php
get_footer();
