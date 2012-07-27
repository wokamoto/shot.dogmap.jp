<?php
if ( function_exists('register_sidebar') ) {
    register_sidebars($number = 6, array('name' => 'Column %d',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="page_title">',
     'after_title' => '</h2>',
     ));
}

function exchange_static_uri($content) {
	$content = str_replace(
		'http://shot.dogmap.jp/wp-includes/' ,
		'http://static.dogmap.jp/shot/includes/' ,
		$content
		);
	$content = trim(str_replace(array('<br class="shot-clear" />','<p></p>'), '', $content));
	return preg_replace(
		'#http://shot.dogmap.jp/wp-content/(uploads|cache|themes|plugins
)/([^"\']*)\.(png|gif|jpe?g|css|js|mp3|wav)#i' ,
		'http://static.dogmap.jp/shot/$1/$2.$3' ,
		$content
		);
}
add_filter('the_content', 'exchange_static_uri');
add_filter('head-cleaner/head_cleaner', 'exchange_static_uri');
add_filter('head-cleaner/footer_cleaner', 'exchange_static_uri');
add_filter('head-cleaner/pre_html_cleaner', 'exchange_static_uri');
add_filter('head-cleaner/css_optimise', 'exchange_static_uri');
add_filter('head-cleaner/js_minify', 'exchange_static_uri');

//**********************************************************************************
// detect browser
//**********************************************************************************
/*
function browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}
add_filter('body_class','browser_body_class');
*/

//**********************************************************************************
// capital_P_dangit disable
//**********************************************************************************
remove_filter( 'the_content', 'capital_P_dangit' );
remove_filter( 'the_title', 'capital_P_dangit' );
remove_filter( 'comment_text', 'capital_P_dangit' );

//**********************************************************************************
// サムネールサポート
//**********************************************************************************
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 160, 160, true );

//**********************************************************************************
// コンテンツに「いいね！」とか「Google+1」とかのボタンを追加
//**********************************************************************************
function add_content($content) {
	if ( is_feed() )
		return $content;

	$permalink = get_permalink();

	$content .= '<span style="float:left;margin-right: 5px;"><iframe';
	$content .= ' src="http://www.facebook.com/plugins/like.php?href=' . $permalink ;
	$content .= '&amp;layout=button_count&amp;show_faces=true&amp;width=100&amp;action=like&amp;colorscheme=light&amp;height=20" scrolling="no" frameborder="0" class="wph facebook" allowTransparency="true"';
	$content .= ' style="width:100px; height:20px;"';
	$content .= '>';
	$content .= '</iframe></span>';

	$content .= '<span style="float:left;"><g:plusone  href="' . $permalink  . '" size="medium" count="true"></span>' . "\n";

	return $content;
}
add_filter('the_content', 'add_content');

//**********************************************************************************
// フッターで読み込む JavaScript 等を指定する
//**********************************************************************************
function add_wp_footer() {
//	$platform = get_browser(null, true);
	$js = "";
	$js_inline = "";
	$js_tag = "<script type=\"text/javascript\" src=\"%s\"%s></script>\n";
	$wp_siteurl  = get_option('siteurl').'/';
	$wp_includes = $wp_siteurl.'wp-includes/';

//	// twitter follow badge by go2web20
//	$js .= sprintf($js_tag, 'http://files.go2web20.net/twitterbadge/1.0/badge.js', '');
//	$js_inline .= "tfb.account = 'wokamoto';";
//	$js_inline .= "tfb.label = 'follow-me';";
//	$js_inline .= "tfb.color = '#35ccff';";
//	$js_inline .= "tfb.side = 'r';";
//	$js_inline .= "tfb.top = 136;";
//	$js_inline .= "tfb.showbadge();\n";

	if (is_page()) {
		$js .= sprintf($js_tag, 'http://s.gravatar.com/js/gprofiles.js', '');
	}

	if (is_single() || is_page()) {
		$js_inline .= "jQuery(function(){";
		$js_inline .= "jQuery('a.tweet-this').unbind('click').click(function(){window.twttr=window.twttr||{};var D=550,A=450,C=screen.height,B=screen.width,H=Math.round((B/2)-(D/2)),G=0,F=document,E;if(C>A) G=Math.round((C/2)-(A/2));window.twttr.shareWin=window.open('http://twitter.com/share','','left='+H+',top='+G+',width='+D+',height='+A+',personalbar=0,toolbar=0,scrollbars=1,resizable=1');E=F.createElement('script');E.src='http://platform.twitter.com/bookmarklets/share.js?v=1';F.getElementsByTagName('head')[0].appendChild(E);return false;});";
		$js_inline .= "});";
		$js .= '<script type="text/javascript" src="http://apis.google.com/js/plusone.js">{lang: \'ja\'}</script>' . "\n";
	}

	$js_inline .= "if (typeof wpOnload=='function') wpOnload();\n";

	if ($js_inline != '') {
		$js .= "<script type=\"text/javascript\"> /*<![CDATA[ */\n";
		$js .= $js_inline;
		$js .= "/*]]>*/</script>\n";
	}

	echo $js;
}
add_action('wp_footer', 'add_wp_footer',11);

