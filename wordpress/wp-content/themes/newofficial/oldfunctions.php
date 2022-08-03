<?php
add_action( 'after_setup_theme', function(){
	load_theme_textdomain( 'trust', get_template_directory() . '/languages' );
});


function get_language_strings() {
    $strings = array(
        'first_name_validation' => __( 'Enter in a first name.', 'funnel-form' ),
        'last_name_validation' => __( 'Enter in a last name.', 'funnel-form' ),
        'email_validation' => __( 'Enter in a valid email address.', 'funnel-form' ),
        'phone_number_validation' => __( 'Enter in a valid phone number.', 'funnel-form' ),
    );

    return $strings;
}

add_action( 'wp_enqueue_scripts', 'trust_scripts' );

define( 'IMAGE_URL' , get_template_directory_uri() . '/assets/' );

function trust_scripts() {

    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/style.min.css', array(), null);

    wp_enqueue_style('funnel-form-tel', get_template_directory_uri() . '/assets/css/tel.css', array(), null);
    wp_enqueue_script( 'main-scripts', get_template_directory_uri() . '/assets/js/main.min.js', array(), null, true );
    wp_enqueue_script('jquery') ;
    wp_enqueue_script( 'funnel-form', get_template_directory_uri() . '/assets/js/funnel-form.js', array(), null, true );
    wp_localize_script( 'funnel-form', 'my_var_prefix', get_language_strings() );

    wp_enqueue_script('funnel-form-plugins', get_template_directory_uri() . '/assets/js/plugins.js', array('jquery'), null, true);
    wp_localize_script('funnel-form', 'ff_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}

// Register Custom Post Type
function review_post_type()
{

    $labels = array(
        'name' => _x('Reviews', 'Post Type General Name', 'text_domain'),
        'singular_name' => _x('Review', 'Post Type Singular Name', 'text_domain'),
        'menu_name' => __('Reviews', 'text_domain'),
        'name_admin_bar' => __('Review', 'text_domain'),
        'archives' => __('Review Archives', 'text_domain'),
        'attributes' => __('Review Attributes', 'text_domain'),
        'parent_item_colon' => __('Parent Review:', 'text_domain'),
        'all_items' => __('All Reviews', 'text_domain'),
        'add_new_item' => __('Add New Review', 'text_domain'),
        'add_new' => __('Add New', 'text_domain'),
        'new_item' => __('New Review', 'text_domain'),
        'edit_item' => __('Edit Review', 'text_domain'),
        'update_item' => __('Update Review', 'text_domain'),
        'view_item' => __('View Review', 'text_domain'),
        'view_items' => __('View Reviews', 'text_domain'),
        'search_items' => __('Search Review', 'text_domain'),
        'not_found' => __('Not found', 'text_domain'),
        'not_found_in_trash' => __('Not found in Trash', 'text_domain'),
        'featured_image' => __('Featured Image', 'text_domain'),
        'set_featured_image' => __('Set featured image', 'text_domain'),
        'remove_featured_image' => __('Remove featured image', 'text_domain'),
        'use_featured_image' => __('Use as featured image', 'text_domain'),
        'insert_into_item' => __('Insert into item', 'text_domain'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'text_domain'),
        'items_list' => __('Reviews list', 'text_domain'),
        'items_list_navigation' => __('Reviews list navigation', 'text_domain'),
        'filter_items_list' => __('Filter Reviews list', 'text_domain'),
    );
    $args = array(
        'label' => __('Review', 'text_domain'),
        'description' => __('Review Description', 'text_domain'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'page-attributes'),
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'rewrite' => false,
        'capability_type' => 'post',
    );
    register_post_type('review', $args);

}

add_action('init', 'review_post_type', 0);

if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Site Content',
        'menu_title'	=> 'Site Content',
        'parent_slug'	=> 'theme-general-settings',
    ));

    if(get_current_blog_id() == 1){
        acf_add_options_sub_page(array(
            'page_title' 	=> 'Global Sites Settings',
            'menu_title'	=> 'Global Sites Settings',
            'parent_slug'	=> 'theme-general-settings',
        ));
    }
}


function hide_siteadmin()
{

    $user = wp_get_current_user();
    $allowed_roles = array('author');
// Use this for specific user role. Change site_admin part accordingly
    if (array_intersect($allowed_roles, $user->roles)) {
        /* DASHBOARD */
        // remove_menu_page( 'index.php' ); // Dashboard + submenus
//         remove_menu_page( 'about.php' ); // WordPress menu
        remove_submenu_page('index.php', 'update-core.php');  // Update

        /* REMOVE DEFAULT MENUS */
        remove_menu_page('edit-comments.php'); //Comments
        remove_menu_page('plugins.php'); //Plugins
        remove_menu_page('tools.php'); //Tools
        remove_menu_page('users.php'); //Users
//        remove_menu_page('edit.php'); //Posts
         remove_menu_page( 'upload.php' ); //Media
        remove_menu_page('edit.php?post_type=page'); // Pages
        remove_menu_page('theme-general-settings');
        // remove_menu_page( 'themes.php' ); // Appearance
        // remove_menu_page( 'options-general.php' ); //Settings
    }
}

add_action('admin_head', 'hide_siteadmin');

