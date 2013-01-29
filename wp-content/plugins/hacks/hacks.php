<?php
/*
Plugin Name: Hacks
Plugin URI: 
Description: 
Version: 0.1
Author: wokamoto
Author URI: http://dogmap.jp/

 Released under the GPL license
  http://www.gnu.org/copyleft/gpl.html
*/
wp_deregister_script('jquery');
wp_enqueue_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js', array(), '1.8.3');

add_filter('got_rewrite','__return_true');

// remove jetpack open graph tags
add_filter( 'jetpack_enable_open_graph', '__return_false' );

//  applied to the comment author's IP address prior to saving the comment in the database.
function auto_reverse_proxy_pre_comment_user_ip() {
	if ( isset($_SERVER['X_FORWARDED_FOR']) && !empty($_SERVER['X_FORWARDED_FOR']) ) {
		$X_FORWARDED_FOR = (array)explode(",", $_SERVER['X_FORWARDED_FOR']);
		$REMOTE_ADDR = trim($X_FORWARDED_FOR[0]); //take the last
	} else {
		$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
	}
	return $REMOTE_ADDR;
}
add_filter('pre_comment_user_ip','auto_reverse_proxy_pre_comment_user_ip');

function yoast_add_google_profile( $contactmethods ) {
	// Add Google Profiles
	$contactmethods['google_profile'] = 'Google Profile URL';
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'yoast_add_google_profile', 10, 1);

function my_excerpt($content){
	global $post;
	return strip_tags($post->post_title . $post->post_content);
}
add_filter( 'get_the_excerpt', 'my_excerpt');

/* hack file directry */
$hack_dir = trailingslashit(WP_CONTENT_DIR) . 'plugins/hacks/hacks/';
opendir($hack_dir);
while(($ent = readdir()) !== false) {
	if(!is_dir($ent) && strtolower(substr($ent,-4)) == ".php")
		include_once($hack_dir.$ent);
}
closedir();
