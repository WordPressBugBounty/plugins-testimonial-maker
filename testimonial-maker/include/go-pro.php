<?php
/**
 * Go Pro Page Callback Layout
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<style>
    .tml-gopro-container {
        max-width: 1000px;
        margin: 0 auto;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
    }

    /* Premium Hero Banner */
    .tml-gopro-hero {
        background: linear-gradient(135deg, #4f46e5 0%, #312e81 100%);
        border-radius: 16px;
        padding: 40px;
        color: #ffffff;
        text-align: center;
        margin-bottom: 32px;
        box-shadow: 0 10px 25px rgba(79, 70, 229, 0.25);
        position: relative;
        overflow: hidden;
    }

    .tml-gopro-hero::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0) 70%);
        pointer-events: none;
    }

    .tml-gopro-badge-icon {
        background: rgba(255, 255, 255, 0.15);
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        border: 1px solid rgba(255, 255, 255, 0.25);
    }

    .tml-gopro-badge-icon i {
        font-size: 28px;
        color: #fbbf24;
    }

    .tml-gopro-hero h1 {
        color: #ffffff !important;
        font-size: 32px !important;
        font-weight: 700 !important;
        margin: 0 0 12px 0 !important;
        line-height: 1.2 !important;
    }

    .tml-gopro-hero p {
        font-size: 16px;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.85);
        max-width: 720px;
        margin: 0 auto 28px auto;
    }

    /* Premium Upgrade Button */
    .tml-gopro-btn-upgrade {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #fbbf24;
        color: #1e1b4b !important;
        font-size: 16px;
        font-weight: 700;
        text-decoration: none !important;
        padding: 14px 36px;
        border-radius: 30px;
        box-shadow: 0 4px 14px rgba(251, 191, 36, 0.4);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        cursor: pointer;
    }

    .tml-gopro-btn-upgrade:hover {
        background: #f59e0b;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(251, 191, 36, 0.6);
    }

    /* Comparison Card */
    .tml-gopro-comparison-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        border: 1px solid rgba(0, 0, 0, 0.05);
        padding: 32px;
        margin-bottom: 24px;
    }

    .tml-gopro-comparison-title {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 24px 0;
        text-align: center;
    }

    /* Comparison Table Styling */
    .tml-gopro-table-wrapper {
        overflow-x: auto;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .tml-gopro-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 14px;
        background: #ffffff;
    }

    .tml-gopro-table th {
        padding: 16px 20px;
        font-weight: 600;
        color: #1e293b;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    .tml-gopro-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #edf2f7;
        vertical-align: middle;
    }

    .tml-gopro-table tbody tr:last-child td {
        border-bottom: none;
    }

    .tml-gopro-feature-name {
        font-weight: 600;
        color: #334155;
        font-size: 14.5px;
    }

    .tml-gopro-feature-desc {
        font-size: 12px;
        color: #64748b;
        margin-top: 4px;
        font-weight: 400;
    }

    .tml-gopro-col-free {
        text-align: center;
        color: #64748b;
        width: 190px;
        font-weight: 500;
    }

    .tml-gopro-col-pro {
        text-align: center;
        color: #4f46e5;
        width: 190px;
        font-weight: 600;
        background: rgba(79, 70, 229, 0.02);
        border-left: 1px solid rgba(79, 70, 229, 0.05);
        border-right: 1px solid rgba(79, 70, 229, 0.05);
    }

    .tml-gopro-table tr:hover .tml-gopro-col-pro {
        background: rgba(79, 70, 229, 0.04);
    }

    .tml-gopro-icon-check {
        color: #10b981;
        font-size: 18px;
    }

    .tml-gopro-icon-times {
        color: #94a3b8;
        font-size: 16px;
    }

    /* Footer Banner */
    .tml-gopro-footer {
        text-align: center;
        padding: 24px 0 10px 0;
    }
</style>

