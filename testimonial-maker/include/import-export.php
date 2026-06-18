<?php
/**
 * Import/Export Page Callback Layout
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="wrap" style="background:#fff; padding:30px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif; position: relative; max-width: 1200px; margin-top: 20px; border-radius: 8px; border: 1px solid #ccd0d4; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden;">
	
	<!-- Small Alert Banner at the Top -->
	<div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e3a8a; padding: 15px; border-radius: 6px; margin-bottom: 25px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
		<div>
			<h4 style="margin: 0 0 5px 0; font-size: 16px; font-weight: 600;"><?php esc_html_e('Unlock Premium Import & Export ★', 'testimonial-maker'); ?></h4>
			<p style="margin: 0; font-size: 13px; color: #1e40af;"><?php esc_html_e('Upgrade to Testimonial Premium to import testimonials from CSV or export them easily.', 'testimonial-maker'); ?></p>
		</div>
		<a href="https://awplife.com/wordpress-plugins/testimonial-wordpress-plugin/" target="_blank" class="button button-primary" style="background: #d63638; border-color: #d63638; font-weight: 600; text-decoration: none; color: #fff; padding: 4px 12px; border-radius: 4px; display: inline-block; font-size: 13px;"><?php esc_html_e('Get PRO Version', 'testimonial-maker'); ?></a>
	</div>

	<!-- Main Content Wrapper that will be blurred -->
	<div style="filter: blur(4px); pointer-events: none; user-select: none; opacity: 0.6;">
		<h1 style="color:#0f172a; margin-top:0; font-size:28px; font-weight: 700; margin-bottom: 8px;"><?php esc_html_e('Import & Export', 'testimonial-maker'); ?></h1>
		<p style="color: #64748b; font-size: 14px; margin-top: 0; margin-bottom: 30px;"><?php esc_html_e('Easily back up, migrate, or bulk import your testimonial reviews via standard CSV files.', 'testimonial-maker'); ?></p>
		
		<div style="display: flex; gap: 24px; flex-wrap: wrap; margin-bottom: 30px;">
			<!-- Export Card -->
			<div style="flex: 1; min-width: 350px; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
				<h2 style="display: flex; align-items: center; gap: 8px; font-size: 18px; font-weight: 700; color: #1e293b; margin-top: 0; margin-bottom: 20px;">
					<span style="color: #2563eb;">📥</span> <?php esc_html_e('Export Testimonials', 'testimonial-maker'); ?>
				</h2>
				<p style="color: #64748b; font-size: 13.5px; line-height: 1.6; margin-bottom: 40px; min-height: 60px;">
					<?php esc_html_e('Download all your testimonials as a CSV spreadsheet. This is highly recommended for creating local manual backups or migrating your reviews to another WordPress site.', 'testimonial-maker'); ?>
				</p>
				<button class="button" style="width: 100%; height: 42px; background: #1d70d6; border-color: #1d70d6; color: #fff; font-weight: 600; font-size: 14px; border-radius: 6px; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: default;">
					📥 <?php esc_html_e('Export to CSV', 'testimonial-maker'); ?>
				</button>
			</div>
			
			<!-- Import Card -->
			<div style="flex: 1; min-width: 350px; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
				<h2 style="display: flex; align-items: center; gap: 8px; font-size: 18px; font-weight: 700; color: #1e293b; margin-top: 0; margin-bottom: 20px;">
					<span style="color: #10b981;">📤</span> <?php esc_html_e('Import Testimonials', 'testimonial-maker'); ?>
				</h2>
				<p style="color: #64748b; font-size: 13.5px; line-height: 1.6; margin-bottom: 20px; min-height: 60px;">
					<?php esc_html_e('Upload a valid CSV backup to bulk import reviews into your system. Make sure the headers strictly match our import guide format below.', 'testimonial-maker'); ?>
				</p>
				<div style="border: 1px dashed #cbd5e1; border-radius: 6px; padding: 10px; background: #f8fafc; margin-bottom: 15px; display: flex; align-items: center;">
					<input type="file" style="font-size: 12px;" disabled>
				</div>
				<button class="button" style="width: 100%; height: 42px; background: #fff; border-color: #10b981; color: #10b981; font-weight: 600; font-size: 14px; border-radius: 6px; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: default;">
					📤 <?php esc_html_e('Import from CSV', 'testimonial-maker'); ?>
				</button>
			</div>
		</div>
		
		<!-- CSV Format Guide Card -->
		<div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
			<h2 style="display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 700; color: #1e293b; margin-top: 0; margin-bottom: 16px;">
				<span style="color: #64748b;">ℹ</span> <?php esc_html_e('CSV Format Guide', 'testimonial-maker'); ?>
			</h2>
			<p style="color: #64748b; font-size: 13.5px; margin-bottom: 16px;"><?php esc_html_e('Your import CSV spreadsheet must have the following exact headers in the very first row:', 'testimonial-maker'); ?></p>
			<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px; font-family: monospace; font-size: 13px; color: #2563eb; line-height: 1.6; word-break: break-all;">
				<?php esc_html_e('Title, Content, Status, Date, Designation, Website Link, Video URL, Star Rating, Image URL, Social Links, Categories', 'testimonial-maker'); ?>
			</div>
		</div>
	</div>
</div>