function acf_load_funnel_field_choices($field)
{
    $field['choices'] = array();

    $choices = '[{"funnel_name":"Bitcoin Aussie System","funnel_code":"Bitcoin Aussie System","funnel_image":"bitcoin-aussie-system-logo.png","funnel_badge_rating":"91","fulfilment_id":""},{"funnel_name":"Bitcoin Bank","funnel_code":"Bitcoin Bank","funnel_image":"bitcoin-bank-logo.png","funnel_badge_rating":"93","fulfilment_id":""},{"funnel_name":"Bitcoin Billionaire","funnel_code":"Bitcoin Billionaire","funnel_image":"bitcoin-billionaire-logo.png","funnel_badge_rating":"92","fulfilment_id":""},{"funnel_name":"Bitcoin Blueprint","funnel_code":"Bitcoin Blueprint","funnel_image":"bitcoin-blueprint-logo.png","funnel_badge_rating":"96","fulfilment_id":""},{"funnel_name":"Bitcoin Bonanza","funnel_code":"Bitcoin Bonanza","funnel_image":"bitcoin-bonanza-logo.png","funnel_badge_rating":"94","fulfilment_id":""},{"funnel_name":"Bitcoin Boom","funnel_code":"Bitcoin Boom","funnel_image":"bitcoin-boom-logo.png","funnel_badge_rating":"90","fulfilment_id":""},{"funnel_name":"Bitcoin Circuit","funnel_code":"Bitcoin Circuit","funnel_image":"bitcoin-circuit-logo.png","funnel_badge_rating":"97","fulfilment_id":""},{"funnel_name":"Bitcoin Champion","funnel_code":"Bitcoin Champion","funnel_image":"bitcoin-champion-logo.jpg","funnel_badge_rating":"94","fulfilment_id":""},{"funnel_name":"Bitcoin Code","funnel_code":"Bitcoin Code","funnel_image":"bitcoin-code-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Bitcoin Compass","funnel_code":"Bitcoin Compass","funnel_image":"bitcoin-compass-logo.png","funnel_badge_rating":"91","fulfilment_id":""},{"funnel_name":"Bitcoin Digital","funnel_code":"Bitcoin Digital","funnel_image":"bitcoin-digital-logo.png","funnel_badge_rating":"93","fulfilment_id":""},{"funnel_name":"Bitcoin Equaliser","funnel_code":"Bitcoin Equaliser","funnel_image":"bitcoin-equaliser-logo.png","funnel_badge_rating":"92","fulfilment_id":""},{"funnel_name":"Bitcoin Era","funnel_code":"Bitcoin Era","funnel_image":"bitcoin-era-logo.png","funnel_badge_rating":"96","fulfilment_id":""},{"funnel_name":"Bitcoin Evolution","funnel_code":"Bitcoin Evolution","funnel_image":"bitcoin-evolution-logo.png","funnel_badge_rating":"94","fulfilment_id":""},{"funnel_name":"Bitcoin Fast Profit","funnel_code":"Bitcoin Fast Profit","funnel_image":"bitcoin-fast-profit-logo.png","funnel_badge_rating":"90","fulfilment_id":""},{"funnel_name":"Bitcoin Formula","funnel_code":"Bitcoin Formula","funnel_image":"bitcoin-formula-logo.png","funnel_badge_rating":"97","fulfilment_id":""},{"funnel_name":"Bitcoin Fortune","funnel_code":"Bitcoin Fortune","funnel_image":"bitcoin-fortune-logo.png","funnel_badge_rating":"90","fulfilment_id":""},{"funnel_name":"Bitcoin Future","funnel_code":"Bitcoin Future","funnel_image":"bitcoin-future-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Bitcoin Gemini","funnel_code":"Bitcoin Gemini","funnel_image":"bitcoin-gemini-logo.png","funnel_badge_rating":"91","fulfilment_id":""},{"funnel_name":"Bitcoin Hero","funnel_code":"Bitcoin Hero","funnel_image":"bitcoin-hero-logo.png","funnel_badge_rating":"93","fulfilment_id":""},{"funnel_name":"Bitcoin Investor","funnel_code":"Bitcoin Investor","funnel_image":"bitcoin-investor-logo.jpg","funnel_badge_rating":"92","fulfilment_id":""},{"funnel_name":"Bitcoin Legacy","funnel_code":"Bitcoin Legacy","funnel_image":"bitcoin-legacy-logo.png","funnel_badge_rating":"96","fulfilment_id":""},{"funnel_name":"Bitcoin Lifestyle","funnel_code":"Bitcoin Lifestyle","funnel_image":"bitcoin-lifestyle-logo.png","funnel_badge_rating":"94","fulfilment_id":""},{"funnel_name":"Bitcoin Loophole","funnel_code":"Bitcoin Loophole","funnel_image":"bitcoin-loophole-logo.png","funnel_badge_rating":"90","fulfilment_id":""},{"funnel_name":"Bitcoin Machine","funnel_code":"Bitcoin Machine","funnel_image":"bitcoin-machine-logo.png","funnel_badge_rating":"97","fulfilment_id":""},{"funnel_name":"Bitcoin Method","funnel_code":"Bitcoin Method","funnel_image":"bitcoin-method-logo.jpg","funnel_badge_rating":"90","fulfilment_id":""},{"funnel_name":"Bitcoin Millionaire","funnel_code":"Bitcoin Millionaire","funnel_image":"bitcoin-millionaire-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Bitcoin Miner","funnel_code":"Bitcoin Miner","funnel_image":"bitcoin-miner-logo.png","funnel_badge_rating":"91","fulfilment_id":""},{"funnel_name":"Bitcoin Money","funnel_code":"Bitcoin Money","funnel_image":"bitcoin-money-logo.png","funnel_badge_rating":"93","fulfilment_id":""},{"funnel_name":"Bitcoin News Trader","funnel_code":"Bitcoin News Trader","funnel_image":"bitcoin-news-trader-logo.png","funnel_badge_rating":"92","fulfilment_id":""},{"funnel_name":"Bitcoin Optimiser","funnel_code":"Bitcoin Optimiser","funnel_image":"bitcoin-optimiser-logo.png","funnel_badge_rating":"96","fulfilment_id":""},{"funnel_name":"Bitcoin Prime","funnel_code":"Bitcoin Prime","funnel_image":"bitcoin-prime-logo.png","funnel_badge_rating":"94","fulfilment_id":""},{"funnel_name":"Bitcoin Pro","funnel_code":"Bitcoin Pro","funnel_image":"bitcoin-pro-logo.png","funnel_badge_rating":"90","fulfilment_id":""},{"funnel_name":"Bitcoin Rejoin","funnel_code":"Bitcoin Rejoin","funnel_image":"bitcoin-rejoin-logo.png","funnel_badge_rating":"97","fulfilment_id":""},{"funnel_name":"Bitcoin Revival","funnel_code":"Bitcoin Revival","funnel_image":"bitcoin-revival-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Bitcoin Revolution","funnel_code":"Bitcoin Revolution","funnel_image":"bitcoin-revolution-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Bitcoin Rush","funnel_code":"Bitcoin Rush","funnel_image":"bitcoin-rush-logo.png","funnel_badge_rating":"91","fulfilment_id":""},{"funnel_name":"Bitcoin Secret","funnel_code":"Bitcoin Secret","funnel_image":"bitcoin-secret-logo.png","funnel_badge_rating":"93","fulfilment_id":""},{"funnel_name":"Bitcoin Storm","funnel_code":"Bitcoin Storm","funnel_image":"bitcoin-storm-logo.png","funnel_badge_rating":"92","fulfilment_id":""},{"funnel_name":"Bitcoin Sunrise","funnel_code":"Bitcoin Sunrise","funnel_image":"bitcoin-sunrise-logo.png","funnel_badge_rating":"96","fulfilment_id":""},{"funnel_name":"Bitcoin Supersplit","funnel_code":"Bitcoin Supersplit","funnel_image":"bitcoin-supersplit-logo.png","funnel_badge_rating":"94","fulfilment_id":""},{"funnel_name":"Bitcoin Superstar","funnel_code":"Bitcoin Superstar","funnel_image":"bitcoin-superstar-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Crypto Superstar","funnel_code":"Crypto Superstar","funnel_image":"bitcoin-superstar-logo.png","funnel_badge_rating":"97","fulfilment_id":""},{"funnel_name":"Bitcoin Supreme","funnel_code":"Bitcoin Supreme","funnel_image":"bitcoin-supreme-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Bitcoin System","funnel_code":"Bitcoin System","funnel_image":"bitcoin-system-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Bitcoin Trade Robot","funnel_code":"Bitcoin Trade Robot","funnel_image":"bitcoin-trade-robot-logo.png","funnel_badge_rating":"91","fulfilment_id":""},{"funnel_name":"Bitcoin Trader","funnel_code":"Bitcoin Trader","funnel_image":"bitcoin-trader-logo.png","funnel_badge_rating":"93","fulfilment_id":""},{"funnel_name":"Bitcoin Trend App","funnel_code":"Bitcoin Trend App","funnel_image":"bitcoin-trend-app-logo.png","funnel_badge_rating":"92","fulfilment_id":""},{"funnel_name":"Bitcoin Union","funnel_code":"Bitcoin Union","funnel_image":"bitcoin-union-logo.png","funnel_badge_rating":"96","fulfilment_id":""},{"funnel_name":"Bitcoin Up","funnel_code":"Bitcoin Up","funnel_image":"bitcoin-up-logo.png","funnel_badge_rating":"94","fulfilment_id":""},{"funnel_name":"Bitcoin Victory","funnel_code":"Bitcoin Victory","funnel_image":"bitcoin-victory-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Bitcoin Wealth","funnel_code":"Bitcoin Wealth","funnel_image":"bitcoin-wealth-logo.png","funnel_badge_rating":"97","fulfilment_id":""},{"funnel_name":"Bitcoin Profit","funnel_code":"Bitcoin Profit","funnel_image":"bitcoin-profit-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"BitQT","funnel_code":"BitQT","funnel_image":"bitqt-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"BitQH","funnel_code":"BitQH","funnel_image":"bitqh-logo.jpg","funnel_badge_rating":"91","fulfilment_id":""},{"funnel_name":"BTC Robot","funnel_code":"BTC Robot","funnel_image":"btc-robot-logo.png","funnel_badge_rating":"93","fulfilment_id":""},{"funnel_name":"Corona Millionaire","funnel_code":"Corona Millionaire","funnel_image":"corona-millionaire-logo.png","funnel_badge_rating":"92","fulfilment_id":""},{"funnel_name":"Crypto Bank","funnel_code":"Crypto Bank","funnel_image":"crypto-bank-logo.png","funnel_badge_rating":"96","fulfilment_id":""},{"funnel_name":"Crypto Bull","funnel_code":"Crypto Bull","funnel_image":"crypto-bull-logo.png","funnel_badge_rating":"94","fulfilment_id":""},{"funnel_name":"Crypto Cash","funnel_code":"Crypto Cash","funnel_image":"crypto-cash-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Crypto Code","funnel_code":"Crypto Code","funnel_image":"crypto-code-logo.png","funnel_badge_rating":"97","fulfilment_id":""},{"funnel_name":"Crypto Comeback Pro","funnel_code":"Crypto Comeback Pro","funnel_image":"crypto-comeback-pro-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Crypto Engine","funnel_code":"Crypto Engine","funnel_image":"crypto-engine-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Crypto Genius","funnel_code":"Crypto Genius","funnel_image":"crypto-genius-logo.png","funnel_badge_rating":"91","fulfilment_id":""},
    {"funnel_name":"Crypto Hopper","funnel_code":"Crypto Hopper","funnel_image":"crypto-hopper-logo.png","funnel_badge_rating":"93","fulfilment_id":""},{"funnel_name":"Crypto Legacy Pro","funnel_code":"Crypto Legacy Pro","funnel_image":"crypto-legacy-logo.png","funnel_badge_rating":"92","fulfilment_id":""},{"funnel_name":"Crypto Method","funnel_code":"Crypto Method","funnel_image":"crypto-method-logo.png","funnel_badge_rating":"96","fulfilment_id":""},{"funnel_name":"Crypto Nation Pro","funnel_code":"Crypto Nation Pro","funnel_image":"crypto-nation-pro-logo.png","funnel_badge_rating":"94","fulfilment_id":""},{"funnel_name":"Crypto Revolt","funnel_code":"Crypto Revolt","funnel_image":"crypto-revolt-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Crypto Trader","funnel_code":"Crypto Trader","funnel_image":"crypto-trader-logo.jpg","funnel_badge_rating":"97","fulfilment_id":""},{"funnel_name":"Crypto VIP Club","funnel_code":"Crypto VIP Club","funnel_image":"crypto-vip-club-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Cryptosoft","funnel_code":"Cryptosoft","funnel_image":"cryptosoft-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Cryptowealth","funnel_code":"Cryptowealth","funnel_image":"cryptowealth-logo.png","funnel_badge_rating":"91","fulfilment_id":""},{"funnel_name":"Ethereum Code","funnel_code":"Ethereum Code","funnel_image":"ethereum-code-logo.png","funnel_badge_rating":"93","fulfilment_id":""},{"funnel_name":"Immediate Edge","funnel_code":"Immediate Edge","funnel_image":"immediate-edge-logo.png","funnel_badge_rating":"97","fulfilment_id":""},{"funnel_name":"Libra Maximizer","funnel_code":"Libra Maximizer","funnel_image":"libra-maximizer-logo.png","funnel_badge_rating":"96","fulfilment_id":""},{"funnel_name":"Libra Method","funnel_code":"Libra Method","funnel_image":"libra-method-logo.png","funnel_badge_rating":"94","fulfilment_id":""},{"funnel_name":"Libra Profit","funnel_code":"Libra Profit","funnel_image":"libra-profit-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"One Bitcoin A Day","funnel_code":"One Bitcoin A Day","funnel_image":"one-bitcoin-a-day-logo.png","funnel_badge_rating":"97","fulfilment_id":""},{"funnel_name":"Quantum Code","funnel_code":"Quantum Code","funnel_image":"quantum-code-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Ripple Code","funnel_code":"Ripple Code","funnel_image":"ripple-code-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"The News Spy","funnel_code":"The News Spy","funnel_image":"the-news-spy-logo.png","funnel_badge_rating":"91","fulfilment_id":""},{"funnel_name":"BitSignal","funnel_code":"BitSignal","funnel_image":"bitsignal-logo.jpg","funnel_badge_rating":"93","fulfilment_id":""},{"funnel_name":"Bitcoin Benefit","funnel_code":"Bitcoin Benefit","funnel_image":"bitcoin-benefit-logo.png","funnel_badge_rating":"92","fulfilment_id":""},{"funnel_name":"Bitcoin Cycle","funnel_code":"Bitcoin Cycle","funnel_image":"bitcoin-cycle-logo.png","funnel_badge_rating":"96","fulfilment_id":""},{"funnel_name":"Bitcoin Freedom","funnel_code":"Bitcoin Freedom","funnel_image":"bitcoin-freedom-logo.png","funnel_badge_rating":"94","fulfilment_id":""},{"funnel_name":"Bitcoin Power","funnel_code":"Bitcoin Power","funnel_image":"bitcoin-power-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"BitQL","funnel_code":"BitQL","funnel_image":"bitql-logo.png","funnel_badge_rating":"97","fulfilment_id":""},{"funnel_name":"BitQS","funnel_code":"BitQS","funnel_image":"bitqs-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"BitPremium","funnel_code":"BitPremium","funnel_image":"bitpremium-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Brexit Trader","funnel_code":"Brexit Trader","funnel_image":"brexit-trader-logo.png","funnel_badge_rating":"91","fulfilment_id":""},{"funnel_name":"British Bitcoin Profit","funnel_code":"British Bitcoin Profit","funnel_image":"british-bitcoin-profit-logo.png","funnel_badge_rating":"93","fulfilment_id":""},{"funnel_name":"Crypt EX","funnel_code":"Crypt EX","funnel_image":"crypt-ex-logo.png","funnel_badge_rating":"92","fulfilment_id":""},{"funnel_name":"Crypto Contracts","funnel_code":"Crypto Contracts","funnel_image":"crypto-contracts-logo.png","funnel_badge_rating":"96","fulfilment_id":""},{"funnel_name":"Crypto Group","funnel_code":"Crypto Group","funnel_image":"crypto-group-logo.png","funnel_badge_rating":"94","fulfilment_id":""},{"funnel_name":"Crypto Profit","funnel_code":"Crypto Profit","funnel_image":"crypto-profit.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Finnish Formula","funnel_code":"Finnish Formula","funnel_image":"finnish-formula-logo.png","funnel_badge_rating":"97","fulfilment_id":""},{"funnel_name":"Immediate Profit","funnel_code":"Immediate Profit","funnel_image":"immediate-profit-logo.png","funnel_badge_rating":"98","fulfilment_id":""},{"funnel_name":"Prime Advantage","funnel_code":"Prime Advantage","funnel_image":"prime-advantage-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Profit Revolution","funnel_code":"Profit Revolution","funnel_image":"profit-revolution-logo.png","funnel_badge_rating":"91","fulfilment_id":""},{"funnel_name":"Profit Secret","funnel_code":"Profit Secret","funnel_image":"profit-secret-logo.png","funnel_badge_rating":"93","fulfilment_id":""},{"funnel_name":"Quantum Trading","funnel_code":"Quantum Trading","funnel_image":"quantum-trading-logo.png","funnel_badge_rating":"92","fulfilment_id":""},{"funnel_name":"Singapore Formula","funnel_code":"Singapore Formula","funnel_image":"singapore-formula-logo.png","funnel_badge_rating":"96","fulfilment_id":""},{"funnel_name":"Stellar Profit","funnel_code":"Stellar Profit","funnel_image":"stellar-profit-logo.png","funnel_badge_rating":"94","fulfilment_id":""},{"funnel_name":"Stock Method","funnel_code":"Stock Method","funnel_image":"stock-method-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Wealth Matrix","funnel_code":"Wealth Matrix","funnel_image":"wealth-matrix-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Big Money Rush","funnel_code":"Big Money Rush","funnel_image":"big-money-rush-logo.png","funnel_badge_rating":"91","fulfilment_id":""},{"funnel_name":"BitTrader","funnel_code":"BitTrader","funnel_image":"bittrader-logo.png","funnel_badge_rating":"93","fulfilment_id":""},{"funnel_name":"Bitcoin Capital","funnel_code":"Bitcoin Capital","funnel_image":"bitcoin-capital-logo.png","funnel_badge_rating":"97","fulfilment_id":""},{"funnel_name":"Immediate Bitcoin","funnel_code":"Immediate Bitcoin","funnel_image":"immediate-bitcoin-logo.png","funnel_badge_rating":"96","fulfilment_id":""},{"funnel_name":"Cannabis Millionaire","funnel_code":"Cannabis Millionaire","funnel_image":"cannabis-millionaire-logo.png","funnel_badge_rating":"94","fulfilment_id":""},{"funnel_name":"CFD Era","funnel_code":"CFD Era","funnel_image":"cfd-era-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Golden Profit","funnel_code":"Golden Profit","funnel_image":"golden-profit-logo.png","funnel_badge_rating":"97","fulfilment_id":""},{"funnel_name":"Dubai Lifestyle","funnel_code":"Dubai Lifestyle","funnel_image":"dubai-lifestyle-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"1K Daily Profit","funnel_code":"1K Daily Profit","funnel_image":"1k-daily-profit-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Anon System","funnel_code":"Anon System","funnel_image":"anon-system-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"AI Stock Profits","funnel_code":"AI Stock Profits","funnel_image":"ai-stock-profits-logo.png","funnel_badge_rating":"91","fulfilment_id":""},{"funnel_name":"Algo Signals","funnel_code":"Algo Signals","funnel_image":"algo-signals-logo.png","funnel_badge_rating":"93","fulfilment_id":""},{"funnel_name":"Weed Millionaire","funnel_code":"Weed Millionaire","funnel_image":"weed-millionaire-logo.png","funnel_badge_rating":"97","fulfilment_id":""},{"funnel_name":"Weed Profit System","funnel_code":"Weed Profit System","funnel_image":"weed-profit-system-logo.png","funnel_badge_rating":"96","fulfilment_id":""},{"funnel_name":"Oil Profit","funnel_code":"Oil Profit","funnel_image":"oil-profit-logo.png","funnel_badge_rating":"94","fulfilment_id":""},{"funnel_name":"Cannabis Wealth","funnel_code":"Cannabis Wealth","funnel_image":"cannabis-wealth-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Cannabis Revolution","funnel_code":"Cannabis Revolution","funnel_image":"cannabis-revolution-logo.png","funnel_badge_rating":"97","fulfilment_id":""},{"funnel_name":"Cannabis Trader","funnel_code":"Cannabis Trader","funnel_image":"cannabis-trader-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Dubai Profit Now","funnel_code":"Dubai Profit Now","funnel_image":"dubai-profit-now-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"CFD Trader","funnel_code":"CFD Trader","funnel_image":"cfd-trader-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"24option","funnel_code":"24option","funnel_image":"24option-logo.png","funnel_badge_rating":"95","fulfilment_id":"60"},{"funnel_name":"eToro","funnel_code":"eToro","funnel_image":"etoro-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Plus500","funnel_code":"Plus500","funnel_image":"plus500-logo.png","funnel_badge_rating":"91","fulfilment_id":""},{"funnel_name":"FXTB","funnel_code":"FXTB","funnel_image":"fxtb-logo.png","funnel_badge_rating":"93","fulfilment_id":"109"},{"funnel_name":"101Investing","funnel_code":"101Investing","funnel_image":"101investing-logo.png","funnel_badge_rating":"97","fulfilment_id":"65"},
    {"funnel_name":"EuropeFX","funnel_code":"EuropeFX","funnel_image":"europefx-logo.png","funnel_badge_rating":"96","fulfilment_id":"52"},{"funnel_name":"FXVC","funnel_code":"FXVC","funnel_image":"fxvc-logo.png","funnel_badge_rating":"94","fulfilment_id":""},
    {"funnel_name":"Alvexo","funnel_code":"Alvexo","funnel_image":"alvexo-logo.png","funnel_badge_rating":"95","fulfilment_id":"68"},{"funnel_name":"UFX","funnel_code":"UFX","funnel_image":"ufx-logo.png","funnel_badge_rating":"97","fulfilment_id":"49"},
    {"funnel_name":"Exness","funnel_code":"Exness","funnel_image":"exness-logo.png","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Trade360","funnel_code":"Trade360","funnel_image":"trade360-logo.png","funnel_badge_rating":"95","fulfilment_id":"70"},
    {"funnel_name":"Código del Caballero","funnel_code":"Código del Caballero","funnel_image":"codigo-logo.jpg","funnel_badge_rating":"91","fulfilment_id":""},
    {"funnel_name":"Crypto Legacy","funnel_code":"Crypto Legacy","funnel_image":"crypto-legacy-logo.jpg","funnel_badge_rating":"93","fulfilment_id":""},{"funnel_name":"Quantum AI","funnel_code":"Quantum AI","funnel_image":"quatum-ai.jpg","funnel_badge_rating":"93","fulfilment_id":""},
    {"funnel_name":"Yuan Pay Group","funnel_code":"Yuan Pay Group","funnel_image":"YuanPayGroup.jpg","funnel_badge_rating":"95","fulfilment_id":""},
    {"funnel_name":"Bitcoin Motion","funnel_code":"Bitcoin Motion","funnel_image":"BitcoinMotion.jpg","funnel_badge_rating":"95","fulfilment_id":""},
    {"funnel_name":"BitIQ","funnel_code":"BitIQ","funnel_image":"BitIQ.jpg","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Bitcoin Apex","funnel_code":"Bitcoin Apex","funnel_image":"bitcoin-apex.jpg","funnel_badge_rating":"95","fulfilment_id":""},{"funnel_name":"Bitcode AI","funnel_code":"Bitcode AI","funnel_image":"bitcode-ai.png","funnel_badge_rating":"96","fulfilment_id":""},{"funnel_name":"Bitcode Prime","funnel_code":"Bitcode Prime","funnel_image":"bitcodeprime.png","funnel_badge_rating":"96","fulfilment_id":""}]';

    $choices = json_decode($choices);
    // loop through array and add to field 'choices'
    if (is_array($choices)) {
        $field['choices'][''] = '';
        foreach ($choices as $choice) {
            $field['choices'][$choice->funnel_name] = $choice->funnel_name;
        }
    }

    return $field;
}

