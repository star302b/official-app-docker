<?php
function cl_acf_set_de_language() {
    return 'de';
}

function translate_specific_field($content, $target_language){
    require_once 'vendor/autoload.php';

    $authKey = '62a59171-685f-fc1a-5cc4-59e33baaa44e';
    $deepl   = new BabyMarkt\DeepL\DeepL($authKey,2,'api.deepl.com');
    if($content) {
        $translated_content = '';
        $content = str_replace(array('[XYZ]','[XYZ ]'),'XYZ',$content);
        $content = str_replace('[XYZY]','<f>[XYZY]</f>',$content);
        $content = str_replace('<h3>','<f><h3></f>',$content);
        $content = str_replace('<h2>','<f><h2></f>',$content);
        $content = str_replace('</h2>','<f></h2></f>',$content);
        $content = str_replace('</h3>','<f></h3></f>',$content);

        $translatedExcerptdeepl = $deepl->translate($content, 'en', $target_language, 'xml', array('f'));
        $translated_content = str_replace(array('<f>','</f>'),'',$translatedExcerptdeepl[0]['text'] . PHP_EOL);
        $translated_content = str_replace('XYZ','[XYZ]',$translated_content);
        return $translated_content;
    }
    return '';
}

add_action('acfe/fields/button/name=global_translate', 'my_acf_button_ajax', 10, 2);
function my_acf_button_ajax($field, $post_id){
    global $sitepress;
    remove_all_shortcodes();

    add_filter('acf/settings/current_language', function () {
        return 'en';
    }, 100);

    $banner_title = get_field('banner_title','option');
    $banner_description = get_field('banner_description','option');
    $banner_form_heading = get_field('banner_form_heading','option');
    $short_y_title = get_field('short_y_title','option');
    $short_y_description = get_field('short_y_description','option');
    $body_title = get_field('body_title','option');
    $body_content = get_field('body_content','option');
    $short_x_title = get_field('short_x_title','option');
    $short_x_description = get_field('short_x_description','option');
    $faq_title = get_field('faq_title','option');
    $faq_description = get_field('faq_description','option');
    $faq_q_and_a = get_field('faq_q_and_a','option'); // question answer

    $features_title = get_field('features_title','option');
    $features_description = get_field('features_description','option');
    $features_features = get_field('features_features','option'); // title description
    $steps_title = get_field('steps_title','option');
    $steps_description = get_field('steps_description','option');

    $step_1_title = get_field('step_1_title','option');
    $step_1_description = get_field('step_1_description','option');
    $step_2_title = get_field('step_2_title','option');
    $step_2_description = get_field('step_2_description','option');
    $step_3_title = get_field('step_3_title','option');
    $step_3_description = get_field('step_3_description','option');
    $testimonials_title = get_field('testimonials_title','option');
    $testimonials_description = get_field('testimonials_description','option');

    try {
        $languages = icl_get_languages();


        foreach ($languages as $l_item) {
            if ($l_item["tag"] != "en") {
                $new_language = $l_item["tag"];
                add_filter('acf/settings/current_language', function () use ($new_language) {
                    return $new_language;
                }, 100);


                // if(!get_field('banner_title','option')){
                    update_field('banner_title', translate_specific_field($banner_title, $new_language), 'option');
                    update_field('banner_description', translate_specific_field($banner_description, $new_language), 'option');
                    update_field('banner_form_heading', translate_specific_field($banner_form_heading, $new_language), 'option');
                    update_field('short_y_title', translate_specific_field($short_y_title, $new_language), 'option');
                    update_field('short_y_description', translate_specific_field($short_y_description, $new_language), 'option');
                    update_field('body_title', translate_specific_field($body_title, $new_language), 'option');
                    update_field('body_content', translate_specific_field($body_content, $new_language), 'option');
                    update_field('short_x_title', translate_specific_field($short_x_title, $new_language), 'option');
                    update_field('short_x_description', translate_specific_field($short_x_description, $new_language), 'option');
                    update_field('faq_title', translate_specific_field($faq_title, $new_language), 'option');
                    update_field('faq_description', translate_specific_field($faq_description, $new_language), 'option');
                    update_field('features_title', translate_specific_field($features_title, $new_language), 'option');
                    update_field('features_description', translate_specific_field($features_description, $new_language), 'option');
                    update_field('steps_title', translate_specific_field($steps_title, $new_language), 'option');
                    update_field('steps_description', translate_specific_field($steps_description, $new_language), 'option');
                    update_field('step_1_title', translate_specific_field($step_1_title, $new_language), 'option');
                    update_field('step_2_title', translate_specific_field($step_2_title, $new_language), 'option');
                    update_field('step_3_title', translate_specific_field($step_3_title, $new_language), 'option');
                    update_field('step_1_description', translate_specific_field($step_1_description, $new_language), 'option');
                    update_field('step_2_description', translate_specific_field($step_2_description, $new_language), 'option');
                    update_field('step_3_description', translate_specific_field($step_3_description, $new_language), 'option');
                    update_field('testimonials_title', translate_specific_field($testimonials_title, $new_language), 'option');
                    update_field('testimonials_description', translate_specific_field($testimonials_description, $new_language), 'option');

                    foreach ($faq_q_and_a as $q_and_a_key => $q_and_a) {
                        $key_new = (int)$q_and_a_key + 1;
                        $row_data = array(
                            'question' => $q_and_a['question'] ? translate_specific_field($q_and_a['question'], $new_language) : '',
                            'answer' => $q_and_a['answer'] ? translate_specific_field($q_and_a['answer'], $new_language) : ''
                        );
                        update_row('faq_q_and_a', $key_new, $row_data, 'option');
                    }

                    foreach ($features_features as $features_feature_key => $features_feature) {
                        $key_new = (int)$features_feature_key + 1;
                        $row_data = array(
                            'title' => $features_feature['title'] ? translate_specific_field($features_feature['title'], $new_language) : '',
                            'description' => $features_feature['description'] ? translate_specific_field($features_feature['description'], $new_language) : ''
                        );
                        update_row('features_features', $key_new, $row_data, 'option');

                    }
                // }
            }
        }
    }catch (Exception $error){
        wp_send_json_error($error);
    }

    // send json success message
    wp_send_json_success("Success!");
}

function my_acf_input_admin_footer() {

    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript">
        acf.addAction('acfe/fields/button/before/name=global_translate', function($el, data){
            $el.find('button').html('<i class="fa fa-spinner fa-spin"></i> Translating').attr('disabled', true);
        });

        acf.addAction('acfe/fields/button/complete/name=global_translate', function(response, $el, data){
            $el.find('button').html('Translated');
        });
    </script>
    <?php

}

add_action('acf/input/admin_footer', 'my_acf_input_admin_footer');