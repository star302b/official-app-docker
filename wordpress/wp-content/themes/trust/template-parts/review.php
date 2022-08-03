<?php
$review = $args['review'];
$iter = $args['iter'];
$review_id = $review->ID;
$rating = get_field('rating', $review_id);
$top_member = get_field('top_review',$review_id);

?>
<article class="comment-item  content-part  <?php echo get_field('new_member',$review_id) && !$top_member ? (get_field('new_member',$review_id) ? 'new-member' : '' ) :
    ( $top_member ? 'top-member' : '' );//'top-member' ?>">
    <header class="ci-header d-flex f-a-c">
        <div class="ci-avatar"><?php preg_match_all("/[A-Z]/", ucwords(strtolower(get_field('author',$review_id))), $matches);
        echo implode('',$matches[0]);
        ?></div>
        <div class="ci-info">
            <div class="ci-name"><?php the_field('author',$review_id); ?></div>
            <div class="ci-counter"><?php _e('Joined on:','trust'); ?> <?php the_field('author_joined',$review_id);?></div>
        </div>
    </header>
    <div class="ci-body">
        <div class="ci-meta d-flex f-a-c f-j-b">
            <div class="mr-5 d-flex f-a-c">
                <div class="rating mr-5 d-flex f-a-c">
                    <?php for ($i=1; $i <= 5; $i++): ?>
                        <?php if( $rating >= $i): ?>
                        <svg height="15" viewBox="0 -10 511.98685 511" width="15" xmlns="http://www.w3.org/2000/svg"><path d="m510.652344 185.902344c-3.351563-10.367188-12.546875-17.730469-23.425782-18.710938l-147.773437-13.417968-58.433594-136.769532c-4.308593-10.023437-14.121093-16.511718-25.023437-16.511718s-20.714844 6.488281-25.023438 16.535156l-58.433594 136.746094-147.796874 13.417968c-10.859376 1.003906-20.03125 8.34375-23.402344 18.710938-3.371094 10.367187-.257813 21.738281 7.957031 28.90625l111.699219 97.960937-32.9375 145.089844c-2.410156 10.667969 1.730468 21.695313 10.582031 28.09375 4.757813 3.4375 10.324219 5.1875 15.9375 5.1875 4.839844 0 9.640625-1.304687 13.949219-3.882813l127.46875-76.183593 127.421875 76.183593c9.324219 5.609376 21.078125 5.097657 29.910156-1.304687 8.855469-6.417969 12.992187-17.449219 10.582031-28.09375l-32.9375-145.089844 111.699219-97.941406c8.214844-7.1875 11.351563-18.539063 7.980469-28.925781zm0 0" fill="#ffc107"/></svg>
                        <?php else: ?>
                        <svg height="15" viewBox="0 -10 511.98685 511" width="15" xmlns="http://www.w3.org/2000/svg"><path d="m114.59375 491.140625c-5.609375 0-11.179688-1.75-15.933594-5.1875-8.855468-6.417969-12.992187-17.449219-10.582031-28.09375l32.9375-145.089844-111.703125-97.960937c-8.210938-7.167969-11.347656-18.519532-7.976562-28.90625 3.371093-10.367188 12.542968-17.707032 23.402343-18.710938l147.796875-13.417968 58.433594-136.746094c4.308594-10.046875 14.121094-16.535156 25.023438-16.535156 10.902343 0 20.714843 6.488281 25.023437 16.511718l58.433594 136.769532 147.773437 13.417968c10.882813.980469 20.054688 8.34375 23.425782 18.710938 3.371093 10.367187.253906 21.738281-7.957032 28.90625l-111.703125 97.941406 32.9375 145.085938c2.414063 10.667968-1.726562 21.699218-10.578125 28.097656-8.832031 6.398437-20.609375 6.890625-29.910156 1.300781l-127.445312-76.160156-127.445313 76.203125c-4.308594 2.558594-9.109375 3.863281-13.953125 3.863281zm141.398438-112.875c4.84375 0 9.640624 1.300781 13.953124 3.859375l120.277344 71.9375-31.085937-136.941406c-2.21875-9.746094 1.089843-19.921875 8.621093-26.515625l105.472657-92.5-139.542969-12.671875c-10.046875-.917969-18.6875-7.234375-22.613281-16.492188l-55.082031-129.046875-55.148438 129.066407c-3.882812 9.195312-12.523438 15.511718-22.546875 16.429687l-139.5625 12.671875 105.46875 92.5c7.554687 6.613281 10.859375 16.769531 8.621094 26.539062l-31.0625 136.9375 120.277343-71.914062c4.308594-2.558594 9.109376-3.859375 13.953126-3.859375zm-84.585938-221.847656s0 .023437-.023438.042969zm169.128906-.0625.023438.042969c0-.023438 0-.023438-.023438-.042969zm0 0"/></svg>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <div class="ci-status d-flex f-a-c">
                    <svg height="512pt" viewBox="0 0 512 512" width="512pt" xmlns="http://www.w3.org/2000/svg"><path d="m369.164062 174.769531c7.8125 7.8125 7.8125 20.476563 0 28.285157l-134.171874 134.175781c-7.8125 7.808593-20.472657 7.808593-28.285157 0l-63.871093-63.875c-7.8125-7.808594-7.8125-20.472657 0-28.28125 7.808593-7.8125 20.472656-7.8125 28.28125 0l49.730468 49.730469 120.03125-120.035157c7.8125-7.808593 20.476563-7.808593 28.285156 0zm142.835938 81.230469c0 141.503906-114.515625 256-256 256-141.503906 0-256-114.515625-256-256 0-141.503906 114.515625-256 256-256 141.503906 0 256 114.515625 256 256zm-40 0c0-119.394531-96.621094-216-216-216-119.394531 0-216 96.621094-216 216 0 119.394531 96.621094 216 216 216 119.394531 0 216-96.621094 216-216zm0 0"/></svg>
