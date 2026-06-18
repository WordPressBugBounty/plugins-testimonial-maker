<?php
/**
 * Save Shortcode Settings Metadata Handler
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
	return;
}
if (!isset($_POST['post_type']) || 'tml-shortcode' != $_POST['post_type']) {
	return;
}
if (!current_user_can('edit_post', $post_id)) {
	return;
}

// Verify nonce
$nonce = isset($_POST['tml_shortcode_nonce']) ? sanitize_text_field(wp_unslash($_POST['tml_shortcode_nonce'])) : '';
if (empty($nonce) || !wp_verify_nonce($nonce, 'tml_save_shortcode_settings')) {
	return;
}

$post_data = wp_unslash($_POST);

$layout_preset = isset($post_data['tml_layout_preset']) ? sanitize_text_field($post_data['tml_layout_preset']) : 'slider';
$carousel_design = isset($post_data['testimonial_carousel_design']) ? sanitize_text_field($post_data['testimonial_carousel_design']) : 1;

if (!in_array($layout_preset, array('slider', 'grid'))) {
	$layout_preset = 'slider';
}
$carousel_design = intval($carousel_design);
if ($carousel_design < 1 || $carousel_design > 3) {
	$carousel_design = 1;
}

$testimonial_settings = array(
	'tml_active_tab' => isset($post_data['tml_active_tab']) ? sanitize_text_field($post_data['tml_active_tab']) : '#tml-tab-general',
	'tml_active_vtab' => isset($post_data['tml_active_vtab']) ? sanitize_text_field($post_data['tml_active_vtab']) : 'basic',
	'tml_active_stab' => isset($post_data['tml_active_stab']) ? sanitize_text_field($post_data['tml_active_stab']) : 'basics',
	'tml_active_subtab' => isset($post_data['tml_active_subtab']) ? sanitize_text_field($post_data['tml_active_subtab']) : '',
	'tml_layout_preset' => $layout_preset,
	'testimonial_carousel_design' => $carousel_design,
	'tml_animateOut_effect' => isset($post_data['tml_animateOut_effect']) ? sanitize_text_field($post_data['tml_animateOut_effect']) : '',
	'tml_animateIn_effect' => isset($post_data['tml_animateIn_effect']) ? sanitize_text_field($post_data['tml_animateIn_effect']) : '',
	'tml_testimonial_loop' => isset($post_data['tml_testimonial_loop']) ? sanitize_text_field($post_data['tml_testimonial_loop']) : '',
	'auto_play_carousel' => isset($post_data['auto_play_carousel']) ? sanitize_text_field($post_data['auto_play_carousel']) : '',
	'tml_slide_speed' => isset($post_data['tml_slide_speed']) ? sanitize_text_field($post_data['tml_slide_speed']) : '',
	'tml_timeout_speed' => isset($post_data['tml_timeout_speed']) ? sanitize_text_field($post_data['tml_timeout_speed']) : '',
	'tml_hover_pause' => isset($post_data['tml_hover_pause']) ? sanitize_text_field($post_data['tml_hover_pause']) : '',
	'tml_nav' => isset($post_data['tml_nav']) ? sanitize_text_field($post_data['tml_nav']) : '',
	'tml_pagination' => isset($post_data['tml_pagination']) ? sanitize_text_field($post_data['tml_pagination']) : '',
	'tml_pagination_mobile_hide' => isset($post_data['tml_pagination_mobile_hide']) ? sanitize_text_field($post_data['tml_pagination_mobile_hide']) : 'false',
	'tml_auto_hight' => isset($post_data['tml_auto_hight']) ? sanitize_text_field($post_data['tml_auto_hight']) : '',
	'tml_post_order' => isset($post_data['tml_post_order']) ? sanitize_text_field($post_data['tml_post_order']) : 'DESC',
	'tml_order_by' => isset($post_data['tml_order_by']) ? sanitize_text_field($post_data['tml_order_by']) : 'date',
	'tml_rtl' => isset($post_data['tml_rtl']) ? sanitize_text_field($post_data['tml_rtl']) : '',
	'tml_mouse_control' => isset($post_data['tml_mouse_control']) ? sanitize_text_field($post_data['tml_mouse_control']) : '',
	'tml_nav_mobile_hide' => isset($post_data['tml_nav_mobile_hide']) ? sanitize_text_field($post_data['tml_nav_mobile_hide']) : 'false',
	'tml_nav_color' => isset($post_data['tml_nav_color']) ? sanitize_hex_color($post_data['tml_nav_color']) : '#666666',
	'tml_nav_bg_color' => isset($post_data['tml_nav_bg_color']) ? sanitize_text_field($post_data['tml_nav_bg_color']) : 'transparent',
	'tml_nav_size' => isset($post_data['tml_nav_size']) ? sanitize_text_field($post_data['tml_nav_size']) : '35',
	'tml_nav_arrow_style' => isset($post_data['tml_nav_arrow_style']) ? sanitize_text_field($post_data['tml_nav_arrow_style']) : 'chevron',
	'tml_autoplay_mobile' => isset($post_data['tml_autoplay_mobile']) ? sanitize_text_field($post_data['tml_autoplay_mobile']) : 'true',
	'tml_title_color' => isset($post_data['tml_title_color']) ? sanitize_hex_color($post_data['tml_title_color']) : '',
	'tml_description_color' => isset($post_data['tml_description_color']) ? sanitize_hex_color($post_data['tml_description_color']) : '',
	'tml_designation_color' => isset($post_data['tml_designation_color']) ? sanitize_hex_color($post_data['tml_designation_color']) : '',
	'tml_background_color' => isset($post_data['tml_background_color']) ? sanitize_hex_color($post_data['tml_background_color']) : '',
	'tml_show_star_rating' => isset($post_data['tml_show_star_rating']) ? sanitize_text_field($post_data['tml_show_star_rating']) : 'true',
	'tml_star_rating_alignment' => isset($post_data['tml_star_rating_alignment']) ? sanitize_text_field($post_data['tml_star_rating_alignment']) : 'center',
	'tml_star_rating_color' => isset($post_data['tml_star_rating_color']) ? sanitize_hex_color($post_data['tml_star_rating_color']) : '#FFD700',
	'tml_image_shape' => isset($post_data['tml_image_shape']) ? sanitize_text_field($post_data['tml_image_shape']) : 'circle',
	'tml_mouse_draggable' => isset($post_data['tml_mouse_draggable']) ? sanitize_text_field($post_data['tml_mouse_draggable']) : 'true',

	// Layout & Grid fields
	'tml_limit' => isset($post_data['tml_limit']) ? sanitize_text_field($post_data['tml_limit']) : '10',
	'tml_random_order' => isset($post_data['tml_random_order']) ? sanitize_text_field($post_data['tml_random_order']) : 'false',
	'tml_filter_category' => isset($post_data['tml_filter_category']) ? sanitize_text_field($post_data['tml_filter_category']) : '',
	'tml_col_ld' => isset($post_data['tml_col_ld']) ? sanitize_text_field($post_data['tml_col_ld']) : '3',
	'tml_col_d' => isset($post_data['tml_col_d']) ? sanitize_text_field($post_data['tml_col_d']) : '3',
	'tml_col_l' => isset($post_data['tml_col_l']) ? sanitize_text_field($post_data['tml_col_l']) : '2',
	'tml_col_t' => isset($post_data['tml_col_t']) ? sanitize_text_field($post_data['tml_col_t']) : '1',
	'tml_col_m' => isset($post_data['tml_col_m']) ? sanitize_text_field($post_data['tml_col_m']) : '1',
	'tml_gap' => isset($post_data['tml_gap']) ? sanitize_text_field($post_data['tml_gap']) : '20',
	'tml_vgap' => isset($post_data['tml_vgap']) ? sanitize_text_field($post_data['tml_vgap']) : '20',

	// Display Settings fields
	'tml_ds_section_title' => isset($post_data['tml_ds_section_title']) ? sanitize_text_field($post_data['tml_ds_section_title']) : 'hide',
	'tml_ds_section_title_text' => isset($post_data['tml_ds_section_title_text']) ? sanitize_text_field($post_data['tml_ds_section_title_text']) : 'Testimonials',
	'tml_ds_preloader' => isset($post_data['tml_ds_preloader']) ? sanitize_text_field($post_data['tml_ds_preloader']) : 'disabled',
	'tml_ds_avg_rating' => isset($post_data['tml_ds_avg_rating']) ? sanitize_text_field($post_data['tml_ds_avg_rating']) : 'hide',
	'tml_ds_ajax_search' => isset($post_data['tml_ds_ajax_search']) ? sanitize_text_field($post_data['tml_ds_ajax_search']) : 'disabled',
	'tml_ds_ajax_search_width' => isset($post_data['tml_ds_ajax_search_width']) ? sanitize_text_field($post_data['tml_ds_ajax_search_width']) : 'container',
	'tml_ds_ajax_search_shape' => isset($post_data['tml_ds_ajax_search_shape']) ? sanitize_text_field($post_data['tml_ds_ajax_search_shape']) : 'round',
	'tml_ds_card_shadow' => isset($post_data['tml_ds_card_shadow']) ? sanitize_text_field($post_data['tml_ds_card_shadow']) : 'show',
	'tml_ds_field_order' => isset($post_data['tml_ds_field_order']) ? sanitize_text_field($post_data['tml_ds_field_order']) : 'image,content,rating,author,social',


	'tml_ds_content_show' => isset($post_data['tml_ds_content_show']) ? sanitize_text_field($post_data['tml_ds_content_show']) : 'show',
	'tml_ds_content_type' => isset($post_data['tml_ds_content_type']) ? sanitize_text_field($post_data['tml_ds_content_type']) : 'full',
	'tml_ds_content_length' => isset($post_data['tml_ds_content_length']) ? sanitize_text_field($post_data['tml_ds_content_length']) : '50',
	'tml_ds_content_length_type' => isset($post_data['tml_ds_content_length_type']) ? sanitize_text_field($post_data['tml_ds_content_length_type']) : 'words',
	'tml_ds_rating_default_color' => isset($post_data['tml_ds_rating_default_color']) ? sanitize_text_field($post_data['tml_ds_rating_default_color']) : '#E0E0E0',
	'tml_ds_rating_pos' => isset($post_data['tml_ds_rating_pos']) ? sanitize_text_field($post_data['tml_ds_rating_pos']) : 'below_name',

	'tml_ds_name_show' => isset($post_data['tml_ds_name_show']) ? sanitize_text_field($post_data['tml_ds_name_show']) : 'show',
	'tml_ds_designation_show' => isset($post_data['tml_ds_designation_show']) ? sanitize_text_field($post_data['tml_ds_designation_show']) : 'show',
	'tml_ds_website_show' => isset($post_data['tml_ds_website_show']) ? sanitize_text_field($post_data['tml_ds_website_show']) : 'show',

	'tml_ds_rating_size' => isset($post_data['tml_ds_rating_size']) ? sanitize_text_field($post_data['tml_ds_rating_size']) : '19',
	'tml_ds_rating_gap' => isset($post_data['tml_ds_rating_gap']) ? sanitize_text_field($post_data['tml_ds_rating_gap']) : '2',

	'tml_ds_image_show' => isset($post_data['tml_ds_image_show']) ? sanitize_text_field($post_data['tml_ds_image_show']) : 'show',

	'tml_ds_image_dim' => isset($post_data['tml_ds_image_dim']) ? sanitize_text_field($post_data['tml_ds_image_dim']) : '120x120',
	'tml_ds_image_shape' => isset($post_data['tml_ds_image_shape']) ? sanitize_text_field($post_data['tml_ds_image_shape']) : 'circle',
	'tml_ds_image_size' => isset($post_data['tml_ds_image_size']) ? sanitize_text_field($post_data['tml_ds_image_size']) : '80',


	'tml_ds_image_fallback' => isset($post_data['tml_ds_image_fallback']) ? sanitize_text_field($post_data['tml_ds_image_fallback']) : 'mystery',
);

update_post_meta($post_id, 'testimonial_settings', $testimonial_settings);
