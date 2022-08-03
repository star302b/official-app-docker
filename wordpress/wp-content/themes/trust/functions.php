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

function trust_scripts() {
    if( get_global_option('theme_version' ) == 'v2' || !is_front_page()) {
        wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/style.min.css', array(), null);
    }else{
        wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/style-v2.min.css', array(), null);
    }
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

    if(get_current_blog_id() == 1){
        acf_add_options_sub_page(array(
            'page_title' 	=> 'Global Sites Settings',
            'menu_title'	=> 'Global Sites Settings',
            'parent_slug'	=> 'theme-general-settings',
        ));
    }
}

//var_dump(get_site_option('test'));
//acf_add_options_page([
//    'network' => true,
//    'post_id' => 'acf_network_options',
//    'page_title' => 'Network Options',
//    'menu_title' => 'Network Options'
//]);

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
    {"funnel_name":"BitIQ","funnel_code":"BitIQ","funnel_image":"BitIQ.jpg","funnel_badge_rating":"95","fulfilment_id":""}]';

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

add_filter('acf/load_field/key=field_60ed4fda2fe50', 'acf_load_funnel_field_choices');

add_theme_support( 'title-tag' );

if ( ! function_exists( 'trust_posted_age' ) ) :
    /**
     * Prints HTML with posted "time ago"
     */
    function trust_posted_age($post = null) {
        printf( _x( '%s ago', '%s = human-readable time difference', 'trust' ), human_time_diff( get_the_time( 'U', $post ), current_time( 'timestamp' ) ) );
    }

endif;