add_filter('acf/load_field/key=field_62012634db064', 'acf_load_funnel_field_choices');

add_theme_support( 'title-tag' );

if ( ! function_exists( 'trust_posted_age' ) ) :
    /**
     * Prints HTML with posted "time ago"
     */
    function trust_posted_age($post = null) {
        printf( _x( '%s ago', '%s = human-readable time difference', 'trust' ), human_time_diff( get_the_time( 'U', $post ), current_time( 'timestamp' ) ) );
    }

endif;



function language_redirect()
{
    if(!is_front_page()) {
        global $post;

        if (get_post_meta($post->ID, '_wp_page_template ', true) == "page-thanks.php") {
            include(get_template_directory() . '/page-thanks.php');
        }
    }
}
add_action( 'template_redirect', 'language_redirect' );

function ff_getallheaders()
{
    foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
            $headers[$name] = $value;
        } else if ($name == "CONTENT_TYPE") {
            $headers["Content-Type"] = $value;
        } else if ($name == "CONTENT_LENGTH") {
            $headers["Content-Length"] = $value;
        }
    }
    return $headers;
}


function ff_post_funnel()
{
    global $post;
    $post_id = $_POST['post_id'];
    $main_post_id = $_POST['main_post_id'];

    $funnel_code = get_field('newofficial_funnel','option');

    $iso = (isset($_POST['iso'])) ? $_POST['iso'] : 'en';

    $post_data = array(
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? $_POST['country'],
        'phone_dial_code' => $_POST['dial_code'],
        'phone_number' => $_POST['phone_number'],
        'country_code' => $_POST['country'],

        'campaign_name' => 'Funnel - ' . $funnel_code,
        'fulfilment_id' => $_POST['fulfilment_id'],
        's3' => 'community',
        's2' => $funnel_code,
        's1' => $_SERVER['HTTP_HOST'],// $_POST['custom_1'], //TODO Context From admin panel params => REVIEW//  OFFICIAL SITE// CELEBRITY ARTICLE
        't1' => $iso,
        //TODO custom_3 => GET param

        //TODO add USER_ID field value
        'affiliate_user' => 376,//get_field('user_id', 'option'),

        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'headers' => json_encode(ff_getallheaders())
    );

    file_put_contents(get_stylesheet_directory() . '/responses/responsesall-' . date('H-d-m-Y') .'.txt' , date('h:i:s A d.m.Y'). ' Site = ' . $_SERVER['HTTP_HOST'] . ' With Email = ' . $_POST['email']  . ' Ip address = ' . 
    (isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR']) . ' IP Remote addre address = ' . ( $_SERVER['REMOTE_ADDR'] ?? $_POST['country']) . ' Country = ' . 
    $_POST['country'] . "\n", FILE_APPEND);

    $curl = curl_init();


        $api_key = 'JKP0P7PTJ7YJMW6X372HPGRJZTIUVOES';

    if( $_POST['country'] == 'GB' ){
        $api_key = '4VTKAFWPHJMLQAITC7XOMC9ZSFJMF5JT';
    }

    // if($_SERVER['HTTP_HOST'] == 'bitcoinmotion.io'){
    //     $api_key = 'JKP0P7PTJ7YJMW6X372HPGRJZTIUVOES';
    // }

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://coininsiderapi.com/p/lead",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => http_build_query($post_data),
        CURLOPT_HTTPHEADER => array(
            "API-KEY: " . $api_key,
            "Content-Type: application/x-www-form-urlencoded"
        ),
    ));

    $response = curl_exec($curl);
    $response_decoded = json_decode($response);
    if (isset($response_decoded->status) && 'error' == $response_decoded->status) {

        die(json_encode(array('success' => false, 'data' => $response_decoded)));
    }

    if ('' != $_POST['redirect_page']) {
        $redirect_page = get_permalink($_POST['redirect_page']);
    } else {
        $redirect_page = get_home_url() . '/ok/';
    }


    curl_close($curl);
    $response_decoded->funnel_name = $funnel_code;
    $response_decoded->url = $response_decoded->autologin_url;
    $response = array(
        'success' => true,
        'thank_you_page' => $redirect_page,
        'data' => $response_decoded,
        'funnel_name' => $funnel_code->funnel_name,
    );

    file_put_contents(get_stylesheet_directory() . '/responses/responsesdone-' . date('H-d-m-Y') .'.txt' , date('h:i:s A d.m.Y'). ' Site = ' . $_SERVER['HTTP_HOST'] . 
    json_encode($response) . ' With Email = ' . $_POST['email']  . 'Ip address = ' . 
    (isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR']) . ' IP Remote addre address = ' . ( $_SERVER['REMOTE_ADDR'] ?? $_POST['country']) . ' Country = ' . 
    $_POST['country'] . "\n", FILE_APPEND);


    die(json_encode($response));
}

