<?php
if (!defined('ABSPATH'))
	exit;

// Star rating display function
if (!function_exists('tml_display_star_rating')) {
	function tml_display_star_rating($rating, $show_rating, $settings = array())
	{
		if ($show_rating == 'false')
			return '';
		$rating = intval($rating);
		if ($rating < 0)
			$rating = 0;
		if ($rating > 5)
			$rating = 5;

		$style = isset($settings['style']) ? $settings['style'] : (isset($GLOBALS['tml_active_settings']['tml_rating_style']) ? $GLOBALS['tml_active_settings']['tml_rating_style'] : 'star');
		$color = isset($settings['color']) ? $settings['color'] : (isset($GLOBALS['tml_active_settings']['tml_star_rating_color']) ? $GLOBALS['tml_active_settings']['tml_star_rating_color'] : '#FFD700');
		$default_color = isset($settings['default_color']) ? $settings['default_color'] : (isset($GLOBALS['tml_active_settings']['tml_ds_rating_default_color']) ? $GLOBALS['tml_active_settings']['tml_ds_rating_default_color'] : '#E0E0E0');
		$size = isset($settings['size']) ? $settings['size'] : (isset($GLOBALS['tml_active_settings']['tml_ds_rating_size']) ? $GLOBALS['tml_active_settings']['tml_ds_rating_size'] : '19');
		$gap = isset($settings['gap']) ? $settings['gap'] : (isset($GLOBALS['tml_active_settings']['tml_ds_rating_gap']) ? $GLOBALS['tml_active_settings']['tml_ds_rating_gap'] : '2');
		$alignment = isset($settings['alignment']) ? $settings['alignment'] : (isset($GLOBALS['tml_active_settings']['tml_star_rating_alignment']) ? $GLOBALS['tml_active_settings']['tml_star_rating_alignment'] : 'center');

		$justify = 'center';
		if ($alignment == 'left') {
			$justify = 'flex-start';
		} elseif ($alignment == 'right') {
			$justify = 'flex-end';
		}

		$icons = array(
			'star' => array('filled' => 'fa-star', 'empty' => 'fa-star-o'),
			'heart' => array('filled' => 'fa-heart', 'empty' => 'fa-heart'),
			'thumbs-up' => array('filled' => 'fa-thumbs-up', 'empty' => 'fa-thumbs-o-up'),
			'smile' => array('filled' => 'fa-smile-o', 'empty' => 'fa-smile-o'),
			'diamond' => array('filled' => 'fa-diamond', 'empty' => 'fa-diamond'),
			'badge' => array('filled' => 'fa-certificate', 'empty' => 'fa-certificate'),
			'trophy' => array('filled' => 'fa-trophy', 'empty' => 'fa-trophy'),
			'bell' => array('filled' => 'fa-bell', 'empty' => 'fa-bell-o')
		);

		$filled_icon = isset($icons[$style]) ? $icons[$style]['filled'] : 'fa-star';
		$empty_icon = isset($icons[$style]) ? $icons[$style]['empty'] : 'fa-star-o';

		$output = '<div class="testimonial-rating" style="display:flex !important; justify-content:' . esc_attr($justify) . ' !important; gap:' . esc_attr($gap) . 'px; margin-bottom:10px; width:100% !important;">';
		for ($i = 1; $i <= 5; $i++) {
			$icon_class = ($i <= $rating) ? $filled_icon : $empty_icon;
			$icon_color = ($i <= $rating) ? $color : $default_color;
			$opacity = ($i > $rating && $style == $filled_icon) ? '0.3' : '1'; // Fallback for icons without outline version

			$output .= '<i class="fa ' . esc_attr($icon_class) . '" style="color:' . esc_attr($icon_color) . '; font-size:' . esc_attr($size) . 'px; opacity:' . $opacity . ';"></i>';
		}
		$output .= '</div>';
		return $output;
	}
}

