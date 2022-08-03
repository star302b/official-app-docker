<?php
/*
 * Template Name: Thanks Page
 */
if( get_global_option('theme_version') == 'v2') {
    get_header();
}else{
    get_header('v2');
}
?>
    <section class="review-section">
        <?php if( get_global_option('theme_version') == 'v2') : ?>
        <?php get_template_part('template-parts/header-review') ?>
        <?php endif; ?>
        <div class="content-wrapper">
            <div class="container">
                <div class="row d-flex f-w-w md-f-r xs-col">
                    <div class="col-sidebar">
                        <aside class="site-sidebar js--sidebar-wrapper">
                            <div class="banner content-part d-flex f-a-c f-j-b xs-c xs-hidden">
                                <div class="banner-logo">
                                    <img width="300" height="66" src="<?php the_field('logo','option'); ?>" alt="<?php the_field('funnel','option'); ?>">                                    </div>
                                <div class="banner-features">
                                    <div><?php _e('Go To Your Account','trust'); ?></div>
                                </div>
                                <div class="banner-cta">
                                    <a href="<?php echo do_shortcode('[funnel_account_button_url]'); ?>" class="button border-width-2 border border-color-1"><?php _e('Login Now','trust'); ?> ></a>
                                </div>
                            </div>
                        </aside>
                    </div>
                    <div class="col-content js--article-wrapper">
                        <article class="review-content content-part article-wrapper js--scroll-sections" id="about">
                            <div class="visible-content text-bigger">
                               <?php echo acf_the_global_field('thank_you_page_content') ?>
                            </div>

                        </article>


                        <section class="comments-row js--scroll-sections" id="reviews">
                            <div class="banner content-part d-flex f-a-c f-j-b xs-c">
                                <div class="banner-logo">
                                    <img width="300" src="<?php the_field('logo','option'); ?>" alt="<?php the_field('funnel','option'); ?>">                                    </div>
                                <div class="banner-features">
                                    <div><?php _e('Go To Your Account','trust'); ?></div>
                                </div>
                                <div class="banner-cta">
                                    <a href="<?php echo do_shortcode('[funnel_account_button_url]'); ?>" class="button border-width-2 border border-color-1"><?php _e('Login Now','trust'); ?> ></a>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>

        </div>

    </section>

<?php
get_footer();