/*
add_action('wp_insert_site', function($site) {
    switch_to_blog( $site->blog_id );
    global $wpdb;
    activate_plugin( ABSPATH . PLUGINDIR . '/sitepress-multilingual-cms/sitepress.php' );

    // Start up WPML
//    icl_sitepress_activate();

//    echo 'WPML started.<br />';
//
//    // Set WPML's initial settings, as in wpml-installation-class.php function "finish_step1"
//    $initial_language_code = 'en';
//
//    icl_set_setting( 'dont_show_help_admin_notice', 1, true );
//    icl_set_setting( 'existing_content_language_verified', 1, true );
//    icl_set_setting( 'default_language', $initial_language_code, true );
//    icl_set_setting( 'admin_default_language', $initial_language_code, true );
//    icl_set_setting( 'setup_complete', 1, true );
//    icl_set_setting( 'active_languages', array( 'en', 'de' ), true );
//    icl_set_setting( 'language_negotiation_type', 2, true );
//    icl_set_setting( 'language_domains', array( 'en' => '<em><u>hidden link</u></em>', 'de' => '<em><u>hidden link</u></em>' ) );
//    // icl_save_settings();
//
//    echo 'WPML settings saved.<br />';
    $sitepress = new SitePress();
    $sitepress_i = new WPML_Installation($wpdb,$sitepress);
    $sitepress_i->go_to_setup1();
    $sitepress_i->finish_step1('en');
    $sitepress_i->finish_step2(['en','de','nl']);
    $sitepress_i->finish_step3();
    $sitepress_i->finish_installation();

    // do some db magic
//    $wpdb->update( $wpdb->prefix . 'icl_languages', array( 'active' => '1' ), array( 'code' => 'ed' ) );
//    $wpdb->update( $wpdb->prefix . 'icl_languages', array( 'active' => '1' ), array( 'code' => 'de' ) );
//    $wpdb->insert( $wpdb->prefix . 'icl_locale_map', array( 'code' => 'de', 'locale' => 'de_DE') );
//    $wpdb->insert( $wpdb->prefix . 'icl_locale_map', array( 'code' => 'en', 'locale' => 'en_US') );
//
//    // update the WPML settings
//    update_option('icl_sitepress_settings','a:57:{s:19:"hide_upgrade_notice";s:5:"4.4.9";s:25:"icl_capabilities_verified";b:1;s:16:"active_languages";a:2:{i:0;s:2:"en";i:1;s:2:"de";}s:21:"interview_translators";i:1;s:34:"existing_content_language_verified";i:1;s:25:"language_negotiation_type";i:3;s:18:"icl_lso_link_empty";i:0;s:18:"sync_page_ordering";i:1;s:16:"sync_page_parent";i:1;s:18:"sync_page_template";i:1;s:16:"sync_ping_status";i:1;s:19:"sync_comment_status";i:1;s:16:"sync_sticky_flag";i:1;s:13:"sync_password";i:1;s:17:"sync_private_flag";i:1;s:16:"sync_post_format";i:1;s:11:"sync_delete";i:0;s:15:"sync_delete_tax";i:0;s:20:"sync_post_taxonomies";i:1;s:14:"sync_post_date";i:0;s:21:"sync_taxonomy_parents";i:0;s:25:"translation_pickup_method";i:0;s:15:"notify_complete";i:1;s:26:"translated_document_status";i:1;s:17:"remote_management";i:0;s:15:"auto_adjust_ids";i:1;s:11:"alert_delay";i:0;s:12:"promote_wpml";i:0;s:18:"automatic_redirect";i:0;s:17:"remember_language";i:24;s:28:"icl_lang_sel_copy_parameters";s:0:"";s:28:"translated_document_page_url";s:13:"auto-generate";s:27:"sync_comments_on_duplicates";i:0;s:3:"seo";a:3:{s:10:"head_langs";i:1;s:27:"canonicalization_duplicates";i:1;s:19:"head_langs_priority";i:1;}s:22:"posts_slug_translation";a:2:{s:2:"on";i:1;s:20:"string_name_migrated";b:1;}s:4:"urls";a:5:{s:30:"directory_for_default_language";i:0;s:12:"show_on_root";s:0:"";s:19:"root_html_file_path";s:0:"";s:9:"root_page";i:0;s:23:"hide_language_switchers";i:1;}s:12:"xdomain_data";i:1;s:24:"custom_posts_sync_option";a:10:{s:4:"post";s:1:"1";s:4:"page";s:1:"1";s:10:"attachment";i:1;s:8:"wp_block";i:1;s:10:"custom_css";s:1:"0";s:19:"customize_changeset";s:1:"0";s:12:"oembed_cache";s:1:"0";s:12:"user_request";s:1:"0";s:6:"review";s:1:"1";s:15:"acf-field-group";s:1:"0";}s:22:"taxonomies_sync_option";a:3:{s:8:"category";i:1;s:8:"post_tag";i:1;s:20:"translation_priority";i:1;}s:28:"tm_block_retranslating_terms";i:1;s:22:"admin_default_language";s:9:"_default_";s:22:"taxonomy_names_checked";b:1;s:14:"setup_complete";i:1;s:18:"ajx_health_checked";b:1;s:2:"st";a:16:{s:25:"db_ok_for_gettext_context";b:1;s:41:"WPML_ST_Upgrade_Migrate_Originals_has_run";b:1;s:48:"WPML_ST_Upgrade_Db_Cache_Command_2.4.2_2_has_run";b:1;s:52:"WPML_ST_Upgrade_Display_Strings_Scan_Notices_has_run";b:1;s:48:"WPML_ST_Upgrade_DB_String_Packages_2.4.2_has_run";b:1;s:37:"WPML_ST_Upgrade_MO_Scanning_4_has_run";b:1;s:46:"WPML_ST_Upgrade_DB_String_Name_Index_2_has_run";b:1;s:48:"WPML_ST_Upgrade_DB_Longtext_String_Value_has_run";b:1;s:53:"WPML_ST_Upgrade_DB_String_Packages_Word_Count_has_run";b:1;s:64:"WPML\ST\Upgrade\Command\RegenerateMoFilesWithStringNames_has_run";b:1;s:16:"strings_per_page";i:10;s:15:"icl_st_auto_reg";s:7:"disable";s:16:"strings_language";s:2:"en";s:16:"translated-users";a:0:{}s:2:"sw";a:0:{}s:53:"WPML\ST\MO\Generate\Process\Status_background_has_run";b:1;}s:15:"languages_order";a:2:{i:0;s:2:"en";i:1;s:2:"de";}s:22:"theme_language_folders";N;s:18:"default_categories";a:2:{s:2:"en";s:1:"1";s:2:"de";i:2;}s:16:"default_language";s:2:"en";s:17:"setup_wizard_step";i:5;s:22:"translation-management";a:12:{s:25:"custom_fields_translation";a:32:{s:5:"title";i:2;s:11:"description";i:2;s:8:"keywords";i:2;s:10:"_edit_last";i:0;s:10:"_edit_lock";i:0;s:17:"_wp_page_template";i:0;s:23:"_wp_attachment_metadata";i:0;s:16:"original_post_id";i:0;s:22:"_wpml_original_post_id";i:0;s:12:"_wp_old_slug";i:0;s:20:"_icl_translator_note";i:0;s:14:"_alp_processed";i:0;s:7:"_pingme";i:0;s:10:"_encloseme";i:0;s:22:"_icl_lang_duplicate_of";i:0;s:13:"_thumbnail_id";i:0;s:17:"_wp_attached_file";i:0;s:24:"_wp_attachment_image_alt";i:2;s:18:"_yoast_wpseo_title";i:2;s:20:"_yoast_wpseo_bctitle";i:2;s:21:"_yoast_wpseo_metadesc";i:2;s:25:"_yoast_wpseo_metakeywords";i:2;s:20:"_yoast_wpseo_focuskw";i:2;s:32:"_yoast_wpseo_meta-robots-noindex";i:1;s:33:"_yoast_wpseo_meta-robots-nofollow";i:1;s:28:"_yoast_wpseo_meta-robots-adv";i:1;s:22:"_yoast_wpseo_canonical";i:0;s:21:"_yoast_wpseo_redirect";i:0;s:34:"_yoast_wpseo_opengraph-description";i:2;s:36:"_yoast_wpseo_google-plus-description";i:2;s:26:"_yoast_wpseo_twitter-title";i:2;s:32:"_yoast_wpseo_twitter-description";i:2;}s:29:"custom_fields_readonly_config";a:32:{i:0;s:5:"title";i:1;s:11:"description";i:2;s:8:"keywords";i:3;s:10:"_edit_last";i:4;s:10:"_edit_lock";i:5;s:17:"_wp_page_template";i:6;s:23:"_wp_attachment_metadata";i:7;s:16:"original_post_id";i:8;s:22:"_wpml_original_post_id";i:9;s:12:"_wp_old_slug";i:10;s:20:"_icl_translator_note";i:11;s:14:"_alp_processed";i:12;s:7:"_pingme";i:13;s:10:"_encloseme";i:14;s:22:"_icl_lang_duplicate_of";i:15;s:13:"_thumbnail_id";i:16;s:17:"_wp_attached_file";i:17;s:24:"_wp_attachment_image_alt";i:18;s:18:"_yoast_wpseo_title";i:19;s:20:"_yoast_wpseo_bctitle";i:20;s:21:"_yoast_wpseo_metadesc";i:21;s:25:"_yoast_wpseo_metakeywords";i:22;s:20:"_yoast_wpseo_focuskw";i:23;s:32:"_yoast_wpseo_meta-robots-noindex";i:24;s:33:"_yoast_wpseo_meta-robots-nofollow";i:25;s:28:"_yoast_wpseo_meta-robots-adv";i:26;s:22:"_yoast_wpseo_canonical";i:27;s:21:"_yoast_wpseo_redirect";i:28;s:34:"_yoast_wpseo_opengraph-description";i:29;s:36:"_yoast_wpseo_google-plus-description";i:30;s:26:"_yoast_wpseo_twitter-title";i:31;s:32:"_yoast_wpseo_twitter-description";}s:32:"custom_fields_translation_custom";a:0:{}s:41:"custom_fields_translation_custom_readonly";a:0:{}s:22:"doc_translation_method";i:0;s:35:"__custom_types_readonly_config_prev";a:0:{}s:28:"custom_types_readonly_config";a:0:{}s:36:"__custom_fields_readonly_config_prev";a:32:{i:0;s:5:"title";i:1;s:11:"description";i:2;s:8:"keywords";i:3;s:10:"_edit_last";i:4;s:10:"_edit_lock";i:5;s:17:"_wp_page_template";i:6;s:23:"_wp_attachment_metadata";i:7;s:16:"original_post_id";i:8;s:22:"_wpml_original_post_id";i:9;s:12:"_wp_old_slug";i:10;s:20:"_icl_translator_note";i:11;s:14:"_alp_processed";i:12;s:7:"_pingme";i:13;s:10:"_encloseme";i:14;s:22:"_icl_lang_duplicate_of";i:15;s:13:"_thumbnail_id";i:16;s:17:"_wp_attached_file";i:17;s:24:"_wp_attachment_image_alt";i:18;s:18:"_yoast_wpseo_title";i:19;s:20:"_yoast_wpseo_bctitle";i:20;s:21:"_yoast_wpseo_metadesc";i:21;s:25:"_yoast_wpseo_metakeywords";i:22;s:20:"_yoast_wpseo_focuskw";i:23;s:32:"_yoast_wpseo_meta-robots-noindex";i:24;s:33:"_yoast_wpseo_meta-robots-nofollow";i:25;s:28:"_yoast_wpseo_meta-robots-adv";i:26;s:22:"_yoast_wpseo_canonical";i:27;s:21:"_yoast_wpseo_redirect";i:28;s:34:"_yoast_wpseo_opengraph-description";i:29;s:36:"_yoast_wpseo_google-plus-description";i:30;s:26:"_yoast_wpseo_twitter-title";i:31;s:32:"_yoast_wpseo_twitter-description";}s:41:"__custom_term_fields_readonly_config_prev";a:0:{}s:34:"custom_term_fields_readonly_config";a:0:{}s:26:"taxonomies_readonly_config";a:1:{s:20:"translation_priority";i:1;}s:28:"custom-types_readonly_config";a:2:{s:10:"attachment";i:1;s:8:"wp_block";i:1;}}s:24:"custom-types_sync_option";a:2:{s:10:"attachment";i:1;s:8:"wp_block";i:1;}s:29:"language_selector_initialized";i:1;s:27:"dont_show_help_admin_notice";b:1;s:21:"site_does_not_use_icl";b:1;s:28:"custom_posts_unlocked_option";a:10:{s:4:"post";s:1:"0";s:4:"page";s:1:"0";s:10:"attachment";s:1:"0";s:10:"custom_css";s:1:"0";s:19:"customize_changeset";s:1:"0";s:12:"oembed_cache";s:1:"0";s:12:"user_request";s:1:"0";s:8:"wp_block";s:1:"0";s:6:"review";s:1:"0";s:15:"acf-field-group";s:1:"0";}s:66:"admin_text_3_2_migration_complete_180a5bf0e239dc4210b510f5556a8b9c";b:1;}');

    
    $page_id = wp_insert_post(
        array(
            'post_author'    => 1,
            'post_title'     => ucwords('Account Registered'),
            'post_name'      => strtolower(str_replace(' ', '-', trim('Account Registered'))),
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'meta_input'     => [ '_wp_page_template '=>'page-thanks.php' ],
        )
    );
    restore_current_blog();
});

//TODO noindex for all exerpt homepage
//TODO template for meta title and decs for each language
//TODO Schema for Review
//TODO Try to prepare WPML when new site created, EN, DE, NL
//TODO Redirect on the thnak you page when form submited
//TODO funnel form S1= site url, S2 = funnel_name, S3 = v2-context

add_action('after_switch_theme', 'mytheme_setup_options');
*/
function mytheme_setup_options () {
    global $wpdb;
    $sitepress = new SitePress();
    $sitepress_i = new WPML_Installation($wpdb,$sitepress);
    $sitepress_i->go_to_setup1();
    $sitepress_i->finish_step1('en');
    $sitepress_i->finish_step2(['en','de','nl']);
    $sitepress_i->finish_step3();
    $sitepress_i->finish_installation();
}
if ( function_exists('icl_object_id') && !get_option('wpml_configured') ) {



    global $wpdb;
    $sitepress = new SitePress();
    $sitepress_i = new WPML_Installation($wpdb,$sitepress);
    $sitepress_i->go_to_setup1();
    $sitepress_i->finish_step1('en');
    $sitepress_i->finish_step2(['en','de','nl']);
    $sitepress_i->finish_step3();
    $sitepress_i->finish_installation();

    $sitepress->set_setting('language_negotiation_type',1);

    $settings_helper = wpml_load_settings_helper();
    $settings_helper->update_cpt_unlocked_settings( ["review" => 0] );
    $settings_helper->update_cpt_sync_settings( ["review" => 1] );



//    $set_language_args = array(
//        'element_id'    => $page_id,
//        'element_type'  => 'post_page',
//        'language_code'   => 'en',
//        'source_language_code' => 'en'
//    );
//
//    do_action( 'wpml_set_element_language_details', $set_language_args );



    update_option('wpml_configured', true);

    echo "<script type='text/javascript'>
        window.location=document.location.href;
        </script>";
}
//if(get_option('wpml_configured') && !get_option('wpml_configured1')){
//    $page_id = wp_insert_post(
//        array(
//            'post_author'    => 1,
//            'post_title'     => ucwords('Account Registered'),
//            'post_name'      => strtolower(str_replace(' ', '-', trim('Account Registered'))),
//            'post_status'    => 'publish',
//            'post_type'      => 'page',
//            'page_template' => 'page-thanks.php',
//            'meta_input'     => [ '_wp_page_template'=>'page-thanks.php' ],
//        )
//    );
//    do_action( 'wpml_make_post_duplicates', $page_id );
//
////    $set_language_args = array(
////        'element_id'    => $page_id,
////        'element_type'  => 'post_page',
////        'language_code'   => 'en',
////        'source_language_code' => 'en'
////    );
////
////    do_action( 'wpml_set_element_language_details', $set_language_args );
//
//
//    $page_id = wp_insert_post(
//        array(
//            'post_author'    => 1,
//            'post_title'     => ucwords('Privacy Policy'),
//            'post_name'      => strtolower(str_replace(' ', '-', trim('Privacy Policy'))),
//            'post_status'    => 'publish',
//            'post_type'      => 'page',
//            'page_template' => 'page-privacy.php',
//            'meta_input'     => [ '_wp_page_template'=>'page-privacy.php' ],
//        )
//    );
//
//    do_action( 'wpml_make_post_duplicates', $page_id );
//
////    $set_language_args = array(
////        'element_id'    => $page_id,
////        'element_type'  => 'post_page',
////        'language_code'   => 'en',
////        'source_language_code' => 'en'
////    );
////
////    do_action( 'wpml_set_element_language_details', $set_language_args );
//
//    $page_id = wp_insert_post(
//        array(
//            'post_author'    => 1,
//            'post_title'     => ucwords('Terms & Conditions'),
//            'post_name'      => strtolower(str_replace(' ', '-', trim('Terms Conditions'))),
//            'post_status'    => 'publish',
//            'post_type'      => 'page',
//            'page_template' => 'page-terms.php',
//            'meta_input'     => [ '_wp_page_template'=>'page-terms.php' ],
//        )
//    );
//
//    do_action( 'wpml_make_post_duplicates', $page_id );