add_action('wp_ajax_ff_post_funnel', 'ff_post_funnel');
add_action('wp_ajax_nopriv_ff_post_funnel', 'ff_post_funnel');

function ff_funnel_account_button_url()
{
    if(isset($_COOKIE["registered"])){
        return $_COOKIE["registered"];
    }
    return esc_attr($_GET['account_url']);
}
add_shortcode('funnel_account_button_url', 'ff_funnel_account_button_url');

function acf_get_global_field($field_name){
    $field = '';
    switch_to_blog( 1 );
    $field = get_field($field_name, 'option');
    restore_current_blog();

    return $field;
}

function acf_the_global_field($field_name){
    $field = '';
    switch_to_blog( 1 );
    $field =  get_field($field_name, 'option', false);

    restore_current_blog();
    $content = apply_filters( 'the_content', $field );
    $content = str_replace( ']]>', ']]&gt;', $content );

    return $content;
}

function acf_the_global_field_by_site($field_name, $site_id){
    $field = '';
    switch_to_blog( 1 );
    $field =  get_field($field_name, 'option', false);

    restore_current_blog();
    switch_to_blog( $site_id );
    $content = apply_filters( 'the_content', $field );
    $content = str_replace( ']]>', ']]&gt;', $content );
    restore_current_blog();
    return $content;
}

