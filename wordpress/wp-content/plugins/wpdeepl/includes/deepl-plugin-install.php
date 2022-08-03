<?php


function deepl_install_plugin() {
	if( !get_option( 'deepl_plugin_installed') ) {
		update_option( 'deepl_plugin_installed', 0 );
	}
	if( !get_option( 'wpdeepl_metabox_post_types') ) {
		update_option( 'wpdeepl_metabox_post_types', array( 'post', 'page' ));
	}

	if( !get_option( 'wpdeepl_metabox_context') ) {
		update_option('wpdeepl_metabox_context','side');
	}
	if( !get_option( 'wpdeepl_metabox_priority' ) ) {
		update_option('wpdeepl_metabox_priority','high');
	}
	
}