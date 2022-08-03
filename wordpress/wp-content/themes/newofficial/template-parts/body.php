<?php
$body_title = get_field('body_title','option');
$body_content = get_field('body_content','option');
?>

<section class="content-section light-section" data-name="Article" data-description="Without image, Long Content">
    <div class="container">
        <div class="fow flex-row flex-align-center">
            <div class="col">
                <div class="typo-wrapper">
                    <h2><?php echo do_shortcode($body_title); ?></h2>
                    <?php the_field('body_content','option'); ?>
                </div>
                <div class="button-wrapper">
                    <a href="#registerpopup" class="button button-primary js--open-modal"><?php _e('Register for Free','trust'); ?></a>
                </div>
            </div>
        </div>
    </div>
</section>