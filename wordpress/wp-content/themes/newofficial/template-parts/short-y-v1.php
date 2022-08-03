<?php
$short_y_title = get_field('short_y_title','option');
$short_y_description = get_field('short_y_description','option');
?>
<section class="content-section light-section" data-name="Article" data-description="Left image">
    <div class="container">
        <div class="fow flex-row flex-align-center flex-md-reverse">
            <div class="col col-md-50">
                <div class="typo-wrapper">
                    <h2><?php echo do_shortcode($short_y_title); ?></h2>
                    <p>
                        <?php echo do_shortcode($short_y_description); ?>
                    </p>
                </div>
                <div class="button-wrapper">
                    <a href="#registerpopup" class="button button-primary js--open-modal"><?php _e('Register for Free','trust'); ?></a>
                </div>
            </div>
            <div class="col col-md-50">
                <img src="<?php echo IMAGE_URL; ?>img/content/pexels-alesia-kozik-6777570.jpg" alt="Start Growing Your Financial Portfolio Today">
            </div>
        </div>
    </div>
</section>