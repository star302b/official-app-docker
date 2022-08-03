<?php

class DeepLConfiguration {
	static function getAPIKey() {
		return apply_filters( __METHOD__, trim( get_option( 'wpdeepl_api_key' ) ) );
	}

	static function getLogLevel() {
		return apply_filters( __METHOD__, get_option( 'wpdeepl_log_level') );
	}
	
	static function getMetaBoxPostTypes() {
		return apply_filters( __METHOD__, get_option( 'wpdeepl_metabox_post_types' ) );
	}
	static function getMetaBoxDefaultBehaviour() {
		return apply_filters( __METHOD__, get_option( 'wpdeepl_metabox_behaviour' ) );
	}
	static function getDefaultTargetLanguage() {
		return apply_filters( __METHOD__, get_option( 'wpdeepl_default_language' ) );
	}
	static function getMetaBoxContext() {
		return apply_filters( __METHOD__, get_option( 'wpdeepl_metabox_context' ) );
	}
	static function getMetaBoxPriority() {
		return apply_filters( __METHOD__, get_option( 'wpdeepl_metabox_priority' ) );
	}

	static function usingMultilingualPlugins() {
		return false;
	}





/**
 * 0 = activated
 * 1 = activated and setup
 */
	static function isPluginInstalled() {
		return get_option( 'wpdeepl_plugin_installed' );
	}

	static function execWorks() {
		if( exec( 'echo EXEC' ) == 'EXEC' ){
		 return true;
		}
		return false;
	}

	static function validateLang( $language_string, $output = 'assource' ) {
		// output source will return 2 characters
		// output source will return AA(-AA)

		$language_string = filter_var( $language_string, FILTER_SANITIZE_STRING );
		$language_string = str_replace( '-', '_', $language_string );

		$all_languages = DeepLConfiguration::DefaultsAllLanguages();
		$locale = get_locale();

		$language = false;
		if( isset( $all_languages[$language_string] ) ) {
			$language = $all_languages[$language_string];
		}
		else {
			foreach( $all_languages as $locale => $try_language ) {
				if( $try_language['allcaps'] == strtoupper( $language_string ) ) {
					$language = $try_language;
					break;
				}
				if( $try_language['isocode'] == strtoupper( $language_string ) ) {
					$language = $try_language;
					break;
				}
			}
		}

		if( !$language ) {
			return false;
		}

		$language['label'] = $language['labels'][$locale];

		if( $output == 'assource' ) {
			return $language['assource'];
		}
		elseif( $output == 'astarget' ) {
			return $language['astarget'];
		}
		elseif( $output == 'isocode' ) {
			return $language['isocode'];
		}
		elseif( $output == 'full' ) {
			return $language;
		}
		elseif( $output == 'label' ) {
			
			return $language['label'];
		}
		else {
			return $language['isocode'];
		}
	}
	static function DefaultsMetaboxBehaviours() {
		$array = array(
			'replace'		=> __( 'Replace content', 'wpdeepl' ),
			'append'		=> __( 'Append to content', 'wpdeepl' )
		);
		return apply_filters( __METHOD__ , $array );
	}
	static function DefaultsISOCodes() {
		$locale = get_locale();
		$all_languages = DeepLConfiguration::DefaultsAllLanguages();
		$languages = array();
		foreach( $all_languages as $isocode => $labels ) {
			$languages[$isocode] = $labels['labels'][$locale];
		}
		return apply_filters( __METHOD__ , $languages );
	}