// Social profiles display function
if (!function_exists('tml_display_social_profiles')) {
	function tml_display_social_profiles($testimonial_post_settings, $settings = array())
	{
		if (empty($settings)) {
			$settings = isset($GLOBALS['tml_active_settings']) ? $GLOBALS['tml_active_settings'] : array();
		}

		$tml_social_share = isset($settings['tml_social_share']) ? $settings['tml_social_share'] : 'false';
		if ($tml_social_share == 'false') {
			return '';
		}

		$social_profiles = isset($testimonial_post_settings['social_profiles']) ? $testimonial_post_settings['social_profiles'] : array();
		if (empty($social_profiles)) {
			return '';
		}

		$tml_social_margin_top = isset($settings['tml_social_margin_top']) ? $settings['tml_social_margin_top'] : '10';
		$tml_social_margin_right = isset($settings['tml_social_margin_right']) ? $settings['tml_social_margin_right'] : '0';
		$tml_social_margin_bottom = isset($settings['tml_social_margin_bottom']) ? $settings['tml_social_margin_bottom'] : '10';
		$tml_social_margin_left = isset($settings['tml_social_margin_left']) ? $settings['tml_social_margin_left'] : '0';

		$tml_social_border_width = isset($settings['tml_social_border_width']) ? $settings['tml_social_border_width'] : '1';
		$tml_social_border_style = isset($settings['tml_social_border_style']) ? $settings['tml_social_border_style'] : 'solid';
		$tml_social_border_color = isset($settings['tml_social_border_color']) ? $settings['tml_social_border_color'] : '#e2e8f0';

		$tml_social_icon_type = isset($settings['tml_social_icon_type']) ? $settings['tml_social_icon_type'] : 'original';
		$tml_social_icon_bg = isset($settings['tml_social_icon_bg']) ? $settings['tml_social_icon_bg'] : '#f0f6fc';
		$tml_social_icon_color = isset($settings['tml_social_icon_color']) ? $settings['tml_social_icon_color'] : '#888888';

		static $brand_colors_printed = false;
		$styles = '';
		if (!$brand_colors_printed) {
			$tml_social_icon_hover_bg = isset($settings['tml_social_icon_hover_bg']) ? $settings['tml_social_icon_hover_bg'] : '#f0f6fc';
			$tml_social_icon_hover_color = isset($settings['tml_social_icon_hover_color']) ? $settings['tml_social_icon_hover_color'] : '#000000';
			$tml_social_border_hover_color = isset($settings['tml_social_border_hover_color']) ? $settings['tml_social_border_hover_color'] : '#e2e8f0';

			$styles = '<style>
				/* Brand Colors - Background and Border */
				.tml-social-original.tml-social-facebook {
					background: #1877f2 !important;
					border-color: #1877f2 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-twitter {
					background: #1da1f2 !important;
					border-color: #1da1f2 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-linkedin {
					background: #0a66c2 !important;
					border-color: #0a66c2 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-instagram {
					background: #e4405f !important;
					border-color: #e4405f !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-youtube {
					background: #ff0000 !important;
					border-color: #ff0000 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-pinterest {
					background: #bd081c !important;
					border-color: #bd081c !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-whatsapp {
					background: #25d366 !important;
					border-color: #25d366 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-github {
					background: #181717 !important;
					border-color: #181717 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-skype {
					background: #00aff0 !important;
					border-color: #00aff0 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-vimeo {
					background: #1ab7ea !important;
					border-color: #1ab7ea !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-snapchat {
					background: #fffc00 !important;
					border-color: #fffc00 !important;
					color: #000 !important;
				}
				.tml-social-original.tml-social-slack {
					background: #4a154b !important;
					border-color: #4a154b !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-dribbble {
					background: #ea4c89 !important;
					border-color: #ea4c89 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-dropbox {
					background: #0061ff !important;
					border-color: #0061ff !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-wordpress {
					background: #21759b !important;
					border-color: #21759b !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-slideshare {
					background: #0077b5 !important;
					border-color: #0077b5 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-vk {
					background: #4c75a1 !important;
					border-color: #4c75a1 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-tumblr {
					background: #35465c !important;
					border-color: #35465c !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-yahoo {
					background: #410093 !important;
					border-color: #410093 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-stumbleupon {
					background: #eb4924 !important;
					border-color: #eb4924 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-reddit {
					background: #ff4500 !important;
					border-color: #ff4500 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-quora {
					background: #a82400 !important;
					border-color: #a82400 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-yelp {
					background: #af0606 !important;
					border-color: #af0606 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-weibo {
					background: #e6162d !important;
					border-color: #e6162d !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-product-hunt {
					background: #da552f !important;
					border-color: #da552f !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-hacker-news {
					background: #ff6600 !important;
					border-color: #ff6600 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-soundcloud {
					background: #ff3300 !important;
					border-color: #ff3300 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-medium {
					background: #000 !important;
					border-color: #000 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-vine {
					background: #00b488 !important;
					border-color: #00b488 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-flickr {
					background: #ff0084 !important;
					border-color: #ff0084 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-foursquare {
					background: #f94877 !important;
					border-color: #f94877 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-behance {
					background: #1769ff !important;
					border-color: #1769ff !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-bitbucket {
					background: #0052cc !important;
					border-color: #0052cc !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-stack-overflow {
					background: #f48024 !important;
					border-color: #f48024 !important;
					color: #fff !important;
				}
				.tml-social-original.tml-social-codepen {
					background: #000 !important;
					border-color: #000 !important;
					color: #fff !important;
				}
				.tml-social-profiles .tml-social-icon:hover {
					background: ' . esc_attr($tml_social_icon_hover_bg) . ' !important;
					color: ' . esc_attr($tml_social_icon_hover_color) . ' !important;
					border-color: ' . esc_attr($tml_social_border_hover_color) . ' !important;
					transform: translateY(-3px);
				}
			</style>';
			$brand_colors_printed = true;
		}

		$output = $styles . '<div class="tml-social-profiles" style="margin: ' . esc_attr($tml_social_margin_top) . 'px ' . esc_attr($tml_social_margin_right) . 'px ' . esc_attr($tml_social_margin_bottom) . 'px ' . esc_attr($tml_social_margin_left) . 'px; display:flex; gap:10px; justify-content:center; flex-wrap:wrap;">';

		foreach ($social_profiles as $profile) {
			if (!empty($profile['url'])) {
				$network = $profile['network'];
				if (!in_array($network, array('facebook', 'twitter'))) {
					continue;
				}
				$icon = "fa-" . $network;
				if ($network == 'facebook')
					$icon = 'fa-facebook-f';
				if ($network == 'linkedin')
					$icon = 'fa-linkedin-in';
				if ($network == 'twitter')
					$icon = 'fa-twitter';

				$social_class = "tml-social-icon tml-social-{$network}";
				$social_style = "width:32px; height:32px; display:flex; align-items:center; justify-content:center; border-radius:50%; text-decoration:none; transition:all 0.3s ease; border:{$tml_social_border_width}px {$tml_social_border_style} {$tml_social_border_color}; margin: 0 5px;";

				if ($tml_social_icon_type == 'custom') {
					$social_style .= "background:{$tml_social_icon_bg}; color:{$tml_social_icon_color};";
				} else {
					$social_class .= " tml-social-original";
				}

				$output .= '<a href="' . esc_url($profile['url']) . '" target="_blank" class="' . esc_attr($social_class) . '" style="' . esc_attr($social_style) . '">';
				$output .= '<i class="fa ' . esc_attr($icon) . '"></i>';
				$output .= '</a>';
			}
		}

		$output .= '</div>';
		return $output;
	}
}

