<?php
// Testimonial Premium - Shortcode Options Parsing
// Auto-extracted for modularity

if (!defined('ABSPATH'))
	exit;

if (isset($post_id['cat'])) {
	$category_ids = explode(",", $post_id['cat']);	// convert string into array
} else {
	$category_ids = 0;
}
// js and css
wp_enqueue_script('jquery');
wp_enqueue_style('tml-bootstrap-css');
wp_enqueue_style('tml-font-awesome-css');

// owl carousel js and css
wp_enqueue_style('tml-owl-carousel-css');
wp_enqueue_style('tml-owl-theme-css');
wp_enqueue_style('tml-owl-animate-css');

//owl settings
if (isset($post_id['id']) && !empty($post_id['id']) && $post_id['id'] !== 'global') {
	$testimonial_settings = get_post_meta($post_id['id'], 'testimonial_settings', true);
} else {
	$testimonial_settings = get_option('testimonial_settings');
}
$GLOBALS['tml_active_settings'] = $testimonial_settings;

if (isset($post_id['template'])) {
	$testimonial_carousel_design = $post_id['template'];	// template set by shortcode
} else {
	if (isset($testimonial_settings['testimonial_carousel_design']))
		$testimonial_carousel_design = $testimonial_settings['testimonial_carousel_design'];
	else
		$testimonial_carousel_design = 1;
}

// Remap legacy templates to Theme One for backward compatibility
$testimonial_carousel_design = intval($testimonial_carousel_design);
if ($testimonial_carousel_design < 1 || $testimonial_carousel_design > 3) {
	$testimonial_carousel_design = 1;
}

if (isset($post_id['effectout'])) {
	$tml_animateOut_effect = $post_id['effectout'];
} else {
	if (isset($testimonial_settings['tml_animateOut_effect']))
		$tml_animateOut_effect = $testimonial_settings['tml_animateOut_effect'];
	else
		$tml_animateOut_effect = 'slideOutDown';
}

if (isset($post_id['effectin'])) {
	$tml_animateIn_effect = $post_id['effectin'];
} else {
	if (isset($testimonial_settings['tml_animateIn_effect']))
		$tml_animateIn_effect = $testimonial_settings['tml_animateIn_effect'];
	else
		$tml_animateIn_effect = 'flipInX';
}

if (isset($testimonial_settings['auto_play_carousel']))
	$auto_play_carousel = $testimonial_settings['auto_play_carousel'];
else
	$auto_play_carousel = "true";

if (isset($post_id['delay'])) {
	$tml_slide_speed = $post_id['delay'];	// transition speed set by shortcode
} else {
	if (isset($testimonial_settings['tml_slide_speed']))
		$tml_slide_speed = $testimonial_settings['tml_slide_speed'];
	else
		$tml_slide_speed = '3000';
}

if (isset($testimonial_settings['tml_layout_preset']))
	$tml_layout = $testimonial_settings['tml_layout_preset'];
else
	$tml_layout = 'slider';

if (!in_array($tml_layout, array('slider', 'grid'))) {
	$tml_layout = 'slider';
}
$tml_random_order = 'false';
if (isset($testimonial_settings['tml_filter_category']))
	$tml_filter_category_id = $testimonial_settings['tml_filter_category'];
else
	$tml_filter_category_id = '';


if (isset($testimonial_settings['tml_col_ld']))
	$tml_col_ld = $testimonial_settings['tml_col_ld'];
else
	$tml_col_ld = '3';
if (isset($testimonial_settings['tml_col_d']))
	$tml_col_d = $testimonial_settings['tml_col_d'];
else
	$tml_col_d = '3';
if (isset($testimonial_settings['tml_col_l']))
	$tml_col_l = $testimonial_settings['tml_col_l'];
else
	$tml_col_l = '2';
if (isset($testimonial_settings['tml_col_t']))
	$tml_col_t = $testimonial_settings['tml_col_t'];
else
	$tml_col_t = '1';
if (isset($testimonial_settings['tml_col_m']))
	$tml_col_m = $testimonial_settings['tml_col_m'];
else
	$tml_col_m = '1';
if (isset($testimonial_settings['tml_gap']))
	$tml_gap = $testimonial_settings['tml_gap'];
else
	$tml_gap = '20';
if (isset($testimonial_settings['tml_vgap']))
	$tml_vgap = $testimonial_settings['tml_vgap'];
