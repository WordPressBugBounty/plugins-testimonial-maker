<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
/**
@package Testimonial Maker
 * Plugin Name:       Testimonial Maker
 * Plugin URI:        https://awplife.com/wordpress-plugins/testimonial-wordpress-plugin/
 * Description:       A very easy Plugin for make testimonials.
 * Version:           1.2.8
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Author:            A WP Life
 * Author URI:        https://profiles.wordpress.org/awordpresslife
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       testimonial-maker
 * Domain Path:       /languages
 * License:           GPL2

Testimonial Maker is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Testimonial Maker is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Testimonial Maker. If not, see https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html.
*/
if (!class_exists('tml_or_testimonial')) {
	class tml_or_testimonial
	{

		public function __construct()
		{
			$this->_constants();
			$this->_hooks();
		}

		protected function _constants()
		{
			// Version Type (PRO/FREE toggle)
			define('TML_IS_PRO', false);

			//Plugin Version
			define('TML_PLUGIN_VER', '1.2.8');

			//Plugin Text Domain
			define('TML_TXTDM', 'testimonial-maker');

			//Plugin Name
			define('TML_PLUGIN_NAME', 'Testimonial Maker');

			//Plugin Slug
			define('TML_PLUGIN_SLUG', 'testimonial-maker');

			//Plugin Directory Path
			define('TML_PLUGIN_DIR', plugin_dir_path(__FILE__));

			//Plugin Directory URL
			define('TML_PLUGIN_URL', plugin_dir_url(__FILE__));

			define('TML_SECURE_KEY', md5(NONCE_KEY));

		} // end of constructor function

		protected function _hooks()
		{
			//Load text domain
			//add_action('plugins_loaded', array($this, 'load_textdomain'));

			//add testimonial menu item, change menu filter for multisite
			add_action('admin_menu', array($this, 'tmonial_menu'), 101);

			// Register Admin Scripts
			add_action('admin_enqueue_scripts', array($this, 'tml_admin_enqueue_scripts'));

			//Create testimonial Filter testimonial Custom Post
			add_action('init', array($this, 'Testimonial'));
			add_action('init', array($this, 'tml_run_v2_migration'));
			add_action('init', array($this, 'tml_auto_create_default_shortcode'));

			//Add meta box to custom post
			add_action('add_meta_boxes', array($this, 'admin_add_meta_box'));

			//loaded during admin init 
			add_action('admin_init', array($this, 'admin_add_meta_box'));

			add_action('save_post', array(&$this, '_tml_save_settings'));
			add_action('save_post', array(&$this, 'tml_save_shortcode_meta'));
			add_action('save_post', array(&$this, 'tml_save_form_meta'));

			//Shortcode Compatibility in Text Widgets
			add_action('widget_text', 'do_shortcode');

			// Gutenberg Block Assets
			add_action('enqueue_block_editor_assets', array($this, 'tml_gutenberg_block_assets'));
			add_action('init', array($this, 'tml_register_gutenberg_blocks'));
			add_filter('block_categories_all', array($this, 'tml_block_category'), 10, 2);

			// Register Scripts
			add_action('wp_enqueue_scripts', array($this, 'awplife_tml_register_scripts'));



			// AJAX Live Preview Handler
			add_action('wp_ajax_tml_save_preview_settings', array($this, 'ajax_save_preview_settings'));

			// AJAX Reset to Defaults Handler
			add_action('wp_ajax_tml_reset_shortcode_settings', array($this, 'ajax_reset_shortcode_settings'));

			// Allow data: protocol for SVG inline avatars in esc_url()
			add_filter('kses_allowed_protocols', array($this, 'tml_allow_data_protocol'));

			// Custom columns for Shortcodes post list
			add_filter('manage_tml-shortcode_posts_columns', array($this, 'tml_shortcode_posts_columns'));
			add_action('manage_tml-shortcode_posts_custom_column', array($this, 'tml_shortcode_posts_custom_column'), 10, 2);

			// Duplicate shortcode action and row actions
			add_action('admin_action_tml_duplicate_shortcode', array($this, 'tml_duplicate_shortcode_handler'));
			add_filter('post_row_actions', array($this, 'tml_shortcode_row_actions'), 10, 2);
			add_filter('page_row_actions', array($this, 'tml_shortcode_row_actions'), 10, 2);
			add_action('admin_notices', array($this, 'tml_duplicate_admin_notice'));
		} // end of hook function

		public function load_textdomain()
		{
			// phpcs:ignore PluginCheck.CodeAnalysis.DiscouragedFunctions.load_plugin_textdomainFound
			load_plugin_textdomain(TML_TXTDM, false, dirname(plugin_basename(__FILE__)) . '/languages');
		}

		public function tmonial_menu()
		{
			add_submenu_page('edit.php?post_type=' . TML_PLUGIN_SLUG, __('Import/Export', 'testimonial-maker'), __('Import/Export', 'testimonial-maker'), 'administrator', 'tml-import-export', array($this, '_tml_import_export_page'));
			add_submenu_page('edit.php?post_type=' . TML_PLUGIN_SLUG, __('Analytics', 'testimonial-maker'), __('Analytics', 'testimonial-maker'), 'administrator', 'tml-analytics', array($this, '_tml_analytics_page'));
			add_submenu_page('edit.php?post_type=' . TML_PLUGIN_SLUG, __('Docs', 'testimonial-maker'), __('Docs', 'testimonial-maker'), 'administrator', 'tml-docs', array($this, '_tml_docs_page'));
			add_submenu_page('edit.php?post_type=' . TML_PLUGIN_SLUG, __('Free Plugins', 'testimonial-maker'), __('Free Plugins', 'testimonial-maker'), 'administrator', 'tml-free-plugins', array($this, '_tml_free_plugins_page'));
			add_submenu_page('edit.php?post_type=' . TML_PLUGIN_SLUG, __('Free Themes', 'testimonial-maker'), __('Free Themes', 'testimonial-maker'), 'administrator', 'tml-free-themes', array($this, '_tml_free_themes_page'));
		}

		public function _tml_import_export_page()
		{
			require_once(TML_PLUGIN_DIR . 'include/import-export.php');
		}

		public function _tml_analytics_page()
		{
			require_once(TML_PLUGIN_DIR . 'include/analytics.php');
		}

		public function Testimonial()
		{
			// register testimonial custom post type
			$cpt_name = __('Testimonial Maker', 'testimonial-maker');
			$labels = array(
				'name' => $cpt_name,
				'singular_name' => $cpt_name,
				'menu_name' => $cpt_name,
				'name_admin_bar' => $cpt_name,
				'add_new' => __('Add New Testimonial', 'testimonial-maker'),
				'add_new_item' => __('Add New Testimonial', 'testimonial-maker'),
				'new_item' => __('New Testimonial', 'testimonial-maker'),
				'edit_item' => __('Edit Testimonial', 'testimonial-maker'),
				'view_item' => __('View Testimonial', 'testimonial-maker'),
				'all_items' => __('All Testimonial', 'testimonial-maker'),
				'search_items' => __('Search Testimonial', 'testimonial-maker'),
				'parent_item_colon' => __('Parent Testimonial:', 'testimonial-maker'),
				'not_found' => __('No Testimonial found', 'testimonial-maker'),
				'not_found_in_trash' => __('No Testimonial found in Trash', 'testimonial-maker')
			);

			$args = array(
				'labels' => __('Testimonial', 'testimonial-maker'),
				'description' => __('Description', 'testimonial-maker'),
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'query_var' => true,
				'rewrite' => array('slug' => false),
				'capability_type' => 'page',
				'has_archive' => true,
				'hierarchical' => false,
				'menu_icon' => 'dashicons-format-status',
				'menu_position' => null,
				'supports' => array('title', 'editor', 'thumbnail', ),
				'taxonomies' => array('testimonial-categories'),
			);

			register_post_type('testimonial-maker', $args);

			// register custom taxonomy for testimonial custom post type
			$labels = array(
				'name' => __('Categories', 'testimonial-maker'),
				'singular_name' => __('Category', 'testimonial-maker'),
				'search_items' => __('Search Categories', 'testimonial-maker'),
				'all_items' => __('All Categories', 'testimonial-maker'),
				'parent_item' => __('Parent Categories', 'testimonial-maker'),
				'parent_item_colon' => __('Parent Categories:', 'testimonial-maker'),
				'edit_item' => __('Edit Categories', 'testimonial-maker'),
				'update_item' => __('Update Categories', 'testimonial-maker'),
				'add_new_item' => __('Add New Categories', 'testimonial-maker'),
				'new_item_name' => __('New Category Name', 'testimonial-maker'),
				'menu_name' => __('Categories', 'testimonial-maker'),
			);

			$args = array(
				'hierarchical' => true,
				'labels' => $labels,
				'show_ui' => true,
				'show_admin_column' => true,
				'query_var' => true,
				'rewrite' => array('slug' => 'testimonial-categories'),
			);

			register_taxonomy('testimonial-categories', array('testimonial-maker'), $args);

			// Register Shortcode Generator CPT
			$shortcode_labels = array(
				'name' => __('Shortcode Generator', 'testimonial-maker'),
				'singular_name' => __('Shortcode', 'testimonial-maker'),
				'menu_name' => __('Shortcodes', 'testimonial-maker'),
				'name_admin_bar' => __('Shortcode', 'testimonial-maker'),
				'add_new' => __('Add New', 'testimonial-maker'),
				'add_new_item' => __('Add New Shortcode', 'testimonial-maker'),
				'new_item' => __('New Shortcode', 'testimonial-maker'),
				'edit_item' => __('Edit Shortcode', 'testimonial-maker'),
				'view_item' => __('View Shortcode', 'testimonial-maker'),
				'all_items' => __('Shortcodes', 'testimonial-maker'),
				'search_items' => __('Search Shortcodes', 'testimonial-maker'),
				'not_found' => __('No shortcodes found.', 'testimonial-maker'),
				'not_found_in_trash' => __('No shortcodes found in Trash.', 'testimonial-maker')
			);

			$shortcode_args = array(
				'labels' => $shortcode_labels,
				'public' => false,
				'show_ui' => true,
				'show_in_menu' => 'edit.php?post_type=' . TML_PLUGIN_SLUG,
				'capability_type' => 'post',
				'hierarchical' => false,
				'supports' => array('title'),
			);
			register_post_type('tml-shortcode', $shortcode_args);

			// Register Form Builder CPT
			$form_labels = array(
				'name' => __('Form Builder', 'testimonial-maker'),
				'singular_name' => __('Form', 'testimonial-maker'),
				'menu_name' => __('Form Builder', 'testimonial-maker'),
				'name_admin_bar' => __('Form', 'testimonial-maker'),
				'add_new' => __('Add New Form', 'testimonial-maker'),
				'add_new_item' => __('Add New Form', 'testimonial-maker'),
				'new_item' => __('New Form', 'testimonial-maker'),
				'edit_item' => __('Edit Form', 'testimonial-maker'),
				'view_item' => __('View Form', 'testimonial-maker'),
				'all_items' => __('Form Builder', 'testimonial-maker'),
				'search_items' => __('Search Forms', 'testimonial-maker'),
				'not_found' => __('No forms found.', 'testimonial-maker'),
				'not_found_in_trash' => __('No forms found in Trash.', 'testimonial-maker')
			);

			$form_args = array(
				'labels' => $form_labels,
				'public' => false,
				'show_ui' => true,
				'show_in_menu' => 'edit.php?post_type=' . TML_PLUGIN_SLUG,
				'capability_type' => 'post',
				'hierarchical' => false,
				'supports' => array('title'),
			);
			register_post_type('tml-form', $form_args);
		}
		public function admin_add_meta_box()
		{
			add_meta_box('', __('Add Client Detail', 'testimonial-maker'), array(&$this, 'tml_testimonial_upload'), 'testimonial-maker', 'normal', 'default');
			add_meta_box('tml_shortcode_settings_box', __('Testimonial Settings', 'testimonial-maker'), array(&$this, 'tml_shortcode_settings_cb'), 'tml-shortcode', 'normal', 'high');
			add_meta_box('tml_shortcode_display_box', __('Shortcode', 'testimonial-maker'), array(&$this, 'tml_shortcode_display_cb'), 'tml-shortcode', 'side', 'high');
			// For Form Builder
			add_meta_box('tml_form_builder_box', __('Form Configuration', 'testimonial-maker'), array(&$this, 'tml_form_builder_cb'), 'tml-form', 'normal', 'high');
		}

		public function tml_form_builder_cb($post)
		{
			wp_nonce_field('tml_save_form_settings', 'tml_form_nonce');
			require_once('include/form-builder.php');
		}
		public function tml_testimonial_upload($post)
		{
			require_once(TML_PLUGIN_DIR . 'include/metabox-testimonial.php');
		}

		public function _tml_save_settings($post_id)
		{
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
				return;
			if (!current_user_can('edit_post', $post_id))
				return;

			$nonce = isset($_POST['tml_save_nonce']) ? sanitize_text_field(wp_unslash($_POST['tml_save_nonce'])) : '';
			if (!empty($nonce)) {
				if (!wp_verify_nonce($nonce, 'tml_save_settings')) {
					print 'Sorry, your nonce did not verify.';
					exit;
				} else {
					$website_link = isset($_POST['website_link']) ? esc_url_raw(wp_unslash($_POST['website_link'])) : '';
					$designation = isset($_POST['designation']) ? sanitize_text_field(wp_unslash($_POST['designation'])) : '';
					$star_rating = isset($_POST['star_rating']) ? sanitize_text_field(wp_unslash($_POST['star_rating'])) : '5';

					$testimonial_post_settings = array(
						'website_link' => $website_link,
						'designation' => $designation,
						'star_rating' => $star_rating,
					);
					$awl_testimonial_shortcode_setting = "awl_testimonial" . $post_id;
					update_post_meta($post_id, $awl_testimonial_shortcode_setting, $testimonial_post_settings);
				}
			}// end save setting
		}
		public function tml_shortcode_settings_cb($post)
		{
			wp_nonce_field('tml_save_shortcode_settings', 'tml_shortcode_nonce');
			require_once('include/testimonial-setting.php');
		}

		public function tml_shortcode_display_cb($post)
		{
			$shortcode = '[TML id="' . $post->ID . '"]';
			?>
			<div class="tml-shortcode-side-box" style="text-align: center;">
				<p style="color:#666; margin-top:0; margin-bottom:10px;">
					<?php esc_html_e('Copy and paste this shortcode into any Page, Post, or Widget.', 'testimonial-maker'); ?>
				</p>
				<input type="text" value="<?php echo esc_attr($shortcode); ?>" readonly onclick="this.select();"
					style="width: 100%; text-align: center; font-size: 14px; padding: 10px; font-weight: bold; background: #f0f0f1; border-color: #8c8f94; box-shadow: inset 0 1px 2px rgba(0,0,0,.07);">
			</div>
			<?php
		}



		public function tml_save_shortcode_meta($post_id)
		{
			require_once(TML_PLUGIN_DIR . 'include/save-shortcode-meta.php');
		}

		public function tml_save_form_meta($post_id)
		{
			require_once(TML_PLUGIN_DIR . 'include/save-form-meta.php');
		}

		public function _tml_testimonial_settings()
		{
			require_once('include/testimonial-setting.php');
		}

		public function _tml_free_plugins_page()
		{
			require_once(TML_PLUGIN_DIR . 'our-plugins.php');
		}

		public function _tml_free_themes_page()
		{
			require_once(TML_PLUGIN_DIR . 'our-themes.php');
		}

		public function _tml_docs_page()
		{
			require_once(TML_PLUGIN_DIR . 'include/docs.php');
		}

		public function tml_admin_enqueue_scripts($hook)
		{
			if (isset($_GET['page']) && ($_GET['page'] === 'tml-free-plugins' || $_GET['page'] === 'tml-free-themes')) {
				wp_enqueue_style('tml-our-plugins-style', TML_PLUGIN_URL . 'assets/css/our-plugins-style.css', array(), TML_PLUGIN_VER);
				add_thickbox();
			}
		}
		public function tml_gutenberg_block_assets()
		{
			wp_enqueue_script(
				'tml-gutenberg-block',
				TML_PLUGIN_URL . 'assets/js/tml-gutenberg-blocks.js',
				array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data'),
				TML_PLUGIN_VER,
				true
			);

			// Fetch shortcodes
			$shortcodes = get_posts(array(
				'post_type' => 'tml-shortcode',
				'posts_per_page' => -1,
				'post_status' => 'any'
			));
			$shortcode_options = array();
			foreach ($shortcodes as $s) {
				$shortcode_options[] = array(
					'label' => $s->post_title . ' (ID: ' . $s->ID . ')',
					'value' => (string) $s->ID,
				);
			}

			wp_localize_script('tml-gutenberg-block', 'tmlBlockData', array(
				'shortcodes' => $shortcode_options,
			));
		}

		public function tml_register_gutenberg_blocks()
		{
			if (!function_exists('register_block_type')) {
				return;
			}

			register_block_type('tml-shortcode/block', array(
				'render_callback' => array($this, 'tml_render_shortcode_block'),
			));
		}

		public function tml_render_shortcode_block($attributes)
		{
			if (empty($attributes['shortcodeId'])) {
				return '<p style="border:1px dashed #2271b1; padding:15px; text-align:center; color:#2271b1;">' . __('Please select a Testimonial Shortcode in block settings.', 'testimonial-maker') . '</p>';
			}
			return do_shortcode('[TML id="' . esc_attr($attributes['shortcodeId']) . '"]');
		}

		public function tml_block_category($categories, $post)
		{
			return array_merge(
				array(
					array(
						'slug' => 'testimonial-maker',
						'title' => __('Testimonial Maker', 'testimonial-maker'),
						'icon' => 'format-status',
					),
				),
				$categories
			);
		}


		public function awplife_tml_register_scripts()
		{
			wp_enqueue_script('jquery');
			wp_enqueue_style('tml-bootstrap-css', TML_PLUGIN_URL . 'assets/css/tml-frontend-bootstrap.css', array(), TML_PLUGIN_VER);
			wp_enqueue_style('tml-font-awesome-css', TML_PLUGIN_URL . 'assets/css/font-awesome.min.css', array(), TML_PLUGIN_VER);

			wp_enqueue_style('tml-owl-carousel-css', TML_PLUGIN_URL . 'assets/css/owl.carousel.css', array(), TML_PLUGIN_VER);
			wp_enqueue_style('tml-owl-theme-css', TML_PLUGIN_URL . 'assets/css/owl.theme.default.css', array(), TML_PLUGIN_VER);
			wp_enqueue_style('tml-owl-animate-css', TML_PLUGIN_URL . 'assets/css/animate.css', array(), TML_PLUGIN_VER);
		}




		public function ajax_save_preview_settings()
		{
			if (!current_user_can('edit_posts')) {
				wp_send_json_error(array('message' => 'Unauthorized user.'));
			}

			// Verify nonce
			$nonce = isset($_POST['tml_shortcode_nonce']) ? sanitize_text_field(wp_unslash($_POST['tml_shortcode_nonce'])) : '';
			if (empty($nonce) || !wp_verify_nonce($nonce, 'tml_save_shortcode_settings')) {
				wp_send_json_error(array('message' => 'Security check failed.'));
			}

			$post_data = wp_unslash($_POST);

			$post_id = isset($post_data['post_ID']) ? intval($post_data['post_ID']) : 0;
			if (!$post_id) {
				wp_send_json_error(array('message' => 'Invalid shortcode ID.'));
			}

			// Verify the post is a tml-shortcode CPT
			$post = get_post($post_id);
			if (!$post || $post->post_type !== 'tml-shortcode') {
				wp_send_json_error(array('message' => 'Invalid post type.'));
			}

			// Start with current saved settings as base (so unlisted fields don't go missing)
			$testimonial_settings = get_post_meta($post_id, 'testimonial_settings', true);
			if (!is_array($testimonial_settings)) {
				$testimonial_settings = array();
			}

			// Override with current form $_POST values — NO SAVE TO DATABASE
			$text_fields = array(
				'tml_active_tab',
				'tml_active_vtab',
				'tml_active_stab',
				'tml_active_subtab',
				'tml_layout_preset',
				'testimonial_carousel_design',
				'tml_animateOut_effect',
				'tml_animateIn_effect',
				'tml_testimonial_loop',
				'auto_play_carousel',
				'tml_slide_speed',
				'tml_timeout_speed',
				'tml_hover_pause',
				'tml_nav',
				'tml_pagination',
				'tml_pagination_mobile_hide',
				'tml_auto_hight',
				'tml_post_order',
				'tml_rtl',
				'tml_mouse_control',
				'tml_nav_mobile_hide',
				'tml_autoplay_mobile',
				'tml_show_star_rating',
				'tml_image_shape',
				'tml_mouse_draggable',
				'tml_limit',
				'tml_order_by',
				'tml_random_order',
				'tml_filter_category',
				'tml_col_ld',
				'tml_col_d',
				'tml_col_l',
				'tml_col_t',
				'tml_col_m',
				'tml_gap',
				'tml_vgap',
				'tml_ds_section_title',
				'tml_ds_preloader',
				'tml_ds_card_shadow',
				'tml_ds_field_order',
				'tml_ds_content_show',
				'tml_ds_content_type',
				'tml_ds_content_length',
				'tml_ds_content_length_type',
				'tml_ds_rating_default_color',
				'tml_ds_rating_pos',
				'tml_ds_name_show',
				'tml_ds_designation_show',
				'tml_ds_website_show',
				'tml_ds_rating_size',
				'tml_ds_rating_gap',
				'tml_ds_image_show',
				'tml_ds_image_dim',
				'tml_ds_image_shape',
				'tml_ds_image_size',
				'tml_ds_image_fallback',
				'tml_ds_avg_rating',
				'tml_ds_ajax_search',
				'tml_ds_ajax_search_width',
				'tml_ds_ajax_search_shape',
				'tml_nav_color',
				'tml_nav_bg_color',
				'tml_nav_size',
				'tml_nav_arrow_style',
				'tml_title_color',
				'tml_description_color',
				'tml_designation_color',
				'tml_background_color',
				'tml_ds_section_title_text',
				'tml_star_rating_color',
				'tml_star_rating_alignment',
			);

			foreach ($text_fields as $field) {
				if (isset($post_data[$field])) {
					$testimonial_settings[$field] = sanitize_text_field($post_data[$field]);
				}
			}

			// Handle array fields
			if (isset($post_data['tml_selected_categories'])) {
				$testimonial_settings['tml_selected_categories'] = map_deep($post_data['tml_selected_categories'], 'sanitize_text_field');
			}
			if (isset($post_data['tml_selected_ratings'])) {
				$testimonial_settings['tml_selected_ratings'] = array_map('intval', (array) $post_data['tml_selected_ratings']);
			}

			// ✅ PREVIEW ONLY — Do NOT save. Temporarily inject settings via WP metadata filter.
			$preview_settings = $testimonial_settings;
			$preview_post_id = $post_id;

			$filter_fn = function ($value, $object_id, $meta_key, $single) use ($preview_settings, $preview_post_id) {
				if ((int) $object_id === (int) $preview_post_id && $meta_key === 'testimonial_settings') {
					// ALWAYS wrap in array.
					// WP does: if ($single && is_array($check)) return $check[0]
					// So $check[0] = $preview_settings (our full settings array) ✅
					return array($preview_settings);
				}
				return $value;
			};

			// Attach temporary filter — priority 99 overrides WP object cache reads too
			add_filter('get_post_metadata', $filter_fn, 99, 4);

			$paged = isset($post_data['paged']) ? intval($post_data['paged']) : 1;
			$is_ajax_request = isset($post_data['is_ajax_request']) ? sanitize_text_field($post_data['is_ajax_request']) : 'false';
			$preview_html = do_shortcode('[TML id="' . $preview_post_id . '" paged="' . $paged . '" is_ajax_request="' . esc_attr($is_ajax_request) . '"]');

			// Remove filter immediately after rendering
			remove_filter('get_post_metadata', $filter_fn, 99);

			wp_send_json_success(array('html' => $preview_html));
		}

		public function ajax_reset_shortcode_settings()
		{
			if (!current_user_can('edit_posts')) {
				wp_send_json_error(array('message' => 'Unauthorized.'));
			}

			// Verify nonce
			$nonce = isset($_POST['tml_shortcode_nonce']) ? sanitize_text_field(wp_unslash($_POST['tml_shortcode_nonce'])) : '';
			if (empty($nonce) || !wp_verify_nonce($nonce, 'tml_save_shortcode_settings')) {
				wp_send_json_error(array('message' => 'Security check failed.'));
			}

			$post_id = isset($_POST['post_ID']) ? intval(wp_unslash($_POST['post_ID'])) : 0;
			if (!$post_id) {
				wp_send_json_error(array('message' => 'Invalid post ID.'));
			}

			$post = get_post($post_id);
			if (!$post || $post->post_type !== 'tml-shortcode') {
				wp_send_json_error(array('message' => 'Invalid post type.'));
			}

			// Delete all settings — next load will use plugin defaults
			delete_post_meta($post_id, 'testimonial_settings');

			wp_send_json_success(array('message' => 'Settings have been reset to defaults.'));
		}

		public function tml_allow_data_protocol($protocols)
		{
			if (!in_array('data', $protocols)) {
				$protocols[] = 'data';
			}
			return $protocols;
		}

		public function tml_shortcode_posts_columns($columns)
		{
			$new_columns = array();
			foreach ($columns as $key => $title) {
				$new_columns[$key] = $title;
				if ($key === 'title') {
					$new_columns['tml_shortcode'] = __('Shortcode', 'testimonial-maker');
					$new_columns['tml_preset'] = __('Layout Preset', 'testimonial-maker');
				}
			}
			return $new_columns;
		}

		public function tml_shortcode_posts_custom_column($column, $post_id)
		{
			if ($column === 'tml_shortcode') {
				static $script_printed = false;
				if (!$script_printed) {
					$script_printed = true;
					?>
					<style>
						.tml-duplicate-shortcode-btn {
							display: inline-flex;
							align-items: center;
							justify-content: center;
							gap: 4px;
							height: 24px;
							padding: 0 10px;
							background: #10b981;
							border: 1px solid #10b981;
							color: #fff;
							border-radius: 4px;
							font-weight: 600;
							cursor: pointer;
							font-size: 11px;
							transition: all 0.2s ease;
							outline: none;
							box-sizing: border-box;
							text-decoration: none;
						}

						.tml-duplicate-shortcode-btn:hover {
							background: #059669;
							border-color: #059669;
							color: #fff;
							box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
						}

						.tml-copy-shortcode-btn:hover {
							opacity: 0.9;
							box-shadow: 0 2px 4px rgba(98, 0, 238, 0.3);
						}
					</style>
					<script>
						jQuery(document).ready(function ($) {
							$(document).on('click', '.tml-copy-shortcode-btn', function (e) {
								e.preventDefault();
								var $btn = $(this);
								var shortcodeText = $btn.attr('data-shortcode');

								var $temp = $("<input>");
								$("body").append($temp);
								$temp.val(shortcodeText).select();
								document.execCommand("copy");
								$temp.remove();

								var originalHtml = $btn.html();
								$btn.html('<span class="dashicons dashicons-yes" style="font-size:14px; width:14px; height:14px; margin-top:2px; color:#fff;"></span> Copied!').css({
									'background': '#2e7d32',
									'border-color': '#2e7d32',
									'box-shadow': '0 2px 4px rgba(46,125,50,0.3)'
								});
								setTimeout(function () {
									$btn.html(originalHtml).css({
										'background': '#6200ee',
										'border-color': '#6200ee',
										'box-shadow': 'none'
									});
								}, 2000);
							});
						});
					</script>
					<?php
				}
				$shortcode = '[TML id="' . $post_id . '"]';
				?>
				<div class="tml-shortcode-copy-container" style="display:inline-flex; align-items:center; gap:8px;">
					<code
						style="background:#f1f3f5; padding:4px 8px; border-radius:4px; border:1px solid #dcdfe3; font-family:Consolas, Monaco, monospace; font-size:11px; color:#1a1a1a; user-select:all; font-weight:500;">[TML id="<?php echo esc_attr($post_id); ?>"]</code>
					<button class="tml-copy-shortcode-btn" data-shortcode='[TML id="<?php echo esc_attr($post_id); ?>"]'
						style="display:inline-flex; align-items:center; justify-content:center; gap:4px; height:24px; padding:0 10px; background:#6200ee; border:1px solid #6200ee; color:#fff; border-radius:4px; font-weight:600; cursor:pointer; font-size:11px; transition:all 0.2s ease; outline:none; box-sizing:border-box;">
						<span class="dashicons dashicons-admin-page"
							style="font-size:12px; width:12px; height:12px; margin-top:2px;"></span> Copy
					</button>
					<a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?action=tml_duplicate_shortcode&post=' . $post_id), 'tml_duplicate_' . $post_id)); ?>"
						class="tml-duplicate-shortcode-btn">
						<span class="dashicons dashicons-welcome-add-page"
							style="font-size:12px; width:12px; height:12px; margin-top:2px;"></span> Duplicate
					</a>
				</div>
				<?php
			} elseif ($column === 'tml_preset') {
				$settings = get_post_meta($post_id, 'testimonial_settings', true);
				$preset = isset($settings['tml_layout_preset']) ? $settings['tml_layout_preset'] : 'slider';
				$preset_titles = array(
					'slider' => 'Slider',
					'carousel' => 'Carousel',
					'grid' => 'Grid',
					'masonry' => 'Masonry',
					'isotope' => 'Isotope',
					'list' => 'List'
				);
				$title = isset($preset_titles[$preset]) ? $preset_titles[$preset] : 'Slider';

				$bg_color = '#e8f0fe';
				$color = '#1a73e8';
				if ($preset === 'grid') {
					$bg_color = '#e6f4ea';
					$color = '#137333';
				} elseif ($preset === 'masonry') {
					$bg_color = '#fef7e0';
					$color = '#b06000';
				} elseif ($preset === 'isotope') {
					$bg_color = '#f3e8fd';
					$color = '#7c25e9';
				} elseif ($preset === 'list') {
					$bg_color = '#fce8e6';
					$color = '#c5221f';
				} elseif ($preset === 'carousel') {
					$bg_color = '#f3e8fd';
					$color = '#9334e6';
				}
				?>
				<span class="tml-preset-badge"
					style="display:inline-flex; align-items:center; background:<?php echo esc_attr($bg_color); ?>; color:<?php echo esc_attr($color); ?>; font-weight:600; font-size:11px; padding:3px 10px; border-radius:12px; text-transform:capitalize; border:1px solid rgba(0,0,0,0.04);">
					<?php echo esc_html($title); ?>
				</span>
				<?php
			}
		}

		public function tml_shortcode_row_actions($actions, $post)
		{
			if ($post->post_type === 'tml-shortcode') {
				$actions['duplicate'] = '<a href="' . esc_url(wp_nonce_url(admin_url('admin.php?action=tml_duplicate_shortcode&post=' . $post->ID), 'tml_duplicate_' . $post->ID)) . '" title="' . esc_attr__('Duplicate this shortcode', 'testimonial-maker') . '">' . __('Duplicate', 'testimonial-maker') . '</a>';
			}
			return $actions;
		}

		public function tml_duplicate_shortcode_handler()
		{
			if (!current_user_can('edit_posts')) {
				wp_die(esc_html__('You do not have permission to duplicate this shortcode.', 'testimonial-maker'));
			}

			$post_id = isset($_GET['post']) ? intval($_GET['post']) : 0;
			if (!$post_id) {
				wp_die(esc_html__('No shortcode ID was provided.', 'testimonial-maker'));
			}

			// Verify nonce
			$nonce = isset($_GET['_wpnonce']) ? sanitize_text_field(wp_unslash($_GET['_wpnonce'])) : '';
			if (!wp_verify_nonce($nonce, 'tml_duplicate_' . $post_id)) {
				wp_die(esc_html__('Security check failed.', 'testimonial-maker'));
			}

			$post = get_post($post_id);
			if (!$post || $post->post_type !== 'tml-shortcode') {
				wp_die(esc_html__('Invalid shortcode CPT.', 'testimonial-maker'));
			}

			// Create duplicate post
			$new_post = array(
				'post_title' => $post->post_title . ' (Duplicate)',
				'post_status' => 'draft',
				'post_type' => 'tml-shortcode',
			);

			$new_post_id = wp_insert_post($new_post);

			if (!is_wp_error($new_post_id)) {
				// Copy all post meta
				$meta_keys = get_post_custom_keys($post_id);
				if (!empty($meta_keys)) {
					foreach ($meta_keys as $key) {
						if (in_array($key, array('_edit_lock', '_edit_last'))) {
							continue;
						}
						$values = get_post_meta($post_id, $key);
						foreach ($values as $value) {
							add_post_meta($new_post_id, $key, $value);
						}
					}
				}

				// Redirect back to list
				wp_safe_redirect(admin_url('edit.php?post_type=tml-shortcode&tml_duplicated=1'));
				exit;
			} else {
				wp_die(esc_html__('Failed to create duplicate shortcode.', 'testimonial-maker'));
			}
		}

		public function tml_duplicate_admin_notice()
		{
			global $pagenow;
			// phpcs:disable WordPress.Security.NonceVerification.Recommended
			if ($pagenow === 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] === 'tml-shortcode' && isset($_GET['tml_duplicated'])) {
				?>
				<div class="notice notice-success is-dismissible">
					<p><?php esc_html_e('Shortcode duplicated successfully.', 'testimonial-maker'); ?></p>
				</div>
				<?php
			}
			// phpcs:enable WordPress.Security.NonceVerification.Recommended
		}

		public function tml_run_v2_migration()
		{
			if (get_option('tml_premium_migrated_to_v2') !== 'yes') {
				// 1. Migrate Global Settings
				$global_settings = get_option('testimonial_settings');
				if (is_array($global_settings)) {
					$global_settings['testimonial_carousel_design'] = 1;
					update_option('testimonial_settings', $global_settings);
				}

				// 2. Migrate Showcase Settings (Custom Post Meta)
				$showcases = get_posts(array(
					'post_type' => 'testimonial-maker',
					'posts_per_page' => -1,
					'post_status' => 'any',
					'fields' => 'ids',
				));
				if (!empty($showcases)) {
					foreach ($showcases as $showcase_id) {
						$settings = get_post_meta($showcase_id, 'testimonial_settings', true);
						if (is_array($settings)) {
							$settings['testimonial_carousel_design'] = 1;
							update_post_meta($showcase_id, 'testimonial_settings', $settings);
						}
					}
				}

				// 3. Mark migration as completed
				update_option('tml_premium_migrated_to_v2', 'yes');
			}
		}

		public function tml_auto_create_default_shortcode()
		{
			$default_id = get_option('tml_default_shortcode_id');
			if (empty($default_id) || !get_post($default_id)) {
				$default_id = wp_insert_post(array(
					'post_title' => 'Default Shortcode',
					'post_status' => 'publish',
					'post_type' => 'tml-shortcode',
				));
				if (!is_wp_error($default_id)) {
					update_option('tml_default_shortcode_id', $default_id);
					$default_settings = get_option('testimonial_settings');
					if (is_array($default_settings)) {
						update_post_meta($default_id, 'testimonial_settings', $default_settings);
					}
				}
			}
		}
	}

	$new_testimonial_object = new tml_or_testimonial();
	require_once('shortcode.php');
	require_once('include/frontend-form.php');
	require_once('include/user-dashboard.php');
}
?>