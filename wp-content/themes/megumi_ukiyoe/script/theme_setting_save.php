<?php function update_megumi_ukiyoe_theme_setting() {
	if (isset($_POST['analytics'])) {
		$analytics = wp_kses($_POST['analytics'],'');
		update_option('megumi_ukiyoe_analytics', $analytics);
	}
	if (isset($_POST['webmaster'])) {
		$webmaster = wp_kses($_POST['webmaster'],'');
		update_option('megumi_ukiyoe_webmaster', $webmaster);
	}
	if (isset($_POST['siteexplorer'])) {
		$siteexplorer = wp_kses($_POST['siteexplorer'],'');
		update_option('megumi_ukiyoe_siteexplorer', $siteexplorer);
	}
	if (isset($_POST['bing'])) {
		$bing = wp_kses($_POST['bing'],'');
		update_option('megumi_ukiyoe_bing', $bing);
	}
	if (isset($_POST['megumi_ukiyoe_data_format'])) {
		$megumi_ukiyoe_data_format = wp_kses($_POST['megumi_ukiyoe_data_format'],'');
		update_option('megumi_ukiyoe_data_format', $megumi_ukiyoe_data_format);
	}
	if (isset($_POST['megumi_ukiyoe_copyright'])) {
		$megumi_ukiyoe_copyright = wp_kses($_POST['megumi_ukiyoe_copyright'],'');
		update_option('megumi_ukiyoe_copyright', $megumi_ukiyoe_copyright);
	}
} ?>