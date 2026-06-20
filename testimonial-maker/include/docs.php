<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
?>
<style>
	:root {
		--tml-docs-bg: #f8fafc;
		--tml-docs-card: #ffffff;
		--tml-docs-text: #475569;
		--tml-docs-text-muted: #64748b;
		--tml-docs-heading: #0f172a;
		--tml-primary: #10b981;
		--tml-primary-hover: #059669;
		--tml-secondary: #6200ee;
		--tml-accent: #3b82f6;
		--tml-border: #e2e8f0;
		--tml-radius: 16px;
		--tml-radius-sm: 8px;
		--tml-shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03);
		--tml-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
		--tml-shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
		--tml-transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
	}

	.tml-docs-wrap {
		max-width: 1280px;
		margin: 20px auto;
		font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
		color: var(--tml-docs-text);
		padding: 0 15px;
		box-sizing: border-box;
	}

	.tml-docs-wrap * {
		box-sizing: border-box;
	}

	/* Header Styling */
	.tml-docs-header {
		background: linear-gradient(135deg, var(--tml-secondary) 0%, var(--tml-primary) 100%);
		color: #fff;
		padding: 45px 40px;
		border-radius: var(--tml-radius);
		margin-bottom: 30px;
		box-shadow: var(--tml-shadow-lg);
		position: relative;
		overflow: hidden;
	}

	.tml-docs-header::before {
		content: '';
		position: absolute;
		top: -50%;
		left: -50%;
		width: 200%;
		height: 200%;
		background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 60%);
		transform: rotate(30deg);
		pointer-events: none;
	}

	.tml-docs-header h1 {
		margin: 0 0 12px 0;
		font-size: 32px;
		font-weight: 800;
		color: #fff;
		letter-spacing: -0.025em;
	}

	.tml-docs-header p {
		margin: 0;
		font-size: 16px;
		color: rgba(255, 255, 255, 0.9);
		max-width: 650px;
		line-height: 1.6;
	}

	.tml-docs-header .tml-badge {
		display: inline-flex;
		align-items: center;
		background: rgba(255, 255, 255, 0.18);
		backdrop-filter: blur(4px);
		color: #fff;
		padding: 6px 14px;
		border-radius: 30px;
		font-size: 11px;
		font-weight: 700;
		letter-spacing: 0.05em;
		margin-bottom: 16px;
		text-transform: uppercase;
		border: 1px solid rgba(255, 255, 255, 0.25);
	}

	/* Two-Column Layout */
	.tml-docs-layout {
		display: grid;
		grid-template-columns: 280px 1fr;
		gap: 30px;
		align-items: start;
	}

	@media (max-width: 991px) {
		.tml-docs-layout {
			grid-template-columns: 1fr;
		}
	}

	/* Sidebar Styling */
	.tml-docs-sidebar {
		position: sticky;
		top: 50px;
		background: var(--tml-docs-card);
		border: 1px solid var(--tml-border);
		border-radius: var(--tml-radius);
		padding: 24px;
		box-shadow: var(--tml-shadow-sm);
		max-height: calc(100vh - 90px);
		overflow-y: auto;
	}

	@media (max-width: 991px) {
		.tml-docs-sidebar {
			position: relative;
			top: 0;
			max-height: none;
			margin-bottom: 20px;
		}
	}

	/* Custom Sidebar Scrollbar */
	.tml-docs-sidebar::-webkit-scrollbar {
		width: 6px;
	}
	.tml-docs-sidebar::-webkit-scrollbar-track {
		background: transparent;
	}
	.tml-docs-sidebar::-webkit-scrollbar-thumb {
		background: #cbd5e1;
		border-radius: 3px;
	}
	.tml-docs-sidebar::-webkit-scrollbar-thumb:hover {
		background: #94a3b8;
	}

	/* Sidebar Search Box */
	.tml-search-wrapper {
		position: relative;
		margin-bottom: 20px;
	}

	.tml-search-wrapper .dashicons {
		position: absolute;
		left: 12px;
		top: 50%;
		transform: translateY(-50%);
		color: var(--tml-docs-text-muted);
		font-size: 18px;
		width: 18px;
		height: 18px;
	}

	#tml-docs-search {
		width: 100%;
		padding: 10px 12px 10px 38px;
		border: 1px solid var(--tml-border);
		border-radius: var(--tml-radius-sm);
		font-size: 13.5px;
		background: #f8fafc;
		color: var(--tml-docs-heading);
		transition: var(--tml-transition);
	}

	#tml-docs-search:focus {
		background: #fff;
		border-color: var(--tml-secondary);
		box-shadow: 0 0 0 3px rgba(98, 0, 238, 0.12);
		outline: none;
	}

	.tml-sidebar-menu {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.tml-sidebar-item {
		margin: 0 0 6px 0;
	}

	.tml-sidebar-link {
		display: flex;
		align-items: center;
		gap: 12px;
		padding: 10px 14px;
		color: var(--tml-docs-text);
		text-decoration: none !important;
		border-radius: var(--tml-radius-sm);
		font-size: 13.5px;
		font-weight: 600;
		transition: var(--tml-transition);
	}

	.tml-sidebar-link:hover {
		background: #f1f5f9;
		color: var(--tml-secondary);
	}

	.tml-sidebar-link.active {
		background: linear-gradient(135deg, var(--tml-secondary) 0%, var(--tml-accent) 100%);
		color: #ffffff !important;
		box-shadow: 0 4px 12px rgba(98, 0, 238, 0.2);
	}

	.tml-sidebar-link .dashicons {
		font-size: 18px;
		width: 18px;
		height: 18px;
		color: var(--tml-docs-text-muted);
		transition: var(--tml-transition);
	}

	.tml-sidebar-link.active .dashicons {
		color: #ffffff;
	}

	/* Content Area Styling */
	.tml-docs-content {
		min-width: 0;
	}

	.tml-docs-section {
		background: var(--tml-docs-card);
		border: 1px solid var(--tml-border);
		padding: 40px;
		margin-bottom: 30px;
		border-radius: var(--tml-radius);
		box-shadow: var(--tml-shadow-sm);
		transition: var(--tml-transition);
		scroll-margin-top: 80px;
	}

	.tml-docs-section:hover {
		box-shadow: var(--tml-shadow);
		border-color: rgba(98, 0, 238, 0.3);
	}

	.tml-docs-section h2 {
		font-size: 22px;
		font-weight: 800;
		color: var(--tml-docs-heading);
		margin: 0 0 25px 0;
		padding-bottom: 16px;
		border-bottom: 2px solid var(--tml-border);
		display: flex;
		align-items: center;
		gap: 12px;
	}

	.tml-docs-section h2 .dashicons {
		font-size: 22px;
		width: 22px;
		height: 22px;
		color: var(--tml-secondary);
	}

	.tml-docs-section h3 {
		font-size: 16px;
		font-weight: 700;
		color: var(--tml-docs-heading);
		margin: 32px 0 16px 0;
		display: flex;
		align-items: center;
		gap: 10px;
	}

	.tml-docs-section h3::before {
		content: '';
		width: 4px;
		height: 16px;
		background: var(--tml-primary);
		border-radius: 2px;
	}

	.tml-docs-section p {
		font-size: 14.5px;
		line-height: 1.75;
		color: var(--tml-docs-text);
		margin: 0 0 16px 0;
	}

	.tml-docs-section ol,
	.tml-docs-section ul {
		margin: 15px 0 25px 20px;
		font-size: 14px;
		line-height: 1.75;
	}

	.tml-docs-section ol li,
	.tml-docs-section ul li {
		margin-bottom: 8px;
	}

	/* Code & Shortcode elements */
	.tml-docs-section code {
		background: #f1f5f9;
		padding: 3px 8px;
		border-radius: 6px;
		font-family: 'Consolas', 'Courier New', monospace;
		font-size: 13px;
		color: var(--tml-secondary);
		border: 1px solid var(--tml-border);
		font-weight: 600;
	}

	.tml-code-block-wrapper {
		position: relative;
		background: #0f172a;
		border-radius: 10px;
		padding: 16px 20px;
		margin: 15px 0;
		border: 1px solid rgba(255,255,255,0.08);
		box-shadow: inset 0 2px 4px rgba(0,0,0,0.15);
		display: flex;
		justify-content: space-between;
		align-items: center;
		gap: 15px;
	}

	.tml-code-block {
		font-family: 'Consolas', 'Courier New', monospace;
		font-size: 14.5px;
		color: #38bdf8;
		margin: 0;
		padding: 0;
		overflow-x: auto;
		white-space: pre-wrap;
		word-break: break-all;
		font-weight: 600;
		flex: 1;
	}

	.tml-copy-btn {
		background: rgba(255, 255, 255, 0.08);
		border: 1px solid rgba(255, 255, 255, 0.15);
		color: #e2e8f0;
		padding: 6px 12px;
		border-radius: 6px;
		font-size: 12px;
		font-weight: 600;
		cursor: pointer;
		display: inline-flex;
		align-items: center;
		gap: 6px;
		transition: var(--tml-transition);
		flex-shrink: 0;
	}

	.tml-copy-btn:hover {
		background: rgba(255, 255, 255, 0.15);
		color: #fff;
		border-color: rgba(255, 255, 255, 0.3);
	}

	.tml-copy-btn.copied {
		background: #10b981;
		border-color: #10b981;
		color: #fff;
	}

	.tml-copy-btn .dashicons {
		font-size: 14px;
		width: 14px;
		height: 14px;
	}

	/* Alerts styling */
	.tml-info, .tml-tip {
		padding: 18px 24px;
		margin: 24px 0;
		border-radius: var(--tml-radius-sm);
		font-size: 14px;
		line-height: 1.75;
	}

	.tml-info {
		background: #eff6ff;
		border-left: 4px solid #3b82f6;
		color: #1e40af;
	}

	.tml-tip {
		background: #fffbeb;
		border-left: 4px solid #f59e0b;
		color: #78350f;
	}

	.tml-info strong, .tml-tip strong {
		display: block;
		font-size: 13px;
		font-weight: 700;
		letter-spacing: 0.05em;
		text-transform: uppercase;
		margin-bottom: 6px;
	}

	.tml-info strong { color: #2563eb; }
	.tml-tip strong { color: #d97706; }

	/* Shortcode Guide Cards */
	.tml-builders-grid {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 20px;
		margin: 24px 0;
	}

	@media (max-width: 768px) {
		.tml-builders-grid {
			grid-template-columns: 1fr;
		}
	}

	.tml-builder-card {
		background: #f8fafc;
		border: 1px solid var(--tml-border);
		border-radius: var(--tml-radius-sm);
		padding: 24px;
		transition: var(--tml-transition);
	}

	.tml-builder-card:hover {
		border-color: var(--tml-secondary);
		background: #fff;
		box-shadow: var(--tml-shadow);
	}

	.tml-builder-card h4 {
		margin: 0 0 12px 0;
		font-size: 15px;
		font-weight: 700;
		color: var(--tml-docs-heading);
		display: flex;
		align-items: center;
		gap: 8px;
	}

	.tml-builder-card h4 .dashicons {
		color: var(--tml-secondary);
	}

	/* Call to Action Buttons */
	.tml-docs-cta {
		background: var(--tml-docs-card);
		border: 1px solid var(--tml-border);
		border-radius: var(--tml-radius);
		padding: 40px;
		display: flex;
		gap: 20px;
		justify-content: center;
		align-items: center;
		box-shadow: var(--tml-shadow-sm);
		margin-top: 30px;
	}

	.tml-docs-cta .button-hero {
		display: inline-flex !important;
		align-items: center !important;
		justify-content: center !important;
		gap: 8px;
		height: 46px !important;
		line-height: 44px !important;
	}

	.tml-docs-cta .button-hero .dashicons {
		margin: 0 !important;
		font-size: 18px;
		width: 18px;
		height: 18px;
		display: inline-flex !important;
		align-items: center !important;
		justify-content: center !important;
	}
</style>

<div class="tml-docs-wrap">

	<!-- Header -->
	<div class="tml-docs-header">
		<span class="tml-badge">★ <?php esc_html_e('Documentation', 'testimonial-maker'); ?></span>
		<h1><?php esc_html_e('Testimonial Maker — Documentation', 'testimonial-maker'); ?></h1>
		<p><?php esc_html_e('Learn how to gather, manage, customize, and display client feedback and reviews on your site.', 'testimonial-maker'); ?></p>
	</div>

	<!-- Main Sidebar and Content Layout -->
	<div class="tml-docs-layout">

		<!-- Sidebar Navigation -->
		<aside class="tml-docs-sidebar">
			<div class="tml-search-wrapper">
				<span class="dashicons dashicons-search"></span>
				<input type="text" id="tml-docs-search" placeholder="<?php esc_attr_e('Search docs...', 'testimonial-maker'); ?>">
			</div>
			<ul class="tml-sidebar-menu">
				<li class="tml-sidebar-item">
					<a class="tml-sidebar-link active" href="#tml-start">
						<span class="dashicons dashicons-format-status"></span>
						<?php esc_html_e('1. Adding Testimonials', 'testimonial-maker'); ?>
					</a>
				</li>
				<li class="tml-sidebar-item">
					<a class="tml-sidebar-link" href="#tml-form-builder">
						<span class="dashicons dashicons-feedback"></span>
						<?php esc_html_e('2. Frontend Submission Form', 'testimonial-maker'); ?>
					</a>
				</li>
				<li class="tml-sidebar-item">
					<a class="tml-sidebar-link" href="#tml-shortcode-generator">
						<span class="dashicons dashicons-layout"></span>
						<?php esc_html_e('3. Designing Showcase Layouts', 'testimonial-maker'); ?>
					</a>
				</li>
				<li class="tml-sidebar-item">
					<a class="tml-sidebar-link" href="#tml-dashboard-section">
						<span class="dashicons dashicons-admin-users"></span>
						<?php esc_html_e('4. User Dashboard', 'testimonial-maker'); ?>
					</a>
				</li>
				<li class="tml-sidebar-item">
					<a class="tml-sidebar-link" href="#tml-page-builders">
						<span class="dashicons dashicons-admin-appearance"></span>
						<?php esc_html_e('5. Gutenberg & Page Builders', 'testimonial-maker'); ?>
					</a>
				</li>
				<li class="tml-sidebar-item">
					<a class="tml-sidebar-link" href="#tml-faq-section">
						<span class="dashicons dashicons-editor-help"></span>
						<?php esc_html_e('6. FAQ & Support', 'testimonial-maker'); ?>
					</a>
				</li>
			</ul>
		</aside>

		<!-- Main Content Sections -->
		<main class="tml-docs-content">

			<!-- 1. Adding Testimonials Manually -->
			<div class="tml-docs-section" id="tml-start">
				<h2><span class="dashicons dashicons-format-status"></span> <?php esc_html_e('1. Adding Testimonials Manually', 'testimonial-maker'); ?></h2>
				<p><?php esc_html_e('You can manually enter and publish reviews received via email or other channels directly from the admin panel.', 'testimonial-maker'); ?></p>
				<ol>
					<li><?php esc_html_e('In your WordPress dashboard, navigate to Testimonial Maker > Add New Testimonial.', 'testimonial-maker'); ?></li>
					<li><?php esc_html_e('Enter the Client\'s Name as the Post Title.', 'testimonial-maker'); ?></li>
					<li><?php esc_html_e('Write the Client\'s Review text in the main content editor.', 'testimonial-maker'); ?></li>
					<li><?php esc_html_e('Under the Add Client Detail meta box at the bottom, configure the client details:', 'testimonial-maker'); ?>
						<ul>
							<li><strong><?php esc_html_e('Website Link:', 'testimonial-maker'); ?></strong> <?php esc_html_e('The reviewer\'s website URL (e.g., https://example.com).', 'testimonial-maker'); ?></li>
							<li><strong><?php esc_html_e('Designation:', 'testimonial-maker'); ?></strong> <?php esc_html_e('Their professional title or job role (e.g., CEO, Tech Lead).', 'testimonial-maker'); ?></li>
							<li><strong><?php esc_html_e('Star Rating:', 'testimonial-maker'); ?></strong> <?php esc_html_e('A score between 1 and 5 stars.', 'testimonial-maker'); ?></li>
						</ul>
					</li>
					<li><?php esc_html_e('Set a Featured Image on the right sidebar. This image acts as the reviewer\'s avatar.', 'testimonial-maker'); ?></li>
					<li><?php esc_html_e('Assign a Category (optional) to classify the review for structured filtering.', 'testimonial-maker'); ?></li>
					<li><?php esc_html_e('Click Publish to finalize your testimonial entry.', 'testimonial-maker'); ?></li>
				</ol>

				<div class="tml-tip">
					<strong><?php esc_html_e('Tip:', 'testimonial-maker'); ?></strong>
					<?php esc_html_e('Categories are incredibly useful when you want to showcase reviews on specific service pages (e.g., displaying only "Web Design Reviews" on your Web Design service page).', 'testimonial-maker'); ?>
				</div>
			</div>

			<!-- 2. Frontend Submission Form Builder -->
			<div class="tml-docs-section" id="tml-form-builder">
				<h2><span class="dashicons dashicons-feedback"></span> <?php esc_html_e('2. Frontend Submission Form Builder', 'testimonial-maker'); ?></h2>
				<p><?php esc_html_e('Testimonial Maker features a built-in Form Builder allowing you to receive testimonials from public users directly on your website.', 'testimonial-maker'); ?></p>
				
				<h3><?php esc_html_e('Setting up the Submission Form:', 'testimonial-maker'); ?></h3>
				<ol>
					<li><?php esc_html_e('Go to Testimonial Maker > Form Builder.', 'testimonial-maker'); ?></li>
					<li><?php esc_html_e('Click Add New Form or edit the default draft form.', 'testimonial-maker'); ?></li>
					<li><?php esc_html_e('Under the Form Configuration panel, select which fields (Full Name, Designation, Website URL, Avatar, Star Rating, Content) to show or hide.', 'testimonial-maker'); ?></li>
					<li><?php esc_html_e('Click on the Form Styles tab to customize button colors, border radius, text labels, and backgrounds.', 'testimonial-maker'); ?></li>
					<li><?php esc_html_e('Click Save or Update to publish your form.', 'testimonial-maker'); ?></li>
				</ol>

				<h3><?php esc_html_e('Displaying the Form on Your Website:', 'testimonial-maker'); ?></h3>
				<p><?php esc_html_e('To place the review submission form on a public page, copy its shortcode and paste it inside any post or page:', 'testimonial-maker'); ?></p>

				<div class="tml-code-block-wrapper">
					<pre class="tml-code-block">[TML_FORM id="YOUR_FORM_ID"]</pre>
					<button class="tml-copy-btn" onclick="tmlCopyCode(this, '[TML_FORM id=\'YOUR_FORM_ID\']')">
						<span class="dashicons dashicons-clipboard"></span>
						<?php esc_html_e('Copy Code', 'testimonial-maker'); ?>
					</button>
				</div>

				<div class="tml-info">
					<strong><?php esc_html_e('Review Moderation & Spam Prevention:', 'testimonial-maker'); ?></strong>
					<?php esc_html_e('By default, all testimonials submitted through the frontend form are saved as "Pending" drafts. You can review them by navigating to Testimonial Maker > All Testimonial and clicking "Approve" (Publish) to display them live on your layouts.', 'testimonial-maker'); ?>
				</div>
			</div>

			<!-- 3. Designing Showcase Layouts -->
			<div class="tml-docs-section" id="tml-shortcode-generator">
				<h2><span class="dashicons dashicons-layout"></span> <?php esc_html_e('3. Designing Showcase Layouts (Shortcode Generator)', 'testimonial-maker'); ?></h2>
				<p><?php esc_html_e('Once you have added testimonials (manually or via frontend submission), you can build sliders or grids to display them.', 'testimonial-maker'); ?></p>

				<h3><?php esc_html_e('Creating a Display Showcase:', 'testimonial-maker'); ?></h3>
				<ol>
					<li><?php esc_html_e('Navigate to Testimonial Maker > Shortcodes.', 'testimonial-maker'); ?></li>
					<li><?php esc_html_e('Click Add New to create a layout configuration.', 'testimonial-maker'); ?></li>
					<li><?php esc_html_e('Configure your display parameters across the settings panels:', 'testimonial-maker'); ?>
						<ul>
							<li><strong><?php esc_html_e('Layout Preset:', 'testimonial-maker'); ?></strong> <?php esc_html_e('Choose between Slider (Carousel) or Grid layouts.', 'testimonial-maker'); ?></li>
							<li><strong><?php esc_html_e('Responsive Columns:', 'testimonial-maker'); ?></strong> <?php esc_html_e('Define separate grid column counts for Large Desktops, Desktops, Laptops, Tablets, and Mobiles.', 'testimonial-maker'); ?></li>
							<li><strong><?php esc_html_e('Spacing & Gap:', 'testimonial-maker'); ?></strong> <?php esc_html_e('Control horizontal gap and vertical gap spacing between cards using simple sliders.', 'testimonial-maker'); ?></li>
							<li><strong><?php esc_html_e('Sorting & Limits:', 'testimonial-maker'); ?></strong> <?php esc_html_e('Limit the number of loaded reviews, and choose ordering types (Date, Title, ID, or Last Modified) and directions (Ascending or Descending).', 'testimonial-maker'); ?></li>
							<li><strong><?php esc_html_e('Theme Selection:', 'testimonial-maker'); ?></strong> <?php esc_html_e('Choose between Theme 1 (Floating Avatar Center), Theme 2 (Modern Clean Card), and Theme 3 (Centered Classic).', 'testimonial-maker'); ?></li>
							<li><strong><?php esc_html_e('Card Elements Visibility:', 'testimonial-maker'); ?></strong> <?php esc_html_e('Toggle on/off title, review text, designations, rating stars, and website links, and configure a fallback default reviewer avatar URL.', 'testimonial-maker'); ?></li>
							<li><strong><?php esc_html_e('Interactive Slider Controls:', 'testimonial-maker'); ?></strong> <?php esc_html_e('Configure loop, autoplay toggle, autoplay timeout delay speed, transition slide speed, mouse draggable, and pause-on-hover actions.', 'testimonial-maker'); ?></li>
							<li><strong><?php esc_html_e('Color Styling:', 'testimonial-maker'); ?></strong> <?php esc_html_e('Set customized colors for title, content, reviewer designation, star ratings, carousel navigation arrows, and card background color.', 'testimonial-maker'); ?></li>
						</ul>
					</li>
					<li><?php esc_html_e('Click Publish / Update. The Shortcode will be generated automatically.', 'testimonial-maker'); ?></li>
				</ol>

				<h3><?php esc_html_e('Displaying Testimonials on Your Site:', 'testimonial-maker'); ?></h3>
				<p><?php esc_html_e('Copy the generated shortcode and place it on any Page, Post, Widget, or Footer section:', 'testimonial-maker'); ?></p>

				<div class="tml-code-block-wrapper">
					<pre class="tml-code-block">[TML id="YOUR_SHORTCODE_ID"]</pre>
					<button class="tml-copy-btn" onclick="tmlCopyCode(this, '[TML id=\'YOUR_SHORTCODE_ID\']')">
						<span class="dashicons dashicons-clipboard"></span>
						<?php esc_html_e('Copy Code', 'testimonial-maker'); ?>
					</button>
				</div>
			</div>

			<!-- 4. User Dashboard -->
			<div class="tml-docs-section" id="tml-dashboard-section">
				<h2><span class="dashicons dashicons-admin-users"></span> <?php esc_html_e('4. Registered Reviewers User Dashboard', 'testimonial-maker'); ?></h2>
				<p><?php esc_html_e('Give logged-in reviewers full visibility of reviews they have posted. They can check their review statuses (Approved/Pending) and even delete them directly from the frontend dashboard.', 'testimonial-maker'); ?></p>
				
				<p><?php esc_html_e('Create a new page (e.g., "My Account" or "Reviewer Dashboard") and paste the following shortcode:', 'testimonial-maker'); ?></p>

				<div class="tml-code-block-wrapper">
					<pre class="tml-code-block">[TML_DASHBOARD]</pre>
					<button class="tml-copy-btn" onclick="tmlCopyCode(this, '[TML_DASHBOARD]')">
						<span class="dashicons dashicons-clipboard"></span>
						<?php esc_html_e('Copy Code', 'testimonial-maker'); ?>
					</button>
				</div>

				<div class="tml-info">
					<strong><?php esc_html_e('Security & Author Protection:', 'testimonial-maker'); ?></strong>
					<?php esc_html_e('The dashboard safely isolates content: it will only display testimonials matching the current logged-in user\'s ID. Non-logged-in visitors will see a notification prompting them to log in.', 'testimonial-maker'); ?>
				</div>
			</div>

			<!-- 5. Gutenberg & Page Builders -->
			<div class="tml-docs-section" id="tml-page-builders">
				<h2><span class="dashicons dashicons-admin-appearance"></span> <?php esc_html_e('5. Gutenberg Block Editor & Page Builders Integration', 'testimonial-maker'); ?></h2>
				<p><?php esc_html_e('Enjoy direct integration with Gutenberg and page builders, preventing the need to remember or copy IDs.', 'testimonial-maker'); ?></p>

				<div class="tml-builders-grid">
					<!-- Gutenberg block description -->
					<div class="tml-builder-card">
						<h4><span class="dashicons dashicons-edit"></span> <?php esc_html_e('Gutenberg Block Editor', 'testimonial-maker'); ?></h4>
						<ol style="margin: 10px 0; padding-left: 15px; font-size: 13px;">
							<li><?php esc_html_e('Open a post or page inside Gutenberg.', 'testimonial-maker'); ?></li>
							<li><?php esc_html_e('Click the "+" block inserter and search for "Testimonial Maker".', 'testimonial-maker'); ?></li>
							<li><?php esc_html_e('Insert the block. Select your desired shortcode layout config directly from the right-hand block settings panel.', 'testimonial-maker'); ?></li>
						</ol>
					</div>

					<!-- Elementor builder description -->
					<div class="tml-builder-card">
						<h4><span class="dashicons dashicons-grid-view"></span> <?php esc_html_e('Elementor Page Builder', 'testimonial-maker'); ?></h4>
						<ol style="margin: 10px 0; padding-left: 15px; font-size: 13px;">
							<li><?php esc_html_e('Edit your page in Elementor.', 'testimonial-maker'); ?></li>
							<li><?php esc_html_e('Search for the "Testimonial Maker" widget in the elements panel.', 'testimonial-maker'); ?></li>
							<li><?php esc_html_e('Drag and drop the element. Select your configured Shortcode layout from the dropdown select list.', 'testimonial-maker'); ?></li>
						</ol>
					</div>
				</div>
			</div>

			<!-- 6. FAQ & Support -->
			<div class="tml-docs-section" id="tml-faq-section">
				<h2><span class="dashicons dashicons-editor-help"></span> <?php esc_html_e('6. Frequently Asked Questions & Troubleshooting', 'testimonial-maker'); ?></h2>

				<h3><?php esc_html_e('Why are submitted testimonials not displaying on my showcase?', 'testimonial-maker'); ?></h3>
				<p><?php esc_html_e('To protect your site from spam, all frontend testimonial form submissions are loaded as "Pending" drafts. Navigate to Testimonial Maker > All Testimonial, verify the content, and change the status to "Published" (Approve) to make them live.', 'testimonial-maker'); ?></p>

				<h3><?php esc_html_e('How can I edit the form fields?', 'testimonial-maker'); ?></h3>
				<p><?php esc_html_e('Go to Testimonial Maker > Form Builder, click to edit your form configuration, toggle field visibility, customize placeholders or button styles, and click save.', 'testimonial-maker'); ?></p>

				<h3><?php esc_html_e('Can I limit the number of testimonials shown in a slider?', 'testimonial-maker'); ?></h3>
				<p><?php esc_html_e('Yes. In your shortcode editor (Testimonial Maker > Shortcodes), locate the "Testimonial Limit" field. Change the default value to your desired maximum number of reviews.', 'testimonial-maker'); ?></p>

				<h3><?php esc_html_e('How do I show only testimonials belonging to a specific category?', 'testimonial-maker'); ?></h3>
				<p><?php esc_html_e('When creating or editing testimonials, assign them categories on the right sidebar. In your shortcode editor under general settings, select the category from the categories filter checklist.', 'testimonial-maker'); ?></p>
			</div>

			<!-- Call to Action -->
			<div class="tml-docs-cta">
				<a class="button button-primary button-hero" href="https://awplife.com/demo/testimonial-premium/" target="_blank" rel="noopener noreferrer" style="border-radius:10px; font-weight:700; background-color:#10b981; border-color:#10b981; color:#fff !important; text-decoration:none;">
					<span class="dashicons dashicons-visibility" style="vertical-align: middle; margin-right: 5px;"></span>
					<?php esc_html_e('Live Pro Demo', 'testimonial-maker'); ?>
				</a>
				<a class="button button-secondary button-hero" href="https://awplife.com/account/signup/testimonial-premium" target="_blank" rel="noopener noreferrer" style="border-radius:10px; font-weight:700; text-decoration:none;">
					<span class="dashicons dashicons-cart" style="vertical-align: middle; margin-right: 5px;"></span>
					<?php esc_html_e('Buy Pro Version', 'testimonial-maker'); ?>
				</a>
				<a class="button button-hero" href="https://wordpress.org/support/plugin/testimonial-maker/reviews/" target="_blank" rel="noopener noreferrer" style="border-radius:10px; font-weight:700; text-decoration:none;">
					<span class="dashicons dashicons-star-filled" style="vertical-align: middle; margin-right: 5px;"></span>
					<?php esc_html_e('Leave a Review', 'testimonial-maker'); ?>
				</a>
			</div>

		</main>

	</div>

</div>

<script>
	// Copy to clipboard utility
	function tmlCopyCode(btn, codeText) {
		if (navigator.clipboard && navigator.clipboard.writeText) {
			navigator.clipboard.writeText(codeText).then(showSuccess, fallbackCopy);
		} else {
			fallbackCopy();
		}

		function showSuccess() {
			var origHTML = btn.innerHTML;
			btn.innerHTML = '<span class="dashicons dashicons-yes"></span> ' + <?php echo json_encode(__('Copied!', 'testimonial-maker')); ?>;
			btn.classList.add('copied');
			setTimeout(function() {
				btn.innerHTML = origHTML;
				btn.classList.remove('copied');
			}, 2000);
		}

		function fallbackCopy() {
			var textArea = document.createElement("textarea");
			textArea.value = codeText;
			textArea.style.position = "fixed";
			document.body.appendChild(textArea);
			textArea.focus();
			textArea.select();
			try {
				document.execCommand('copy');
				showSuccess();
			} catch (err) {
				console.error('Fallback copy failed', err);
			}
			document.body.removeChild(textArea);
		}
	}

	// Real-time documentation search filtering
	document.getElementById('tml-docs-search').addEventListener('input', function(e) {
		var query = e.target.value.toLowerCase().trim();
		var sections = document.querySelectorAll('.tml-docs-section');
		var sidebarItems = document.querySelectorAll('.tml-sidebar-item');

		sections.forEach(function(section) {
			var headingText = section.querySelector('h2').innerText.toLowerCase();
			var bodyText = section.innerText.toLowerCase();
			if (headingText.indexOf(query) > -1 || bodyText.indexOf(query) > -1) {
				section.style.display = 'block';
			} else {
				section.style.display = 'none';
			}
		});

		sidebarItems.forEach(function(item) {
			var link = item.querySelector('.tml-sidebar-link');
			var targetId = link.getAttribute('href');
			var targetSection = document.querySelector(targetId);
			var linkText = link.innerText.toLowerCase();
			
			if (linkText.indexOf(query) > -1 || (targetSection && targetSection.style.display !== 'none')) {
				item.style.display = 'block';
			} else {
				item.style.display = 'none';
			}
		});
	});

	// Sticky sidebar scrollspy highlight
	window.addEventListener('DOMContentLoaded', function() {
		var sections = document.querySelectorAll('.tml-docs-section');
		var navLinks = document.querySelectorAll('.tml-sidebar-link');

		function updateScrollspy() {
			var scrollPos = window.scrollY || window.pageYOffset || document.documentElement.scrollTop;
			var currentId = '';

			sections.forEach(function(section) {
				var sectionTop = section.offsetTop;
				var sectionHeight = section.clientHeight;
				
				if (scrollPos >= (sectionTop - 130)) {
					currentId = section.getAttribute('id');
				}
			});

			if (currentId) {
				navLinks.forEach(function(link) {
					if (link.getAttribute('href') === '#' + currentId) {
						link.classList.add('active');
					} else {
						link.classList.remove('active');
					}
				});
			}
		}

		window.addEventListener('scroll', updateScrollspy);
		updateScrollspy(); // Run once on load
	});
</script>
