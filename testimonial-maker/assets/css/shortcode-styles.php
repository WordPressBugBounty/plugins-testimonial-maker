<?php
// Testimonial Premium - Dynamic Styles Injection
// Auto-extracted for modularity

if (!defined('ABSPATH')) exit;
?>
<style>
		/* Advanced Typography & Custom Settings Dynamic Injection */
		body #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .pic {
			float: none !important;
		}

		body #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-section-title {
			font-size: 28px !important;
			font-weight: 700 !important;
			color: #1e293b !important;
			line-height: 1.3 !important;
			margin-top: 0 !important;
			margin-bottom: 30px !important;
			text-align: center !important;
		}

		<?php
		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		$wrapper_id = '#tml-main-wrapper-' . esc_attr($post_id['id']);

		// Always output base text colors so they work on every theme (dark/light) even without Advanced Typography
		if (!empty($tml_title_color)) {
			echo "body $wrapper_id .tml-testimonial-title, body $wrapper_id .tml-tagline, body $wrapper_id .testimonial-title, body $wrapper_id .tml-name { color: " . esc_attr($tml_title_color) . " !important; }\n";
		}
		if (!empty($tml_description_color)) {
			echo "body $wrapper_id .tml-testimonial-content, body $wrapper_id .tml-content, body $wrapper_id .tml-description, body $wrapper_id .tml-desc { color: " . esc_attr($tml_description_color) . " !important; }\n";
		}
		if (!empty($tml_designation_color)) {
			echo "body $wrapper_id .tml-designation, body $wrapper_id .tml-desig { color: " . esc_attr($tml_designation_color) . " !important; }\n";
		}

		// Advanced Typography overrides (includes font, size, weight, spacing, AND color — takes priority over base colors above)
		if (!empty($typo_styles['tml_typo_title'])) {
			echo "body $wrapper_id .tml-testimonial-title, body $wrapper_id .tml-tagline, body $wrapper_id .testimonial-title, body $wrapper_id .tml-name { {$typo_styles['tml_typo_title']} }\n";
		}
		if (!empty($typo_styles['tml_typo_content'])) {
			echo "body $wrapper_id .tml-testimonial-content, body $wrapper_id .tml-content, body $wrapper_id .tml-description, body $wrapper_id .tml-desc { {$typo_styles['tml_typo_content']} }\n";
		}
		if (!empty($typo_styles['tml_typo_designation'])) {
			echo "body $wrapper_id .tml-designation, body $wrapper_id .tml-desig { {$typo_styles['tml_typo_designation']} }\n";
		}
		if (!empty($typo_styles['tml_typo_website'])) {
			echo "body $wrapper_id .tml-website, body $wrapper_id .testimonial-link, body $wrapper_id .testimonial-link a { {$typo_styles['tml_typo_website']} }\n";
		}
		if (!empty($typo_styles['tml_typo_isotope'])) {
			$filters_id = '#tml-filters-container-' . esc_attr($post_id['id']);
			echo "body $filters_id .tml-filter-select, body $filters_id .tml-filter-label, body $filters_id .tml-filter-btn { {$typo_styles['tml_typo_isotope']} }\n";

			$isotope_align = isset($testimonial_settings['tml_typo_isotope_align']) ? $testimonial_settings['tml_typo_isotope_align'] : 'center';
			$justify_content = 'center';
			if ($isotope_align == 'left') {
				$justify_content = 'flex-start';
			} elseif ($isotope_align == 'right') {
				$justify_content = 'flex-end';
			}
			echo "body $filters_id { justify-content: {$justify_content} !important; }\n";

			$isotope_color = isset($testimonial_settings['tml_typo_isotope_color']) ? $testimonial_settings['tml_typo_isotope_color'] : '';
			if (!empty($isotope_color)) {
				echo "body $filters_id .tml-filter-select:hover { border-color: {$isotope_color} !important; }\n";
				echo "body $filters_id .tml-filter-btn.active { background-color: {$isotope_color} !important; color: #ffffff !important; border-color: {$isotope_color} !important; }\n";
				echo "body $filters_id .tml-filter-btn:hover { border-color: {$isotope_color} !important; color: {$isotope_color} !important; }\n";
				echo "body $filters_id .tml-filter-btn.active:hover { color: #ffffff !important; }\n";
			}
		}

		// Card Box Shadow Override
		if ($tml_ds_card_shadow === 'hide') {
			echo "body $wrapper_id .tml-testimonial {\n";
			echo "    box-shadow: none !important;\n";
			echo "}\n";
			echo "body $wrapper_id .tml-testimonial:hover {\n";
			echo "    box-shadow: none !important;\n";
			echo "}\n";
		} else {
			echo "body $wrapper_id .tml-testimonial {\n";
			echo "    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04) !important;\n";
			echo "    border: 1px solid rgba(0, 0, 0, 0.05) !important;\n";
			echo "}\n";
			echo "body $wrapper_id .tml-testimonial:hover {\n";
			echo "    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.07) !important;\n";
			echo "    border-color: rgba(0, 0, 0, 0.08) !important;\n";
			echo "}\n";
		}

		// Navigation Settings Override
		if ($tml_nav == 'true') {
			echo "/* Navigation Buttons Base Styles */\n";
			echo "body $wrapper_id .owl-carousel .owl-nav button.owl-prev,\n";
			echo "body $wrapper_id .owl-carousel .owl-nav button.owl-next,\n";
			echo "body $wrapper_id .owl-nav button {\n";
			echo "    color: " . esc_attr($tml_nav_color) . " !important;\n";
			echo "    background: " . esc_attr($tml_nav_bg_color) . " !important;\n";
			$size_val = !empty($tml_nav_size) ? $tml_nav_size : '35';
			if (is_numeric($size_val)) {
				$size_val .= 'px';
			}
			echo "    width: " . esc_attr($size_val) . " !important;\n";
			echo "    height: " . esc_attr($size_val) . " !important;\n";
			echo "    font-size: 18px !important;\n";
			echo "    padding: 0 !important;\n";
			echo "    margin: 0 !important;\n";
			echo "    border-radius: 8px !important;\n";
			echo "    border: none !important;\n";
			echo "    box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important;\n";
			echo "    cursor: pointer !important;\n";
			echo "    display: inline-flex !important;\n";
			echo "    align-items: center !important;\n";
			echo "    justify-content: center !important;\n";
			echo "    line-height: 1 !important;\n";
			echo "    vertical-align: middle !important;\n";
			echo "    transition: all 0.3s ease !important;\n";
			echo "}\n";

			echo "/* Navigation Icons (Inner Elements) Centering */\n";
			echo "body $wrapper_id .owl-carousel .owl-nav button.owl-prev span,\n";
			echo "body $wrapper_id .owl-carousel .owl-nav button.owl-next span,\n";
			echo "body $wrapper_id .owl-carousel .owl-nav button.owl-prev i,\n";
			echo "body $wrapper_id .owl-carousel .owl-nav button.owl-next i,\n";
			echo "body $wrapper_id .owl-carousel .owl-nav button.owl-prev svg,\n";
			echo "body $wrapper_id .owl-carousel .owl-nav button.owl-next svg,\n";
			echo "body $wrapper_id .owl-nav button span,\n";
			echo "body $wrapper_id .owl-nav button i,\n";
			echo "body $wrapper_id .owl-nav button svg {\n";
			echo "    display: flex !important;\n";
			echo "    align-items: center !important;\n";
			echo "    justify-content: center !important;\n";
			echo "    width: 1em !important;\n";
			echo "    height: 1em !important;\n";
			echo "    line-height: 1 !important;\n";
			echo "    margin: 0 auto !important;\n";
			echo "    padding: 0 !important;\n";
			echo "    font-size: inherit !important;\n";
			echo "}\n";

			echo "/* SVG specific stroke styling */\n";
			echo "body $wrapper_id .owl-carousel .owl-nav button.owl-prev svg,\n";
			echo "body $wrapper_id .owl-carousel .owl-nav button.owl-next svg,\n";
			echo "body $wrapper_id .owl-nav button svg {\n";
			echo "    fill: none !important;\n";
			echo "    stroke: currentColor !important;\n";
			echo "    stroke-width: 2.5 !important;\n";
			echo "    stroke-linecap: round !important;\n";
			echo "    stroke-linejoin: round !important;\n";
			echo "}\n";

			echo "/* Caret (Filled) SVG specific styling */\n";
			echo "body $wrapper_id .owl-carousel .owl-nav button.owl-prev svg.tml-caret,\n";
			echo "body $wrapper_id .owl-carousel .owl-nav button.owl-next svg.tml-caret,\n";
			echo "body $wrapper_id .owl-nav button svg.tml-caret {\n";
			echo "    fill: currentColor !important;\n";
			echo "    stroke: none !important;\n";
			echo "}\n";

			echo "/* Navigation Buttons Hover State */\n";
			echo "body $wrapper_id .owl-carousel .owl-nav button.owl-prev:hover,\n";
			echo "body $wrapper_id .owl-carousel .owl-nav button.owl-next:hover,\n";
			echo "body $wrapper_id .owl-nav button:hover {\n";
			echo "    opacity: 0.9 !important;\n";
			echo "    transform: scale(1.05) !important;\n";
			echo "}\n";

			if ($tml_nav_mobile_hide == 'true') {
				echo "@media (max-width: 767px) {\n";
				echo "    body $wrapper_id .owl-carousel .owl-nav, body $wrapper_id .owl-nav {\n";
				echo "        display: none !important;\n";
				echo "    }\n";
				echo "}\n";
			}
		} else {
			echo "body $wrapper_id .owl-carousel .owl-nav, body $wrapper_id .owl-nav { display: none !important; }\n";
		}

		// Pagination Settings Override
		if ($tml_pagination == 'true') {
			echo "body $wrapper_id .owl-theme .owl-dots .owl-dot span {\n";
			echo "    background: #cccccc !important;\n";
			echo "}\n";
			echo "body $wrapper_id .owl-theme .owl-dots .owl-dot.active span, body $wrapper_id .owl-theme .owl-dots .owl-dot:hover span {\n";
			echo "    background: #2271b1 !important;\n";
			echo "}\n";
		} else {
			echo "body $wrapper_id .owl-theme .owl-dots, body $wrapper_id .owl-dots { display: none !important; }\n";
		}
		/* Grid & Masonry Layouts */
		echo "		.tml-hide {\n";
		echo "			display: none !important;\n";
		echo "		}\n";

		$grid_id = esc_attr($post_id['id']);

		// Layout auto-height override to prevent squishing of Isotope, Masonry, and List cards
		if ($tml_layout == 'isotope' || $tml_layout == 'masonry' || $tml_layout == 'list') {
			echo "		#tml-main-wrapper-{$grid_id} .tml-item-wrapper {\n";
			echo "			height: auto !important;\n";
			echo "		}\n";
		}

		$col_ld_val = (!empty($tml_col_ld) && is_numeric($tml_col_ld)) ? $tml_col_ld : '3';
		$col_d_val = (!empty($tml_col_d) && is_numeric($tml_col_d)) ? $tml_col_d : '3';
		$col_l_val = (!empty($tml_col_l) && is_numeric($tml_col_l)) ? $tml_col_l : '2';
		$col_t_val = (!empty($tml_col_t) && is_numeric($tml_col_t)) ? $tml_col_t : '1';
		$col_m_val = (!empty($tml_col_m) && is_numeric($tml_col_m)) ? $tml_col_m : '1';

		$row_gap_val = esc_attr($tml_vgap);
		$col_gap_val = esc_attr($tml_gap);

		echo "		#tml-grid-container-{$grid_id}.tml-testimonial-grid {\n";
		echo "			display: grid !important;\n";
		echo "			grid-template-columns: repeat({$col_ld_val}, minmax(0, 1fr)) !important;\n";
		echo "			row-gap: {$row_gap_val}px !important;\n";
		echo "			column-gap: {$col_gap_val}px !important;\n";
		echo "		}\n";

		echo "		#tml-grid-container-{$grid_id}.tml-testimonial-grid .tml-item-wrapper {\n";
		echo "			width: auto !important;\n";
		echo "			max-width: 100% !important;\n";
		echo "			display: flex !important;\n";
		echo "			flex-direction: column !important;\n";
		echo "			align-items: stretch !important;\n";
		echo "			height: 100% !important;\n";
		echo "			word-wrap: break-word !important;\n";
		echo "			word-break: break-word !important;\n";
		echo "			overflow-wrap: break-word !important;\n";
		echo "		}\n";

		echo "		#tml-grid-container-{$grid_id}.tml-testimonial-grid .tml-item-wrapper>div {\n";
		echo "			flex: 1 1 auto !important;\n";
		echo "		}\n";

		echo "		#tml-masonry-container-{$grid_id}.tml-testimonial-masonry {\n";
		echo "			column-count: {$col_ld_val} !important;\n";
		echo "			column-gap: {$col_gap_val}px !important;\n";
		echo "		}\n";

		echo "		#tml-masonry-container-{$grid_id}.tml-testimonial-masonry .tml-item-wrapper {\n";
		echo "			break-inside: avoid !important;\n";
		echo "			margin-bottom: {$row_gap_val}px !important;\n";
		echo "			display: block;\n";
		echo "			width: 100% !important;\n";
		echo "			word-wrap: break-word !important;\n";
		echo "			word-break: break-word !important;\n";
		echo "			overflow-wrap: break-word !important;\n";
		echo "		}\n";

		echo "		#tml-isotope-container-{$grid_id}.tml-testimonial-isotope {\n";
		echo "			position: relative !important;\n";
		echo "			width: calc(100% + {$col_gap_val}px) !important;\n";
		echo "			margin-left: calc(-{$col_gap_val}px / 2) !important;\n";
		echo "			margin-right: calc(-{$col_gap_val}px / 2) !important;\n";
		echo "			transition: height 0.4s ease-in-out !important;\n";
		echo "			overflow: hidden !important;\n";
		echo "		}\n";

		echo "		#tml-isotope-container-{$grid_id}.tml-testimonial-isotope .tml-item-wrapper {\n";
		echo "			width: calc(100% / {$col_ld_val}) !important;\n";
		echo "			padding-left: calc({$col_gap_val}px / 2) !important;\n";
		echo "			padding-right: calc({$col_gap_val}px / 2) !important;\n";
		echo "			margin-bottom: {$row_gap_val}px !important;\n";
		echo "			float: left;\n";
		echo "			box-sizing: border-box !important;\n";
		echo "			word-wrap: break-word !important;\n";
		echo "			word-break: break-word !important;\n";
		echo "			overflow-wrap: break-word !important;\n";
		echo "			transition: opacity 0.4s ease;\n";
		echo "		}\n";

		echo "		@media (max-width: 1200px) {\n";
		echo "			#tml-grid-container-{$grid_id}.tml-testimonial-grid {\n";
		echo "				grid-template-columns: repeat({$col_d_val}, minmax(0, 1fr)) !important;\n";
		echo "			}\n";
		echo "			#tml-masonry-container-{$grid_id}.tml-testimonial-masonry {\n";
		echo "				column-count: {$col_d_val} !important;\n";
		echo "			}\n";
		echo "			#tml-isotope-container-{$grid_id}.tml-testimonial-isotope .tml-item-wrapper {\n";
		echo "				width: calc(100% / {$col_d_val}) !important;\n";
		echo "			}\n";
		echo "		}\n";

		echo "		@media (max-width: 992px) {\n";
		echo "			#tml-grid-container-{$grid_id}.tml-testimonial-grid {\n";
		echo "				grid-template-columns: repeat({$col_l_val}, minmax(0, 1fr)) !important;\n";
		echo "			}\n";
		echo "			#tml-masonry-container-{$grid_id}.tml-testimonial-masonry {\n";
		echo "				column-count: {$col_l_val} !important;\n";
		echo "			}\n";
		echo "			#tml-isotope-container-{$grid_id}.tml-testimonial-isotope .tml-item-wrapper {\n";
		echo "				width: calc(100% / {$col_l_val}) !important;\n";
		echo "			}\n";
		echo "		}\n";

		echo "		@media (max-width: 768px) {\n";
		echo "			#tml-grid-container-{$grid_id}.tml-testimonial-grid {\n";
		echo "				grid-template-columns: repeat({$col_t_val}, minmax(0, 1fr)) !important;\n";
		echo "			}\n";
		echo "			#tml-masonry-container-{$grid_id}.tml-testimonial-masonry {\n";
		echo "				column-count: {$col_t_val} !important;\n";
		echo "			}\n";
		echo "			#tml-isotope-container-{$grid_id}.tml-testimonial-isotope .tml-item-wrapper {\n";
		echo "				width: calc(100% / {$col_t_val}) !important;\n";
		echo "			}\n";
		echo "		}\n";

		echo "		@media (max-width: 480px) {\n";
		echo "			#tml-grid-container-{$grid_id}.tml-testimonial-grid {\n";
		echo "				grid-template-columns: repeat({$col_m_val}, minmax(0, 1fr)) !important;\n";
		echo "			}\n";
		echo "			#tml-masonry-container-{$grid_id}.tml-testimonial-masonry {\n";
		echo "				column-count: {$col_m_val} !important;\n";
		echo "			}\n";
		echo "			#tml-isotope-container-{$grid_id}.tml-testimonial-isotope .tml-item-wrapper {\n";
		echo "				width: calc(100% / {$col_m_val}) !important;\n";
		echo "			}\n";
		echo "		}\n";
		// phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped
		?>

		/* Preloader Styles */
		<?php if ($tml_ds_preloader == 'enabled') { ?>
			.tml-preloader {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background: rgba(255, 255, 255, 0.8);
				display: flex;
				justify-content: center;
				align-items: center;
				z-index: 10;
			}

			.tml-preloader .tml-premium-spinner {
				width: 50px;
				height: 50px;
				border: 3.5px solid transparent;
				border-top: 3.5px solid #2271b1;
				border-right: 3.5px solid #2271b1;
				border-radius: 50%;
				animation: tml-spin 0.75s linear infinite;
				box-shadow: 0 0 15px rgba(0, 0, 0, 0.02);
			}

			.tml-main-wrapper {
				position: relative;
				min-height: 200px;
			}

			@keyframes tml-spin {
				to {
					transform: rotate(360deg);
				}
			}
		<?php } ?>

		/* Star Rating Styles */
		.testimonial-rating {
			margin: 10px 0;
			text-align: center;
		}

		.testimonial-rating i {
			color: <?php echo esc_attr($tml_star_rating_color); ?>;
			font-size: 16px;
			margin: 0 2px;
		}

		.testimonial-rating i.fa-star-o {
			color: #ddd;
		}

		/* Reviewer Image Styles */
		.tml-testimonial .pic {
			margin: 0 auto 15px !important;
			display: block !important;
			overflow: visible !important;
		}

		.tml-testimonial .pic img {
			width: 100% !important;
			height: 100% !important;
			object-fit: cover !important;
		}

		/* Shape styling based on settings */
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .pic,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .pic img,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-avatar-wrapper,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-avatar-wrapper img,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-t13-avatar-ring,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-t13-avatar,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-t13-avatar img,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-t13-avatar-container,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-t13-avatar-container img,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-t14-avatar-wrapper,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-t14-avatar-wrapper img,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-t14-avatar-square,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-t14-avatar-square img,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-t15-avatar,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-t15-avatar img,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-t16-avatar-glow-ring,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-t16-avatar,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-t16-avatar img,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-t16-avatar-container,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-t16-avatar-container img,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-image-circle,
		#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-image-circle img {
			<?php if ($tml_ds_image_shape === 'circle') { ?>
				border-radius: 50% !important;
			<?php } elseif ($tml_ds_image_shape === 'rounded') { ?>
				border-radius: 10px !important;
			<?php } else { ?>
				border-radius: 0% !important;
			<?php } ?>
		}

		/* Explicit backwards compatibility for class styling */
		.tml-image-circle,
		.tml-image-circle img {
			border-radius: 50% !important;
		}

		.tml-image-square,
		.tml-image-square img {
			border-radius: 0% !important;
		}

		.tml-image-rounded,
		.tml-image-rounded img {
			border-radius: 10px !important;
		}

		/* Filter Tabs */
		.tml-filter-tabs {
			text-align: center;
			margin-bottom: 20px;
		}

		.tml-filter-btn {
			background: transparent;
			border: 1px solid #ccc;
			padding: 5px 15px;
			margin: 0 5px;
			cursor: pointer;
			transition: 0.3s;
		}

	</style>