add_shortcode('TML', 'tml_testimonial_shortcode');
function tml_testimonial_shortcode($post_id)
{
	if ( ! is_array( $post_id ) ) {
		$post_id = array();
	}

	$is_global_shortcode = false;
	if ( ! isset( $post_id['id'] ) || empty( $post_id['id'] ) || $post_id['id'] === 'global' ) {
		$default_id = get_option('tml_default_shortcode_id');
		if ( ! empty( $default_id ) && get_post( $default_id ) ) {
			$post_id['id'] = $default_id;
			$is_global_shortcode = true;
		} else {
			$post_id['id'] = 'global';
			$is_global_shortcode = true;
		}
	}

	ob_start();
	$tml_unified_js = '';

	include(plugin_dir_path(__FILE__) . 'include/shortcode-options.php');

	if ($is_global_shortcode) {
		$tml_limit = -1;
		if ( ! isset( $post_id['category'] ) ) {
			$category_ids = '';
		}
		$tml_filter_category_id = '';
	}
	$template_number = 0;
	$owl_template_map = array(
		1 => 'owl-t1.php',
		2 => 'owl-t2.php',
		3 => 'owl-t3.php',
	);
	$owl_css_file = '';
	if (isset($owl_template_map[$testimonial_carousel_design])) {
		$template_number = $testimonial_carousel_design;
		$owl_css_file = plugin_dir_path(__FILE__) . 'assets/css/owl-carousal/' . $owl_template_map[$testimonial_carousel_design];
	}
	if ($owl_css_file) {
		include($owl_css_file);
	} ?>
	<?php include(plugin_dir_path(__FILE__) . 'assets/css/shortcode-styles.php'); ?>
	<?php
	// Set the orderby parameter based on the selected order option
	$orderby = (isset($tml_order_by) && $tml_order_by != '') ? $tml_order_by : 'date';
	$order = (isset($tml_post_order) && $tml_post_order != '') ? $tml_post_order : 'DESC';

	// Define the query arguments
	$paged = isset($post_id['paged']) ? intval($post_id['paged']) : 1;
	$all_testimonial = array(
		'post_type' => 'testimonial-maker',
		'post_status' => 'publish',
		'orderby' => $orderby,
		'order' => $order,
		'posts_per_page' => $tml_limit,
		'paged' => $paged
	);

	// Filter by category (from admin settings)
	if (!empty($tml_filter_category_id)) {
		// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		$all_testimonial['tax_query'] = array(
			array(
				'taxonomy' => 'testimonial-categories',
				'field' => 'term_id',
				'terms' => $tml_filter_category_id,
			),
		);
	}

	// filter by category
	if ($category_ids) {
		// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		$all_testimonial['tax_query'] = array(
			array(
				'taxonomy' => 'testimonial-categories',
				'field' => 'term_id',
				'terms' => $category_ids,
			),
		);
	}


	$testimonial_loop = new WP_Query($all_testimonial);

	$total_rating = 0;
	$rating_count = 0;
	$schema_reviews = array();

	if ($testimonial_loop->have_posts()) {

		// Pre-calculate ratings for Schema and Summary
		foreach ($testimonial_loop->posts as $p) {
			$meta = get_post_meta($p->ID, 'awl_testimonial' . $p->ID, true);
			$r = isset($meta['star_rating']) ? intval($meta['star_rating']) : 5;
			$total_rating += $r;
			$rating_count++;

			$schema_reviews[] = array(
				'@type' => 'Review',
				'author' => array(
					'@type' => 'Person',
					'name' => get_the_title($p->ID)
				),
				'reviewRating' => array(
					'@type' => 'Rating',
					'ratingValue' => $r,
					'bestRating' => '5'
				),
				'reviewBody' => wp_strip_all_tags($p->post_content)
			);
		}

		$average_rating = $rating_count > 0 ? round($total_rating / $rating_count, 1) : 5;

		if ($is_ajax_request == 'true' && $tml_pagi_type != 'number') {
			ob_clean(); // Clear everything before for AJAX request
		} else {
			// Output Schema
			if (isset($post_id['schema']) && $post_id['schema'] == 'true' && $is_ajax_request != 'true') {
				$schema_data = array(
					'@context' => 'https://schema.org',
					'@type' => 'Product',
					'name' => get_bloginfo('name') . ' Services',
					'aggregateRating' => array(
						'@type' => 'AggregateRating',
						'ratingValue' => $average_rating,
						'reviewCount' => $rating_count
					),
					'review' => $schema_reviews
				);
				echo '<script type="application/ld+json">' . wp_json_encode($schema_data) . '</script>';
			}

			// Output Summary
			if (isset($post_id['show_summary']) && $post_id['show_summary'] == 'true' && $is_ajax_request != 'true') {
				echo '<div class="tml-average-rating-summary" style="text-align:center; padding:20px; background:#f9f9f9; border-radius:8px; margin-bottom:20px;">';
				/* translators: %s: average rating value */
				echo '<h2 style="margin:0 0 10px 0;">' . esc_html(sprintf(__('Overall Rating: %s / 5', 'testimonial-maker'), $average_rating)) . '</h2>';
				echo '<div class="testimonial-rating">';
				for ($i = 1; $i <= 5; $i++) {
					if ($i <= round($average_rating)) {
						echo '<i class="fa fa-star" style="color:' . esc_attr($tml_star_rating_color) . ';"></i>';
					} else {
						echo '<i class="fa fa-star-o" style="color:#ddd;"></i>';
					}
				}
				echo '</div>';
				/* translators: %d: total reviews count */
				echo '<p style="margin:10px 0 0 0;">' . esc_html(sprintf(__('Based on %d reviews', 'testimonial-maker'), $rating_count)) . '</p>';
				echo '</div>';
			}

			?>
			<div class="tml-main-wrapper" id="tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?>"
				data-social-share="<?php echo esc_attr($tml_social_share); ?>"
				data-field-order="<?php echo esc_attr($tml_ds_field_order); ?>">

				<?php if ($tml_ds_preloader == 'enabled') { ?>
					<div class="tml-preloader">
						<div class="tml-premium-spinner"></div>
					</div>
				<?php } ?>

				<?php if ($tml_ds_section_title == 'show' && $is_ajax_request != 'true') { ?>
					<h2 class="tml-section-title" style="text-align: center; margin-bottom: 30px;">
						<?php echo esc_html($tml_ds_section_title_text); ?>
					</h2>
				<?php } ?>

				<?php if ($tml_ds_avg_rating == 'show' && $is_ajax_request != 'true') {
					$avg = ($rating_count > 0) ? round($total_rating / $rating_count, 1) : 0;
					?>
					<div class="tml-avg-rating-summary"
						style="text-align: center; margin-bottom: 30px; padding: 20px; background: #f9f9f9; border-radius: 10px; color: #333;">
						<h4 style="margin: 0 0 10px 0; color: #333;"><?php esc_html_e('Average Customer Rating', 'testimonial-maker'); ?></h4>
						<div class="testimonial-rating" style="font-size: 24px; color: #333;">
							<?php
							for ($i = 1; $i <= 5; $i++) {
								if ($i <= round($avg))
									echo '<i class="fa fa-star"></i>';
								else
									echo '<i class="fa fa-star-o"></i>';
							}
							?>
							<span style="font-size: 18px; margin-left: 10px; color: #333;">(<?php echo esc_html($avg); ?> / 5)</span>
						</div>
						<p style="margin: 10px 0 0 0; color: #666;">
							<?php
							/* translators: %d: number of reviews */
							printf(esc_html__('Based on %d reviews', 'testimonial-maker'), intval($rating_count));
							?>
						</p>
					</div>
				<?php } ?>

				<?php if ($tml_ds_ajax_search == 'enabled' && $is_ajax_request != 'true') {
					$search_max_width = ($tml_ds_ajax_search_width == 'full') ? '100%' : '600px';
					$search_margin = ($tml_ds_ajax_search_width == 'full') ? '0 0 30px 0' : '0 auto 30px auto';
					$search_radius = ($tml_ds_ajax_search_shape == 'square') ? '4px' : '25px';
					?>
					<style>
						#tml-search-input-<?php echo esc_attr($post_id['id']); ?>:focus {
							border-color: #6200ee !important;
							box-shadow: 0 0 0 4px color-mix(in srgb, #6200ee 12%, transparent) !important;
						}
					</style>
					<div class="tml-ajax-search"
						style="max-width: <?php echo esc_attr($search_max_width); ?>; margin: <?php echo esc_attr($search_margin); ?>;">
						<input type="text" id="tml-search-input-<?php echo esc_attr($post_id['id']); ?>"
							class="form-control tml-search-input"
							data-container="#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?>"
							placeholder="<?php esc_attr_e('Search testimonials...', 'testimonial-maker'); ?>"
							style="width: 100%; padding: 12px 18px; border-radius: <?php echo esc_attr($search_radius); ?>; border: 1px solid #ddd; outline: none; box-sizing: border-box; transition: all 0.3s ease;">
						<div class="tml-search-results-grid"
							style="display:none; margin-top:20px; display:flex; flex-wrap:wrap; justify-content:center; gap:20px;">
						</div>
						<div class="tml-search-no-results" style="display:none; text-align:center; padding:40px; color:#999;">
							<i class="fa fa-search" style="font-size:40px; margin-bottom:15px; opacity:0.3;"></i>
							<p><?php esc_html_e('Testimonials not found', 'testimonial-maker'); ?></p>
						</div>
					</div>
				<?php } ?>
				<?php if ($tml_layout == 'grid') { ?>
					<div class="tml-testimonial-grid" id="tml-grid-container-<?php echo esc_attr($post_id['id']); ?>">
				<?php } else { ?>
					<?php if ($tml_progress_bar == 'true') { ?>
						<div class="tml-slider-progress-wrap"
							style="width: 100%; height: 4px; background: #eee; margin-bottom: 15px; border-radius: 2px; overflow: hidden;">
							<div class="tml-slider-progress-bar"
								style="height: 100%; width: 0%; background: <?php echo esc_attr($tml_star_rating_color); ?>;">
							</div>
						</div>
					<?php } ?>
					<div id="tml-carousel-<?php echo esc_attr($post_id['id']); ?>"
						class="owl-carousel owl-theme">
				<?php } ?>
								<?php
								$all_avatar_urls = array();
								if ($testimonial_loop->have_posts()) {
									foreach ($testimonial_loop->posts as $p) {
										$thumb_id = get_post_thumbnail_id($p->ID);
										$thumb_url = "";
										if ($thumb_id) {
											$src = wp_get_attachment_image_src($thumb_id, $tml_ds_image_dim, true);
											if ($src)
												$thumb_url = $src[0];
										}
										if (empty($thumb_url)) {
											$thumb_url = TML_PLUGIN_URL . 'assets/img/person.png';
										}
										$all_avatar_urls[] = $thumb_url;
									}
								}
								$tml_t13_index = 0;
								$tml_t13_total = count($all_avatar_urls);

								while ($testimonial_loop->have_posts()):
									$testimonial_loop->the_post();
									$testimonial_post_id = get_the_ID();
									$testimonial_post_settings = get_post_meta(get_the_ID(), 'awl_testimonial' . get_the_ID(), true);
									$website_link = $testimonial_post_settings['website_link'];
									$designation = $testimonial_post_settings['designation'];
									$video_url = '';
									$star_rating = isset($testimonial_post_settings['star_rating']) ? $testimonial_post_settings['star_rating'] : '5';

									// get testimonial data
									$t_text = get_the_content();
									$t_website_url = ($tml_ds_website_show === 'show') ? $website_link : '';
									$t_designation = $designation;
									$t_video_url = ($tml_ds_video_icon === 'show') ? $video_url : '';
									$t_star_rating = intval($star_rating);
									$t_fe_image_id = get_post_thumbnail_id($testimonial_post_id); // featured image id
									$tml_fe_image_thumb = array("", 0, 0);
									$tml_default_img = TML_PLUGIN_URL . 'assets/img/person.png';

									// Integrate legacy text_limit shortcode option with dashboard settings
									$effective_limit = $tml_ds_content_length;
									$effective_type = $tml_ds_content_length_type;
									$is_limit_active = ($tml_ds_content_type == 'limit');
									$show_read_more = ($tml_ds_read_more == 'show');

									if ($tml_text_limit > 0) {
										$effective_limit = $tml_text_limit;
										$effective_type = 'chars';
										$is_limit_active = true;
										$show_read_more = true;
									}

									// Initialize display text and apply character/word limit if applicable
									$display_text = $t_text;
									if ($is_limit_active) {
										$limit = intval($effective_limit);
										if ($effective_type == 'words') {
											$display_text = wp_trim_words($t_text, $limit);
										} else {
											// Strip HTML tags first to prevent cutting in the middle of a tag (e.g. '<p>' or '<a>')
											$plain_text = wp_strip_all_tags($t_text);
											$display_text = (mb_strlen($plain_text) > $limit) ? mb_substr($plain_text, 0, $limit) . '...' : $plain_text;
										}
									}

									// Construct the final HTML block for the testimonial content
									$display_content = wp_kses_post($display_text);
									if ($is_limit_active && $show_read_more && trim($t_text) !== trim($display_text)) {
										$read_more_text = __("Read More", 'testimonial-maker');
										$read_less_text = __("Read Less", 'testimonial-maker');

										if ($tml_ds_rm_action == 'popup') {
											// Resolve image URL for popup
											$popup_image_url = $tml_default_img;
											if ($t_fe_image_id) {
												$image_size = ($testimonial_carousel_design == 10) ? 'full' : $tml_ds_image_dim;
												$src = wp_get_attachment_image_src($t_fe_image_id, $image_size, true);
												if ($src) {
													$popup_image_url = $src[0];
												}
											} else {
												if ($tml_ds_image_fallback == 'none') {
													$popup_image_url = 'none';
												} elseif ($tml_ds_image_fallback == 'avatar') {
													// Generate SVG initials avatar for popup
													$author_name = get_the_title($testimonial_post_id);
													$initials = '';
													if (!empty($author_name)) {
														$author_name = wp_strip_all_tags($author_name);
														$words = preg_split('/\s+/', trim($author_name));
														if (function_exists('mb_substr')) {
															if (count($words) >= 2) {
																$first_char = mb_substr($words[0], 0, 1, 'UTF-8');
																$second_char = mb_substr($words[1], 0, 1, 'UTF-8');
																$initials = mb_strtoupper($first_char . $second_char, 'UTF-8');
															} else {
																$initials = mb_strtoupper(mb_substr($author_name, 0, 2, 'UTF-8'), 'UTF-8');
															}
														} else {
															if (count($words) >= 2) {
																$first_char = substr($words[0], 0, 1);
																$second_char = substr($words[1], 0, 1);
																$initials = strtoupper($first_char . $second_char);
															} else {
																$initials = strtoupper(substr($author_name, 0, 2));
															}
														}
													}
													if (empty($initials)) {
														$initials = 'T';
													}

													$bg_colors = array(
														'#1abc9c',
														'#2ecc71',
														'#3498db',
														'#9b59b6',
														'#34495e',
														'#16a085',
														'#27ae60',
														'#2980b9',
														'#8e44ad',
														'#2c3e50',
														'#f1c40f',
														'#e67e22',
														'#e74c3c',
														'#95a5a6',
														'#f39c12',
														'#d35400',
														'#c0392b',
														'#7f8c8d',
														'#ff5252',
														'#7c4dff'
													);
													$color_index = abs(crc32($author_name)) % count($bg_colors);
													$bg_color = $bg_colors[$color_index];

													$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100">' .
														'<rect width="100%" height="100%" fill="' . $bg_color . '"/>' .
														'<text x="50%" y="54%" font-size="38" font-family="\'Outfit\', \'Inter\', \'Helvetica Neue\', sans-serif" font-weight="700" fill="#ffffff" dominant-baseline="middle" text-anchor="middle">' . $initials . '</text>' .
														'</svg>';

													$popup_image_url = 'data:image/svg+xml;utf8,' . rawurlencode($svg);
												}
											}
											$rating_val = ($tml_show_star_rating == 'true') ? $t_star_rating : 0;

											$display_content = '<span>' . wp_kses_post($display_text) .
												'<a href="#" class="popup-btn tml-read-more-link" ' .
												'data-full-text="' . esc_attr(wp_kses_post($t_text)) . '" ' .
												'data-title="' . esc_attr(get_the_title()) . '" ' .
												'data-image="' . esc_url($popup_image_url) . '" ' .
												'data-designation="' . esc_attr($t_designation) . '" ' .
												'data-website="' . esc_url($t_website_url) . '" ' .
												'data-rating="' . esc_attr($rating_val) . '" ' .
												'style="color:#0073aa; font-weight:bold; text-decoration:none; margin-left:5px;">' . esc_html($read_more_text) . '</a>' .
												'</span>';
										} else {
											// Default to 'expand'
											$display_content = '<span id="tml-short-' . $testimonial_post_id . '" class="tml-short-text">' . wp_kses_post($display_text) .
												'<a href="#" class="expand-btn tml-read-more-link" data-id="' . $testimonial_post_id . '" style="color:#0073aa; font-weight:bold; text-decoration:none; margin-left:5px;">' . esc_html($read_more_text) . '</a>' .
												'</span>' .
												'<span id="tml-full-' . $testimonial_post_id . '" class="tml-full-text" style="display:none;">' . wp_kses_post($t_text) .
												'<a href="#" class="expand-btn tml-read-more-link" data-id="' . $testimonial_post_id . '" style="color:#0073aa; font-weight:bold; text-decoration:none; margin-left:5px;">' . esc_html($read_less_text) . '</a>' .
												'</span>';
										}
									}

									if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {
										$image_size = ($testimonial_carousel_design == 10) ? 'full' : $tml_ds_image_dim;
										$tml_fe_image_thumb = wp_get_attachment_image_src($t_fe_image_id, $image_size, true);
										$is_fallback = false;
									} else {
										if ($tml_ds_image_fallback == 'none') {
											$tml_fe_image_thumb[0] = "";
										} elseif ($tml_ds_image_fallback == 'avatar') {
											// Generate a gorgeous SVG initials avatar
											$author_name = get_the_title($testimonial_post_id);
											$initials = '';
											if (!empty($author_name)) {
												$author_name = wp_strip_all_tags($author_name);
												$words = preg_split('/\s+/', trim($author_name));
												if (function_exists('mb_substr')) {
													if (count($words) >= 2) {
														$first_char = mb_substr($words[0], 0, 1, 'UTF-8');
														$second_char = mb_substr($words[1], 0, 1, 'UTF-8');
														$initials = mb_strtoupper($first_char . $second_char, 'UTF-8');
													} else {
														$initials = mb_strtoupper(mb_substr($author_name, 0, 2, 'UTF-8'), 'UTF-8');
													}
												} else {
													if (count($words) >= 2) {
														$first_char = substr($words[0], 0, 1);
														$second_char = substr($words[1], 0, 1);
														$initials = strtoupper($first_char . $second_char);
													} else {
														$initials = strtoupper(substr($author_name, 0, 2));
													}
												}
											}
											if (empty($initials)) {
												$initials = 'T';
											}

											// Premium, gorgeous colors for backgrounds
											$bg_colors = array(
												'#1abc9c',
												'#2ecc71',
												'#3498db',
												'#9b59b6',
												'#34495e',
												'#16a085',
												'#27ae60',
												'#2980b9',
												'#8e44ad',
												'#2c3e50',
												'#f1c40f',
												'#e67e22',
												'#e74c3c',
												'#95a5a6',
												'#f39c12',
												'#d35400',
												'#c0392b',
												'#7f8c8d',
												'#ff5252',
												'#7c4dff'
											);
											$color_index = abs(crc32($author_name)) % count($bg_colors);
											$bg_color = $bg_colors[$color_index];

											// Generate Inline SVG data URL
											$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100">' .
												'<rect width="100%" height="100%" fill="' . $bg_color . '"/>' .
												'<text x="50%" y="54%" font-size="38" font-family="\'Outfit\', \'Inter\', \'Helvetica Neue\', sans-serif" font-weight="700" fill="#ffffff" dominant-baseline="middle" text-anchor="middle">' . $initials . '</text>' .
												'</svg>';

											$tml_fe_image_thumb[0] = 'data:image/svg+xml;utf8,' . rawurlencode($svg);
										} else {
											$tml_fe_image_thumb[0] = "$tml_default_img";
										}
										$is_fallback = true;
									}

									$pic_width = (isset($tml_fe_image_thumb[1]) && $tml_fe_image_thumb[1] > 0) ? $tml_fe_image_thumb[1] : 100;
									$pic_height = (isset($tml_fe_image_thumb[2]) && $tml_fe_image_thumb[2] > 0) ? $tml_fe_image_thumb[2] : 100;
									$pic_style = "";

									// Category classes for filtering
									$terms = get_the_terms($testimonial_post_id, 'testimonial-categories');
									$term_classes = 'tml-item-wrapper tml-rating-' . $t_star_rating;
									if ($terms && !is_wp_error($terms)) {
										foreach ($terms as $term) {
											$term_classes .= ' tml-cat-' . $term->term_id;
										}
									}

									// template settings
									wp_enqueue_script('tml-owl-js', TML_PLUGIN_URL . 'assets/js/owl.carousel.js', array('jquery'), TML_PLUGIN_VER, false);
									$image_shape_class = 'tml-image-' . $tml_ds_image_shape;
									?>

									<div class="<?php echo esc_attr($term_classes); ?>"
										data-url="<?php echo urlencode(get_permalink()); ?>"
										data-text="<?php echo urlencode(wp_trim_words($t_text, 10)); ?>"
										data-video-url="<?php echo esc_url($t_video_url); ?>">
										<?php
										$design_file = TML_PLUGIN_DIR . 'templates/design-' . intval($testimonial_carousel_design) . '.php';
										if (file_exists($design_file)) {
											include($design_file);
										}
										?>
									</div>
									<?php
								endwhile;
								if ($is_ajax_request == 'true' && $tml_pagi_type != 'number') {
									wp_die(); // end execution for AJAX
								}
								?>
							</div>




						</div>
						<?php
						ob_start();
						include(plugin_dir_path(__FILE__) . 'assets/js/shortcode-scripts-carousel.php');
						$tml_unified_js .= ob_get_clean();
						?>
						<?php
	}


	if ($tml_layout != 'grid' && $tml_layout != 'masonry' && $tml_layout != 'list' && $tml_layout != 'isotope') {
		?>
						<?php
						// Dynamic Navigation Styling
						$nav_css = '';
						$nav_id = '#tml-carousel-' . $post_id['id'];

						if ($tml_nav == 'true') {
							$size_val = !empty($tml_nav_size) ? $tml_nav_size : '35';
							if (is_numeric($size_val)) {
								$size_val .= 'px';
							}
							// Colors, Borders, and Theme Conflict Fixes
							$nav_css .= "body $nav_id.owl-carousel { overflow: visible !important; }";
							$nav_css .= "body $nav_id.owl-carousel .owl-stage-outer { overflow: hidden !important; }";
							$nav_css .= "body $nav_id.owl-carousel .owl-nav { opacity: 1 !important; visibility: visible !important; pointer-events: none !important; z-index: 99999 !important; display: block !important; }";
							
							$nav_css .= "body $nav_id.owl-carousel .owl-nav button.owl-prev, body $nav_id.owl-carousel .owl-nav button.owl-next {";
							$nav_css .= "color: $tml_nav_color !important;";
							$nav_css .= "background: $tml_nav_bg_color !important;";
							$nav_css .= "width: $size_val !important; height: $size_val !important; font-size: 18px !important; padding: 0 !important; border-radius: 8px !important; transition: all 0.3s; display: inline-flex !important; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important; opacity: 1 !important; visibility: visible !important; z-index: 999999 !important; pointer-events: auto !important; cursor: pointer !important;";
							$nav_css .= "}";

							// Hover opacity effect
							$nav_css .= "body $nav_id.owl-carousel .owl-nav button.owl-prev:hover, body $nav_id.owl-carousel .owl-nav button.owl-next:hover {";
							$nav_css .= "opacity: 0.9 !important; transform: scale(1.05) !important; color: $tml_nav_color !important; background: $tml_nav_bg_color !important; cursor: pointer !important;";
							$nav_css .= "}";

							if ($tml_nav_mobile_hide == 'true') {
								$nav_css .= "@media (max-width: 767px) {";
								$nav_css .= "body $nav_id.owl-carousel .owl-nav, body $nav_id .owl-nav { display: none !important; }";
								$nav_css .= "}";
							}


							// Positions
							switch ($tml_nav_position) {
								case 'vertical_outer':
									// Pad the slider wrapper so the "outer" arrows fit inside the element bounds and never collide with sidebars
									$nav_css .= "body $nav_id.owl-carousel { padding-left: 50px !important; padding-right: 50px !important; box-sizing: border-box !important; }";
									$nav_css .= "$nav_id { position: relative; }";
									$nav_css .= "$nav_id .owl-nav { display: contents !important; }";
									$nav_css .= "body $nav_id .owl-prev, body $nav_id .owl-next { position: absolute !important; top: 50% !important; transform: translateY(-50%) !important; }";
									$nav_css .= "body $nav_id .owl-prev { left: 5px !important; }";
									$nav_css .= "body $nav_id .owl-next { right: 5px !important; }";
									break;
								case 'vertical_inner':
									$nav_css .= "$nav_id { position: relative; }";
									$nav_css .= "$nav_id .owl-nav { display: contents !important; }";
									$nav_css .= "body $nav_id .owl-prev, body $nav_id .owl-next { position: absolute !important; top: 50% !important; transform: translateY(-50%) !important; }";
									$nav_css .= "body $nav_id .owl-prev { left: 10px !important; }";
									$nav_css .= "body $nav_id .owl-next { right: 10px !important; }";
									break;
								case 'top_right':
									$nav_css .= "$nav_id { padding-top: 40px; }";
									$nav_css .= "$nav_id .owl-nav { position: absolute; top: 0; right: 0; display: flex; gap: 5px; }";
									break;
								case 'top_left':
									$nav_css .= "$nav_id { padding-top: 40px; }";
									$nav_css .= "$nav_id .owl-nav { position: absolute; top: 0; left: 0; display: flex; gap: 5px; }";
									break;
								case 'top_center':
									$nav_css .= "$nav_id { padding-top: 40px; }";
									$nav_css .= "$nav_id .owl-nav { position: absolute; top: 0; left: 50%; transform: translateX(-50%); display: flex; gap: 5px; }";
									break;
								case 'bottom_center':
									$nav_css .= "$nav_id { padding-bottom: 40px; }";
									$nav_css .= "$nav_id .owl-nav { position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); display: flex; gap: 5px; }";
									break;
								case 'bottom_right':
									$nav_css .= "$nav_id { padding-bottom: 40px; }";
									$nav_css .= "$nav_id .owl-nav { position: absolute; bottom: 0; right: 0; display: flex; gap: 5px; }";
									break;
								case 'bottom_left':
									$nav_css .= "$nav_id { padding-bottom: 40px; }";
									$nav_css .= "$nav_id .owl-nav { position: absolute; bottom: 0; left: 0; display: flex; gap: 5px; }";
									break;
								case 'vertical_center':
									// Pad the slider wrapper slightly to fit "center" outer arrows
									$nav_css .= "body $nav_id.owl-carousel { padding-left: 35px !important; padding-right: 35px !important; box-sizing: border-box !important; }";
									$nav_css .= "$nav_id { position: relative; }";
									$nav_css .= "$nav_id .owl-nav { display: contents !important; }";
									$nav_css .= "body $nav_id .owl-prev, body $nav_id .owl-next { position: absolute !important; top: 50% !important; transform: translateY(-50%) !important; }";
									$nav_css .= "body $nav_id .owl-prev { left: 5px !important; }";
									$nav_css .= "body $nav_id .owl-next { right: 5px !important; }";
									break;
							}
						} else {
							// Force hide the entire navigation container when disabled to prevent CSS specificity overrides
							$nav_css .= "body $nav_id.owl-carousel .owl-nav { display: none !important; }";
						}

						// Pagination Styling
						$nav_css .= "body $nav_id.owl-theme .owl-dots .owl-dot span { background: #cccccc !important; transition: all 0.3s; }";
						$nav_css .= "body $nav_id.owl-theme .owl-dots .owl-dot.active span, body $nav_id.owl-theme .owl-dots .owl-dot:hover span { background: #2271b1 !important; }";
						?>
						<style>
							<?php echo esc_html($nav_css); ?>
						</style>
						<?php
						ob_start();
						include(plugin_dir_path(__FILE__) . 'assets/js/shortcode-scripts-owl.php');
						$tml_unified_js .= ob_get_clean();
						?>
						<?php
	} // end if not grid or masonry






	// Preloader dismissal & Schema Markup
	?>
					<script>
						<?php
						// Strip any opening/closing script tags from unified scripts
						$tml_clean_js = preg_replace('/<script[^>]*>/i', '', $tml_unified_js);
						$tml_clean_js = preg_replace('/<\/script>/i', '', $tml_clean_js);
						echo $tml_clean_js; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
						jQuery(document).ready(function ($) {
							// Preloader dismissal
							<?php if ($tml_ds_preloader == 'enabled') { ?>
								jQuery(window).on('load', function () {
									$('.tml-preloader').fadeOut(500);
								});
								// Fallback in case load event already fired
								setTimeout(function () {
									$('.tml-preloader').fadeOut(500);
								}, 3000);
							<?php } ?>

							// Search functionality
							$('.tml-search-input').on('keyup', function () {
								var containerId = $(this).data('container');
								var $container = $(containerId);
								if (typeof window.applyTmlFilters === 'function') {
									window.applyTmlFilters($container);
								} else {
									// Standalone search logic when other filters are disabled
									var value = $(this).val().toLowerCase().trim();
									var $noResults = $(this).siblings('.tml-search-no-results');
									var isSlider = $container.find('.owl-carousel').length > 0;
									var matchCount = 0;

									if (isSlider) {
										var $owl = $container.find('.owl-carousel');
										var originalSlides = $owl.data('original-slides');
										if (originalSlides && originalSlides.length) {
											$owl.trigger('destroy.owl.carousel');
											$owl.removeClass('owl-loaded owl-drag owl-refresh');
											$owl.empty();

											$.each(originalSlides, function (index, $slide) {
												var isMatch = true;
												if (value !== '') {
													var slideText = $slide.text().toLowerCase();
													if (slideText.indexOf(value) === -1) {
														isMatch = false;
													}
												}
												if (isMatch) {
													$owl.append($slide.clone());
													matchCount++;
												}
											});

											if (matchCount === 0) {
												$noResults.show();
												$owl.hide();
											} else {
												$noResults.hide();
												$owl.show();
												var initFn = $owl.data('owl-init-fn');
												if (typeof initFn === 'function') {
													initFn($owl);
												}
											}
										}
									} else {
										// Grid / Masonry / List standalone search filtering
										$container.find('.tml-item-wrapper').each(function () {
											var $item = $(this);
											var isMatch = true;
											if (value !== '') {
												var itemText = $item.text().toLowerCase();
												if (itemText.indexOf(value) === -1) {
													isMatch = false;
												}
											}
											if (isMatch) {
												$item.removeClass('tml-hide');
												this.style.removeProperty('display');
												matchCount++;
											} else {
												$item.addClass('tml-hide');
												this.style.setProperty('display', 'none', 'important');
											}
										});

										if (matchCount === 0) {
											$noResults.show();
										} else {
											$noResults.hide();
										}
									}
								}
							});

							// Read More Expand Action - Sibling-based toggle for maximum template compatibility
							$(document).off('click.tmlExpandBtn').on('click.tmlExpandBtn', '.expand-btn', function (e) {
								e.preventDefault();
								var $btn = $(this);
								var $currentSpan = $btn.closest('span');
								var $nextSpan = $currentSpan.next('span');

								if ($nextSpan.length > 0) {
									// This is the short span (first span). Hide it and show the next sibling span (full span).
									$currentSpan.hide();
									$nextSpan.show();
								} else {
									// This is the full span (second span). Hide it and show the previous sibling span (short span).
									var $prevSpan = $currentSpan.prev('span');
									if ($prevSpan.length > 0) {
										$currentSpan.hide();
										$prevSpan.show();
									}
								}

								// Force Owl Carousel recalculation if it exists
								var $owl = $btn.closest('.owl-carousel');
								if ($owl.length > 0) {
									$owl.trigger('refresh.owl.carousel');
								}
							});

							// Read More Popup Action
							$(document).off('click.tmlPopupBtn').on('click.tmlPopupBtn', '.popup-btn', function (e) {
								e.preventDefault();
								var text = $(this).data('full-text');
								var title = $(this).data('title');
								var image = $(this).data('image');
								var designation = $(this).data('designation');
								var website = $(this).data('website');
								var rating = $(this).data('rating');

								// Build HTML for avatar image dynamically respecting the image shape setting
								var imageHtml = '';
								if (image && image !== 'none') {
									var activeImageShape = <?php echo json_encode($tml_ds_image_shape); ?>;
									var popupBorderRadius = '50%';
									if (activeImageShape === 'rounded') {
										popupBorderRadius = '10px';
									} else if (activeImageShape === 'square') {
										popupBorderRadius = '0%';
									}

									imageHtml = '<div style="margin-bottom: 18px; display: inline-block;">' +
										'<img src="' + image + '" style="width: 90px; height: 90px; border-radius: ' + popupBorderRadius + '; object-fit: cover; border: 3px solid #0073aa; box-shadow: 0 4px 12px rgba(0,0,0,0.15);" />' +
										'</div>';
								}

								// Build HTML for rating stars dynamically matching active settings
								var ratingHtml = '';
								if (rating && rating > 0) {
									var activeRatingStyle = <?php echo json_encode($tml_rating_style); ?>;
									var activeRatingColor = <?php echo json_encode($tml_star_rating_color); ?>;
									var activeDefaultColor = <?php echo json_encode($tml_ds_rating_default_color); ?>;
									var activeGap = <?php echo json_encode($tml_ds_rating_gap); ?>;

									var iconsList = {
										'star': { 'filled': 'fa-star', 'empty': 'fa-star-o' },
										'heart': { 'filled': 'fa-heart', 'empty': 'fa-heart' },
										'thumbs-up': { 'filled': 'fa-thumbs-up', 'empty': 'fa-thumbs-o-up' },
										'smile': { 'filled': 'fa-smile-o', 'empty': 'fa-smile-o' },
										'diamond': { 'filled': 'fa-diamond', 'empty': 'fa-diamond' },
										'badge': { 'filled': 'fa-certificate', 'empty': 'fa-certificate' },
										'trophy': { 'filled': 'fa-trophy', 'empty': 'fa-trophy' },
										'bell': { 'filled': 'fa-bell', 'empty': 'fa-bell-o' }
									};

									var filledIcon = (iconsList[activeRatingStyle] ? iconsList[activeRatingStyle]['filled'] : 'fa-star');
									var emptyIcon = (iconsList[activeRatingStyle] ? iconsList[activeRatingStyle]['empty'] : 'fa-star-o');

									ratingHtml = '<div style="font-size: 18px; margin-bottom: 15px; display: flex; justify-content: center; gap: ' + activeGap + 'px;">';
									for (var i = 1; i <= 5; i++) {
										var iconClass = (i <= rating) ? filledIcon : emptyIcon;
										var iconColor = (i <= rating) ? activeRatingColor : activeDefaultColor;
										var opacity = (i > rating && activeRatingStyle === filledIcon) ? '0.3' : '1';

										ratingHtml += '<i class="fa ' + iconClass + '" style="color:' + iconColor + '; opacity:' + opacity + ';"></i>';
									}
									ratingHtml += '</div>';
								}

								// Build HTML for designation
								var designationHtml = '';
								if (designation) {
									designationHtml = '<h4 style="margin: 6px 0 12px 0; font-size: 14px; font-weight: 600; color: #0073aa; text-transform: uppercase; letter-spacing: 0.8px;">' + designation + '</h4>';
								}

								// Build HTML for website link
								var websiteHtml = '';
								if (website) {
									websiteHtml = '<div style="margin-top: 18px; margin-bottom: 5px;">' +
										'<a href="' + website + '" target="_blank" style="color: #0073aa; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; gap: 6px; transition: opacity 0.2s;" onmouseover="this.style.opacity=\'0.8\'" onmouseout="this.style.opacity=\'1\'"><i class="fa fa-external-link"></i> Visit Website</a>' +
										'</div>';
								}

								var modalHtml = '<div id="tml-modal" style="position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:999999; display:flex; align-items:center; justify-content:center; padding:20px; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Oxygen-Sans, Ubuntu, Cantarell, \"Helvetica Neue\", sans-serif; box-sizing: border-box;">' +
									'<div style="background:#fff; width:100%; max-width:550px; padding:35px; border-radius:16px; position:relative; max-height:85vh; overflow-y:auto; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.3); box-sizing: border-box;">' +
									'<span class="tml-close-modal" style="position:absolute; top:12px; right:18px; font-size:32px; cursor:pointer; color:#bbb; transition: color 0.2s;" onmouseover="this.style.color=\'#666\'" onmouseout="this.style.color=\'#bbb\'">&times;</span>' +
									imageHtml +
									'<h3 style="margin: 0; font-size: 24px; font-weight: 700; color: #1e293b;">' + title + '</h3>' +
									designationHtml +
									ratingHtml +
									'<div style="line-height:1.7; color:#475569; font-size: 15px; background: #f8fafc; padding: 22px; border-radius: 10px; text-align: center; margin: 18px 0; font-style: italic;">' + text + '</div>' +
									websiteHtml +
									'</div></div>';

								$('body').append(modalHtml);
							});

							$(document).off('click.tmlCloseModal').on('click.tmlCloseModal', '.tml-close-modal, #tml-modal', function (e) {
								if (e.target !== this && !$(e.target).hasClass('tml-close-modal')) return;
								$('#tml-modal').remove();
							});

							// Video logic excised for lightweight free-only version
						});
					</script>
					<?php

					}
					wp_reset_postdata();
					$output = ob_get_contents();
					ob_end_clean();
					return $output;
} ?>