<?php _e('Verified','trust'); ?>
                </div>
            </div>
            <div class="ci-date"><?php trust_posted_age($review) ?></div>
        </div>
        <div class="ci-comment">
            <h3><?php echo do_shortcode( get_the_title($review) ); ?></h3>
            <?php
            $content = $review->post_content;
            $content = apply_filters( 'the_content', $content );
            $content = str_replace( ']]>', ']]&gt;', $content );
            echo $content;
            ?>
        </div>
    </div>
    <?php
    $args = array(
        'post_parent' => $review_id,
        'post_type'   => 'review'
    );

    $childrens = get_children( $args );

    if ( ! empty($childrens) ):
        foreach ($childrens as $children):
    ?>
        <div class="ci-reply">
            <div class="ci-reply-header d-flex f-j-b f-a-c">
                <div class="ci-reply-name"><?php _e('Reply from','trust'); ?> <?php the_field('author', $children->ID); ?></div>
                <div class="date"><?php trust_posted_age($children) ?></div>
            </div>
            <div class="ci-reply-body">
                <?php
                $content = $children->post_content;
                $content = apply_filters( 'the_content', $content );
                $content = str_replace( ']]>', ']]&gt;', $content );
                echo $content;
                ?>
            </div>
        </div>
    <?php endforeach;
    endif; ?>

</article>
<?php if( $iter != 0 && $iter % 4 == 0): ?>
<div class="banner content-part d-flex f-a-c f-j-b xs-c">
    <div class="banner-logo">
        <img width="300"  src="<?php the_field('logo', 'option'); ?>" alt="<?php the_field('funnel', 'option'); ?>">                                    </div>
    <div class="banner-features">
        <div><?php _e('Join','trust'); ?> <?php the_field('funnel', 'option'); ?></div>
    </div>
    <div class="banner-cta">
        <a href="#register" class="js--open-modal button border-width-2 border border-color-1"><?php _e('Register Free','trust'); ?></a>
    </div>
</div>
<?php endif; ?>