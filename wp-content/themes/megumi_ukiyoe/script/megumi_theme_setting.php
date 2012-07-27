<?php
require_once(dirname(__FILE__).'/theme_setting_save.php');
require_once(dirname(__FILE__).'/theme_setting_load.php');
add_action( 'admin_menu', 'add_megumi_ukiyoe_theme_setting_menu' );
function add_megumi_ukiyoe_theme_setting_menu() {
	add_menu_page(__('Photolog Theme Settings','megumi'), __('Photolog Theme Settings','megumi'), 10, 'megumi_ukiyoe_theme_setting.php', 'megumi_ukiyoe_theme_setting_menu');
}
function megumi_ukiyoe_theme_setting_menu() { ?>
	<div class="wrap">
		<div id="icon-edit-pages" class="icon32"><br /></div>
		<h2><?php _e('Photolog Theme Settings','megumi'); ?></h2>
		<hr class="clear" />
		<?php if ($_POST['action']) {	?>
		<div id="message" class="updated fade"><p><strong><?php _e('Settings saved.') ?></strong></p></div>
		<?php } ?>
		<form method="post" action="<?php echo attribute_escape($_SERVER['REQUEST_URI']); ?>">
			<input type="hidden" name="action" value="update" />
			<div id="megumi_ukiyoe_wrap">
				<ul id="tab_nav">
					<li class="present"><a href="#seo"><?php _e('Set SEO','megumi'); ?></a></li>
					<li><a href="#othe"><?php _e('Set Other','megumi'); ?></a></li>
				</ul>
				<div class="tabBox">
				<div id="seo" class="tabContent">
					<div class="set_box">
						<h3><?php _e('SEO Tools','megumi'); ?></h3>
						<table border="0" cellpadding="0" cellspacing="0"class="seo-table">
							<tr>
								<th><label for="analytics"><?php _e('Googlean Alytics','megumi'); ?></label></th>
								<td><input name="analytics" type="text" id="analytics" value="<?php echo get_analytics(); ?>" size="26" /></td>
							</tr>
							<tr>
								<th><label for="webmaster"><?php _e('Google Web Master Tools','megumi'); ?></label></th>
								<td><input name="webmaster" type="text" id="webmaster" value="<?php echo get_webmaster(); ?>" size="54" /></td>
							</tr>
							<tr>
								<th><label for="siteexplorer"><?php _e('Site Explorer','megumi'); ?></label></th>
								<td><input name="siteexplorer" type="text" id="siteexplorer" value="<?php echo get_siteexplorer(); ?>" size="26" /></td>
							</tr>
							<tr>
								<th><label for="bing"><?php _e('Bing','megumi'); ?></label></th>
								<td><input name="bing" type="text" id="bing" value="<?php echo get_bing(); ?>" size="42" /></td>
							</tr>
						</table>
					</div>
					<p class="submit"><input type="submit" value="<?php _e('Save Changes &raquo;','megumi'); ?>" /></p>
				</div>
				<div id="othe" class="tabContent">
					<div class="set_box">
						<h3><?php _e('Other Settings','megumi'); ?></h3>
						<table border="0" cellpadding="0" cellspacing="0"class="othe-table">
							<tr>
								<th><label for="megumi_ukiyoe_data_format"><?php _e('Date Format') ?></label></th>
								<td><input name="megumi_ukiyoe_data_format" type="text" id="megumi_ukiyoe_data_format" value="<?php echo get_megumi_ukiyoe_data_format(); ?>" /> <?php echo date(get_megumi_ukiyoe_data_format()); ?></td>
							</tr>
							<tr>
								<th><label for="megumi_ukiyoe_copyright"><?php _e('Copyright') ?></label></th>
								<td><input name="megumi_ukiyoe_copyright" type="text" id="megumi_ukiyoe_copyright" value="<?php echo get_megumi_ukiyoe_copyright(); ?>" /></td>
							</tr>
						</table>
					</div>
					<p class="submit"><input type="submit" value="<?php _e('Save Changes &raquo;','megumi'); ?>" /></p>
				</div>
			</div>
			<hr class="clear" />
		</form>
	</div>
<?php
}
add_action( 'init', 'update_megumi_ukiyoe_theme_setting');
?>