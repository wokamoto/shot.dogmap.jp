<?php
require_once(dirname(__FILE__).'/theme_setting_save.php');
require_once(dirname(__FILE__).'/theme_setting_load.php');
add_action( 'admin_menu', 'add_webnist_theme_setting_menu' );
function add_webnist_theme_setting_menu() {
	add_menu_page(__('Photolog Theme Settings','webnist'), __('Photolog Theme Settings','webnist'), 10, 'webnist_theme_setting.php', 'webnist_theme_setting_menu');
}
function webnist_theme_setting_menu() { ?>
	<div class="wrap">
		<div id="icon-edit-pages" class="icon32"><br /></div>
		<h2><?php _e('Photolog Theme Settings','webnist'); ?></h2>
		<hr class="clear" />
		<?php if ($_POST['action']) {	?>
		<div id="message" class="updated fade"><p><strong><?php _e('Settings saved.') ?></strong></p></div>
		<?php } ?>
		<form method="post" action="<?php echo attribute_escape($_SERVER['REQUEST_URI']); ?>">
			<input type="hidden" name="action" value="update" />
			<div id="webnist_wrap">
				<ul id="tab_nav">
					<li class="present"><a href="#seo"><?php _e('Set SEO','webnist'); ?></a></li>
					<li><a href="#othe"><?php _e('Set Other','webnist'); ?></a></li>
				</ul>
				<div class="tabBox">
				<div id="seo" class="tabContent">
					<div class="set_box">
						<h3><?php _e('SEO Tools','webnist'); ?></h3>
						<table border="0" cellpadding="0" cellspacing="0"class="seo-table">
							<tr>
								<th><label for="analytics"><?php _e('Googlean Alytics','webnist'); ?></label></th>
								<td><input name="analytics" type="text" id="analytics" value="<?php echo get_analytics(); ?>" size="26" /></td>
							</tr>
							<tr>
								<th><label for="webmaster"><?php _e('Google Web Master Tools','webnist'); ?></label></th>
								<td><input name="webmaster" type="text" id="webmaster" value="<?php echo get_webmaster(); ?>" size="54" /></td>
							</tr>
							<tr>
								<th><label for="siteexplorer"><?php _e('Site Explorer','webnist'); ?></label></th>
								<td><input name="siteexplorer" type="text" id="siteexplorer" value="<?php echo get_siteexplorer(); ?>" size="26" /></td>
							</tr>
							<tr>
								<th><label for="bing"><?php _e('Bing','webnist'); ?></label></th>
								<td><input name="bing" type="text" id="bing" value="<?php echo get_bing(); ?>" size="42" /></td>
							</tr>
						</table>
					</div>
					<p class="submit"><input type="submit" value="<?php _e('Save Changes &raquo;','webnist'); ?>" /></p>
				</div>
				<div id="othe" class="tabContent">
					<div class="set_box">
						<h3><?php _e('Other Settings','webnist'); ?></h3>
						<table border="0" cellpadding="0" cellspacing="0"class="othe-table">
							<tr>
								<th><label for="webnist_data_format"><?php _e('Date Format') ?></label></th>
								<td><input name="webnist_data_format" type="text" id="webnist_data_format" value="<?php echo get_webnist_data_format(); ?>" /> <?php echo date(get_webnist_data_format()); ?></td>
							</tr>
							<tr>
								<th><label for="webnist_copyright"><?php _e('Copyright') ?></label></th>
								<td><input name="webnist_copyright" type="text" id="webnist_copyright" value="<?php echo get_webnist_copyright(); ?>" /></td>
							</tr>
						</table>
					</div>
					<p class="submit"><input type="submit" value="<?php _e('Save Changes &raquo;','webnist'); ?>" /></p>
				</div>
			</div>
			<hr class="clear" />
		</form>
	</div>
<?php
}
add_action( 'init', 'update_webnist_theme_setting');
?>