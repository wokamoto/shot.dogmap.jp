<?php
/* Don't remove these lines. */
add_filter('comment_text', 'popuplinks');
/* This variable is for alternating comment background */
$oddcomment = 'alt';

while ( have_posts()) : the_post();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo get_option('blogname'); ?> - Comments on <?php the_title(); ?></title>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
<style type="text/css" media="screen">
@import url( <?php bloginfo('stylesheet_url'); ?> );
</style>
</head>
<body>
<div id="commentspopup">
<div class="post_info">
<?php the_excerpt(); ?> 
<?php the_title('<b>"', '"</b>'); ?><br />
&nbsp; Date: <?php the_time('n.j.Y') ?><br />
&nbsp; Category: <?php the_category(', ') ?><br />
&nbsp; <small><a href="<?php echo get_post_comments_feed_link($post->ID); ?>"><abbr title="Really Simple Syndication">RSS</abbr> feed for comments on this post.</a></small>
</div>
<div class="clear"></div>
<?php if ('open' == $post->ping_status) { ?>
<h2 id="trackback_url">Trackback URL</h2>
<input type="text" value="<?php trackback_url() ?>" readonly="readonly" onclick="this.select();" id="trackback" />
<?php } ?>	
<h2 id="comments">Comments</h2>
<?php
// this line is WordPress' motor, do not delete it.
$commenter = wp_get_current_commenter();
extract($commenter);
$comments = pb_get_comments($id);
$post = get_post($id);
if (!empty($post->post_password) && $_COOKIE['wp-postpass_'. COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
	echo(get_the_password_form());
} else { ?>
<?php if ($comments) { ?>
<ul id="commentlist">
<?php foreach ($comments as $comment) { ?>
<li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
<?php if ($comment->comment_approved == '0') : ?>
<em>Your comment is awaiting moderation.</em>
<?php endif; ?>
<?php comment_text() ?>
<p class="comment_meta">by <?php comment_author_link() ?> &#8212; <?php comment_date() ?> @ <a href="#comment-<?php comment_ID() ?>"><?php comment_time() ?></a></p>
</li>
<?php /* Changes every other comment to a different class */	
if ('alt' == $oddcomment) $oddcomment = 'nor';
else $oddcomment = 'alt';
?>
<?php } // end for each comment ?>
</ul>
<?php } else { // this is displayed if there are no comments so far ?>
<p>No comments yet.</p>
<?php } ?>
<?php if ('open' == $post->comment_status) { ?>
<h2>Leave a comment</h2>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<p>
<input type="text" name="author" id="author" class="textarea" value="<?php echo $comment_author; ?>" size="28" tabindex="1" />
<label for="author">&nbsp;Name</label>
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
<input type="hidden" name="redirect_to" value="<?php echo attribute_escape($_SERVER["REQUEST_URI"]); ?>" />
</p>
<p>
<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="28" tabindex="2" />
<label for="email">&nbsp;E-mail (never displayed)</label>
</p>
<p>
<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="28" tabindex="3" />
<label for="url"><abbr title="Universal Resource Locator">&nbsp;URL</abbr></label>
</p>
<p>
<label for="comment">Your Comment</label>
<br />
<textarea name="comment" id="comment" cols="45" rows="5" tabindex="4"></textarea>
</p>
<p>
<input name="submit" id="submit" type="submit" tabindex="5" value="Submit" />
</p>
<?php do_action('comment_form', $post->ID); ?>
</form>
<?php } else { // comments are closed ?>
<p>Sorry, the comment form is closed at this time.</p>
<?php }
} // end password check
?>
<div><strong><a href="javascript:window.close()">Close this window.</a></strong></div>
<?php // if you delete this the sky will fall on your head
endwhile;
?>
<?php //} ?>
<script type="text/javascript">
<!--
document.onkeypress = function esc(e) {
if(typeof(e) == "undefined") { e=event; }
if (e.keyCode == 27) { self.close(); }
}
// -->
</script>
</div>
</body>
</html>
