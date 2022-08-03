<?php
/*
 * Template Name: Privacy Page
 */
    get_header();
?>
    <main class="site-wrapper">
    <section class="content-section light-section" data-name="Article" data-description="Without image, Long Content">
        <div class="container">
            <div class="fow flex-row flex-align-center">
                <div class="col">
                    <div class="typo-wrapper">
                <?php echo acf_the_global_field('privacy_policy'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main>
<?php
get_footer();