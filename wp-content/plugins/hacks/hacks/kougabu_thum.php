<?php
function use_kougabu_thumb($content) {
	global $post;

	$content = str_replace(' class="shot-float"', '', $content);
	$content = preg_replace(
		'/^(<a [^>]*href=[\'"])([^\'"]+)([\'"][^>]*>)(<img [^>]*src=[\'"])([^\'"]+)([\'"][^>]*>)(<\/a>)(.*)/i' ,
		'$1$2$3$4$5$6$7<br>' . $post->post_title . '$8' ,
		$content
		);

	return $content;
}
add_filter('the_content', 'use_kougabu_thumb', 9);
