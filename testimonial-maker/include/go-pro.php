<?php
/**
 * Go Pro Page Callback Layout
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="wrap" style="background:#fff; padding:40px; border:1px solid #ccd0d4; margin-top:20px; max-width:900px; border-radius:8px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
	<div style="text-align: center; margin-bottom: 40px;">
		<h1 style="color:#2271b1; margin-top:0; font-size:32px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
			<?php esc_html_e('Upgrade to Testimonial Premium! ★', 'testimonial-maker'); ?>
		</h1>
		<p style="font-size:17px; line-height:1.6; color:#50575e; max-width: 700px; margin: 15px auto 0;">
			<?php esc_html_e('Unlock the full potential of your testimonials! Upgrading to Premium gets you access to all 17 stunning design templates, custom form builder, analytics dashboard, CSV import/export, video testimonials, advanced typography settings, and priority support.', 'testimonial-maker'); ?>
		</p>
	</div>

	<hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 30px 0;">

	<h2 style="font-size:22px; color:#1e293b; margin-bottom: 20px; text-align: center; font-weight: 600;">
		<?php esc_html_e('Free vs Premium Features Comparison', 'testimonial-maker'); ?>
	</h2>

	<div style="overflow-x: auto; margin-bottom: 40px; border: 1px solid #e2e8f0; border-radius: 8px;">
		<table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 15px;">
			<thead>
				<tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
					<th style="padding: 15px 20px; font-weight: 600; color: #1e293b;"><?php esc_html_e('Features', 'testimonial-maker'); ?></th>
					<th style="padding: 15px 20px; font-weight: 600; color: #64748b; width: 180px; text-align: center;"><?php esc_html_e('Free Version (Lite)', 'testimonial-maker'); ?></th>
					<th style="padding: 15px 20px; font-weight: 600; color: #d63638; width: 180px; text-align: center; background: rgba(214, 54, 56, 0.03);"><?php esc_html_e('Premium Version (PRO)', 'testimonial-maker'); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr style="border-bottom: 1px solid #edf2f7;">
					<td style="padding: 15px 20px; font-weight: 500; color: #334155;"><strong><?php esc_html_e('Design Templates', 'testimonial-maker'); ?></strong><div style="font-size: 12px; color: #64748b; margin-top: 3px; font-weight: 400;"><?php esc_html_e('Stunning layouts for your testimonials', 'testimonial-maker'); ?></div></td>
					<td style="padding: 15px 20px; text-align: center; color: #64748b;"><?php esc_html_e('3 Themes', 'testimonial-maker'); ?></td>
					<td style="padding: 15px 20px; text-align: center; color: #d63638; font-weight: 600; background: rgba(214, 54, 56, 0.03);"><?php esc_html_e('17 Themes', 'testimonial-maker'); ?></td>
				</tr>
				<tr style="border-bottom: 1px solid #edf2f7;">
					<td style="padding: 15px 20px; font-weight: 500; color: #334155;"><strong><?php esc_html_e('Layout Presets', 'testimonial-maker'); ?></strong><div style="font-size: 12px; color: #64748b; margin-top: 3px; font-weight: 400;"><?php esc_html_e('Slider, Grid, Masonry, Filter options', 'testimonial-maker'); ?></div></td>
					<td style="padding: 15px 20px; text-align: center; color: #64748b;"><?php esc_html_e('Slider & Grid', 'testimonial-maker'); ?></td>
					<td style="padding: 15px 20px; text-align: center; color: #d63638; font-weight: 600; background: rgba(214, 54, 56, 0.03);"><?php esc_html_e('Slider, Grid, Masonry, List & Category Filter', 'testimonial-maker'); ?></td>
				</tr>
				<tr style="border-bottom: 1px solid #edf2f7;">
					<td style="padding: 15px 20px; font-weight: 500; color: #334155;"><strong><?php esc_html_e('Frontend Form Builder', 'testimonial-maker'); ?></strong><div style="font-size: 12px; color: #64748b; margin-top: 3px; font-weight: 400;"><?php esc_html_e('Customize layout with drag-and-drop fields', 'testimonial-maker'); ?></div></td>
					<td style="padding: 15px 20px; text-align: center; color: #64748b;"><?php esc_html_e('Standard Fields (Name, Rating, Content, Designation, Website, Image, Category)', 'testimonial-maker'); ?></td>
					<td style="padding: 15px 20px; text-align: center; color: #d63638; font-weight: 600; background: rgba(214, 54, 56, 0.03);"><?php esc_html_e('Premium Fields + Video Record, Social Profiles, and Google reCAPTCHA', 'testimonial-maker'); ?></td>
				</tr>
				<tr style="border-bottom: 1px solid #edf2f7;">
					<td style="padding: 15px 20px; font-weight: 500; color: #334155;"><strong><?php esc_html_e('Video Testimonials', 'testimonial-maker'); ?></strong><div style="font-size: 12px; color: #64748b; margin-top: 3px; font-weight: 400;"><?php esc_html_e('YouTube, Vimeo and custom video reviews', 'testimonial-maker'); ?></div></td>
					<td style="padding: 15px 20px; text-align: center; color: #94a3b8; font-size: 18px;">❌</td>
					<td style="padding: 15px 20px; text-align: center; color: #22c55e; font-size: 18px; background: rgba(214, 54, 56, 0.03);">✔️</td>
				</tr>
				<tr style="border-bottom: 1px solid #edf2f7;">
					<td style="padding: 15px 20px; font-weight: 500; color: #334155;"><strong><?php esc_html_e('Analytics & Performance Tracking', 'testimonial-maker'); ?></strong><div style="font-size: 12px; color: #64748b; margin-top: 3px; font-weight: 400;"><?php esc_html_e('Detailed impressions, clicks, conversions reports', 'testimonial-maker'); ?></div></td>
					<td style="padding: 15px 20px; text-align: center; color: #94a3b8; font-size: 18px;">❌</td>
					<td style="padding: 15px 20px; text-align: center; color: #22c55e; font-size: 18px; background: rgba(214, 54, 56, 0.03);">✔️</td>
				</tr>
				<tr style="border-bottom: 1px solid #edf2f7;">
					<td style="padding: 15px 20px; font-weight: 500; color: #334155;"><strong><?php esc_html_e('CSV Import & Export', 'testimonial-maker'); ?></strong><div style="font-size: 12px; color: #64748b; margin-top: 3px; font-weight: 400;"><?php esc_html_e('Bulk migrate testimonials instantly', 'testimonial-maker'); ?></div></td>
					<td style="padding: 15px 20px; text-align: center; color: #94a3b8; font-size: 18px;">❌</td>
					<td style="padding: 15px 20px; text-align: center; color: #22c55e; font-size: 18px; background: rgba(214, 54, 56, 0.03);">✔️</td>
				</tr>
				<tr style="border-bottom: 1px solid #edf2f7;">
					<td style="padding: 15px 20px; font-weight: 500; color: #334155;"><strong><?php esc_html_e('SEO Schema Rich Snippets', 'testimonial-maker'); ?></strong><div style="font-size: 12px; color: #64748b; margin-top: 3px; font-weight: 400;"><?php esc_html_e('Show aggregate rating stars in Google search results', 'testimonial-maker'); ?></div></td>
					<td style="padding: 15px 20px; text-align: center; color: #94a3b8; font-size: 18px;">❌</td>
					<td style="padding: 15px 20px; text-align: center; color: #22c55e; font-size: 18px; background: rgba(214, 54, 56, 0.03);">✔️</td>
				</tr>
				<tr style="border-bottom: 1px solid #edf2f7;">
					<td style="padding: 15px 20px; font-weight: 500; color: #334155;"><strong><?php esc_html_e('Advanced Typography', 'testimonial-maker'); ?></strong><div style="font-size: 12px; color: #64748b; margin-top: 3px; font-weight: 400;"><?php esc_html_e('Google fonts, size, spacing and line-height settings', 'testimonial-maker'); ?></div></td>
					<td style="padding: 15px 20px; text-align: center; color: #94a3b8; font-size: 18px;">❌</td>
					<td style="padding: 15px 20px; text-align: center; color: #22c55e; font-size: 18px; background: rgba(214, 54, 56, 0.03);">✔️</td>
				</tr>
				<tr style="border-bottom: 1px solid #edf2f7;">
					<td style="padding: 15px 20px; font-weight: 500; color: #334155;"><strong><?php esc_html_e('Advanced Navigation Options', 'testimonial-maker'); ?></strong><div style="font-size: 12px; color: #64748b; margin-top: 3px; font-weight: 400;"><?php esc_html_e('Choose from 9 arrow positions and 5 chevron styles', 'testimonial-maker'); ?></div></td>
					<td style="padding: 15px 20px; text-align: center; color: #64748b;"><?php esc_html_e('Basic positions & styles', 'testimonial-maker'); ?></td>
					<td style="padding: 15px 20px; text-align: center; color: #22c55e; font-size: 18px; background: rgba(214, 54, 56, 0.03);">✔️</td>
				</tr>
				<tr style="border-bottom: 1px solid #edf2f7;">
					<td style="padding: 15px 20px; font-weight: 500; color: #334155;"><strong><?php esc_html_e('Live Ajax Category Filters', 'testimonial-maker'); ?></strong><div style="font-size: 12px; color: #64748b; margin-top: 3px; font-weight: 400;"><?php esc_html_e('Frontend tab filters to filter testimonials instantly', 'testimonial-maker'); ?></div></td>
					<td style="padding: 15px 20px; text-align: center; color: #94a3b8; font-size: 18px;">❌</td>
					<td style="padding: 15px 20px; text-align: center; color: #22c55e; font-size: 18px; background: rgba(214, 54, 56, 0.03);">✔️</td>
				</tr>

				<tr style="border-bottom: 1px solid #edf2f7;">
					<td style="padding: 15px 20px; font-weight: 500; color: #334155;"><strong><?php esc_html_e('Random Sorting Order', 'testimonial-maker'); ?></strong><div style="font-size: 12px; color: #64748b; margin-top: 3px; font-weight: 400;"><?php esc_html_e('Randomize testimonials order dynamically on page load', 'testimonial-maker'); ?></div></td>
					<td style="padding: 15px 20px; text-align: center; color: #94a3b8; font-size: 18px;">❌</td>
					<td style="padding: 15px 20px; text-align: center; color: #22c55e; font-size: 18px; background: rgba(214, 54, 56, 0.03);">✔️</td>
				</tr>
				<tr style="border-bottom: 1px solid #edf2f7;">
					<td style="padding: 15px 20px; font-weight: 500; color: #334155;"><strong><?php esc_html_e('Star Rating Customizations', 'testimonial-maker'); ?></strong><div style="font-size: 12px; color: #64748b; margin-top: 3px; font-weight: 400;"><?php esc_html_e('Change star colors, alignment and styling size', 'testimonial-maker'); ?></div></td>
					<td style="padding: 15px 20px; text-align: center; color: #64748b;"><?php esc_html_e('Basic rating stars', 'testimonial-maker'); ?></td>
					<td style="padding: 15px 20px; text-align: center; color: #22c55e; font-size: 18px; background: rgba(214, 54, 56, 0.03);">✔️</td>
				</tr>

				<tr style="border-bottom: 1px solid #edf2f7;">
					<td style="padding: 15px 20px; font-weight: 500; color: #334155;"><strong><?php esc_html_e('Social Profiles Integration', 'testimonial-maker'); ?></strong><div style="font-size: 12px; color: #64748b; margin-top: 3px; font-weight: 400;"><?php esc_html_e('Link clients Facebook, LinkedIn and Twitter profiles', 'testimonial-maker'); ?></div></td>
					<td style="padding: 15px 20px; text-align: center; color: #94a3b8; font-size: 18px;">❌</td>
					<td style="padding: 15px 20px; text-align: center; color: #22c55e; font-size: 18px; background: rgba(214, 54, 56, 0.03);">✔️</td>
				</tr>

				<tr style="border-bottom: 1px solid #edf2f7;">
					<td style="padding: 15px 20px; font-weight: 500; color: #334155;"><strong><?php esc_html_e('Google reCAPTCHA v2', 'testimonial-maker'); ?></strong><div style="font-size: 12px; color: #64748b; margin-top: 3px; font-weight: 400;"><?php esc_html_e('Enable Google reCAPTCHA integration to prevent fake spam submissions', 'testimonial-maker'); ?></div></td>
					<td style="padding: 15px 20px; text-align: center; color: #94a3b8; font-size: 18px;">❌</td>
					<td style="padding: 15px 20px; text-align: center; color: #22c55e; font-size: 18px; background: rgba(214, 54, 56, 0.03);">✔️</td>
				</tr>
				<tr style="border-bottom: 1px solid #edf2f7;">
					<td style="padding: 15px 20px; font-weight: 500; color: #334155;"><strong><?php esc_html_e('Form Background Styling', 'testimonial-maker'); ?></strong><div style="font-size: 12px; color: #64748b; margin-top: 3px; font-weight: 400;"><?php esc_html_e('Upload custom background images and select positions in the form builder', 'testimonial-maker'); ?></div></td>
					<td style="padding: 15px 20px; text-align: center; color: #64748b;"><?php esc_html_e('Standard styles only', 'testimonial-maker'); ?></td>
					<td style="padding: 15px 20px; text-align: center; color: #22c55e; font-size: 18px; background: rgba(214, 54, 56, 0.03);">✔️</td>
				</tr>

				<tr>
					<td style="padding: 15px 20px; font-weight: 500; color: #334155;"><strong><?php esc_html_e('Priority Support & Updates', 'testimonial-maker'); ?></strong><div style="font-size: 12px; color: #64748b; margin-top: 3px; font-weight: 400;"><?php esc_html_e('Dedicated technical support and lifetime updates', 'testimonial-maker'); ?></div></td>
					<td style="padding: 15px 20px; text-align: center; color: #64748b;"><?php esc_html_e('Community Forum', 'testimonial-maker'); ?></td>
					<td style="padding: 15px 20px; text-align: center; color: #d63638; font-weight: 600; background: rgba(214, 54, 56, 0.03);"><?php esc_html_e('Priority Email Support', 'testimonial-maker'); ?></td>
				</tr>
			</tbody>
		</table>
	</div>

	<div style="text-align: center; margin-top: 20px;">
		<a href="https://awplife.com/wordpress-plugins/testimonial-wordpress-plugin/" target="_blank"
			class="button button-primary button-large"
			style="font-size:18px; height:54px; line-height:52px; padding:0 36px; background:#d63638; border-color:#d63638; text-decoration:none; display:inline-block; text-align:center; box-sizing:border-box; color:#fff; border-radius:6px; font-weight:bold; box-shadow: 0 4px 10px rgba(214, 54, 56, 0.25); transition: background-color 0.2s;"><?php esc_html_e('Upgrade to Premium Now', 'testimonial-maker'); ?></a>
	</div>
</div>