function _add_custom_urls() {
	add_rewrite_rule('date/([\d]{4})/?$', 'index.php?year=$matches[1]');
}
add_action('init', '_add_custom_urls');

function nice_trailingslashit($string, $type_of_url) {
	if ($type_of_url != 'single')
		$string = trailingslashit($string);
	return $string;
}
add_filter('user_trailingslashit', 'nice_trailingslashit', 10, 2);

function pb_thumbnails($thum_count = 6) {
	global $id;

	$results = pb_before_after_posts($thum_count + 2);
	if (count($results) > 0) {
		echo '<ul>';

		echo '<li>';
		if ( $results[0] == $id || (isset($results[1]) && $results[1] == $id ) ) {
			echo '<img src="http://shot.dogmap.jp/wp-content/themes/PB2-LT/images/leftarrow_grey.png" height="24" width="24" style="margin-right:.25em; vertical-align: middle;" alt="" />';
		} else {
			$before_id = array_shift($results);
			echo '<a href="' . get_permalink($before_id) . '">';
			echo '<img src="http://shot.dogmap.jp/wp-content/themes/PB2-LT/images/leftarrow.png" height="24" width="24" style="margin-right:.25em; vertical-align: middle;" alt="" />';
			echo '</a>';
		}
		echo "</li>\n";

		$before_after_posts = array_slice($results, 0, $thum_count);
		$images = (array) kougabu_get_images(array(
			'post_id' => $before_after_posts ,
			'sort_key' => 'date' ,
			'max_width' => 80 ,
			'max_height' => 60 ,
			'echo' => false ,
			'array' => true ,
			));
		foreach ( $images as $key => $image ) {
			echo '<li>';
			echo str_replace(" style='border: 0;'", ($key != $id ? ' style="vertical-align: top;"' : ' style="vertical-align: top; border-bottom: solid 2px #35CCFF;"'), $image[0]);
			echo "</li>\n";
		}

		echo '<li>';
		if (count($results) > $thum_count) {
			$after_id = $results[$thum_count];
			echo '<a href="' . get_permalink($after_id) . '">';
			echo '<img src="http://shot.dogmap.jp/wp-content/themes/PB2-LT/images/rightarrow.png" height="24" width="24" style="vertical-align: middle;" alt="" />';
			echo '</a>';
		} else {
			echo '<img src="http://shot.dogmap.jp/wp-content/themes/PB2-LT/images/rightarrow_grey.png" height="24" width="24" style="vertical-align: middle;" alt="" />';
		}
		echo "</li>\n";

		echo '</ul>';
	}
}

// ===== PB THUMBNAILS in SINGLE PAGE ===== //
function pb_before_after_posts($limit) {
	global $wpdb, $id;
	$before_after_posts = array();

	$thumnum = 2;
	$sql = 
		"SELECT ID" .
		" FROM $wpdb->posts" .
		" WHERE post_status = 'publish'" .
		" AND post_type = 'post'" .
		" AND ID > '$id'" .
		" ORDER BY post_date ASC" .
		" LIMIT $thumnum";
	$results = array_reverse((array) $wpdb->get_results($sql));
	foreach ($results as $result) {
		$before_after_posts[] = $result->ID;
	}

	$before_after_posts[] = $id;

	$thumnum = $limit - count($before_after_posts);
	$sql = 
		"SELECT ID" .
		" FROM $wpdb->posts" .
		" WHERE post_status = 'publish'" .
		" AND post_type = 'post'" .
		" AND ID < '$id'" .
		" ORDER BY post_date DESC" .
		" LIMIT $thumnum";
	$results = (array) $wpdb->get_results($sql);
	foreach ($results as $result) {
		$before_after_posts[] = $result->ID;
	}

	return $before_after_posts;
}

// ===== PB RECENT THUMBNAILS in HOME PAGE ===== //
/*
function pb_recent_thumbnails ($limit) {
	global $wpdb;
	$current_post_date = $post->post_date;
	$sql = "SELECT ID, post_title, post_excerpt FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date DESC LIMIT $limit";
	$results = $wpdb->get_results($sql);
	$output = "";
	foreach ($results as $result) {
		$post_title = stripslashes($result->post_title);
        $permalink = get_permalink($result->ID);
		$post_excerpt = ($result->post_excerpt);
		$output="<div class=\"thumbnails\"><a href=\"" . $permalink . "\" title=\"Permanent Link: " . $post_title . "\">" . $post_excerpt . "</a></div>\n			" . $output;
	}
	echo $output;
}
*/

