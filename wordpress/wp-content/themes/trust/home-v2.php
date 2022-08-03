

<?php 
if($_GET['test']){
    var_dump($_SERVER);
}
?>
    <section class="top-section" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/img/header-bg-scaled.jpeg)">
        <div class="container">
            <div class="row d-flex f-a-c f-w-w">
                <div class="col-video">
                    <div class="video-wrapper">
                        <?php
                        $video_url = 'https://player.vimeo.com/video/582885488?color&autopause=0&loop=0&muted=0&title=0&portrait=0&byline=0#t=';
                        if( ICL_LANGUAGE_CODE == 'de' ){
                            $video_url = 'https://player.vimeo.com/video/328987304';
                        }
                        ?>
                        <iframe src="<?php echo $video_url; ?>" frameborder="0" loading="lazy"></iframe>
                    </div>
                </div>
                <div class="col-form">
                    <div class="sign-area" id="registerform">

                        <div class="alternative-switch" style="font-size: 1.1rem">
                            <div class="variant-1">
                                <?php echo acf_the_global_field('register_popup_text');?>
                            </div>
                        </div>
<style>.form-error{
    background: #f40;
    border-radius: 4px;
    color: #fff;
    padding: 6px 12px;
    width: 100%;
}</style>
                        <form action="">
                            <span class="error form-error hidden"></span>
                            <div class="input-row">
                                <label><?php _e('Name:','trust'); ?> </label>
                                <div class="field-wrapper">
                                    <span class="error hidden"></span>
                                    <input type="text" id="first_name2" name="first_name" autocomplete="off" title="Please enter 3-15 characters (alphabets only), no spaces allowed"
                                           required=""  pattern="[A-Za-z][A-Za-z ]{2,40}">
                                </div>
                            </div>
                            <div class="input-row">
                                <label><?php _e('Surname:','trust'); ?> </label>
                                <div class="field-wrapper">
                                    <span class="error hidden"></span>
                                    <input type="text" id="last_name2" name="last_name" required="" autocomplete="off" pattern="[A-Za-z][A-Za-z ]{2,40}" title="Please enter 3-15 characters (alphabets only), no spaces allowed">
                                </div>
                            </div>
                            <div class="input-row">
                                <label><?php _e('Email:','trust'); ?> </label>
                                <div class="field-wrapper">
                                    <span class="error hidden"></span>
                                    <input type="email" id="email2" name="email" required="">
                                </div>
                            </div>
                            <div class="input-row">
                                <label><?php _e('Phone:','trust'); ?> </label>
                                <div class="field-wrapper">
                                    <span class="error hidden"></span>
                                    <input id="phone_number2" name="phone_number" required>
                                </div>
                            </div>
                            <input type="hidden" id="funnel_id2" value=""/>
                            <input type="hidden" id="dial_code2"/>
                            <input type="hidden" id="redirect_page2" value="<?php echo home_url('/ok/'); ?>"/>
                            <input type="hidden" id="iso2"
                                   value="<?php echo (defined('ICL_LANGUAGE_CODE')) ? ICL_LANGUAGE_CODE : 'en'; ?>"/>

                            <input type="hidden" id="main_post_id2"
                                   value="<?php echo $post->ID; ?>"/>

                            <input type="hidden" id="country2"
                                   value="<?php echo(isset($_SERVER['GEOIP2_COUNTRY_ISO_CODE']) ? $_SERVER['GEOIP2_COUNTRY_ISO_CODE'] : 'za'); ?>"/>
                            <input type="hidden" id="ip_address2"
                                   value="<?php echo(isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR']); ?>"/>
                            <input type="hidden" id="fulfilment_id2"
                                   value=""/>
                            <input type="hidden" id="custom_12" name="custom_1" value="<?php echo $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : 'seo'; ?>"/>

                            <div class="input-row text-center" style="position:relative;">
                            <div class="ajax-loader-gif" style="width: 40px; display: none; position: absolute;left: 15px;top: 50%;transform: translateY(-50%);">
                               <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ajax-loader-table.gif?v1" style="    max-height: 35px;"></div>
                                <button style="    width: 100%;" class="button border border-color-1 border-width-2" type="submit"><?php _e('Register for Free','trust'); ?></button>
                            </div>
                        </form>

                        <div class="alternative-switch">
                            <?php echo acf_the_global_field('register_bottom_text');?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="trust-section">
        <div class="container text-center">
            <div class="logos_section_inner">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bitgo.png">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/norton.png">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/mcafee.png">
            </div>
        </div>
    </section>

    <section class="content-section">
        <div class="container">
            <div class="row d-flex f-a-c f-w-w md-f-r xs-col">
                <div class="col-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/join-us.png" alt="">
                </div>
                <div class="col-text">
                    <?php
                    if(get_field('overview_visible','option')) {
                        the_field('overview_visible', 'option');
                    }else{
                        echo acf_the_global_field('overview_visible_global');
                    }
                    ?>
                    <div class="text-center">
                        <a href="#register" class="js--open-modal button button-white border border-width-2 border-color-1"><?php _e('Register for Free','trust'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <?php
    $main_blog_id = get_current_blog_id();
    if(get_main_site_id() != get_current_blog_id() ){
        if( !get_option('reviews_idsnn_' . ICL_LANGUAGE_CODE) ) {
            switch_to_blog( 1 );

            $args = [
                'posts_per_page' => 10,
                'fields' => 'ids',
                'orderby' => 'rand',
                'post_type' => 'review',
                'suppress_filters' => 0,
            ];

            $reviews_ids = get_posts($args);

            restore_current_blog();
            update_option('reviews_idsnn_' . ICL_LANGUAGE_CODE , json_encode($reviews_ids));
        }else{
            $reviews_ids = json_decode( get_option('reviews_idsnn_' . ICL_LANGUAGE_CODE) );
        }

        $today_reviews_ids = json_decode(get_transient('current_review_4_idsnnnnn'. ICL_LANGUAGE_CODE));
        if( !$today_reviews_ids) {
            $posts_ids_offset = rand(1,60);


            if( get_option('posts_ids_offsetnnn'. ICL_LANGUAGE_CODE) !== false ){
                update_option('posts_ids_offsetnn'. ICL_LANGUAGE_CODE, get_option('posts_ids_offsetnnn'. ICL_LANGUAGE_CODE) + 1 );
                $posts_ids_offset = get_option('posts_ids_offsetnnn'. ICL_LANGUAGE_CODE);
            }else{
                update_option('posts_ids_offsetnnn'. ICL_LANGUAGE_CODE, $posts_ids_offset );
            }


            switch_to_blog(1);

            $args = [
                'posts_per_page' => 4,
                'fields' => 'ids',
                'orderby' => 'id',
                'order' => 'DESC',
                'post_type' => 'review',
                'suppress_filters' => 0,
                'offset' => $posts_ids_offset
            ];

            $all_rev_ids = get_posts($args);

            restore_current_blog();
            set_transient('current_review_4_idsnnnnn'. ICL_LANGUAGE_CODE, json_encode($all_rev_ids) ,DAY_IN_SECONDS);
            $today_reviews_ids = $all_rev_ids;
        }
        switch_to_blog( 1 );
        $reviews = get_posts(array(
            'post_type' => 'review',
            'include' => $today_reviews_ids,
            'suppress_filters' => false,
        ));

    }else {
        $reviews = get_posts(array(
            'numberposts' => 4,
            'post_type' => 'review',
            'post_parent' => 0,
//        'orderby' => 'meta_value_num',
//        'meta_key' => 'top_review',
            'suppress_filters' => 0,
        ));
    }
    $showed_reviews = 0;
    if( count($reviews) ):
    ?>
    <section class="section-testimonials" id="reviews">
        <div class="section-heading">
            <h2><?php echo strip_tags(acf_the_global_field_by_site('testimonials_title',$main_blog_id)); ?></h2>
        </div>
        <div class="container">
            <div class="row d-flex f-w-w md-f-r xs-col">
                <?php foreach ($reviews as $review):
                    $showed_reviews++;
                    if($showed_reviews > 4){
                        break;
                    }
                    $review_id = $review->ID;
                ?>
                <div class="col-half">
                    <div class="testimonials-item">
                        <div class="avatar">
                            <div class="ci-avatar"><?php preg_match_all("/[A-Z]/", ucwords(strtolower(get_field('author',$review_id))), $matches);
                                echo implode('',$matches[0]);
                                ?></div>
                        </div>
                        <div class="content">
                            <div class="heading">
                                <h5><?php the_field('author',$review_id); ?></h5>
                            </div>
                            <div class="date"><?php _e('Joined on:','trust'); ?> <?php the_field('author_joined',$review_id);?></div>
                            <div class="text">
                                <h3><?php echo prepere_contente_review( get_the_title($review_id) , $main_blog_id ); ?></h3>
                                "<?php echo prepere_contente_review($review->post_content, $main_blog_id); ?>"
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="cta-section">
                <a href="#register" class="js--open-modal button button-white border border-width-2 border-color-1"><?php _e('Register for Free','trust'); ?></a>                            </div>
        </div>
        </div>
    </section>
    <?php endif;
    if(get_main_site_id() != get_current_blog_id() ){
        restore_current_blog();

    }
    switch_to_blog( $main_blog_id );
    ?>
    <section class="section-see">
        <div class="container">
            <div class="text-center">
                <h2><?php _e('As seen on','trust'); ?></h2>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/seenon.png" alt="">
            </div>
        </div>
    </section>

    <section class="content-section">
        <div class="container">
            <div class="row d-flex f-a-c f-w-w md-f-r xs-col">
<!--                <div class="col-image">-->
<!--                    <img src="--><?php //echo get_template_directory_uri(); ?><!--/assets/img/join-us.png" alt="">-->
<!--                </div>-->
<!--                <div class="col-text">-->
                <div class="mobile-visible-content">
                    <?php
                    if(get_field('overview_hidden','option')) {
                        the_field('overview_hidden', 'option');
                    }else{
                        echo acf_the_global_field('overview_hidden_global');
                    }
                    ?>
                    <div class="text-center">
                        <a href="#register" class="js--open-modal button button-white border border-width-2 border-color-1"><?php _e('Register for Free','trust'); ?></a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <?php
    switch_to_blog( 1 );
    

    $faqs = get_field('faq','option',false);
    restore_current_blog();
    //var_dump($faqs);
    if(count( $faqs )):
    // if( have_rows('faq', 'option')):
    ?>
    <section class="section-faq">
        <div class="section-heading">
            <h2><?php echo do_shortcode(acf_get_global_field('faq_title'));
            restore_current_blog();
                switch_to_blog( $main_blog_id );
            ?></h2>
        </div>
        <div class="container" itemscope itemtype="https://schema.org/FAQPage">
            <div class="row d-flex f-w-w md-f-r xs-col">
                <?php //while( have_rows('faq', 'option') ): the_row(); 
                foreach( $faqs as $faq):
                ?>
                    <div class="col-half">
                        <div class="acc-item" itemscope itemprop="mainEntity"
                             itemtype="https://schema.org/Question">
                            <div class="acc-header js--acc-header" itemprop="name"><?php 
                            echo do_shortcode($faq['field_60fe66e6e41d2']); ?></div>
                            <div class="acc-content" itemscope itemprop="acceptedAnswer"
                                 itemtype="https://schema.org/Answer">
                                <div style="padding: 0 1rem 0;" itemprop="text">
                                    <p><?php echo do_shortcode($faq['field_60fe66f1e41d3']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php //endwhile; 
                endforeach;
                ?>
            </div>
        </div>
        <div class="cta-section">
            <a href="#register" class="js--open-modal button button-white border border-width-2 border-color-1"><?php _e('Register for Free','trust'); ?></a>                            </div>
        </div>
    </section>
<?php endif;
         ?>