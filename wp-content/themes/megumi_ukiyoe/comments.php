<?php
if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
if (!empty($post->post_password)) { // if there's a password
if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
?>
<p class="nocomments">
		<?php _e('This post is password protected. Enter the password to view comments.', 'megumi'); ?>
</p>
<?php
return;
}
}
/* This variable is for alternating comment background */
?>
<!-- You can start editing here. -->
<?php if ( have_comments() ) : ?>
<div id="commentlist_box">
<h3 id="comments" class="title"><?php comments_number(__('No Comment', 'megumi'), __('Comment', 'megumi'), __('Comments %', 'megumi'));?></h3>
		<?php if (function_exists('wp_list_comments')) { ?>
	<ol class="commentlist">
		<?php wp_list_comments('avatar_size=60'); ?>
	</ol>
	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
		<?php } else { ?>
	<ol class="commentlist">
		<?php foreach ($comments as $comment) : ?>
		<li id="comment-<?php comment_ID() ?>"> <?php echo get_avatar( $comment, 60 ); ?> <?php printf(__('<cite>%s</cite> Says:', 'megumi'), get_comment_author_link()); ?>
		<?php if ($comment->comment_approved == '0') : ?>
		<em><?php _e('Your comment is awaiting moderation.', 'megumi'); ?></em>
		<?php endif; ?>
		<a href="#comment-<?php comment_ID() ?>" title=""><?php printf(__('%1$s at %2$s', 'megumi'), get_comment_date(__('F jS, Y', 'megumi')), get_comment_time()); ?></a>
		<?php edit_comment_link(__('edit', 'megumi'),'&nbsp;&nbsp;',''); ?>
		<?php comment_text() ?>
		</li>
	</ol>
		<?php endforeach; /* end for each comment */ ?>
		<?php } ?>
</div>
 <?php else : // this is displayed if there are no comments so far ?>
	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e('Comments are closed.', 'megumi'); ?></p>
	<?php endif; ?>
<?php endif; ?>
<?php if ('open' == $post->comment_status) : ?>

<div id="respond">
<h3 class="title"><?php _e('Post comment', 'megumi'); ?></h3>
<?php if (function_exists('wp_list_comments')) { ?>
<div id="cancel-comment-reply"> 
	<small><?php cancel_comment_reply_link() ?></small>
</div>
<?php } ?> 
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'megumi'), get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode(get_permalink())); ?></p>
<?php else : ?>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php if ( $user_ID ) : ?>
<p><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.', 'megumi'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account', 'megumi'); ?>"><?php _e('Log out &raquo;', 'megumi'); ?></a></p>
<?php else : ?>
<p><label for="author"><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> /><?php _e('Your name:', 'megumi'); ?> <?php if ($req) _e("<em>(required)</em>", "kubrick"); ?></label></p>
<p><label for="email"><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> /><?php _e('E-mail:', 'megumi'); ?> 
<?php if ($req) _e("<em>(required)</em>", "megumi"); ?></label></p>
<p><label for="url"><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" /><?php _e('Website', 'megumi'); ?></label></p>
<?php endif; ?>
<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment', 'megumi'); ?>" />
<?php if (function_exists('wp_list_comments')) { ?>
<?php comment_id_fields(); ?> 
<?php } ?> 
</p>
<?php do_action('comment_form', $post->ID); ?>
</form>
<?php endif; // If registration required and not logged in ?>
</div>
<?php endif; // if you delete this the sky will fall on your head ?>