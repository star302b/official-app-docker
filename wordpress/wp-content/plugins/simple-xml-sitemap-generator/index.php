<?php 
/*
Plugin Name: Simple XML Sitemap Generator
Plugin URI: http://www.chefblogger.me
Description: XML Sitemap creates an XML for use with Google and Yahoo (and Yes! Bing too). Just install it to your wordpress installation and let the plugin do his job. <a href="options-general.php?page=QWA_sxmlsg">Administration</a>
Version: 2.2.1
Author: Eric-Oliver M&auml;chler
Author URI: http://www.chefblogger.me
Requires at least: 3.5
Tested up to: 5.8.2
*/

include 'conf.php';

//mehrsprachigkeit
//threema mehrsprachig machen
function my_plugin_initsimplexmlsitemapgenerator() {
  load_plugin_textdomain( 'simple-xml-sitemap-generator', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action('init', 'my_plugin_initsimplexmlsitemapgenerator');





/* WordPress 5.5 interner XML Sitemap Generator abschalten */
add_filter('wp_sitemaps_enabled', '__return_false');

/* Coding start */
function sg_create_sitemap() {
  $postsForSitemap = get_posts(array(
    'numberposts' => -1,
    'orderby' => 'modified',
    'post_type'  => array('post','page','product'),
    'order'    => 'DESC'
  ));

  $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
  $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';



  $xmlpost_id = get_the_ID();
  $xmlpost_id_check = nl2br(get_post_meta($prod_id,'sitemap',true));

  foreach($postsForSitemap as $post) {
    setup_postdata($post);

    $postdate = explode(" ", $post->post_modified);

    $xml_textid = $post->ID;
    $xml_custom_field = nl2br(get_post_meta($xml_textid,'sitemap',true));

    // score wert
    $xml_sitemapscore = nl2br(get_post_meta($xml_textid,'sitemapscore',true));

    if (is_numeric($xml_sitemapscore))
    {
      $xml_kontrolle_ob_zahl = '1';
    }
    else
    {
      $xml_kontrolle_ob_zahl = '0';
    }



    if ($xml_custom_field == 'no')
    {

    }
    else
    {

      if ($xml_kontrolle_ob_zahl == '1')
      {
        $sitemap .= '<url>'.
        '<loc>'. get_permalink($post->ID) .'</loc>'.
        '<lastmod>'. $postdate[0] . '</lastmod>'.
        '<changefreq>daily</changefreq>'.
        '<priority>'. $xml_sitemapscore . '</priority>'.
        /* '<postid>'. $xml_textid . '</postid>'. */ 
        /* '<smap>'. $xml_custom_field . '</smap>'. */
      '</url>';
      }
      else
      {

            $sitemap .= '<url>'.
              '<loc>'. get_permalink($post->ID) .'</loc>'.
              '<lastmod>'. $postdate[0] . '</lastmod>'.
              '<changefreq>daily</changefreq>'.
              '<priority>0.8</priority>'.
              /* '<postid>'. $xml_textid . '</postid>'. */ 
              /* '<smap>'. $xml_custom_field . '</smap>'. */
            '</url>';
      }


    }



  }
	
	
/* ADD WP Kategorie */
$sxmlsg_kategorien_view = get_option('sxmlsg_kategorien');
	
if ($sxmlsg_kategorien_view == 'Ja') {
	
$now = time();
$sxmlsg_kategorien_datum = date("Y-m-d",$now);	
	
$categories = get_categories( array(
    'orderby' => 'name',
    'order'   => 'ASC'
) );
 
	
foreach( $categories as $category ) {
   
	
    $sitemap .= '<url>'.
      '<loc>'. get_category_link( $category->term_id ) .'</loc>'.
      '<lastmod>'. $sxmlsg_kategorien_datum .'</lastmod>'.
      '<changefreq>daily</changefreq>'.
      '<priority>0.8</priority>'.
    '</url>';
	
} 
	
	
	
	
	
/*	
<url>
	<loc>$sxmlsg_kategorien_link</loc>
	<lastmod>2010-10-11</lastmod>
	<changefreq>daily</changefreq>
	<priority>0.8</priority>
</url>
*/


	
}
	
		
	

  $sitemap .= '</urlset>';

  $fp = fopen(ABSPATH . "sitemap.xml", 'w');
  fwrite($fp, $sitemap);
  fclose($fp);
}
add_action("publish_post", "sg_create_sitemap");
add_action("publish_page", "sg_create_sitemap");
/* Ok that's all */
?>