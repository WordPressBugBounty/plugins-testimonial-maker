<?php
/**
 * Analytics Page Callback Layout
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="wrap" style="background:#fff; padding:30px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif; position: relative; max-width: 1200px; margin-top: 20px; border-radius: 8px; border: 1px solid #ccd0d4; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
	
	<!-- Small Alert Banner at the Top -->
	<div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e3a8a; padding: 15px; border-radius: 6px; margin-bottom: 25px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
		<div>
			<h4 style="margin: 0 0 5px 0; font-size: 16px; font-weight: 600;"><?php esc_html_e('Unlock Analytics & Conversion Tracking ★', 'testimonial-maker'); ?></h4>
			<p style="margin: 0; font-size: 13px; color: #1e40af;"><?php esc_html_e('Upgrade to Testimonial Premium to monitor views, link clicks, CTR, and submission conversions.', 'testimonial-maker'); ?></p>
		</div>
		<a href="https://awplife.com/wordpress-plugins/testimonial-wordpress-plugin/" target="_blank" class="button button-primary" style="background: #d63638; border-color: #d63638; font-weight: 600; text-decoration: none; color: #fff; padding: 4px 12px; border-radius: 4px; display: inline-block; font-size: 13px;"><?php esc_html_e('Get PRO Version', 'testimonial-maker'); ?></a>
	</div>

	<!-- Main Content Wrapper that will be blurred -->
	<div style="filter: blur(4px); pointer-events: none; user-select: none; opacity: 0.6;">
		<h1 style="color:#0f172a; margin-top:0; font-size:28px; font-weight: 700; margin-bottom: 8px;"><?php esc_html_e('Analytics & Statistics', 'testimonial-maker'); ?></h1>
		<p style="color: #64748b; font-size: 14px; margin-top: 0; margin-bottom: 30px;"><?php esc_html_e('Track views, clicks, CTR, and submission rates of your testimonials in real-time.', 'testimonial-maker'); ?></p>
		
		<!-- Stats Cards Mock -->
		<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
			<div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; background: #f8fafc; position: relative;">
				<span style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;"><?php esc_html_e('Impressions', 'testimonial-maker'); ?></span>
				<span style="display: block; font-size: 28px; font-weight: 700; color: #0f172a; margin-top: 8px;">24,850</span>
			</div>
			<div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; background: #f8fafc; position: relative;">
				<span style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;"><?php esc_html_e('Clicks', 'testimonial-maker'); ?></span>
				<span style="display: block; font-size: 28px; font-weight: 700; color: #0f172a; margin-top: 8px;">1,290</span>
			</div>
			<div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; background: #f8fafc; position: relative;">
				<span style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;"><?php esc_html_e('CTR (Average)', 'testimonial-maker'); ?></span>
				<span style="display: block; font-size: 28px; font-weight: 700; color: #0f172a; margin-top: 8px;">5.19%</span>
			</div>
			<div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; background: #f8fafc; position: relative;">
				<span style="font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;"><?php esc_html_e('Submissions', 'testimonial-maker'); ?></span>
				<span style="display: block; font-size: 28px; font-weight: 700; color: #0f172a; margin-top: 8px;">184</span>
			</div>
		</div>
		
		<!-- Visual Graph Mock -->
		<div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 40px; background: #f8fafc; text-align: center; min-height: 250px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
			<span style="font-size: 48px; color: #94a3b8; margin-bottom: 15px;">📈</span>
			<h3 style="font-size: 18px; font-weight: 700; color: #334155; margin: 0 0 8px 0;"><?php esc_html_e('Interactive Performance Chart', 'testimonial-maker'); ?></h3>
			<p style="font-size: 13.5px; color: #64748b; margin: 0; max-width: 450px; line-height: 1.6;">
				<?php esc_html_e('Monitor conversion trends, compare metrics, and optimize your testimonials with filterable analytics reports.', 'testimonial-maker'); ?>
			</p>
		</div>
	</div>
</div>
