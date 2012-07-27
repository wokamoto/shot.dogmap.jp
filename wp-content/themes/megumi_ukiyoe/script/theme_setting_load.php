<?php
// Megumi SEO
function get_analytics() {
	if(get_option('analytics')) {
		$value = apply_filters('analytics', get_option('megumi_ukiyoe_analytics'));
	}
	return $value;
}
function get_webmaster() {
	if(get_option('webmaster')) {
		$value = apply_filters('webmaster', get_option('megumi_ukiyoe_webmaster'));
	}
	return $value;
}
function get_siteexplorer() {
	if(get_option('siteexplorer')) {
		$value = apply_filters('siteexplorer', get_option('megumi_ukiyoe_siteexplorer'));
	}
	return $value;
}
function get_bing() {
	if(get_option('bing')) {
		$value = apply_filters('bing', get_option('megumi_ukiyoe_bing'));
	}
	return $value;
}
function get_megumi_ukiyoe_data_format() {
	if(get_option('megumi_ukiyoe_data_format')) {
		$value = apply_filters('megumi_ukiyoe_data_format', get_option('megumi_ukiyoe_data_format'));
	} else {
		$value = 'Y/m/d';
	}
	return $value;
}
function get_megumi_ukiyoe_copyright() {
	if(get_option('megumi_ukiyoe_copyright')) {
		$value = apply_filters('megumi_ukiyoe_copyright', get_option('megumi_ukiyoe_copyright'));
	} else {
		$blog_name = get_bloginfo();
		$value = 'Copyright (c) '.date('Y') .' '.$blog_name.'.';
	}
	return $value;
} ?>