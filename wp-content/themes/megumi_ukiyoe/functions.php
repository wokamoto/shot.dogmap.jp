<?php
if ( function_exists('add_theme_support') )
	add_theme_support( 'post-thumbnails' );
load_textdomain('megumi', dirname(__FILE__).'/lang/' . get_locale() . '.mo');
require_once(dirname(__FILE__).'/script/megumi_theme_setting.php');
require_once(dirname(__FILE__).'/script/theme_function_load.php');
if ( function_exists('register_sidebars') )
	register_sidebars(1, array(
		'name' => __('Sidebar Home &amp; Pages','megumi'),
		'before_widget' => '<div class="widgets">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="title">',
		'after_title' => '</h2>',
	));
function post_img_check() {
	global $post;
	$post_id = $post->ID;
	$content = $post->post_content;
	if (preg_match('/ src="(.*?)"/',$content, $match_img)) {
		return TRUE;
	} else {
		return FALSE;
	}
}
/* ---- Body ID Change ---- */
function body_change() {
	if(is_single()) {
		if (post_img_check()) {
			echo 'single';
		} else {
			echo 'page';
		}
	} elseif (is_page()) {
		echo 'page';
	} else {
		echo 'content';
	}
}
/* ---- Page Navigation Change ---- */
function wp_pagenav() {
	$siteuri = get_option('siteurl');
	$page_name = $siteuri.$_SERVER['REQUEST_URI'];
	if (get_option('permalink_structure'))	{
		$permalink_page_name = "'/".attribute_escape(str_replace('http://', '' ,$siteuri))."\/page\/2/'";
		$pagenav_no1= '/page/1';
	} else {
		$permalink_page_name = '/\/\?paged=2/';
		$pagenav_no1 = '/?paged=1';
	}
	if (function_exists('wp_pagenavi')){
		wp_pagenavi();
	} else {
		echo '<div class="navigation">';
		echo '<p class="previous_post">';
		next_posts_link(__('&laquo; Older Entries', 'megumi'));
		echo '</p>';
		echo '<p class="next_post">';
		if (preg_match($permalink_page_name , $page_name)) { ?>
			<a href="<?php echo get_option('home'). $pagenav_no1; ?>"><?php _e('Newer Entries &raquo;','megumi'); ?></a>
		<?php } else {
			previous_posts_link(__('Newer Entries &raquo;', 'megumi'));
		}
		echo '</p>';
		echo '</div>';
	}
}
function remove_img_content() {
	$get_post_entrys = get_the_content();
	$post_entrys = preg_replace('/<img[^>]*>/', '', $get_post_entrys);
	return $post_entrys;
}
function get_photo_back() {
	global $post;
	$post_id = $post->ID;
	$content = $post->post_content;
	if(is_single()) {
		if (preg_match('/ src="(.*?)"/',$content, $match_img)) {
			$imgsrc = preg_replace('/-[0-9]{1,}x[0-9]{1,}/', '',  $match_img[1]);
			$filename = $imgsrc;
			$img_size = getimagesize($filename);
			$width = $img_size['0'];
			$height = $img_size['1'];
			echo '<style type="text/css">/*<![CDATA[ */'."\n";
			echo "\t".'body#single div#box'."\n";
			echo "\t".'{'."\n";
			echo "\t\t".'max-width:'.$width.'px;'."\n";
			echo "\t\t".'height:'.$height.'px;'."\n";
			echo "\t\t".'margin:0px auto 0px auto;;'."\n";
			echo "\t\t".'background:url('.$filename.') no-repeat;'."\n";
			echo "\t".'}'."\n";
			echo '/*]]>*/ </style>'."\n";
		}
	}
}
add_action('wp_head','get_photo_back');
function photo_template() {
	if(is_single()) {
		if (post_img_check()) {
			$template = locate_template(array('photo_single.php'));
		} else {
			$template = locate_template(array('single.php'));
		}
	}
	return $template;
}
add_filter('single_template', 'photo_template');
function megumi_ukiyoe_script() {
	$themeurl = get_stylesheet_directory_uri();
	if(!is_single()) {
//		wp_enqueue_script('googleapis', 'http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js');
		wp_enqueue_script('masonry', $themeurl.'/js/jquery.masonry.min.js', array('jquery'));
	}
}
add_action('wp_print_scripts','megumi_ukiyoe_script');
function vgrid_config() {
	if(!is_single()) {?>
		<script type="text/javascript">//<![CDATA[
			jQuery(function($){
				$('#photo_list').masonry(); 
			})
		//]]> </script>
	<?php }
}
add_action('wp_footer','vgrid_config');
function get_img($img_size = '') {
	global $post, $blog_id;
	switch(strtolower($img_size)){
	case 'thumbnail':
		$set_width = $set_height = '159';
		break;
	default:
		$set_width = $set_height = null;
		break;
	}
	$post_id = $post->ID;
	$get_title = $post->post_title;
	$content = $post->post_content;
	$blog_url = get_option('siteurl');
	$themeurl = get_stylesheet_directory_uri();
	$themepatch = get_stylesheet_directory();
	$get_script_url = $themeurl.'/script/show_image.php';
	$get_script_path = $themepatch.'/script/show_image.php';
	$get_width = $set_width;
	$get_height = $set_height;
	$get_permalink = get_permalink($post_id);
	$match_blog_url = "'/".attribute_escape(str_replace('http://', '' ,$blog_url))."/'";
	if (preg_match('/ src="(.*?)"/',$content, $match_img)) {
		$imgsrc = preg_replace('/-[0-9]{1,}x[0-9]{1,}/', '',  $match_img[1]);
		if (preg_match($match_blog_url, $imgsrc)) {
			$img_url = attribute_escape(str_replace($blog_url.'/wp-content/', '', $imgsrc));
			$script_path = $get_script_path;
			$script_url = attribute_escape(str_replace(ABSPATH, '', $get_script_path));
			$cnt = substr_count( dirname($script_url) , "/");
			$cnt = ( !strcmp(dirname($script_url), "/" ) ) ? (0) : $cnt ;
			$relativ_path = ($cnt == 0) ? ("./") : str_repeat( "../", $cnt );
			$relativ_path .= $img_url;
			$filename = $get_script_url.'?filename='.$relativ_path.'&width='.$get_width.'&height='.$get_height;
			$img_size = @getimagesize($filename);
			if (!$img_size) {
				$width = $img_size['0'];
				$height = $img_size['1'];
				$size = 'width="'.$width.'" height="'.$height.'" ';
			} else {
				$size = '';
			}
			$output = '<p class="thumbnail"><a href="'.$get_permalink.'" title="'.sprintf(__('Permanent Link to %s','megumi'), $get_title).'"><img src="'.$filename.'" '.$size.'/></a></p>';
		} else {
			$relativ_path = $imgsrc;
			$filename = $get_script_url.'?filename='.$relativ_path.'&width='.$get_width.'&height='.$get_height;
			$img_size = @getimagesize($filename);
			if (!$img_size) {
				$width = $img_size['0'];
				$height = $img_size['1'];
				$size = 'width="'.$width.'" height="'.$height.'" ';
			} else {
				$size = '';
			}
			$output = '<p class="thumbnail"><a href="'.$get_permalink.'" title="'.sprintf(__('Permanent Link to %s','megumi'), $get_title).'"><img src="'.$filename.'" '.$size.'/></a></p>';
		}

	} else {
		$filename = $themeurl.'/images/no_images/noimage.gif';
		$img_size = getimagesize($filename);
		$width = $img_size['0'];
		$height = $img_size['1'];
		$output = '<p class="thumbnail"><a href="'.$get_permalink.'" title="'.sprintf(__('Permanent Link to %s','megumi'), $get_title).'"><img src="'.$filename.'" width="'.$width.'" height="'.$height.'" /></a></p>';
	}
	return $output;
}
//Admin Page
function megumi_ukiyoe_theme_setting_head(){
	$request_page_name = $_SERVER['REQUEST_URI'];
	echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/css/style.css" type="text/css" media="screen" />'."\n";
	if(preg_match('/megumi_ukiyoe_theme_setting/' , $request_page_name)) {
	echo '<script type="text/javascript" src="'.get_settings('siteurl').'/wp-includes/js/prototype.js"></script>'."\n";
	echo '<script type="text/javascript" src="'.get_stylesheet_directory_uri().'/js/tab_change.js"></script>'."\n";
	}
}
add_action('admin_head', 'megumi_ukiyoe_theme_setting_head', 99);
?>