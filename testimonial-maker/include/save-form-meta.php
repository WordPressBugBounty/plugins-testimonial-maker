<?php
/**
 * Save Form Builder Settings Metadata Handler
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
	return;
}
if (!isset($_POST['post_type']) || 'tml-form' != $_POST['post_type']) {
	return;
}
if (!current_user_can('edit_post', $post_id)) {
	return;
}

// Verify nonce
$nonce = isset($_POST['tml_form_nonce']) ? sanitize_text_field(wp_unslash($_POST['tml_form_nonce'])) : '';
if (empty($nonce) || !wp_verify_nonce($nonce, 'tml_save_form_settings')) {
	return;
}

$post_data = wp_unslash($_POST);

// Save active fields
if (isset($post_data['tml_form_active_fields']) && is_array($post_data['tml_form_active_fields'])) {
	$active_fields = map_deep($post_data['tml_form_active_fields'], 'sanitize_text_field');
	// Filter out PRO fields
	$active_fields = array_values(array_diff($active_fields, array('video', 'social', 'recaptcha')));
	update_post_meta($post_id, 'tml_form_active_fields', $active_fields);
} else {
	update_post_meta($post_id, 'tml_form_active_fields', array());
}

// Save form fields data
if (isset($post_data['tml_form_fields']) && is_array($post_data['tml_form_fields'])) {
	$form_fields = map_deep($post_data['tml_form_fields'], 'sanitize_text_field');
	// Remove PRO fields
	unset($form_fields['video'], $form_fields['social'], $form_fields['recaptcha']);
	update_post_meta($post_id, 'tml_form_fields', $form_fields);
}

// Save form settings
if (isset($post_data['tml_form_settings']) && is_array($post_data['tml_form_settings'])) {
	$form_settings = map_deep($post_data['tml_form_settings'], 'sanitize_text_field');
	
	// Enforce style_one layout (style_two is PRO)
	$form_settings['form_layout'] = 'style_one';
	
	// Remove PRO background image and recaptcha settings
	unset(
		$form_settings['recaptcha_site_key'],
		$form_settings['recaptcha_secret_key'],
		$form_settings['enable_bg_image'],
		$form_settings['form_bg_image'],
		$form_settings['bg_image_position'],
		$form_settings['bg_image_width']
	);

	// Hex sanitization for colors
	foreach ( array('label_color', 'input_bg', 'form_bg', 'btn_bg_color', 'btn_text_color') as $color_key ) {
		if ( isset( $form_settings[$color_key] ) ) {
			$form_settings[$color_key] = sanitize_hex_color( $form_settings[$color_key] );
		}
	}
	update_post_meta($post_id, 'tml_form_settings', $form_settings);
}
