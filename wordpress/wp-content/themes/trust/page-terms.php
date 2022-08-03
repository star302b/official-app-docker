<?php
/*
 * Template Name: Terms Page
 */
if( get_global_option('theme_version') == 'v2') {
    get_header();
}else{
    get_header('v2');
}
?>
    <section class="default-page ">
        <div class="container">
            <div class="content-part">
                <?php echo acf_the_global_field('terms_&_conditions'); ?>
            </div>
        </div>

    </section>
<?php
get_footer();