function get_page_url($template_name)
{
    $pages = get_posts([
        'post_type' => 'page',
        'post_status' => 'publish',
        'meta_query' => [
            [
                'key' => '_wp_page_template',
                'value' => $template_name,
                'compare' => '='
            ]
        ]
    ]);
    if(!empty($pages))
    {
        foreach($pages as $pages__value)
        {
            return get_permalink($pages__value->ID);
        }
    }
    return get_bloginfo('url');
}

add_filter( 'pre_get_document_title', 'filter_document_title' );
function filter_document_title( $title ) {

    $title = get_field('newofficial_funnel','option') . ' Official Community';
    if( get_global_option('theme_version' ) == 'v2'){
        $title = get_field('site_meta_title','option');
        if(empty($title)){
            if(ICL_LANGUAGE_CODE == 'en'){
                $title = get_field('newofficial_funnel','option') . " ™ Community | Verified User Reviews " . date('Y');
            }elseif (ICL_LANGUAGE_CODE == 'de'){
                $title = get_field('newofficial_funnel','option') . " | offizielle Benutzerseite | Verifizierte Erfahrungen " . date('Y');
            }else{
                $title = get_field('newofficial_funnel','option') . " | officiële gebruikerssite | Geverifieerde evaringen " . date('Y');
            }
        }
    }else{
        $title = get_field('site_meta_title_15','option');

        if(empty($title)){
            if(ICL_LANGUAGE_CODE == 'en'){
                $title = get_field('newofficial_funnel','option') . " ™ | Official Website " . date('Y') . " | Claim Now!";
            }elseif (ICL_LANGUAGE_CODE == 'de'){
                $title = get_field('newofficial_funnel','option') . " ™ | Offizielle Website " . date('Y') . " | Beanspruche jetzt!";
            }else{
                $title = get_field('newofficial_funnel','option') . " ™ | Officiële website " . date('Y') . " | Claim nu!";
            }
        }


    }

    if(is_home()){
        $title = do_shortcode(get_field('global_home_page_title','option'));
    }else{
        $title = get_field('newofficial_funnel','option');
    }

    return $title;

}