<div class="tml-gopro-container">
    <!-- Hero Section -->
    <div class="tml-gopro-hero">
        <div class="tml-gopro-badge-icon">
            <i class="fa fa-star"></i>
        </div>
        <h1><?php esc_html_e('Upgrade to Testimonial Premium!', 'testimonial-maker'); ?></h1>
        <p>
            <?php esc_html_e('Unlock the full potential of your testimonials! Upgrading to Premium gets you access to all 17 stunning design templates, custom form builder, analytics dashboard, CSV import/export, video testimonials, advanced typography settings, and priority support.', 'testimonial-maker'); ?>
        </p>
        <a href="https://awplife.com/wordpress-plugins/testimonial-wordpress-plugin/" target="_blank" class="tml-gopro-btn-upgrade">
            <i class="fa fa-rocket"></i> <?php esc_html_e('Upgrade to Premium Now', 'testimonial-maker'); ?>
        </a>
    </div>

    <!-- Comparison Card -->
    <div class="tml-gopro-comparison-card">
        <h2 class="tml-gopro-comparison-title">
            <?php esc_html_e('Free vs Premium Features Comparison', 'testimonial-maker'); ?>
        </h2>

        <div class="tml-gopro-table-wrapper">
            <table class="tml-gopro-table">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Features', 'testimonial-maker'); ?></th>
                        <th style="text-align: center;"><?php esc_html_e('Free Version (Lite)', 'testimonial-maker'); ?></th>
                        <th style="text-align: center; color: #4f46e5; background: rgba(79, 70, 229, 0.03);"><?php esc_html_e('Premium Version (PRO)', 'testimonial-maker'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="tml-gopro-feature-name"><?php esc_html_e('Design Templates', 'testimonial-maker'); ?></div>
                            <div class="tml-gopro-feature-desc"><?php esc_html_e('Stunning layouts for your testimonials', 'testimonial-maker'); ?></div>
                        </td>
                        <td class="tml-gopro-col-free"><?php esc_html_e('3 Themes', 'testimonial-maker'); ?></td>
                        <td class="tml-gopro-col-pro" style="color: #4f46e5; font-weight: 700;"><?php esc_html_e('17 Themes', 'testimonial-maker'); ?></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="tml-gopro-feature-name"><?php esc_html_e('Layout Presets', 'testimonial-maker'); ?></div>
                            <div class="tml-gopro-feature-desc"><?php esc_html_e('Slider, Grid, Masonry, Filter options', 'testimonial-maker'); ?></div>
                        </td>
                        <td class="tml-gopro-col-free"><?php esc_html_e('Slider & Grid', 'testimonial-maker'); ?></td>
                        <td class="tml-gopro-col-pro" style="color: #4f46e5; font-weight: 700;"><?php esc_html_e('Slider, Grid, Masonry, List & Category Filter', 'testimonial-maker'); ?></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="tml-gopro-feature-name"><?php esc_html_e('Frontend Form Builder', 'testimonial-maker'); ?></div>
                            <div class="tml-gopro-feature-desc"><?php esc_html_e('Customize layout with drag-and-drop fields', 'testimonial-maker'); ?></div>
                        </td>
                        <td class="tml-gopro-col-free" style="font-size: 13px;"><?php esc_html_e('Standard Fields', 'testimonial-maker'); ?></td>
                        <td class="tml-gopro-col-pro" style="color: #4f46e5; font-weight: 700;"><?php esc_html_e('Premium Fields + Video Record, Social Profiles, and Google reCAPTCHA', 'testimonial-maker'); ?></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="tml-gopro-feature-name"><?php esc_html_e('Video Testimonials', 'testimonial-maker'); ?></div>
                            <div class="tml-gopro-feature-desc"><?php esc_html_e('YouTube, Vimeo and custom video reviews', 'testimonial-maker'); ?></div>
                        </td>
                        <td class="tml-gopro-col-free"><i class="fa fa-times tml-gopro-icon-times"></i></td>
                        <td class="tml-gopro-col-pro"><i class="fa fa-check-circle tml-gopro-icon-check"></i></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="tml-gopro-feature-name"><?php esc_html_e('Analytics & Performance Tracking', 'testimonial-maker'); ?></div>
                            <div class="tml-gopro-feature-desc"><?php esc_html_e('Detailed impressions, clicks, conversions reports', 'testimonial-maker'); ?></div>
                        </td>
                        <td class="tml-gopro-col-free"><i class="fa fa-times tml-gopro-icon-times"></i></td>
                        <td class="tml-gopro-col-pro"><i class="fa fa-check-circle tml-gopro-icon-check"></i></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="tml-gopro-feature-name"><?php esc_html_e('CSV Import & Export', 'testimonial-maker'); ?></div>
                            <div class="tml-gopro-feature-desc"><?php esc_html_e('Bulk migrate testimonials instantly', 'testimonial-maker'); ?></div>
                        </td>
                        <td class="tml-gopro-col-free"><i class="fa fa-times tml-gopro-icon-times"></i></td>
                        <td class="tml-gopro-col-pro"><i class="fa fa-check-circle tml-gopro-icon-check"></i></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="tml-gopro-feature-name"><?php esc_html_e('SEO Schema Rich Snippets', 'testimonial-maker'); ?></div>
                            <div class="tml-gopro-feature-desc"><?php esc_html_e('Show aggregate rating stars in Google search results', 'testimonial-maker'); ?></div>
                        </td>
                        <td class="tml-gopro-col-free"><i class="fa fa-times tml-gopro-icon-times"></i></td>
                        <td class="tml-gopro-col-pro"><i class="fa fa-check-circle tml-gopro-icon-check"></i></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="tml-gopro-feature-name"><?php esc_html_e('Advanced Typography', 'testimonial-maker'); ?></div>
                            <div class="tml-gopro-feature-desc"><?php esc_html_e('Google fonts, size, spacing and line-height settings', 'testimonial-maker'); ?></div>
                        </td>
                        <td class="tml-gopro-col-free"><i class="fa fa-times tml-gopro-icon-times"></i></td>
                        <td class="tml-gopro-col-pro"><i class="fa fa-check-circle tml-gopro-icon-check"></i></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="tml-gopro-feature-name"><?php esc_html_e('Advanced Navigation Options', 'testimonial-maker'); ?></div>
                            <div class="tml-gopro-feature-desc"><?php esc_html_e('Choose from 9 arrow positions and 5 chevron styles', 'testimonial-maker'); ?></div>
                        </td>
                        <td class="tml-gopro-col-free" style="font-size: 13px;"><?php esc_html_e('Basic positions & styles', 'testimonial-maker'); ?></td>
                        <td class="tml-gopro-col-pro"><i class="fa fa-check-circle tml-gopro-icon-check"></i></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="tml-gopro-feature-name"><?php esc_html_e('Live Ajax Category Filters', 'testimonial-maker'); ?></div>
                            <div class="tml-gopro-feature-desc"><?php esc_html_e('Frontend tab filters to filter testimonials instantly', 'testimonial-maker'); ?></div>
                        </td>
                        <td class="tml-gopro-col-free"><i class="fa fa-times tml-gopro-icon-times"></i></td>
                        <td class="tml-gopro-col-pro"><i class="fa fa-check-circle tml-gopro-icon-check"></i></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="tml-gopro-feature-name"><?php esc_html_e('Random Sorting Order', 'testimonial-maker'); ?></div>
                            <div class="tml-gopro-feature-desc"><?php esc_html_e('Randomize testimonials order dynamically on page load', 'testimonial-maker'); ?></div>
                        </td>
                        <td class="tml-gopro-col-free"><i class="fa fa-times tml-gopro-icon-times"></i></td>
                        <td class="tml-gopro-col-pro"><i class="fa fa-check-circle tml-gopro-icon-check"></i></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="tml-gopro-feature-name"><?php esc_html_e('Star Rating Customizations', 'testimonial-maker'); ?></div>
                            <div class="tml-gopro-feature-desc"><?php esc_html_e('Change star colors, alignment and styling size', 'testimonial-maker'); ?></div>
                        </td>
                        <td class="tml-gopro-col-free" style="font-size: 13px;"><?php esc_html_e('Basic rating stars', 'testimonial-maker'); ?></td>
                        <td class="tml-gopro-col-pro"><i class="fa fa-check-circle tml-gopro-icon-check"></i></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="tml-gopro-feature-name"><?php esc_html_e('Social Profiles Integration', 'testimonial-maker'); ?></div>
                            <div class="tml-gopro-feature-desc"><?php esc_html_e('Link clients Facebook, LinkedIn and Twitter profiles', 'testimonial-maker'); ?></div>
                        </td>
                        <td class="tml-gopro-col-free"><i class="fa fa-times tml-gopro-icon-times"></i></td>
                        <td class="tml-gopro-col-pro"><i class="fa fa-check-circle tml-gopro-icon-check"></i></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="tml-gopro-feature-name"><?php esc_html_e('Google reCAPTCHA v2', 'testimonial-maker'); ?></div>
                            <div class="tml-gopro-feature-desc"><?php esc_html_e('Enable Google reCAPTCHA integration to prevent fake spam submissions', 'testimonial-maker'); ?></div>
                        </td>
                        <td class="tml-gopro-col-free"><i class="fa fa-times tml-gopro-icon-times"></i></td>
                        <td class="tml-gopro-col-pro"><i class="fa fa-check-circle tml-gopro-icon-check"></i></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="tml-gopro-feature-name"><?php esc_html_e('Form Background Styling', 'testimonial-maker'); ?></div>
                            <div class="tml-gopro-feature-desc"><?php esc_html_e('Upload custom background images and select positions in the form builder', 'testimonial-maker'); ?></div>
                        </td>
                        <td class="tml-gopro-col-free" style="font-size: 13px;"><?php esc_html_e('Standard styles only', 'testimonial-maker'); ?></td>
                        <td class="tml-gopro-col-pro"><i class="fa fa-check-circle tml-gopro-icon-check"></i></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="tml-gopro-feature-name"><?php esc_html_e('Priority Support & Updates', 'testimonial-maker'); ?></div>
                            <div class="tml-gopro-feature-desc"><?php esc_html_e('Dedicated technical support and lifetime updates', 'testimonial-maker'); ?></div>
                        </td>
                        <td class="tml-gopro-col-free" style="font-size: 13px;"><?php esc_html_e('Community Forum', 'testimonial-maker'); ?></td>
                        <td class="tml-gopro-col-pro" style="color: #4f46e5; font-weight: 700;"><?php esc_html_e('Priority Email Support', 'testimonial-maker'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="tml-gopro-footer">
            <a href="https://awplife.com/wordpress-plugins/testimonial-wordpress-plugin/" target="_blank" class="tml-gopro-btn-upgrade">
                <i class="fa fa-rocket"></i> <?php esc_html_e('Upgrade to Premium Now', 'testimonial-maker'); ?>
            </a>
        </div>
    </div>
</div>
