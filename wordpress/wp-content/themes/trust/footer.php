</main>
<!--close main wrapper-->

<footer class="site-footer">
    <div class="container">
        <ul class="langs">
            <?php
            $languages = icl_get_languages('skip_missing=0&orderby=code');
            foreach ($languages as $l) : ?>
            <li>
                <a href="<?php echo $l['url'] ?>" title="<?php echo $l['translated_name']; ?>" >
                    <img class="lazy-loaded" src="<?php echo $l['country_flag_url'] ; ?>" height="16"
                          alt="<?php echo $l['translated_name']; ?>">
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <div class="disclamer">
            <?php echo acf_the_global_field('disclaimer') ?>
        </div>
        <ul class="text-center footer-menu">
            <li><a href="<?php echo get_page_url('page-privacy.php'); ?>"><?php _e('Privacy Policy','trust'); ?></a></li>
            <li><a href="<?php echo get_page_url('page-terms.php'); ?>"><?php _e('Terms & Conditions','trust'); ?></a></li>
        </ul>
    </div>
</footer>
<div class="modal-box" id="login">
    <div class="sign-area">
        <div class="close-modal-button js--close-modal">
            <svg width="15" height="15" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;" xml:space="preserve"><g><g><path d="M284.286,256.002L506.143,34.144c7.811-7.811,7.811-20.475,0-28.285c-7.811-7.81-20.475-7.811-28.285,0L256,227.717 L34.143,5.859c-7.811-7.811-20.475-7.811-28.285,0c-7.81,7.811-7.811,20.475,0,28.285l221.857,221.857L5.858,477.859 c-7.811,7.811-7.811,20.475,0,28.285c3.905,3.905,9.024,5.857,14.143,5.857c5.119,0,10.237-1.952,14.143-5.857L256,284.287 l221.857,221.857c3.905,3.905,9.024,5.857,14.143,5.857s10.237-1.952,14.143-5.857c7.811-7.811,7.811-20.475,0-28.285 L284.286,256.002z"/></g></g></svg>
        </div>
        <form action="">
            <div class="input-row">
                <label><?php _e('Email:','trust'); ?> </label>
                <input type="email" required>
            </div>
            <div class="input-row">
                <label><?php _e('Password:','trust'); ?> </label>
                <input type="password" required>
            </div>
            <div class="input-row text-center">
                <button class="button border border-color-1 border-width-2" onclick='document.getElementsByClassName("login-error")[0].classList.remove("hidden");return false;'><?php _e('Login','trust'); ?></button>
            </div>
            <div class="field-wrapper">
                <span class="error hidden login-error"><?php _e('Username not found. Please try again','trust') ?></span>
            </div>
        </form>
        <div class="alternative-switch text-center">
            <?php _e('Don\'t have an account?','trust'); ?> <a href="#register" class="js--open-modal" ><?php _e('Register','trust'); ?></a>
        </div>
    </div>
