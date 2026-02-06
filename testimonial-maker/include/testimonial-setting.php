<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
$testimonial_settings = get_option('testimonial_settings');
// js
wp_enqueue_script('awl-tml-bootstrap-js', TML_PLUGIN_URL . 'assets/js/bootstrap.js', array('jquery'), '', true);

// WordPress color picker
wp_enqueue_style('wp-color-picker');
wp_enqueue_script('wp-color-picker');

// css
wp_enqueue_style('tml-bootstrap-css', TML_PLUGIN_URL . 'assets/css/bootstrap.css');
wp_enqueue_style('tml-metabox-css', TML_PLUGIN_URL . 'assets/css/metabox.css');
wp_enqueue_style('tml-toggle-css', TML_PLUGIN_URL . 'assets/css/toogle-button.css');
wp_enqueue_style('tml-font-awesome-css', TML_PLUGIN_URL . 'assets/css/font-awesome.css');

?>
<div style="text-align:center">
	<h1><?php esc_html_e('How to show Testimonial on page ?', 'testimonial-maker'); ?></h1>
	<hr>
	<p class="input-text-wrap">
	<p><?php esc_html_e('Copy & Embed shortcode into any Page/ Post / Text to display Testimonial on site.', 'testimonial-maker'); ?><br>
	</p>
	<input type="text" name="shortcode" id="shortcode" value="[TML]" readonly
		style="height: 60px; text-align: center; font-size: 24px; width: 15%; border: 2px dashed;"
		onmouseover="return pulseOff();" onmouseout="return pulseStart();">
	</p>
	<hr>
