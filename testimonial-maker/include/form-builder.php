<?php
if (!defined('ABSPATH'))
    exit;

wp_enqueue_media();
wp_enqueue_style('tml-mui-admin-css', TML_PLUGIN_URL . 'assets/css/tml-mui-admin.css', array(), TML_PLUGIN_VER);
wp_enqueue_style('font-awesome', TML_PLUGIN_URL . 'assets/css/font-awesome.min.css', array(), TML_PLUGIN_VER);

global $post;
$form_fields = get_post_meta($post->ID, 'tml_form_fields', true);
if (!is_array($form_fields)) {
    $form_fields = array(
        'name' => array('label' => 'Full Name', 'placeholder' => '', 'required' => 'yes'),
        'designation' => array('label' => 'Designation', 'placeholder' => '', 'required' => 'no'),
        'content' => array('label' => 'Testimonial Content', 'placeholder' => '', 'required' => 'yes'),
        'image' => array('label' => 'Image', 'placeholder' => '', 'required' => 'yes'),
        'video' => array('label' => 'Video Record/URL', 'placeholder' => '', 'required' => 'no'),
        'rating' => array('label' => 'Star Rating', 'placeholder' => '', 'required' => 'no'),
        'social' => array('label' => 'Social Profile', 'placeholder' => '', 'required' => 'no')
    );
}

$active_fields = get_post_meta($post->ID, 'tml_form_active_fields', true);
if (!is_array($active_fields) || empty($active_fields)) {
    $active_fields = array('name', 'designation', 'website', 'category', 'content', 'image', 'video', 'rating', 'social');
} else {
    // Make sure 'email' is removed from active list
    if (($key = array_search('email', $active_fields)) !== false) {
        unset($active_fields[$key]);
    }
}

// Additional Settings
$form_settings = get_post_meta($post->ID, 'tml_form_settings', true);
$get_fset = function ($key, $default = '') use ($form_settings) {
    return isset($form_settings[$key]) ? $form_settings[$key] : $default;
};

$available_fields = array(
    'name' => 'Full Name',
    'designation' => 'Designation',
    'website' => 'Website URL',
    'category' => 'Category Select',
    'content' => 'Testimonial Content',
    'image' => 'Image / Avatar',
    'video' => 'Video Record/URL',
    'rating' => 'Star Rating',
    'social' => 'Social Profile',
    'recaptcha' => 'Google reCAPTCHA'
);

$shortcode = '[TML_FORM id="' . $post->ID . '"]';
?>

<style>
    /* Material UI Accordion Styles */
    .tml-fb-accordion {
        background: #fff;
        border: 1px solid var(--tml-border);
        border-radius: 8px;
        margin-bottom: 12px;
        transition: box-shadow 0.3s ease;
        overflow: hidden;
    }

    .tml-fb-accordion:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-color: #d1d5db;
    }

    .tml-fb-acc-header {
        padding: 16px 20px;
        font-weight: 500;
        font-size: 0.875rem;
        color: var(--tml-text);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        user-select: none;
        background: #fff;
    }

    .tml-fb-acc-body {
        padding: 20px;
        border-top: 1px solid var(--tml-border);
        display: none;
        background: #fafafa;
    }

    .tml-fb-accordion.open .tml-fb-acc-body {
        display: block;
    }

    .tml-fb-accordion.open .fa-chevron-down {
        transform: rotate(180deg);
        color: var(--tml-primary) !important;
    }

    .tml-fb-accordion.open .tml-fb-acc-header {
        color: var(--tml-primary);
    }

    /* Styled Input Group from Screenshot */
    .tml-style-input-group {
        display: inline-flex;
        align-items: center;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
        height: 38px;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.07);
    }

    .tml-style-input-group-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 100%;
        background: #f0f0f1;
        border-right: 1px solid #ccd0d4;
        color: #50575e;
        font-size: 14px;
    }

    .tml-style-input-group input[type="number"],
    .tml-style-input-group select {
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
        margin: 0 !important;
        padding: 0 10px !important;
        height: 100% !important;
        font-size: 14px !important;
        color: #3c434a;
    }

    .tml-style-input-group input[type="number"] {
        width: 70px !important;
        text-align: center;
    }

    .tml-style-input-group select {
        width: 100px !important;
        cursor: pointer;
    }

    .tml-style-input-group-text {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 100%;
        background: #f0f0f1;
        border-left: 1px solid #ccd0d4;
        color: #50575e;
        font-size: 12px;
        font-weight: 600;
    }

    /* Styled Color Picker Trigger */
    .tml-color-picker-trigger {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
        padding: 4px 12px;
        background: #fff;
        cursor: pointer;
        height: 38px;
        box-sizing: border-box;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.07);
    }

    .tml-color-picker-trigger input[type="color"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .tml-color-preview-box {
        width: 22px;
        height: 22px;
        border-radius: 2px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .tml-color-text-box {
        font-size: 13px;
        color: #3c434a;
        font-weight: 500;
    }

    /* Layout Cards */
    .tml-layout-card {
        border: 2px solid transparent;
        border-radius: 6px;
        padding: 10px;
        background: #fff;
        position: relative;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        transition: all 0.2s;
        cursor: pointer;
    }

    .tml-layout-card.selected {
        border-color: #0073aa !important;
        box-shadow: 0 4px 8px rgba(0, 73, 170, 0.15);
    }

    .tml-layout-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
    }

    #tml-reset-settings-btn:hover {
        background: #fdf2f2 !important;
        border-color: #d32f2f !important;
        color: #d32f2f !important;
    }

    /* Background Position Cards */
    .tml-bg-position-card {
        border: 2px solid #ccd0d4;
        border-radius: 6px;
        padding: 0;
        background: #fff;
        position: relative;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        transition: all 0.2s;
        cursor: pointer;
        width: 140px;
        height: 110px;
        box-sizing: border-box;
        overflow: hidden;
    }

    .tml-bg-position-card.selected {
        border-color: #0073aa !important;
        box-shadow: 0 4px 8px rgba(0, 73, 170, 0.15);
    }

    .tml-bg-position-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
    }

    .tml-bg-position-badge {
        position: absolute;
        top: 4px;
        right: 4px;
        background: #0073aa;
        color: #fff;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 8px;
        z-index: 5;
    }

    .tml-bg-position-card.selected .tml-bg-position-badge {
        display: flex;
    }
