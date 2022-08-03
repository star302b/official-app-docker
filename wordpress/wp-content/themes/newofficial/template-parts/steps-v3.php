<?php
$steps_title = get_field('steps_title','option');
$steps_description = get_field('steps_description','option');
$step_1_title = get_field('step_1_title','option');
$step_1_description = get_field('step_1_description','option');
$step_2_title = get_field('step_2_title','option');
$step_2_description = get_field('step_2_description','option');
$step_3_title = get_field('step_3_title','option');
$step_3_description = get_field('step_3_description','option');
?>
<section class="content-section steps-section section-overlay section-overlay--variant-3 steps-section--variant-3 light-section" style="background-image: url(<?php echo IMAGE_URL; ?>img/content/pexels-antoni-shkraba-5816296.jpg);" data-name="Steps" data-description="Variant 3">
    <div class="relative z-2">
        <div class="container">
            <div class="section-header">
                <h2><?php echo do_shortcode($steps_title); ?></h2>
                <p>
                    <?php echo do_shortcode($steps_description); ?>
                </p>
            </div>
            <div class="row flex-row">
                <div class="col col-md-30">
                    <div class="step-item">
                        <div class="step-title">
                            <i class="fas fa-id-card"></i>
                            <?php echo do_shortcode($step_1_title); ?>
                        </div>
                        <div class="step-body">
                            <?php echo do_shortcode($step_1_description); ?>
                        </div>
                    </div>
                </div>
                <div class="col col-md-30">
                    <div class="step-item">
                        <div class="step-title">
                            <i class="fas fa-wallet"></i>
                            <?php echo do_shortcode($step_2_title); ?>
                        </div>
                        <div class="step-body">
                            <?php echo do_shortcode($step_2_description); ?>
                        </div>
                    </div>
                </div>
                <div class="col col-md-30">
                    <div class="step-item">
                        <div class="step-title">
                            <i class="fas fa-pray"></i>
                            <?php echo do_shortcode($step_3_title); ?>
                        </div>
                        <div class="step-body">
                            <?php echo do_shortcode($step_3_description); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="button-wrapper text-center">
                <a href="#registerpopup" class="button button-primary js--open-modal"><?php _e('Register for Free','trust'); ?></a>
            </div>
        </div>
    </div>
</section>