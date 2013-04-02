<?php
function thumbnail_thumbnail($html, $post_id, $post_thumbnail_id, $size, $attr) {
	if (!empty($html))
		return $html;
	if (is_numeric($post_id)) {
		$post = get_post($post_id);
		$post_type = $post->post_type;
	} else if (is_object($post_id)) {
		$post = $post_id;
		$post_id = $post->ID;
		$post_type = $post->post_type;
	} else {
		return html;
	}

	if ($post_type === 'attachment') {
		$html = wp_get_attachment_image($post_id, $size, false, $attr);
	} else if ($attachments = get_posts(array('post_type' => 'attachment', 'post_parent' => $post_id))) {
		foreach($attachments as $attachment) {
			$html = wp_get_attachment_image($attachment->ID, $size, false, $attr);
		}
	}

    return $html;
}
add_filter('post_thumbnail_html', 'thumbnail_thumbnail', 10, 5);