</style>

<div class="tml-mui-container" style="display:flex; gap:24px; flex-wrap: wrap; margin-top:20px;">

    <!-- MAIN COLUMN -->
    <div style="flex: 1 1 70%; min-width: 400px;">

        <!-- SHORTCODE CARD -->
        <div class="tml-mui-card"
            style="margin-bottom:24px; padding:24px; display:flex; justify-content:space-between; align-items:center;">
            <div>
                <div class="tml-mui-card-title"
                    style="margin:0; border:0; padding:0; text-transform:none; font-size:1.1rem;">
                    <?php esc_html_e('Shortcode Generator', 'testimonial-maker'); ?>
                </div>
                <div class="tml-mui-description" style="margin-bottom:0; font-size:14px;">
                    <?php esc_html_e('Use this shortcode on any page to display this specific form configuration.', 'testimonial-maker'); ?>
                </div>
            </div>
            <code
                style="background:#f0f6fc; color:var(--tml-primary); padding:10px 20px; border-radius:6px; font-size:16px; font-weight:bold; border:1px solid #c8d9ea; user-select:all;"><?php echo esc_html($shortcode); ?></code>
        </div>

        <!-- TABS & EDITOR LAYOUT -->
        <div class="tml-mui-card" style="display:flex; padding:0; overflow:hidden;">
            <!-- VERTICAL TABS -->
            <div class="tml-mui-sidebar"
                style="width:240px; flex-shrink:0; border-right:1px solid var(--tml-border); padding: 20px 0; background: #fff;">
                <div class="tml-mui-nav-item active" data-tab="editor"><i class="fa fa-list-ul"></i>
                    <?php esc_html_e('FORM EDITOR', 'testimonial-maker'); ?></div>
                <div class="tml-mui-nav-item" data-tab="styles"><i class="fa fa-paint-brush"></i>
                    <?php esc_html_e('FORM STYLES', 'testimonial-maker'); ?></div>
                <div class="tml-mui-nav-item" data-tab="recaptcha"><i class="fa fa-shield"></i>
                    <?php esc_html_e('GOOGLE RECAPTCHA', 'testimonial-maker'); ?> <span
                        style="color: #d63638; font-weight: bold; font-size: 11px; margin-left: 5px;">PRO ★</span></div>
                <div class="tml-mui-nav-item" data-tab="background-image"><i class="fa fa-image"></i>
                    <?php esc_html_e('BACKGROUND IMAGE', 'testimonial-maker'); ?> <span
                        style="color: #d63638; font-weight: bold; font-size: 11px; margin-left: 5px;">PRO ★</span></div>
            </div>

            <!-- TAB CONTENTS -->
            <div style="flex:1; padding:30px; background:#fcfcfc;">
                <!-- EDITOR TAB -->
                <div id="tml-form-editor">
                    <p class="tml-mui-description" style="margin-top:0; margin-bottom:20px; font-style:italic;">Drag and
                        drop to reorder fields (visual only for now). Use the sidebar to toggle visibility.</p>

                    <?php foreach ($available_fields as $key => $title):
                        $is_active = in_array($key, $active_fields);
                        $field_data = isset($form_fields[$key]) ? $form_fields[$key] : array('label' => $title, 'placeholder' => '', 'required' => 'no');
                        ?>
                        <div class="tml-fb-accordion" id="acc_<?php echo esc_attr($key); ?>"
                            style="display: <?php echo $is_active ? 'block' : 'none'; ?>;">
                            <div class="tml-fb-acc-header">
                                <span style="display:flex; align-items:center;"><i class="fa fa-arrows-v"
                                        style="margin-right:12px; color:#ccc; cursor:grab;"></i>
                                    <?php echo esc_html($title); ?></span>
                                <i class="fa fa-chevron-down" style="color:#999; font-size:12px; transition:0.3s;"></i>
                            </div>
                            <div class="tml-fb-acc-body">
                                <div class="tml-mui-form-group">
                                    <label class="tml-mui-label">Label</label>
                                    <input type="text" class="tml-mui-input"
                                        name="tml_form_fields[<?php echo esc_attr($key); ?>][label]"
                                        value="<?php echo esc_attr($field_data['label']); ?>" style="width:100%;">
                                    <div class="tml-mui-description">To hide this label, leave it empty.</div>
                                </div>
                                <?php if ($key !== 'recaptcha'): ?>
                                    <div class="tml-mui-form-group">
                                        <label class="tml-mui-label">Placeholder</label>
                                        <input type="text" class="tml-mui-input"
                                            name="tml_form_fields[<?php echo esc_attr($key); ?>][placeholder]"
                                            value="<?php echo esc_attr($field_data['placeholder']); ?>" style="width:100%;">
                                    </div>
                                <?php endif; ?>
                                <?php if ($key !== 'rating' && $key !== 'image' && $key !== 'video' && $key !== 'recaptcha'): ?>
                                    <div class="tml-mui-form-group"
                                        style="flex-direction:row; justify-content:space-between; align-items:center; margin-bottom:0;">
                                        <div>
                                            <label class="tml-mui-label" style="margin-bottom:0;">Required Field</label>
                                            <div class="tml-mui-description">Make this field mandatory for submission.</div>
                                        </div>
                                        <label class="tml-mui-switch">
                                            <input type="hidden" name="tml_form_fields[<?php echo esc_attr($key); ?>][required]"
                                                value="no">
                                            <input type="checkbox"
                                                name="tml_form_fields[<?php echo esc_attr($key); ?>][required]" value="yes"
                                                <?php checked($field_data['required'], 'yes'); ?>>
                                            <span class="tml-mui-slider"></span>
                                        </label>
                                    </div>
                                <?php else: ?>
                                    <input type="hidden" name="tml_form_fields[<?php echo esc_attr($key); ?>][required]"
                                        value="yes">
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>



                <!-- FORM STYLES TAB -->
                <div id="tml-tab-styles" style="display:none;">

                    <!-- Form Layout Section -->
                    <div class="tml-mui-form-group" style="margin-bottom: 24px;">
                        <label class="tml-mui-label" style="font-weight:600; font-size:14px; margin-bottom:4px;">Form
                            Layout</label>
                        <div class="tml-mui-description" style="margin-bottom:12px;">Choose a testimonial form layout.
                        </div>
                        <div style="display:flex; gap:20px; flex-wrap:wrap;">
                            <!-- Style One -->
                            <div style="position:relative; width: 140px; text-align:center;">
                                <label style="cursor:pointer; display:block;">
                                    <input type="radio" name="tml_form_settings[form_layout]" value="style_one" <?php checked($get_fset('form_layout', 'style_one'), 'style_one'); ?>
                                        style="display:none;">
                                    <div class="tml-layout-card <?php echo $get_fset('form_layout', 'style_one') === 'style_one' ? 'selected' : ''; ?>"
                                        id="tml-layout-one">
                                        <!-- Select Checkmark Badge -->
                                        <span class="tml-layout-badge"
                                            style="position:absolute; top:-8px; right:-8px; background:#0073aa; color:#fff; width:20px; height:20px; border-radius:50%; display:<?php echo $get_fset('form_layout', 'style_one') === 'style_one' ? 'flex' : 'none'; ?>; align-items:center; justify-content:center; font-size:10px;"><i
                                                class="fa fa-check"></i></span>
                                        <svg width="100" height="120" viewBox="0 0 100 120" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" style="display:block; margin:0 auto;">
                                            <rect x="5" y="10" width="60" height="4" rx="2" fill="#888" />
                                            <rect x="5" y="20" width="80" height="24" rx="3" fill="none"
                                                stroke="#ccc" />
                                            <rect x="5" y="50" width="70" height="4" rx="2" fill="#888" />
                                            <rect x="5" y="60" width="80" height="34" rx="3" fill="none"
                                                stroke="#ccc" />
                                            <circle cx="10" cy="105" r="4" fill="#ffb600" />
                                            <circle cx="20" cy="105" r="4" fill="#ffb600" />
                                            <circle cx="30" cy="105" r="4" fill="#ffb600" />
                                            <circle cx="40" cy="105" r="4" fill="#ffb600" />
                                            <circle cx="50" cy="105" r="4" fill="#ffb600" />
                                            <rect x="5" y="112" width="20" height="4" rx="2" fill="#888" />
                                        </svg>
                                    </div>
                                    <div style="font-weight:600; font-size:13px; margin-top:8px; color:#555;">Style One
                                    </div>
                                </label>
                            </div>

                            <!-- Style Two -->
                            <!-- Style Two (PRO Locked) -->
                            <div style="position:relative; width: 140px; text-align:center;">
                                <div
                                    style="position: absolute; top: -5px; right: -5px; background: #d63638; color: #fff; font-size: 10px; font-weight: bold; padding: 2px 6px; border-radius: 4px; z-index: 10; pointer-events: none;">
                                    PRO</div>
                                <div style="filter: blur(1.5px); opacity: 0.6; pointer-events: none; cursor: not-allowed;"
                                    title="<?php esc_attr_e('Available in PRO version', 'testimonial-maker'); ?>">
                                    <div class="tml-layout-card" id="tml-layout-two">
                                        <svg width="100" height="120" viewBox="0 0 100 120" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" style="display:block; margin:0 auto;">
                                            <!-- Row 1: Name Input -->
                                            <rect x="5" y="15" width="22" height="4" rx="2" fill="#888" />
                                            <rect x="35" y="10" width="60" height="14" rx="3" fill="none"
                                                stroke="#ccc" />

                                            <!-- Row 2: Message/Textarea Input -->
                                            <rect x="5" y="40" width="22" height="4" rx="2" fill="#888" />
                                            <rect x="35" y="32" width="60" height="24" rx="3" fill="none"
                                                stroke="#ccc" />

                                            <!-- Row 3: Ratings -->
                                            <rect x="5" y="70" width="22" height="4" rx="2" fill="#888" />
                                            <circle cx="40" cy="72" r="3" fill="#ffb600" />
                                            <circle cx="48" cy="72" r="3" fill="#ffb600" />
                                            <circle cx="56" cy="72" r="3" fill="#ffb600" />
                                            <circle cx="64" cy="72" r="3" fill="#ffb600" />
                                            <circle cx="72" cy="72" r="3" fill="#ffb600" />

                                            <!-- Row 4: Submit Buttons -->
                                            <rect x="35" y="94" width="24" height="10" rx="3" fill="#0073aa" />
                                            <rect x="64" y="94" width="24" height="10" rx="3" fill="none"
                                                stroke="#ccc" />
                                        </svg>
                                    </div>
                                    <div style="font-weight:600; font-size:13px; margin-top:8px; color:#555;">Style Two
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Width Section -->
                    <div class="tml-mui-form-group" style="margin-bottom: 24px;">
                        <label class="tml-mui-label" style="font-weight:600; font-size:14px; margin-bottom:4px;">Form
                            Width</label>
                        <div class="tml-mui-description" style="margin-bottom:10px;">Set a custom width for the
                            testimonial form.</div>
                        <div class="tml-style-input-group">
                            <span class="tml-style-input-group-icon"><i class="fa fa-arrows-h"></i></span>
                            <input type="number" name="tml_form_settings[form_width]"
                                value="<?php echo esc_attr($get_fset('form_width', '680')); ?>" placeholder="680">
                            <span class="tml-style-input-group-text">px</span>
                        </div>
                    </div>

                    <!-- Form Top Spacing Section -->
                    <div class="tml-mui-form-group" style="margin-bottom: 24px;">
                        <label class="tml-mui-label" style="font-weight:600; font-size:14px; margin-bottom:4px;">Form
                            Top Spacing</label>
                        <div class="tml-mui-description" style="margin-bottom:10px;">Set top spacing (margin-top) for
                            the testimonial form.</div>
                        <div class="tml-style-input-group">
                            <span class="tml-style-input-group-icon"><i class="fa fa-arrows-v"></i></span>
                            <input type="number" name="tml_form_settings[form_margin_top]"
                                value="<?php echo esc_attr($get_fset('form_margin_top', '40')); ?>" placeholder="40">
                            <span class="tml-style-input-group-text">px</span>
                        </div>
                    </div>

                    <!-- Label Color Section -->
                    <div class="tml-mui-form-group" style="margin-bottom: 24px;">
                        <label class="tml-mui-label" style="font-weight:600; font-size:14px; margin-bottom:4px;">Label
                            Color</label>
                        <div class="tml-mui-description" style="margin-bottom:10px;">Set color for the field label.
                        </div>
                        <div class="tml-color-picker-trigger">
                            <span class="tml-color-preview-box"
                                style="background-color: <?php echo esc_attr($get_fset('label_color', '#333333')); ?>;"></span>
                            <span class="tml-color-text-box">Select Color</span>
                            <input type="color" name="tml_form_settings[label_color]"
                                value="<?php echo esc_attr($get_fset('label_color', '#333333')); ?>">
                        </div>
                    </div>

                    <!-- Input Field Styling Section -->
                    <div class="tml-mui-form-group" style="margin-bottom: 24px;">
                        <label class="tml-mui-label" style="font-weight:600; font-size:14px; margin-bottom:4px;">Input
                            Field</label>
                        <div class="tml-mui-description" style="margin-bottom:10px;">Set input field style.</div>
                        <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
                            <!-- BG Color -->
                            <div style="display:flex; flex-direction:column; gap:4px;">
                                <span style="font-size:11px; color:#666; font-weight:600;">BG Color</span>
                                <div class="tml-color-picker-trigger">
                                    <span class="tml-color-preview-box"
                                        style="background-color: <?php echo esc_attr($get_fset('input_bg', '#ffffff')); ?>;"></span>
                                    <span class="tml-color-text-box">Select Color</span>
                                    <input type="color" name="tml_form_settings[input_bg]"
                                        value="<?php echo esc_attr($get_fset('input_bg', '#ffffff')); ?>">
                                </div>
                            </div>
                            <!-- Radius -->
                            <div style="display:flex; flex-direction:column; gap:4px;">
                                <span style="font-size:11px; color:#666; font-weight:600;">Radius</span>
                                <div class="tml-style-input-group">
                                    <span class="tml-style-input-group-icon"><i class="fa fa-crop"></i></span>
                                    <input type="number" name="tml_form_settings[input_radius]"
                                        value="<?php echo esc_attr($get_fset('input_radius', '4')); ?>" placeholder="4">
                                    <span class="tml-style-input-group-text">px</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Background Section -->
                    <div class="tml-mui-form-group" style="margin-bottom: 24px;">
                        <label class="tml-mui-label" style="font-weight:600; font-size:14px; margin-bottom:4px;">Form
                            Background Color</label>
                        <div class="tml-mui-description" style="margin-bottom:10px;">Set testimonial form background
                            color style.</div>
                        <div class="tml-color-picker-trigger">
                            <span class="tml-color-preview-box"
                                style="background-color: <?php echo esc_attr($get_fset('form_bg', '#ffffff')); ?>;"></span>
                            <span class="tml-color-text-box">Select Color</span>
                            <input type="color" name="tml_form_settings[form_bg]"
                                value="<?php echo esc_attr($get_fset('form_bg', '#ffffff')); ?>">
                        </div>
                    </div>

                    <!-- Submit Button Section -->
                    <div class="tml-mui-form-group" style="margin-bottom: 24px;">
                        <label class="tml-mui-label" style="font-weight:600; font-size:14px; margin-bottom:4px;">Submit
                            Button</label>
                        <div class="tml-mui-description" style="margin-bottom:10px;">Customize your submit button text
                            and colors.</div>

                        <!-- Text Input -->
                        <div style="margin-bottom:12px;">
                            <span
                                style="font-size:11px; color:#666; font-weight:600; display:block; margin-bottom:4px;">Button
                                Text</span>
                            <input type="text" class="tml-mui-input" name="tml_form_settings[submit_text]"
                                value="<?php echo esc_attr($get_fset('submit_text', 'Submit Testimonial')); ?>"
                                style="width:100%; max-width:350px;">
                        </div>

                        <!-- Colors Selection -->
                        <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap;">
                            <!-- Button BG Color -->
                            <div style="display:flex; flex-direction:column; gap:4px;">
                                <span style="font-size:11px; color:#666; font-weight:600;">BG Color</span>
                                <div class="tml-color-picker-trigger">
                                    <span class="tml-color-preview-box"
                                        style="background-color: <?php echo esc_attr($get_fset('btn_bg_color', '#0073aa')); ?>;"></span>
                                    <span class="tml-color-text-box">Select Color</span>
                                    <input type="color" name="tml_form_settings[btn_bg_color]"
                                        value="<?php echo esc_attr($get_fset('btn_bg_color', '#0073aa')); ?>">
                                </div>
                            </div>
                            <!-- Button Text Color -->
                            <div style="display:flex; flex-direction:column; gap:4px;">
                                <span style="font-size:11px; color:#666; font-weight:600;">Text Color</span>
                                <div class="tml-color-picker-trigger">
                                    <span class="tml-color-preview-box"
                                        style="background-color: <?php echo esc_attr($get_fset('btn_text_color', '#ffffff')); ?>;"></span>
                                    <span class="tml-color-text-box">Select Color</span>
                                    <input type="color" name="tml_form_settings[btn_text_color]"
                                        value="<?php echo esc_attr($get_fset('btn_text_color', '#ffffff')); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reset Settings Section -->
                    <div
                        style="margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--tml-border); display: flex; justify-content: flex-end;">
                        <button type="button" id="tml-reset-settings-btn" class="button button-secondary"
                            style="height: 38px; padding: 0 16px; display: flex; align-items: center; gap: 8px; color: #d32f2f; border-color: #d32f2f; font-weight: 500; background: #fff; transition: all 0.2s; cursor: pointer; border-radius: 4px;">
                            <i class="fa fa-refresh"></i> Reset Styling Defaults
                        </button>
                    </div>

                </div>

                <!-- GOOGLE RECAPTCHA TAB -->
                <div id="tml-tab-recaptcha" style="display:none; position: relative; min-height: 250px;">
                    <!-- Small PRO Link at the top -->
                    <div
                        style="background: #fff5f5; border: 1px solid #feb2b2; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; gap: 15px;">
                        <span style="font-size: 13px; color: #c53030; font-weight: 500;">
                            🔒 <strong>Google reCAPTCHA v2</strong> is a Premium Feature.
                        </span>
                        <a href="https://awplife.com/demo/testimonial-premium/testimonial-form/" target="_blank"
                            style="color: #fff; background: #d63638; border: none; padding: 6px 12px; font-size: 12px; font-weight: bold; border-radius: 4px; text-decoration: none; display: inline-block; transition: background 0.2s;"><?php esc_html_e('Get PRO Version ★', 'testimonial-maker'); ?></a>
                    </div>

                    <!-- Non-blurred Content -->
                    <div style="pointer-events: none; opacity: 0.85;">
                        <div class="tml-mui-form-group" style="margin-bottom: 24px;">
                            <label class="tml-mui-label"
                                style="font-weight:600; font-size:14px; margin-bottom:4px;">Google reCAPTCHA v2
                                (Checkbox)</label>
                            <div class="tml-mui-description" style="margin-bottom:15px;">Secure your form from spam by
                                enabling Google reCAPTCHA.</div>

                            <div style="margin-bottom:20px;">
                                <label class="tml-mui-label"
                                    style="font-size:11px; color:#666; font-weight:600; display:block; margin-bottom:6px;">reCAPTCHA
                                    Site Key</label>
                                <input type="text" class="tml-mui-input" value="6Ld...sitekey"
                                    style="width:100%; max-width:450px;" disabled>
                            </div>

                            <div style="margin-bottom:20px;">
                                <label class="tml-mui-label"
                                    style="font-size:11px; color:#666; font-weight:600; display:block; margin-bottom:6px;">reCAPTCHA
                                    Secret Key</label>
                                <input type="text" class="tml-mui-input" value="6Ld...secretkey"
                                    style="width:100%; max-width:450px;" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BACKGROUND IMAGE TAB -->
                <div id="tml-tab-background-image" style="display:none; position: relative; min-height: 250px;">
                    <!-- Small PRO Link at the top -->
                    <div
                        style="background: #fff5f5; border: 1px solid #feb2b2; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; gap: 15px;">
                        <span style="font-size: 13px; color: #c53030; font-weight: 500;">
                            🖼️ <strong>Form Background Image</strong> is a Premium Feature.
                        </span>
                        <a href="https://awplife.com/demo/testimonial-premium/testimonial-form/" target="_blank"
                            style="color: #fff; background: #d63638; border: none; padding: 6px 12px; font-size: 12px; font-weight: bold; border-radius: 4px; text-decoration: none; display: inline-block; transition: background 0.2s;"><?php esc_html_e('Get PRO Version ★', 'testimonial-maker'); ?></a>
                    </div>

                    <!-- Non-blurred Content -->
                    <div style="pointer-events: none; opacity: 0.85;">
                        <!-- Enable Form Background Image -->
                        <div
                            style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; border-bottom:1px solid #e2e8f0; padding-bottom:20px;">
                            <div>
                                <h4 style="margin:0; font-weight:600; font-size:15px; color:#1e293b;">Enable Form
                                    Background Image</h4>
                                <p style="margin:4px 0 0 0; font-size:13px; color:#64748b;">Add a custom background
                                    image to your testimonial submission form.</p>
                            </div>
                            <label class="tml-mui-switch" style="cursor: not-allowed;">
                                <input type="checkbox" disabled checked>
                                <span class="tml-mui-slider" style="background-color: #2196F3;"></span>
                            </label>
                        </div>

                        <!-- Upload Background Image -->
                        <div class="tml-mui-form-group" style="margin-bottom: 24px;">
                            <label class="tml-mui-label"
                                style="font-weight:600; font-size:14px; margin-bottom:4px;">Upload Background
                                Image</label>
                            <div class="tml-mui-description" style="margin-bottom:12px;">Select or upload an image to
                                use as the background.</div>

                            <!-- Dashed Box with Sunset Mountain Image Preview -->
                            <div
                                style="border: 2px dashed #ccd0d4; background: #fafafa; border-radius: 6px; padding: 24px; text-align: center; margin-bottom: 15px;">
                                <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=400&h=300&q=80"
                                    style="max-height: 180px; border-radius: 4px; box-shadow: 0 4px 10px rgba(0,0,0,0.15); display: inline-block;"
                                    alt="Background Preview">
                            </div>

                            <!-- Buttons -->
                            <div style="display:flex; gap:10px;">
                                <button type="button" class="button button-secondary"
                                    style="border-color: #2271b1; color: #2271b1; height: 38px; padding: 0 16px; font-weight: 500; background:#fff; border-radius: 4px; display:inline-flex; align-items:center; gap:6px;"
                                    disabled>
                                    <span class="dashicons dashicons-upload"
                                        style="font-size:16px; width:16px; height:16px; line-height:16px;"></span>
                                    Select / Upload Image
                                </button>
                                <button type="button" class="button"
                                    style="border-color: #d63638; color: #d63638; height: 38px; padding: 0 16px; font-weight: 500; background:#fff; border-radius: 4px;"
                                    disabled>Remove</button>
                            </div>
                        </div>

                        <!-- Image Position Layout Options -->
                        <div class="tml-mui-form-group" style="margin-bottom: 24px;">
                            <label class="tml-mui-label"
                                style="font-weight:600; font-size:14px; margin-bottom:4px;">Image Position</label>
                            <div class="tml-mui-description" style="margin-bottom:10px;">Choose where the background
                                image should be positioned relative to the form.</div>
                            <div style="display:flex; gap:20px; flex-wrap:wrap; margin-top:10px;">

                                <!-- Behind Form -->
                                <div style="width: 140px; text-align:center;">
                                    <div class="tml-bg-position-card"
                                        style="border: 1.5px solid #ccd0d4; border-radius: 6px; width: 140px; height: 110px; overflow: hidden; background: #fff; position: relative;">
                                        <svg width="136" height="106" viewBox="0 0 136 106" fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                            style="display:block; margin: 2px auto 0;">
                                            <!-- Checkered Background Pattern -->
                                            <rect width="136" height="106" fill="#e9edf0" />
                                            <path
                                                d="M 0,0 L 136,106 M 0,20 L 136,126 M 0,40 L 136,146 M 0,60 L 136,166 M 0,80 L 136,186 M 0,100 L 136,206 M 20,0 L 156,106 M 40,0 L 176,106 M 60,0 L 196,106 M 80,0 L 216,106 M 100,0 L 236,106 M 120,0 L 256,106"
                                                stroke="#fff" stroke-width="1.5" stroke-dasharray="2 3" opacity="0.6" />
                                            <!-- Centered White Form Card -->
                                            <rect x="23" y="18" width="90" height="70" rx="4" fill="#fff"
                                                stroke="#ccd0d4" stroke-width="1.5" />
                                            <!-- Form Elements -->
                                            <rect x="33" y="33" width="70" height="8" rx="2" fill="none" stroke="#ddd"
                                                stroke-width="1.5" />
                                            <rect x="33" y="49" width="70" height="8" rx="2" fill="none" stroke="#ddd"
                                                stroke-width="1.5" />
                                            <rect x="33" y="65" width="30" height="10" rx="2" fill="#2271b1" />
                                        </svg>
                                    </div>
                                    <div style="font-weight:600; font-size:12px; margin-top:8px; color:#555;">Behind
                                        Form</div>
                                </div>

                                <!-- Left Side (Selected) -->
                                <div style="width: 140px; text-align:center; position:relative;">
                                    <span
                                        style="position:absolute; top:-8px; right:-8px; background:#2271b1; color:#fff; width:20px; height:20px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:10px; z-index:10;"><i
                                            class="fa fa-check"></i></span>
                                    <div class="tml-bg-position-card"
                                        style="border: 2px solid #2271b1; border-radius: 6px; width: 140px; height: 110px; overflow: hidden; background: #fff; position: relative; box-shadow: 0 2px 8px rgba(34,113,177,0.15);">
                                        <svg width="136" height="106" viewBox="0 0 136 106" fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                            style="display:block; margin: 2px auto 0;">
                                            <!-- Left side background pattern -->
                                            <rect width="45" height="106" fill="#e9edf0" />
                                            <path
                                                d="M -20,0 L 45,65 M -20,20 L 45,85 M -20,40 L 45,105 M -20,60 L 45,125 M -20,80 L 45,145 M -20,100 L 45,165 M 0,0 L 65,65 M 20,0 L 85,65 M 40,0 L 105,65"
                                                stroke="#fff" stroke-width="1.5" stroke-dasharray="2 3" opacity="0.6" />
                                            <!-- Separator line -->
                                            <line x1="45" y1="0" x2="45" y2="106" stroke="#ccd0d4" stroke-width="1.5" />
                                            <!-- Right side form elements -->
                                            <rect x="55" y="25" width="70" height="8" rx="2" fill="none" stroke="#ddd"
                                                stroke-width="1.5" />
                                            <rect x="55" y="41" width="70" height="8" rx="2" fill="none" stroke="#ddd"
                                                stroke-width="1.5" />
                                            <rect x="55" y="57" width="70" height="8" rx="2" fill="none" stroke="#ddd"
                                                stroke-width="1.5" />
                                            <rect x="55" y="73" width="30" height="10" rx="2" fill="#2271b1" />
                                            <!-- Thumbnail image placeholder -->
                                            <rect x="12" y="43" width="20" height="20" rx="2" fill="none" stroke="#fff"
                                                stroke-width="1.5" />
                                            <path d="M 12,58 L 17,53 L 22,58 M 20,56 L 24,52 L 32,60" stroke="#fff"
                                                stroke-width="1.5" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div style="font-weight:600; font-size:12px; margin-top:8px; color:#555;">Left Side
                                    </div>
                                </div>

                                <!-- Right Side -->
                                <div style="width: 140px; text-align:center;">
                                    <div class="tml-bg-position-card"
                                        style="border: 1.5px solid #ccd0d4; border-radius: 6px; width: 140px; height: 110px; overflow: hidden; background: #fff; position: relative;">
                                        <svg width="136" height="106" viewBox="0 0 136 106" fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                            style="display:block; margin: 2px auto 0;">
                                            <!-- Right side background pattern -->
                                            <rect x="91" width="45" height="106" fill="#e9edf0" />
                                            <path
                                                d="M 71,0 L 136,65 M 71,20 L 136,85 M 71,40 L 136,105 M 71,60 L 136,125 M 71,80 L 136,145 M 71,100 L 136,165 M 91,0 L 156,65 M 111,0 L 176,65 M 131,0 L 196,65"
                                                stroke="#fff" stroke-width="1.5" stroke-dasharray="2 3" opacity="0.6" />
                                            <!-- Separator line -->
                                            <line x1="91" y1="0" x2="91" y2="106" stroke="#ccd0d4" stroke-width="1.5" />
                                            <!-- Left side form elements -->
                                            <rect x="11" y="25" width="70" height="8" rx="2" fill="none" stroke="#ddd"
                                                stroke-width="1.5" />
                                            <rect x="11" y="41" width="70" height="8" rx="2" fill="none" stroke="#ddd"
                                                stroke-width="1.5" />
                                            <rect x="11" y="57" width="70" height="8" rx="2" fill="none" stroke="#ddd"
                                                stroke-width="1.5" />
                                            <rect x="11" y="73" width="30" height="10" rx="2" fill="#2271b1" />
                                            <!-- Thumbnail image placeholder -->
                                            <rect x="103" y="43" width="20" height="20" rx="2" fill="none" stroke="#fff"
                                                stroke-width="1.5" />
                                            <path d="M 103,58 L 108,53 L 113,58 M 111,56 L 115,52 L 123,60"
                                                stroke="#fff" stroke-width="1.5" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div style="font-weight:600; font-size:12px; margin-top:8px; color:#555;">Right Side
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Image Column Width -->
                        <div class="tml-mui-form-group" style="margin-bottom: 24px;">
                            <label class="tml-mui-label"
                                style="font-weight:600; font-size:14px; margin-bottom:4px;">Image Column Width</label>
                            <div class="tml-mui-description" style="margin-bottom:10px;">Set the width of the background
                                image column in the split layout.</div>
                            <div class="tml-style-input-group" style="opacity:0.8;">
                                <span class="tml-style-input-group-icon"><i class="fa fa-arrows-h"></i></span>
                                <input type="number" value="500" style="width: 70px !important; text-align: center;"
                                    disabled>
                                <span class="tml-style-input-group-text">px</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SIDEBAR -->
    <div style="flex: 0 0 320px;">
        <div class="tml-mui-card" style="padding:0; overflow:hidden;">
            <div style="background:#f9f9f9; padding:20px; border-bottom:1px solid var(--tml-border);">
                <div class="tml-mui-card-title" style="margin:0; padding:0; border:0; font-size:1rem;">Testimonial Form
                    Fields</div>
                <div class="tml-mui-description" style="margin-top:5px; margin-bottom:0;">Toggle which fields to show.
                </div>
            </div>
            <div style="padding:10px 20px;">
                <?php foreach ($available_fields as $key => $title):
                    $is_pro_field = in_array($key, array('video', 'social', 'recaptcha'));
                    ?>
                    <div
                        style="display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid #eee; <?php echo $is_pro_field ? 'opacity: 0.6;' : ''; ?>">
                        <span style="font-weight:500; font-size:14px; color:#333;">
                            <?php echo esc_html($title); ?>
                            <?php if ($is_pro_field): ?>
                                <span style="color: #d63638; font-weight: bold; font-size: 11px; margin-left: 5px;">PRO ★</span>
                            <?php endif; ?>
                        </span>
                        <?php if ($is_pro_field): ?>
                            <label class="tml-mui-switch" style="cursor: not-allowed;"
                                title="<?php esc_attr_e('Available in PRO version', 'testimonial-maker'); ?>">
                                <input type="checkbox" disabled>
                                <span class="tml-mui-slider" style="background-color: #ccc;"></span>
                            </label>
                        <?php else: ?>
                            <label class="tml-mui-switch">
                                <input type="checkbox" class="tml-field-toggle" value="<?php echo esc_attr($key); ?>"
                                    name="tml_form_active_fields[]" <?php checked(in_array($key, $active_fields)); ?>>
                                <span class="tml-mui-slider"></span>
                            </label>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>

