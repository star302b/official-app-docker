<div id="registerform" >
    
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
               value="<?php echo(isset($_SERVER['GEOIP2_COUNTRY_CODE']) ? $_SERVER['GEOIP2_COUNTRY_CODE'] : 'za'); ?>"/>
        <input type="hidden" id="ip_address2"
               value="<?php echo(isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR']); ?>"/>
        <input type="hidden" id="fulfilment_id2"
               value=""/>
        <input type="hidden" id="custom_12" name="custom_1" value="<?php echo $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : 'seo'; ?>"/>

        <div class="input-row text-center" style="position:relative;">
            <div class="ajax-loader-gif" style="width: 40px; display: none; position: absolute;left: 15px;top: 50%;transform: translateY(-50%);">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/ajax-loader-table.gif?v1" style="    max-height: 35px;"></div>
            <button style="    width: 100%;" class="button  button-primary" type="submit"><?php _e('Register for Free','trust'); ?></button>
        </div>
    </form>
    <div class="form-bottom">
        <p><?php echo acf_the_global_field('register_bottom_text');?></p>
        
    </div>
    <div class="modal-safe flex-xs-row flex-align-center flex-justify-between">
    <img src="<?php echo get_template_directory_uri() . '/assets/img/bitgo.png'; ?>">
                <img src="<?php echo get_template_directory_uri() . '/assets/img/norton.png'; ?>">
                <img src="<?php echo get_template_directory_uri() . '/assets/img/mcafee.png'; ?>">
            </div>
</div>