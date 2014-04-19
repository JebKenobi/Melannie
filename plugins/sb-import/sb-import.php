<?php
/*
  Plugin Name: SB Import
  Plugin URI: http://plugins.seven-bytes.com/sb_import
  Description: Import content/options
  Version: 1.0
  Author: Seven Bytes (office@seven-bytes.com)
 */

class SbImport {
	
	private $import_files = array();

	function __construct() {
		add_action('admin_menu', array($this, 'add_menu_page'));
		
		$this->import_files = array(
			// content
			'all_content' => __('Content', 'sb-import'),
//			'all_without_attachments' => __('Content: without attachments', 'sb-import'),
//			'only_attachments' => __('Content: only attachments', 'sb-import'),
			// layer_slider
//			'layer_slider' => __('Layer slider', 'sb-import'),
			// news_page_slider
			'news_page_slider' => __('News page slider', 'sb-import'),
			// revslider
			'revslider' => __('Revolution slider', 'sb-import'),
			// smk_sidebar_generator
			'smk_sidebar_generator' => __('SMK Sidebar Generator', 'sb-import'),
			// widgets
			'widgets' => __('Widgets', 'sb-import'),
			// theme_options
			//'theme_options' => __('Theme options', 'sb-import'),
			// options
			'options' => __('Options', 'sb-import'),
		);
	}

	function add_menu_page() {
		add_menu_page(
				__('SB Import'),
				__('SB Import'),
				'import',
				'sb-import',
				array($this, 'page_import'),
				'',
				82
			);
	}

	function page_import() {
		if (!empty($_POST) && wp_verify_nonce($_POST['sb-import'], 'sb-import')) {
			self::import();
		} elseif (!empty($_GET) && isset($_GET['_nonce']) && wp_verify_nonce($_GET['_nonce'], 'sb_import_nonce') && isset($_GET['action']) && $_GET['action'] === 'import') { 
			@self::import();
		} else {
			?>
			<div class="wrap">
				<div class="ls-icon-layers"></div>
				<h2><?php _e('Import'); ?></h2>

				<form method="post" action="">
					<?php wp_nonce_field('sb-import', 'sb-import'); ?>
					<button class="button-primary" type="submit"><?php _e('Import all') ?></button>
				</form>
				
				<br />
				<?php echo __('OR', 'sb-import'); ?>
				<br />
				
				<form method="post" action="">
					<?php wp_nonce_field('sb-import', 'sb-import'); ?>
					<?php if (!empty($this->import_files)) :
						foreach ($this->import_files as $file=>$filename) : ?>
						<p>
							<label>
								<input type="checkbox" name="import_files[]" value="<?php echo $file; ?>" /> <?php echo $filename; ?>
							</label>
						</p>
					<?php endforeach; endif; ?>
					<button class="button-primary" type="submit"><?php _e('Import selected files') ?></button>
				</form>
			</div>
			<?php
		}
	}

	private static function import() {
		global $wpdb;
		set_time_limit(0);
		if (!defined('WP_MEMORY_LIMIT')) { define('WP_MEMORY_LIMIT', '512M' ); }
		
		if (!empty($_POST['import_files'])) {
			foreach ($_POST['import_files'] as $file) {
				
				if (in_array($file, array('all_content', 'all_without_attachments', 'only_attachments'))) {
					if (is_callable('self::import_content')) {
						call_user_func('self::import_content', array($file));
					}
				} else {
					if (is_callable('self::import_'.$file)) {
						call_user_func('self::import_'.$file);
					}
				}
				
				
			}
		} else {
			
			// content
			self::import_content(array(
				'all_content',
//				'all_without_attachments',
//				'only_attachments',
			));

			// layerslider
//			self::import_layer_slider();

			// smk-sidebar-generator
			self::import_smk_sidebar_generator();

			// news-page-slider
			self::import_news_page_slider();
			
			// revslider
			self::import_revslider();

			// widgets
			self::import_widgets();

			// kadabra theme options
			//self::import_theme_options();

			// wp options
			self::import_options();
		}
		
	}
	