<script>
    jQuery(document).ready(function ($) {
        // Styled Color Picker updates
        $('.tml-color-picker-trigger input[type="color"]').on('input change', function () {
            var color = $(this).val();
            $(this).siblings('.tml-color-preview-box').css('background-color', color);
        });

        // Reset Styling Defaults
        $('#tml-reset-settings-btn').on('click', function (e) {
            e.preventDefault();
            if (confirm('Are you sure you want to reset all form style settings to defaults?')) {
                // 1. Reset Form Width
                $('input[name="tml_form_settings[form_width]"]').val('680');

                // 1.5. Reset Form Top Spacing
                $('input[name="tml_form_settings[form_margin_top]"]').val('40');

                // 2. Reset Label Color
                $('input[name="tml_form_settings[label_color]"]').val('#333333').trigger('change');

                // 3. Reset Input BG Color
                $('input[name="tml_form_settings[input_bg]"]').val('#ffffff').trigger('change');

                // 4. Reset Input Radius
                $('input[name="tml_form_settings[input_radius]"]').val('4');

                // 5. Reset Form BG
                $('input[name="tml_form_settings[form_bg]"]').val('#ffffff').trigger('change');

                // 5.5. Reset Submit Button Settings
                $('input[name="tml_form_settings[submit_text]"]').val('Submit Testimonial');
                $('input[name="tml_form_settings[btn_bg_color]"]').val('#0073aa').trigger('change');
                $('input[name="tml_form_settings[btn_text_color]"]').val('#ffffff').trigger('change');

                // 6. Reset layout to Style One
                $('input[name="tml_form_settings[form_layout]"][value="style_one"]').prop('checked', true).trigger('change');
            }
        });

        // Form Layout Selection
        $('input[name="tml_form_settings[form_layout]"]').on('change', function () {
            $('.tml-layout-card').removeClass('selected');
            $('.tml-layout-badge').hide();

            if ($(this).is(':checked')) {
                var $card = $(this).siblings('.tml-layout-card');
                $card.addClass('selected');
                $card.find('.tml-layout-badge').css('display', 'flex');
            }
        });

        // Accordion Logic
        $('.tml-fb-acc-header').on('click', function () {
            var $acc = $(this).parent();
            $acc.toggleClass('open');
        });

        // Toggle Field Visibility from Sidebar
        $('.tml-field-toggle').on('change', function () {
            var key = $(this).val();
            if ($(this).is(':checked')) {
                $('#acc_' + key).slideDown();
            } else {
                $('#acc_' + key).slideUp();
            }
        });

        // Tabs
        $('.tml-mui-nav-item').on('click', function () {
            $('.tml-mui-nav-item').removeClass('active');
            $(this).addClass('active');

            var tab = $(this).data('tab');
            $('#tml-form-editor, #tml-tab-styles, #tml-tab-recaptcha, #tml-tab-background-image').hide();

            if (tab == 'editor') $('#tml-form-editor').fadeIn(200);
            if (tab == 'styles') $('#tml-tab-styles').fadeIn(200);
            if (tab == 'recaptcha') $('#tml-tab-recaptcha').fadeIn(200);
            if (tab == 'background-image') $('#tml-tab-background-image').fadeIn(200);
        });

        // Toggle Button Group highlight sync
        $('.tml-mui-toggle-label input[type="radio"]').on('change', function () {
            var name = $(this).attr('name');
            $('input[name="' + name + '"]').closest('.tml-mui-toggle-label').removeClass('active');
            if ($(this).is(':checked')) {
                $(this).closest('.tml-mui-toggle-label').addClass('active');
            }
        });
    });
</script>