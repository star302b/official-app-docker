<?php
if($_GET['account_url'] && !is_user_logged_in()){
    setcookie("registered", $_GET['account_url'], time()+3600*24*365,'/');
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php wp_head(); ?>

    <link rel="canonical" href="<?php echo home_url(); ?>" />
    <?php
    // Color Picker Color
    $color_picker_color = get_field('theme_color','option');
    $color_picker_color_header = get_field('review_header_color','option');
    $color_picker_color_secondary = get_field('theme_color_second','option');
    $color_picker_color_third = get_field('theme_color_third','option');

    function adjustBrightness($hex, $steps) {
        // Steps should be between -255 and 255. Negative = darker, positive = lighter
        $steps = max(-255, min(255, $steps));

        // Normalize into a six character long hex string
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
        }

        // Split into three parts: R, G and B
        $color_parts = str_split($hex, 2);
        $return = '#';

        foreach ($color_parts as $color) {
            $color   = hexdec($color); // Convert to decimal
            $color   = max(0,min(255,$color + $steps)); // Adjust color
            $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
        }

        return $return;
    };

    function ak_convert_hex2rgba($color, $opacity = false) {
        $default = 'rgb(0,0,0)';

        if (empty($color))
            return $default;

        if ($color[0] == '#')
            $color = substr($color, 1);

        if (strlen($color) == 6)
            $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);

        elseif (strlen($color) == 3)
            $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);

        else
            return $default;

        $rgb = array_map('hexdec', $hex);

        if ($opacity) {
            if (abs($opacity) > 1)
                $opacity = 1.0;

            $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
        } else {
            $output = 'rgb(' . implode(",", $rgb) . ')';
        }
        return $output;
    }

    ?>


    <meta name="theme-color" content="<?php echo $color_picker_color; ?>">
    <style>
        .hidden {
            display:none;
        }
        .field-wrapper .error{
            color:red;
        }
        .mobile-visible-content table h3,
        .mobile-visible-content table h2{
            color: #fff;
        }
        .mobile-visible-content table {
            width: 100%;
        }
        .mobile-visible-content ul{
                    padding-left: 1rem;
                }
        .mobile-visible-content table {
            vertical-align: top;
            margin-bottom: 1rem;
        }
        .mobile-visible-content table tr:first-child td{
                        background: <?php echo $color_picker_color; ?>;
                        color: #fff;
                        padding: .5rem 1rem;
                    }
        .mobile-visible-content table ul{
                    margin: .5rem 0 0;
                }

        .site-header{
            border-bottom-color: <?php echo $color_picker_color; ?>;
            background: <?php echo $color_picker_color_header; ?>;
        }

        .show-more-content,
        .banner-features,
        .button{
            color:  <?php echo $color_picker_color; ?>;
        }
        .main-screen img {
            box-shadow: 0 9px 12px 0  <?php echo $color_picker_color; ?>;
        }

        .acc-header,
        .border-color-1:hover,
        .site-footer{
            background: <?php echo $color_picker_color; ?>;
        }

        .border-color-1{
            border-color: <?php echo $color_picker_color_third; ?>;
            background:  <?php echo $color_picker_color_third; ?>;
            color: #fff;
        }

        .border-color-1:hover{
            border-color: <?php echo adjustBrightness($color_picker_color_third, -50); ?>;
            background:  <?php echo adjustBrightness($color_picker_color_third, -50); ?>;
        }

        .rating svg path{
            fill:  <?php echo $color_picker_color; ?> !important;
        }

        .alternative-switch a,
        .form-title,
        .main-title{
            color: <?php echo $color_picker_color; ?>;
        }

        .testimonials-item .avatar img,
        .sign-area input{
            border-color: <?php echo $color_picker_color; ?>;
        }

        .mobile-scroll-nav{
            background: <?php echo $color_picker_color; ?>;

        }
        .highlight{
            background: <?php echo $color_picker_color_secondary; ?>;
            color: <?php echo $color_picker_color; ?>;
            padding: 0 10px;
        }
        .online-row .user-item:first-child{
            background: <?php echo $color_picker_color; ?>;
            line-height: 0;
        }

        .online-row svg{
            fill: <?php echo $color_picker_color; ?>;
        }

        .main-meta{
            color: <?php echo $color_picker_color; ?>;
        }

        .col-video{
            background: <?php echo $color_picker_color; ?>;
        }

        .col-form{
            border-color: <?php echo $color_picker_color; ?>;
        }

        .col-content .review-content a {
            color: <?php echo $color_picker_color; ?>;
            font-weight: bold;
        }
        .comment-item.top-member:after{
            background: <?php echo $color_picker_color; ?>;
        }

        .green{
            color: <?php echo $color_picker_color_third; ?>;
        }

        .orange{
            color: orange;
        }

        .red{
            color: red;
        }

        .strong-color{ color:  <?php echo $color_picker_color; ?>;}
        h2,h3{ color:  <?php echo $color_picker_color; ?>;}

        .crypto-item-container .crypto-item-cont-text .crypto-item-cont-text-name{ color:  <?php echo $color_picker_color; ?>;}

        .crypto-item-container .crypto-item-cont-text .up-change{
        color: <?php echo $color_picker_color_third; ?>;
        }

        .section-testimonials{
            background-color: <?php echo ak_convert_hex2rgba($color_picker_color_secondary, 0.2); ?>;
        }

        .coin-ticker{
            background-color: <?php echo ak_convert_hex2rgba($color_picker_color_secondary, 0.2); ?>;
        }
        @media screen and (max-width: 1024px) and ( min-width: 768px) {
            .content-section .container,
            .section-testimonials .container,
            .section-faq .container
            {
                max-width: 90%;
            }
        }

        @media screen and (max-width: 767px) {
            .header-menu .button{
                border: 1px solid <?php echo $color_picker_color; ?>;
            }
.header-menu { z-index: 10;}
        }

        /*_______________*/
        .show-more-content{
            background:  <?php echo $color_picker_color_secondary; ?> ;
        }
        .ci-avatar{
            background:  <?php echo $color_picker_color_secondary; ?> ;
            color: <?php echo $color_picker_color; ?>;
            box-shadow: 0 3px 12px 0 <?php echo $color_picker_color; ?>;
        }
        .sign-area .form-title,{
            background:  <?php echo $color_picker_color_third; ?> ;
            color: #fff;
        }

        .header-logo .logo-text{
            background:  <?php echo $color_picker_color; ?> ;
            color: #fff;
        }
        .crypto-item-container .crypto-item-cont-text .down-change {
            color: <?php echo $color_picker_color; ?>;
        }

        .review-header{
            background:  <?php echo $color_picker_color_secondary; ?> ;
        }
        @media screen and (max-width: 767px) {
            .header-menu{
                background: <?php echo $color_picker_color_secondary; ?>;
            }
            .mobile-visible-content{
                padding: 0 1rem;
                max-width: 100%;
            }
        }

        .online-row .user-item{
            color: <?php echo $color_picker_color; ?>;
        }

        .iti.iti--allow-dropdown{
            width: 100%;
        }

        .header-logo h1.logo-text{
            font-size: 1rem;
            margin: 0 0 0 10px;
        }
        @media screen and (max-width: 767px) {
            .header-logo h1.logo-text {
                font-size: .8rem;
            }
        }
    </style>
