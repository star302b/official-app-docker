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
					'fr_FR' => 'fran??ais',
					'en_GB' => 'french',
					'en_US' => 'french',
					'de_DE' => 'franz??sisch',
					'es_ES' => 'franc??s',
					'it_IT' => 'francese',
					'nl_NL' => 'frans',
					'pl_PL' => 'francuski',
					'ru_RU' => '??????????????????????',

					'pt_PT'	=> 'ingl??s',
					'pt_BR'	=> 'ingl??s',
					'ja_JP'	=> '??????',
					'cn_ZH'	=> '????????????'						
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
					'es_ES' => 'ingl??s (UK)',
					'it_IT' => 'inglese (UK)',
					'nl_NL' => 'engels (UK)',
					'pl_PL' => 'anglik (UK)',
					'ru_RU'	=> '?????????????????? (UK)',
					'pt_PT'	=> 'Ingl??s (UK)',
					'pt_BR'	=> 'Ingl??s (UK)',
					'ja_JP'	=> '?????????????????? (UK)',
					'cn_ZH'	=> '???????????? (UK)'							
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
					'es_ES' => 'ingl??s (US)',
					'it_IT' => 'inglese (US)',
					'nl_NL' => 'engels (US)',
					'pl_PL' => 'anglik (US)',
					'ru_RU'	=> '?????????????????? (US)',
					'pt_PT'	=> 'Ingl??s (US)',
					'pt_BR'	=> 'Ingl??s (US)',
					'ja_JP'	=> '?????????????????? (US)',
					'cn_ZH'	=> '???????????? (US)'							
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
					'es_ES' => 'alem??n',
					'it_IT' => 'allemando',
					'nl_NL' => 'allemandrijk',
					'pl_PL' => 'niemiec',
					'ru_RU'	=> '??????????????',
					'pt_PT'	=> 'Alem??o',
					'pt_BR'	=> 'Alem??o',
					'ja_JP'	=> '????????????',
					'cn_ZH'	=> '??????'							
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
					'ru_RU' => '????????????????',
					'pt_PT'	=> 'Espanhol',
					'pt_BR'	=> 'Espanhol',
					'ja_JP'	=> '???????????????',
					'cn_ZH'	=> '????????????'							
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
					'pl_PL' => 'w??och',
					'ru_RU' => '????????????????????',
					'pt_PT'	=> 'Italiano',
					'pt_BR'	=> 'Italiano',
					'ja_JP'	=> '???????????????',
					'cn_ZH'	=> '?????????'							
				),
				'assource'	=> 'IT',
				'astarget'	=> 'IT',
				'allcaps'	=> 'IT_IT',
				'isocode'	=> 'IT',
			),
			'nl_NL' => array(
				'labels' => array(
					'fr_FR' => 'n??erlandais',
					'en_GB' => 'dutch',
					'en_US' => 'dutch',
					'de_DE' => 'holl??ndisch',
					'es_ES' => 'neerland??s',
					'it_IT' => 'olandese',
					'nl_NL' => 'hollands',
					'pl_PL' => 'holender',
					'ru_RU' => '????????????????????',
					'pt_PT'	=> 'Holand??s',
					'pt_BR'	=> 'Holand??s',
					'ja_JP'	=> '??????',
					'cn_ZH'	=> '?????????'						
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
					'ru_RU' => '??????????????',
					'pt_PT'	=> 'Polaco',
					'pt_BR'	=> 'Polon??s',
					'ja_JP'	=> '??????????????????',
					'cn_ZH'	=> '?????????'							
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
					'ru_RU'	=> '??????????????',
					'pt_PT'	=> 'Russo',
					'pt_BR'	=> 'Russo',
					'ja_JP'	=> '????????????',
					'cn_ZH'	=> '??????'							
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
					'es_ES' => 'Portugu??s',
					'it_IT' => 'Portoghese',
					'nl_NL' => 'Portugees',
					'pl_PL' => 'Portugalski',
					'ru_RU' => '??????????????????????????',
					'pt_PT'	=> 'Portugu??s',
					'pt_BR'	=> 'Portugu??s Brasileiro',
					'ja_JP'	=> '??????????????????',
					'cn_ZH'	=> '????????????'							
				),
				'assource'	=> 'PT',
				'astarget'	=> 'PT-PT',
				'allcaps'	=> 'PT_PT',
				'isocode'	=> 'PT',
			),
			'pt_BR' => array(
				'labels' => array(
					'fr_FR' => 'portugais du Br??sil',
					'en_GB' => 'Brazilian Portuguese',
					'en_US' => 'Brazilian Portuguese',
					'de_DE' => 'Brasilianisches Portugiesisch',
					'es_ES' => 'Portugu??s de Brasil',
					'it_IT' => 'Portoghese brasiliano',
					'nl_NL' => 'Braziliaans Portugees',
					'pl_PL' => 'Brazylijczyk-Portugalczyk',
					'ru_RU' => '?????????????????????? ??????????????????????????',
					'pt_PT'	=> 'Portugu??s',
					'pt_BR'	=> 'Portugu??s do Brasil',
					'ja_JP'	=> '??????????????????????????????',
					'cn_ZH'	=> '??????????????????'									
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
					'es_ES' => 'Japon??s',
					'it_IT' => 'Giapponese',
					'nl_NL' => 'Japans',
					'pl_PL' => 'Japo??czyk',
					'ru_RU' => '????????????????',
					'pt_PT'	=> 'Japon??s',
					'pt_BR'	=> 'Japon??s',
					'ja_JP'	=> '????????????',
					'cn_ZH'	=> '??????',
				),
				'assource'	=> 'JA',
				'astarget'	=> 'JA',
				'allcaps'	=> 'JA_JP',
				'isocode'	=> 'JA',
			),
			'cn_ZH'	=> array(
				'labels'	=> array(
					'fr_FR' => 'chinois simplifi??',
					'en_GB' => 'simplified chinese',
					'en_US' => 'simplified chinese',
					'de_DE' => 'chinesische',
					'es_ES' => 'lengua china',
					'it_IT' => 'cinese',
					'nl_NL' => 'chinese taal',
					'pl_PL' => 'J??zyk chi??ski',
					'ru_RU' => '?????????????????? ????????',
					'pt_PT'	=> 'Chin??s',
					'pt_BR'	=> 'Chin??s',
					'ja_JP'	=> '??????????????????',
					'cn_ZH'	=> '??????'			
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