// ===== PB THUMBNAILS in SINGLE PAGE ===== //
/*
function pb_before_after_thumbnails ($limit) {
	global $wpdb, $id;
	global $cur_post_date;
	$thumbnum = ($limit-1)/2;
	$cur_sql = "SELECT ID, post_title, post_excerpt, post_date FROM $wpdb->posts WHERE ID = '$id'";
	$cur_results = $wpdb->get_results($cur_sql);
	$output = '';
	foreach ($cur_results as $cur_result) {
		$cur_post_date = ($cur_result->post_date);
	}

	$before_sql = "SELECT ID, post_title, post_excerpt FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' and post_date < '$cur_post_date' ORDER BY post_date DESC LIMIT $thumbnum";
	$before_results = $wpdb->get_results($before_sql);
	if($before_results) {
		foreach ($before_results as $before_result) {
			$post_title = stripslashes($before_result->post_title);
			$permalink = get_permalink($before_result->ID);
			$post_excerpt = ($before_result->post_excerpt);
			$output="<div class=\"thumbnails\"><a href=\"" . $permalink . "\" title=\"Permanent Link: " . $post_title . "\">" . $post_excerpt . "</a><br />&lsaquo;</div>\n			" . $output;
		}
	}
	foreach ($cur_results as $cur_result) {
		$post_title = stripslashes($cur_result->post_title);
		$permalink = get_permalink($cur_result->ID);
		$post_excerpt = ($cur_result->post_excerpt);
		$output.="<div class=\"current-thumbnail\"><a href=\"" . $permalink . "\" title=\"Permanent Link: " . $post_title . "\">" . $post_excerpt . "</a><br />&#149;</div>\n			";
	}
	
	$after_sql = "SELECT ID, post_title, post_excerpt FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' and post_date > '$cur_post_date' ORDER BY post_date ASC LIMIT $thumbnum";
	$after_results = $wpdb->get_results($after_sql);
	if($after_results){
		foreach ($after_results as $after_result) {
			$post_title = stripslashes($after_result->post_title);
			$permalink = get_permalink($after_result->ID);
			$post_excerpt = ($after_result->post_excerpt);
			$output.="<div class=\"thumbnails\"><a href=\"" . $permalink . "\" title=\"Permanent Link: " . $post_title . "\">" . $post_excerpt . "</a><br />&rsaquo;</div>\n			";
		}
	}	
	echo $output;
}
*/

// ===== PB RANDOM POST LINK =====//
function pb_random_post($text="") {
  global $wpdb;
	$url = get_option('siteurl');
  $row = $wpdb->get_row("select id from $wpdb->posts".
                        " where post_status='publish' AND post_type = 'post'".
                        " order by rand() limit 1");
	if ($row) {
    if (strlen($text)) {
      $random = "<a href=\"";
      $random .= get_permalink($row->id);
      $random .="\">$text</a>";
      echo $random;
    }
    else $random = "$url/archives/$row->id";
  }
  else $random = "";
	return $random;
}


// ===== POP-UP COMMENTS (Not used PB 2.7+) =====//
function pb_get_comments($post_id) {
	global $wp_query, $withcomments, $post, $wpdb, $id, $comment, $user_login, $user_ID, $comment_author,$comment_author_email,$user_identity;
	$post_id = (int) $post_id;
	$req = get_option('require_name_email');
	if ( $user_ID) {
		return $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = '$post->ID' AND (comment_approved = '1' OR ( user_id = '$user_ID' AND comment_approved = '0' ) )  ORDER BY comment_date");
	} else if ( empty($comment_author) ) { 
		return $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = '$post->ID' AND comment_approved = '1' ORDER BY comment_date");
	} else {
		$author_db = $wpdb->escape($comment_author);
		$email_db  = $wpdb->escape($comment_author_email);
		return $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = '$post->ID' AND ( comment_approved = '1' OR ( comment_author = '$author_db' AND comment_author_email = '$email_db' AND comment_approved = '0' ) ) ORDER BY comment_date");
	}
	$comments = $wp_query->comments = apply_filters( 'comments_array', $comments, $post->ID );
	$wp_query->comment_count = count($wp_query->comments);
}

