<?php 
if($_GET['denistest'] == 2321){

        echo esc_url_raw(home_url('/ok/')) ? home_url('/ok/') : '/ok/';

        $pageid = get_page_by_path('/ok/');
        echo apply_filters( 'wpml_object_id', $pageid->ID, 'page', FALSE );



        $translatedPostId = icl_object_id($pageid->ID, 'page', false, ICL_LANGUAGE_CODE);
        $myPost = get_post( $translatedPostId );

        // var_dump($myPost);
}

?>
<div class="sign-area" id="register">
    <div class="form-title">
        <p><?php echo do_shortcode(get_field('banner_form_heading','option'))?></p>
    </div>
    <form action="">
        <span class="error form-error hidden"></span>
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
        <input type="hidden" id="redirect_page" value="<?php echo in_array(ICL_LANGUAGE_CODE,['nl','de','en']) ? home_url('/ok/') : '/ok/'; ?>"/>
        <input type="hidden" id="iso"
               value="<?php echo (defined('ICL_LANGUAGE_CODE')) ? ICL_LANGUAGE_CODE : 'en'; ?>"/>

        <input type="hidden" id="main_post_id"
               value="<?php echo $post->ID; ?>"/>
        <?php 
        $main_country_code = isset($_SERVER['GEOIP2_COUNTRY_CODE']) ? $_SERVER['GEOIP2_COUNTRY_CODE'] : 'za';
        if( function_exists('wp_remote_get')){
            $ippppp = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR'];
            $responseipinfo = wp_remote_get('https://ipinfo.io/'.$ippppp.'?token=cfcd9237902f60');
    
            if ( is_wp_error( $responseipinfo ) ){
                $main_country_code = isset($_SERVER['GEOIP2_COUNTRY_CODE']) ? $_SERVER['GEOIP2_COUNTRY_CODE'] : 'za';
            }
            elseif( wp_remote_retrieve_response_code( $responseipinfo ) === 200 ){
                $body = wp_remote_retrieve_body( $responseipinfo );
                $bodyipinfo = json_decode($body);
                $main_country_code = $bodyipinfo->country;
            }
    
        }
        ?>
        <input type="hidden" id="country"
               value="<?php echo $main_country_code; ?>"/>
        <input type="hidden" id="ip_address"
               value="<?php echo(isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR']); ?>"/>
        <input type="hidden" id="fulfilment_id"
               value=""/>
        <input type="hidden" id="custom_1" name="custom_1" value="<?php echo $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : 'seo'; ?>"/>

        <div class="input-row text-center" style="position:relative;">
            <div class="ajax-loader-gif" style="width: 40px; display: none; position: absolute;left: 15px;top: 50%;transform: translateY(-50%);">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ajax-loader-table.gif?v1" style="    max-height: 35px;"></div>
            <button style="    width: 100%;" class="button  button-primary" type="submit"><?php _e('Register for Free','trust'); ?></button>
        </div>
    </form>
    <div class="form-bottom">
        <p><?php echo acf_the_global_field('register_bottom_text');?></p>
    </div>
</div>

<?php
if($_GET['test'] == 'Landers184%'){
    $main_country_code = isset($_SERVER['GEOIP2_COUNTRY_CODE']) ? $_SERVER['GEOIP2_COUNTRY_CODE'] : 'za';
    if( function_exists('wp_remote_get')){
        $ippppp = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR'];
        $responseipinfo = wp_remote_get('https://ipinfo.io/'.$ippppp.'?token=cfcd9237902f60');

        if ( is_wp_error( $responseipinfo ) ){
            $main_country_code = isset($_SERVER['GEOIP2_COUNTRY_CODE']) ? $_SERVER['GEOIP2_COUNTRY_CODE'] : 'za';
        }
        elseif( wp_remote_retrieve_response_code( $responseipinfo ) === 200 ){
            $body = wp_remote_retrieve_body( $responseipinfo );
            $bodyipinfo = json_decode($body);
            $main_country_code = $bodyipinfo->country;
        }

    }
    
}

?>