<?php if ( get_global_option('global_ga_id') ): ?>
    <!-- Global site tag (gtag.js) - Google Analytics --> 
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo get_global_option('global_ga_id'); ?>"></script> 
    <script> 
    window.dataLayer = window.dataLayer || []; 
    function gtag(){dataLayer.push(arguments);} 
    gtag('js', new Date()); 
    
    gtag('config', '<?php echo get_global_option('global_ga_id'); ?>'); 
    </script>
    <?php endif; ?>
</head>
<body>

<header class="site-header">
    <div class="container">
        <div class="d-flex f-j-b f-a-c f-w-w xs-c-r">
            <div class="header-logo d-flex f-a-c">
                <a href="<?php echo home_url(); ?>" class="d-flex f-a-e"  style="    align-items: center;"><img width="200" height="35" src="<?php the_field('logo','option'); ?>" alt="<?php the_field('funnel','option'); ?>"> <h1 class="logo-text"><?php _e('Official Website','trust'); ?></h1></a>
            </div>
            <?php if( is_front_page() ): ?>
                <ul class="header-menu">
                    <li><a href="#login" class="js--open-modal button button-white"><?php _e('Login','trust'); ?></a></li>
                    <li><a href="#register" class="js--open-modal button button-white border border-width-2 border-color-1"><?php _e('Register','trust'); ?></a></li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</header>

<?php
//if(get_main_site_id() == get_current_blog_id() ) {
    get_template_part('template-parts/header', 'coins');
//}
?>


<!--start main wrapper-->
<main id="main" class="main-wrapper js--scroll-sections">