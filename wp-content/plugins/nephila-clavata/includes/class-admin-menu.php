<?php
if ( !class_exists('InputValidator') )
	require_once(dirname(__FILE__).'/class-InputValidator.php');
if ( !class_exists('S3_helper') )
	require_once(dirname(__FILE__).'/class-s3-helper.php');

class NephilaClavataAdmin {
	const OPTION_KEY  = 'nephila_clavata';
	const OPTION_PAGE = 'nephila-clavata';

	private $options = array();
	private $plugin_basename;
	private $admin_hook, $admin_action;
	private $option_keys = array(
		'access_key' => 'AWS Access Key',
		'secret_key' => 'AWS Secret Key',
		'region' => 'AWS Region',
		'bucket' => 'S3 Bucket',
		's3_url' => 'S3 URL',
		);
	private $regions = array(
		'US_EAST_1',
		'US_WEST_1',
		'US_WEST_2',
		'EU_WEST_1',
		'AP_SOUTHEAST_1',
		'AP_SOUTHEAST_2',
		'AP_NORTHEAST_1',
		'SA_EAST_1',
		'US_GOV_WEST_1'
		);

	function __construct(){
		$this->options = $this->get_option();
		$this->plugin_basename = NephilaClavata::plugin_basename();

		add_action('admin_menu', array(&$this, 'admin_menu'));
		add_filter('plugin_action_links', array(&$this, 'plugin_setting_links'), 10, 2 );
	}

	static public function get_option(){
		$options = get_option(self::OPTION_KEY);
		return $options;
	}

	//**************************************************************************************
	// Add Admin Menu
	//**************************************************************************************
	public function admin_menu() {
		global $wp_version;

		$title = __( 'Nephila clavata', NephilaClavata::TEXT_DOMAIN );
		$this->admin_hook = add_options_page($title, $title, 'manage_options', self::OPTION_PAGE, array(&$this, 'options_page'));
		$this->admin_action = admin_url('/options-general.php') . '?page=' . self::OPTION_PAGE;
	}

	public function options_page(){
		$nonce_action = 'update_options';
		$nonce_name   = '_wpnonce_update_options';

		$this->options = $this->get_option();
		$title = __( 'Nephila clavata', NephilaClavata::TEXT_DOMAIN );

		$iv = new InputValidator('POST');
		$iv->set_rules($nonce_name, 'required');

		// Update options
		if (!is_wp_error($iv->input($nonce_name)) && check_admin_referer($nonce_action, $nonce_name)) {
			// Get posted options
			$fields = array_keys($this->option_keys);
			foreach ($fields as $field) {
				switch ($field) {
				case 'access_key':
				case 'secret_key':
					$iv->set_rules($field, array('trim','esc_html','required'));
					break;
				default:
					$iv->set_rules($field, array('trim','esc_html'));
					break;
				}
			}
			$options = $iv->input($fields);
			if ((!isset($options['s3_url']) || empty($options['s3_url'])) && (isset($options['bucket']) && !empty($options['bucket']))) {
				$options['s3_url'] = sprintf(
					'http://%1$s.s3-website-%2$s.amazonaws.com',
					strtolower($options['bucket']),
					strtolower(str_replace('_','-',$options['region']))
					);
			}
			$options['s3_url'] = untrailingslashit($options['s3_url']);
			if (NephilaClavata::DEBUG_MODE && function_exists('dbgx_trace_var')) {
				dbgx_trace_var($options);
			}

			// Update options
			update_option(self::OPTION_KEY, $options);
			printf('<div id="message" class="updated fade"><p><strong>%s</strong></p></div>'."\n", __('Done!', NephilaClavata::TEXT_DOMAIN));
			$this->options = $options;
			unset($options);
		}

		// Get S3 Object
		$s3 = new S3_helper(
			isset($this->options['access_key']) ? $this->options['access_key'] : null,
			isset($this->options['secret_key']) ? $this->options['secret_key'] : null,
			isset($this->options['region']) ? $this->options['region'] : null
			);
		$regions = $this->regions;
		$buckets = false;
		if ($s3) {
			$regions = $s3->get_regions();
			$buckets = $s3->list_buckets();
		}
		if (!$buckets) {
			unset($this->option_keys['bucket']);
			unset($this->option_keys['s3_url']);
		}

?>
		<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php echo esc_html( $title ); ?></h2>
		<form method="post" action="<?php echo $this->admin_action;?>">
		<?php echo wp_nonce_field($nonce_action, $nonce_name, true, false) . "\n"; ?>
		<table class="wp-list-table fixed"><tbody>
		<?php foreach ($this->option_keys as $field => $label) { $this->input_field($field, $label, array('regions' => $regions, 'buckets' => $buckets)); } ?>
		</tbody></table>
		<?php submit_button(); ?>
		</form>
		</div>
<?php
	}

	private function input_field($field, $label, $args = array()){
		extract($args);

		$label = sprintf('<th><label for="%1$s">%2$s</label></th>'."\n", $field, __($label, NephilaClavata::TEXT_DOMAIN));

		$input_field = sprintf('<td><input type="text" name="%1$s" value="%2$s" id="%1$s" size=100 /></td>'."\n", $field, esc_attr($this->options[$field]));
		switch ($field) {
		case 'region':
			if ($regions && count($regions) > 0) {
				$input_field  = sprintf('<td><select name="%1$s">', $field);
				$input_field .= '<option value=""></option>';
				foreach ($regions as $region) {
					$input_field .= sprintf(
						'<option value="%1$s"%2$s>%3$s</option>',
						esc_attr($region),
						$region == $this->options[$field] ? ' selected' : '',
						__($region, NephilaClavata::TEXT_DOMAIN));
				}
				$input_field .= '</select></td>';
			}
			break;
		case 'bucket':
			if ($buckets && count($buckets) > 0) {
				$input_field  = sprintf('<td><select name="%1$s">', $field);
				$input_field .= '<option value=""></option>';
				foreach ($buckets as $bucket) {
					$input_field .= sprintf(
						'<option value="%1$s"%2$s>%1$s</option>',
						esc_attr($bucket['Name']),
						$bucket['Name'] == $this->options[$field] ? ' selected' : '');
				}
				$input_field .= '</select></td>';
			}
			break;
		}

		echo "<tr>\n{$label}{$input_field}</tr>\n";
	}

	//**************************************************************************************
	// Add setting link
	//**************************************************************************************
	public function plugin_setting_links($links, $file) {
		if ($file === $this->plugin_basename) {
			$settings_link = '<a href="' . $this->admin_action . '">' . __('Settings') . '</a>';
			array_unshift($links, $settings_link); // before other links
		}

		return $links;
	}
}