</div>
<div class="modal-box" id="register">
    <div class="sign-area">
        <div class="close-modal-button js--close-modal">
            <svg width="15" height="15" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;" xml:space="preserve"><g><g><path d="M284.286,256.002L506.143,34.144c7.811-7.811,7.811-20.475,0-28.285c-7.811-7.81-20.475-7.811-28.285,0L256,227.717 L34.143,5.859c-7.811-7.811-20.475-7.811-28.285,0c-7.81,7.811-7.811,20.475,0,28.285l221.857,221.857L5.858,477.859 c-7.811,7.811-7.811,20.475,0,28.285c3.905,3.905,9.024,5.857,14.143,5.857c5.119,0,10.237-1.952,14.143-5.857L256,284.287 l221.857,221.857c3.905,3.905,9.024,5.857,14.143,5.857s10.237-1.952,14.143-5.857c7.811-7.811,7.811-20.475,0-28.285 L284.286,256.002z"/></g></g></svg>
        </div>
        <img class="modal-logo" width="200" height="35" src="<?php the_field('logo','option'); ?>" alt="<?php the_field('funnel','option'); ?>">
        <div class="alternative-switch" style="font-size: 1.1rem">
            <div class="variant-1">
                <?php echo acf_the_global_field('register_popup_text');?>
            </div>
            <div class="variant-2">
                <?php echo acf_the_global_field('register_review_text');?>
            </div>
        </div>
        <form action="">
            <div class="input-row">
                <label><?php _e('Name:','trust'); ?> </label>
                <div class="field-wrapper">
                    <span class="error hidden"></span>
                    <input type="text" id="first_name" name="first_name" autocomplete="off" title="Please enter 3-15 characters (alphabets only), no spaces allowed"
                           required=""  pattern="[A-Za-z][A-Za-z ]{2,40}">
                </div>
            </div>
            <div class="input-row">
                <label><?php _e('Surname:','trust'); ?> </label>
                <div class="field-wrapper">
                    <span class="error hidden"></span>
                    <input type="text" id="last_name" name="last_name" required="" autocomplete="off" pattern="[A-Za-z][A-Za-z ]{2,40}" title="Please enter 3-15 characters (alphabets only), no spaces allowed">
                </div>
            </div>
            <div class="input-row">
                <label><?php _e('Email:','trust'); ?> </label>
                <div class="field-wrapper">
                    <span class="error hidden"></span>
                    <input type="email" id="email" name="email" required="">
                </div>
            </div>
            <div class="input-row">
                <label><?php _e('Phone:','trust'); ?> </label>
                <div class="field-wrapper">
                    <span class="error hidden"></span>
                    <input id="phone_number" name="phone_number" required>
                </div>
            </div>
            <input type="hidden" id="funnel_id" value=""/>
            <input type="hidden" id="dial_code"/>
            <input type="hidden" id="redirect_page" value="<?php echo home_url('/ok/'); ?>"/>
            <input type="hidden" id="iso"
                   value="<?php echo (defined('ICL_LANGUAGE_CODE')) ? ICL_LANGUAGE_CODE : 'en'; ?>"/>

            <input type="hidden" id="main_post_id"
                   value="<?php echo $post->ID; ?>"/>

            <input type="hidden" id="country"
                   value="<?php echo(isset($_SERVER['GEOIP2_COUNTRY_ISO_CODE']) ? $_SERVER['GEOIP2_COUNTRY_ISO_CODE'] : 'za'); ?>"/>
            <input type="hidden" id="ip_address"
                   value="<?php echo(isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR']); ?>"/>
            <input type="hidden" id="fulfilment_id"
                   value=""/>
            <input type="hidden" id="custom_1" name="custom_1" value="<?php echo $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : 'seo'; ?>"/>

            <div class="input-row text-center" style="position:relative;">
                            <div class="ajax-loader-gif" style="width: 40px; display: none; position: absolute;left: 15px;top: 50%;transform: translateY(-50%);">
                               <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ajax-loader-table.gif?v1" style="    max-height: 35px;"></div>
                                 <button style="    width: 100%;" class="button border border-color-1 border-width-2" type="submit"><?php _e('Register for Free','trust'); ?></button>
            </div>
        </form>
        <div class="alternative-switch">
            <?php echo acf_the_global_field('register_bottom_text');?>
            <div class="logos_section_inner">
                <img src="<?php echo get_template_directory_uri() . '/assets/img/bitgo.png'; ?>">
                <img src="<?php echo get_template_directory_uri() . '/assets/img/norton.png'; ?>">
                <img src="<?php echo get_template_directory_uri() . '/assets/img/mcafee.png'; ?>">
            </div>
            <div class="text-center">
                <p>
<?php _e('Already have an account?','trust'); ?> <a href="#login" class="js--open-modal"><?php _e('Login','trust'); ?></a>
                </p>
            </div>
        </div>
    </div>
</div>
<?php wp_footer(); ?>
</body>
</html>