</div>
<form id="testimonial_form_setting">
	<div class="row setting-css">
		<div class="col-lg-12 bhoechie-tab-container">
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 bhoechie-tab-menu">
				<div class="list-group">
					<a href="#" class="list-group-item active text-center">
						<span
							class="dashicons dashicons-format-image"></span><br /><?php esc_html_e('Template Design', 'testimonial-maker'); ?>
					</a>
					<a href="#" class="list-group-item text-center">
						<span
							class="dashicons dashicons-admin-generic"></span><br /><?php esc_html_e('Config', 'testimonial-maker'); ?>
					</a>
					<a href="#" class="list-group-item text-center">
						<span
							class="dashicons dashicons-admin-appearance"></span><br /><?php esc_html_e('Color Setting', 'testimonial-maker'); ?>
					</a>
					<a href="#" class="list-group-item text-center">
						<span
							class="dashicons dashicons-art"></span><br /><?php esc_html_e('Advanced Design', 'testimonial-maker'); ?>
					</a>
					<a href="#" class="list-group-item text-center">
						<span
							class="dashicons dashicons-media-code"></span><br /><?php esc_html_e('Custum Css', 'testimonial-maker'); ?>
					</a>
				</div>
			</div>
			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 bhoechie-tab">

				<div class="bhoechie-tab-content active">
					<h1><?php esc_html_e('Template Design', 'testimonial-maker'); ?></h1>
					<hr>
					<div class="col-md-4" id="carousal_effect">
						<div class="ma_field p-4">
							<?php
							if (isset($testimonial_settings['testimonial_carousel_design'])) {
								$testimonial_carousel_design = $testimonial_settings['testimonial_carousel_design'];
							} else {
								$testimonial_carousel_design = 1;
							}
							?>
							<select id="testimonial_carousel_design" name="testimonial_carousel_design"
								class="form-control" style="margin-left: 15px; width: 300px;">
								<option value="template1" <?php selected($testimonial_carousel_design, 'template1'); ?>><?php esc_html_e('Template 1 - Classic', 'testimonial-maker'); ?></option>
								<option value="template2" <?php selected($testimonial_carousel_design, 'template2'); ?>><?php esc_html_e('Template 2 - Side Image', 'testimonial-maker'); ?></option>
								<option value="template3" <?php selected($testimonial_carousel_design, 'template3'); ?>><?php esc_html_e('Template 3 - Bottom Image', 'testimonial-maker'); ?></option>
								<option value="template4" <?php selected($testimonial_carousel_design, 'template4'); ?>><?php esc_html_e('Template 4 - Compact', 'testimonial-maker'); ?></option>
								<option value="template5" <?php selected($testimonial_carousel_design, 'template5'); ?>><?php esc_html_e('Template 5 - Grid Masonry ⭐', 'testimonial-maker'); ?>
								</option>
								<option value="template6" <?php selected($testimonial_carousel_design, 'template6'); ?>><?php esc_html_e('Template 6 - Video Style ⭐', 'testimonial-maker'); ?>
								</option>
								<option value="template7" <?php selected($testimonial_carousel_design, 'template7'); ?>><?php esc_html_e('Template 7 - Social Media ⭐', 'testimonial-maker'); ?>
								</option>
								<option value="template8" <?php selected($testimonial_carousel_design, 'template8'); ?>><?php esc_html_e('Template 8 - Glassmorphism ⭐', 'testimonial-maker'); ?>
								</option>
							</select>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<div class="testimonial_img_preview">
								<!-- Template 1: Classic Centered -->
								<img style="display:none;"
									src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'img/templet-1.png'); ?>"
									class="temp_1" />


								<!-- Template 2: Left Aligned -->
								<img style="display:none;"
									src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'img/templet-2.png'); ?>"
									class="temp_2" />


								<!-- Template 3: Card Style -->
								<img style="display:none;"
									src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'img/templet-3.png'); ?>"
									class="temp_3" />


								<!-- Template 4: Minimal -->
								<img style="display:none;"
									src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'img/templet-4.png'); ?>"
									class="temp_4" />


								<!-- Template 5-8: Modern Templates Preview -->
								<img style="display:none;" src="<?php echo esc_url(plugin_dir_url( __FILE__ ). 'img/templet-5.png'); ?>" class="temp_5"/>
								<img style="display:none;" src="<?php echo esc_url(plugin_dir_url( __FILE__ ). 'img/templet-6.png'); ?>" class="temp_6"/>
								<img style="display:none;" src="<?php echo esc_url(plugin_dir_url( __FILE__ ). 'img/templet-7.png'); ?>" class="temp_7"/>
								<img style="display:none;" src="<?php echo esc_url(plugin_dir_url( __FILE__ ). 'img/templet-8.png'); ?>" class="temp_8"/>
							</div>
						</div>
					</div>
				</div>

				<div class="bhoechie-tab-content">
					<h1><?php esc_html_e('Transitions Settings', 'testimonial-maker'); ?></h1>
					<hr>
					<!--Theme 1 lighbox -->

					<div class="col-md-4">
						<div class="ma_field_discription">
							<h5><?php esc_html_e('Transitions Effect', 'testimonial-maker'); ?></h5>
							<p><?php esc_html_e('Select Effect', 'testimonial-maker'); ?></p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<p class="switch-field em_size_field">
								<?php
								if (isset($testimonial_settings['carousal_effect'])) {
									$carousal_effect = $testimonial_settings['carousal_effect'];
								} else {
									$carousal_effect = 'none';
								}
								?>
								<input type="radio" name="carousal_effect" id="carousal_effect1" value="none" <?php
								if ($carousal_effect == 'none') {
									echo 'checked=checked';
								}
								?>>
								<label
									for="carousal_effect1"><?php esc_html_e('None', 'testimonial-maker'); ?></label>
								<input type="radio" name="carousal_effect" id="carousal_effect2" value="fadeUp" <?php
								if ($carousal_effect == 'fadeUp') {
									echo 'checked=checked';
								}
								?>>
								<label
									for="carousal_effect2"><?php esc_html_e('Fadup', 'testimonial-maker'); ?></label>
							</p>
						</div>
					</div>



					<div class="col-md-4">
						<div class="ma_field_discription">
							<h5><?php esc_html_e('Auto Play', 'testimonial-maker'); ?></h5>
							<p><?php esc_html_e('Select Auto play yes or no for testimonial slide.', 'testimonial-maker'); ?>
							</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<p class="switch-field em_size_field">
								<?php
								if (isset($testimonial_settings['auto_play_carousel'])) {
									$auto_play_carousel = $testimonial_settings['auto_play_carousel'];
								} else {
									$auto_play_carousel = 'true';
								}
								?>
								<input type="radio" name="auto_play_carousel" id="auto_play_carousel1" value="true"
									<?php
									if ($auto_play_carousel == 'true') {
										echo 'checked=checked';
									}
									?>>
								<label
									for="auto_play_carousel1"><?php esc_html_e('Yes', 'testimonial-maker'); ?></label>
								<input type="radio" name="auto_play_carousel" id="auto_play_carousel2" value="false"
									<?php
									if ($auto_play_carousel == 'false') {
										echo 'checked=checked';
									}
									?>>
								<label
									for="auto_play_carousel2"><?php esc_html_e('No', 'testimonial-maker'); ?></label>
							</p>
						</div>
					</div>



					<div class="col-md-4">
						<div class="ma_field_discription">
							<h5><?php esc_html_e('Pagination Bullets', 'testimonial-maker'); ?></h5>
							<p><?php esc_html_e('Enable or disable pagination', 'testimonial-maker'); ?></p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<p class="switch-field em_size_field">
								<?php
								if (isset($testimonial_settings['pagination11'])) {
									$pagination11 = $testimonial_settings['pagination11'];
								} else {
									$pagination11 = 'false';
								}
								?>
								<input type="radio" name="pagination11" id="pagination1" value="true" <?php
								if ($pagination11 == 'true') {
									echo 'checked=checked';
								}
								?>>
								<label for="pagination1"><?php esc_html_e('Yes', 'testimonial-maker'); ?></label>
								<input type="radio" name="pagination11" id="pagination2" value="false" <?php
								if ($pagination11 == 'false') {
									echo 'checked=checked';
								}
								?>>
								<label for="pagination2"><?php esc_html_e('No', 'testimonial-maker'); ?></label>
							</p>
						</div>
					</div>



					<div class="col-md-4">
						<div class="ma_field_discription">
							<h5><?php esc_html_e('Testimonial Column Layout', 'testimonial-maker'); ?></h5>
							<p><?php esc_html_e('Select how many columns of testimonial you want to show', 'testimonial-maker'); ?>
							</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<p class="switch-field em_size_field">
								<?php
								if (isset($testimonial_settings['testimonial_column_layout'])) {
									$testimonial_column_layout = $testimonial_settings['testimonial_column_layout'];
								} else {
									$testimonial_column_layout = '1';
								}
								?>
								<input id="testimonial_column_layout" name="testimonial_column_layout"
									class="range-slider__range" style="width: 200px !important;" type="range"
									value="<?php echo esc_html($testimonial_column_layout); ?>" min="1" max="4"
									step="1" style="width: 300px !important; margin-left: 10px;">
								<span id="testimonial_column"
									class="range-slider__value"><?php echo esc_html($testimonial_column_layout); ?></span>
							</p>
						</div>
					</div>
				</div>


				<div class="bhoechie-tab-content">
					<h1><?php esc_html_e('Color Setting', 'testimonial-maker'); ?></h1>
					<hr>

					<div class="col-md-4">
						<div class="ma_field_discription">
							<h5><?php esc_html_e('Title Color Settings', 'testimonial-maker'); ?></h5>
							<p><?php esc_html_e('Change Testimonial Title [Name] color', 'testimonial-maker'); ?></p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<div class="custom-radios">
								<?php
								if (isset($testimonial_settings['title_color'])) {
									$title_color = $testimonial_settings['title_color'];
								} else {
									$title_color = '#000000';
								}
								?>
								<input type="radio" id="title_color_1" name="title_color" value="#000000" <?php
								if ($title_color == '#000000') {
									echo 'checked=checked';
								}
								?>>
								<label for="title_color_1">
									<span>
									</span>
								</label>
								<input type="radio" id="title_color_2" name="title_color" value="#ffffff" <?php
								if ($title_color == '#ffffff') {
									echo 'checked=checked';
								}
								?>>
								<label for="title_color_2">
									<span>
									</span>
								</label>
								<input type="radio" id="title_color_3" name="title_color" value="#1e73be" <?php
								if ($title_color == '#1e73be') {
									echo 'checked=checked';
								}
								?>>
								<label for="title_color_3">
									<span>
									</span>
								</label>
								<input type="radio" id="title_color_4" name="title_color" value="#dd3333" <?php
								if ($title_color == '#dd3333') {
									echo 'checked=checked';
								}
								?>>
								<label for="title_color_4">
									<span>
									</span>
								</label>
							</div>
						</div>
					</div>



					<div class="col-md-4">
						<div class="ma_field_discription">
							<h5><?php esc_html_e('Description Text Color', 'testimonial-maker'); ?></h5>
							<p><?php esc_html_e('Change Testimonial description text color.', 'testimonial-maker'); ?>
							</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<div class="custom-radios">
								<?php
								if (isset($testimonial_settings['description_color'])) {
									$description_color = $testimonial_settings['description_color'];
								} else {
									$description_color = '#000000';
								}
								?>
								<input type="radio" id="description_color1" name="description_color" value="#000000"
									<?php
									if ($description_color == '#000000') {
										echo 'checked=checked';
									}
									?>>
								<label for="description_color1">
									<span>
									</span>
								</label>
								<input type="radio" id="description_color2" name="description_color" value="#ffffff"
									<?php
									if ($description_color == '#ffffff') {
										echo 'checked=checked';
									}
									?>>
								<label for="description_color2">
									<span>
									</span>
								</label>
								<input type="radio" id="description_color3" name="description_color" value="#1e73be"
									<?php
									if ($description_color == '#1e73be') {
										echo 'checked=checked';
									}
									?>>
								<label for="description_color3">
									<span>
									</span>
								</label>
								<input type="radio" id="description_color4" name="description_color" value="#dd3333"
									<?php
									if ($description_color == '#dd3333') {
										echo 'checked=checked';
									}
									?>>
								<label for="description_color4">
									<span>
									</span>
								</label>
							</div>
						</div>
					</div>



					<div class="col-md-4">
						<div class="ma_field_discription">
							<h5><?php esc_html_e('Designation Text Color', 'testimonial-maker'); ?></h5>
							<p><?php esc_html_e('Change Testimonial Designation text color.', 'testimonial-maker'); ?>
							</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<div class="custom-radios">
								<?php
								if (isset($testimonial_settings['designation_color'])) {
									$designation_color = $testimonial_settings['designation_color'];
								} else {
									$designation_color = '#000000';
								}
								?>
								<input type="radio" id="designation_color1" name="designation_color" value="#000000"
									<?php
									if ($designation_color == '#000000') {
										echo 'checked=checked';
									}
									?>>
								<label for="designation_color1">
									<span>
									</span>
								</label>
								<input type="radio" id="designation_color2" name="designation_color" value="#ffffff"
									<?php
									if ($designation_color == '#ffffff') {
										echo 'checked=checked';
									}
									?>>
								<label for="designation_color2">
									<span>
									</span>
								</label>
								<input type="radio" id="designation_color3" name="designation_color" value="#1e73be"
									<?php
									if ($designation_color == '#1e73be') {
										echo 'checked=checked';
									}
									?>>
								<label for="designation_color3">
									<span>
									</span>
								</label>
								<input type="radio" id="designation_color4" name="designation_color" value="#dd3333"
									<?php
									if ($designation_color == '#dd3333') {
										echo 'checked=checked';
									}
									?>>
								<label for="designation_color4">
									<span>
									</span>
								</label>
							</div>
						</div>
					</div>
				</div>


				<div class="bhoechie-tab-content">
					<h1><?php esc_html_e('Advanced Design Settings', 'testimonial-maker'); ?></h1>
					<hr>

					<div class="row">
						<!-- Star Rating Color -->
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h5><?php esc_html_e('Star Rating Color', 'testimonial-maker'); ?></h5>
								<p><?php esc_html_e('Choose color for star ratings', 'testimonial-maker'); ?></p>
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field p-4">
								<?php
								if (isset($testimonial_settings['star_rating_color'])) {
									$star_rating_color = $testimonial_settings['star_rating_color'];
								} else {
									$star_rating_color = '#ffd700';
								}
								?>
								<input type="text" name="star_rating_color"
									value="<?php echo esc_attr($star_rating_color); ?>" class="color-picker"
									data-default-color="#ffd700" />
							</div>
						</div>
					</div>

					<div class="row">
						<!-- Box Shadow -->
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h5><?php esc_html_e('Box Shadow', 'testimonial-maker'); ?></h5>
								<p><?php esc_html_e('Enable shadow effect on testimonial cards', 'testimonial-maker'); ?>
								</p>
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field p-4">
								<?php
								if (isset($testimonial_settings['enable_box_shadow'])) {
									$enable_box_shadow = $testimonial_settings['enable_box_shadow'];
								} else {
									$enable_box_shadow = 'no';
								}
								?>
								<label><input type="radio" name="enable_box_shadow" value="yes" <?php checked($enable_box_shadow, 'yes'); ?>>
									<?php esc_html_e('Enable', 'testimonial-maker'); ?></label>
								<label><input type="radio" name="enable_box_shadow" value="no" <?php checked($enable_box_shadow, 'no'); ?>>
									<?php esc_html_e('Disable', 'testimonial-maker'); ?></label>
							</div>
						</div>
					</div>

					<div class="row">
						<!-- Border Radius -->
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h5><?php esc_html_e('Border Radius', 'testimonial-maker'); ?></h5>
								<p><?php esc_html_e('Set corner roundness (0-50px)', 'testimonial-maker'); ?></p>
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field p-4">
								<?php
								if (isset($testimonial_settings['border_radius'])) {
									$border_radius = $testimonial_settings['border_radius'];
								} else {
									$border_radius = '10';
								}
								?>
								<input id="border_radius" name="border_radius" class="range-slider__range" type="range"
									value="<?php echo esc_attr($border_radius); ?>" min="0" max="50" step="1"
									style="width: 300px !important; margin-left: 10px;">
								<span id="border_radius_value"
									class="range-slider__value"><?php echo esc_html($border_radius); ?>px</span>
							</div>
						</div>
					</div>

					<div class="row">
						<!-- Image Shape -->
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h5><?php esc_html_e('Image Shape', 'testimonial-maker'); ?></h5>
								<p><?php esc_html_e('Choose testimonial image shape', 'testimonial-maker'); ?></p>
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field p-4">
								<?php
								if (isset($testimonial_settings['image_shape'])) {
									$image_shape = $testimonial_settings['image_shape'];
								} else {
									$image_shape = 'circle';
								}
								?>
								<select name="image_shape" class="form-control" style="width: 300px;">
									<option value="circle" <?php selected($image_shape, 'circle'); ?>>
										<?php esc_html_e('Circle', 'testimonial-maker'); ?></option>
									<option value="square" <?php selected($image_shape, 'square'); ?>>
										<?php esc_html_e('Square', 'testimonial-maker'); ?></option>
									<option value="rounded" <?php selected($image_shape, 'rounded'); ?>>
										<?php esc_html_e('Rounded Square', 'testimonial-maker'); ?></option>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<!-- Hover Effect -->
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h5><?php esc_html_e('Hover Effect', 'testimonial-maker'); ?></h5>
								<p><?php esc_html_e('Choose hover animation effect', 'testimonial-maker'); ?></p>
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field p-4">
								<?php
								if (isset($testimonial_settings['hover_effect'])) {
									$hover_effect = $testimonial_settings['hover_effect'];
								} else {
									$hover_effect = 'none';
								}
								?>
								<select name="hover_effect" class="form-control" style="width: 300px;">
									<option value="none" <?php selected($hover_effect, 'none'); ?>>
										<?php esc_html_e('None', 'testimonial-maker'); ?></option>
									<option value="lift" <?php selected($hover_effect, 'lift'); ?>>
										<?php esc_html_e('Lift Up', 'testimonial-maker'); ?></option>
									<option value="scale" <?php selected($hover_effect, 'scale'); ?>>
										<?php esc_html_e('Scale', 'testimonial-maker'); ?></option>
									<option value="shadow" <?php selected($hover_effect, 'shadow'); ?>>
										<?php esc_html_e('Shadow Grow', 'testimonial-maker'); ?></option>
									<option value="glow" <?php selected($hover_effect, 'glow'); ?>>
										<?php esc_html_e('Glow', 'testimonial-maker'); ?></option>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<!-- Typography - Font Size -->
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h5><?php esc_html_e('Font Size', 'testimonial-maker'); ?></h5>
								<p><?php esc_html_e('Set testimonial text font size (12-24px)', 'testimonial-maker'); ?>
								</p>
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field p-4">
								<?php
								if (isset($testimonial_settings['font_size'])) {
									$font_size = $testimonial_settings['font_size'];
								} else {
									$font_size = '16';
								}
								?>
								<input id="font_size" name="font_size" class="range-slider__range" type="range"
									value="<?php echo esc_attr($font_size); ?>" min="12" max="24" step="1"
									style="width: 300px !important; margin-left: 10px;">
								<span id="font_size_value"
									class="range-slider__value"><?php echo esc_html($font_size); ?>px</span>
							</div>
						</div>
					</div>

					<div class="row">
						<!-- Entrance Animation -->
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h5><?php esc_html_e('Entrance Animation', 'testimonial-maker'); ?></h5>
								<p><?php esc_html_e('Choose animation when testimonials appear', 'testimonial-maker'); ?>
								</p>
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field p-4">
								<?php
								if (isset($testimonial_settings['entrance_animation'])) {
									$entrance_animation = $testimonial_settings['entrance_animation'];
								} else {
									$entrance_animation = 'none';
								}
								?>
								<select name="entrance_animation" class="form-control" style="width: 300px;">
									<option value="none" <?php selected($entrance_animation, 'none'); ?>>
										<?php esc_html_e('None', 'testimonial-maker'); ?></option>
									<option value="fade" <?php selected($entrance_animation, 'fade'); ?>>
										<?php esc_html_e('Fade In', 'testimonial-maker'); ?></option>
									<option value="slide-up" <?php selected($entrance_animation, 'slide-up'); ?>>
										<?php esc_html_e('Slide Up', 'testimonial-maker'); ?></option>
									<option value="slide-left" <?php selected($entrance_animation, 'slide-left'); ?>>
										<?php esc_html_e('Slide Left', 'testimonial-maker'); ?></option>
									<option value="slide-right" <?php selected($entrance_animation, 'slide-right'); ?>><?php esc_html_e('Slide Right', 'testimonial-maker'); ?></option>
									<option value="zoom" <?php selected($entrance_animation, 'zoom'); ?>>
										<?php esc_html_e('Zoom In', 'testimonial-maker'); ?></option>
									<option value="flip" <?php selected($entrance_animation, 'flip'); ?>>
										<?php esc_html_e('Flip', 'testimonial-maker'); ?></option>
									<option value="bounce" <?php selected($entrance_animation, 'bounce'); ?>>
										<?php esc_html_e('Bounce', 'testimonial-maker'); ?></option>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<!-- Animation Speed -->
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h5><?php esc_html_e('Animation Speed', 'testimonial-maker'); ?></h5>
								<p><?php esc_html_e('Set animation duration (0.3-2s)', 'testimonial-maker'); ?></p>
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field p-4">
								<?php
								if (isset($testimonial_settings['animation_speed'])) {
									$animation_speed = $testimonial_settings['animation_speed'];
								} else {
									$animation_speed = '0.8';
								}
								?>
								<input id="animation_speed" name="animation_speed" class="range-slider__range"
									type="range" value="<?php echo esc_attr($animation_speed); ?>" min="0.3" max="2"
									step="0.1" style="width: 300px !important; margin-left: 10px;">
								<span id="animation_speed_value"
									class="range-slider__value"><?php echo esc_html($animation_speed); ?>s</span>
							</div>
						</div>
					</div>

					<div class="row">
						<!-- Lazy Loading -->
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h5><?php esc_html_e('Lazy Loading', 'testimonial-maker'); ?></h5>
								<p><?php esc_html_e('Load images only when visible', 'testimonial-maker'); ?></p>
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field p-4">
								<?php
								if (isset($testimonial_settings['enable_lazy_load'])) {
									$enable_lazy_load = $testimonial_settings['enable_lazy_load'];
								} else {
									$enable_lazy_load = 'yes';
								}
								?>
								<label><input type="radio" name="enable_lazy_load" value="yes" <?php checked($enable_lazy_load, 'yes'); ?>>
									<?php esc_html_e('Enable', 'testimonial-maker'); ?></label>
								<label><input type="radio" name="enable_lazy_load" value="no" <?php checked($enable_lazy_load, 'no'); ?>>
									<?php esc_html_e('Disable', 'testimonial-maker'); ?></label>
							</div>
						</div>
					</div>

					<div class="row">
						<!-- Video Playback Mode -->
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h5><?php esc_html_e('Video Playback Mode', 'testimonial-maker'); ?></h5>
								<p><?php esc_html_e('Choose how video testimonials should play (Template 6)', 'testimonial-maker'); ?>
								</p>
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field p-4">
								<?php
								$video_playback = get_option('testimonial_video_playback', 'external');
								?>
								<label style="display: block; margin-bottom: 10px;">
									<input type="radio" name="testimonial_video_playback" value="inline" <?php checked($video_playback, 'inline'); ?>>
									<?php esc_html_e('Play Inline (Embed video in page)', 'testimonial-maker'); ?>
								</label>
								<label style="display: block;">
									<input type="radio" name="testimonial_video_playback" value="external" <?php checked($video_playback, 'external'); ?>>
									<?php esc_html_e('Open External (Open YouTube/Vimeo in new tab)', 'testimonial-maker'); ?>
								</label>
								<p style="margin-top: 10px; font-size: 12px; color: #666;">
									<strong><?php esc_html_e('Inline:', 'testimonial-maker'); ?></strong> <?php esc_html_e('Video plays directly on your page', 'testimonial-maker'); ?><br>
									<strong><?php esc_html_e('External:', 'testimonial-maker'); ?></strong> <?php esc_html_e('Opens video on YouTube/Vimeo website', 'testimonial-maker'); ?>
								</p>
							</div>
						</div>
					</div>

				</div>

				<div class="bhoechie-tab-content">
					<h1><?php esc_html_e('Custom Css', 'testimonial-maker'); ?></h1>
					<hr>

					<div class="col-md-4">
						<div class="ma_field_discription">
							<h5><?php esc_html_e('Custom Css', 'testimonial-maker'); ?></h5>
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field p-4">
							<p class="switch-field em_size_field">
								<?php
								if (isset($testimonial_settings['maker_custom_css'])) {
									$maker_custom_css = $testimonial_settings['maker_custom_css'];
								} else {
									$maker_custom_css = '';
								}
								?>
								<textarea name="maker_custom_css" id="maker_custom_css" style="width: 50%;" rows="5"
									placeholder="Type direct CSS code here. Don't use <style>...</style> tag."><?php echo $maker_custom_css; ?></textarea>
							</p>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>

	<!--end-->
	<input type="hidden" id="snow_action" name="snow_action" value="save_tmlsetting">
	<div id="loading_icon" name="loading_icon" style="display:none; text-align: center">
		<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
		<span class=""><?php esc_html_e('Please wait...', 'testimonial-maker'); ?></span>
	</div>
	<div class="p-4" style="text-align:center">
		<button type="button" id="save_tmlsetting" class="btn btn-primary btn-lg"
			onclick="TmlSaveSettings();"><?php esc_html_e('Save Settings', 'testimonial-maker'); ?></button>
	</div>