else
	$tml_vgap = '20';

if (isset($testimonial_settings['tml_testimonial_loop']))
	$tml_testimonial_loop = $testimonial_settings['tml_testimonial_loop'];
else
	$tml_testimonial_loop = 'true';
if (isset($testimonial_settings['tml_timeout_speed']))
	$tml_timeout_speed = $testimonial_settings['tml_timeout_speed'];
else
	$tml_timeout_speed = '3000';
if (isset($testimonial_settings['tml_show_star_rating']))
	$tml_show_star_rating = $testimonial_settings['tml_show_star_rating'];
else
	$tml_show_star_rating = 'true';
if (isset($testimonial_settings['tml_star_rating_color']))
	$tml_star_rating_color = $testimonial_settings['tml_star_rating_color'];
else
	$tml_star_rating_color = '#FFD700';
if (isset($testimonial_settings['tml_star_rating_alignment']))
	$tml_star_rating_alignment = $testimonial_settings['tml_star_rating_alignment'];
else
	$tml_star_rating_alignment = 'center';
if (isset($testimonial_settings['tml_image_shape']))
	$tml_image_shape = $testimonial_settings['tml_image_shape'];
else
	$tml_image_shape = 'circle';
if (isset($testimonial_settings['tml_hover_pause']))
	$tml_hover_pause = $testimonial_settings['tml_hover_pause'];
else
	$tml_hover_pause = 'true';
if (isset($testimonial_settings['tml_nav']))
	$tml_nav = $testimonial_settings['tml_nav'];
else
	$tml_nav = 'false';
if (isset($testimonial_settings['tml_pagination']))
	$tml_pagination = $testimonial_settings['tml_pagination'];
else
	$tml_pagination = 'false';
if (isset($testimonial_settings['tml_post_order']))
	$tml_post_order = $testimonial_settings['tml_post_order'];
else
	$tml_post_order = 'DESC';
if (isset($testimonial_settings['tml_order_by']))
	$tml_order_by = $testimonial_settings['tml_order_by'];
else
	$tml_order_by = 'date';
if (isset($testimonial_settings['tml_auto_hight']))
	$tml_auto_hight = $testimonial_settings['tml_auto_hight'];
else
	$tml_auto_hight = 'false';
if (isset($testimonial_settings['tml_rtl']))
	$tml_rtl = $testimonial_settings['tml_rtl'];
else
	$tml_rtl = 'false';

if (isset($testimonial_settings['tml_ds_section_title']))
	$tml_ds_section_title = $testimonial_settings['tml_ds_section_title'];
else
	$tml_ds_section_title = 'hide';
if (isset($testimonial_settings['tml_ds_section_title_text']))
	$tml_ds_section_title_text = $testimonial_settings['tml_ds_section_title_text'];
else
	$tml_ds_section_title_text = 'Testimonials';
$tml_ds_schema = 'disabled';
if (isset($testimonial_settings['tml_ds_preloader']))
	$tml_ds_preloader = $testimonial_settings['tml_ds_preloader'];
else
	$tml_ds_preloader = 'disabled';
if (isset($testimonial_settings['tml_ds_field_order']))
	$tml_ds_field_order = $testimonial_settings['tml_ds_field_order'];
else
	$tml_ds_field_order = 'image,content,rating,author,social';
if (isset($testimonial_settings['tml_ds_avg_rating']))
	$tml_ds_avg_rating = $testimonial_settings['tml_ds_avg_rating'];
else
	$tml_ds_avg_rating = 'hide';
if (isset($testimonial_settings['tml_ds_ajax_search']))
	$tml_ds_ajax_search = $testimonial_settings['tml_ds_ajax_search'];
else
	$tml_ds_ajax_search = 'disabled';

if (isset($testimonial_settings['tml_ds_ajax_search_width']))
	$tml_ds_ajax_search_width = $testimonial_settings['tml_ds_ajax_search_width'];
else
	$tml_ds_ajax_search_width = 'container';

if (isset($testimonial_settings['tml_ds_ajax_search_shape']))
	$tml_ds_ajax_search_shape = $testimonial_settings['tml_ds_ajax_search_shape'];
else
	$tml_ds_ajax_search_shape = 'round';


if (isset($testimonial_settings['tml_ds_card_shadow']))
	$tml_ds_card_shadow = $testimonial_settings['tml_ds_card_shadow'];