add_action( 'wp_head', 'cyb_author_archive_meta_desc' );
function cyb_author_archive_meta_desc() {

    if( is_front_page() ) {
        if( get_global_option('theme_version' ) == 'v2'){
            $description = get_field('site_meta_description','option');// get_field('funnel','option') . ' Official Community desc';
        }else{
            $description = get_field('site_meta_description_15','option');// get_field('funnel','option') . ' Official Community desc';
        }
        echo '<meta name="description" content="' . esc_attr( $description ) . '">';
    }

}

add_shortcode('funnel',function (){
    return get_field('newofficial_funnel','option');
});

add_shortcode('privacy_url','get_privacy_page_url');
function get_privacy_page_url()
{
    $pages = get_posts([
        'post_type' => 'page',
        'post_status' => 'publish',
        'meta_query' => [
            [
                'key' => '_wp_page_template',
                'value' => 'page-privacy.php',
                'compare' => '='
            ]
        ]
    ]);
    if(!empty($pages))
    {
        foreach($pages as $pages__value)
        {
            return get_permalink($pages__value->ID);
        }
    }
    return get_bloginfo('url');
}

add_shortcode('terms_url','get_terms_page_url');

function get_terms_page_url()
{
    $pages = get_posts([
        'post_type' => 'page',
        'post_status' => 'publish',
        'meta_query' => [
            [
                'key' => '_wp_page_template',
                'value' => 'page-terms.php',
                'compare' => '='
            ]
        ]
    ]);
    if(!empty($pages))
    {
        foreach($pages as $pages__value)
        {
            return get_permalink($pages__value->ID);
        }
    }
    return get_bloginfo('url');
}

