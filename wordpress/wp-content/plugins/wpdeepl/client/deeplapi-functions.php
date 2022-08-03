<?php

function deepl_translate( $source_lang = false, $target_lang, $strings = array(), $cache_prefix = '' ) {
		$DeepLApiTranslate = new DeepLApiTranslate();
		$DeepLApiTranslate->setCachePrefix( $cache_prefix );

		if( $source_lang ) {
			$DeepLApiTranslate->setLangFrom( $source_lang );
		}

		//var_dump($target_lang);		die('ok');
		if( !$DeepLApiTranslate->setLangTo( $target_lang ) ) {
			return new WP_Error( sprintf( __( "Target language '%s' not valid", 'wpdeepl' ), $target_lang ) );
		}

		$DeepLApiTranslate->setTagHandling( 'xml' );


		$translations = $DeepLApiTranslate->getTranslations( $strings );

		if( is_wp_error( $translations ) ) {
			return $translations;
		}
		$request = array(
			'cached'				=> $DeepLApiTranslate->wasItCached(),
			'time'					=> $DeepLApiTranslate->getTimeElapsed(),
			'cache_file_request'	=> $DeepLApiTranslate->getCacheFile( 'request' ),
			'cache_file_response'	=> $DeepLApiTranslate->getCacheFile( 'response' ),
		);


		$return = compact( 'request', 'translations' );
		return apply_filters( 'deepl_translate', $return, $source_lang, $target_lang, $strings, $cache_prefix );
}

	
function deepl_show_usage() {
	?>
		<h3><?php _e( 'Usage', 'wpdeepl' ); ?></h3>
		<?php
		$DeepLApiUsage = new DeepLApiUsage();
		$usage = $DeepLApiUsage->request();

		//plouf($usage);		plouf($DeepLApiUsage);

		if( $usage && is_array( $usage ) && array_key_exists( 'character_count', $usage ) && array_key_exists( 'character_limit', $usage )) :
			$ratio = round( 100 * ( $usage['character_count'] / $usage['character_limit'] ), 3 );
			$left_chars = $usage['character_limit'] - $usage['character_count'];

		?>
		<div class="progress-bar blue">
			<span style="width: <?php echo round( (100 - $ratio ), 0 ); ?>%"><b><?php printf( __( '%s characters remaining', 'wpdeepl' ), number_format( $left_chars )); ?></b></span>
			<div class="progress-text"><?php
			printf( __( '%s / %s characters translated', 'wpdeepl' ), number_format_i18n( $usage['character_count'] ), number_format_i18n( $usage['character_limit'] ) );
			 echo " - " . $ratio; ?> %</div>
			 <small class="request_time"><?php printf( __( 'Request done in: %f milliseconds', 'wpdeepl' ), $DeepLApiUsage->getRequestTime( true )) ?></small>
		</div>
		<?php
		endif;
}