else
	$tml_ds_card_shadow = 'show';

if (isset($testimonial_settings['tml_autoplay_mobile']))
	$tml_autoplay_mobile = $testimonial_settings['tml_autoplay_mobile'];
else
	$tml_autoplay_mobile = 'true';

$tml_nav_position = 'vertical_outer';
if (isset($testimonial_settings['tml_nav_mobile_hide']))
	$tml_nav_mobile_hide = $testimonial_settings['tml_nav_mobile_hide'];
else
	$tml_nav_mobile_hide = 'false';
if (isset($testimonial_settings['tml_nav_color']))
	$tml_nav_color = $testimonial_settings['tml_nav_color'];
else
	$tml_nav_color = '#666666';
if (isset($testimonial_settings['tml_nav_bg_color']))
	$tml_nav_bg_color = $testimonial_settings['tml_nav_bg_color'];
else
	$tml_nav_bg_color = 'transparent';
if (isset($testimonial_settings['tml_nav_size']))
	$tml_nav_size = $testimonial_settings['tml_nav_size'];
else
	$tml_nav_size = '35';
if (isset($testimonial_settings['tml_nav_arrow_style']))
	$tml_nav_arrow_style = $testimonial_settings['tml_nav_arrow_style'];
else
	$tml_nav_arrow_style = 'chevron';
if (isset($testimonial_settings['tml_pagination_mobile_hide']))
	$tml_pagination_mobile_hide = $testimonial_settings['tml_pagination_mobile_hide'];
else
	$tml_pagination_mobile_hide = 'false';
$tml_pagination_style = 'bullets';
if (isset($testimonial_settings['tml_mouse_draggable']))
	$tml_mouse_draggable = $testimonial_settings['tml_mouse_draggable'];
else
	$tml_mouse_draggable = 'true';
$tml_pagi_enabled = 'false';
$tml_pagi_type = 'load_more';
$tml_per_page = 6;
$tml_pagi_align = 'center';




if (isset($testimonial_settings['tml_ds_content_show']))
	$tml_ds_content_show = $testimonial_settings['tml_ds_content_show'];
else
	$tml_ds_content_show = 'show';
if (isset($testimonial_settings['tml_ds_content_type']))
	$tml_ds_content_type = $testimonial_settings['tml_ds_content_type'];
else
	$tml_ds_content_type = 'full';
if (isset($testimonial_settings['tml_ds_content_length']))
	$tml_ds_content_length = $testimonial_settings['tml_ds_content_length'];
else
	$tml_ds_content_length = '50';
if (isset($testimonial_settings['tml_ds_content_length_type']))
	$tml_ds_content_length_type = $testimonial_settings['tml_ds_content_length_type'];
else
	$tml_ds_content_length_type = 'words';
$tml_ds_read_more = 'show';
$tml_ds_rm_action = 'expand';

if (isset($testimonial_settings['tml_ds_image_size'])) {
	$tml_ds_image_size = $testimonial_settings['tml_ds_image_size'];
} else {
	$tml_ds_image_size = '80';
}

// Dynamically adjust WordPress image source size based on visual pixel size to avoid blurriness
$tml_ds_image_size_num = intval($tml_ds_image_size);
if ($tml_ds_image_size_num > 300) {
	$tml_ds_image_dim = 'large';
} elseif ($tml_ds_image_size_num > 150) {
	$tml_ds_image_dim = 'medium';
} else {
	$tml_ds_image_dim = 'thumbnail';
}

if (isset($testimonial_settings['tml_ds_image_shape']))
	$tml_ds_image_shape = $testimonial_settings['tml_ds_image_shape'];
else
	$tml_ds_image_shape = 'circle';

if (isset($testimonial_settings['tml_ds_name_show']))
	$tml_ds_name_show = $testimonial_settings['tml_ds_name_show'];
else
	$tml_ds_name_show = 'show';
$tml_ds_name_tag = 'h4';
if (isset($testimonial_settings['tml_ds_designation_show']))
	$tml_ds_designation_show = $testimonial_settings['tml_ds_designation_show'];
else
	$tml_ds_designation_show = 'show';
if (isset($testimonial_settings['tml_ds_website_show']))
	$tml_ds_website_show = $testimonial_settings['tml_ds_website_show'];
else
	$tml_ds_website_show = 'show';