add_shortcode('site_url','get_site_url_shortcode');
function get_site_url_shortcode(){
    return home_url();
}
function remove_posts_menu() {
    remove_menu_page('edit.php');
}
add_action('admin_menu', 'remove_posts_menu');

//add_action( 'init', 'remove_categories_from_posts' );
//function remove_categories_from_posts() {
//    remove_post_type_support( 'post', [ 'taxonomy' => [ 'category' ] ] );
//}


///**
// * Large Favicon
// *
// * @author Bill Erickson
// * @link https://www.billerickson.net/code/large-favicon/
// *
// * @param string $url, favicon image url
// * @param int $size, size in pixels
// * @return string $url
// *
// */
function ea_large_favicon( $url, $size ) {

    if(empty($url)) {
        $url = get_template_directory_uri() . '/assets/img/favicon.png';
    }
    return $url;
}
add_filter( 'get_site_icon_url', 'ea_large_favicon', 10, 2 );

//add_filter('site_url',  'wpadmin_filter', 10, 3);

function wpadmin_filter( $url, $path, $orig_scheme ) {
    $old  = array( "/(wp-admin)/");
    $admin_dir = 'party';
    $new  = array($admin_dir);
    return preg_replace( $old, $new, $url, 1);
}

///**
// * Advanced Custom Fields Options function
// * Always fetch an Options field value from the default language
// */
function cl_acf_set_language() {
    return acf_get_setting('default_language');
  }

