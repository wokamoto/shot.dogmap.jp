<?php
/* ************************************************ 
 * Megumi SEO Menu
 * ************************************************ */
function megumi_ukiyoe_googleanalytics() {
	if ($value){
		echo("<script type=\"text/javascript\">\n");
		echo("	var gaJsHost = ((\"https:\" == document.location.protocol) ? \"https://ssl.\" : \"http://www.\");\n");
		echo("	document.write(unescape(\"%3Cscript src='\" + gaJsHost + \"google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E\"));\n");
		echo("</script>\n");
		echo("<script type=\"text/javascript\">\n");
		echo("	try {\n");
		echo("		var pageTracker = _gat._getTracker(\"$analytics\");\n");
		echo("		pageTracker._trackPageview();\n");
		echo("	} catch(err) {}\n");
		echo("</script>\n");
	}
}
add_action('wp_footer','megumi_ukiyoe_googleanalytics',99);
function megumi_ukiyoe_googlewebmastertools() {
	$value = get_webmaster();
	if ($value){
		echo("<meta name=\"verify-v1\" content=\"$webmaster\" />\n");
	}
}
add_action('wp_head', 'megumi_ukiyoe_googlewebmastertools');
function megumi_ukiyoe_siteexplorer() {
	$value = get_siteexplorer();
	if ($value){
		echo("<meta name=\"y_key\" content=\"$siteexplorer\" />\n");
	}
}
add_action('wp_head','megumi_ukiyoe_siteexplorer');
function megumi_ukiyoe_bing() {
	$value = get_bing();
	if ($value){
		echo("<meta name=\"msvalidate.01\" content=\"$bing\" />\n");
	}
}
add_action('wp_head','megumi_ukiyoe_bing');
/* ---- Data Format ---- */
function megumi_ukiyoe_data_format() {
	echo the_time(get_megumi_ukiyoe_data_format());
}
/* ---- Copyright ---- */
function megumi_ukiyoe_copyright() {
	echo get_megumi_ukiyoe_copyright();
} ?>