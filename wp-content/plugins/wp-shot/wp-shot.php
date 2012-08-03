<?php
/*
Plugin Name: wp-shot
Plugin URI: http://wppluginsj.sourceforge.jp/wp-shot/
Description: You can attach images inline in your email messages and they'll be shown as an image in your wordpress article. (WordPress 2.1+ only)
Version: 0.4.4
Author: Otsukare &amp; <a href="http://dogmap.jp/">wokamoto</a>
Author URI: 
Text Domain: wp-shot
Domain Path: /lang/
*/

/*
 based on wp-mail.php of WordPress 2.0.5

 Copyright 2006 - 2011
  WordPress Plugins/JSeries: http://wppluginsj.sourceforge.jp/wp-shot/

 Released under the GPL license
  http://www.gnu.org/copyleft/gpl.html

  Copyright (c) 2003-2004 The Wordpress Team
  Copyright (c) 2004 - John B. Hewitt - jb@stcpl.com.au
  Copyright (c) 2004 - Dan Cech - dcech@lansmash.com
  Copyright (c) 2006 - Santaro Otsukare - staybymyside [at] gmail.com
  Copyright (c) 2009 - wokamoto - wokamoto1973@gmail.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!function_exists('wp_schedule_single_event'))
	return FALSE;

define('WP_SHOT_LOG_WRITE', FALSE);
define('WP_SHOT_SCHEDULE_HANDLER', 'wp_shot_mail_check');

if (!defined('CUSTOM_TAGS')) define('CUSTOM_TAGS', true);
if (!CUSTOM_TAGS) {
	$allowedposttags = array (
		'address' => array () ,
		'a' => array ('href' => array (), 'title' => array (), 'rel' => array (), 'rev' => array (), 'name' => array (), 'class' => array (), 'onclick' => array ()) ,
		'abbr' => array ('title' => array ()) ,
		'acronym' => array ('title' => array ()) ,
		'b' => array () ,
		'big' => array () ,
		'blockquote' => array ('cite' => array ()) ,
		'br' => array ('class' => array ()) ,
		'button' => array ('disabled' => array (), 'name' => array (), 'type' => array (), 'value' => array ()) ,
		'caption' => array ('align' => array ()), 'code' => array (), 'col' => array ('align' => array (), 'char' => array (), 'charoff' => array (), 'span' => array (), 'valign' => array (), 'width' => array ()) ,
		'del' => array ('datetime' => array ()) ,
		'dd' => array () ,
		'div' => array ('align' => array ()) ,
		'dl' => array () ,
		'dt' => array () ,
		'em' => array () ,
		'fieldset' => array () ,
		'font' => array ('color' => array (), 'face' => array (), 'size' => array ()) ,
		'form' => array ('action' => array (), 'accept' => array (), 'accept-charset' => array (), 'enctype' => array (), 'method' => array (), 'name' => array (), 'target' => array ()) ,
		'h1' => array ('align' => array ()) ,
		'h2' => array ('align' => array ()) ,
		'h3' => array ('align' => array ()) ,
		'h4' => array ('align' => array ()) ,
		'h5' => array ('align' => array ()) ,
		'h6' => array ('align' => array ()) ,
		'hr' => array ('align' => array (), 'noshade' => array (), 'size' => array (), 'width' => array ()) ,
		'i' => array (), 'img' => array ('alt' => array (), 'align' => array (), 'border' => array (), 'height' => array (), 'hspace' => array (), 'longdesc' => array (), 'vspace' => array (), 'src' => array (), 'width' => array (), 'class' => array ()) ,
		'ins' => array ('datetime' => array (), 'cite' => array ()) ,
		'kbd' => array () ,
		'label' => array ('for' => array ()) ,
		'legend' => array ('align' => array ()) ,
		'li' => array () ,
		'p' => array ('align' => array ()) ,
		'pre' => array ('width' => array ()) ,
		'q' => array ('cite' => array ()) ,
		's' => array () ,
		'strike' => array () ,
		'strong' => array () ,
		'sub' => array () ,
		'sup' => array () ,
		'table' => array ('align' => array (), 'bgcolor' => array (), 'border' => array (), 'cellpadding' => array (), 'cellspacing' => array (), 'rules' => array (), 'summary' => array (), 'width' => array ()) ,
		'tbody' => array ('align' => array (), 'char' => array (), 'charoff' => array (), 'valign' => array ()) ,
		'td' => array ('abbr' => array (), 'align' => array (), 'axis' => array (), 'bgcolor' => array (), 'char' => array (), 'charoff' => array (), 'colspan' => array (), 'headers' => array (), 'height' => array (), 'nowrap' => array (), 'rowspan' => array (), 'scope' => array (), 'valign' => array (), 'width' => array ()) ,
		'textarea' => array ('cols' => array (), 'rows' => array (), 'disabled' => array (), 'name' => array (), 'readonly' => array ()) ,
		'tfoot' => array ('align' => array (), 'char' => array (), 'charoff' => array (), 'valign' => array ()) ,
		'th' => array ('abbr' => array (), 'align' => array (), 'axis' => array (), 'bgcolor' => array (), 'char' => array (), 'charoff' => array (), 'colspan' => array (), 'headers' => array (), 'height' => array (), 'nowrap' => array (), 'rowspan' => array (), 'scope' => array (), 'valign' => array (), 'width' => array ()) ,
		'thead' => array ('align' => array (), 'char' => array (), 'charoff' => array (), 'valign' => array ()) ,
		'title' => array () ,
		'tr' => array ('align' => array (), 'bgcolor' => array (), 'char' => array (), 'charoff' => array (), 'valign' => array ()) ,
		'tt' => array () ,
		'u' => array () ,
		'ul' => array () ,
		'ol' => array () ,
		'var' => array () ,
	);

	$allowedtags = array (
		'a' => array ('href' => array (), 'title' => array ()), 'abbr' => array ('title' => array ()), 'acronym' => array ('title' => array ()), 'b' => array (), 'blockquote' => array ('cite' => array ()) ,
//		'br' => array() ,
		'code' => array () ,
//		'del' => array('datetime' => array()) ,
//		'dd' => array() ,
//		'dl' => array() ,
//		'dt' => array() ,
		'em' => array () ,
		'i' => array () ,
//		'ins' => array('datetime' => array(), 'cite' => array()) ,
//		'li' => array() ,
//		'ol' => array() ,
//		'p' => array() ,
//		'q' => array() ,
		'strike' => array () ,
		'strong' => array () ,
//		'sub' => array() ,
//		'sup' => array() ,
//		'u' => array() ,
//		'ul' => array() ,
	);
}

class wpShot {
	var $dir_division, $dir_name_full, $dir_name, $textdomain_name;
	var $log_file_name;
	var $datetime_format;
	var $photosdir, $link_photosdir;
	var $shot_use_thumb;
	var $error;

	function wpShot(){
		$this->__construct();
	}
	function __construct() {
		global $wp_version;

		$this->dir_division  = preg_match("/^WIN/i", PHP_OS) ? "\\" : "/";
		$this->dir_name_full = dirname(__FILE__);
		$wp_shot_dir_array   = explode($this->dir_division, $this->dir_name_full);
		$this->dir_name      = array_pop($wp_shot_dir_array);
		$this->log_file_name = $this->dir_name_full . '/wp-shot.log';
		unset($wp_shot_dir_array);

		$this->datetime_format = get_option("date_format") . " @" . get_option("time_format");
		$this->error = '';

		// Get Options
		if (get_option('shot_add_dir', FALSE)) {
			$this->photosdir      = trailingslashit(get_option('shot_dir_pass'), '');
			$this->link_photosdir = trailingslashit(get_option('shot_dir_url'), '');
		} else {
			$cur_dir = wp_upload_dir();
			$this->photosdir      = trailingslashit($cur_dir['path']);
			$this->link_photosdir = trailingslashit($cur_dir['url']);
			unset($cur_dir);
		}
		$this->shot_use_thumb = get_option('shot_make_samb', FALSE);

		// Load Plugin textdomain
		$this->textdomain_name = $this->dir_name;
		$abs_plugin_dir = $this->pluginsDir($this->dir_name);
		$sub_dir        = (file_exists($abs_plugin_dir.'languages') ? 'languages' : (file_exists($abs_plugin_dir.'language') ? 'language' : (file_exists($abs_plugin_dir.'lang') ? 'lang' : '')));
		$textdomain_dir = trailingslashit(trailingslashit($this->dir_name) . $sub_dir);
		if (version_compare($wp_version, "2.6", ">=") && defined('WP_PLUGIN_DIR')) {
			load_plugin_textdomain($this->textdomain_name, false, $textdomain_dir);
		} else {
			load_plugin_textdomain($this->textdomain_name, $this->pluginsDir($textdomain_dir));
		}

		// Prevent launch of wp-mail.php
		if (preg_match('/\/wp-mail\.php(\?.*)?$/i', $_SERVER['REQUEST_URI'])) {
			header('HTTP/1.0 403 Forbidden');
			wp_die(__("You don't have permission to access the URL on this server.", $this->textdomain_name));
		}

		if (is_admin()) {
			add_action('admin_menu', array(&$this, 'menu'));
			add_filter('plugin_action_links', array(&$this, 'plugin_action_links'), 10, 2 );
		} else {
			add_action('wp_head', array(&$this, 'style'));
		}

		if ( !$this->schedule_enabled() ) {
			 $this->schedule_single_event();
		}
		add_action(WP_SHOT_SCHEDULE_HANDLER, array(&$this, 'mail_check'));
	}

	// contentDir
	function contentDir($path = '') {
		return trailingslashit(trailingslashit(!defined('WP_CONTENT_DIR')
			? WP_CONTENT_DIR
			: trailingslashit(ABSPATH) . 'wp-content'
			) . $path);
	}

	// contentUrl
	function contentUrl($path = '') {
		return trailingslashit(trailingslashit(!defined('WP_CONTENT_URL')
			? WP_CONTENT_URL
			: trailingslashit(get_option('siteurl')) . 'wp-content'
			) . $path);
	}

	// pluginsDir
	function pluginsDir($path = '') {
		return trailingslashit($this->contentDir( 'plugins/' . $path ));
	}

	// pluginsUrl
	function pluginsUrl($path = '') {
		return trailingslashit($this->contentUrl( 'plugins/' . $path ));
	}

	function style() {
		$style =  '<link rel="stylesheet"'
			. ' href="' . $this->pluginsUrl($this->dir_name) . 'style.css"'
			. ' type="text/css" media="screen" />';

		echo $style;
	}

	function subpanel() {
		$warn = '';
		if (isset($_POST['update_shot_style'])) {
			// strip slashes array
			$_POST = $this->_strip_array($_POST);

			$shot_make_samb = $_POST['shot_make_samb'];
			$shot_samb_size = (int) is_numeric($_POST['shot_samb_size']) ? $_POST['shot_samb_size'] : 120;
			$shot_ilink_att = trim($_POST['shot_ilink_att']);
			$shot_rotate    = (int) is_numeric($_POST['shot_rotate']) ? $_POST['shot_rotate'] : 0;

			update_option('shot_make_samb', $shot_make_samb);
			update_option('shot_samb_size', $shot_samb_size);
			update_option('shot_ilink_att', $shot_ilink_att);
			update_option('shot_rotate',    $shot_rotate);

			$warn = '<div class="updated"><p>' . __('Changed the Layout Options.', $this->textdomain_name) . '</p></div>';

		} elseif (isset($_POST['update_shot_etc'])) {
			// strip slashes array
			$_POST = $this->_strip_array($_POST);

			$shot_add_dir       = $_POST['shot_add_dir'];
			$shot_dir_pass      = $_POST['shot_dir_pass'];
			$shot_dir_url       = $_POST['shot_dir_url'];
			$shot_rfc_check     = isset($_POST['shot_rfc_check']) ? $_POST['shot_rfc_check'] : FALSE;
			$shot_time_interval = (int) is_numeric($_POST['shot_time_interval']) ? $_POST['shot_time_interval'] : 10;

			update_option('shot_add_dir', $shot_add_dir);
			update_option('shot_dir_pass', $shot_dir_pass);
			update_option('shot_dir_url', $shot_dir_url);
			update_option('shot_rfc_check', $shot_rfc_check);
			update_option('shot_time_interval', $shot_time_interval);

			$warn = '<div class="updated"><p>' . __('Changed the Posting Options.', $this->textdomain_name) . '</p></div>';

		} elseif (isset($_POST['delete_shot_options'])) {
			if ($schedule['enabled'])
				wp_unschedule_event($schedule['time'], $schedule['procname']);

			delete_option('shot_make_samb');
			delete_option('shot_samb_size');
			delete_option('shot_ilink_att');
			delete_option('shot_rotate');
			delete_option('shot_add_dir');
			delete_option('shot_dir_pass');
			delete_option('shot_rfc_check');
			delete_option('shot_time_interval');
			delete_option('shot_execution_log');
			delete_option('shot_cron_notify');
			delete_option('shot_cron_log');

			update_option('mailserver_url', 'mail.example.com');
			update_option('mailserver_port', 110);
			update_option('mailserver_login', 'login@example.com');
			update_option('mailserver_pass', 'password');

			$warn = '<div class="updated"><p>' . __('Options Deleted.', $this->textdomain_name) . '</p></div>';
		}

		if (!empty($warn)) {
			echo $warn;
			$schedule = $this->_get_schedule(TRUE);
		} else {
			$schedule = $this->_get_schedule();
		}
?>
	<div class="wrap">
		<h2><?php _e('Shot Settings', $this->textdomain_name); ?></h2>
		<form method="post">
			<table width="100%" cellpadding="3" cellspacing="3">
				<tr class="white">
					<th scope="row" align="left" valign="top" rowspan="2">1.</th>
					<td class="alternate"><?php _e('Set the <a href="./users.php">user</a> for E-mail posting with the level of Author(Level2).', $this->textdomain_name); ?></td>
				</tr>
				<tr class="white">
					<td class="white"><?php _e("Enter your mobile phone's E-Mail address here.", $this->textdomain_name); ?></td>
				</tr>
				<tr class="white">
					<th scope="row" align="left" valign="top" rowspan="2">2.</th>
					<td class="alternate"><?php _e('Create a <a href="./categories.php">category</a> for E-mail posting.', $this->textdomain_name); ?></td>
				</tr>
				<tr class="white">
					<td class="white"><?php printf(__('The current selected category: %s ', $this->textdomain_name), get_catname(get_option('default_email_category'))); ?></td>
				</tr>
				<tr class="white">
					<th scope="row" align="left" valign="top" rowspan="2">3.</th>
					<td class="alternate"><?php _e("Use the mobile phone's E-mail address for posting.", $this->textdomain_name); ?></td>
				</tr>
				<tr class="white">
					<td class="white"><?php _e('All the mail in the inbox will be deleted after the blog recieves them. Please make sure to have the E-mail address only for posting blog entries.', $this->textdomain_name); ?></td>
				</tr>
				<tr class="white">
					<th scope="row" align="left" valign="top" rowspan="2">4.</th>
					<td class="alternate"><?php _e('Set the mail server via the Option => <a href="options-writing.php">Writting Option</a>', $this->textdomain_name); ?></td>
				</tr>
				<tr class="white">
					<td class="white"><?php _e('The Current Settings:', $this->textdomain_name); ?>
						<ul>
							<li><?php _e('Mail server:') . form_option('mailserver_url'); ?></li>
							<li><?php _e('Port:') . form_option('mailserver_port'); ?></li>
							<li><?php _e('Login name:') . form_option('mailserver_login'); ?></li>
							<li><?php _e('Password:') . form_option('mailserver_pass'); ?></li>
						</ul>
					</td>
				</tr>
				<tr class="white">
					<th scope="row" align="left" valign="top" rowspan="2">5.</th>
					<td class="alternate"><?php _e('translate line_218 into en_US.', $this->textdomain_name); ?></td>
				</tr>
				<tr class="white">
					<td class="white"><input name="shot_rfc_check" type="checkbox" value="1" <?php checked(1, get_option('shot_rfc_check')); ?> /> <?php _e('translate line_222 into en_US.', $this->textdomain_name); ?></td>
				</tr>
				<tr class="white">
					<th scope="row" align="left" valign="top" rowspan="7">6.</th>
					<td class="alternate"><?php _e('Create a directry for images and set the rewritable permission.', $this->textdomain_name); ?></td>
				</tr>
				<tr class="white">
					<td><input name="shot_add_dir" type="radio" value="0" <?php checked(0, get_option('shot_add_dir')); ?> /> <?php _e('<a href="./options-misc.php">Keep the Current Directry</a> => ', $this->textdomain_name); ?> <?php echo wp_specialchars(str_replace(ABSPATH, '', get_option('upload_path')), 1); ?></td>
				</tr>
				<tr class="white">
					<td><input name="shot_add_dir" type="radio" value="1" <?php checked(1, get_option('shot_add_dir')); ?> /> <?php _e('Create Your Own => Fill out the following both text fields without slashes (/) at the end.', $this->textdomain_name); ?></td>
				</tr>
				<tr class="white">
					<td><?php _e('Absolute Path of the Directry', $this->textdomain_name); ?> : <input name="shot_dir_pass" type="text" value="<?php echo get_option('shot_dir_pass'); ?>" size="60" /></td>
				</tr>
				<tr class="white">
					<td><?php _e('Example', $this->textdomain_name); ?> : <?php echo dirname(dirname(dirname(dirname(__FILE__)))) . $this->dir_division . 'wp-photos'; ?></td>
				</tr>
				<tr class="white">
					<td><?php _e('URL of the Directry', $this->textdomain_name); ?> : <input name="shot_dir_url" type="text" value="<?php echo get_option('shot_dir_url'); ?>" size="60" /></td>
				</tr>
				<tr class="white">
					<td><?php _e('Example', $this->textdomain_name); ?> : <?php echo get_option('siteurl') . '/wp-photos'; ?></td>
				</tr>
				<tr class="white">
					<th scope="row" align="left" valign="top" rowspan="<?php echo (!empty($schedule['last_log']) ? 5 : 3); ?>">7.</th>
					<td class="alternate">
						<?php _e('Interval when mail is checked.', $this->textdomain_name); ?>&nbsp;
					</td>
				</tr>
				<tr class="white">
					<td><input name="shot_time_interval" type="text" value="<?php echo get_option('shot_time_interval', 10); ?>" />&nbsp;<?php _e('minute', $this->textdomain_name);?></td>
				</tr>
				<tr class="white">
					<td><?php echo $schedule['text']; ?></td>
				</tr>
<?php if (!empty($schedule['last_log'])) : ?>
				<tr class="white">
					<td class="alternate"><strong><?php _e('The last execution log.', $this->textdomain_name); ?></strong></td>
				</tr>
				<tr class="white">
					<td><?php echo $schedule['last_log']; ?></td>
				</tr>
<?php endif; ?>
			</table>
			<p class="submit"><input type="submit" name="update_shot_etc" class=\"button-primary\" value="<?php _e('Save the Options', $this->textdomain_name); ?>" style="font-weight:bold;" /></p>
		</form>
	</div>

	<div class="wrap">
		<h2><?php _e('Layout Settings', $this->textdomain_name); ?></h2>
		<form method="post">
			<table width="100%" cellpadding="3" cellspacing="3">
				<tr class="white">
					<td><input name="shot_make_samb" type="radio" value="0" <?php checked(0, get_option('shot_make_samb')); ?> /> <?php _e('Do Not Use Thumbnail', $this->textdomain_name); ?></td>
					<td><?php _e('Simply an Image will be placed above texts', $this->textdomain_name); ?></td>
				</tr>
				<tr class="alternate">
					<td><input name="shot_make_samb" type="radio" value="1" <?php checked(1, get_option('shot_make_samb')); ?> /> <?php _e('Use Thumbnail', $this->textdomain_name); ?></td>
					<td><?php _e('The following fields must be filled for this option.', $this->textdomain_name); ?></td>
				</tr>
				<tr class="white">
					<td><?php _e('The maximum length (px)', $this->textdomain_name); ?></td>
					<td><input name="shot_samb_size" type="text" value="<?php echo get_option('shot_samb_size'); ?>" size="5" /> px</td>
				</tr>
				<tr class="white">
					<td><?php _e('Rotate', $this->textdomain_name); ?></td>
					<td><input name="shot_rotate" type="text" value="<?php echo get_option('shot_rotate'); ?>" size="5" /></td>
				</tr>
				<tr class="alternate">
					<td><?php _e('Attributes for the IMG tag<br />(only when the thumbnail is used.)', $this->textdomain_name); ?></td>
					<td><input name="shot_ilink_att" type="text" value='<?php echo get_option('shot_ilink_att'); ?>' size="45" /><br /><?php _e('Example : class="highslide" onclick="return hs.expand(this)"', $this->textdomain_name); ?></td>
				</tr>
			</table>
			<p><div class="submit"><input type="submit" name="update_shot_style" class=\"button-primary\" value="<?php _e('Save Layout Option', $this->textdomain_name); ?>"  style="font-weight:bold;" /></div></p>
		</form>
	</div>

	<div class="wrap">
		<h2><?php _e('Uninstall', $this->textdomain_name); ?></h2>
		<form method="post">
			<p><div class="submit"><input type="submit" name="delete_shot_options" class=\"button-primary\" value="<?php _e('Delete Options', $this->textdomain_name); ?>"  style="font-weight:bold;" /></div></p>
		</form>
	</div>
<?php
		unset ($schedule);
	}

	function menu() {
		if (function_exists('add_options_page')) {
			add_options_page(
				__('WP-Shot Config', $this->textdomain_name),
				__($this->textdomain_name, $this->textdomain_name),
				'administrator',
				basename(__FILE__),
				array(&$this, 'subpanel')
				);
		}
	}

	function plugin_action_links($links, $file) {
		$this_plugin = plugin_basename(__FILE__);
		if ($file == $this_plugin) {
			$settings_link = '<a href="options-general.php?page=' . basename(__FILE__) . '">' . __('Settings') . '</a>';
			array_unshift($links, $settings_link); // before other links
		}
		return $links;
	}

	function set_transient($key, $value, $expiration) {
		return
			function_exists('set_site_transient')
			? set_site_transient($key, $value, $expiration)
			: set_transient($key, $value, $expiration);
	}

	function get_transient($key) {
		return
			function_exists('get_site_transient')
			? get_site_transient($key)
			: get_transient($key);
	}

	function delete_transient($key) {
		return
			function_exists('delete_site_transient')
			? delete_site_transient($key)
			: delete_transient($key);
	}

	function mail_check() {
		if (!$this->get_transient(WP_SHOT_SCHEDULE_HANDLER)) {
			$time_interval = (int) get_option('shot_time_interval', 0);
			$expiration = ($time_interval > 0 ? $time_interval : 1) * 60;
			$this->set_transient(WP_SHOT_SCHEDULE_HANDLER, time(), $expiration);

			$message = $this->_retrieve_mail();

			if (defined('WP_SHOT_LOG_WRITE') && WP_SHOT_LOG_WRITE) {
				$handle = fopen($this->log_file_name, 'w');
				fwrite($handle, $message);
				fclose($handle);
			} else {
				update_option('shot_execution_log', $message);
			}

			$this->delete_transient(WP_SHOT_SCHEDULE_HANDLER);
		}

		$this->schedule_single_event();
	}

	function schedule_single_event() {
		$time_interval = (int) get_option('shot_time_interval', 0);
		if ($time_interval > 0)
			wp_schedule_single_event(time() + $time_interval * 60, WP_SHOT_SCHEDULE_HANDLER);
	}

	function schedule_enabled($schedule_procname = WP_SHOT_SCHEDULE_HANDLER) {
		$schedule = $this->_get_schedule($schedule_procname);
		return ($schedule['enabled']);
	}

	// Handles Add/strips slashes to the given array
	function _strip_array($array) {
		if(!is_array($array)) return $array;
		foreach($array as $key => $value) {$slashed_array[$key] = stripslashes($value);}
		return $slashed_array;
	}

	// based on cron.php of WordPress 2.8.5
	function _upgrade_cron_array($cron) {
		if ( function_exists('_upgrade_cron_array') ) {
			return _upgrade_cron_array($cron);
		} else {
			if ( isset($cron['version']) && 2 == $cron['version'])
				return $cron;

			$new_cron = array();

			foreach ( (array) $cron as $timestamp => $hooks) {
				foreach ( (array) $hooks as $hook => $args ) {
					$key = md5(serialize($args['args']));
					$new_cron[$timestamp][$hook][$key] = $args;
				}
			}

			$new_cron['version'] = 2;
			update_option( 'cron', $new_cron );
			return $new_cron;
		}
	}

	// based on cron.php of WordPress 2.8.5
	function _get_cron_array() {
		if ( function_exists('_get_cron_array') ) {
			return _get_cron_array();
		} else {
			$cron = get_option('cron');
			if ( ! is_array($cron) )
				return false;

			if ( !isset($cron['version']) )
				$cron = $this->_upgrade_cron_array($cron);

			unset($cron['version']);

			return $cron;
		}
	}

	// get wp-cron schedule
	function _get_schedule($force = false, $schedule_procname = WP_SHOT_SCHEDULE_HANDLER) {
		$schedule = (!$force ? (array) maybe_unserialize(wp_cache_get("WP_SHOT_SCHEDULE")) : FALSE);
		if ($schedule !== FALSE)
			return ($schedule);

		$schedule = array(
			'procname' => '' ,
			'enabled' => FALSE ,
			'text' => '' ,
			'time' => '' ,
			'last_log' => ''
		);

		$crons = $this->_get_cron_array();
		if ( empty($crons) ) {
			$schedule['text'] = __('Nothing scheduled.', $this->textdomain_name);
		} else {
			foreach ( $crons as $time => $tasks ) {
				foreach ( $tasks as $procname => $task ) {
					if ($procname === $schedule_procname) {
						$schedule['procname'] = $procname;
						$schedule['text'] = '<p>' . sprintf(__('Anytime after <strong>%s</strong> execute tasks.', $this->textdomain_name), date($this->datetime_format, $time)) . '</p>';
						$schedule['time'] = $time;
						$schedule['enabled'] = true;
						break;
					}
				}
				if ($schedule['enabled']) break;
			}
			unset($procname); unset($task);
			unset($time); unset ($tasks);
		}
		unset($crons);

		if (defined('WP_SHOT_LOG_WRITE') && WP_SHOT_LOG_WRITE && file_exists($this->log_file_name)) {
			$schedule['last_log'] = @file_get_contents($this->log_file_name);
			if ($schedule['last_log'] === FALSE) $schedule['last_log'] = '';
		} else {
			$schedule['last_log'] = get_option('shot_execution_log', $schedule['last_log']);
		}
		wp_cache_set("WP_SHOT_SCHEDULE", maybe_serialize($schedule));

		return ($schedule);
	}

	// based on wp-mail.php of WordPress 2.0.5
	function _retrieve_mail() {
		$includes_dir = $this->dir_name_full . '/includes/';
		require_once $includes_dir . 'class-pop3.php';
		if (! @include_once 'Mail/mimeDecode.php')			// try to use PEAR in the server.
			require_once $includes_dir . 'mimeDecode.php';		// use local version

		$pop3 = new POP3();

		$time_difference = get_option('gmt_offset');
		$message = '<p><strong>[' . date($this->datetime_format). "]</strong></p>\n";

		// Connect Mail Server
		if (!$pop3->connect(get_option('mailserver_url'), get_option('mailserver_port'))) {
			$message .= '<p>' . sprintf(__('Oops: %s'), wp_specialchars($pop3->ERROR)) . '</p>';
			unset($pop3);
			return $message;
		}

		// Getting Mail
		$count = $pop3->apop(get_option('mailserver_login'), get_option('mailserver_pass'));
		if (FALSE === $count) {
			$message .= !empty($pop3->ERROR)
				? '<p>' . sprintf(__('Oops: %s'), wp_specialchars($pop3->ERROR)) . '</p>'
				: '<p>' . __("There doesn't seem to be any new mail.") .'</p>';
			$pop3->quit();
			unset($pop3);
			return $message;
		} elseif (0 == $count) {
			$message .= '<p>' . __("There doesn't seem to be any new mail.") .'</p>';
			$pop3->quit();
			unset($pop3);
			return $message;
		}

		// looping over messages
		for ($i=1; $i <= $count; $i++) {
			//variables
			$content_type = '';
			$boundary = '';
			$bodysignal = 0;

			// get mail
			$input = implode('', $pop3->get($i));

			//decode the mime
			$params = array(
				'include_bodies' => true ,
				'decode_bodies'  => true ,
				'decode_headers' => false ,
				'input'          => $input
			);
			$structure = Mail_mimeDecode::decode($params);
			$ctype = $structure->ctype_parameters;

			// 差出人アドレスの抽出と検証
			$from = $this->_yn_read_address($structure);
			if (! $from) {
				$message .= '<p>' . "Error: No sender address found at message #$i.\n" . '</p>';
				continue;
			}
			$post_author = $this->_yn_validate_address($from);
			if ( $post_author === FALSE ) {
				$message .= '<p>' . "Error: Sender address '$from' is not allowd to post at message #$i.\n" . '</p>';
				continue;
			}

			// 題名の取り出し
			$post_title = trim($structure->headers['subject']);
			$post_title = $this->_decode_header($post_title, $ctype);

			//date reformating
			$post_time_gmt = strtotime(trim($structure->headers['date']));
			if (! $post_time_gmt) {
				$message .= '<p>' . "Error: There is no Date: field at message #$i.\n" . '</p>';
				continue;
			}
			$post_date = gmdate('Y-m-d H:i:s', $post_time_gmt + ($time_difference * 3600));
			$post_date_gmt = gmdate('Y-m-d H:i:s', $post_time_gmt);

			// 投稿内容の取り出し
			$content = $this->_get_content($structure);
			$post_content = $this->_decode_header($content['post_content'], $ctype);
			// strip extra line breaks
			$post_content = preg_replace(
				array('/ (\n|\r\n|\r)/', '/(\n|\r\n|\r)/') ,
				array(' ', "\n") ,
				trim($post_content)
			);
			//try and determine category
			if ( preg_match('/.*\[(.+)\](.+)/', $post_title, $matches) ) {
				$post_category[0] = $matches[1];
				$post_title = $matches[2];
			}

			if (empty($post_category))
				$post_category[] = get_option('default_email_category');

			//report
			$message .= '<p>';
			$message .= '<b>From</b>: '     . wp_specialchars($from) . '<br />';
			$message .= '<b>Date</b>: '     . wp_specialchars($post_date) . '<br />';
			$message .= '<b>Date GMT</b>: ' . wp_specialchars($post_date_gmt) . '<br />';
			$message .= '<b>Category</b>: ' . wp_specialchars(intval($post_category)) . '<br />';
			$message .= '<b>Subject</b>: '  . wp_specialchars($post_title) . '<br />';
			if (0 < count($content['images'])) {
				$message .= '<b>Image Files</b>: <br />';
				$message .= '<ul>';
				foreach ($content['images'] as $image)
					$message .= '<li>' . $image['file'] . '</li>';
				unset($image);
				$message .= '</ul><br />';
			}
			$message .= '<b>Posted content:</b>';
			$message .= '<hr />' . wp_specialchars($post_content) . '<hr />';
			$message .= '</p>';

			// 入力項目を数点追加
			// post_name は http://plasticdreams.org/archives/2007/02/01/1639/no-post-slug-please/ 
			$post_status = 'publish';
			$post_name   = strtolower(preg_replace('/[^%a-zA-Z0-9 _-]/', '', $post_title));
			$details = array(
				'post_author'       => $post_author ,
				'post_date'         => $post_date ,
				'post_date_gmt'     => $post_date_gmt ,
				'post_content'      => $post_content ,
				'post_title'        => $post_title ,
				'post_modified'     => $post_date ,
				'post_modified_gmt' => $post_date_gmt ,
				'post_category'     => $post_category ,
				'post_status'       => $post_status ,
				'post_name'         => $post_name
			);

			// delete mail
			if(! $pop3->delete($i)) {
				$message .= '<p>' . sprintf(__('Oops: %s'), wp_specialchars($pop3->ERROR)) . '</p>';
				$pop3->reset();
				$pop3->quit();
				unset($pop3);
				return $message;
			}
			$message .= '<p>' . sprintf(__('Mission complete.  Message <strong>%s</strong> deleted.'), $i) . '</p>';

			// WPのデータ入力関数に変更
			$post_ID = wp_insert_post($details);
			do_action('publish_post',  $post_ID);
			do_action('publish_phone', $post_ID);

			/****** タイムアウト回避
			pingback($content, $post_ID);

			foreach ($post_categories as $post_category) {
				$post_category = intval($post_category);

				// Double check it's not there already
				$exists = $wpdb->get_row("SELECT * FROM $tablepost2cat WHERE post_id = $post_ID AND category_id = $post_category");

				 if (!$exists && $result) { 
					$wpdb->query("
					INSERT INTO $tablepost2cat
					(post_id, category_id)
					VALUES
					($post_ID, $post_category)
					");
				}
			}
			*/
			unset($details);

			// メディアライブラリに追加
			$result .= $this->_insert_attachment($post_ID, $post_author, $content['images']);
			if ( $result !== FALSE ) $message .= $result;
			unset($image);

		} // end looping over messages

		$pop3->quit();
		unset($pop3);

		return $message;
	}

	function _get_content($part, $meta_return = '') {
		$add_link_rel  = ' ' . get_option('shot_ilink_att', '');
		$shot_max_size = (int) get_option('shot_samb_size', 100);

		if (empty($meta_return)) {
			$meta_return = array('post_content' => '', 'images' => array(), 'applications' => array());
		}

		switch (strtolower($part->ctype_primary)) {
			case 'multipart':
				foreach ($part->parts as $section)
					$meta_return = $this->_get_content($section, $meta_return);
				unset($section);

				if (0 < count($meta_return['images'])) {
					$images = array_reverse($meta_return['images']);
					foreach ($images as $image)
						$meta_return['post_content'] = $image['post_content'] . $meta_return['post_content'];
					unset($images); unset($image);
				}

				if (0 < count($meta_return['applications'])) {
					$applications = array_reverse($meta_return['applications']);
					foreach ($applications as $application)
						$meta_return['post_content'] = $application['post_content'] . $meta_return['post_content'];
					unset($applications); unset($application);
				}
				break;

			case 'text':
				//dump the enriched stuff
				if ($part->ctype_secondary == 'enriched') {
					break;
				} else {
					$meta_return['post_content'] .= $part->body;
					if($this->shot_use_thumb)
						$meta_return['post_content'] .= "<br class=\"shot-clear\" />\n";
					else
						$meta_return['post_content'] .= "\n";
				}
				break;

			case 'image':
				$image_type = ( strtolower($part->ctype_secondary) == 'jpeg' ? 'jpg' : strtolower($part->ctype_secondary) );
				$image_name = attribute_escape($part->ctype_parameters['name']);
				$filename =
					$this->photosdir .
					sprintf("%u", crc32( $image_name . rand() ) ) .
					'.' . $image_type;

				// Lotate image
				$angle = (int) get_option('shot_rotate', 0);
				if ($angle != 0) {
					$rotated = imagerotate(imagecreatefromstring($part->body), $angle, 0);
					switch ($image_type) {
						case 'gif':
							$result = imagegif($rotated, $filename);
							break;
						case 'png':
							$result = imagepng($rotated, $filename);
							break;
						case 'jpg':
						default:
							$result = imagejpeg($rotated, $filename);
							break;
					}
					imagedestroy($rotated);
				} else {
					$fp = fopen($filename, 'w');
					fwrite($fp, $part->body);
					fclose($fp);
				}
				$real_file = str_replace($this->photosdir, '', $filename);

				// Create thumbnail
				if($this->shot_use_thumb) {
					$thumb = $this->_create_thumbnail($filename, $shot_max_size, NULL);
					if ($thumb !== FALSE) {
						$real_thumb = str_replace($this->photosdir, '', $thumb);
						$post_content =
							  '<a href="'  . $this->link_photosdir . $real_file  . '"' . $add_link_rel . '>'
							. '<img src="' . $this->link_photosdir . $real_thumb . '" alt="' . $image_name . '" class="shot-float" />'
							. '</a>';
					} else {
						$thumb = '';
						$real_thumb = '';
						$post_content =
							  '<img src="' . $this->link_photosdir . $real_file  . '" alt="' . $image_name . '" class="shot-image" />'
							. "\n\n";
					}
				} else {
					$thumb = '';
					$real_thumb = '';
					$post_content =
						  '<img src="' . $this->link_photosdir . $real_file  . '" alt="' . $image_name . '" class="shot-image" />'
						. "\n\n";
				}
				$meta_return['images'][] = array(
					'type'         => $part->ctype_primary . '/' . $part->ctype_secondary ,
					'url'          => $this->link_photosdir . $real_file ,
					'file'         => $filename ,
					'thumb_file'   => $thumb ,
					'title'        => $image_name ,
					'post_content' => $post_content ,
				);
				break;

			case 'application':
				//pgp signature
				if ( $part->ctype_secondary == 'pgp-signature' ) {
					break;
				} else {
					//other attachments
					$image_name = attribute_escape($part->ctype_parameters['name']);
					$filename = $filesdir . $image_name;
					$fp = fopen($filename, 'w');
					fwrite($fp, $part->body);
					fclose($fp);
					$post_content =
						  '<a href="' . $filename . '">'
						. $image_name . '</a>' . "\n";
					$meta_return['applications'][] = array(
						'type' => $part->ctype_primary . '/' . $part->ctype_secondary ,
						'file' => $filename ,
						'title' => $image_name ,
						'post_content' => $post_content ,
					);
				}
				break;
		}

		return $meta_return;
	}

	// メディアライブラリに追加
	function _insert_attachment($post_ID, $post_author, $images) {
		if ( !function_exists('wp_insert_attachment')) return FALSE;

		$result = '';
		foreach ((array) $images as $image) {
			$file = $image['file'];
			$attachment_title   = preg_replace('/\.[^.]+$/', '', basename($image['title']));
			$attachment_content = '';

			if ( function_exists('wp_read_image_metadata') && $image_meta = @wp_read_image_metadata($file) ) {
				if ( trim($image_meta['title']) )
					$attachment_title = $image_meta['title'];
				if ( trim($image_meta['caption']) )
					$attachment_content = $image_meta['caption'];
			}

			$attachment = array(
				'post_mime_type' => $image['type'] ,
				'guid'           => $image['url'] ,
				'post_parent'    => $post_ID ,
				'post_author'    => $post_author ,
				'post_title'     => $attachment_title ,
				'post_content'   => $attachment_content ,
				'post_excerpt'   => $attachment_content ? $attachment_content : basename($image['title'])
			);

			$attachment_id = wp_insert_attachment($attachment, $file, $post_ID);
			$result .= @ $this->_update_attachment_metadata($attachment, $attachment_id, $file);
			unset($attachment);
		}

		return $result;
	}

	// ==================================================
	// based on pickup_rfc2822_address() at post.php from ktai_entry
	function _yn_rfc2822_mail_address($addr) {
		$addresses = array();
		$quoted    = array();

		// ----- save quoted text -----
		while (1) {
			preg_match('/(^|[^\\\\])("([^\\\\"]|\\\\.)*")/', $addr, $m);
			if (! $m[2]) break;
			$addr = preg_replace("/(^|[^\\\\])$m[2]/", "$1\376\376\376" . count($quoted) . "\376\376\376", $addr, 1);
			$quoted[] = $m[2];
		}
		// ---- remove comments -----
		$addr = preg_replace('/\([^)]*[^\\\\]\)/', '', $addr);
		// ----- remove group name -----
		$addr = preg_replace('/[-\w ]+:([^;]*);/', '$1', $addr);
		// ----- split into each address -----
		foreach (explode(',', $addr) as $a) {
			$a = str_replace(' ', '', $a);
			preg_match('/<([^>]*)>/', $a, $m);
			if ($m[1]) $a = $m[1];
			// ----- restore quoted text -----
			$a = preg_replace('/\376\376\376(\d+)\376\376\376/e', '$quoted[$1]', $a);
			// ----- got address -----
			if ($a) $addresses[] = $a;
		}
		return $addresses;
	}


	// ==================================================
	// based on yn_read_address() at wp-mta.php from wp-mta
	function _yn_read_address($structure) {
		$senders = $this->_yn_rfc2822_mail_address(trim($structure->headers['from']));
		$sender = $senders[0];
		if (! $sender) {
			$senders = $this->_yn_rfc2822_mail_address(trim($structure->headers['return-path']));
			$sender = $senders[0];
		}
		return $sender;
	}

	// ==================================================
	// based on yn_validate_address() at wp-mta.php from wp-mta
	function _yn_validate_address($sender) {
		global $wpdb;
		$email4sql = $wpdb->escape($sender);
		$result = $wpdb->get_row("SELECT ID FROM {$wpdb->users} WHERE user_email = '$email4sql' LIMIT 1");
		if (! $result)
			return FALSE;
		else
			return $result->ID;
	}

	// ==================================================
	// based on _decodeHeader() at Mail_mimeDecode.php from PEAR
	function _decode_mime($input) {
		// Remove white space between encoded-words
		$input = preg_replace('/(=\?[^?]+\?(q|b)\?[^?]*\?=)(\s)+=\?/i', '\1=?', $input);

		// For each encoded-word...
		while (preg_match('/(=\?([^?]+)\?(q|b)\?([^?]*)\?=)/i', $input, $matches)) {
			list($match, $encoded, $charset, $encoding, $text) = $matches;

			switch (strtolower($encoding)) {
				case 'b':
					$text = base64_decode($text);
					break;

				case 'q':
					$text = str_replace('_', ' ', $text);
					preg_match_all('/=([a-f0-9]{2})/i', $text, $matches);
					foreach($matches[1] as $value)
						$text = str_replace('='.$value, chr(hexdec($value)), $text);
					break;
			}

			$input = str_replace($encoded, $text, $input);
		}
		unset($matches);

		return $input;
	}

	// ==================================================
	// based on line 78-105 at inline-uploading.php of WP ME 2.0.11
	function _update_attachment_metadata($attachment, $id, $file) {
		$metadata = array();
		if ( preg_match('!^image/!', $attachment['post_mime_type']) ) {
			// Generate the attachment's postmeta.
			$imagesize = getimagesize($file);
			$metadata['width'] = $imagesize['0'];
			$metadata['height'] = $imagesize['1'];
			$metadata['hwstring_small'] = "height='{$metadata['width']}' width='{$metadata['height']}'";
			$metadata['file'] = $file;
			unset($imagesize);
		}
		add_post_meta($id, '_wp_attachment_metadata', $metadata);
		unset($metadata);
	}

	// ==================================================
	// based on decode_header() at post.php from ktai_entry
	function _decode_header($encoded, $ctype, $place = 'elesewhere') {
		if (preg_match('/=\?([^?]+)\?[qb]\?/ims', $encoded, $mime)) {
			$encoding = $mime[1];
			$encoded  = $this->_decode_mime($encoded);
		} else {
			$encoding = isset($ctype['charset']) ? $ctype['charset'] : 'JIS, SJIS, UTF-8, EUC-JP';
		}
		unset($mime);
		return mb_convert_encoding($encoded, get_bloginfo('charset'), $encoding);
	}

	// ==================================================
	/**
	* enhanced copy of wp_create_thumbnail()
	* エフェクトやクォリティ対応の要望があればバージョンアップで対応
	*/
	function _create_thumbnail($file, $max_side, $effect = '') {
		if (!file_exists($file)) {
			$this->error = __('File not found');
			return FALSE;
		}

		// create the initial copy from the original file
		$type = getimagesize($file);
		$thumbpath = FALSE;
		switch ($type[2]) {
			case IMAGETYPE_GIF:
				if (function_exists('imagecreatefromgif'))
					$image = imagecreatefromgif($file);
				else
					$this->error = __('Filetype not supported. Thumbnail not created.');
				break;
			case IMAGETYPE_JPEG:
				if (function_exists('imagecreatefromjpeg'))
					$image = imagecreatefromjpeg($file);
				else
					$this->error = __('Filetype not supported. Thumbnail not created.');
				break;
			case IMAGETYPE_PNG:
				if (function_exists('imagecreatefrompng'))
					$image = imagecreatefrompng($file);
				else
					$this->error = __('Filetype not supported. Thumbnail not created.');
				break;
			default:
				$this->error = __('Filetype not supported. Thumbnail not created.');
				break;
		}

		// create thumbnail
		if (isset($image)) {
			if (function_exists('imageantialias'))
				imageantialias($image, TRUE);

			$image_attr = getimagesize($file);

			// figure out the longest side
			$dims = image_resize_dimensions($image_attr[0], $image_attr[1], $max_side, $max_side, false);
			if (!$dims) return $dims;
			list($dst_x, $dst_y, $src_x, $src_y, $image_new_width, $image_new_height, $image_crop_width, $image_crop_height) = $dims;

			$thumbnail = imagecreatetruecolor($image_new_width, $image_new_height);
			@ imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $image_new_width, $image_new_height, $image_attr[0], $image_attr[1]);

			// If no filters change the filename, we'll do a default transformation.
			if ( basename($file) == $thumb = apply_filters('thumbnail_filename', basename($file)) )
				$thumb = preg_replace('!(\.[^.]+)?$!', __('.thumbnail').'$1', basename($file), 1);

			$thumbpath = str_replace(basename($file), $thumb, $file);
		}

		// move the thumbnail to it's final destination
		if ($thumbpath !== FALSE) {
			switch ($type[2]) {
				case IMAGETYPE_GIF:
					if (!(function_exists('imagegif') && imagegif($thumbnail, $thumbpath))) {
						$this->error = __("Thumbnail path invalid");
						$thumbpath = FALSE;
					}
					break;
				case IMAGETYPE_JPEG:
					if (!(function_exists('imagejpeg') && imagejpeg($thumbnail, $thumbpath))) {
						$this->error = __("Thumbnail path invalid");
						$thumbpath = FALSE;
					}
					break;
				case IMAGETYPE_PNG:
					if (!(function_exists('imagepng') && imagepng($thumbnail, $thumbpath))) {
						$this->error = __("Thumbnail path invalid");
						$thumbpath = FALSE;
					}
					break;
				default:
					$this->error = __("Thumbnail path invalid");
					$thumbpath = FALSE;
					break;
			}
		}

		return $thumbpath;
	}
}

new wpShot();
