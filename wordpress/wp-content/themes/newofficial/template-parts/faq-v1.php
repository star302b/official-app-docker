<?php
$faq_title = get_field('faq_title','option');
$faq_description = get_field('faq_description','option');
?>

<section class="section content-section light-section" data-name="FAQ">
    <div class="container">
        <div class="section-header">
            <h2><?php echo do_shortcode($faq_title); ?></h2>
            <p>
                <?php echo do_shortcode($faq_description); ?>
            </p>
        </div>
        <div class="row flex-row flex-wrap">
            <?php foreach ( get_field('faq_q_and_a','option') as $faq): ?>
                <div class="col col-md-50">
                        <div class="acc-item">
                            <div class="acc-header js--acc-header"><?php echo do_shortcode($faq['question']); ?></div>
                            <div class="acc-content">
                                <div>
                                    <?php echo do_shortcode($faq['answer']); ?>
                                </div>
                            </div>
                        </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="button-wrapper text-center">
            <a href="#registerpopup" class="button button-primary js--open-modal"><?php _e('Register for Free','trust'); ?></a>
        </div>
    </div>
</section>