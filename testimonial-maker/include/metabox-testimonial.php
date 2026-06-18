<?php
/**
 * Testimonial Post Meta Fields Metabox Layout
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

wp_enqueue_style('tml-mui-admin-css', TML_PLUGIN_URL . 'assets/css/tml-mui-admin.css', array(), TML_PLUGIN_VER);
wp_enqueue_style('font-awesome', TML_PLUGIN_URL . 'assets/css/font-awesome.min.css', array(), TML_PLUGIN_VER);

//load settings
$testimonial_post_settings = get_post_meta($post->ID, 'awl_testimonial' . $post->ID, true);

$website_link = isset($testimonial_post_settings['website_link']) ? $testimonial_post_settings['website_link'] : "";
$designation = isset($testimonial_post_settings['designation']) ? $testimonial_post_settings['designation'] : "";
$star_rating = isset($testimonial_post_settings['star_rating']) ? $testimonial_post_settings['star_rating'] : "0";
?>
<style>
	.tml-meta-box-wrap {
		font-family: var(--tml-font-family);
		color: var(--tml-text);
		background: #fff;
		padding: 15px 5px;
	}

	.tml-meta-box-wrap .tml-mui-form-group {
		margin-bottom: 24px;
		max-width: 600px;
	}

	.tml-meta-box-wrap .tml-mui-input {
		width: 100%;
		box-sizing: border-box;
	}

	.tml-social-row {
		display: flex;
		gap: 12px;
		margin-bottom: 12px;
		align-items: center;
		max-width: 600px;
	}

	.tml-social-row select.tml-mui-input {
		flex: 0 0 160px;
		height: 42px;
		-webkit-appearance: none !important;
		-moz-appearance: none !important;
		appearance: none !important;
		background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23707070%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E") !important;
		background-repeat: no-repeat !important;
		background-position: right 12px center !important;
		background-size: 12px !important;
		padding-right: 32px !important;
		cursor: pointer !important;
		border: 1px solid rgba(0, 0, 0, 0.23) !important;
		border-radius: 4px !important;
		background-color: #fff !important;
	}

	.tml-social-row input.tml-mui-input {
		flex: 1;
		height: 42px;
	}

	.tml-social-row .tml-remove-row {
		background: #f44336;
		color: #fff;
		border: none;
		width: 42px;
		height: 42px;
		border-radius: 4px;
		cursor: pointer;
		font-size: 16px;
		display: flex;
		align-items: center;
		justify-content: center;
		transition: background-color 0.2s;
	}

	.tml-social-row .tml-remove-row:hover {
		background: #d32f2f;
	}

	.tml-star-rating span {
		transition: color 0.2s, transform 0.2s;
	}

	.tml-star-rating span:hover {
		transform: scale(1.15);
	}
</style>

<div class="tml-meta-box-wrap">
	<!-- Client Website URL -->
	<div class="tml-mui-form-group">
		<label class="tml-mui-label"
			for="website_link"><?php esc_html_e('Client Website URL', 'testimonial-maker'); ?></label>
		<input type="text" class="tml-mui-input" id="website_link" name="website_link"
			value="<?php echo esc_attr($website_link); ?>" placeholder="https://example.com" />
	</div>

	<!-- Client Designation -->
	<div class="tml-mui-form-group">
		<label class="tml-mui-label"
			for="designation"><?php esc_html_e('Client Designation', 'testimonial-maker'); ?></label>
		<input type="text" class="tml-mui-input" id="designation" name="designation"
			value="<?php echo esc_attr($designation); ?>" placeholder="CEO, Company Name" />
	</div>

	<!-- Video Testimonial URL (PRO Locked) -->
	<div class="tml-mui-form-group" style="position: relative; max-width: 600px;">
		<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
			<label class="tml-mui-label"
				style="margin: 0;"><?php esc_html_e('Video Testimonial URL (YouTube/Vimeo)', 'testimonial-maker'); ?></label>
			<span
				style="background: #d63638; color: #fff; font-size: 10px; font-weight: bold; padding: 2px 6px; border-radius: 4px;">PRO</span>
		</div>
		<input type="text" class="tml-mui-input" value="" placeholder="https://www.youtube.com/watch?v=..." disabled
			style="background-color: #f6f7f7 !important;" />
		<div class="tml-mui-description" style="margin-top: 6px; line-height: 1.5;">
			<strong><?php esc_html_e('Supported formats:', 'testimonial-maker'); ?></strong><br>
			• YouTube: <code>https://www.youtube.com/watch?v=VIDEO_ID</code>
			<?php esc_html_e('or', 'testimonial-maker'); ?> <code>https://youtu.be/VIDEO_ID</code><br>
			• Vimeo: <code>https://vimeo.com/VIDEO_ID</code>
		</div>
		<div style="margin-top: 8px; font-size: 12px; color: #c53030; font-weight: 500; font-family: sans-serif;">
			📣 <?php esc_html_e('Video Testimonials is a Premium Feature.', 'testimonial-maker'); ?>
			<a href="https://awplife.com/demo/testimonial-premium/" target="_blank"
				style="color: #2563eb; text-decoration: underline; font-weight: 600;"><?php esc_html_e('Get PRO Version ★', 'testimonial-maker'); ?></a>
		</div>
	</div>

	<!-- Star Rating -->
	<div class="tml-mui-form-group">
		<label class="tml-mui-label"><?php esc_html_e('Star Rating', 'testimonial-maker'); ?></label>
		<div style="display:flex; align-items:center; gap:16px;">
			<input type="hidden" name="star_rating" id="star_rating" value="<?php echo esc_attr($star_rating); ?>">
			<span class="tml-star-rating" style="cursor: pointer; display: inline-flex; gap: 4px;">
				<?php for ($i = 1; $i <= 5; $i++): ?>
					<span class="dashicons dashicons-star-filled star" data-val="<?php echo esc_attr($i); ?>"
						style="font-size:32px; width:32px; height:32px; color: <?php echo ($i <= $star_rating) ? '#ffb600' : '#e0e0e0'; ?>;"></span>
				<?php endfor; ?>
			</span>
			<span id="star-rating-label"
				style="font-weight:600; color:rgba(0,0,0,0.54); font-size:14px;"><?php echo ($star_rating > 0) ? esc_html($star_rating) . ' Stars' : 'No Rating'; ?></span>
		</div>
		<div class="tml-mui-description">
			<?php esc_html_e('Click on the stars to select a rating', 'testimonial-maker'); ?>
		</div>
	</div>

	<!-- SOCIAL MEDIA (PRO Locked) -->
	<div class="tml-mui-form-group" style="margin-bottom:0; position: relative;">
		<div
			style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; max-width: 600px;">
			<label class="tml-mui-label"
				style="margin: 0;"><?php esc_html_e('SOCIAL MEDIA PROFILES', 'testimonial-maker'); ?></label>
			<span
				style="background: #d63638; color: #fff; font-size: 10px; font-weight: bold; padding: 2px 6px; border-radius: 4px;">PRO</span>
		</div>

		<div style="pointer-events: none; opacity: 0.65;">
			<div class="tml-social-row" style="margin-bottom: 8px;">
				<select class="tml-mui-input" disabled style="background-color: #f6f7f7 !important;">
					<option>Facebook</option>
				</select>
				<input type="url" class="tml-mui-input" placeholder="Profile URL" value="https://facebook.com/username"
					disabled />
				<button type="button" class="tml-remove-row" style="background: #ccc; cursor: not-allowed;" disabled><i
						class="fa fa-trash"></i></button>
			</div>

			<button type="button" class="tml-mui-btn" disabled
				style="border: 1px solid #ccc; color: #888; background: transparent; padding: 8px 16px; margin-top: 8px; font-weight:600; text-transform:none; cursor: not-allowed;">
				<i class="fa fa-plus" style="margin-right:8px;"></i>
				<?php esc_html_e('Add Social Profile', 'testimonial-maker'); ?>
			</button>
		</div>

		<div style="margin-top: 8px; font-size: 12px; color: #c53030; font-weight: 500; font-family: sans-serif;">
			📣 <?php esc_html_e('Social Media Profiles is a Premium Feature.', 'testimonial-maker'); ?>
			<a href="https://awplife.com/demo/testimonial-premium/" target="_blank"
				style="color: #2563eb; text-decoration: underline; font-weight: 600;"><?php esc_html_e('Get PRO Version ★', 'testimonial-maker'); ?></a>
		</div>
	</div>

	<script>
		jQuery(document).ready(function ($) {
			// Star Rating
			$('.tml-star-rating .star').on('click', function () {
				var val = $(this).data('val');
				$('#star_rating').val(val);
				$('#star-rating-label').text(val + ' Stars');
				$(this).parent().children('.star').each(function () {
					if ($(this).data('val') <= val) $(this).css('color', '#ffb600');
					else $(this).css('color', '#e0e0e0');
				});
			});
		});
	</script>
</div>
<?php
// syntax: wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' );
wp_nonce_field('tml_save_settings', 'tml_save_nonce');
