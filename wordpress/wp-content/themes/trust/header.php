<?php
if($_GET['account_url'] && !is_user_logged_in()){
    setcookie("registered", $_GET['account_url'], time()+3600*24*365,'/');
}

if(get_current_blog_id() == 1 && !is_user_logged_in()){
    die();
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
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

    ?>


    <meta name="theme-color" content="<?php echo $color_picker_color; ?>">
    <style>
        .error{
            color: red;
        }
.hidden{
    display: none;
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

        @media screen and (max-width: 767px) {
            .header-menu .button{
                border: 1px solid <?php echo $color_picker_color; ?>;
            }
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
        .sign-area .form-title,
        .header-logo .logo-text{
            background:  <?php echo $color_picker_color_third; ?> ;
            color: #fff;
        }
        .review-header{
            background:  <?php echo $color_picker_color_secondary; ?> ;
        }
        @media screen and (max-width: 767px) {
            .header-menu{
                background: <?php echo $color_picker_color_secondary; ?>;
            }
        }

        .online-row .user-item{
            color: <?php echo $color_picker_color; ?>;
        }
        .comment-item.top-member:after{
            content: '<?php _e('Top Review','trust'); ?>';
        }
        .comment-item.new-member:after{
            content: '<?php _e('New Member','trust'); ?>';
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
                <a href="<?php echo home_url(); ?>" class="d-flex f-a-e" style="    align-items: center;"><img width="200" height="35" src="<?php the_field('logo','option'); ?>" alt="<?php the_field('funnel','option'); ?>"> <h1 class="logo-text"><?php _e('Official Community','trust'); ?></h1></a>
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


<!--start main wrapper-->
<main id="main" class="main-wrapper js--scroll-sections">