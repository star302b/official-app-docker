<?php
$features_title = get_field('features_title','option');
$features_description = get_field('features_description','option');

$features_features = get_field('features_features','option'); // title / description
?>

<section class="content-section dark-section section-overlay" style="background-image: url(<?php echo IMAGE_URL; ?>img/content/pexels-lukas-590016.jpg);" data-name="Features" data-description="Variant 1 (icon - 'fa-bookmark')">
    <div class="relative z-2">
        <div class="container">
            <div class="section-header">
                <h2><?php echo do_shortcode($features_title); ?></h2>
                <p>
                    <?php echo do_shortcode($features_description); ?>
                </p>
            </div>
            <div class="fow flex-row">
                <div class="col col-md-50">
                    <div class="awesome-list">
                        <ul>
                            <?php foreach ($features_features as $iter => $single_feature):
                                if($iter >= 3){
                                    break;
                                }
                                ?>
                            <li>
                                <i class="fas fa-bookmark"></i>
                                <?php echo do_shortcode($single_feature['description'])?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="col col-md-50">
                    <div class="awesome-list">
                        <ul>
                            <?php foreach ($features_features as $iter => $single_feature):
                                if($iter < 3){
                                    continue;
                                }
                                ?>
                                <li>
                                    <i class="fas fa-bookmark"></i>
                                    <?php echo do_shortcode($single_feature['description'])?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>