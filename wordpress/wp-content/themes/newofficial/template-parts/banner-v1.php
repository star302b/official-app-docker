<?php
$title = get_field('banner_title','option');
$description = get_field('banner_description','option');
$banner_form_heading = get_field('banner_form_heading','option');
?>

<section class="hero-banner" style="background-image: url(<?php if( get_field('background_image1','option')): echo get_field('background_image1','option'); else: ?><?php echo IMAGE_URL; ?>img/hero/hero-bg-1.jpg<?php endif; ?>)" data-name="Hero Banner" data-description="Without Image/Video, Form-left">
    <div class="relative z-2">
        <div class="container">
            <div class="row flex-row flex-align-center">
                <div class="col col-md-60">
                    <h1 class="hero-title"><?php echo do_shortcode($title); ?></h1>
                    <p class="hero-description">
                        <?php echo do_shortcode($description); ?>
                    </p>
                </div>
                <div class="col col-md-40">
                    <?php get_template_part('./template-parts/form'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_template_part('./template-parts/safe'); ?>