//    update_option('wpml_configured1', true);
//    echo "<script type='text/javascript'>
//        window.location=document.location.href;
//        </script>";
//}


function language_redirect()
{
    if(!is_front_page()) {
        global $post;

        if (get_post_meta($post->ID, '_wp_page_template ', true) == "page-thanks.php") {
            include(get_template_directory() . '/page-thanks.php');
//        exit;
        }
//    global $q_config;
//
//    if( $q_config['lang'] == 'en' )
//    {
//        include( get_template_directory() . '/page-template_en.php' );
//        exit;
//    }
//    else
//    {
//        include( get_template_directory() . '/page-template_de.php' );
//        exit;
//    }
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

    $funnel_code = get_field('funnel','option');

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
        $redirect_page = get_home_url() . '/account-registered';
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



    die(json_encode($response));
}

function ff_post_funnel_old()
{
    global $post;

    $funnel_code = get_field('funnel','option');

    $post_data = array(
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? $_POST['country'],
        'phone_area_code' => $_POST['dial_code'],
        'phone_number' => $_POST['phone_number'],
        'country_code' => $_POST['country'],

        'product_name' => 'Funnel - ' . $funnel_code,
        'fulfilment_id' => $_POST['fulfilment_id'],
        'custom_3' => 'community',
        'custom_2' => $funnel_code,
        'custom_1' => $_SERVER['HTTP_HOST'],//home_url(),//$_POST['custom_1'],
        'affiliate_user' => 376,

        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'headers' => json_encode(ff_getallheaders())
    );

    $curl = curl_init();

        $iso = (isset($_POST['iso'])) ? $_POST['iso'] : 'en';

        if ('de' == $iso) {
            $api_key = '8UAGBHGO8OFHUOZZYH5Z0LCZKDRSZYYJ';
        } elseif ('es' == $iso) {
            $api_key = 'SVD5JODR4BF5YWYUD6HMPSALCHWAHBIA';
        } elseif ('nl' == $iso) {
            $api_key = 'JS4NXOKWDKABLSYTBOKRPNHIG0DYPGZJ';
        } elseif ('it' == $iso) {
            $api_key = 'PGEKDXFGM3J8VSUTFR1YUONK3NHQL2OR';
        } elseif ('pt' == $iso) {
            $api_key = '7UUSDENEWZ2VISB2TFLTIP4VOMYTE87Z';
        } elseif ('pl' == $iso) {
            $api_key = 'U1S5KCS12B6KIJNPXJK8VXAINF4REX2W';
        } else {
            $api_key = 'I2MH9BABGJ19WVLFR422FPA2MYAQFVGU';
        }
        if( $_POST['country'] == 'GB' ){
            $api_key = 'ZE1WFVPJQOJE1SJJJ6PAU7U7KGRQSHH2';
        }

        // $api_key = 'test';

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://srvsapi.com/api/register",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($post_data),
            CURLOPT_HTTPHEADER => array(
                "X-API-KEY: " . $api_key,
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
            $redirect_page = get_home_url() . '/account-registered';
        }

        error_log("Redirect Page for funnel: " . $iso . " Thank you page: " . $redirect_page);

        curl_close($curl);

        $response = array(
            'success' => true,
            'thank_you_page' => $redirect_page,
            'data' => $response_decoded
        );

    error_log("Funnel Response: " . json_encode($response));

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

    $title = get_field('funnel','option') . ' Official Community';
    if( get_global_option('theme_version' ) == 'v2'){
        $title = get_field('site_meta_title','option');
        if(empty($title)){
            if(ICL_LANGUAGE_CODE == 'en'){
                $title = get_field('funnel','option') . " ™ Community | Verified User Reviews " . date('Y');
            }elseif (ICL_LANGUAGE_CODE == 'de'){
                $title = get_field('funnel','option') . " | offizielle Benutzerseite | Verifizierte Erfahrungen " . date('Y');
            }else{
                $title = get_field('funnel','option') . " | officiële gebruikerssite | Geverifieerde evaringen " . date('Y');
            }
        }
    }else{
        $title = get_field('site_meta_title_15','option');

        if(empty($title)){
            if(ICL_LANGUAGE_CODE == 'en'){
                $title = get_field('funnel','option') . " ™ | Official Website " . date('Y') . " | Claim Now!";
            }elseif (ICL_LANGUAGE_CODE == 'de'){
                $title = get_field('funnel','option') . " ™ | Offizielle Website " . date('Y') . " | Beanspruche jetzt!";
            }else{
                $title = get_field('funnel','option') . " ™ | Officiële website " . date('Y') . " | Claim nu!";
            }
        }

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
    return get_field('funnel','option');
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

add_action( 'init', 'remove_categories_from_posts' );
function remove_categories_from_posts() {
    remove_post_type_support( 'post', [ 'taxonomy' => [ 'category' ] ] );
}
function has_my_cookie()
{
    if (!is_admin()){
        if ( isset($_COOKIE["registered"]) && !preg_match('/account-registered/m', $_SERVER['REQUEST_URI'],$matches) ) {
            //Redirect
            wp_redirect( home_url().'/account-registered' ); exit;
        }
    }
}
// add_action('init', 'has_my_cookie');


/**
 * Large Favicon
 *
 * @author Bill Erickson
 * @link https://www.billerickson.net/code/large-favicon/
 *
 * @param string $url, favicon image url
 * @param int $size, size in pixels
 * @return string $url
 *
 */
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


function ok_page(){
    $page_id = wp_insert_post(
        array(
            'post_author'    => 1,
            'post_title'     => ucwords('Account Registered'),
            'post_name'      => 'ok',//strtolower(str_replace(' ', '-', trim('Account Registered'))),
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'page_template' => 'page-thanks.php',
            'meta_input'     => [ '_wp_page_template'=>'page-thanks.php' ],
        )
    );

//    do_action( 'wpml_make_post_duplicates', $page_id );

    $page_id_de = wp_insert_post(
        array(
            'post_author'    => 1,
            'post_title'     => ucwords('Konto registriert'),
            'post_name'      => 'ok',//strtolower(str_replace(' ', '-', trim('Account Registered'))),
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'page_template' => 'page-thanks.php',
            'meta_input'     => [ '_wp_page_template'=>'page-thanks.php' ],
        )
    );

    $page_id_nl = wp_insert_post(
        array(
            'post_author'    => 1,
            'post_title'     => ucwords('Account geregistreerd'),
            'post_name'      => 'ok',//strtolower(str_replace(' ', '-', trim('Account Registered'))),
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'page_template' => 'page-thanks.php',
            'meta_input'     => [ '_wp_page_template'=>'page-thanks.php' ],
        )
    );

    $get_language_args = array('element_id' => $page_id, 'element_type' => 'post_page' );
    $original_post_language_info = apply_filters( 'wpml_element_language_details', null, $get_language_args );

    $set_language_args = array(
        'element_id'    => $page_id_de,
        'element_type'  => 'post_page',
        'trid'   => $original_post_language_info->trid,
        'language_code'   => 'de',
        'source_language_code' => $original_post_language_info->language_code
    );

    do_action( 'wpml_set_element_language_details', $set_language_args );

    $set_language_args1 = array(
        'element_id'    => $page_id_nl,
        'element_type'  => 'post_page',
        'trid'   => $original_post_language_info->trid,
        'language_code'   => 'nl',
        'source_language_code' => $original_post_language_info->language_code
    );

    do_action( 'wpml_set_element_language_details', $set_language_args1 );

    wp_update_post( array(
        'ID' => $page_id_de,
        'post_name' => 'ok'
    ));

    wp_update_post( array(
        'ID' => $page_id_nl,
        'post_name' => 'ok'
    ));
}

function terms_page(){
    $page_id = wp_insert_post(
        array(
            'post_author'    => 1,
            'post_title'     => ucwords('Terms & Conditions'),
            'post_name'      => strtolower(str_replace(' ', '-', trim('Terms Conditions'))),
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'page_template' => 'page-terms.php',
            'meta_input'     => [ '_wp_page_template'=>'page-terms.php' ],
        )
    );

//    do_action( 'wpml_make_post_duplicates', $page_id );
    $page_id_de = wp_insert_post(
        array(
            'post_author'    => 1,
            'post_title'     => ucwords('Terms & Bedingungen'),
            'post_name'      => strtolower(str_replace(' ', '-', trim('Terms Conditions'))),
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'page_template' => 'page-terms.php',
            'meta_input'     => [ '_wp_page_template'=>'page-terms.php' ],
        )
    );

    $page_id_nl = wp_insert_post(
        array(
            'post_author'    => 1,
            'post_title'     => ucwords('Algemene Voorwaarden'),
            'post_name'      => strtolower(str_replace(' ', '-', trim('Terms Conditions'))),
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'page_template' => 'page-terms.php',
            'meta_input'     => [ '_wp_page_template'=>'page-terms.php' ],
        )
    );

    $get_language_args = array('element_id' => $page_id, 'element_type' => 'post_page' );
    $original_post_language_info = apply_filters( 'wpml_element_language_details', null, $get_language_args );

    $set_language_args = array(
        'element_id'    => $page_id_de,
        'element_type'  => 'post_page',
        'trid'   => $original_post_language_info->trid,
        'language_code'   => 'de',
        'source_language_code' => $original_post_language_info->language_code
    );

    do_action( 'wpml_set_element_language_details', $set_language_args );

    $set_language_args1 = array(
        'element_id'    => $page_id_nl,
        'element_type'  => 'post_page',
        'trid'   => $original_post_language_info->trid,
        'language_code'   => 'nl',
        'source_language_code' => $original_post_language_info->language_code
    );

    do_action( 'wpml_set_element_language_details', $set_language_args1 );

    wp_update_post( array(
        'ID' => $page_id_de,
        'post_name' => 'terms-conditions'
    ));

    wp_update_post( array(
        'ID' => $page_id_nl,
        'post_name' => 'terms-conditions'
    ));
}

function privacy_page(){
    $page_id = wp_insert_post(
        array(
            'post_author'    => 1,
            'post_title'     => ucwords('Privacy Policy'),
            'post_name'      => strtolower(str_replace(' ', '-', trim('Privacy Policy'))),
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'page_template' => 'page-privacy.php',
            'meta_input'     => [ '_wp_page_template'=>'page-privacy.php' ],
        )
    );

//    do_action( 'wpml_make_post_duplicates', $page_id );
    $page_id_de = wp_insert_post(
        array(
            'post_author'    => 1,
            'post_title'     => ucwords('Datenschutz-Bestimmungen'),
            'post_name'      => strtolower(str_replace(' ', '-', trim('Privacy Policy'))),
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'page_template' => 'page-privacy.php',
            'meta_input'     => [ '_wp_page_template'=>'page-privacy.php' ],
        )
    );

    $page_id_nl = wp_insert_post(
        array(
            'post_author'    => 1,
            'post_title'     => ucwords('Privacybeleid'),
            'post_name'      => strtolower(str_replace(' ', '-', trim('Privacy Policy'))),
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'page_template' => 'page-privacy.php',
            'meta_input'     => [ '_wp_page_template'=>'page-privacy.php' ],
        )
    );

    $get_language_args = array('element_id' => $page_id, 'element_type' => 'post_page' );
    $original_post_language_info = apply_filters( 'wpml_element_language_details', null, $get_language_args );

    $set_language_args = array(
        'element_id'    => $page_id_de,
        'element_type'  => 'post_page',
        'trid'   => $original_post_language_info->trid,
        'language_code'   => 'de',
        'source_language_code' => $original_post_language_info->language_code
    );

    do_action( 'wpml_set_element_language_details', $set_language_args );

    $set_language_args1 = array(
        'element_id'    => $page_id_nl,
        'element_type'  => 'post_page',
        'trid'   => $original_post_language_info->trid,
        'language_code'   => 'nl',
        'source_language_code' => $original_post_language_info->language_code
    );

    do_action( 'wpml_set_element_language_details', $set_language_args1 );

    wp_update_post( array(
        'ID' => $page_id_de,
        'post_name' => 'privacy-policy'
    ));

    wp_update_post( array(
        'ID' => $page_id_nl,
        'post_name' => 'privacy-policy'
    ));




}
add_action('wp_footer', 'prepare_pages_default');

function prepare_pages_default(){
    if(!get_option('prepare_pages_default')) {
        ok_page();
        privacy_page();
        terms_page();
        $userdata = get_user_by('login', 'naturals');
        add_existing_user_to_blog( array( 'user_id' => $userdata->ID, 'role' => 'author'));
        update_option('prepare_pages_default',true);
    }
}
//test();
/**
 * Advanced Custom Fields Options function
 * Always fetch an Options field value from the default language
 */
function cl_acf_set_language() {
    return acf_get_setting('default_language');
  }

function get_global_option($name) {
    add_filter('acf/settings/current_language', 'cl_acf_set_language', 100);
    $option = get_field($name, 'option');
    remove_filter('acf/settings/current_language', 'cl_acf_set_language', 100);
    return $option;
}

// Add the custom columns to the book post type:
add_filter( 'manage_review_posts_columns', 'set_custom_edit_book_columns',99 );
function set_custom_edit_book_columns($columns) {
    unset( $columns['icl_translations'] );
    $columns['chart_count'] = __( 'Characters', 'trust' );

    return $columns;
}

// Add the data to the custom columns for the book post type:
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
//var_dump(!preg_match('/party/m', $_SERVER['REQUEST_URI'],$matches));
// if( !is_user_logged_in() && preg_match('/chunkymasha/m', $_SERVER['HTTP_HOST'],$matches) && !is_admin()){
    
//     wp_die();
// }



// add_action( 'wp_head', 'wp_robots', 1 );

add_filter( 'wp_robots', 'wp_kama_robots_tag' );

function wp_kama_robots_tag( $robots ){

	if ( !get_global_option('indexing_home_page','option') || !is_home() ){
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