// ===== PB AUTO-INSERT EXCERPT ===== //
function pb_insert_excerpt(){
	$post_data = &$_POST;
	$post_id = $post_data['ID'] ;
	$post_title = $post_data['post_title'];
	$post_excerpt = $post_data['post_excerpt'];
	$arrImages =& get_children('post_type=attachment&post_mime_type=image&post_parent=' . $post_id); 
	if($arrImages) {
		$arrKeys = array_keys($arrImages); 
		$iNum = $arrKeys[0];
		$sThumbUrl = wp_get_attachment_thumb_url($iNum); 
		$thumbWidth = get_option("thumbnail_size_w");
		$thumbHeight = get_option("thumbnail_size_h");
		$sImgString = '<img src="' . $sThumbUrl . '" width="'.$thumbWidth.'" height="'.$thumbHeight.'" alt="'.$post_title.'" title="'.$post_title.'" />' ;  
		$existing_img = strstr($post_excerpt, 'jpg');
		if($post_data['post_excerpt'] = isset($post_data['excerpt'])) {
			if ($existing_img) {
				return $post_excerpt;
			} else {
				return $sImgString;
			}	
		}
	}	
}

// ===== PB COMMENT TEMPLATE ===== //
function pb_comment($comment, $args, $depth) {
 $GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
<div id="comment-<?php comment_ID(); ?>">
<div class="vcard">
<?php echo get_avatar($comment,$size='35',$default ); ?>
</div>
<?php if ($comment->comment_approved == '0') : ?>
<em><?php _e('Your comment is awaiting moderation.') ?></em>
<br />
<?php endif; ?>      
<?php comment_text() ?>
<div class="comment-meta commentmetadata"><span style="font-weight: bold;"><?php printf(__('by %s'), get_comment_author_link()) ?></span> - <?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?><?php edit_comment_link(__('(Edit)'),'  ','') ?></a></div>
<div class="reply">
<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'before' =>'( &#9998; ', 'after' =>' )'))) ?>
</div>
</div>
<?php
}

// ===== SHOW / HIDE COMMENTS FUNCTIONS ===== //
function pb_hideshow_comment_js () { ?>
<script type="text/javascript"> 
var currLayerId = "show"; 
function togLayer(id) { if(currLayerId) setDisplay(currLayerId, "none"); if(id)setDisplay(id, "block"); currLayerId = id; }
function setDisplay(id,value) { var elm = document.getElementById(id); elm.style.display = value; }
</script>
<?php
}

function hideshowComments () {
$linkText1 = __("Comments", "hideshowcomments");
   $relinkText = __("Hide Comments", "hideshowcomments");
		echo "
<div id=\"show\" style=\"display: block;\">
<a href=\"#\" style=\"text-decoration:none\" onclick=\"togLayer('hide');return false;\" title=\"Post your comment / View comments\">",
$linkText1, " (", comments_number('0','1','%'), ")</a>
</div>
<div id=\"hide\" style=\"display: none;\">
<a href=\"#\" style=\"text-decoration:none\" onclick=\"togLayer('show');return false;\" title=\"\">",
$relinkText,
"</a>
", comments_template(), "</div>";
}

//add_filter('wp_head','pb_hideshow_comment_js');
add_filter('excerpt_save_pre', 'pb_insert_excerpt');
remove_filter('the_excerpt', 'wpautop'); 

/*
remove_filter('do_feed_rdf', 'do_feed_rdf', 10);
remove_filter('do_feed_rss', 'do_feed_rss', 10);
remove_filter('do_feed_rss2', 'do_feed_rss2', 10);
remove_filter('do_feed_atom', 'do_feed_atom', 10);

function custom_feed_rdf() {
        $template_file = '/feed-rdf.php';
        $template_file = ( file_exists( get_template_directory() . $template_file )
                ? get_template_directory()
                : ABSPATH . WPINC
                ) . $template_file;
        load_template( $template_file );
}
add_action('do_feed_rdf', 'custom_feed_rdf', 10, 1);

function custom_feed_rss() {
        $template_file = '/feed-rss.php';
        $template_file = ( file_exists( get_template_directory() . $template_file )
                ? get_template_directory()
                : ABSPATH . WPINC
                ) . $template_file;
        load_template( $template_file );
}
add_action('do_feed_rss', 'custom_feed_rss', 10, 1);
function custom_feed_rss2( $for_comments ) {
        $template_file = '/feed-rss2' . ( $for_comments ? '-comments' : '' ) . '.php';
        $template_file = ( file_exists( get_template_directory() . $template_file )
                ? get_template_directory()
                : ABSPATH . WPINC
                ) . $template_file;
        load_template( $template_file );
}
add_action('do_feed_rss2', 'custom_feed_rss2', 10, 1);

function custom_feed_atom( $for_comments ) {
        $template_file = '/feed-atom' . ( $for_comments ? '-comments' : '' ) . '.php';
        $template_file = ( file_exists( get_template_directory() . $template_file )
                ? get_template_directory()
                : ABSPATH . WPINC
                ) . $template_file;
        load_template( $template_file );
}
add_action('do_feed_atom', 'custom_feed_atom', 10, 1);
*/
?>
