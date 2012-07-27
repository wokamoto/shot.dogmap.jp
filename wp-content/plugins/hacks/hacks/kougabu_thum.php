<?php
function use_kougabu_thumb($content) {
	global $post;

/*
	if (is_feed())
		return $content;
	$thumb = str_replace(array("\r","\n"), '', preg_replace(
		'/^.*(<img [^>]*>).*$/i' ,
		'$1' ,
		kougabu_get_images(array(
			'before' => '' ,
			'after' => '' ,
			'post_id' => $post->ID ,
			'echo' => false ,
			'max_width' => 320 ,
			'max_height' => 320
		))));
	$content = preg_replace(
		'/^(<a [^>]*>)(<img [^>]*>)(<\/a>)(.*)/i' ,
		'$1' . $thumb . '$3$4' ,
		$content
		);
*/
	$content = str_replace(' class="shot-float"', '', $content);
	$content = preg_replace(
		'/^(<a [^>]*><img )([^>]*><\/a>)(.*)/i' ,
		'$1height="240" $2' . $post->post_title . '$3' ,
		$content
		);

	return $content;
}
add_filter('the_content', 'use_kougabu_thumb', 9);
