<?php

    get_header();
?>
    <main class="site-wrapper">
    <section class="content-section light-section" data-name="Article" data-description="Without image, Long Content">
        <div class="container">
            <div class="fow flex-row flex-align-center">
                <div class="col">
                    <div class="typo-wrapper">
                        <h1><?php the_title(); ?></h1>
                <?php the_content( ); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main>
<?php
get_footer();