// Advanced Typography Extraction & CSS Generation
$typography_prefixes = array(
	'tml_typo_title',
	'tml_typo_content',
	'tml_typo_designation',
	'tml_typo_website',
	'tml_typo_isotope'
);

$typo_styles = array();
foreach ($typography_prefixes as $prefix) {
	$load = isset($testimonial_settings[$prefix . '_load']) ? $testimonial_settings[$prefix . '_load'] : 'off';
	if ($load == 'on') {
		$style = "";
		$font = isset($testimonial_settings[$prefix . '_font']) ? $testimonial_settings[$prefix . '_font'] : 'inherit';
		$align = isset($testimonial_settings[$prefix . '_align']) ? $testimonial_settings[$prefix . '_align'] : 'inherit';
		$transform = isset($testimonial_settings[$prefix . '_transform']) ? $testimonial_settings[$prefix . '_transform'] : 'none';
		$size = isset($testimonial_settings[$prefix . '_size']) ? $testimonial_settings[$prefix . '_size'] : '';
		$lh = isset($testimonial_settings[$prefix . '_line_height']) ? $testimonial_settings[$prefix . '_line_height'] : '';
		$ls = isset($testimonial_settings[$prefix . '_spacing']) ? $testimonial_settings[$prefix . '_spacing'] : '0';
		$weight = isset($testimonial_settings[$prefix . '_weight']) ? $testimonial_settings[$prefix . '_weight'] : 'inherit';
		$mt = isset($testimonial_settings[$prefix . '_m_t']) ? $testimonial_settings[$prefix . '_m_t'] : '0';
		$mb = isset($testimonial_settings[$prefix . '_m_b']) ? $testimonial_settings[$prefix . '_m_b'] : '0';
		$ml = isset($testimonial_settings[$prefix . '_m_l']) ? $testimonial_settings[$prefix . '_m_l'] : '0';
		$mr = isset($testimonial_settings[$prefix . '_m_r']) ? $testimonial_settings[$prefix . '_m_r'] : '0';
		$color_key = $prefix . '_color';
		if ($prefix == 'tml_typo_title')
			$color_key = 'tml_title_color';
		if ($prefix == 'tml_typo_content')
			$color_key = 'tml_description_color';
		if ($prefix == 'tml_typo_designation')
			$color_key = 'tml_designation_color';

		$color = isset($testimonial_settings[$color_key]) && $testimonial_settings[$color_key] !== '' ? $testimonial_settings[$color_key] : '#000000';

		if ($font != 'inherit')
			$style .= "font-family: $font !important;";
		if ($align != 'inherit')
			$style .= "text-align: $align !important;";
		if ($transform != 'none')
			$style .= "text-transform: $transform !important;";
		if ($size != '')
			$style .= "font-size: {$size}px !important;";
		if ($lh != '')
			$style .= "line-height: {$lh}px !important;";
		if ($ls != '0' && $ls != '')
			$style .= "letter-spacing: {$ls}px !important;";
		if ($weight != 'inherit')
			$style .= "font-weight: $weight !important;";
		if ($mt != '0' && $mt != '')
			$style .= "margin-top: {$mt}px !important;";
		if ($mb != '0' && $mb != '')
			$style .= "margin-bottom: {$mb}px !important;";
		if ($ml != '0' && $ml != '')
			$style .= "margin-left: {$ml}px !important;";
		if ($mr != '0' && $mr != '')
			$style .= "margin-right: {$mr}px !important;";
		if ($color != '')
			$style .= "color: $color !important;";

		$typo_styles[$prefix] = $style;
	} else {
		$typo_styles[$prefix] = "";
	}
}

if (isset($testimonial_settings['tml_ds_image_show']))
	$tml_ds_image_show = $testimonial_settings['tml_ds_image_show'];
else
	$tml_ds_image_show = 'show';
if (isset($testimonial_settings['tml_ds_image_fallback']))
	$tml_ds_image_fallback = $testimonial_settings['tml_ds_image_fallback'];
else
	$tml_ds_image_fallback = 'mystery';
if (isset($testimonial_settings['tml_mouse_control']))
	$tml_mouse_control = $testimonial_settings['tml_mouse_control'];
else
	$tml_mouse_control = 'false';
$tml_rsp_slide = 'false';
$tml_url_hash_slide = 'false';
if (isset($testimonial_settings['tml_limit']))
	$tml_limit = $testimonial_settings['tml_limit'];
else
	$tml_limit = '10';

