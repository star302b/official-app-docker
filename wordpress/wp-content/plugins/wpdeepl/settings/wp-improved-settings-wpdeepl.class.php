<?php

if( !class_exists( 'WP_Improved_Settings\WP_Improved_Settings' ) ) {
	require( dirname( __FILE__ ) . '/wp-improved-settings.class.php' );
}

class WP_Improved_Settings_DeepL extends WP_Improved_Settings\WP_Improved_Settings {
	public $plugin_id = 'wpdeepl';
	public $option_page = 'deepl_settings';
	public $menu_order = 15;
	public $parent_menu = 'options-general.php';
	public $defaultSettingsTab = 'ids';
	public $extendedActions = array();


	static function geti18nDomain() {
		return 'wpdeepl';
	}

	static function getPageTitle() {
		return __( 'DeepL settings', 'wpdeepl' );
	}

	static function getMenuTitle() {
		return __( 'DeepL translation', 'wpdeepl' );
	}

	function on_save() {
		update_option( 'deepl_plugin_installed', 1 );

		if( $_REQUEST['tab'] == 'cron_jobs' ) {
		}
	}



	function maybe_print_notices() {
		$fully_configured = deepl_is_plugin_fully_configured();
		if( $fully_configured !== true ) {
			$class = 'notice notice-error';

			$messages = array();

			if( is_wp_error( $fully_configured ) ) {
				foreach( $fully_configured->get_error_codes() as $error_code ) {
					foreach( $fully_configured->get_error_messages( $error_code ) as $error_message ) {
						$messages[] = sprintf(
							__( '<li><a href="%s">%s</a></li>', 'wpdeepl' ),
							admin_url( '/admin.php?page=deepl_settings&tab=' . $error_code ),
							$error_message
						);
					}
				}
			}
			$message = sprintf(
				__( 'The DeepL plugin is not fully configured yet: <ul>%s</ul>', 'wpdeepl' ),
				implode( "\n", $messages )
			);
			if( count( $messages ) ) {
				$message .= sprintf(
					__( '<a href="%s">Please provide required informations</a>', 'wpdeepl' ),
					admin_url( '/admin.php?page=deepl_settings' )
				);
			}

			printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), ( $message ) );
		}
	}

	function getSettingsStructure() {
		$settings = array(
			'ids'			=> array(
				'title'			=> __( 'Credentials', 'wpdeepl' ),
				'sections'		=> array()
			),
			'translation' 	=> array(
				'title'			=> __( 'Translation', 'wpdeepl' ),
				'sections'		=> array()
			),
			'integration'	=> array(
				'title'			=> __( 'Integration', 'wpdeepl' ),
				'sections'		=> array()
			),
			'maintenance'	=> array(
				'title'			=> __('Maintenance', 'wpdeepl' ),
				'sections'		=> array(),
			),

		);

		/** IDS **/
		$settings['ids']['sections']['identifiants'] = array(
			'title'			=> __( 'DeepL credentials', 'wpdeepl' ),
			'fields'	=> array(

				array(
					'id'			=> 'api_key',
					'title'			=> __( 'API Key', 'wpdeepl' ),
					'type'			=> 'text',
					'css'			=> 'width: 20em;',
					'description'	=> sprintf(
						__( '<a target="_blank" href="%s">Create a DeepL Pro account here</a>. Get your <a target="_blank" href="%s">API key there</a>', 'wpdeepl' ),
						'https://www.deepl.com/pro.html',
						'https://www.deepl.com/pro-account.html'
					),
				),

			)
		);
		if( DeepLConfiguration::getAPIKey() ) {
			$settings['ids']['footer']['actions'] = array( 'deepl_show_usage' );
		/** END IDS **/

		/** TRANSLATION **/

		$settings['translation']['sections']['languages'] = array(
			'title'		=> __( 'Translation', 'wpdeepl' ),
			'fields'	=> array(
					array(
						'id'			=> 'default_language',
						'title'			=> __( 'Default target language', 'wpdeepl' ),
						'type'			=> 'select',
						'options'		=> DeepLConfiguration::DefaultsISOCodes(),
						'default'		=> substr( get_locale(), 0, 2 ),
					),
			)
		);
		}

		/** END TRANSLATION **/

		/** INTEGRATION **/
		$wp_post_types = get_post_types( array( 'public'	=> true, 'show_ui' => true ), 'objects' );
		$post_types = array();
		if( $wp_post_types ) foreach( $wp_post_types as $post_type => $WP_Post_Type ) {
			$post_types[$post_type] = $WP_Post_Type->label;
		}

		$default_metabox_behaviours = DeepLConfiguration::DefaultsMetaboxBehaviours();

		//plouf($post_types); 		plouf( DeeplConfiguration::getMetaBoxPostTypes() , "saved");

		$settings['integration']['sections']['metabox'] = array(
			'title'			=> __( 'Metabox', 'wpdeepl' ),
			'fields'	=> array(
				array(
					'id'			=> 'metabox_post_types',
					'title'			=> __( 'Metabox should be displayed on:', 'wpdeepl' ),
					'type'			=> 'multiselect',
					'options'		=> $post_types,
					'default'		=> array( 'post', 'page' ),
					'description'	=> __( 'Select which post types you want the metabox to appear on', 'wpdeepl' ),
 				),
				array(
					'id'			=> 'metabox_behaviour',
					'title'			=> __( 'Metabox behaviour', 'wpdeepl' ),
					'type'			=> 'radio',
					'values'		=> $default_metabox_behaviours,
					'default'		=> 'replace',
					'description'	=> __( 'For content to be appended, you need to use a supported multilingual plugin', 'wpdeepl' ),
 				),
 				array(
					'id'			=> 'metabox_context',
					'title'			=> __( 'Metabox context', 'wpdeepl' ),
					'type'			=> 'select',
					'options'		=> array(
						'normal' 		=> 'normal',
						 'side' 		=> 'side',
						 'advanced'		=> 'advanced'
					),
					'default'		=> 'side',
					'description'	=> __('<a href="https://developer.wordpress.org/reference/functions/add_meta_box/">See add_meta_box function reference</a>','wpdeepl' ),
 				),
 				array(
					'id'			=> 'metabox_priority',
					'title'			=> __( 'Metabox priority', 'wpdeepl' ),
					'type'			=> 'select',
					'options'		=> array(
						'high'			=> 'high',
						'low'			=> 'low'
					),
					'default'		=> 'high',
					'description'	=> '',
 				),
			)
		);

		$settings['maintenance']['sections']['logs'] = array(
			'title'		=> __('Logging', 'wpdeepl' ),
			'fields'	=> array(
				array(
					'id'			=> 'log_level',
					'title'			=> __( 'Log level', 'wpdeepl' ),
					'type'			=> 'select',
					'options'		=> array(
						'0'	=> __('None','wpdeepl' ),
						'1'	=> __('Minimal','wpdeepl' ),
						'2'	=> __('Full','wpdeepl' ),
					),
					'default'		=> 0,
 				),
			)
		);

		$message = 
			'<a href="' 
			. get_admin_url(null, 'admin.php?page=' . $this->option_page . '&tab=maintenance&prune_logs=1' ) 
			.'" class="button button-primary">' 
			. __( 'Delete logs from previous months', 'wpdeepl' ) 
			. '</a>';

		$settings['maintenance']['footer']['html'] = array( $message );

		$settings['maintenance']['footer']['actions'] = array( array( $this, 'showServerInfo'), array( $this, 'showLogs') );


		return apply_filters( 'deepl_admin_configuration', $settings );
	}
}