	private static function import_content($data_names=array()){
		global $wpdb;
		
		if (!class_exists( 'WP_Import')) {
			require_once dirname(__FILE__) .'/wordpress-importer.php';
		}
		
		if ( class_exists( 'WP_Import' ) && !empty($data_names)) {
			
			$wp_upload_dir = wp_upload_dir();
			self::rmdir($wp_upload_dir['basedir']);
			
			$wpdb->query("TRUNCATE TABLE {$wpdb->prefix}posts");
			$wpdb->query("TRUNCATE TABLE {$wpdb->prefix}postmeta");
			
			$wpdb->query("TRUNCATE TABLE {$wpdb->prefix}terms");
			$wpdb->query("TRUNCATE TABLE {$wpdb->prefix}term_relationships");
			$wpdb->query("TRUNCATE TABLE {$wpdb->prefix}term_taxonomy");
			
			$wpdb->query("TRUNCATE TABLE {$wpdb->prefix}comments");
			$wpdb->query("TRUNCATE TABLE {$wpdb->prefix}commentmeta");
			
			foreach($data_names as $data_name) {
				$data_file = self::getFile("{$data_name}.xml");
				
				if (!file_exists($data_file)) {
					echo "<p><b>Import Error</b>: File for '{$data_name}' is not exists!</p>";
					continue;
				}
				
				$importer = new WP_Import();
				$importer->fetch_attachments = true;
				$importer->import($data_file);
				
				_e("<p><b>'{$data_name}'</b> imported!</p>");
			}
		} else {
			_e('<p>Content wasn`t imported! :o(</p>');
		}
	}

	private static function import_layer_slider() {
		global $wpdb;
		
		ob_start();

		$data_file = self::getFile('layerslider.txt');

		if (!file_exists($data_file)) {
			echo '<p>LayerSlider file is not exists!</p>';
			return;
		}

		if (!is_plugin_active('LayerSlider/layerslider.php')) {
			echo '<p>LayerSlider plugin is not active!</p>';
			return;
		}

		$data = file_get_contents($data_file);
		if (empty($data)) {
			echo '<p>LayerSlider file is empty!</p>';
			return;
		}

		$sample_slider = json_decode(base64_decode($data), true);

		$table_name = $wpdb->prefix . "layerslider";

		$wpdb->query("TRUNCATE TABLE {$table_name}");
		foreach ($sample_slider as $key => $val) {
			$wpdb->query(
					$wpdb->prepare("INSERT INTO $table_name (id, name, data, date_c, date_m) "
							. "VALUES (%d, %s, %s, %d, %d)", $key, $val['properties']['title'], json_encode($val), time(), time())
			);
		}

		echo '<p>LayerSlider data imported!</p>';

		ob_end_flush();
	}

	private static function import_smk_sidebar_generator() {
		global $wpdb;
		
		ob_start();

		$data_file = self::getFile('smk_sidebar_generator.txt');

		if (!file_exists($data_file)) {
			echo '<p>smk_sidebar_generator file is not exists!</p>';
			return;
		}

		if (!is_plugin_active('smk-sidebar-generator/smk-sidebar-generator.php')) {
			echo '<p>smk_sidebar_generator plugin is not active!</p>';
			return;
		}

		$data = file_get_contents($data_file);
		if (empty($data)) {
			echo '<p>smk_sidebar_generator file is empty!</p>';
			return;
		}
		
		$data = maybe_unserialize(base64_decode($data));
		
		delete_option('smk_sidebar_generator_option');
		if (update_option('smk_sidebar_generator_option', $data)) {
			echo '<p>smk_sidebar_generator data imported!</p>';
		} else {
			echo '<p>smk_sidebar_generator data not imported!</p>';
		}

		ob_end_flush();
	}

	private static function import_news_page_slider() {
		global $wpdb;
		
		ob_start();

		$data_file = self::getFile('news_page_slider.txt');

		if (!file_exists($data_file)) {
			echo '<p>news_page_slider file is not exists!</p>';
			return;
		}

		if (!is_plugin_active('news-page-slider/news-page-slider.php')) {
			echo '<p>news_page_slider plugin is not active!</p>';
			return;
		}

		$data = file_get_contents($data_file);
		if (empty($data)) {
			echo '<p>news_page_slider file is empty!</p>';
			return;
		}

		$sample_slider = json_decode(base64_decode($data), true);

		$table_name = $wpdb->prefix . "news_page_slider";

		$wpdb->query("TRUNCATE TABLE {$table_name}");
		foreach ($sample_slider as $key => $val) {
			$wpdb->query(
					$wpdb->prepare("INSERT INTO $table_name (id, name, data, date_c, date_m) VALUES (%d, %s, %s, %d, %d)", $key, $val['name'], json_encode($val['data']), time(), time()
					)
			);
		}

		echo '<p>news_page_slider data imported!</p>';

		ob_end_flush();
	}

