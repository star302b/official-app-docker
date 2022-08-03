<?php
if( get_global_option('theme_version') == 'v2') {
    get_header();
}else{
    get_header('v2');
}
?>

<?php if( get_global_option('theme_version' ) == 'v2'): ?>

<?php
global $wpdb;
$reviews_count = wp_count_posts('review')->publish;

$avg_rating = $wpdb->get_results("SELECT AVG(meta_value) as rating FROM `{$wpdb->prefix}postmeta` WHERE `meta_key` = 'rating'", ARRAY_A);
$avg_rating = $avg_rating[0]['rating'];

$excellent_count = $wpdb->get_results("SELECT COUNT(meta_value) as rating_count FROM `{$wpdb->prefix}postmeta` WHERE `meta_key` = 'rating' AND meta_value > 4", ARRAY_A);
$excellent_count = floor(100 * $excellent_count[0]['rating_count'] / $reviews_count);
$great_count = $wpdb->get_results("SELECT COUNT(meta_value) as rating_count FROM `{$wpdb->prefix}postmeta` WHERE `meta_key` = 'rating' AND meta_value <= 4 AND meta_value > 3", ARRAY_A);
$great_count = floor(100 * $great_count[0]['rating_count'] / $reviews_count);
$average_count = $wpdb->get_results("SELECT COUNT(meta_value) as rating_count FROM `{$wpdb->prefix}postmeta` WHERE `meta_key` = 'rating' AND meta_value <= 3 AND meta_value > 2", ARRAY_A);
$average_count = floor(100 * $average_count[0]['rating_count'] / $reviews_count);
$poor_count = $wpdb->get_results("SELECT COUNT(meta_value) as rating_count FROM `{$wpdb->prefix}postmeta` WHERE `meta_key` = 'rating' AND meta_value <= 2 AND meta_value > 1", ARRAY_A);
$poor_count = floor(100 * $poor_count[0]['rating_count'] / $reviews_count);
$bad_count = $wpdb->get_results("SELECT COUNT(meta_value) as rating_count FROM `{$wpdb->prefix}postmeta` WHERE `meta_key` = 'rating' AND meta_value <= 1 ", ARRAY_A);
$bad_count = floor(100 * $bad_count[0]['rating_count'] / $reviews_count);
?>
    <div class="mobile-scroll-nav">
        <ul>
            <li><a class="js--scroll-link" href="#main">Overview</a></li>
            <li><a class="js--scroll-link" href="#about">About</a></li>
            <li><a class="js--scroll-link" href="#reviews">Reviews</a></li>
        </ul>
    </div>

    <section class="review-section">
        <?php get_template_part('template-parts/header-review') ?>
        <div class="content-wrapper">
            <div class="container">
                <div class="row d-flex f-w-w md-f-r xs-col">
                    <div class="col-sidebar">
                        <aside class="site-sidebar js--sidebar-wrapper">
                            <a class="js--scroll-link" href="#reviews">
                                <div class="content-part">
                                    <h2 class="sidebar-title"><?php the_field('funnel', 'option'); ?> <?php _e('Reviews','trust'); ?> <span>(<?php echo $reviews_count; ?>)</span></h2>

                                    <table class="reviews-score-table">
                                        <tr>
                                            <td><?php _e('Excellent','trust'); ?></td>
                                            <td>
                                                <div class="progress-bar">
                                                    <div class="progress-bar-inner"
                                                         style="width: <?php echo $excellent_count;?>%; background: #138e04;"></div>
                                                </div>
                                            </td>
                                            <td><?php echo $excellent_count;?>%</td>
                                        </tr>
                                        <tr>
                                            <td><?php _e('Great','trust'); ?></td>
                                            <td>
                                                <div class="progress-bar">
                                                    <div class="progress-bar-inner"
                                                         style="width: <?php echo $great_count;?>%; background: #128e05b8;"></div>
                                                </div>
                                            </td>
                                            <td><?php echo $great_count;?>%</td>
                                        </tr>
                                        <tr>
                                            <td><?php _e('Average','trust'); ?></td>
                                            <td>
                                                <div class="progress-bar">
                                                    <div class="progress-bar-inner"
                                                         style="width: <?php echo $average_count;?>%; background: #f3a81e;"></div>
                                                </div>
                                            </td>
                                            <td><?php echo $average_count;?>%</td>
                                        </tr>
                                        <tr>
                                            <td><?php _e('Poor','trust'); ?></td>
                                            <td>
                                                <div class="progress-bar">
                                                    <div class="progress-bar-inner"
                                                         style="width: <?php echo $poor_count;?>%; background: #f3883d;"></div>
                                                </div>
                                            </td>
                                            <td><?php echo $poor_count;?>%</td>
                                        </tr>
                                        <tr>
                                            <td><?php _e('Bad','trust'); ?></td>
                                            <td>
                                                <div class="progress-bar">
                                                    <div class="progress-bar-inner"
                                                         style="width: <?php echo $bad_count;?>%; background: #d41212;"></div>
                                                </div>
                                            </td>
                                            <td><?php echo $bad_count;?>%</td>
                                        </tr>
                                    </table>
                                </div>
                            </a>

                            <div class="banner content-part d-flex f-a-c f-j-b xs-c xs-hidden">
                                <div class="banner-logo">
                                    <img width="300" height="66" src="<?php the_field('logo','option'); ?>" alt="<?php the_field('funnel','option'); ?>">                                    </div>
                                <div class="banner-features">
                                    <div><?php _e('Join','trust'); ?> <?php the_field('funnel','option'); ?></div>
                                </div>
                                <div class="banner-cta">
                                    <a href="#register" class="js--open-modal button border-width-2 border border-color-1"><?php _e('Register Free','trust'); ?></a>
                                </div>
                            </div>
                        </aside>
                    </div>
                    <div class="col-content js--article-wrapper">
                        <article class="review-content content-part article-wrapper js--scroll-sections" id="about">
                            <div class="visible-content text-bigger">
                                <?php
                                if(get_field('overview_visible','option')) {
                                    the_field('overview_visible', 'option');
                                }else{
                                    echo acf_the_global_field('overview_visible_global');
                                }
                                ?>
                            </div>
                            <div class="text-right">
                                <button class="show-more-content js--show-more" data-show-id="mainHiddenContent"><?php _e('Read More','trust'); ?></button>
                            </div>
                            <div class="hidden-content" id="mainHiddenContent">
                                <?php
                                if(get_field('overview_hidden','option')) {
                                    the_field('overview_hidden', 'option');
                                }else{
                                    echo acf_the_global_field('overview_hidden_global');
                                }
                                ?>
                            </div>
                        </article>

                        <section class="content-part add-review-block">
                            <div class="d-flex f-a-c f-j-b fw">
                                <div class="d-flex f-a-c wh-n">
                                    <svg width="25" height="25" style="margin-right: 10px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 53 53" xml:space="preserve"><path style="fill:#E7ECED;" d="M18.613,41.552l-7.907,4.313c-0.464,0.253-0.881,0.564-1.269,0.903C14.047,50.655,19.998,53,26.5,53 c6.454,0,12.367-2.31,16.964-6.144c-0.424-0.358-0.884-0.68-1.394-0.934l-8.467-4.233c-1.094-0.547-1.785-1.665-1.785-2.888v-3.322 c0.238-0.271,0.51-0.619,0.801-1.03c1.154-1.63,2.027-3.423,2.632-5.304c1.086-0.335,1.886-1.338,1.886-2.53v-3.546 c0-0.78-0.347-1.477-0.886-1.965v-5.126c0,0,1.053-7.977-9.75-7.977s-9.75,7.977-9.75,7.977v5.126 c-0.54,0.488-0.886,1.185-0.886,1.965v3.546c0,0.934,0.491,1.756,1.226,2.231c0.886,3.857,3.206,6.633,3.206,6.633v3.24 C20.296,39.899,19.65,40.986,18.613,41.552z"/><g><path style="fill:#556080;" d="M26.953,0.004C12.32-0.246,0.254,11.414,0.004,26.047C-0.138,34.344,3.56,41.801,9.448,46.76 c0.385-0.336,0.798-0.644,1.257-0.894l7.907-4.313c1.037-0.566,1.683-1.653,1.683-2.835v-3.24c0,0-2.321-2.776-3.206-6.633 c-0.734-0.475-1.226-1.296-1.226-2.231v-3.546c0-0.78,0.347-1.477,0.886-1.965v-5.126c0,0-1.053-7.977,9.75-7.977 s9.75,7.977,9.75,7.977v5.126c0.54,0.488,0.886,1.185,0.886,1.965v3.546c0,1.192-0.8,2.195-1.886,2.53 c-0.605,1.881-1.478,3.674-2.632,5.304c-0.291,0.411-0.563,0.759-0.801,1.03V38.8c0,1.223,0.691,2.342,1.785,2.888l8.467,4.233 c0.508,0.254,0.967,0.575,1.39,0.932c5.71-4.762,9.399-11.882,9.536-19.9C53.246,12.32,41.587,0.254,26.953,0.004z"/></g></svg>
                                    <a class="link js--open-modal" href="#register" data-body-class="write-review-modal"><?php _e('Write a review','trust'); ?></a>
                                </div>

                                <div>
                                    <div class="rating big-rating js--rating mr-5 d-flex f-a-c ">
                                        <svg data-index="1" height="25" viewBox="0 -10 511.98685 511" width="25" xmlns="http://www.w3.org/2000/svg"><path d="m510.652344 185.902344c-3.351563-10.367188-12.546875-17.730469-23.425782-18.710938l-147.773437-13.417968-58.433594-136.769532c-4.308593-10.023437-14.121093-16.511718-25.023437-16.511718s-20.714844 6.488281-25.023438 16.535156l-58.433594 136.746094-147.796874 13.417968c-10.859376 1.003906-20.03125 8.34375-23.402344 18.710938-3.371094 10.367187-.257813 21.738281 7.957031 28.90625l111.699219 97.960937-32.9375 145.089844c-2.410156 10.667969 1.730468 21.695313 10.582031 28.09375 4.757813 3.4375 10.324219 5.1875 15.9375 5.1875 4.839844 0 9.640625-1.304687 13.949219-3.882813l127.46875-76.183593 127.421875 76.183593c9.324219 5.609376 21.078125 5.097657 29.910156-1.304687 8.855469-6.417969 12.992187-17.449219 10.582031-28.09375l-32.9375-145.089844 111.699219-97.941406c8.214844-7.1875 11.351563-18.539063 7.980469-28.925781zm0 0" fill="#ffc107"/></svg>
                                        <svg data-index="2" height="25" viewBox="0 -10 511.98685 511" width="25" xmlns="http://www.w3.org/2000/svg"><path d="m114.59375 491.140625c-5.609375 0-11.179688-1.75-15.933594-5.1875-8.855468-6.417969-12.992187-17.449219-10.582031-28.09375l32.9375-145.089844-111.703125-97.960937c-8.210938-7.167969-11.347656-18.519532-7.976562-28.90625 3.371093-10.367188 12.542968-17.707032 23.402343-18.710938l147.796875-13.417968 58.433594-136.746094c4.308594-10.046875 14.121094-16.535156 25.023438-16.535156 10.902343 0 20.714843 6.488281 25.023437 16.511718l58.433594 136.769532 147.773437 13.417968c10.882813.980469 20.054688 8.34375 23.425782 18.710938 3.371093 10.367187.253906 21.738281-7.957032 28.90625l-111.703125 97.941406 32.9375 145.085938c2.414063 10.667968-1.726562 21.699218-10.578125 28.097656-8.832031 6.398437-20.609375 6.890625-29.910156 1.300781l-127.445312-76.160156-127.445313 76.203125c-4.308594 2.558594-9.109375 3.863281-13.953125 3.863281zm141.398438-112.875c4.84375 0 9.640624 1.300781 13.953124 3.859375l120.277344 71.9375-31.085937-136.941406c-2.21875-9.746094 1.089843-19.921875 8.621093-26.515625l105.472657-92.5-139.542969-12.671875c-10.046875-.917969-18.6875-7.234375-22.613281-16.492188l-55.082031-129.046875-55.148438 129.066407c-3.882812 9.195312-12.523438 15.511718-22.546875 16.429687l-139.5625 12.671875 105.46875 92.5c7.554687 6.613281 10.859375 16.769531 8.621094 26.539062l-31.0625 136.9375 120.277343-71.914062c4.308594-2.558594 9.109376-3.859375 13.953126-3.859375zm-84.585938-221.847656s0 .023437-.023438.042969zm169.128906-.0625.023438.042969c0-.023438 0-.023438-.023438-.042969zm0 0"/></svg>
                                        <svg data-index="3" height="25" viewBox="0 -10 511.98685 511" width="25" xmlns="http://www.w3.org/2000/svg"><path d="m114.59375 491.140625c-5.609375 0-11.179688-1.75-15.933594-5.1875-8.855468-6.417969-12.992187-17.449219-10.582031-28.09375l32.9375-145.089844-111.703125-97.960937c-8.210938-7.167969-11.347656-18.519532-7.976562-28.90625 3.371093-10.367188 12.542968-17.707032 23.402343-18.710938l147.796875-13.417968 58.433594-136.746094c4.308594-10.046875 14.121094-16.535156 25.023438-16.535156 10.902343 0 20.714843 6.488281 25.023437 16.511718l58.433594 136.769532 147.773437 13.417968c10.882813.980469 20.054688 8.34375 23.425782 18.710938 3.371093 10.367187.253906 21.738281-7.957032 28.90625l-111.703125 97.941406 32.9375 145.085938c2.414063 10.667968-1.726562 21.699218-10.578125 28.097656-8.832031 6.398437-20.609375 6.890625-29.910156 1.300781l-127.445312-76.160156-127.445313 76.203125c-4.308594 2.558594-9.109375 3.863281-13.953125 3.863281zm141.398438-112.875c4.84375 0 9.640624 1.300781 13.953124 3.859375l120.277344 71.9375-31.085937-136.941406c-2.21875-9.746094 1.089843-19.921875 8.621093-26.515625l105.472657-92.5-139.542969-12.671875c-10.046875-.917969-18.6875-7.234375-22.613281-16.492188l-55.082031-129.046875-55.148438 129.066407c-3.882812 9.195312-12.523438 15.511718-22.546875 16.429687l-139.5625 12.671875 105.46875 92.5c7.554687 6.613281 10.859375 16.769531 8.621094 26.539062l-31.0625 136.9375 120.277343-71.914062c4.308594-2.558594 9.109376-3.859375 13.953126-3.859375zm-84.585938-221.847656s0 .023437-.023438.042969zm169.128906-.0625.023438.042969c0-.023438 0-.023438-.023438-.042969zm0 0"/></svg>
                                        <svg data-index="4" height="25" viewBox="0 -10 511.98685 511" width="25" xmlns="http://www.w3.org/2000/svg"><path d="m114.59375 491.140625c-5.609375 0-11.179688-1.75-15.933594-5.1875-8.855468-6.417969-12.992187-17.449219-10.582031-28.09375l32.9375-145.089844-111.703125-97.960937c-8.210938-7.167969-11.347656-18.519532-7.976562-28.90625 3.371093-10.367188 12.542968-17.707032 23.402343-18.710938l147.796875-13.417968 58.433594-136.746094c4.308594-10.046875 14.121094-16.535156 25.023438-16.535156 10.902343 0 20.714843 6.488281 25.023437 16.511718l58.433594 136.769532 147.773437 13.417968c10.882813.980469 20.054688 8.34375 23.425782 18.710938 3.371093 10.367187.253906 21.738281-7.957032 28.90625l-111.703125 97.941406 32.9375 145.085938c2.414063 10.667968-1.726562 21.699218-10.578125 28.097656-8.832031 6.398437-20.609375 6.890625-29.910156 1.300781l-127.445312-76.160156-127.445313 76.203125c-4.308594 2.558594-9.109375 3.863281-13.953125 3.863281zm141.398438-112.875c4.84375 0 9.640624 1.300781 13.953124 3.859375l120.277344 71.9375-31.085937-136.941406c-2.21875-9.746094 1.089843-19.921875 8.621093-26.515625l105.472657-92.5-139.542969-12.671875c-10.046875-.917969-18.6875-7.234375-22.613281-16.492188l-55.082031-129.046875-55.148438 129.066407c-3.882812 9.195312-12.523438 15.511718-22.546875 16.429687l-139.5625 12.671875 105.46875 92.5c7.554687 6.613281 10.859375 16.769531 8.621094 26.539062l-31.0625 136.9375 120.277343-71.914062c4.308594-2.558594 9.109376-3.859375 13.953126-3.859375zm-84.585938-221.847656s0 .023437-.023438.042969zm169.128906-.0625.023438.042969c0-.023438 0-.023438-.023438-.042969zm0 0"/></svg>
                                        <svg data-index="5" height="25" viewBox="0 -10 511.98685 511" width="25" xmlns="http://www.w3.org/2000/svg"><path d="m114.59375 491.140625c-5.609375 0-11.179688-1.75-15.933594-5.1875-8.855468-6.417969-12.992187-17.449219-10.582031-28.09375l32.9375-145.089844-111.703125-97.960937c-8.210938-7.167969-11.347656-18.519532-7.976562-28.90625 3.371093-10.367188 12.542968-17.707032 23.402343-18.710938l147.796875-13.417968 58.433594-136.746094c4.308594-10.046875 14.121094-16.535156 25.023438-16.535156 10.902343 0 20.714843 6.488281 25.023437 16.511718l58.433594 136.769532 147.773437 13.417968c10.882813.980469 20.054688 8.34375 23.425782 18.710938 3.371093 10.367187.253906 21.738281-7.957032 28.90625l-111.703125 97.941406 32.9375 145.085938c2.414063 10.667968-1.726562 21.699218-10.578125 28.097656-8.832031 6.398437-20.609375 6.890625-29.910156 1.300781l-127.445312-76.160156-127.445313 76.203125c-4.308594 2.558594-9.109375 3.863281-13.953125 3.863281zm141.398438-112.875c4.84375 0 9.640624 1.300781 13.953124 3.859375l120.277344 71.9375-31.085937-136.941406c-2.21875-9.746094 1.089843-19.921875 8.621093-26.515625l105.472657-92.5-139.542969-12.671875c-10.046875-.917969-18.6875-7.234375-22.613281-16.492188l-55.082031-129.046875-55.148438 129.066407c-3.882812 9.195312-12.523438 15.511718-22.546875 16.429687l-139.5625 12.671875 105.46875 92.5c7.554687 6.613281 10.859375 16.769531 8.621094 26.539062l-31.0625 136.9375 120.277343-71.914062c4.308594-2.558594 9.109376-3.859375 13.953126-3.859375zm-84.585938-221.847656s0 .023437-.023438.042969zm169.128906-.0625.023438.042969c0-.023438 0-.023438-.023438-.042969zm0 0"/></svg>
                                    </div>
                                </div>
                            </div>
                        </section>



                        <?php
                        $reviews = get_posts(array(
                            'numberposts' => 10,
                            'post_type' => 'review',
                            'post_parent' => 0,
                            // 'orderby' => 'meta_value_num',
                            // 'meta_key' => 'top_review',
                            'suppress_filters' => false,
                        ));
                        if( count($reviews) ):
                            $iter = 0;
                        ?>

                            <script type="application/ld+json">
                                {
                                    "@context":"http:\/\/schema.org\/",
                                    "@type":"Product",
                                    "name":"<?php the_field('funnel','option'); ?>",
                                    "description":"<?php echo strip_tags(get_field('overview_visible', 'option')); ?>",
                                    "aggregateRating": {
                                        "@type": "AggregateRating",
                                        "ratingValue": "<?php echo $avg_rating; ?>",
                                        "reviewCount": "<?php echo $reviews_count; ?>"
                                    },
                                    "image":{
                                        "@type":"ImageObject",
                                        "url":"<?php the_field('logo','option'); ?>",
                                        "width":0,
                                        "height":0
                                    },
                                    "Review":[
                                        <?php
                                $iter =0;

                                foreach ($reviews as $review):
                                    $review_id = $review->ID;
                                    ?>
                                        {
                                            "@type":"Review",
                                            "name":"<?php echo get_the_title($review); ?>",
                                            "reviewBody":"<?php echo strip_tags($review->post_content) ?>",
                                            "author":{
                                                "@type":"Person",
                                                "name":"<?php echo get_field('author',$review_id) ?>"
                                            },
                                            "datePublished":"<?php echo get_the_date('d-m-Y',$review_id)?>",
                                            "dateModified":"<?php echo get_the_date('d-m-Y',$review_id)?>",
                                            "reviewRating":{
                                                "@type":"Rating",
                                                "ratingValue":"<?php echo get_field('rating', $review_id); ?>",
                                                "bestRating":5,
                                                "worstRating":1
                                            },
                                            "publisher":{
                                                "@type":"Organization",
                                                "name":"<?php the_field('funnel','option'); ?> <?php _e('Official Community','trust'); ?>",
                                                "logo":{
                                                    "@type":"ImageObject",
                                                    "url":"",
                                                    "width":0,
                                                    "height":0
                                                }
                                            }
                                        }<?php $iter++; if(count($reviews) != $iter) echo ','; ?>
                                        <?php endforeach;?>
                                    ],
                                    "brand":"",
                                    "sku":"",
                                    "":""
                                }

                            </script>

                        <section class="comments-row js--scroll-sections" id="reviews">
                        <?php foreach ($reviews as $review):
                            setup_postdata( $review );
                            ?>
                            <?php get_template_part('template-parts/review',null, ['review' => $review, 'iter' => ++$iter ]);  ?>
                        <?php endforeach;
                        ?>
                        </section>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>

    </section>
<?php else: ?>
    <?php get_template_part('home-v2'); ?>
<?php endif; ?>
<?php
get_footer();