	static function DefaultsAllLanguages() {
		$languages = array(
			'fr_FR' => array(
				'labels' => array(
					'fr_FR' => 'français',
					'en_GB' => 'french',
					'en_US' => 'french',
					'de_DE' => 'französisch',
					'es_ES' => 'francés',
					'it_IT' => 'francese',
					'nl_NL' => 'frans',
					'pl_PL' => 'francuski',
					'ru_RU' => 'Французский',

					'pt_PT'	=> 'inglês',
					'pt_BR'	=> 'inglês',
					'ja_JP'	=> '英語',
					'cn_ZH'	=> '英国人的'						
				),
				'assource'	=> 'FR',
				'astarget'	=> 'FR',
				'allcaps'	=> 'FR_FR',
				'isocode'	=> 'FR',
			),
			'en_GB' => array(
				'labels' => array(
					'fr_FR' => 'anglais (UK)',
					'en_GB' => 'english (GB)',
					'en_US' => 'english (GB)',
					'de_DE' => 'englisch (UK)',
					'es_ES' => 'inglès (UK)',
					'it_IT' => 'inglese (UK)',
					'nl_NL' => 'engels (UK)',
					'pl_PL' => 'anglik (UK)',
					'ru_RU'	=> 'английски (UK)',
					'pt_PT'	=> 'Inglês (UK)',
					'pt_BR'	=> 'Inglês (UK)',
					'ja_JP'	=> 'イギリス英語 (UK)',
					'cn_ZH'	=> '英式英语 (UK)'							
				),
				'assource'	=> 'EN',
				'astarget'	=> 'EN-GB',
				'allcaps'	=> 'EN_GB',
				'isocode'	=> 'EN',
			),
			'en_US' => array(
				'labels' => array(
					'fr_FR' => 'anglais (US)',
					'en_GB' => 'english (US)',
					'en_US' => 'english (US)',
					'de_DE' => 'englisch (US)',
					'es_ES' => 'inglès (US)',
					'it_IT' => 'inglese (US)',
					'nl_NL' => 'engels (US)',
					'pl_PL' => 'anglik (US)',
					'ru_RU'	=> 'английски (US)',
					'pt_PT'	=> 'Inglês (US)',
					'pt_BR'	=> 'Inglês (US)',
					'ja_JP'	=> 'イギリス英語 (US)',
					'cn_ZH'	=> '英式英语 (US)'							
				),
				'assource'	=> 'EN',
				'astarget'	=> 'EN-US',
				'allcaps'	=> 'EN_US',
				'isocode'	=> 'EN',
			),			
			'de_DE' => array(
				'labels' => array(
					'fr_FR' => 'allemand',
					'en_GB' => 'german',
					'en_US' => 'german',
					'de_DE' => 'deutsch',
					'es_ES' => 'alemán',
					'it_IT' => 'allemando',
					'nl_NL' => 'allemandrijk',
					'pl_PL' => 'niemiec',
					'ru_RU'	=> 'немецки',
					'pt_PT'	=> 'Alemão',
					'pt_BR'	=> 'Alemão',
					'ja_JP'	=> 'ドイツ語',
					'cn_ZH'	=> '德国'							
				),
				'assource'	=> 'DE',
				'astarget'	=> 'DE',
				'allcaps'	=> 'DE_DE',
				'isocode'	=> 'DE',
			),
			'es_ES' => array(
				'labels' => array(
					'fr_FR' => 'espagnol',
					'en_GB' => 'spanish',
					'en_US' => 'spanish',
					'de_DE' => 'spanisch',
					'es_ES' => 'castellano',
					'it_IT' => 'spagnola',
					'nl_NL' => 'spaans',
					'pl_PL' => 'hiszpanin',
					'ru_RU' => 'испански',
					'pt_PT'	=> 'Espanhol',
					'pt_BR'	=> 'Espanhol',
					'ja_JP'	=> 'スペイン語',
					'cn_ZH'	=> '西班牙语'							
				),
				'assource'	=> 'ES',
				'astarget'	=> 'ES',
				'allcaps'	=> 'ES_ES',
				'isocode'	=> 'ES',
			),
			'it_IT' => array(
				'labels' => array(
					'fr_FR' => 'italien',
					'en_GB' => 'italian',
					'en_US' => 'italian',
					'de_DE' => 'italienisch',
					'es_ES' => 'italiano',
					'it_IT' => 'italiano',
					'nl_NL' => 'italiaan',
					'pl_PL' => 'włoch',
					'ru_RU' => 'итальянски',
					'pt_PT'	=> 'Italiano',
					'pt_BR'	=> 'Italiano',
					'ja_JP'	=> 'イタリア語',
					'cn_ZH'	=> '意大利'							
				),
				'assource'	=> 'IT',
				'astarget'	=> 'IT',
				'allcaps'	=> 'IT_IT',
				'isocode'	=> 'IT',
			),
			'nl_NL' => array(
				'labels' => array(
					'fr_FR' => 'néerlandais',
					'en_GB' => 'dutch',
					'en_US' => 'dutch',
					'de_DE' => 'holländisch',
					'es_ES' => 'neerlandés',
					'it_IT' => 'olandese',
					'nl_NL' => 'hollands',
					'pl_PL' => 'holender',
					'ru_RU' => 'голландски',
					'pt_PT'	=> 'Holandês',
					'pt_BR'	=> 'Holandês',
					'ja_JP'	=> '蘭語',
					'cn_ZH'	=> '荷兰语'						
				),
				'assource'	=> 'NL',
				'astarget'	=> 'NL',
				'allcaps'	=> 'NL_NL',
				'isocode'	=> 'NL',
			),

			'pl_PL' => array(
				'labels' => array(
					'fr_FR' => 'polonais',
					'en_GB' => 'polish',
					'en_US' => 'polish',
					'de_DE' => 'polnisch',
					'es_ES' => 'polaco',
					'it_IT' => 'polacca',
					'nl_NL' => 'pools',
					'pl_PL' => 'polak',
					'ru_RU' => 'польски',
					'pt_PT'	=> 'Polaco',
					'pt_BR'	=> 'Polonês',
					'ja_JP'	=> 'ポーランド語',
					'cn_ZH'	=> '波兰语'							
				),
				'assource'	=> 'PL',
				'astarget'	=> 'PL',
				'allcaps'	=> 'PL_PL',
				'isocode'	=> 'PL',
			),
			'ru_RU' => array(
				'labels' => array(
					'fr_FR' => 'russe',
					'en_GB' => 'russian',
					'en_US' => 'russian',
					'de_DE' => 'russisch',
					'es_ES' => 'ruso',
					'it_IT' => 'russo',
					'nl_NL' => 'russisch',
					'pl_PL' => 'rosjanin',
					'ru_RU'	=> 'русский',
					'pt_PT'	=> 'Russo',
					'pt_BR'	=> 'Russo',
					'ja_JP'	=> 'ロシア語',
					'cn_ZH'	=> '俄语'							
				),
				'assource'	=> 'RU',
				'astarget'	=> 'RU',
				'allcaps'	=> 'RU_RU',
				'isocode'	=> 'RU',
			),			
			
			
			'pt_PT' => array(
				'labels' => array(
					'fr_FR' => 'portugais',
					'en_GB' => 'Portuguese',
					'en_US' => 'Portuguese',
					'de_DE' => 'Portugiesisch',
					'es_ES' => 'Portugués',
					'it_IT' => 'Portoghese',
					'nl_NL' => 'Portugees',
					'pl_PL' => 'Portugalski',
					'ru_RU' => 'Португальский',
					'pt_PT'	=> 'Português',
					'pt_BR'	=> 'Português Brasileiro',
					'ja_JP'	=> 'ポルトガル語',
					'cn_ZH'	=> '葡萄牙语'							
				),
				'assource'	=> 'PT',
				'astarget'	=> 'PT-PT',
				'allcaps'	=> 'PT_PT',
				'isocode'	=> 'PT',
			),
			'pt_BR' => array(
				'labels' => array(
					'fr_FR' => 'portugais du Brésil',
					'en_GB' => 'Brazilian Portuguese',
					'en_US' => 'Brazilian Portuguese',
					'de_DE' => 'Brasilianisches Portugiesisch',
					'es_ES' => 'Portugués de Brasil',
					'it_IT' => 'Portoghese brasiliano',
					'nl_NL' => 'Braziliaans Portugees',
					'pl_PL' => 'Brazylijczyk-Portugalczyk',
					'ru_RU' => 'бразильский португальский',
					'pt_PT'	=> 'Português',
					'pt_BR'	=> 'Português do Brasil',
					'ja_JP'	=> 'ブラジルポルトガル語',
					'cn_ZH'	=> '巴西葡萄牙语'									
				),
				'assource'	=> 'PT',
				'astarget'	=> 'PT-BR',
				'allcaps'	=> 'PT_BR',
				'isocode'	=> 'PT',
			),
									
			'ja_JP'	=> array(
				'labels'	=> array(
					'fr_FR' => 'japonais',
					'en_GB' => 'japanese',
					'en_US' => 'japanese',
					'de_DE' => 'Japanisch',
					'es_ES' => 'Japonés',
					'it_IT' => 'Giapponese',
					'nl_NL' => 'Japans',
					'pl_PL' => 'Japończyk',
					'ru_RU' => 'Японский',
					'pt_PT'	=> 'Japonês',
					'pt_BR'	=> 'Japonês',
					'ja_JP'	=> 'にほんご',
					'cn_ZH'	=> '日文',
				),
				'assource'	=> 'JA',
				'astarget'	=> 'JA',
				'allcaps'	=> 'JA_JP',
				'isocode'	=> 'JA',
			),
			'cn_ZH'	=> array(
				'labels'	=> array(
					'fr_FR' => 'chinois simplifié',
					'en_GB' => 'simplified chinese',
					'en_US' => 'simplified chinese',
					'de_DE' => 'chinesische',
					'es_ES' => 'lengua china',
					'it_IT' => 'cinese',
					'nl_NL' => 'chinese taal',
					'pl_PL' => 'Język chiński',
					'ru_RU' => 'китайский язык',
					'pt_PT'	=> 'Chinês',
					'pt_BR'	=> 'Chinês',
					'ja_JP'	=> 'ちゅうごくご',
					'cn_ZH'	=> '中文'			
				),
				'assource'	=> 'ZH',
				'astarget'	=> 'ZH',
				'allcaps'	=> 'CN_ZH',
				'isocode'	=> 'ZH',
			),
		);
		return apply_filters( __METHOD__, $languages );

		// used for.. something else
		$test = __('Translate to %s', 'wpdeepl' );
		$test = __('Translated %d posts.', 'wpdeepl');
		$test = __('Bulk translate', 'wpdeepl');
		$test = __('Content types', 'wpdeepl');
		$test = __( 'Translate contents', 'wpdeepl' );
		$test = __( 'Select which kind of content you want to be able to translate', 'wpdeepl' );
		$test = __( 'Target languages for bulk actions', 'wpdeepl' );
		$test = __( 'Show these target languages in bulk menu', 'wpdeepl' );
	}

 // might serve somewhere
 	static function getContentTypes() {
		return apply_filters( __METHOD__, get_option('wpdeepl_contents_to_translate') );
	}
	static function getTargetLocales() {
		return apply_filters( __METHOD__, get_option( 'wpdeepl_target_locales') );
	}

	static function usingPolylang() {
		return function_exists( 'pll_the_languages' );
	}

	static function getBulkTargetLanguages() {
		return apply_filters( __METHOD__, get_option( 'wpdeepl_bulk_target_locales' ) );
	}	
}