	// Thanks to http://wordpress.org/plugins/widget-settings-importexport/
	private static function import_widgets() {
		$added = true;
		
		ob_start();

		$data_file = self::getFile('wp-widgets.wie');

		if (!file_exists($data_file)) {
			echo '<p>Widgets file is not exists!</p>';
			return;
		}

		$data = file_get_contents($data_file);
		if (empty($data)) {
			echo '<p>Widgets file is empty!</p>';
			return;
		}
		
		$data = json_decode($data, true);
		
		$available_widgets = array();
		foreach ($GLOBALS['wp_widget_factory']->widgets as $available_widget) {
			$available_widgets[] = $available_widget->id_base;
		}
		
		$widgets_out = array();
		$sidebars_out = array();
		
		$sidebars_out['wp_inactive_widgets'] = array();
		
		foreach ( $data as $sidebar_id => $widgets ) {
			if ( 'wp_inactive_widgets' == $sidebar_id ) {
				continue;
			}
			
			// active widgets in sidebars
			foreach ($widgets as $widget_name=>$widget_settings) {
				$id_base = preg_replace( '/-[0-9]+$/', '', $widget_name );
				$instance_id_number = str_replace( $id_base . '-', '', $widget_name );
				
				if (!in_array($id_base, $available_widgets))
					continue;
				
				$sidebars_out[$sidebar_id][] = $widget_name;
				
				$widgets_out[$id_base][$instance_id_number] = $widget_settings;
			}
		}
		
		// save widgets
		foreach ($widgets_out as $wo_k=>$wo_v) {
			if (count($widgets_out[$wo_k]) > 1) {
				$widgets_out[$wo_k]['_multiwidget'] = 1;
			}
			
			delete_option('widget_'.$wo_k);
			if (!add_option('widget_'.$wo_k, $wo_v))
				$added = false;
		}
		
		// save sidebars
		$sidebars_out['array_version'] = 1;
		delete_option('sidebars_widgets');
		if (!add_option('sidebars_widgets', $sidebars_out))
			$added = false;

		if ($added) {
			echo '<p>Widgets data imported!</p>';
		} else {
			echo '<p>Widgets data not imported!</p>';
		}
		
		ob_end_flush();

	}

	private static function import_theme_options() {
		ob_start();

		$data_file = self::getFile('theme_options.txt');

		if (!file_exists($data_file)) {
			echo '<p>theme options file is not exists!</p>';
			return;
		}
		
		$theme = wp_get_theme('kadabra');
		
		if (!$theme->exists()) {
			echo '<p>kadabra theme is not active!</p>';
			return;
		}

		$data = file_get_contents($data_file);
		$data = trim($data, '#');
		if (empty($data)) {
			echo '<p>theme options file is empty!</p>';
			return;
		}
		
		$data_array = maybe_unserialize(trim($data));
		if (is_array($data_array)) {
			foreach ($data_array as $k=>$v) {
				if(is_array($v)) {
					$v = serialize($v);
				}
				$data_array[$k] = preg_replace('/^(ht.+?)\/wp-content/i', site_url( 'wp-content'), trim($v));
			}
			
			$data = $data_array;
		}

		delete_option('kadabra');
		if ( update_option( 'kadabra', maybe_unserialize($data) ) )  {
			echo '<p>theme options imported!</p>';
		} else {
			echo '<p>theme options not imported!</p>';
		}

		ob_end_flush();
	}
	
	private static function import_options() {
		ob_start();
		
		$data_file = self::getFile('options.txt');

		if (!file_exists($data_file)) {
			echo '<p>wp options file is not exists!</p>';
			return;
		}
		
		$data = file_get_contents($data_file);
		if (empty($data)) {
			echo '<p>wp options file is empty!</p>';
			return;
		}
		
		$data = unserialize(base64_decode($data));
		
		foreach ($data as $key=>$option) {
			if (in_array($key, array('woocommerce', 'wc_wishlist')))
				continue;
			
			delete_option($key);
			update_option($key, $option);
		}
		
		if (is_plugin_active('woocommerce/woocommerce.php')) {
			foreach ($data['woocommerce'] as $wc_key=>$wc_option) {
				delete_option($wc_key);
				update_option($wc_key, $wc_option);
			}
		}
		
		if (is_plugin_active('yith-woocommerce-wishlist/init.php')) {
			foreach ($data['wc_wishlist'] as $wcwl_key=>$wcwl_option) {
				delete_option($wcwl_key);
				update_option($wcwl_key, $wcwl_option);
			}
		}
		
		echo '<p>wp options imported!</p>';
		
		ob_end_flush();
	}
	
