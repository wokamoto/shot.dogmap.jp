<form method="get" id="searchform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" />
<INPUT TYPE="image" id="searchsubmit" value="search" NAME="submit" src="<?php bloginfo('stylesheet_directory'); ?>/images/search_btn.gif" width="110" height="15" border="0" alt="Submit">
</div>
</form>