function get_global_option($name) {
    add_filter('acf/settings/current_language', 'cl_acf_set_language', 100);
    $option = get_field($name, 'option');
    remove_filter('acf/settings/current_language', 'cl_acf_set_language', 100);
    return $option;
}

//// Add the custom columns to the book post type:
add_filter( 'manage_review_posts_columns', 'set_custom_edit_book_columns',99 );
function set_custom_edit_book_columns($columns) {
    unset( $columns['icl_translations'] );
    $columns['chart_count'] = __( 'Characters', 'trust' );

    return $columns;
}

//// Add the data to the custom columns for the book post type:
add_action( 'manage_review_posts_custom_column' , 'custom_book_column', 10, 2 );
function custom_book_column( $column, $post_id ) {
    switch ( $column ) {
        case 'icl_translations':
            break;

        case 'chart_count' :
            $content_post = get_post($post_id);
            $content = $content_post->post_content;
            echo strlen(str_replace(' ', '',strip_tags(do_shortcode($content))));
            break;

    }
}

function custom_hide_meta_boxes( $hidden, $screen ) {
    // Grab the current post type
    $post_type = $screen->post_type;
    // If we're on a 'post'...
    if ( $post_type == 'review' ) {
        // Define which meta boxes we wish to hide
        $hidden = array(
            'icl_div'
        );
        // Pass our new defaults onto WordPress
        return $hidden;
    }
    // If we are not on a 'post', pass the
    // original defaults, as defined by WordPress
    return $hidden;
}
add_action( 'default_hidden_meta_boxes', 'custom_hide_meta_boxes', 10, 2 );

add_filter( 'wp_robots', 'wp_kama_robots_tag' );

function wp_kama_robots_tag( $robots ){

	if ( !is_home() ){
		$robots['noindex'] = true;
	}


	return $robots;
}

function wpassist_remove_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'wpassist_remove_block_library_css' );


function prepere_contente_review($content , $blog_id){
    $return_content = '';
    switch_to_blog( $blog_id );
    $return_content = do_shortcode($content);
    restore_current_blog();

    return $return_content;
}

function get_cryptocurrencies(){
    $response = json_decode(get_transient('coinstats_list_global'), true);
    if( !$response) {
        $response = wp_remote_get('https://api.coinstats.app/public/v1/coins?skip=0&limit=25&currency=EUR');

        $response = wp_remote_retrieve_body( $response );

        if(!empty( $response )){
            $response = json_decode($response, true);
            set_transient('coinstats_list_global', json_encode($response) ,DAY_IN_SECONDS);

        }
    }

    return $response;
}


add_shortcode('XYZ', 'fri_XYZ_shortcode');//Name
add_shortcode('XYZY', 'fri_XYZY_shortcode');//Year

function fri_XYZY_shortcode($atts)
{
    return date('Y');
}

function fri_XYZ_shortcode($atts)
{
    return get_field('newofficial_funnel','option');
}