$tml_category_order = '';
$tml_selected_categories = array();
$tml_rating_order = '5,4,3,2,1';
$tml_selected_ratings = array();



$tml_rating_style = 'star';
if (isset($testimonial_settings['tml_ds_rating_default_color']))
	$tml_ds_rating_default_color = $testimonial_settings['tml_ds_rating_default_color'];
else
	$tml_ds_rating_default_color = '#E0E0E0';
if (isset($testimonial_settings['tml_ds_rating_size']))
	$tml_ds_rating_size = $testimonial_settings['tml_ds_rating_size'];
else
	$tml_ds_rating_size = '19';
if (isset($testimonial_settings['tml_ds_rating_gap']))
	$tml_ds_rating_gap = $testimonial_settings['tml_ds_rating_gap'];
else
	$tml_ds_rating_gap = '2';
if (isset($testimonial_settings['tml_ds_rating_pos']))
	$tml_ds_rating_pos = $testimonial_settings['tml_ds_rating_pos'];
else
	$tml_ds_rating_pos = 'below_name';
$tml_ds_video_icon = 'hide';
$tml_video_playback = 'external';
$tml_ds_video_icon_size = '32';
$tml_ds_video_icon_color = '#ffffff';
$tml_ds_video_icon_hover_color = '#ffffff';
$tml_ds_video_icon_bg = 'rgba(0, 0, 0, 0.4)';

$rating_args = array(
	'style' => $tml_rating_style,
	'color' => $tml_star_rating_color,
	'default_color' => $tml_ds_rating_default_color,
	'size' => $tml_ds_rating_size,
	'gap' => $tml_ds_rating_gap,
	'alignment' => $tml_star_rating_alignment
);


if (isset($post_id['background'])) {
	$tml_background_color = $post_id['background'];	// Background Color set by shortcode
} else {
	if (isset($testimonial_settings['tml_background_color']) && !empty($testimonial_settings['tml_background_color']) && $testimonial_settings['tml_background_color'] !== '#6c6c6c')
		$tml_background_color = $testimonial_settings['tml_background_color'];
	else
		$tml_background_color = "#ffffff";
}



if (isset($post_id['nfc'])) {
	$tml_title_color = $post_id['nfc'];	// name text color set by shortcode
} else {
	if (isset($testimonial_settings['tml_title_color']))
		$tml_title_color = $testimonial_settings['tml_title_color'];
	else
		$tml_title_color = "#000000";
}

if (isset($post_id['tfc'])) {
	$tml_description_color = $post_id['tfc'];	// testimonial text color set by shortcode
} else {
	if (isset($testimonial_settings['tml_description_color']))
		$tml_description_color = $testimonial_settings['tml_description_color'];
	else
		$tml_description_color = "#000000";
}

if (isset($post_id['dfc'])) {
	$tml_designation_color = $post_id['dfc'];	// designation text color set by shortcode
} else {
	if (isset($testimonial_settings['tml_designation_color']))
		$tml_designation_color = $testimonial_settings['tml_designation_color'];
	else
		$tml_designation_color = "#000000";
}



if (isset($post_id['layout'])) {
	$tml_layout = $post_id['layout'];
}

if (isset($post_id['limit'])) {
	$tml_limit = intval($post_id['limit']);
} else {
	// Fallback to global limit from settings
	$tml_limit = isset($testimonial_settings['tml_limit']) ? intval($testimonial_settings['tml_limit']) : -1;
}

// Limit should only work for slider and carousel layouts
if (!in_array($tml_layout, array('slider', 'carousel'))) {
	$tml_limit = -1;
}

// Ajax Pagination Override: Use tml_per_page if pagination is enabled, layout is not slider/carousel, and limit is not set via shortcode
if (!in_array($tml_layout, array('slider', 'carousel')) && $tml_pagi_enabled == 'true' && $tml_pagi_type != 'normal' && empty($post_id['limit'])) {
	$tml_limit = $tml_per_page;
}

if (isset($post_id['is_ajax_request'])) {
	$is_ajax_request = $post_id['is_ajax_request'];
} else {
	$is_ajax_request = 'false';
}

if (isset($post_id['text_limit'])) {
	$tml_text_limit = intval($post_id['text_limit']);
} else {
	$tml_text_limit = 0;
}

$tml_rating_filter = 'false';

$tml_progress_bar = 'false';
$tml_social_share = 'false';