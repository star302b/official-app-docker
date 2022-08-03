/* version 1.5.2.8 - 20201020 */
jQuery(document).ready(function() {

	// disable for gutenberg, waiting for a decent API
	/*
	if(wp && wp.data && wp.data.select( "core/editor" )) {
		var warning = jQuery('#deepl_metabox .hidden_warning').html();
		jQuery('#deepl_metabox div.inside').html(warning);

	}
*/
	//console.log("allo");	console.dir(DeepLStrings.extended_fields);


	if( jQuery('select[name="post_lang_choice"]').length ) {
		// polylang : langue cible = langue courante de polylang
		var current_language = jQuery('select[name="post_lang_choice"]').find(':selected').attr('lang');
		current_language = current_language.replace('-', '_');
		jQuery('select#deepl_target_lang option[value="' + current_language + '"]').prop('selected', true );
	}

jQuery( "#deepl_translate" ).on( "click", function() {

	var is_gutenberg = jQuery('.wp-block').length;
	var is_classic_editor = jQuery('.wp-editor-area').length;

	if(is_gutenberg) {
		console.log("is gutenberg");
		is_classic_editor = false;
	}
	if(is_classic_editor) console.log(" classic editor plugin");

	jQuery( '#deepl_spinner' ).css( 'visibility', 'visible' );

	var should_we_replace = jQuery( 'input[name="deepl_replace"]:checked' ).val();
	var target_lang = jQuery( '#deepl_target_lang' ).val();
	var text_bits = {};

	if(is_gutenberg) {

		const { select } = wp.data;		
		text_bits['post_title'] = select("core/editor").getEditedPostAttribute( 'title' );
		text_bits['post_excerpt'] = select("core/editor").getEditedPostAttribute( 'excerpt' );
		text_bits['post_content'] = select("core/editor").getEditedPostAttribute( 'content' );
	}
	else {
		text_bits['post_title'] = jQuery( 'input[name="post_title"]' ).val();
		text_bits['post_excerpt'] = jQuery( 'textarea[name="excerpt"]' ).val();

		var classic_editor_visual = false;
		var classic_editor_text = false;
		if( jQuery( '#content.wp-editor-area' ).val() !== undefined ) {
			var classic_editor_text = true;
		}
		else {
			console.log("empty text editor ?");
			console.log("Please send me an email to test your installation");
		}
		if( jQuery( '#content_ifr' ).contents().find( '#tinymce' ).html() !== undefined ) {
			var classic_editor_visual = true;
		}

		text_bits['post_content'] = jQuery( '#content.wp-editor-area' ).val();
	/*	if( classic_editor_text ) {

		}
		else if( classic_editor_visual) {
			text_bits['post_content'] = jQuery( '#content_ifr' ).contents().find( '#tinymce' ).html();
		}
		else {
			console.log("no post content. Exotic editor ?");
		}*/

	}

	if(DeepLStrings.extended_fields) {
		var fields = DeepLStrings.extended_fields.split(',');
		fields.forEach(function(field) {
			var value = jQuery('*[name="acf[' + field + ']"]').val();
			console.log(field);			console.log(value);
			text_bits['acf_' + field] = value;
		});
	}


//	JSON.stringify(text_bits);

	var data = {
	 	action: 'deepl_translate',
	 	post_id: jQuery( 'input[name="post_ID"]' ).val(),
	 	to_translate: text_bits,
	 	source_lang: jQuery( '#deepl_source_lang' ).val(),
	 	target_lang: target_lang,
	 	nonce: jQuery( '#deepl_nonce' ).val(),
	 	};

	 console.log( "AJAX parameters call" );
	 console.dir( data );
	 // stop
	 //jQuery( '#deepl_spinner' ).css( 'visibility', 'hidden' );	 return false;

	 jQuery.post( ajaxurl, data, function( responses ) {
	  	console.log( "Responses from API" ); console.dir( responses );



	  	/*if(responses != undefined && responses.data != undefined && responses.data.request.cached) {
	  		console.log("Résultats en cache");
	  	}
	  	else {
	  		console.log("Nouvelle requête");
	  		console.log("Exécutée en " + responses.data.request.time + " millisecondes");
	  	}*/

	  	if( !responses.success ) {
	  		jQuery('#deepl_metabox #deepl_error').html( responses.data[0] );
	  		jQuery('#deepl_metabox #deepl_error').css('display', 'block');
	  	}
	  	else {

		 	jQuery.each( responses.data.translations, function( index, value ) {
		 		console.log( "index = " + index );
		 		console.log(" text = " + value +  " VERSUS " + value.replace( /\\( . )/mg, "$1" ));

		 		if( index == 'post_title' ) {
		 			if( should_we_replace == 'replace' ) {
		 				var new_value = value.replace( /\\( . )/mg, "$1" )
		 			}
		 			else {
		 				var new_value = text_bits['post_title'] + '<lang="' + target_lang + '">' + value + '</lang>';
		 			}
		 			if(is_gutenberg) {
		 				wp.data.dispatch( 'core/editor' ).editPost( { title: new_value } )
		 				//jQuery('.editor-post-title textarea').val(new_value);
		 			}
		 			else {
		 				jQuery( 'input[name="post_title"]' ).val(new_value);
		 			}
		 		}
		 		else if( index == 'post_excerpt' ) {
		 			if( should_we_replace == 'replace' ) {
		 				var new_value = value.replace( /\\( . )/mg, "$1" )
		 			}
		 			else {
		 				var new_value = text_bits['post_excerpt'] + '<lang="' + target_lang + '">' + value + '</lang>';
		 			}
		 			if(is_gutenberg) {
		 				wp.data.dispatch( 'core/editor' ).editPost( { excerpt: new_value } )
		 			}
		 			else {
		 				jQuery( 'textarea[name="excerpt"]' ).val(new_value);
		 			}
		 		}
		 		else if(index == 'post_content') {

		 			if( should_we_replace == 'replace' ) {
		 				var new_value = value.replace( /\\( . )/mg, "$1" )
		 			}
		 			else {
		 				var new_value = text_bits['post_content'] + '<lang="' + target_lang + '">' + value + '</lang>';
		 			}

		 			console.log(" post content is gonna be " + new_value );

		 			if( is_gutenberg ) {
		 				console.log("replacing gutenberg post  content");
		 				//const { select } = wp.data;	 				console.log("old");	 				console.dir(select("core/editor").getEditedPostAttribute( 'content' ));

		 				if( should_we_replace ) {
		 					wp.data.dispatch( 'core/block-editor' ).resetBlocks([]);
		 				}
		 				// si seulement ! wp.data.dispatch('core/editor').editPost( {content: new_value });

		 				// en editeur de code 
		 				if( jQuery('textarea.editor-post-text-editor').val() !== undefined ) {
		 					console.log("editeur de code");
		 					jQuery('textarea.editor-post-text-editor').val(new_value);
		 				}
		 				else {

		 					console.log("------------------------------");
			 				//var pattern = /<!-- wp:paragraph -->\s*?(\S.+?\S)\s*?<!-- \/wp:paragraph -->/g;
			 				//var pattern = /<!-- wp:paragraph -->\s*?<p id="anchor[^>]*?>(.+?)<\/p>\s*?<!-- \/wp:paragraph -->/g;
			 				var pattern = /<!-- wp:.*? -->\s*?.+?\s*?<!-- \/wp:[a-z]+? -->/g;
			 				var pattern = /<!-- wp:.*? -->(\s*?.+?\s*?)<!-- \/wp:[a-z]+? -->/g;
			 				var blocks = [];
			 				while( match = pattern.exec( new_value ) ) {
			 					console.log("match");	 					console.dir( match);
			 					blocks.push( match[1] );
			 				}

			 				if( blocks.length == 0 ) {
			 					blocks.push( new_value );

			 				}	 					
			 					
		 				//var blocks = new_value.match( pattern );

			 				//console.log("new post_contnt");	 				console.dir( new_value);
			 				console.log("blocks a jouter");	 				console.dir(blocks);


			 				if( blocks && blocks.length > 0 ) {
			 					for (var i = 0; i < blocks.length; i++) {

				 					var content = blocks[i];
				 					//content = content.replace('<!-- wp:paragraph -->', '');
				 					//content = content.replace('<!-- /wp:paragraph -->', '');
				 					content = content.trim();
				 					console.log("contenu du bloc = ");	 					console.dir(content);

				 					var p_pattern = /<p>(\s*?.+?\s*?)<\/p>/g;
				 					if( match = p_pattern.exec( content ) ) {
				 						console.log(" paragraphe détecté");
				 						console.dir(match);
				 						content = match[1];
				 					}

				 					var broken_deepl_linebreak_pattern = /(.+?)<\/br>$/g;
				 					if( match = broken_deepl_linebreak_pattern.exec( content ) ) {
				 						console.log(" ugly line break détecté");
				 						console.dir(match);
				 						content = match[1];	
				 					}
				 					console.log("contenu du bloc = ");	 					console.dir(content);
					 				var newBlock = wp.blocks.createBlock( "core/paragraph", {
				    					content: content
									});
									console.log("ajout block");								console.dir(newBlock);
									var inserted = wp.data.dispatch( "core/block-editor" ).insertBlocks( newBlock );
									//console.log( "inserted  = "); 								console.dir(inserted);

				 				}
			 				}
		 					console.log("------------------------------");
		 				}



		 				//wp.data.dispatch( 'core/editor' ).editPost( { content: new_value } )
		 			}
		 			else if( is_classic_editor ) {
		 				console.log("is classic editor");

		 				
						/*

						*/

		 				
		 				if( classic_editor_visual ) {
		 					console.log("mode visuel");
		 					/*var splitted = new_value.split("\n");
							console.log("splitted");
							console.dir(splitted);
							var new_html = '';
							for( var i = 0; i < splitted.length; i ++ ) {
								if( splitted[i].length ) {
									new_html = new_html + '<p>' + splitted[i] + "</p>\n\n";
								}
							}
							console.log("1 post_content modifie =");
			 				console.dir( new_html );
							*/
							//jQuery( '#content_ifr' ).contents().find( '#tinymce' ).html( new_html );
			 				
			 				//jQuery( '#content.wp-editor-area' ).val( new_value );
			 				//jQuery( '#content_ifr' ).contents().find( '#tinymce' ).html( new_value );
			 				//jQuery('#tinymce').html('');			 				jQuery('#tinymce').html(new_value);

			 				//new_html = new_value.replace(/([^>]{1})\s*?\n\s*?([^<]{1})/gmu, '\1<br />\2');
			 				//new_html = new_value.replace(/[^>]{1}(\s*?\n\s*?)[^<]{1}/gmu, '<br />');
			 				//new_html = new_value.replace( /([^>\s]{1})(\s*?\n\s*?)([^<\s]{1})/gmu, '\1<br>\2');
			 				new_html = new_value;
			 				console.log("1 post_content modifie =");
			 				console.dir( new_html );
			 				var editor = tinyMCE.get('content'); 
							//var content = editor.getContent();							console.log("tiny content");							console.dir(content);
							//content = content.replace(/{\$baseurl}/g, 'http://mydomain.com');
							editor.setContent(new_html);

		 				}
		 				else if( classic_editor_text ) {
		 					new_value = new_value.replace(/\n\s*\n/g, '\n');
		 					console.log("mode texte");
		 					console.log("2 post_content modifie =");
			 				console.dir( new_value );
		 					jQuery( '#content.wp-editor-area' ).val( new_value );
		 				}

		 			}
		 			else {
		 				console.log(" default editor");
		 				new_value = new_value.replace
		 				jQuery( '#content_ifr' ).contents().find( '#tinymce' ).html( new_value );
		 			}

		 				/*jQuery( '#content_ifr' ).contents().find( '#tinymce' ).html( value.replace( /\\( . )/mg, "$1" ));
		 			}
		 			else {
		 				jQuery( '#content_ifr' ).contents().find( '#tinymce' ).html( 
		 					jQuery( '#content_ifr' ).contents().find( '#tinymce' ).html()
		 					+ '<lang="' + target_lang + '">' + value + '</lang>' 
		 					);
		 			}*/

		 		}
		 		else if( index.substr(0,3) == 'acf') {
		 			var field_name = index.substr(4);
		 			console.log("field " + field_name + " = " + value);
		 			if(value) {
		 				jQuery('*[name="acf[' + field_name + ']"]').val(value);
		 			}			
		 		}
		 		/*
		 		else if( is_gutenberg) {
		 			var content_index = index.substr(13);
		 			var content_type = (index.substr(0,12) == 'post_content') ? 'post_content' : 'post_content_titles';
		 			console.log("index = " + index + " type = " + content_type + " content index = " + content_index);
		 			console.log("content index = " + content_index);
		 			
		 			if( content_type == 'post_content' ) {
		 				var blocks = jQuery('.edit-post-visual-editor .editor-rich-text p.wp-block-paragraph');
		 			}
		 			else if( content_type === 'post_content_titles') {
		 				var blocks = jQuery('.edit-post-visual-editor .editor-rich-text :header');
		 			}

		 			var block = blocks[content_index];
		 			var existing = jQuery(block).html();
		 			console.log("Replacing " + existing.length + " with " + value.length + " cars");
					if( should_we_replace == 'replace') {
							jQuery(block).html(value.replace( /\\( . )/mg, "$1" ))
						}
						else {
							jQuery(block).html( existing + value.replace( /\\( . )/mg, "$1" ) );
						}

					jQuery(blocks).each(function(index) {
						if(index == content_index) {
							if( should_we_replace == 'replace') {
								jQuery(this).html(value.replace( /\\( . )/mg, "$1" ))
							}
							else {
								jQuery(this).html( jQuery(this).html() + value.replace( /\\( . )/mg, "$1" ) );
							}

						}
					});	 			

		 		} 		*/
		 		else {
		 			console.log( "No action for " + index );
		 		}
		 	} );
	  	}



	 	jQuery( '#deepl_spinner' ).css( 'visibility', 'hidden' );
	 });
	 });

});