</form>
<?php
// Default settings
register_activation_hook(__FILE__, 'testimonial_defaultsettings');
function testimonial_defaultsettings()
{
	$tmldefaultsettings = array(
		'testimonial_carousel_design' => '1',
		'carousal_effect' => 'none',
		'auto_play_carousel' => 'true',
		'title_color' => '#000000',
		'description_color' => '#000000',
		'designation_color' => '#000000',
		'pagination11' => 'false',
		'maker_custom_css' => '',
		'testimonial_column_layout' => '1',
		'star_rating_color' => '#ffd700',
		'enable_box_shadow' => 'yes',
		'border_radius' => '10',
		'image_shape' => 'circle',
		'hover_effect' => 'lift',
		'font_size' => '16',
		'entrance_animation' => 'fade',
		'animation_speed' => '0.8',
		'enable_lazy_load' => 'yes',
	);
	add_option('testimonial_settings', $tmldefaultsettings);
}

// save settings
if (isset($_POST['tml_setting_action'])) {
	$tml_save_nonce_value = $_POST['security'];
	if (wp_verify_nonce($tml_save_nonce_value, 'tml_save_nonce')) {

		$testimonial_carousel_design = sanitize_text_field($_POST['testimonial_carousel_design']);
		$carousal_effect = sanitize_text_field($_POST['carousal_effect']);
		$auto_play_carousel = sanitize_text_field($_POST['auto_play_carousel']);
		$title_color = sanitize_text_field($_POST['title_color']);
		$description_color = sanitize_text_field($_POST['description_color']);
		$designation_color = sanitize_text_field($_POST['designation_color']);
		$pagination11 = sanitize_text_field($_POST['pagination11']);
		$maker_custom_css = sanitize_text_field($_POST['maker_custom_css']);
		$testimonial_column_layout = sanitize_text_field($_POST['testimonial_column_layout']);
		$star_rating_color = isset($_POST['star_rating_color']) ? sanitize_text_field($_POST['star_rating_color']) : '#ffd700';
		$enable_box_shadow = isset($_POST['enable_box_shadow']) ? sanitize_text_field($_POST['enable_box_shadow']) : 'yes';
		$border_radius = isset($_POST['border_radius']) ? sanitize_text_field($_POST['border_radius']) : '10';
		$image_shape = isset($_POST['image_shape']) ? sanitize_text_field($_POST['image_shape']) : 'circle';
		$hover_effect = isset($_POST['hover_effect']) ? sanitize_text_field($_POST['hover_effect']) : 'lift';
		$font_size = isset($_POST['font_size']) ? sanitize_text_field($_POST['font_size']) : '16';
		$entrance_animation = isset($_POST['entrance_animation']) ? sanitize_text_field($_POST['entrance_animation']) : 'fade';
		$animation_speed = isset($_POST['animation_speed']) ? sanitize_text_field($_POST['animation_speed']) : '0.8';
		$enable_lazy_load = isset($_POST['enable_lazy_load']) ? sanitize_text_field($_POST['enable_lazy_load']) : 'yes';

		// Video playback setting (separate option)
		if (isset($_POST['testimonial_video_playback'])) {
			update_option('testimonial_video_playback', sanitize_text_field($_POST['testimonial_video_playback']));
		}

		$testimonial_settings = array(
			'testimonial_carousel_design' => $testimonial_carousel_design,
			'carousal_effect' => $carousal_effect,
			'auto_play_carousel' => $auto_play_carousel,
			'title_color' => $title_color,
			'description_color' => $description_color,
			'designation_color' => $designation_color,
			'pagination11' => $pagination11,
			'maker_custom_css' => $maker_custom_css,
			'testimonial_column_layout' => $testimonial_column_layout,
			'star_rating_color' => $star_rating_color,
			'enable_box_shadow' => $enable_box_shadow,
			'border_radius' => $border_radius,
			'image_shape' => $image_shape,
			'hover_effect' => $hover_effect,
			'font_size' => $font_size,
			'entrance_animation' => $entrance_animation,
			'animation_speed' => $animation_speed,
			'enable_lazy_load' => $enable_lazy_load,
		);
		update_option('testimonial_settings', $testimonial_settings);
	}
} // end of save if
// end of setting page fuction
?>
<script>
	function TmlSaveSettings() {
		jQuery("#loading_icon").show();
		jQuery("#save_tmlsetting").hide();
		jQuery.ajax({
			dataType: 'html',
			type: 'POST',
			url: location.href,
			cache: false,
			data: jQuery('#testimonial_form_setting').serialize() + '&tml_setting_action=save_tmlsetting' + '&security=' + '<?php echo esc_js(wp_create_nonce('tml_save_nonce')); ?>',
			complete: function () { },
			success: function (data) {
				jQuery("#loading_icon").hide();
				jQuery("#save_tmlsetting").show();
			}
		});
	}

	// start pulse on page load
	function pulseEff() {
		jQuery('#shortcode').fadeOut(600).fadeIn(600);
	};
	var Interval;
	Interval = setInterval(pulseEff, 1500);

	// stop pulse
	function pulseOff() {
		clearInterval(Interval);
	}
	// start pulse
	function pulseStart() {
		Interval = setInterval(pulseEff, 1500);
	}

	// testimonial img start
	var testimonial_carousel_design = jQuery("#testimonial_carousel_design option:selected").val();
	jQuery(".testimonial_img_preview img, .testimonial_img_preview div").hide();
	jQuery(".temp_" + testimonial_carousel_design.replace('template', '')).show();

	jQuery(document).ready(function () {
		jQuery('#testimonial_carousel_design').change(function () {
			var testimonial_carousel_design = jQuery('#testimonial_carousel_design').val();
			jQuery(".testimonial_img_preview img, .testimonial_img_preview div").hide();
			jQuery(".temp_" + testimonial_carousel_design.replace('template', '')).show();
		});
	});

	///range bar
	var testimonial_column_layout = document.getElementById("testimonial_column_layout");
	var testimonial_column = document.getElementById("testimonial_column");
	testimonial_column.innerHTML = testimonial_column_layout.value;
	testimonial_column_layout.oninput = function () {
		testimonial_column.innerHTML = this.value;
	}

	// Border radius range slider
	var border_radius = document.getElementById("border_radius");
	if (border_radius) {
		var border_radius_value = document.getElementById("border_radius_value");
		border_radius_value.innerHTML = border_radius.value + 'px';
		border_radius.oninput = function () {
			border_radius_value.innerHTML = this.value + 'px';
		}
	}

	// Font size range slider
	var font_size = document.getElementById("font_size");
	if (font_size) {
		var font_size_value = document.getElementById("font_size_value");
		font_size_value.innerHTML = font_size.value + 'px';
		font_size.oninput = function () {
			font_size_value.innerHTML = this.value + 'px';
		}
	}

	// Animation speed range slider
	var animation_speed = document.getElementById("animation_speed");
	if (animation_speed) {
		var animation_speed_value = document.getElementById("animation_speed_value");
		animation_speed_value.innerHTML = animation_speed.value + 's';
		animation_speed.oninput = function () {
			animation_speed_value.innerHTML = this.value + 's';
		}
	}

	// Initialize WordPress Color Picker
	jQuery(document).ready(function ($) {
		if (typeof $.fn.wpColorPicker !== 'undefined') {
			$('.color-picker').wpColorPicker();
		}
	});

	// tab
	jQuery("div.bhoechie-tab-menu>div.list-group>a").click(function (e) {
		e.preventDefault();
		jQuery(this).siblings('a.active').removeClass("active");
		jQuery(this).addClass("active");
		var index = jQuery(this).index();
		jQuery("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
		jQuery("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
	});
</script>