	private static function import_revslider() {
		global $wpdb;
		
		ob_start();

		$data_file = self::getFile('revslider.txt');

		if (!file_exists($data_file)) {
			echo '<p>Revolution slider file is not exists!</p>';
			return;
		}

		if (!is_plugin_active('revslider/revslider.php')) {
			echo '<p>Revolution slider plugin is not active!</p>';
			return;
		}

		$data = file_get_contents($data_file);
		if (empty($data)) {
			echo '<p>Revolution slider file is empty!</p>';
			return;
		}

		$revslider_data = json_decode(base64_decode($data), true);
		if (empty($revslider_data)) {
			echo '<p>Revolution slider file is empty!</p>';
			return;
		}

		$sliders_table = $wpdb->prefix . GlobalsRevSlider::TABLE_SLIDERS_NAME;
		$slides_table = $wpdb->prefix . GlobalsRevSlider::TABLE_SLIDES_NAME;
		$settings_table = $wpdb->prefix . GlobalsRevSlider::TABLE_SETTINGS_NAME;
		$css_table = $wpdb->prefix . GlobalsRevSlider::TABLE_CSS_NAME;
		$layer_anims_table = $wpdb->prefix . GlobalsRevSlider::TABLE_LAYER_ANIMS_NAME;

		$wpdb->query("TRUNCATE TABLE {$sliders_table};");
		$wpdb->query("TRUNCATE TABLE {$slides_table};");
		$wpdb->query("TRUNCATE TABLE {$settings_table};");
		$wpdb->query("TRUNCATE TABLE {$css_table};");
		$wpdb->query("TRUNCATE TABLE {$layer_anims_table};");
		
		// settings
		if (!empty($revslider_data['settings'])) {
			$sql = "INSERT INTO `$settings_table` (`id`, `general`, `params`) VALUES ";
			$sql_data = array();
			foreach ($revslider_data['settings'] as $setting) {
				$sql_data[] = $wpdb->prepare("(%d, %s, %s)", 
						$setting['id'], 
						$setting['general'], 
						$setting['params']);
			}
			$sql .= implode(',', $sql_data).';';
			$wpdb->query($sql);
			unset($sql);
		}
		
		// css
		if (!empty($revslider_data['css'])) {
			$sql = "INSERT INTO `$css_table` (`id`, `handle`, `settings`, `hover`, `params`) VALUES ";
			$sql_data = array();
			foreach ($revslider_data['css'] as $css) {
				$sql_data[] = $wpdb->prepare("(%d, %s, %s, %s, %s)", 
						$css['id'], 
						$css['handle'], 
						$css['settings'], 
						$css['hover'], 
						$css['params']);
			}
			$sql .= implode(',', $sql_data).';';
			$wpdb->query($sql);
			unset($sql);
		}
		
		// layer animation
		if (!empty($revslider_data['layer_anims'])) {
			$sql = "INSERT INTO `$layer_anims_table` (`id`, `handle`, `params`) VALUES ";
			$sql_data = array();
			foreach ($revslider_data['layer_anims'] as $layer_anim) {
				$sql_data[] = $wpdb->prepare("(%d, %s, %s)", 
						$layer_anim['id'], 
						$layer_anim['handle'], 
						$layer_anim['params']);
			}
			$sql .= implode(',', $sql_data).';';
			$wpdb->query($sql);
			unset($sql);
		}
		
		// sliders
		
		if (!empty($revslider_data['sliders'])) {
			foreach($revslider_data['sliders'] as $slider) {
				$sql = $wpdb->prepare("INSERT INTO `$sliders_table` (`id`, `title`, `alias`, `params`) VALUES (%d, %s, %s, %s)", 
						$slider['id'], 
						$slider['title'], 
						$slider['alias'], 
						$slider['params']);
				$wpdb->query($sql);
				unset($sql);
				
				// slides
				if (!empty($revslider_data['sliders']['slides'])) {
					$sql = "INSERT INTO `$slides_table` (`id`, `slider_id`, `slide_order`, `params`, `layers`) VALUES ";
					$sql_data = array();
					foreach ($revslider_data['sliders']['slides'] as $slides) {
						$sql_data[] = $wpdb->prepare("(%d, %d, %d, %s, %s)", 
								$layer_anim['id'], 
								$layer_anim['slider_id'], 
								$layer_anim['slide_order'],
								$layer_anim['params'],
								$layer_anim['layers']);
					}
					$sql .= implode(',', $sql_data).';';
					$wpdb->query($sql);
					unset($sql);
				}
			}
		}

		echo '<p>Revslider data imported!</p>';

		ob_end_flush();
	}
	
	private static function rmdir($dir) {
		if ($objs = glob($dir . "/*")) {
			foreach ($objs as $obj) {
				is_dir($obj) ? self::rmdir($obj) : @unlink($obj);
			}
		}
		@rmdir($dir);
	}

	private static function getFile($filename) {
		$theme_import_dir = get_template_directory() . '/inc/sb_import/';
		
		if (is_file($theme_import_dir . $filename)) {
			return $theme_import_dir . $filename;
		} elseif (is_file(dirname(__FILE__) . '/data/' . $filename)) {
			return dirname(__FILE__) . '/data/' . $filename;
		} else {
			return $filename;
		}
	}
}

$sbImport = new SbImport();
