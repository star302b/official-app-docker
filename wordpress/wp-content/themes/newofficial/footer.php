<style>
    /*Root colors*/
    :root {
        /*typography*/
        --text-color-dark: <?php echo get_global_option('newofficial_text_color_dark') ? get_global_option('newofficial_text_color_dark'): '#333333'; ?>;
        --text-color-light: <?php echo get_global_option('newofficial_text_color_light') ? get_global_option('newofficial_text_color_light'): '#ffffff'; ?>;
        --text-color-title: <?php echo get_global_option('newofficial_text_color_title') ? get_global_option('newofficial_text_color_title'): '#0070b8'; ?>;
        --text-size: 16px;
        /*background*/
        --site-header-bg: <?php echo get_global_option('newofficial_site_header_bg') ? get_global_option('newofficial_site_header_bg'): '#ffffff'; ?>;
        --background-light: <?php echo get_global_option('newofficial_background_light') ? get_global_option('newofficial_background_light'): '#ffffff'; ?>;
        --background-variant-1: <?php echo get_global_option('newofficial_background_variant_1') ? get_global_option('newofficial_background_variant_1'): '#0fb60f'; ?>;
        --background-variant-2: <?php echo get_global_option('newofficial_background_variant_2') ? get_global_option('newofficial_background_variant_2'): '#0070b8'; ?>;
        --background-variant-3: <?php echo get_global_option('newofficial_background_variant_3') ? get_global_option('newofficial_background_variant_3'): '#7645c9'; ?>;
        /*Other*/
        --box-shadow: 0px 5px 20px 0px rgba(0, 0, 0, .3);
    }
</style>

<!--Fonts Control-->
<style>
    <?php
    $theme_version = get_field('theme_variant','option');
    ?>
    <?php 
    if( get_global_option('global_google_font_link') && get_global_option('global_google_font_name')):
        ?>
    @import url("<?php echo get_global_option('global_google_font_link'); ?>");
    body {
        font-family: "<?php echo get_global_option('global_google_font_name'); ?>", sans-serif;
    }
        <?php
    elseif( $theme_version == 'v2'): ?>
    @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap");
    body {
        font-family: "Roboto", sans-serif;
    }
    <?php elseif ( $theme_version == 'v1' ): ?>
    @import url("https://fonts.googleapis.com/css2?family=Noto+Serif&display=swap");
    body {
        font-family: 'Noto Serif', serif;
    }
    <?php elseif ( $theme_version == 'v3' ): ?>
    @import url("https://fonts.googleapis.com/css2?family=Ubuntu&display=swap");
    body {
        font-family: 'Ubuntu', sans-serif;
    }
    <?php elseif ( $theme_version == 'v4' ): ?>
    @import url("https://fonts.googleapis.com/css2?family=Bitter&display=swap");
    body {
        font-family: 'Bitter', serif;
    }
    <?php endif; ?>
</style>

<footer class="site-footer">
    <div class="container">
        <?php
        $languages = icl_get_languages('skip_missing=0&orderby=code');
        if( count( $languages ) > 1):
        ?>
        <ul class="site-lang">
            <?php
            
            foreach ($languages as $l) : ?>
                <li>
                    <a href="<?php echo $l['url'] ?>" title="<?php echo $l['translated_name']; ?>" >
                        <img class="lazy-loaded" src="<?php echo $l['country_flag_url'] ; ?>" height="20"
                             alt="<?php echo $l['translated_name']; ?>">
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <div class="disclamer">
            <?php echo get_field('newofficial_footer_content','option') ? do_shortcode(get_field('newofficial_footer_content','option')) : acf_the_global_field('disclaimer') ?>
        </div>
        <ul class="text-center footer-menu">
            <li><a href="<?php echo get_page_url('page-privacy.php'); ?>"><?php _e('Privacy Policy','trust'); ?></a></li>
            <li><a href="<?php echo get_page_url('page-terms.php'); ?>"><?php _e('Terms & Conditions','trust'); ?></a></li>
        </ul>
    </div>
</footer>

<!--Modal Boxes-->
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

            <div class="input-row text-center" style="margin-top: 1em;">
                <button class="button button-primary" onclick='document.getElementsByClassName("login-error")[0].classList.remove("hidden");return false;'><?php _e('Login','trust'); ?></button>
            </div>
            <div class="field-wrapper">
                <span class="error hidden login-error"><?php _e('Username not found. Please try again','trust') ?></span>
            </div>
        </form>

        <div class="form-bottom">
            <p><?php _e('Don\'t have an account?','trust'); ?> <a href="#register" class="js--open-modal" ><?php _e('Register','trust'); ?></a></p>
        </div>
    </div>
</div>
<div class="modal-box" id="registerpopup">
    <div class="modal-inner">
        <div class="close-modal-button js--close-modal">
            <svg width="15" height="15" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;" xml:space="preserve"><g><g><path d="M284.286,256.002L506.143,34.144c7.811-7.811,7.811-20.475,0-28.285c-7.811-7.81-20.475-7.811-28.285,0L256,227.717 L34.143,5.859c-7.811-7.811-20.475-7.811-28.285,0c-7.81,7.811-7.811,20.475,0,28.285l221.857,221.857L5.858,477.859 c-7.811,7.811-7.811,20.475,0,28.285c3.905,3.905,9.024,5.857,14.143,5.857c5.119,0,10.237-1.952,14.143-5.857L256,284.287 l221.857,221.857c3.905,3.905,9.024,5.857,14.143,5.857s10.237-1.952,14.143-5.857c7.811-7.811,7.811-20.475,0-28.285 L284.286,256.002z"/></g></g></svg>
        </div>

        <div class="sign-area">
        <img class="modal-logo" src="<?php echo get_global_option('newofficial_logo')?>" alt="">
        <div class="form-title">
        <p><?php echo do_shortcode(get_field('banner_form_heading','option'))?></p>
    </div>
            <?php get_template_part('template-parts/form-popup'); ?>
        </div>
    </div>
</div>
<!--Scripts-->

<?php wp_footer(); ?>
</body>
</html>