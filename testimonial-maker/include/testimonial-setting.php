<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

global $post;
$is_cpt = (isset($post) && $post->post_type == 'tml-shortcode');

if ($is_cpt) {
    $testimonial_settings = get_post_meta($post->ID, 'testimonial_settings', true);
    $shortcode_base = '[TML id="' . $post->ID . '"';
} else {
    $testimonial_settings = get_option('testimonial_settings');
    $shortcode_base = '[TML';
}

wp_enqueue_script('wp-color-picker');
wp_enqueue_style('wp-color-picker');
wp_enqueue_script('jquery-ui-sortable');
wp_enqueue_style('tml-mui-admin-css', TML_PLUGIN_URL . 'assets/css/tml-mui-admin.css', array(), TML_PLUGIN_VER);
wp_enqueue_style('font-awesome', TML_PLUGIN_URL . 'assets/css/font-awesome.min.css', array(), TML_PLUGIN_VER);

// Enqueue frontend scripts and styles for live preview Modal
wp_enqueue_style('tml-bootstrap-css', TML_PLUGIN_URL . 'assets/css/tml-frontend-bootstrap.css', array(), TML_PLUGIN_VER);
wp_enqueue_style('tml-owl-carousel-css', TML_PLUGIN_URL . 'assets/css/owl.carousel.css', array(), TML_PLUGIN_VER);
wp_enqueue_style('tml-owl-theme-css', TML_PLUGIN_URL . 'assets/css/owl.theme.default.css', array(), TML_PLUGIN_VER);
wp_enqueue_style('tml-owl-animate-css', TML_PLUGIN_URL . 'assets/css/animate.css', array(), TML_PLUGIN_VER);
wp_enqueue_script('tml-owl-js', TML_PLUGIN_URL . 'assets/js/owl.carousel.js', array('jquery'), TML_PLUGIN_VER, false);

// Fallback logic for all variables
$get_val = function ($key, $default = '') use ($testimonial_settings) {
    return isset($testimonial_settings[$key]) ? $testimonial_settings[$key] : $default;
};

$design = $get_val('testimonial_carousel_design', 1);
$layout_preset = $get_val('tml_layout_preset', 'slider');
if (!in_array($layout_preset, array('slider', 'grid'))) {
    $layout_preset = 'slider';
}

if (!function_exists('tml_render_typography_section')) {
    function tml_render_typography_section($label, $sub_label, $prefix, $get_val, $color_key = '')
    {
        $color_key = !empty($color_key) ? $color_key : $prefix . '_color';
        $fonts = array(
            'Default' => 'inherit',
            'Arial' => 'Arial, Helvetica, sans-serif',
            'Open Sans' => "'Open Sans', sans-serif",
            'Roboto' => "'Roboto', sans-serif",
            'Lato' => "'Lato', sans-serif",
            'Montserrat' => "'Montserrat', sans-serif",
            'Oswald' => "'Oswald', sans-serif",
            'Poppins' => "'Poppins', sans-serif",
            'Inter' => "'Inter', sans-serif",
            'Ubuntu' => "'Ubuntu', sans-serif",
            'Playfair Display' => "'Playfair Display', serif",
            'Merriweather' => "'Merriweather', serif",
            'Lora' => "'Lora', serif",
        );
        ?>
        <div class="tml-typo-section" style="margin-bottom:25px; border-bottom:1px solid #f0f0f0; padding-bottom:25px;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:30px;">
                <div style="width:280px; flex-shrink:0;">
                    <h4
                        style="margin:0; font-weight:500; font-size:1rem; line-height:1.5; letter-spacing:0.00938em; color:rgba(0,0,0,0.87);">
                        <?php echo esc_html($label); ?>
                    </h4>
                    <p
                        style="color:rgba(0,0,0,0.6); font-size:0.875rem; font-weight:400; margin-top:4px; line-height:1.43; letter-spacing:0.01071em;">
                        <?php echo esc_html($sub_label); ?>
                    </p>

                    <?php $load = $get_val($prefix . '_load', 'on'); ?>
                    <div style="margin-top:15px;">
                        <input type="hidden" name="<?php echo esc_attr($prefix); ?>_load" value="off">
                        <label class="tml-toggle-label">
                            <input type="checkbox" name="<?php echo esc_attr($prefix); ?>_load" value="on" <?php checked($load, 'on'); ?> class="tml-toggle-input">
                            <span class="tml-toggle-switch"></span>
                            <span class="tml-toggle-text"><?php echo esc_html(strtoupper($load)); ?></span>
                        </label>
                    </div>
                </div>
                <div style="flex-grow:1;">
                    <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:15px; margin-bottom:15px;">
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Font
                                Family</label>
                            <select name="<?php echo esc_attr($prefix); ?>_font" style="width:100%; border-radius:3px;">
                                <?php foreach ($fonts as $name => $val): ?>
                                    <option value="<?php echo esc_attr($val); ?>" <?php selected($get_val($prefix . '_font', 'inherit'), $val); ?>><?php echo esc_html($name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Text
                                Align</label>
                            <select name="<?php echo esc_attr($prefix); ?>_align" style="width:100%; border-radius:3px;">
                                <option value="inherit" <?php selected($get_val($prefix . '_align', 'inherit'), 'inherit'); ?>>
                                    Default</option>
                                <option value="left" <?php selected($get_val($prefix . '_align'), 'left'); ?>>Left</option>
                                <option value="center" <?php selected($get_val($prefix . '_align'), 'center'); ?>>Center
                                </option>
                                <option value="right" <?php selected($get_val($prefix . '_align'), 'right'); ?>>Right</option>
                                <option value="justify" <?php selected($get_val($prefix . '_align'), 'justify'); ?>>Justify
                                </option>
                            </select>
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Text
                                Transform</label>
                            <select name="<?php echo esc_attr($prefix); ?>_transform" style="width:100%; border-radius:3px;">
                                <option value="none" <?php selected($get_val($prefix . '_transform', 'none'), 'none'); ?>>None
                                </option>
                                <option value="capitalize" <?php selected($get_val($prefix . '_transform'), 'capitalize'); ?>>
                                    Capitalize</option>
                                <option value="uppercase" <?php selected($get_val($prefix . '_transform'), 'uppercase'); ?>>
                                    Uppercase</option>
                                <option value="lowercase" <?php selected($get_val($prefix . '_transform'), 'lowercase'); ?>>
                                    Lowercase</option>
                            </select>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns: repeat(4, 1fr); gap:15px; margin-bottom:15px;">
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Font
                                Size (px)</label>
                            <input type="number" name="<?php echo esc_attr($prefix); ?>_size"
                                value="<?php echo esc_attr($get_val($prefix . '_size')); ?>"
                                style="width:100%; border-radius:3px;" placeholder="20">
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Line
                                Height (px)</label>
                            <input type="number" name="<?php echo esc_attr($prefix); ?>_line_height"
                                value="<?php echo esc_attr($get_val($prefix . '_line_height')); ?>"
                                style="width:100%; border-radius:3px;" placeholder="30">
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Letter
                                Spacing (px)</label>
                            <input type="number" step="0.1" name="<?php echo esc_attr($prefix); ?>_spacing"
                                value="<?php echo esc_attr($get_val($prefix . '_spacing', '0')); ?>"
                                style="width:100%; border-radius:3px;">
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Font
                                Weight</label>
                            <select name="<?php echo esc_attr($prefix); ?>_weight" style="width:100%; border-radius:3px;">
                                <option value="inherit" <?php selected($get_val($prefix . '_weight', 'inherit'), 'inherit'); ?>>
                                    Default</option>
                                <option value="300" <?php selected($get_val($prefix . '_weight'), '300'); ?>>300 (Light)
                                </option>
                                <option value="400" <?php selected($get_val($prefix . '_weight'), '400'); ?>>400 (Regular)
                                </option>
                                <option value="500" <?php selected($get_val($prefix . '_weight'), '500'); ?>>500 (Medium)
                                </option>
                                <option value="600" <?php selected($get_val($prefix . '_weight'), '600'); ?>>600 (Semi-Bold)
                                </option>
                                <option value="700" <?php selected($get_val($prefix . '_weight'), '700'); ?>>700 (Bold)</option>
                            </select>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns: repeat(4, 1fr); gap:15px; margin-bottom:15px;">
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Margin
                                Top (px)</label>
                            <input type="number" name="<?php echo esc_attr($prefix); ?>_m_t"
                                value="<?php echo esc_attr($get_val($prefix . '_m_t', '0')); ?>"
                                style="width:100%; border-radius:3px;">
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Margin
                                Bottom (px)</label>
                            <input type="number" name="<?php echo esc_attr($prefix); ?>_m_b"
                                value="<?php echo esc_attr($get_val($prefix . '_m_b', '0')); ?>"
                                style="width:100%; border-radius:3px;">
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Margin
                                Left (px)</label>
                            <input type="number" name="<?php echo esc_attr($prefix); ?>_m_l"
                                value="<?php echo esc_attr($get_val($prefix . '_m_l', '0')); ?>"
                                style="width:100%; border-radius:3px;">
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Margin
                                Right (px)</label>
                            <input type="number" name="<?php echo esc_attr($prefix); ?>_m_r"
                                value="<?php echo esc_attr($get_val($prefix . '_m_r', '0')); ?>"
                                style="width:100%; border-radius:3px;">
                        </div>
                    </div>

                    <div>
                        <label
                            style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Font
                            Color</label>
                        <input type="text" name="<?php echo esc_attr($color_key); ?>"
                            value="<?php echo esc_attr($get_val($color_key) ? $get_val($color_key) : '#000000'); ?>"
                            class="tml-color-field">
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('tml_render_typography_section_pro')) {
    function tml_render_typography_section_pro($label, $sub_label)
    {
        ?>
        <div class="tml-typo-section"
            style="margin-bottom:25px; border-bottom:1px solid #f0f0f0; padding-bottom:25px; opacity: 0.6; filter: blur(0.6px); pointer-events: none; user-select: none;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:30px;">
                <div style="width:280px; flex-shrink:0;">
                    <h4
                        style="margin:0; font-weight:500; font-size:1rem; line-height:1.5; letter-spacing:0.00938em; color:rgba(0,0,0,0.87); display: flex; align-items: center; gap: 8px;">
                        <?php echo esc_html($label); ?>
                        <span
                            style="background: #cbd5e1; color: #ffffff; padding: 2px 5px; border-radius: 3px; font-family: sans-serif; font-size: 8px; font-weight: bold; line-height: 1;">PRO</span>
                    </h4>
                    <p
                        style="color:rgba(0,0,0,0.6); font-size:0.875rem; font-weight:400; margin-top:4px; line-height:1.43; letter-spacing:0.01071em;">
                        <?php echo esc_html($sub_label); ?>
                    </p>

                    <div style="margin-top:15px;">
                        <label class="tml-toggle-label">
                            <input type="checkbox" disabled class="tml-toggle-input">
                            <span class="tml-toggle-switch"></span>
                            <span class="tml-toggle-text">OFF</span>
                        </label>
                    </div>
                </div>
                <div style="flex-grow:1;">
                    <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:15px; margin-bottom:15px;">
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Font
                                Family</label>
                            <select style="width:100%; border-radius:3px;" disabled>
                                <option>Default</option>
                            </select>
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Text
                                Align</label>
                            <select style="width:100%; border-radius:3px;" disabled>
                                <option>Default</option>
                            </select>
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Text
                                Transform</label>
                            <select style="width:100%; border-radius:3px;" disabled>
                                <option>None</option>
                            </select>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns: repeat(4, 1fr); gap:15px; margin-bottom:15px;">
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Font
                                Size (px)</label>
                            <input type="number" style="width:100%; border-radius:3px;" placeholder="20" disabled>
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Line
                                Height (px)</label>
                            <input type="number" style="width:100%; border-radius:3px;" placeholder="30" disabled>
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Letter
                                Spacing (px)</label>
                            <input type="number" style="width:100%; border-radius:3px;" placeholder="0" disabled>
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Font
                                Weight</label>
                            <select style="width:100%; border-radius:3px;" disabled>
                                <option>Default</option>
                            </select>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns: repeat(4, 1fr); gap:15px; margin-bottom:15px;">
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Margin
                                Top (px)</label>
                            <input type="number" style="width:100%; border-radius:3px;" placeholder="0" disabled>
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Margin
                                Bottom (px)</label>
                            <input type="number" style="width:100%; border-radius:3px;" placeholder="0" disabled>
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Margin
                                Left (px)</label>
                            <input type="number" style="width:100%; border-radius:3px;" placeholder="0" disabled>
                        </div>
                        <div>
                            <label
                                style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Margin
                                Right (px)</label>
                            <input type="number" style="width:100%; border-radius:3px;" placeholder="0" disabled>
                        </div>
                    </div>

                    <div>
                        <label
                            style="display:block; font-size:0.75rem; color:rgba(0,0,0,0.6); font-weight:400; line-height:2.66; letter-spacing:0.08333em; text-transform:uppercase; margin-bottom:4px;">Font
                            Color</label>
                        <input type="text" value="#000000" class="tml-color-field" disabled>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<style>
    .tml-settings-wrapper {
        padding: 10px 0;
        max-width: 100%;
        box-sizing: border-box;
    }

    .tml-settings-wrapper .nav-tab-wrapper {
        margin-bottom: 20px;
        border-bottom: 1px solid #ccc;
    }

    .tml-settings-wrapper .nav-tab {
        font-size: 14px;
        font-weight: 600;
        padding: 10px 15px;
        margin-right: 5px;
        outline: none;
        box-shadow: none;
    }

    .tml-settings-wrapper .nav-tab-active {
        background: #fff;
        border-bottom-color: #fff;
        color: #2271b1;
    }

    .tml-tab-content {
        display: none;
    }

    .tml-tab-content.active {
        display: block;
    }

    .tml-form-table {
        width: 100%;
        border-collapse: collapse;
    }

    .tml-form-table th {
        width: 280px;
        text-align: left;
        padding: 16px 16px 16px 0;
        font-weight: 500;
        font-size: 0.875rem;
        /* MUI subtitle2 */
        line-height: 1.57;
        letter-spacing: 0.00714em;
        color: rgba(0, 0, 0, 0.87);
        /* MUI primary text */
        border-bottom: 1px solid rgba(0, 0, 0, 0.12);
        /* MUI divider */
        vertical-align: top;
    }

    .tml-form-table th small {
        display: block;
        color: rgba(0, 0, 0, 0.6);
        /* MUI secondary text */
        font-size: 0.75rem;
        /* MUI caption */
        font-weight: 400;
        line-height: 1.66;
        letter-spacing: 0.03333em;
        margin-top: 4px;
    }

    .tml-form-table td {
        padding: 16px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.12);
        vertical-align: middle;
    }

    .tml-form-table tr:last-child th,
    .tml-form-table tr:last-child td {
        border-bottom: none;
    }

    .tml-shortcode-box {
        background: rgb(229, 246, 253);
        padding: 16px;
        border-radius: 4px;
        margin-bottom: 24px;
        color: rgb(1, 67, 97);
        display: flex;
        flex-direction: column;
    }

    .tml-shortcode-box input {
        width: 100%;
        font-size: 0.875rem;
        font-family: var(--tml-font-family);
        padding: 12px;
        margin-top: 12px;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(1, 67, 97, 0.2);
        border-radius: 4px;
        text-align: center;
        color: rgb(1, 67, 97);
        font-weight: 500;
        letter-spacing: 0.02857em;
    }

    /* Visual Template Selector Grid */
    .tml-template-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
    }

    .tml-template-card {
        border: 2px solid #e2e4e7;
        border-radius: 4px;
        overflow: hidden;
        cursor: pointer;
        position: relative;
        transition: all 0.2s;
        background: #fff;
        text-align: center;
    }

    .tml-template-card:hover {
        border-color: #b5b9c0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .tml-template-card input[type="radio"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .tml-template-card img {
        width: 100%;
        height: auto;
        border-bottom: 1px solid #eee;
        display: block;
    }

    .tml-template-card .tml-theme-label {
        display: block;
        padding: 12px 6px;
        font-weight: 600;
        font-size: 12px;
        line-height: 1.3;
        color: #4a5568;
        background: #fafafa;
        border-top: 1px solid #eee;
        transition: all 0.2s;
        word-wrap: break-word;
        white-space: normal;
    }

    .tml-template-card.selected {
        border-color: #2271b1;
    }

    .tml-template-card.selected .tml-theme-label {
        background: #2271b1;
        color: #fff;
    }

    /* Wireframe Schematic Styles */
    .tml-wireframe-container {
        height: 140px;
        background: #ffffff;
        position: relative;
        padding: 14px;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        overflow: hidden;
        text-align: left;
    }

    .tml-wf-accent {
        height: 4px;
        background: #2271b1;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
    }

    .tml-wf-content-wrapper {
        display: flex;
        flex-direction: column;
        height: 100%;
        justify-content: space-between;
    }

    .tml-wf-avatar-sm {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #e2e8f0;
        flex-shrink: 0;
    }

    .tml-wf-avatar-md {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #e2e8f0;
        flex-shrink: 0;
    }

    .tml-wf-line {
        background: #e2e8f0;
        height: 6px;
        border-radius: 3px;
        margin-bottom: 5px;
    }

    .tml-wf-line-lg {
        width: 100%;
    }

    .tml-wf-line-md {
        width: 75%;
    }

    .tml-wf-line-sm {
        width: 45%;
    }

    .tml-wf-stars {
        display: flex;
        gap: 3px;
    }

    .tml-wf-stars-center {
        display: flex;
        gap: 3px;
        justify-content: center;
    }

    .tml-wf-star {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #cbd5e1;
        display: inline-block;
    }

    .tml-wf-profile-center {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .tml-wf-bubble {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 6px;
        padding: 8px;
        margin-top: 6px;
        position: relative;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .tml-wf-flex-row {
        display: flex;
        flex-direction: row;
    }

    .tml-wf-flex-col {
        display: flex;
        flex-direction: column;
    }

    .tml-wf-video-block {
        background: #475569;
        height: 75px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .tml-wf-play-btn {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
    }

    .tml-wf-badge {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Layout Presets */
    .tml-preset-grid {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 15px;
    }

    .tml-preset-card {
        border: 2px solid #e2e4e7;
        border-radius: 4px;
        padding: 15px 10px;
        text-align: center;
        cursor: pointer;
        min-width: 110px;
        display: inline-block;
        transition: all 0.2s;
        background: #fff;
    }

    .tml-preset-card:hover {
        border-color: #b5b9c0;
    }

    .tml-preset-card.selected {
        border-color: #2271b1;
        background: #f0f6fc;
    }

    .tml-preset-card input[type="radio"] {
        display: none;
    }

    .tml-preset-card svg {
        width: 40px;
        height: 30px;
        color: #a7aaad;
        margin-bottom: 10px;
        transition: all 0.2s;
        display: inline-block;
    }

    .tml-preset-card.selected svg {
        color: #2271b1;
    }

    .tml-preset-card span {
        font-weight: 600;
        color: #50575e;
        transition: all 0.2s;
        display: block;
        font-size: 13px;
    }

    .tml-preset-card.selected span {
        color: #2271b1;
    }

    /* Toggle Switch */
    .tml-toggle-label {
        position: relative;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
    }

    .tml-toggle-input {
        display: none !important;
    }

    .tml-toggle-switch {
        width: 45px;
        height: 22px;
        background-color: #ccc;
        border-radius: 22px;
        position: relative;
        transition: background-color 0.2s;
        margin-right: 10px;
    }

    .tml-toggle-switch::before {
        content: "";
        position: absolute;
        width: 18px;
        height: 18px;
        background-color: white;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        transition: transform 0.2s;
    }

    .tml-toggle-input:checked+.tml-toggle-switch {
        background-color: #2271b1;
    }

    .tml-toggle-input:checked+.tml-toggle-switch::before {
        transform: translateX(23px);
    }

    .tml-toggle-text {
        font-weight: 600;
        font-size: 12px;
        color: #50575e;
    }

    /* Range Slider */
    .range-slider__range {
        -webkit-appearance: none;
        appearance: none;
        width: 200px;
        background: transparent !important;
        outline: none;
        margin-right: 12px;
        vertical-align: middle;
        padding: 10px 0 !important;
        /* Prevents thumb cutoff */
        border: none !important;
        box-shadow: none !important;
    }

    .range-slider__range::-webkit-slider-runnable-track {
        width: 100%;
        height: 4px;
        cursor: pointer;
        background: rgba(0, 0, 0, 0.12);
        border-radius: 4px;
        border: none;
    }

    .range-slider__range::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #1976d2;
        /* MUI primary */
        cursor: pointer;
        border: none;
        margin-top: -8px;
        /* Centers thumb over 4px track */
        box-shadow: 0px 3px 1px -2px rgba(0, 0, 0, 0.2), 0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 1px 5px 0px rgba(0, 0, 0, 0.12);
        transition: box-shadow 150ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
    }

    .range-slider__range::-moz-range-track {
        width: 100%;
        height: 4px;
        cursor: pointer;
        background: rgba(0, 0, 0, 0.12);
        border-radius: 4px;
        border: none;
    }

    .range-slider__range::-moz-range-thumb {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #1976d2;
        cursor: pointer;
        border: none;
        box-shadow: 0px 3px 1px -2px rgba(0, 0, 0, 0.2), 0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 1px 5px 0px rgba(0, 0, 0, 0.12);
        transition: box-shadow 150ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
    }

    .range-slider__range::-webkit-slider-thumb:hover {
        box-shadow: 0px 0px 0px 8px rgba(25, 118, 210, 0.16);
    }

    .range-slider__range::-moz-range-thumb:hover {
        box-shadow: 0px 0px 0px 8px rgba(25, 118, 210, 0.16);
    }

    .range-slider__value {
        display: inline-block;
        padding: 4px 8px;
        background: rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(0, 0, 0, 0.12);
        border-radius: 4px;
        font-size: 0.875rem;
        font-weight: 500;
        color: rgba(0, 0, 0, 0.87);
        vertical-align: middle;
        min-width: 24px;
        text-align: center;
    }

    /* Vertical Sub-Tabs */
    .tml-vertical-tabs-wrapper {
        display: flex;
        border: 1px solid rgba(0, 0, 0, 0.12);
        background: var(--tml-surface);
        min-height: 400px;
        border-radius: var(--tml-radius);
        overflow: hidden;
    }

    .tml-vertical-tabs-sidebar {
        width: 220px;
        background: rgba(0, 0, 0, 0.02);
        border-right: 1px solid rgba(0, 0, 0, 0.12);
    }

    .tml-vertical-tab-link {
        display: flex;
        align-items: center;
        padding: 12px 24px;
        color: rgba(0, 0, 0, 0.6);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        line-height: 1.25;
        letter-spacing: 0.02857em;
        text-transform: uppercase;
        border-right: 2px solid transparent;
        transition: background-color 150ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, color 150ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
    }

    .tml-vertical-tab-link i {
        margin-right: 16px;
        font-size: 1.25rem;
        width: 24px;
        text-align: center;
        color: rgba(0, 0, 0, 0.54);
    }

    .tml-vertical-tab-link:hover {
        background: rgba(0, 0, 0, 0.04);
        color: rgba(0, 0, 0, 0.87);
    }

    .tml-vertical-tab-link.active {
        background: rgba(25, 118, 210, 0.08);
        color: var(--tml-primary);
        border-right-color: var(--tml-primary);

    }

    .tml-vertical-tab-link.active i {
        color: #2271b1;
    }

    .tml-vertical-tabs-content {
        flex: 1;
        background: #fff;
        padding: 30px;
    }

    .tml-sub-tab-panel {
        display: none;
    }

    .tml-sub-tab-panel.active {
        display: block;
    }

    .tml-mui-sidebar .tml-mui-nav-item.tml-hide-tab,
    .tml-mui-nav-item.tml-hide-tab,
    #tml-pagination-tab.tml-hide-tab,
    #tml-slider-config-tab.tml-hide-tab {
        display: none !important;
    }

    /* Material-UI (MUI) Premium Outlined Select Styling */
    select.tml-mui-input,
    .tml-mui-select {
        appearance: none !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='rgba(0, 0, 0, 0.54)'%3e%3cpath d='M7 10l5 5 5-5z'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 12px center !important;
        background-size: 24px !important;
        padding: 8px 36px 8px 14px !important;
        border: 1px solid rgba(0, 0, 0, 0.23) !important;
        background-color: #ffffff !important;
        color: rgba(0, 0, 0, 0.87) !important;
        font-family: var(--tml-font-family) !important;
        font-size: 0.875rem !important;
        font-weight: 400 !important;
        height: 40px !important;
        line-height: 1.4375em !important;
        border-radius: 4px !important;
        box-shadow: none !important;
        transition: border-color 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, box-shadow 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms !important;
        cursor: pointer !important;
        outline: none !important;
        box-sizing: border-box !important;
        display: inline-block !important;
    }

    select.tml-mui-input {
        width: auto !important;
    }

    .tml-mui-select {
        width: 100% !important;
    }

    select.tml-mui-input:hover,
    .tml-mui-select:hover {
        border-color: rgba(0, 0, 0, 0.87) !important;
    }

    select.tml-mui-input:focus,
    .tml-mui-select:focus {
        border: 2px solid #1976d2 !important;
        padding-left: 13px !important;
        padding-right: 35px !important;
        background-color: #ffffff !important;
    }
</style>

<div class="tml-settings-wrapper">
    <?php
    $active_tab = $get_val('tml_active_tab', '#tml-tab-general');
    $active_vtab = $get_val('tml_active_vtab', 'basic');
    $active_stab = $get_val('tml_active_stab', 'basics');
    $active_subtab = $get_val('tml_active_subtab', '');
    ?>
    <input type="hidden" id="tml_active_tab_field" name="tml_active_tab" value="<?php echo esc_attr($active_tab); ?>" />
    <input type="hidden" id="tml_active_vtab_field" name="tml_active_vtab"
        value="<?php echo esc_attr($active_vtab); ?>" />
    <input type="hidden" id="tml_active_stab_field" name="tml_active_stab"
        value="<?php echo esc_attr($active_stab); ?>" />
    <input type="hidden" id="tml_active_subtab_field" name="tml_active_subtab"
        value="<?php echo esc_attr($active_subtab); ?>" />

    <div style="background:#fff; border:1px solid #ccd0d4; padding:20px; margin-bottom:20px;">
        <h3 class="tml-mui-card-title"
            style="margin-top:0; margin-bottom:16px; border-bottom:1px solid rgba(0,0,0,0.12); padding-bottom:16px; border-top:none;">
            <i class="fa fa-th-large" style="margin-right:8px; color:rgba(0,0,0,0.54);"></i>
            <?php esc_html_e('Layout Preset', 'testimonial-maker'); ?>
        </h3>
        <p class="tml-mui-description" style="margin-bottom:24px;">
            <?php esc_html_e('To create eye-catching testimonial layout designs, select your preferred layout type below.', 'testimonial-maker'); ?>
        </p>
        <div class="tml-preset-grid">
            <?php
            $presets = array(
                'slider' => array('title' => 'Slider', 'svg' => '<svg viewBox="0 0 40 30" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="10" y="5" width="20" height="15" rx="2" stroke="currentColor" stroke-width="1.5"/><rect x="2" y="7" width="5" height="11" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="33" y="7" width="5" height="11" rx="1" stroke="currentColor" stroke-width="1.5"/><circle cx="16" cy="25" r="1.5" fill="currentColor"/><circle cx="20" cy="25" r="1.5" fill="currentColor"/><circle cx="24" cy="25" r="1.5" fill="currentColor"/></svg>'),
                'grid' => array('title' => 'Grid', 'svg' => '<svg viewBox="0 0 40 30" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="2" width="13" height="10" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="22" y="2" width="13" height="10" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="5" y="16" width="13" height="10" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="22" y="16" width="13" height="10" rx="1" stroke="currentColor" stroke-width="1.5"/></svg>'),
                'carousel' => array('title' => 'Carousel', 'svg' => '<svg viewBox="0 0 40 30" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="5" width="10" height="15" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="15" y="5" width="10" height="15" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="28" y="5" width="10" height="15" rx="1" stroke="currentColor" stroke-width="1.5"/><circle cx="16" cy="25" r="1.5" fill="currentColor"/><circle cx="20" cy="25" r="1.5" fill="currentColor"/><circle cx="24" cy="25" r="1.5" fill="currentColor"/></svg>'),
                'masonry' => array('title' => 'Masonry', 'svg' => '<svg viewBox="0 0 40 30" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="2" width="13" height="15" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="22" y="2" width="13" height="10" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="5" y="20" width="13" height="8" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="22" y="15" width="13" height="13" rx="1" stroke="currentColor" stroke-width="1.5"/></svg>'),
                'isotope' => array('title' => 'Isotope', 'svg' => '<svg viewBox="0 0 40 30" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="2" width="13" height="13" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="22" y="2" width="13" height="8" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="5" y="18" width="13" height="10" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="22" y="13" width="13" height="15" rx="1" stroke="currentColor" stroke-width="1.5"/><circle cx="11.5" cy="8.5" r="1.5" fill="currentColor"/><circle cx="28.5" cy="6" r="1.5" fill="currentColor"/><circle cx="11.5" cy="23" r="1.5" fill="currentColor"/><circle cx="28.5" cy="20.5" r="1.5" fill="currentColor"/></svg>'),
                'list' => array('title' => 'List', 'svg' => '<svg viewBox="0 0 40 30" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="5" y="2" width="30" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="5" y="12" width="30" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="5" y="22" width="30" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/></svg>'),
            );
            foreach ($presets as $key => $data) {
                $is_pro_layout = !in_array($key, array('slider', 'grid'));
                $is_disabled = $is_pro_layout;
                $is_selected = ($layout_preset == $key);
                ?>
                <label class="tml-preset-card <?php echo $is_selected ? 'selected' : ''; ?>" <?php echo $is_disabled ? 'style="opacity: 0.65; cursor: not-allowed; position: relative; pointer-events: none;"' : ''; ?>>
                    <input type="radio" name="tml_layout_preset" value="<?php echo esc_attr($key); ?>" <?php checked($is_selected); ?>     <?php echo $is_disabled ? 'disabled' : ''; ?>>
                    <?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static pre-defined SVG template ?>
                    <?php echo $data['svg']; ?>
                    <span>
                        <?php echo esc_html($data['title']); ?>
                    </span>
                    <?php if ($is_disabled): ?>
                        <span class="tml-pro-badge"
                            style="position: absolute; top: 4px; right: 4px; background: #d63638; color: #fff; font-size: 8px; font-weight: 700; padding: 2px 5px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 2px 4px rgba(214, 54, 56, 0.3); line-height: 1; z-index: 10;">PRO</span>
                    <?php endif; ?>
                </label>
                <?php
            }
            ?>
        </div>
    </div>

    <div class="tml-mui-container">
        <!-- MUI Sidebar -->
        <div class="tml-mui-sidebar">
            <div
                style="padding: 0 24px 16px; font-size: 0.75rem; font-weight: 400; line-height: 2.66; letter-spacing: 0.08333em; text-transform: uppercase; color: rgba(0, 0, 0, 0.6);">
                <?php esc_html_e('Configuration', 'testimonial-maker'); ?>
            </div>
            <a href="#tml-tab-general" class="tml-mui-nav-item active" data-tab="tml-tab-general">
                <i class="fa fa-cog"></i> <?php esc_html_e('General Settings', 'testimonial-maker'); ?>
            </a>
            <a href="#tml-tab-theme" class="tml-mui-nav-item" data-tab="tml-tab-theme">
                <i class="fa fa-paint-brush"></i> <?php esc_html_e('Theme Settings', 'testimonial-maker'); ?>
            </a>
            <a href="#tml-tab-display" class="tml-mui-nav-item" data-tab="tml-tab-display">
                <i class="fa fa-desktop"></i> <?php esc_html_e('Display Settings', 'testimonial-maker'); ?>
            </a>
            <a href="#tml-tab-slider" class="tml-mui-nav-item" id="tml-slider-config-tab" data-tab="tml-tab-slider"
                style="<?php echo in_array($layout_preset, ['slider', 'carousel']) ? 'display: flex !important;' : 'display: none !important;'; ?>">
                <i class="fa fa-sliders"></i> <?php esc_html_e('Slider Config', 'testimonial-maker'); ?>
            </a>
            <a href="#tml-tab-style" class="tml-mui-nav-item" data-tab="tml-tab-style"
                style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                <span><i class="fa fa-font"></i> <?php esc_html_e('Typography', 'testimonial-maker'); ?></span>
                <span
                    style="background: #cbd5e1; color: #ffffff; padding: 2px 5px; border-radius: 3px; font-family: sans-serif; font-size: 8px; font-weight: bold; line-height: 1; display: inline-block;">PRO</span>
            </a>
            <a href="#tml-tab-pagination" class="tml-mui-nav-item" id="tml-pagination-tab" data-tab="tml-tab-pagination"
                style="<?php echo in_array($layout_preset, ['grid', 'masonry', 'list', 'isotope']) ? 'display: flex !important;' : 'display: none !important;'; ?> align-items: center; justify-content: space-between; gap: 8px;">
                <span><i class="fa fa-list-ol"></i> <?php esc_html_e('Pagination', 'testimonial-maker'); ?></span>
                <span
                    style="background: #cbd5e1; color: #ffffff; padding: 2px 5px; border-radius: 3px; font-family: sans-serif; font-size: 8px; font-weight: bold; line-height: 1; display: inline-block;">PRO</span>
            </a>
        </div>

        <!-- MUI Content -->
        <div class="tml-mui-content">

            <div id="tml-tab-general" class="tml-tab-content active">
                <!-- Grid Columns Card -->
                <?php
                $default_cols_ld = in_array($layout_preset, ['slider', 'list']) ? '1' : '3';
                $default_cols_d = in_array($layout_preset, ['slider', 'list']) ? '1' : '3';
                $default_cols_l = in_array($layout_preset, ['slider', 'list']) ? '1' : '2';
                ?>
                <div class="tml-mui-card">
                    <div class="tml-mui-card-title">
                        <?php esc_html_e('Grid Columns (Responsive)', 'testimonial-maker'); ?>
                    </div>
                    <div class="tml-responsive-grid">
                        <div class="tml-responsive-column-item">
                            <div class="tml-device-icon"><i class="fa fa-television"></i></div>
                            <label>Large Desktop</label>
                            <input type="number" id="tml_col_ld" name="tml_col_ld"
                                value="<?php echo esc_attr($get_val('tml_col_ld', $default_cols_ld)); ?>"
                                class="tml-mui-input">
                        </div>
                        <div class="tml-responsive-column-item">
                            <div class="tml-device-icon"><i class="fa fa-desktop"></i></div>
                            <label>Desktop</label>
                            <input type="number" id="tml_col_d" name="tml_col_d"
                                value="<?php echo esc_attr($get_val('tml_col_d', $default_cols_d)); ?>"
                                class="tml-mui-input">
                        </div>
                        <div class="tml-responsive-column-item">
                            <div class="tml-device-icon"><i class="fa fa-laptop"></i></div>
                            <label>Laptop</label>
                            <input type="number" id="tml_col_l" name="tml_col_l"
                                value="<?php echo esc_attr($get_val('tml_col_l', $default_cols_l)); ?>"
                                class="tml-mui-input">
                        </div>
                        <div class="tml-responsive-column-item">
                            <div class="tml-device-icon"><i class="fa fa-tablet"></i></div>
                            <label>Tablet</label>
                            <input type="number" id="tml_col_t" name="tml_col_t"
                                value="<?php echo esc_attr($get_val('tml_col_t', '1')); ?>" class="tml-mui-input">
                        </div>
                        <div class="tml-responsive-column-item">
                            <div class="tml-device-icon"><i class="fa fa-mobile-phone"></i></div>
                            <label>Mobile</label>
                            <input type="number" id="tml_col_m" name="tml_col_m"
                                value="<?php echo esc_attr($get_val('tml_col_m', '1')); ?>" class="tml-mui-input">
                        </div>
                    </div>
                </div>

                <!-- Spacing Card -->
                <div class="tml-mui-card">
                    <div class="tml-mui-card-title"><?php esc_html_e('Item Spacing', 'testimonial-maker'); ?></div>
                    <div class="tml-mui-grid-2" style="gap: 40px;">

                        <!-- Gap (Horizontal) with Tooltip -->
                        <div class="tml-mui-form-group"
                            style="flex-direction: row; justify-content: space-between; align-items: center; border-bottom: none; padding-bottom: 0; margin-bottom: 0;">
                            <label class="tml-mui-label"
                                style="margin-bottom: 0; display:flex; align-items:center; gap:6px;">
                                <?php esc_html_e('Gap (Horizontal):', 'testimonial-maker'); ?>
                                <span class="tml-spacing-tooltip-wrap">
                                    <i class="fa fa-question-circle"
                                        style="color:#2271b1; font-size:14px; cursor:pointer;"></i>
                                    <span class="tml-spacing-tooltip">
                                        <svg width="160" height="90" viewBox="0 0 160 90"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <!-- Card 1 -->
                                            <rect x="5" y="10" width="45" height="50" rx="3" fill="#3b82f6"
                                                opacity="0.85" />
                                            <line x1="10" y1="22" x2="44" y2="22" stroke="#fff" stroke-width="1.5"
                                                opacity="0.6" />
                                            <line x1="10" y1="30" x2="38" y2="30" stroke="#fff" stroke-width="1.5"
                                                opacity="0.4" />
                                            <line x1="10" y1="37" x2="40" y2="37" stroke="#fff" stroke-width="1.5"
                                                opacity="0.4" />
                                            <!-- Gap Arrow -->
                                            <line x1="50" y1="35" x2="70" y2="35" stroke="#f97316" stroke-width="2" />
                                            <polygon points="50,31 50,39 43,35" fill="#f97316" />
                                            <polygon points="70,31 70,39 77,35" fill="#f97316" />
                                            <text x="56" y="28" font-size="8" fill="#f97316"
                                                font-family="sans-serif">Gap</text>
                                            <!-- Card 2 -->
                                            <rect x="77" y="10" width="45" height="50" rx="3" fill="#3b82f6"
                                                opacity="0.85" />
                                            <line x1="82" y1="22" x2="116" y2="22" stroke="#fff" stroke-width="1.5"
                                                opacity="0.6" />
                                            <line x1="82" y1="30" x2="110" y2="30" stroke="#fff" stroke-width="1.5"
                                                opacity="0.4" />
                                            <line x1="82" y1="37" x2="112" y2="37" stroke="#fff" stroke-width="1.5"
                                                opacity="0.4" />
                                            <!-- Card 3 -->
                                            <rect x="130" y="10" width="25" height="50" rx="3" fill="#3b82f6"
                                                opacity="0.5" />
                                            <!-- Label -->
                                            <text x="5" y="82" font-size="9" fill="#60a5fa" font-family="sans-serif"
                                                font-weight="600">← Horizontal space between cards →</text>
                                        </svg>
                                    </span>
                                </span>
                            </label>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="range" class="tml-range-slider" min="0" max="100" name="tml_gap"
                                    value="<?php echo esc_attr($get_val('tml_gap', '20')); ?>"
                                    oninput="this.nextElementSibling.value = this.value">
                                <input type="number" value="<?php echo esc_attr($get_val('tml_gap', '20')); ?>"
                                    style="width:70px; height:35px; text-align:center; border:1px solid #ddd; border-radius:4px;"
                                    oninput="this.previousElementSibling.value = this.value">
                            </div>
                        </div>

                        <!-- Vertical Gap with Tooltip -->
                        <div class="tml-mui-form-group"
                            style="flex-direction: row; justify-content: space-between; align-items: center; border-bottom: none; padding-bottom: 0; margin-bottom: 0;">
                            <label class="tml-mui-label"
                                style="margin-bottom: 0; display:flex; align-items:center; gap:6px;">
                                <?php esc_html_e('Vertical Gap:', 'testimonial-maker'); ?>
                                <span class="tml-spacing-tooltip-wrap">
                                    <i class="fa fa-question-circle"
                                        style="color:#2271b1; font-size:14px; cursor:pointer;"></i>
                                    <span class="tml-spacing-tooltip tml-spacing-tooltip-right">
                                        <svg width="160" height="110" viewBox="0 0 160 110"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <!-- Row 1 Card 1 -->
                                            <rect x="5" y="5" width="60" height="35" rx="3" fill="#3b82f6"
                                                opacity="0.85" />
                                            <line x1="10" y1="16" x2="58" y2="16" stroke="#fff" stroke-width="1.5"
                                                opacity="0.6" />
                                            <line x1="10" y1="23" x2="52" y2="23" stroke="#fff" stroke-width="1.5"
                                                opacity="0.4" />
                                            <!-- Row 1 Card 2 -->
                                            <rect x="75" y="5" width="60" height="35" rx="3" fill="#3b82f6"
                                                opacity="0.85" />
                                            <line x1="80" y1="16" x2="128" y2="16" stroke="#fff" stroke-width="1.5"
                                                opacity="0.6" />
                                            <line x1="80" y1="23" x2="122" y2="23" stroke="#fff" stroke-width="1.5"
                                                opacity="0.4" />
                                            <!-- Vertical Gap Arrow -->
                                            <line x1="142" y1="40" x2="142" y2="65" stroke="#f97316" stroke-width="2" />
                                            <polygon points="138,40 146,40 142,33" fill="#f97316" />
                                            <polygon points="138,65 146,65 142,72" fill="#f97316" />
                                            <text x="146" y="56" font-size="8" fill="#f97316"
                                                font-family="sans-serif">Gap</text>
                                            <!-- Row 2 Card 1 -->
                                            <rect x="5" y="70" width="60" height="35" rx="3" fill="#3b82f6"
                                                opacity="0.85" />
                                            <line x1="10" y1="81" x2="58" y2="81" stroke="#fff" stroke-width="1.5"
                                                opacity="0.6" />
                                            <line x1="10" y1="88" x2="52" y2="88" stroke="#fff" stroke-width="1.5"
                                                opacity="0.4" />
                                            <!-- Row 2 Card 2 -->
                                            <rect x="75" y="70" width="60" height="35" rx="3" fill="#3b82f6"
                                                opacity="0.85" />
                                            <line x1="80" y1="81" x2="128" y2="81" stroke="#fff" stroke-width="1.5"
                                                opacity="0.6" />
                                            <line x1="80" y1="88" x2="122" y2="88" stroke="#fff" stroke-width="1.5"
                                                opacity="0.4" />
                                            <!-- Label -->
                                            <text x="5" y="108" font-size="9" fill="#60a5fa" font-family="sans-serif"
                                                font-weight="600">↕ Vertical space between rows</text>
                                        </svg>
                                    </span>
                                </span>
                            </label>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <input type="range" class="tml-range-slider" min="0" max="100" name="tml_vgap"
                                    value="<?php echo esc_attr($get_val('tml_vgap', '20')); ?>"
                                    oninput="this.nextElementSibling.value = this.value">
                                <input type="number" value="<?php echo esc_attr($get_val('tml_vgap', '20')); ?>"
                                    style="width:70px; height:35px; text-align:center; border:1px solid #ddd; border-radius:4px;"
                                    oninput="this.previousElementSibling.value = this.value">
                            </div>
                        </div>

                    </div>
                </div>


                <!-- Configuration Card -->
                <div class="tml-mui-card">
                    <div class="tml-mui-card-title"><?php esc_html_e('General Configuration', 'testimonial-maker'); ?>
                    </div>
                    <div class="tml-mui-form-group" id="tml-limit-setting-row"
                        style="flex-direction: row; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(0, 0, 0, 0.06); padding-bottom: 16px;">
                        <div>
                            <label class="tml-mui-label"
                                style="margin-bottom: 4px;"><?php esc_html_e('Limit', 'testimonial-maker'); ?></label>
                            <div class="tml-mui-description" style="margin: 0;">
                                <?php esc_html_e('Leave it empty to show all testimonials.', 'testimonial-maker'); ?>
                            </div>
                        </div>
                        <input type="number" name="tml_limit"
                            value="<?php echo esc_attr($get_val('tml_limit', '10')); ?>" class="tml-mui-input"
                            style="width: 100px; text-align: center;">
                    </div>
                    <div class="tml-mui-form-group"
                        style="flex-direction: row; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(0, 0, 0, 0.06); padding-bottom: 16px;">
                        <label class="tml-mui-label"
                            style="margin-bottom: 0;"><?php esc_html_e('Order By', 'testimonial-maker'); ?></label>
                        <select name="tml_order_by" class="tml-mui-input" style="min-width: 150px;">
                            <option value="date" <?php selected($get_val('tml_order_by'), 'date'); ?>>Date</option>
                            <option value="title" <?php selected($get_val('tml_order_by'), 'title'); ?>>Title</option>
                            <option value="ID" <?php selected($get_val('tml_order_by'), 'ID'); ?>>Post ID</option>
                            <option value="modified" <?php selected($get_val('tml_order_by'), 'modified'); ?>>Last
                                Modified</option>
                        </select>
                    </div>
                    <div class="tml-mui-form-group"
                        style="flex-direction: row; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(0, 0, 0, 0.06); padding-bottom: 16px;">
                        <label class="tml-mui-label"
                            style="margin-bottom: 0;"><?php esc_html_e('Order Type', 'testimonial-maker'); ?></label>
                        <select name="tml_post_order" class="tml-mui-input" style="min-width: 150px;">
                            <option value="DESC" <?php selected($get_val('tml_post_order', 'DESC'), 'DESC'); ?>>
                                Descending</option>
                            <option value="ASC" <?php selected($get_val('tml_post_order', 'DESC'), 'ASC'); ?>>Ascending
                            </option>
                        </select>
                    </div>
                    <div class="tml-mui-form-group"
                        style="flex-direction: row; justify-content: space-between; align-items: center; border-bottom: none; padding-bottom: 0; margin-bottom: 0;">
                        <div>
                            <label class="tml-mui-label"
                                style="margin-bottom: 4px;"><?php esc_html_e('Random Order', 'testimonial-maker'); ?></label>
                            <div class="tml-mui-description" style="margin: 0;">
                                <?php esc_html_e('Enable to display testimonials in random order.', 'testimonial-maker'); ?>
                            </div>
                        </div>
                        <div
                            style="display: flex; align-items: center; background: #e2e8f0; border-radius: 4px; padding: 2px 6px; font-family: sans-serif; font-size: 10px; font-weight: bold; color: #64748b;">
                            <span
                                style="background: #cbd5e1; color: #475569; padding: 1px 4px; border-radius: 2px; margin-right: 4px; font-size: 9px;">PRO</span>
                            DISABLED
                        </div>
                    </div>
                </div>

                <div class="tml-mui-card" style="margin-top: 24px;">
                    <div class="tml-mui-card-title"><?php esc_html_e('AJAX LIVE FILTERS (PRO)', 'testimonial-maker'); ?>
                    </div>

                    <div
                        style="color: #475569; font-size: 0.875rem; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid rgba(0,0,0,0.06); font-family: sans-serif;">
                        <?php esc_html_e('To allow your visitors to filter reviews by', 'testimonial-maker'); ?>
                        <?php esc_html_e('Star Ratings', 'testimonial-maker'); ?>
                        <?php esc_html_e('Ajax Search, and Sort on the frontend,', 'testimonial-maker'); ?>
                        <a href="https://awplife.com/demo/testimonial-premium/" target="_blank"
                            style="color: #2563eb; text-decoration: none; font-weight: 500;"><?php esc_html_e('Upgrade to Pro!', 'testimonial-maker'); ?></a>
                    </div>

                    <div class="tml-mui-form-group"
                        style="margin-bottom: 24px; display: flex; flex-direction: row !important; justify-content: space-between; align-items: center;">
                        <div>
                            <div class="tml-mui-label"
                                style="margin-bottom: 4px; font-size: 1rem; display: flex; align-items: center; gap: 6px;">
                                <?php esc_html_e('Ajax Live Filters', 'testimonial-maker'); ?>
                                <span
                                    style="display: inline-flex; align-items: center; justify-content: center; width: 14px; height: 14px; border: 1px solid #cbd5e1; border-radius: 50%; font-size: 9px; color: #94a3b8; cursor: help; font-weight: bold;">i</span>
                            </div>
                            <div class="tml-mui-description" style="margin: 0;">
                                <?php esc_html_e('Enable the Ajax Live Filters by groups or star ratings.', 'testimonial-maker'); ?>
                            </div>
                        </div>
                        <div
                            style="display: flex; align-items: center; background: #e2e8f0; border-radius: 4px; padding: 4px 10px; font-family: sans-serif; font-size: 10px; font-weight: bold; color: #475569;">
                            ENABLED
                            <span
                                style="background: #cbd5e1; color: #475569; padding: 1px 4px; border-radius: 2px; margin-left: 6px; font-size: 9px;">PRO</span>
                        </div>
                    </div>

                    <div class="tml-mui-form-group"
                        style="margin-bottom: 0; border-bottom: none; padding-bottom: 0; display: flex; flex-direction: row !important; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <div class="tml-mui-label" style="margin-bottom: 4px;">
                                <?php esc_html_e('Filter By', 'testimonial-maker'); ?>
                            </div>
                            <div class="tml-mui-description" style="margin: 0;">
                                <?php esc_html_e('Enable your filter(s).', 'testimonial-maker'); ?>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 8px; width: 320px;">
                            <!-- Box 1: Star Rating -->
                            <div
                                style="display: flex; align-items: center; justify-content: space-between; border: 1px solid #e2e8f0; border-radius: 6px; padding: 8px 12px; background: #f8fafc; color: #64748b; font-family: sans-serif; font-size: 13px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 16px; color: #94a3b8; line-height: 1;">⠿</span>
                                    <span><?php esc_html_e('Star Rating', 'testimonial-maker'); ?></span>
                                </div>
                                <div
                                    style="display: flex; align-items: center; background: #f1f5f9; border-radius: 4px; padding: 2px 6px; font-size: 9px; font-weight: bold;">
                                    <span style="color: #64748b; margin-right: 4px;">SHOW</span>
                                    <span
                                        style="background: #cbd5e1; color: #475569; padding: 1px 3px; border-radius: 2px;">PRO</span>
                                </div>
                            </div>
                            <!-- Box 2: Groups -->
                            <div
                                style="display: flex; align-items: center; justify-content: space-between; border: 1px solid #e2e8f0; border-radius: 6px; padding: 8px 12px; background: #f8fafc; color: #64748b; font-family: sans-serif; font-size: 13px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 16px; color: #94a3b8; line-height: 1;">⠿</span>
                                    <span><?php esc_html_e('Category', 'testimonial-maker'); ?></span>
                                </div>
                                <div
                                    style="display: flex; align-items: center; background: #f1f5f9; border-radius: 4px; padding: 2px 6px; font-size: 9px; font-weight: bold;">
                                    <span style="color: #64748b; margin-right: 4px;">SHOW</span>
                                    <span
                                        style="background: #cbd5e1; color: #475569; padding: 1px 3px; border-radius: 2px;">PRO</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- THEME SETTINGS TAB -->
            <div id="tml-tab-theme" class="tml-tab-content">
                <h3 class="tml-mui-card-title"
                    style="margin-top:0; margin-bottom:16px; border-bottom:1px solid rgba(0,0,0,0.12); padding-bottom:16px; border-top:none;">
                    <?php esc_html_e('Select Your Theme', 'testimonial-maker'); ?>
                </h3>
                <p class="tml-mui-description">
                    <?php esc_html_e('Select which template/theme design you want to use for the testimonial cards.', 'testimonial-maker'); ?>
                </p>

                <?php


                $templates = array(
                    1 => 'Theme One',
                    2 => 'Theme Two',
                    3 => 'Theme Three',
                    4 => 'Theme Four',
                    5 => 'Theme Five',
                    6 => 'Theme Six',
                    7 => 'Theme Seven',
                    8 => 'Theme Eight',
                    9 => 'Theme Nine',
                    10 => 'Theme Ten (Video Template)',
                    11 => 'Theme Eleven',
                    12 => 'Theme Twelve',
                    13 => 'Theme Thirteen',
                    14 => 'Theme Fourteen (Video Premium Card)',
                    15 => 'Theme Fifteen',
                    16 => 'Theme Sixteen (Neon Aurora Glow)',
                    17 => 'Theme Seventeen (Custom Field Builder Layout)'
                );

                ?>
                <div class="tml-template-grid" style="margin-bottom:30px;">
                    <?php
                    foreach ($templates as $i => $name) {
                        $is_pro_template = ($i > 3);
                        $is_disabled = $is_pro_template;
                        $is_selected = ($design == $i);
                        ?>
                        <label class="tml-template-card <?php echo $is_selected ? 'selected' : ''; ?>" <?php echo $is_disabled ? 'style="opacity: 0.65; cursor: not-allowed; position: relative; pointer-events: none;"' : ''; ?>>
                            <input type="radio" name="testimonial_carousel_design" value="<?php echo esc_attr($i); ?>" <?php checked($is_selected); ?>     <?php echo $is_disabled ? 'disabled' : ''; ?>>

                            <div class="tml-wireframe-container">
                                <?php if ($i == 2) { ?>
                                    <!-- Theme 2 (Modern Card Clean Redesign) -->
                                    <div class="tml-wf-content-wrapper" style="padding-top: 12px;">
                                        <div class="tml-wf-text-lines" style="margin-top: 10px;">
                                            <div class="tml-wf-line tml-wf-line-lg"></div>
                                            <div class="tml-wf-line tml-wf-line-md"></div>
                                        </div>
                                        <div class="tml-wf-stars-center">
                                            <span class="tml-wf-star"></span><span class="tml-wf-star"></span><span
                                                class="tml-wf-star"></span><span class="tml-wf-star"></span><span
                                                class="tml-wf-star"></span>
                                        </div>
                                        <div class="tml-wf-profile-center" style="margin-bottom: 5px;">
                                            <div class="tml-wf-avatar-md"></div>
                                            <div class="tml-wf-line tml-wf-line-sm"
                                                style="margin-top: 5px; height: 5px; width: 60px;"></div>
                                        </div>
                                    </div>
                                <?php } else if ($i == 1) { ?>
                                        <!-- Theme 1 (Floating Avatar Center Redesign) -->
                                        <div class="tml-wf-t1-card"
                                            style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 22px 10px 10px; display: flex; flex-direction: column; align-items: center; text-align: center; flex-grow: 1; margin-top: 18px; position: relative; background: #fff; width: 100%; box-sizing: border-box; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                                            <!-- Floating Avatar overlapping top edge -->
                                            <div class="tml-wf-avatar-md"
                                                style="position: absolute; top: -16px; left: 50%; transform: translateX(-50%); border: 2px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.08); width: 32px; height: 32px; border-radius: 50%; background: #cbd5e1;">
                                            </div>

                                            <!-- Centered Quote Mark -->
                                            <div
                                                style="font-size: 14px; color: #cbd5e1; font-family: Georgia, serif; line-height: 1; margin-bottom: 4px; margin-top: 2px; font-weight: bold;">
                                                “</div>

                                            <!-- Centered Text lines -->
                                            <div class="tml-wf-line" style="height: 4px; margin-bottom: 4px; width: 85%;"></div>
                                            <div class="tml-wf-line" style="height: 4px; margin-bottom: 8px; width: 60%;"></div>

                                            <!-- Name & Subtext -->
                                            <div class="tml-wf-line"
                                                style="width: 45px; height: 4px; margin-bottom: 2px; background: #cbd5e1;"></div>
                                            <div class="tml-wf-line"
                                                style="width: 30px; height: 3px; margin-bottom: 6px; background: #cbd5e1;"></div>

                                            <!-- Stars centered at the bottom -->
                                            <div class="tml-wf-stars-center" style="margin-top: auto;">
                                                <span class="tml-wf-star"></span><span class="tml-wf-star"></span><span
                                                    class="tml-wf-star"></span><span class="tml-wf-star"></span><span
                                                    class="tml-wf-star"></span>
                                            </div>
                                        </div>
                                <?php } else if ($i == 3) { ?>
                                            <!-- Theme 3 (Simple Centered Classic Redesign) -->
                                            <div class="tml-wf-profile-center"
                                                style="margin-bottom: 6px; display: flex; flex-direction: column; align-items: center; gap: 4px;">
                                                <div class="tml-wf-avatar-md"
                                                    style="width: 32px; height: 32px; border-radius: 50%; background: #cbd5e1; margin: 0 auto;">
                                                </div>
                                            </div>
                                            <div class="tml-wf-line"
                                                style="width: 50px; height: 4px; margin: 0 auto 2px auto; background: #cbd5e1;"></div>
                                            <div class="tml-wf-line"
                                                style="width: 35px; height: 3px; margin: 0 auto 4px auto; background: #cbd5e1;"></div>
                                            <div class="tml-wf-stars-center"
                                                style="margin-bottom: 6px; display: flex; justify-content: center; gap: 2px;">
                                                <span class="tml-wf-star"></span><span class="tml-wf-star"></span><span
                                                    class="tml-wf-star"></span><span class="tml-wf-star"></span><span
                                                    class="tml-wf-star"></span>
                                            </div>
                                            <div class="tml-wf-line tml-wf-line-lg"
                                                style="height: 4px; margin: 6px auto 4px auto; width: 85%;"></div>
                                            <div class="tml-wf-line tml-wf-line-md"
                                                style="height: 4px; margin: 0 auto 0 auto; width: 60%;"></div>

                                <?php } else if ($i == 4) { ?>
                                                <!-- Theme 4 (Premium Trust Card) -->
                                                <div class="tml-wf-card"
                                                    style="display: flex; flex-direction: column; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; width: 100%; box-sizing: border-box; box-shadow: 0 4px 12px rgba(0,0,0,0.02); margin-top: 14px; justify-content: space-between; padding: 12px 10px 8px; height: calc(100% - 14px);">
                                                    <!-- Top Row -->
                                                    <div
                                                        style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 6px;">
                                                        <!-- Quote Badge -->
                                                        <div
                                                            style="width: 12px; height: 12px; background: rgba(99, 102, 241, 0.08); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: Georgia, serif; font-size: 9px; font-weight: bold; color: #6366f1; line-height: 1; padding-top: 2px; box-sizing: border-box;">
                                                            “</div>
                                                        <!-- Verified Tag -->
                                                        <div
                                                            style="background: rgba(16, 185, 129, 0.06); border: 0.5px solid rgba(16, 185, 129, 0.15); border-radius: 10px; padding: 1px 4px; display: flex; align-items: center; gap: 1px;">
                                                            <span
                                                                style="color: #10b981; font-size: 3px; font-weight: bold; line-height: 1;">✓</span>
                                                            <span
                                                                style="color: #10b981; font-size: 2px; font-weight: bold; line-height: 1; text-transform: uppercase;">Verified</span>
                                                        </div>
                                                    </div>

                                                    <!-- Rating Row -->
                                                    <div style="display: flex; gap: 0.5px; margin-bottom: 4px;">
                                                        <span style="font-size: 3px; color: #ffb600; line-height: 1;">★</span>
                                                        <span style="font-size: 3px; color: #ffb600; line-height: 1;">★</span>
                                                        <span style="font-size: 3px; color: #ffb600; line-height: 1;">★</span>
                                                    </div>

                                                    <!-- Body Description -->
                                                    <div style="width: 100%; margin-bottom: 8px;">
                                                        <div class="tml-wf-line"
                                                            style="height: 2px; margin-bottom: 2px; width: 40px; background: #0f172a;">
                                                        </div>
                                                        <div class="tml-wf-line"
                                                            style="height: 2px; margin-bottom: 2px; width: 95%; background: #cbd5e1;"></div>
                                                        <div class="tml-wf-line"
                                                            style="height: 2px; margin-bottom: 0px; width: 75%; background: #cbd5e1;"></div>
                                                    </div>

                                                    <!-- Footer Row -->
                                                    <div
                                                        style="display: flex; align-items: center; border-top: 1px solid #e2e8f0; padding-top: 6px; width: 100%; box-sizing: border-box;">
                                                        <div class="tml-wf-avatar-md"
                                                            style="width: 12px; height: 12px; border-radius: 50%; background: #cbd5e1; margin-right: 4px; flex-shrink: 0;">
                                                        </div>
                                                        <div style="display: flex; flex-direction: column; gap: 1px;">
                                                            <div class="tml-wf-line"
                                                                style="width: 24px; height: 2px; background: #475569; margin: 0;"></div>
                                                            <div class="tml-wf-line"
                                                                style="width: 16px; height: 1.5px; background: #94a3b8; margin: 0;"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                <?php } else if ($i == 5) { ?>
                                                    <!-- Theme 5 (Speech Bubble Card Redesign) -->
                                                    <div class="tml-wf-bubble"
                                                        style="border: 1px solid #cbd5e1; background: #f8fafc; border-radius: 8px; padding: 12px 10px 8px; position: relative; width: 100%; box-sizing: border-box; margin-bottom: 10px;">
                                                        <!-- Mini blue quote icon overlapping top-left edge -->
                                                        <div
                                                            style="position: absolute; top: -6px; left: 8px; background: #fff; border-radius: 3px; font-size: 8px; color: #4f8ef7; line-height: 1; padding: 1px 2px; font-weight: bold; border: 1px solid #e2e8f0; font-family: Georgia, serif;">
                                                            “</div>

                                                        <!-- Bubble Text Lines -->
                                                        <div class="tml-wf-line"
                                                            style="height: 3px; margin-bottom: 3px; width: 95%; background: #cbd5e1;"></div>
                                                        <div class="tml-wf-line"
                                                            style="height: 3px; margin-bottom: 4px; width: 75%; background: #cbd5e1;"></div>

                                                        <!-- Stars rating inside bubble -->
                                                        <div class="tml-wf-stars"
                                                            style="margin-bottom: 0; display: flex; justify-content: flex-start; gap: 1px;">
                                                            <span class="tml-wf-star" style="font-size: 5px; height: 5px; width: 5px;"></span>
                                                            <span class="tml-wf-star" style="font-size: 5px; height: 5px; width: 5px;"></span>
                                                            <span class="tml-wf-star" style="font-size: 5px; height: 5px; width: 5px;"></span>
                                                            <span class="tml-wf-star" style="font-size: 5px; height: 5px; width: 5px;"></span>
                                                            <span class="tml-wf-star" style="font-size: 5px; height: 5px; width: 5px;"></span>
                                                        </div>

                                                        <!-- Speech bubble pointer pointing down -->
                                                        <div
                                                            style="position: absolute; bottom: -5px; left: 16px; border-width: 5px 5px 0; border-style: solid; border-color: #f8fafc transparent; width: 0; height: 0;">
                                                        </div>
                                                        <!-- Speech bubble pointer border -->
                                                        <div
                                                            style="position: absolute; bottom: -6px; left: 16px; border-width: 6px 6px 0; border-style: solid; border-color: #cbd5e1 transparent; z-index: -1; width: 0; height: 0;">
                                                        </div>
                                                    </div>

                                                    <!-- Author block below speech bubble -->
                                                    <div class="tml-wf-flex-row"
                                                        style="gap: 6px; align-items: center; width: 100%; padding-left: 6px;">
                                                        <div class="tml-wf-avatar-sm"
                                                            style="flex-shrink: 0; width: 18px; height: 18px; border-radius: 50%; background: #cbd5e1;">
                                                        </div>
                                                        <div class="tml-wf-flex-col" style="flex-grow: 1; gap: 1px;">
                                                            <div class="tml-wf-line"
                                                                style="width: 45px; height: 3px; margin-bottom: 0; background: #cbd5e1;"></div>
                                                            <div class="tml-wf-line"
                                                                style="width: 30px; height: 2px; margin-bottom: 0; background: #cbd5e1;"></div>
                                                        </div>
                                                    </div>
                                <?php } else if ($i == 6) { ?>
                                                        <!-- Theme 6 (Redesigned Card Layout) -->
                                                        <div class="tml-wf-card"
                                                            style="padding: 10px; min-height: 97px; display: flex; flex-direction: column; gap: 8px; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; width: 100%; box-sizing: border-box; box-shadow: 0 4px 12px rgba(0,0,0,0.02); margin-top: 14px; height: calc(100% - 14px);">

                                                            <!-- Header Row: Avatar + Name / Designation / Link -->
                                                            <div class="tml-wf-flex-row"
                                                                style="display: flex; gap: 8px; align-items: flex-start; width: 100%;">
                                                                <div class="tml-wf-avatar-md"
                                                                    style="width: 24px; height: 24px; border-radius: 50%; background: #cbd5e1; flex-shrink: 0;">
                                                                </div>
                                                                <div class="tml-wf-flex-col"
                                                                    style="display: flex; flex-direction: column; gap: 2px; flex-grow: 1; align-items: flex-start;">
                                                                    <!-- Name line -->
                                                                    <div class="tml-wf-line"
                                                                        style="width: 45px; height: 3px; background: #475569; margin-bottom: 0;">
                                                                    </div>
                                                                    <!-- Designation line -->
                                                                    <div class="tml-wf-line"
                                                                        style="width: 30px; height: 2px; background: #9ca3af; margin-bottom: 0;">
                                                                    </div>
                                                                    <!-- Website Link line -->
                                                                    <div class="tml-wf-line"
                                                                        style="width: 35px; height: 2px; background: #0d6efd; margin-bottom: 0;">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Middle Row: Description text lines spanning full width -->
                                                            <div class="tml-wf-flex-col"
                                                                style="display: flex; flex-direction: column; gap: 3px; width: 100%;">
                                                                <div class="tml-wf-line"
                                                                    style="width: 100%; height: 3px; background: #cbd5e1; margin-bottom: 0;"></div>
                                                                <div class="tml-wf-line"
                                                                    style="width: 90%; height: 3px; background: #cbd5e1; margin-bottom: 0;"></div>
                                                                <div class="tml-wf-line"
                                                                    style="width: 60%; height: 3px; background: #cbd5e1; margin-bottom: 0;"></div>
                                                            </div>

                                                            <!-- Footer Row: Stars (Left-aligned) -->
                                                            <div class="tml-wf-stars"
                                                                style="display: flex; gap: 2px; justify-content: flex-start; margin-top: auto;">
                                                                <span class="tml-wf-star"
                                                                    style="background: #ff9200; width: 4px; height: 4px;"></span>
                                                                <span class="tml-wf-star"
                                                                    style="background: #ff9200; width: 4px; height: 4px;"></span>
                                                                <span class="tml-wf-star"
                                                                    style="background: #ff9200; width: 4px; height: 4px;"></span>
                                                                <span class="tml-wf-star"
                                                                    style="background: #ff9200; width: 4px; height: 4px;"></span>
                                                                <span class="tml-wf-star"
                                                                    style="background: #ff9200; width: 4px; height: 4px;"></span>
                                                            </div>
                                                        </div>
                                <?php } else if ($i == 7) { ?>
                                                            <!-- Theme 7 (Classic Centered Double Quotes Card Redesign) -->
                                                            <div class="tml-wf-flex-col"
                                                                style="align-items: center; width: 100%; box-sizing: border-box; height: 100%; justify-content: center; gap: 8px;">
                                                                <!-- Top centered quotes and review lines row -->
                                                                <div class="tml-wf-flex-row"
                                                                    style="width: 100%; align-items: flex-start; justify-content: center; gap: 6px;">
                                                                    <span
                                                                        style="font-size: 14px; color: #3b82f6; font-family: Georgia, serif; line-height: 1; font-weight: bold; flex-shrink: 0; margin-top: -2px;">“</span>
                                                                    <div class="tml-wf-flex-col" style="flex-grow: 1; gap: 3px; align-items: center;">
                                                                        <div class="tml-wf-line"
                                                                            style="width: 100%; height: 3px; background: #cbd5e1; margin-bottom: 0;">
                                                                        </div>
                                                                        <div class="tml-wf-line"
                                                                            style="width: 80%; height: 3px; background: #cbd5e1; margin-bottom: 0;">
                                                                        </div>
                                                                    </div>
                                                                    <span
                                                                        style="font-size: 14px; color: #3b82f6; font-family: Georgia, serif; line-height: 1; font-weight: bold; flex-shrink: 0; margin-top: -2px;">”</span>
                                                                </div>

                                                                <!-- Centered profile block -->
                                                                <div class="tml-wf-flex-col" style="align-items: center; gap: 2px; width: 100%;">
                                                                    <div class="tml-wf-avatar-md"
                                                                        style="width: 20px; height: 20px; border-radius: 50%; background: #cbd5e1; box-sizing: border-box; margin-bottom: 2px;">
                                                                    </div>
                                                                    <div class="tml-wf-line"
                                                                        style="width: 32px; height: 3px; margin: 0 auto; background: #db2777;"></div>
                                                                    <div class="tml-wf-line"
                                                                        style="width: 24px; height: 2.5px; margin: 0 auto; background: #3b82f6;"></div>

                                                                    <!-- Centered Star rating wireframe -->
                                                                    <div class="tml-wf-stars"
                                                                        style="margin-top: 3px; display: flex; justify-content: center; gap: 1px; width: 100%;">
                                                                        <span class="tml-wf-star"
                                                                            style="font-size: 3px; height: 3px; width: 3px;"></span>
                                                                        <span class="tml-wf-star"
                                                                            style="font-size: 3px; height: 3px; width: 3px;"></span>
                                                                        <span class="tml-wf-star"
                                                                            style="font-size: 3px; height: 3px; width: 3px;"></span>
                                                                        <span class="tml-wf-star"
                                                                            style="font-size: 3px; height: 3px; width: 3px;"></span>
                                                                        <span class="tml-wf-star"
                                                                            style="font-size: 3px; height: 3px; width: 3px;"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                <?php } else if ($i == 8) { ?>
                                                                <!-- [ignoring loop detection] Theme 8 (Circular Avatar with Overlapping Green Quote Badge) -->
                                                                <div class="tml-wf-flex-col"
                                                                    style="align-items: flex-start; width: 100%; box-sizing: border-box; height: 100%; justify-content: center; gap: 8px; padding-top: 5px;">
                                                                    <!-- Top row: Avatar & Description side-by-side -->
                                                                    <div class="tml-wf-flex-row" style="width: 100%; align-items: center; gap: 10px;">
                                                                        <!-- Circular Avatar wrapper with absolute green quote badge -->
                                                                        <div style="position: relative; width: 28px; height: 28px; flex-shrink: 0;">
                                                                            <div class="tml-wf-avatar-md"
                                                                                style="width: 28px; height: 28px; border-radius: 50%; background: #cbd5e1; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                                                                            </div>
                                                                            <!-- Overlapping Quote Badge -->
                                                                            <div
                                                                                style="position: absolute; bottom: -2px; left: -2px; width: 10px; height: 10px; border-radius: 50%; background: #10b981; border: 1px solid #ffffff; display: flex; align-items: center; justify-content: center; font-size: 5px; color: #ffffff;">
                                                                                “</div>
                                                                        </div>
                                                                        <!-- Right side: lines -->
                                                                        <div class="tml-wf-flex-col" style="flex-grow: 1; gap: 3px;">
                                                                            <div class="tml-wf-line"
                                                                                style="width: 100%; height: 3px; background: #cbd5e1; margin-bottom: 0;">
                                                                            </div>
                                                                            <div class="tml-wf-line"
                                                                                style="width: 75%; height: 3px; background: #cbd5e1; margin-bottom: 0;">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Bottom column: Left aligned metadata separated by "/" -->
                                                                    <div class="tml-wf-flex-col"
                                                                        style="align-items: flex-start; gap: 2px; width: 100%; padding-left: 38px;">
                                                                        <div class="tml-wf-flex-row" style="align-items: center; gap: 4px;">
                                                                            <div class="tml-wf-line"
                                                                                style="width: 36px; height: 3px; background: #10b981; margin-bottom: 0;">
                                                                            </div>
                                                                            <span
                                                                                style="font-size: 8px; color: #9ca3af; line-height: 1; font-weight: bold;">/</span>
                                                                            <div class="tml-wf-line"
                                                                                style="width: 44px; height: 2.5px; background: #4b5563; margin-bottom: 0;">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                <?php } else if ($i == 9) { ?>
                                                                    <!-- Theme 9 (Orange Modern Frame) -->
                                                                    <div class="tml-wf-flex-row"
                                                                        style="align-items: center; width: 100%; box-sizing: border-box; height: 100%; justify-content: center; gap: 15px; padding: 5px;">
                                                                        <!-- Left side: Avatar with orange bracket outline -->
                                                                        <div
                                                                            style="position: relative; width: 34px; height: 34px; padding: 4px; box-sizing: border-box; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                                                                            <!-- Top-Right Orange bracket corner -->
                                                                            <div
                                                                                style="position: absolute; top: 0; right: 0; width: 10px; height: 10px; border-top: 1.5px solid #ff6a3d; border-right: 1.5px solid #ff6a3d;">
                                                                            </div>
                                                                            <!-- Bottom-Left Orange bracket corner -->
                                                                            <div
                                                                                style="position: absolute; bottom: 0; left: 0; width: 10px; height: 10px; border-bottom: 1.5px solid #ff6a3d; border-left: 1.5px solid #ff6a3d;">
                                                                            </div>
                                                                            <!-- Square avatar inside -->
                                                                            <div style="width: 24px; height: 24px; background: #cbd5e1; border-radius: 2px;">
                                                                            </div>
                                                                        </div>

                                                                        <!-- Right side: Name, line, designation, description -->
                                                                        <div class="tml-wf-flex-col" style="flex-grow: 1; gap: 4px;">
                                                                            <!-- Title & Designation Row -->
                                                                            <div class="tml-wf-flex-row" style="align-items: center; gap: 4px;">
                                                                                <!-- Orange Name line -->
                                                                                <div class="tml-wf-line"
                                                                                    style="width: 30px; height: 3px; background: #ff6a3d; margin-bottom: 0;">
                                                                                </div>
                                                                                <!-- Grey | vertical line -->
                                                                                <span style="font-size: 8px; color: #d1d5db; line-height: 1;">|</span>
                                                                                <!-- Grey Designation line -->
                                                                                <div class="tml-wf-line"
                                                                                    style="width: 25px; height: 2.5px; background: #9ca3af; margin-bottom: 0;">
                                                                                </div>
                                                                            </div>

                                                                            <!-- Content description lines -->
                                                                            <div class="tml-wf-line"
                                                                                style="width: 100%; height: 2.5px; background: #cbd5e1; margin-bottom: 0;">
                                                                            </div>
                                                                            <div class="tml-wf-line"
                                                                                style="width: 80%; height: 2.5px; background: #cbd5e1; margin-bottom: 0;"></div>
                                                                        </div>
                                                                    </div>
                                <?php } else if ($i == 10) { ?>
                                                                        <!-- Theme 10 (Premium Video Rectangle Inset Cover Card) -->
                                                                        <div class="tml-wf-flex-col"
                                                                            style="align-items: center; width: 100%; box-sizing: border-box; height: 100%; justify-content: center; gap: 8px; padding: 10px; background: #f0f5ff; border: 1px solid rgba(0, 0, 0, 0.05); border-radius: 8px;">

                                                                            <!-- Top Rectangular Mock Image with Play Button Centered -->
                                                                            <div
                                                                                style="width: 100%; aspect-ratio: 1.5 / 1; border-radius: 4px; background: #cbd5e1; position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                                                                <!-- Play Button Icon mockup -->
                                                                                <div
                                                                                    style="width: 22px; height: 22px; border-radius: 50%; border: 2px solid #ffffff; background: rgba(17, 24, 39, 0.7); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                                                                                    <span style="margin-left: 1px; font-size: 8px;">▶</span>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Centered Name Line -->
                                                                            <div class="tml-wf-line"
                                                                                style="width: 55px; height: 3px; background: #1f2937; margin: 2px 0 0 0;"></div>

                                                                            <!-- Centered Stars Mockup -->
                                                                            <div style="display: flex; gap: 2px; justify-content: center;">
                                                                                <span style="font-size: 8px; color: #ffb600; line-height: 1;">★</span>
                                                                                <span style="font-size: 8px; color: #ffb600; line-height: 1;">★</span>
                                                                                <span style="font-size: 8px; color: #ffb600; line-height: 1;">★</span>
                                                                                <span style="font-size: 8px; color: #ffb600; line-height: 1;">★</span>
                                                                                <span style="font-size: 8px; color: #ffb600; line-height: 1;">★</span>
                                                                            </div>

                                                                            <!-- Centered Designation Line -->
                                                                            <div class="tml-wf-line"
                                                                                style="width: 40px; height: 2px; background: #6b7280; margin: 0;"></div>
                                                                        </div>
                                <?php } else if ($i == 11) { ?>
                                                                            <!-- Theme 11 (Elegant Speech Bubble in 2 Columns Mockup) -->
                                                                            <div class="tml-wf-flex-row"
                                                                                style="align-items: center; gap: 8px; width: 100%; box-sizing: border-box; height: 100%; justify-content: center; padding: 4px;">

                                                                                <!-- Column 1 -->
                                                                                <div class="tml-wf-flex-col"
                                                                                    style="align-items: center; flex: 1; gap: 4px; box-sizing: border-box;">
                                                                                    <!-- Speech Bubble container -->
                                                                                    <div
                                                                                        style="position: relative; width: 100%; background: #f3f4f6; border-radius: 4px; padding: 5px; box-sizing: border-box; display: flex; flex-direction: column; gap: 2px; align-items: center; justify-content: center;">
                                                                                        <div class="tml-wf-line"
                                                                                            style="width: 85%; height: 2px; background: #cbd5e1; margin-bottom: 0;">
                                                                                        </div>
                                                                                        <div class="tml-wf-line"
                                                                                            style="width: 65%; height: 2px; background: #cbd5e1; margin-bottom: 0;">
                                                                                        </div>
                                                                                        <!-- Pointing arrow at the bottom -->
                                                                                        <div
                                                                                            style="position: absolute; bottom: -4px; left: 50%; transform: translateX(-50%); width: 0; height: 0; border-left: 4px solid transparent; border-right: 4px solid transparent; border-top: 4px solid #f3f4f6;">
                                                                                        </div>
                                                                                    </div>

                                                                                    <!-- Avatar -->
                                                                                    <div class="tml-wf-avatar-sm"
                                                                                        style="width: 14px; height: 14px; border-radius: 50%; background: #cbd5e1; margin-top: 2px; flex-shrink: 0;">
                                                                                    </div>

                                                                                    <!-- Name Line -->
                                                                                    <div class="tml-wf-line"
                                                                                        style="width: 20px; height: 2px; background: #ff6a3d; margin-bottom: 0;"></div>

                                                                                    <!-- Stars (Centered) -->
                                                                                    <div class="tml-wf-flex-row"
                                                                                        style="gap: 1px; justify-content: center; align-items: center;">
                                                                                        <span class="tml-wf-star"
                                                                                            style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                        <span class="tml-wf-star"
                                                                                            style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                        <span class="tml-wf-star"
                                                                                            style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                        <span class="tml-wf-star"
                                                                                            style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                        <span class="tml-wf-star"
                                                                                            style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Column 2 -->
                                                                                <div class="tml-wf-flex-col"
                                                                                    style="align-items: center; flex: 1; gap: 4px; box-sizing: border-box;">
                                                                                    <!-- Speech Bubble container -->
                                                                                    <div
                                                                                        style="position: relative; width: 100%; background: #f3f4f6; border-radius: 4px; padding: 5px; box-sizing: border-box; display: flex; flex-direction: column; gap: 2px; align-items: center; justify-content: center;">
                                                                                        <div class="tml-wf-line"
                                                                                            style="width: 85%; height: 2px; background: #cbd5e1; margin-bottom: 0;">
                                                                                        </div>
                                                                                        <div class="tml-wf-line"
                                                                                            style="width: 65%; height: 2px; background: #cbd5e1; margin-bottom: 0;">
                                                                                        </div>
                                                                                        <!-- Pointing arrow at the bottom -->
                                                                                        <div
                                                                                            style="position: absolute; bottom: -4px; left: 50%; transform: translateX(-50%); width: 0; height: 0; border-left: 4px solid transparent; border-right: 4px solid transparent; border-top: 4px solid #f3f4f6;">
                                                                                        </div>
                                                                                    </div>

                                                                                    <!-- Avatar -->
                                                                                    <div class="tml-wf-avatar-sm"
                                                                                        style="width: 14px; height: 14px; border-radius: 50%; background: #cbd5e1; margin-top: 2px; flex-shrink: 0;">
                                                                                    </div>

                                                                                    <!-- Name Line -->
                                                                                    <div class="tml-wf-line"
                                                                                        style="width: 20px; height: 2px; background: #ff6a3d; margin-bottom: 0;"></div>

                                                                                    <!-- Stars (Centered) -->
                                                                                    <div class="tml-wf-flex-row"
                                                                                        style="gap: 1px; justify-content: center; align-items: center;">
                                                                                        <span class="tml-wf-star"
                                                                                            style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                        <span class="tml-wf-star"
                                                                                            style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                        <span class="tml-wf-star"
                                                                                            style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                        <span class="tml-wf-star"
                                                                                            style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                        <span class="tml-wf-star"
                                                                                            style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                <?php } else if ($i == 12) { ?>
                                                                                <!-- Theme 12 (Modern Header Card in 2 Columns Mockup) -->
                                                                                <div class="tml-wf-flex-row"
                                                                                    style="align-items: center; gap: 8px; width: 100%; box-sizing: border-box; height: 100%; justify-content: center; padding: 4px;">

                                                                                    <!-- Column 1 -->
                                                                                    <div class="tml-wf-flex-col"
                                                                                        style="align-items: center; flex: 1; gap: 4px; box-sizing: border-box; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 4px; overflow: hidden; padding-bottom: 6px;">
                                                                                        <!-- Header Block (filled rectangular top block) -->
                                                                                        <div style="width: 100%; height: 16px; background: #cbd5e1; position: relative;">
                                                                                            <!-- Overlapping circular avatar -->
                                                                                            <div class="tml-wf-avatar-sm"
                                                                                                style="width: 16px; height: 16px; border-radius: 50%; background: #9ca3af; border: 1px solid #ffffff; position: absolute; bottom: -8px; left: 50%; transform: translateX(-50%); z-index: 2; box-shadow: 0 1px 3px rgba(0,0,0,0.1); box-sizing: border-box;">
                                                                                            </div>
                                                                                        </div>

                                                                                        <!-- Name -->
                                                                                        <div class="tml-wf-line"
                                                                                            style="width: 25px; height: 2px; background: #ff6a3d; margin-top: 6px; margin-bottom: 0;">
                                                                                        </div>

                                                                                        <!-- Stars (Centered) -->
                                                                                        <div class="tml-wf-flex-row"
                                                                                            style="gap: 1px; justify-content: center; align-items: center; margin-bottom: 2px;">
                                                                                            <span class="tml-wf-star"
                                                                                                style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                            <span class="tml-wf-star"
                                                                                                style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                            <span class="tml-wf-star"
                                                                                                style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                            <span class="tml-wf-star"
                                                                                                style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                            <span class="tml-wf-star"
                                                                                                style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                        </div>

                                                                                        <!-- Description Lines -->
                                                                                        <div class="tml-wf-line"
                                                                                            style="width: 80%; height: 1.5px; background: #e5e7eb; margin-bottom: 0;"></div>
                                                                                        <div class="tml-wf-line"
                                                                                            style="width: 60%; height: 1.5px; background: #e5e7eb; margin-bottom: 0;"></div>
                                                                                    </div>

                                                                                    <!-- Column 2 -->
                                                                                    <div class="tml-wf-flex-col"
                                                                                        style="align-items: center; flex: 1; gap: 4px; box-sizing: border-box; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 4px; overflow: hidden; padding-bottom: 6px;">
                                                                                        <!-- Header Block (filled rectangular top block) -->
                                                                                        <div style="width: 100%; height: 16px; background: #cbd5e1; position: relative;">
                                                                                            <!-- Overlapping circular avatar -->
                                                                                            <div class="tml-wf-avatar-sm"
                                                                                                style="width: 16px; height: 16px; border-radius: 50%; background: #9ca3af; border: 1px solid #ffffff; position: absolute; bottom: -8px; left: 50%; transform: translateX(-50%); z-index: 2; box-shadow: 0 1px 3px rgba(0,0,0,0.1); box-sizing: border-box;">
                                                                                            </div>
                                                                                        </div>

                                                                                        <!-- Name -->
                                                                                        <div class="tml-wf-line"
                                                                                            style="width: 25px; height: 2px; background: #ff6a3d; margin-top: 6px; margin-bottom: 0;">
                                                                                        </div>

                                                                                        <!-- Stars (Centered) -->
                                                                                        <div class="tml-wf-flex-row"
                                                                                            style="gap: 1px; justify-content: center; align-items: center; margin-bottom: 2px;">
                                                                                            <span class="tml-wf-star"
                                                                                                style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                            <span class="tml-wf-star"
                                                                                                style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                            <span class="tml-wf-star"
                                                                                                style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                            <span class="tml-wf-star"
                                                                                                style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                            <span class="tml-wf-star"
                                                                                                style="font-size: 2px; height: 2px; width: 2px;"></span>
                                                                                        </div>

                                                                                        <!-- Description Lines -->
                                                                                        <div class="tml-wf-line"
                                                                                            style="width: 80%; height: 1.5px; background: #e5e7eb; margin-bottom: 0;"></div>
                                                                                        <div class="tml-wf-line"
                                                                                            style="width: 60%; height: 1.5px; background: #e5e7eb; margin-bottom: 0;"></div>
                                                                                    </div>

                                                                                </div>
                                <?php } else if ($i == 13) { ?>
                                                                                    <!-- Theme 13 (Modern Ticket/Coupon Stub Mockup) -->
                                                                                    <div class="tml-wf-flex-row"
                                                                                        style="width: 100%; box-sizing: border-box; height: 100%; justify-content: flex-start; position: relative; background: #ffffff; border-radius: 12px; border: 1px solid rgba(226, 232, 240, 0.8); overflow: visible; padding: 0; align-items: stretch; gap: 0;">

                                                                                        <!-- Top and bottom physical circular cutouts -->
                                                                                        <div
                                                                                            style="position: absolute; top: -6px; left: 28%; transform: translateX(-50%); width: 12px; height: 12px; border-radius: 50%; background: #fafafa; border: 1px solid rgba(226, 232, 240, 0.8); z-index: 100;">
                                                                                        </div>
                                                                                        <div
                                                                                            style="position: absolute; bottom: -6px; left: 28%; transform: translateX(-50%); width: 12px; height: 12px; border-radius: 50%; background: #fafafa; border: 1px solid rgba(226, 232, 240, 0.8); z-index: 100;">
                                                                                        </div>

                                                                                        <!-- Left portion: stub -->
                                                                                        <div class="tml-wf-flex-col"
                                                                                            style="width: 28%; height: 100%; justify-content: center; align-items: center; gap: 2px; padding: 6px; box-sizing: border-box;">
                                                                                            <!-- Tiny avatar -->
                                                                                            <div
                                                                                                style="width: 16px; height: 16px; border-radius: 50%; background: #cbd5e1; border: 1px solid #ff6a3d; box-shadow: 0 1px 3px rgba(255, 106, 61, 0.15); flex-shrink: 0;">
                                                                                            </div>
                                                                                            <!-- Name and designation lines -->
                                                                                            <div class="tml-wf-line"
                                                                                                style="width: 80%; height: 2px; background: #0f172a; margin-bottom: 0;"></div>
                                                                                            <div class="tml-wf-line"
                                                                                                style="width: 60%; height: 1.5px; background: #db2777; margin-bottom: 0;"></div>
                                                                                        </div>

                                                                                        <!-- Vertical divider line -->
                                                                                        <div
                                                                                            style="width: 0; border-left: 1px dashed rgba(226, 232, 240, 1); align-self: stretch; margin: 6px 0;">
                                                                                        </div>

                                                                                        <!-- Right portion: body -->
                                                                                        <div class="tml-wf-flex-col"
                                                                                            style="width: 72%; height: 100%; justify-content: center; align-items: flex-start; gap: 2.5px; padding: 8px 10px; box-sizing: border-box; position: relative;">
                                                                                            <!-- Subtle quote decorator -->
                                                                                            <span
                                                                                                style="position: absolute; top: 1px; right: 4px; font-size: 16px; color: rgba(255, 106, 61, 0.08); font-family: Georgia, serif; pointer-events: none; font-weight: bold; line-height: 1;">“</span>

                                                                                            <!-- Rating stars -->
                                                                                            <div class="tml-wf-flex-row" style="gap: 0.5px; margin-bottom: 1px;">
                                                                                                <span class="tml-wf-star"
                                                                                                    style="font-size: 2px; height: 1.5px; width: 1.5px; background: #ff6a3d;"></span>
                                                                                                <span class="tml-wf-star"
                                                                                                    style="font-size: 2px; height: 1.5px; width: 1.5px; background: #ff6a3d;"></span>
                                                                                                <span class="tml-wf-star"
                                                                                                    style="font-size: 2px; height: 1.5px; width: 1.5px; background: #ff6a3d;"></span>
                                                                                                <span class="tml-wf-star"
                                                                                                    style="font-size: 2px; height: 1.5px; width: 1.5px; background: #ff6a3d;"></span>
                                                                                                <span class="tml-wf-star"
                                                                                                    style="font-size: 2px; height: 1.5px; width: 1.5px; background: #ff6a3d;"></span>
                                                                                            </div>

                                                                                            <!-- Description text -->
                                                                                            <div class="tml-wf-line"
                                                                                                style="width: 90%; height: 1.5px; background: #cbd5e1; margin-bottom: 0;"></div>
                                                                                            <div class="tml-wf-line"
                                                                                                style="width: 85%; height: 1.5px; background: #cbd5e1; margin-bottom: 0;"></div>
                                                                                            <div class="tml-wf-line"
                                                                                                style="width: 70%; height: 1.5px; background: #cbd5e1; margin-bottom: 0;"></div>
                                                                                        </div>
                                                                                    </div>
                                <?php } else if ($i == 14) { ?>
                                                                                        <!-- Theme 14 (Video Premium Card) -->
                                                                                        <div class="tml-wf-video-block">
                                                                                            <div class="tml-wf-play-btn"><i class="fa fa-play"
                                                                                                    style="font-size: 8px; margin-left: 2px; color: #475569;"></i></div>
                                                                                        </div>
                                                                                        <div class="tml-wf-flex-row"
                                                                                            style="gap: 8px; align-items: center; padding: 6px 0 0 0; margin-top: auto;">
                                                                                            <div class="tml-wf-avatar-sm" style="flex-shrink: 0;"></div>
                                                                                            <div class="tml-wf-flex-col" style="flex-grow: 1; gap: 2px;">
                                                                                                <div class="tml-wf-line" style="width: 50%; height: 5px; margin-bottom: 0;"></div>
                                                                                                <div class="tml-wf-line" style="width: 30%; height: 4px; margin-bottom: 0;"></div>
                                                                                            </div>
                                                                                        </div>
                                <?php } else if ($i == 15) { ?>
                                                                                            <!-- Theme 15 (Scandinavian Layered Card Mockup) -->
                                                                                            <div class="tml-wf-flex-col"
                                                                                                style="width: 100%; box-sizing: border-box; height: 100%; justify-content: center; position: relative; background: #ffffff; padding: 0; align-items: stretch; gap: 0;">
                                                                                                <!-- Offset background border block representing layered design -->
                                                                                                <div
                                                                                                    style="position: absolute; top: 4px; left: 4px; right: -4px; bottom: -4px; background: transparent; border: 1px solid #0f172a; border-radius: 8px; z-index: 1;">
                                                                                                </div>
                                                                                                <!-- Foreground block -->
                                                                                                <div class="tml-wf-flex-col"
                                                                                                    style="position: relative; z-index: 2; width: 100%; height: 100%; background: #ffffff; border: 1px solid #0f172a; border-radius: 8px; padding: 10px; box-sizing: border-box; justify-content: center; gap: 4px;">
                                                                                                    <div class="tml-wf-flex-row" style="align-items: center; gap: 6px; width: 100%;">
                                                                                                        <div
                                                                                                            style="width: 14px; height: 14px; border-radius: 50%; background: #cbd5e1; border: 1px solid #0f172a; flex-shrink: 0;">
                                                                                                        </div>
                                                                                                        <div class="tml-wf-flex-col" style="gap: 1.5px; flex-grow: 1;">
                                                                                                            <div class="tml-wf-line"
                                                                                                                style="width: 50%; height: 2px; background: #0f172a; margin-bottom: 0;">
                                                                                                            </div>
                                                                                                            <div class="tml-wf-line"
                                                                                                                style="width: 30%; height: 1.5px; background: #64748b; margin-bottom: 0;">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="tml-wf-flex-row" style="gap: 0.5px;">
                                                                                                        <span class="tml-wf-star"
                                                                                                            style="font-size: 2px; height: 1.5px; width: 1.5px; background: #0f172a;"></span>
                                                                                                        <span class="tml-wf-star"
                                                                                                            style="font-size: 2px; height: 1.5px; width: 1.5px; background: #0f172a;"></span>
                                                                                                        <span class="tml-wf-star"
                                                                                                            style="font-size: 2px; height: 1.5px; width: 1.5px; background: #0f172a;"></span>
                                                                                                        <span class="tml-wf-star"
                                                                                                            style="font-size: 2px; height: 1.5px; width: 1.5px; background: #0f172a;"></span>
                                                                                                        <span class="tml-wf-star"
                                                                                                            style="font-size: 2px; height: 1.5px; width: 1.5px; background: #0f172a;"></span>
                                                                                                    </div>
                                                                                                    <div class="tml-wf-line"
                                                                                                        style="width: 90%; height: 1.5px; background: #cbd5e1; margin-bottom: 0;"></div>
                                                                                                    <div class="tml-wf-line"
                                                                                                        style="width: 80%; height: 1.5px; background: #cbd5e1; margin-bottom: 0;"></div>
                                                                                                </div>
                                                                                            </div>
                                <?php } else if ($i == 16) { ?>
                                                                                                <!-- Theme 16 (Royal Neon Aurora Glow Mockup) -->
                                                                                                <div class="tml-wf-flex-col"
                                                                                                    style="width: 100%; box-sizing: border-box; height: 100%; justify-content: center; position: relative; background: #ffffff; border-radius: 12px; border: 1px solid rgba(226, 232, 240, 0.8); overflow: hidden; padding: 12px 10px 10px 10px; align-items: flex-start; gap: 3.5px; box-shadow: 0 4px 8px rgba(99, 102, 241, 0.04);">
                                                                                                    <!-- Top horizontal glowing strip representation -->
                                                                                                    <div
                                                                                                        style="position: absolute; top: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, #6366f1 0%, #a855f7 50%, #ec4899 100%);">
                                                                                                    </div>

                                                                                                    <!-- Header section with avatar container and verified text -->
                                                                                                    <div class="tml-wf-flex-row" style="align-items: center; gap: 6px; width: 100%;">
                                                                                                        <!-- Glowing avatar -->
                                                                                                        <div
                                                                                                            style="width: 15px; height: 15px; border-radius: 50%; background: #cbd5e1; border: 1px solid #a855f7; box-shadow: 0 0 3px rgba(168, 85, 247, 0.3); flex-shrink: 0;">
                                                                                                        </div>
                                                                                                        <div class="tml-wf-flex-col" style="gap: 1.5px; flex-grow: 1;">
                                                                                                            <div class="tml-wf-line"
                                                                                                                style="width: 45%; height: 2px; background: #0f172a; margin-bottom: 0;">
                                                                                                            </div>
                                                                                                            <!-- Sub row with verified pill badge -->
                                                                                                            <div class="tml-wf-flex-row" style="gap: 3px; align-items: center;">
                                                                                                                <div class="tml-wf-line"
                                                                                                                    style="width: 20%; height: 1.5px; background: #64748b; margin-bottom: 0;">
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    style="width: 12px; height: 4px; border-radius: 4px; background: rgba(16, 185, 129, 0.15); border: 0.2px solid rgba(16, 185, 129, 0.3); flex-shrink: 0;">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <!-- Star ratings -->
                                                                                                    <div class="tml-wf-flex-row" style="gap: 0.5px;">
                                                                                                        <span class="tml-wf-star"
                                                                                                            style="font-size: 2px; height: 1.5px; width: 1.5px; background: #f59e0b;"></span>
                                                                                                        <span class="tml-wf-star"
                                                                                                            style="font-size: 2px; height: 1.5px; width: 1.5px; background: #f59e0b;"></span>
                                                                                                        <span class="tml-wf-star"
                                                                                                            style="font-size: 2px; height: 1.5px; width: 1.5px; background: #f59e0b;"></span>
                                                                                                        <span class="tml-wf-star"
                                                                                                            style="font-size: 2px; height: 1.5px; width: 1.5px; background: #f59e0b;"></span>
                                                                                                        <span class="tml-wf-star"
                                                                                                            style="font-size: 2px; height: 1.5px; width: 1.5px; background: #f59e0b;"></span>
                                                                                                    </div>

                                                                                                    <!-- Description text representation -->
                                                                                                    <div class="tml-wf-line"
                                                                                                        style="width: 90%; height: 1.5px; background: #cbd5e1; margin-bottom: 0;"></div>
                                                                                                    <div class="tml-wf-line"
                                                                                                        style="width: 80%; height: 1.5px; background: #cbd5e1; margin-bottom: 0;"></div>
                                                                                                </div>
                                <?php } else if ($i == 17) { ?>
                                                                                                    <!-- Theme 17 (Custom Field Builder Layout Mockup) -->
                                                                                                    <div class="tml-wf-flex-col"
                                                                                                        style="width: 100%; box-sizing: border-box; height: 100%; justify-content: center; align-items: center; gap: 4px; padding: 10px; background: #ffffff;">
                                                                                                        <!-- Stack of 4 distinct blocks representing flexible sorting -->
                                                                                                        <div
                                                                                                            style="width: 80%; height: 8px; border: 1px dashed #6366f1; border-radius: 4px; background: rgba(99, 102, 241, 0.05); display: flex; align-items: center; justify-content: center; font-size: 5px; color: #6366f1; font-weight: bold; line-height: 1;">
                                                                                                            Image</div>
                                                                                                        <div
                                                                                                            style="width: 80%; height: 8px; border: 1px dashed #6366f1; border-radius: 4px; background: rgba(99, 102, 241, 0.05); display: flex; align-items: center; justify-content: center; font-size: 5px; color: #6366f1; font-weight: bold; line-height: 1;">
                                                                                                            Rating</div>
                                                                                                        <div
                                                                                                            style="width: 80%; height: 8px; border: 1px dashed #6366f1; border-radius: 4px; background: rgba(99, 102, 241, 0.05); display: flex; align-items: center; justify-content: center; font-size: 5px; color: #6366f1; font-weight: bold; line-height: 1;">
                                                                                                            Content</div>
                                                                                                        <div
                                                                                                            style="width: 80%; height: 8px; border: 1px dashed #6366f1; border-radius: 4px; background: rgba(99, 102, 241, 0.05); display: flex; align-items: center; justify-content: center; font-size: 5px; color: #6366f1; font-weight: bold; line-height: 1;">
                                                                                                            Author</div>
                                                                                                    </div>
                                <?php } ?>
                            </div>

                            <span class="tml-theme-label"><?php echo esc_html($name); ?></span>
                            <?php if ($is_disabled): ?>
                                <span class="tml-pro-badge"
                                    style="position: absolute; top: 4px; right: 4px; background: #d63638; color: #fff; font-size: 8px; font-weight: 700; padding: 2px 5px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 2px 4px rgba(214, 54, 56, 0.3); line-height: 1; z-index: 10;">PRO</span>
                            <?php endif; ?>
                        </label>
                    <?php } ?>
                </div>
            </div>
            <!-- SLIDER CONFIG TAB -->
            <div id="tml-tab-slider" class="tml-tab-content" style="padding:0; border:none; box-shadow:none;">
                <div class="tml-mui-container" style="background:#fff; min-height:500px; padding:0; gap:0;">
                    <!-- Vertical Sidebar -->
                    <div class="tml-mui-sidebar"
                        style="width:240px; border-right:1px solid var(--tml-border); padding: 16px 0; background: rgba(0, 0, 0, 0.02); flex-shrink: 0;">
                        <a href="#" class="tml-mui-nav-item tml-s-tab active" data-stab="basics">
                            <i class="fa fa-sliders"></i> <?php esc_html_e('Slider Basics', 'testimonial-maker'); ?>
                        </a>
                        <a href="#" class="tml-mui-nav-item tml-s-tab" data-stab="navigation">
                            <i class="fa fa-compass"></i> <?php esc_html_e('Navigation', 'testimonial-maker'); ?>
                        </a>
                        <a href="#" class="tml-mui-nav-item tml-s-tab" data-stab="pagination">
                            <i class="fa fa-list-ol"></i> <?php esc_html_e('Pagination', 'testimonial-maker'); ?>
                        </a>
                        <a href="#" class="tml-mui-nav-item tml-s-tab" data-stab="misc">
                            <i class="fa fa-cogs"></i> <?php esc_html_e('Miscellaneous', 'testimonial-maker'); ?>
                        </a>
                    </div>

                    <!-- Vertical Content -->
                    <div class="tml-mui-content" style="flex-grow:1; padding:24px; box-sizing: border-box;">

                        <!-- BASICS PANEL -->
                        <div id="tml-stab-basics" class="tml-s-content active">
                            <div class="tml-mui-card">
                                <div class="tml-mui-card-title">
                                    <?php esc_html_e('Slider Basics', 'testimonial-maker'); ?>
                                </div>

                                <!-- Auto Play -->
                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Auto Play', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Enable/Disable autoplay.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:20px;">
                                        <?php $ap = $get_val('auto_play_carousel', 'true'); ?>
                                        <input type="hidden" name="auto_play_carousel" value="false">
                                        <label class="tml-toggle-label">
                                            <input type="checkbox" name="auto_play_carousel" value="true" <?php checked($ap, 'true'); ?> class="tml-toggle-input">
                                            <span class="tml-toggle-switch"></span>
                                        </label>
                                        <label style="font-weight:500; display:flex; align-items:center; gap:8px;">
                                            <input type="hidden" name="tml_autoplay_mobile" value="true">
                                            <input type="checkbox" name="tml_autoplay_mobile" value="false" <?php checked($get_val('tml_autoplay_mobile', 'true'), 'false'); ?>>
                                            <?php esc_html_e('Disable on Mobile', 'testimonial-maker'); ?>
                                        </label>
                                    </div>
                                </div>

                                <!-- Auto Play Delay -->
                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Auto Play Delay', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Set auto play delay time in millisecond.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:15px;">
                                        <?php $delay = $get_val('tml_timeout_speed', '3000'); ?>
                                        <input type="range" min="500" max="10000" step="100" class="tml-range-slider"
                                            value="<?php echo esc_attr($delay); ?>"
                                            oninput="this.nextElementSibling.value = this.value">
                                        <input type="number" name="tml_timeout_speed"
                                            value="<?php echo esc_attr($delay); ?>"
                                            style="width:70px; height:35px; text-align:center; border:1px solid #ddd; border-radius:4px;">
                                        <span
                                            style="background:#eee; padding:5px 10px; border:1px solid #ddd; border-left:none; border-radius:0 3px 3px 0; margin-left:-16px; height:23px; display:flex; align-items:center; font-size:12px; color:#666;">ms</span>
                                    </div>
                                </div>

                                <!-- Transition Speed -->
                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Transition Speed', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Set slide transition speed in millisecond.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:15px;">
                                        <?php $speed = $get_val('tml_slide_speed', '3000'); ?>
                                        <input type="range" min="100" max="5000" step="100" class="tml-range-slider"
                                            value="<?php echo esc_attr($speed); ?>"
                                            oninput="this.nextElementSibling.value = this.value">
                                        <input type="number" name="tml_slide_speed"
                                            value="<?php echo esc_attr($speed); ?>"
                                            style="width:70px; height:35px; text-align:center; border:1px solid #ddd; border-radius:4px;">
                                        <span
                                            style="background:#eee; padding:5px 10px; border:1px solid #ddd; border-left:none; border-radius:0 3px 3px 0; margin-left:-16px; height:23px; display:flex; align-items:center; font-size:12px; color:#666;">ms</span>
                                    </div>
                                </div>

                                <!-- Pause on Hover -->
                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Pause on Hover', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Enable/Disable slider pause on hover.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div>
                                        <?php $poh = $get_val('tml_hover_pause', 'true'); ?>
                                        <input type="hidden" name="tml_hover_pause" value="false">
                                        <label class="tml-toggle-label">
                                            <input type="checkbox" name="tml_hover_pause" value="true" <?php checked($poh, 'true'); ?> class="tml-toggle-input">
                                            <span class="tml-toggle-switch"></span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Infinite Loop -->
                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Infinite Loop', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Enable/Disable infinite loop mode.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div>
                                        <?php $loop = $get_val('tml_testimonial_loop', 'true'); ?>
                                        <input type="hidden" name="tml_testimonial_loop" value="false">
                                        <label class="tml-toggle-label">
                                            <input type="checkbox" name="tml_testimonial_loop" value="true" <?php checked($loop, 'true'); ?> class="tml-toggle-input">
                                            <span class="tml-toggle-switch"></span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Transition Effect -->
                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Transition Effect', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Select a transition effect or animation.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div>
                                        <?php $effect = $get_val('tml_animateOut_effect', 'slide'); ?>
                                        <select name="tml_animateOut_effect"
                                            style="width:200px; height:35px; border:1px solid #ddd; border-radius:4px; padding:0 10px;">
                                            <option value="slide" <?php selected($effect, 'slide'); ?>>Slide</option>
                                            <option value="fade" <?php selected($effect, 'fade'); ?>>Fade</option>
                                            <option value="flip" <?php selected($effect, 'flip'); ?>>Flip</option>
                                            <option value="zoom" <?php selected($effect, 'zoom'); ?>>Zoom</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Direction -->
                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center; border-bottom:none; margin-bottom:0; padding-bottom:0;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Direction', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Slider direction.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div>
                                        <?php $rtl = $get_val('tml_rtl', 'false'); ?>
                                        <div class="tml-mui-toggle-group">
                                            <label
                                                class="tml-mui-toggle-label <?php echo $rtl == 'true' ? 'active' : ''; ?>">
                                                <input type="radio" name="tml_rtl" value="true" <?php checked($rtl, 'true'); ?> style="display:none;">
                                                <?php esc_html_e('Right to Left', 'testimonial-maker'); ?>
                                            </label>
                                            <label
                                                class="tml-mui-toggle-label <?php echo $rtl == 'false' ? 'active' : ''; ?>">
                                                <input type="radio" name="tml_rtl" value="false" <?php checked($rtl, 'false'); ?> style="display:none;">
                                                <?php esc_html_e('Left to Right', 'testimonial-maker'); ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- NAVIGATION PANEL -->
                        <div id="tml-stab-navigation" class="tml-s-content" style="display:none;">
                            <div class="tml-mui-card">
                                <div class="tml-mui-card-title">
                                    <?php esc_html_e('Navigation Settings', 'testimonial-maker'); ?>
                                </div>

                                <!-- Navigation Toggle -->
                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Navigation', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Show/Hide the navigation arrows.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:20px;">
                                        <?php $nav = $get_val('tml_nav', 'true'); ?>
                                        <input type="hidden" name="tml_nav" value="false">
                                        <label class="tml-toggle-label">
                                            <input type="checkbox" name="tml_nav" value="true" <?php checked($nav, 'true'); ?> class="tml-toggle-input">
                                            <span class="tml-toggle-switch"></span>
                                        </label>
                                        <label style="font-weight:500; display:flex; align-items:center; gap:8px;">
                                            <input type="hidden" name="tml_nav_mobile_hide" value="false">
                                            <input type="checkbox" name="tml_nav_mobile_hide" value="true" <?php checked($get_val('tml_nav_mobile_hide', 'false'), 'true'); ?>>
                                            <?php esc_html_e('Hide on Mobile', 'testimonial-maker'); ?>
                                        </label>
                                    </div>
                                </div>

                                <!-- Select Position -->
                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center; border-bottom: none; margin-bottom: 0; padding-bottom: 0;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Select Position', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Select a position for the navigation arrows.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div style="display:flex; flex-direction:column; align-items:flex-end; gap:15px;">
                                        <?php $nav_pos = $get_val('tml_nav_position', 'vertical_outer'); ?>
                                        <select name="tml_nav_position" id="tml_nav_position"
                                            style="width:200px; height:35px; border:1px solid #ddd; border-radius:4px; padding:0 10px;">
                                            <option value="vertical_outer" <?php selected($nav_pos, 'vertical_outer'); ?>>Vertical Outer</option>
                                            <option value="top_right" disabled style="color: #94a3b8;">Top Right (PRO)
                                            </option>
                                            <option value="top_center" disabled style="color: #94a3b8;">Top Center (PRO)
                                            </option>
                                            <option value="top_left" disabled style="color: #94a3b8;">Top Left (PRO)
                                            </option>
                                            <option value="bottom_left" disabled style="color: #94a3b8;">Bottom Left
                                                (PRO)</option>
                                            <option value="bottom_center" disabled style="color: #94a3b8;">Bottom Center
                                                (PRO)</option>
                                            <option value="bottom_right" disabled style="color: #94a3b8;">Bottom Right
                                                (PRO)</option>
                                            <option value="vertical_inner" disabled style="color: #94a3b8;">Vertical
                                                Inner (PRO)</option>
                                            <option value="vertical_center" disabled style="color: #94a3b8;">Vertical
                                                Center (PRO)</option>
                                        </select>
                                        <div id="tml-nav-preview-box"
                                            style="width:200px; border:1px solid #ddd; padding:20px 10px; border-radius:8px; background:#f9f9f9; position:relative;">
                                            <div
                                                style="background:#fff; border:1px solid #eee; height:60px; display:flex; gap:5px; justify-content:center; align-items:center; border-radius:3px; position:relative; overflow:visible;">
                                                <div
                                                    style="width:35px; height:40px; border:1px solid #ddd; border-radius:2px; background:#f5f5f5; display:flex; align-items:center; justify-content:center; font-size:10px;">
                                                    👤</div>
                                                <div
                                                    style="width:35px; height:40px; border:1px solid #ddd; border-radius:2px; background:#f5f5f5; display:flex; align-items:center; justify-content:center; font-size:10px;">
                                                    👤</div>
                                                <div id="tml-nav-preview-arrows"
                                                    style="position:absolute; width:100%; height:100%; pointer-events:none;">
                                                    <span class="prev"
                                                        style="position:absolute; width:14px; height:14px; border:1px solid #666; background:#fff; display:flex; align-items:center; justify-content:center; font-size:8px; border-radius:2px;">&lt;</span>
                                                    <span class="next"
                                                        style="position:absolute; width:14px; height:14px; border:1px solid #666; background:#fff; display:flex; align-items:center; justify-content:center; font-size:8px; border-radius:2px;">&gt;</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Navigation Arrow Style -->
                                <div class="tml-mui-form-group"
                                     style="flex-direction: row; justify-content: space-between; align-items: center; border-top: 1px solid var(--tml-border); border-bottom: none; margin-bottom: 0; padding-bottom: 0; margin-top: 20px; padding-top: 20px;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Arrow Style', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Choose a style for the navigation arrows.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div>
                                        <?php $arrow_style = $get_val('tml_nav_arrow_style', 'chevron'); ?>
                                        <select name="tml_nav_arrow_style" id="tml_nav_arrow_style"
                                            style="width:200px; height:35px; border:1px solid #ddd; border-radius:4px; padding:0 10px;">
                                            <option value="chevron" <?php selected($arrow_style, 'chevron'); ?>><?php esc_html_e('Chevron (Default)', 'testimonial-maker'); ?></option>
                                            <option value="angle_double" <?php selected($arrow_style, 'angle_double'); ?>><?php esc_html_e('Double Chevron', 'testimonial-maker'); ?></option>
                                            <option value="arrow" <?php selected($arrow_style, 'arrow'); ?>><?php esc_html_e('Simple Arrow', 'testimonial-maker'); ?></option>
                                            <option value="long_arrow" <?php selected($arrow_style, 'long_arrow'); ?>><?php esc_html_e('Long Arrow', 'testimonial-maker'); ?></option>
                                            <option value="caret" <?php selected($arrow_style, 'caret'); ?>><?php esc_html_e('Caret (Filled)', 'testimonial-maker'); ?></option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Navigation Size -->
                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center; border-top: 1px solid var(--tml-border); border-bottom: none; margin-bottom: 0; padding-bottom: 0; margin-top: 20px; padding-top: 20px;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Navigation Size', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Set size (height & width) for navigation arrows (default: 35px).', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:15px;">
                                        <?php $nav_size = $get_val('tml_nav_size', '35'); ?>
                                        <input type="range" min="15" max="150" step="1" class="tml-range-slider"
                                            value="<?php echo esc_attr($nav_size); ?>"
                                            oninput="this.nextElementSibling.value = this.value">
                                        <input type="number" name="tml_nav_size"
                                            value="<?php echo esc_attr($nav_size); ?>"
                                            style="width:65px; height:35px; text-align:center; border:1px solid #ddd; border-radius:4px; font-size:13px;">
                                        <span
                                            style="background:#eee; padding:5px 10px; border:1px solid #ddd; border-left:none; border-radius:0 3px 3px 0; margin-left:-16px; height:23px; display:flex; align-items:center; font-size:12px; color:#666;">px</span>
                                    </div>
                                </div>

                                <!-- Navigation Color -->
                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center; border-top: 1px solid var(--tml-border); border-bottom: none; margin-bottom: 0; padding-bottom: 0; margin-top: 20px; padding-top: 20px;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Navigation Colors', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Set arrow colors and backgrounds.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div class="tml-color-pickers-block">
                                        <div class="tml-color-picker-item">
                                            <label
                                                class="tml-color-picker-label"><?php esc_html_e('Color', 'testimonial-maker'); ?></label>
                                            <input type="text" name="tml_nav_color"
                                                value="<?php echo esc_attr($get_val('tml_nav_color', '#ffffff')); ?>"
                                                class="tml-color-field">
                                        </div>
                                        <div class="tml-color-picker-item">
                                            <label
                                                class="tml-color-picker-label"><?php esc_html_e('Background', 'testimonial-maker'); ?></label>
                                            <input type="text" name="tml_nav_bg_color"
                                                value="<?php echo esc_attr($get_val('tml_nav_bg_color', '#1e73be')); ?>"
                                                class="tml-color-field">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- PAGINATION PANEL -->
                        <div id="tml-stab-pagination" class="tml-s-content" style="display:none;">
                            <div class="tml-mui-card">
                                <div class="tml-mui-card-title">
                                    <?php esc_html_e('Pagination Settings', 'testimonial-maker'); ?>
                                </div>

                                <!-- Pagination Toggle -->
                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Pagination', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Show/Hide the pagination dots.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:20px;">
                                        <?php $pag = $get_val('tml_pagination', 'false'); ?>
                                        <input type="hidden" name="tml_pagination" value="false">
                                        <label class="tml-toggle-label">
                                            <input type="checkbox" name="tml_pagination" value="true" <?php checked($pag, 'true'); ?> class="tml-toggle-input">
                                            <span class="tml-toggle-switch"></span>
                                        </label>
                                        <label style="display:flex; align-items:center; gap:8px; font-weight:500;">
                                            <input type="checkbox" name="tml_pagination_mobile_hide" value="true" <?php checked($get_val('tml_pagination_mobile_hide', 'false'), 'true'); ?>>
                                            <?php esc_html_e('Hide on Mobile', 'testimonial-maker'); ?>
                                        </label>
                                    </div>
                                </div>

                                <!-- Pagination Style -->
                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Pagination Style', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Select carousel pagination type.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div>
                                        <div
                                            style="display:flex; gap:15px; flex-wrap:wrap; justify-content:flex-end;">
                                                <!-- Bullets (Free) -->
                                                <label style="text-align:center; cursor:pointer;">
                                                    <div
                                                        style="padding:10px; border:1px solid #2271b1; border-radius:4px; margin-bottom:5px; background:#f0f6fc;">
                                                        <div
                                                            style="width:50px; height:15px; display:flex; gap:3px; align-items:center; justify-content:center;">
                                                            <span
                                                                style="width:6px; height:6px; border-radius:50%; background:#ccc;"></span>
                                                            <span
                                                                style="width:6px; height:6px; border-radius:50%; background:#2271b1;"></span>
                                                            <span
                                                                style="width:6px; height:6px; border-radius:50%; background:#ccc;"></span>
                                                        </div>
                                                    </div>
                                                    <input type="radio" name="tml_pagination_style" value="bullets"
                                                        checked="checked"> Bullets
                                                </label>

                                                <!-- Strokes (PRO) -->
                                                <div
                                                    style="text-align:center; opacity: 0.6; filter: blur(0.8px); pointer-events: none; user-select: none;">
                                                    <div
                                                        style="padding:10px; border:1px solid #ccc; border-radius:4px; margin-bottom:5px; background:#fff;">
                                                        <div
                                                            style="width:50px; height:15px; display:flex; gap:3px; align-items:center; justify-content:center;">
                                                            <span
                                                                style="width:12px; height:2px; background:#ccc;"></span>
                                                            <span
                                                                style="width:12px; height:2px; background:#2271b1;"></span>
                                                        </div>
                                                    </div>
                                                    <span
                                                        style="font-size: 13px; color: #475569; display: flex; align-items: center; justify-content: center; gap: 4px;">
                                                        <i class="fa fa-lock" style="font-size: 10px;"></i>
                                                        Strokes
                                                    </span>
                                                </div>

                                                <!-- Scrollbar (PRO) -->
                                                <div
                                                    style="text-align:center; opacity: 0.6; filter: blur(0.8px); pointer-events: none; user-select: none;">
                                                    <div
                                                        style="padding:10px; border:1px solid #ccc; border-radius:4px; margin-bottom:5px; background:#fff;">
                                                        <div
                                                            style="width:50px; height:15px; display:flex; align-items:center; justify-content:center;">
                                                            <div
                                                                style="width:50px; height:4px; background:#eee; border-radius:2px; position:relative;">
                                                                <div
                                                                    style="position:absolute; left:10px; width:15px; height:4px; background:#2271b1; border-radius:2px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span
                                                        style="font-size: 13px; color: #475569; display: flex; align-items: center; justify-content: center; gap: 4px;">
                                                        <i class="fa fa-lock" style="font-size: 10px;"></i>
                                                        Scrollbar
                                                    </span>
                                                </div>

                                                <!-- Fraction (PRO) -->
                                                <div
                                                    style="text-align:center; opacity: 0.6; filter: blur(0.8px); pointer-events: none; user-select: none;">
                                                    <div
                                                        style="padding:10px; border:1px solid #ccc; border-radius:4px; margin-bottom:5px; background:#fff;">
                                                        <div
                                                            style="width:50px; height:15px; display:flex; align-items:center; justify-content:center; font-size:10px; color:#666;">
                                                            1 / 5
                                                        </div>
                                                    </div>
                                                    <span
                                                        style="font-size: 13px; color: #475569; display: flex; align-items: center; justify-content: center; gap: 4px;">
                                                        <i class="fa fa-lock" style="font-size: 10px;"></i>
                                                        Fraction
                                                    </span>
                                                </div>

                                                <!-- Numbers (PRO) -->
                                                <div
                                                    style="text-align:center; opacity: 0.6; filter: blur(0.8px); pointer-events: none; user-select: none;">
                                                    <div
                                                        style="padding:10px; border:1px solid #ccc; border-radius:4px; margin-bottom:5px; background:#fff;">
                                                        <div
                                                            style="width:50px; height:15px; display:flex; gap:2px; align-items:center; justify-content:center; font-size:9px;">
                                                            <span
                                                                style="width:10px; height:10px; border:1px solid #ccc; border-radius:50%; display:flex; align-items:center; justify-content:center;">1</span>
                                                            <span
                                                                style="width:10px; height:10px; border:1px solid #2271b1; border-radius:50%; background:#2271b1; color:#fff; display:flex; align-items:center; justify-content:center;">2</span>
                                                        </div>
                                                    </div>
                                                    <span
                                                        style="font-size: 13px; color: #475569; display: flex; align-items: center; justify-content: center; gap: 4px;">
                                                        <i class="fa fa-lock" style="font-size: 10px;"></i>
                                                        Numbers
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>

                        <!-- MISCELLANEOUS PANEL -->
                        <div id="tml-stab-misc" class="tml-s-content" style="display:none;">
                            <div class="tml-mui-card">
                                <div class="tml-mui-card-title">
                                    <?php esc_html_e('Miscellaneous Settings', 'testimonial-maker'); ?>
                                </div>

                                <!-- Adaptive Height -->
                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Adaptive Slider Height', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e("Dynamically adjust slider height based on each slide's height.", 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div>
                                        <?php $ah = $get_val('tml_auto_hight', 'false'); ?>
                                        <input type="hidden" name="tml_auto_hight" value="false">
                                        <label class="tml-toggle-label">
                                            <input type="checkbox" name="tml_auto_hight" value="true" <?php checked($ah, 'true'); ?> class="tml-toggle-input">
                                            <span class="tml-toggle-switch"></span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Mouse Draggable -->
                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Mouse Draggable', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Enable/Disable mouse draggable mode.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div>
                                        <?php $md = $get_val('tml_mouse_draggable', 'true'); ?>
                                        <input type="hidden" name="tml_mouse_draggable" value="false">
                                        <label class="tml-toggle-label">
                                            <input type="checkbox" name="tml_mouse_draggable" value="true" <?php checked($md, 'true'); ?> class="tml-toggle-input">
                                            <span class="tml-toggle-switch"></span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Mouse Wheel -->
                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center; border-bottom:none; margin-bottom:0; padding-bottom:0;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Mouse Wheel', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Enable/Disable mouse wheel control.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div>
                                        <?php $mw = $get_val('tml_mouse_control', 'false'); ?>
                                        <input type="hidden" name="tml_mouse_control" value="false">
                                        <label class="tml-toggle-label">
                                            <input type="checkbox" name="tml_mouse_control" value="true" <?php checked($mw, 'true'); ?> class="tml-toggle-input">
                                            <span class="tml-toggle-switch"></span>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- TYPOGRAPHY TAB -->
            <div id="tml-tab-style" class="tml-tab-content">
                <div
                    style="background: #fff5f5; border: 1px solid #feb2b2; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; gap: 15px;">
                    <span style="font-size: 13px; color: #c53030; font-weight: 500;">
                        🔒 <strong>Advanced Typography Customization</strong> is a Premium Feature.
                    </span>
                    <a href="https://awplife.com/demo/testimonial-premium/" target="_blank"
                        style="color: #fff; background: #d63638; border: none; padding: 6px 12px; font-size: 12px; font-weight: bold; border-radius: 4px; text-decoration: none; display: inline-block; transition: background 0.2s;"><?php esc_html_e('Get PRO Version ★', 'testimonial-maker'); ?></a>
                </div>
                <div
                    style="background:#fff; padding:25px; border:1px solid #e5e5e5; border-radius:4px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">

                    <?php
                    tml_render_typography_section_pro('Testimonial Title Font', 'Customize the individual testimonial titles or taglines.');
                    tml_render_typography_section_pro('Testimonial Content Font', 'Adjust the main body text of the testimonials.');
                    tml_render_typography_section_pro('Designation & Company Font', 'Set typography for designations and company names.');
                    tml_render_typography_section_pro('Website Font', 'Style the website URLs or links.');
                    tml_render_typography_section_pro('AJAX Filters Font', 'Style the category and rating filters (fonts, sizes, colors).');
                    ?>

                </div>
            </div>

            <!-- PAGINATION TAB -->
            <div id="tml-tab-pagination" class="tml-tab-content">
                <div
                    style="background: #fff5f5; border: 1px solid #feb2b2; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; gap: 15px;">
                    <span style="font-size: 13px; color: #c53030; font-weight: 500;">
                        🔒 <strong>Ajax Pagination & Infinite Scroll</strong> is a Premium Feature.
                    </span>
                    <a href="https://awplife.com/demo/testimonial-premium/" target="_blank"
                        style="color: #fff; background: #d63638; border: none; padding: 6px 12px; font-size: 12px; font-weight: bold; border-radius: 4px; text-decoration: none; display: inline-block; transition: background 0.2s;"><?php esc_html_e('Get PRO Version ★', 'testimonial-maker'); ?></a>
                </div>
                <div class="tml-mui-card"
                    style="opacity: 0.6; filter: blur(0.6px); pointer-events: none; user-select: none;">
                    <div class="tml-mui-card-title">
                        <i class="fa fa-arrow-circle-o-down" style="color:var(--tml-primary);"></i>
                        <?php esc_html_e('Ajax & Page Pagination Settings', 'testimonial-maker'); ?>
                    </div>

                    <!-- Pagination Toggle -->
                    <div class="tml-mui-form-group"
                        style="flex-direction: row; justify-content: space-between; align-items: center;">
                        <div>
                            <label class="tml-mui-label"
                                style="margin-bottom:0;"><?php esc_html_e('Pagination status', 'testimonial-maker'); ?></label>
                            <div class="tml-mui-description">
                                <?php esc_html_e('Enable/Disable pagination display for this testimonial block.', 'testimonial-maker'); ?>
                            </div>
                        </div>
                        <div>
                            <label class="tml-toggle-label" style="opacity: 0.6; cursor: not-allowed;">
                                <input type="checkbox" class="tml-toggle-input" disabled>
                                <span class="tml-toggle-switch"></span>
                            </label>
                        </div>
                    </div>

                    <!-- Pagination Type (Grid Selectors) -->
                    <div class="tml-mui-form-group"
                        style="flex-direction: column; align-items: flex-start; gap: 12px; border-bottom: 1px solid var(--tml-border); padding-bottom: 24px;">
                        <div>
                            <label class="tml-mui-label"
                                style="margin-bottom:0;"><?php esc_html_e('Pagination Type', 'testimonial-maker'); ?></label>
                            <div class="tml-mui-description">
                                <?php esc_html_e('Choose how you want your testimonials to be segmented and loaded.', 'testimonial-maker'); ?>
                            </div>
                        </div>
                        <div class="tml-pagi-type-grid"
                            style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; width: 100%; margin-top: 10px;">

                            <!-- Ajax Load More -->
                            <label class="tml-pagi-type-card tml-pro-locked"
                                style="opacity: 0.6; cursor: not-allowed; position: relative;">
                                <input type="radio" disabled checked style="display:none;">
                                <i class="fa fa-hand-o-up"
                                    style="font-size: 1.75rem; color: rgba(0,0,0,0.38); margin-bottom: 10px; display: block; transition: all 0.2s ease;"></i>
                                <span style="font-size: 0.8rem; font-weight: 500; display: block;">
                                    <?php esc_html_e('Load More Button', 'testimonial-maker'); ?>
                                    <span class="pro-badge"
                                        style="font-size: 8px; background: #d63638; color: #fff; padding: 1px 3px; border-radius: 2px; margin-left: 2px; font-weight: bold; vertical-align: middle;"><?php esc_html_e('PRO', 'testimonial-maker'); ?></span>
                                </span>
                            </label>

                            <!-- Ajax Number -->
                            <label class="tml-pagi-type-card tml-pro-locked"
                                style="opacity: 0.6; cursor: not-allowed; position: relative;">
                                <input type="radio" disabled style="display:none;">
                                <i class="fa fa-list-ol"
                                    style="font-size: 1.75rem; color: rgba(0,0,0,0.38); margin-bottom: 10px; display: block; transition: all 0.2s ease;"></i>
                                <span style="font-size: 0.8rem; font-weight: 500; display: block;">
                                    <?php esc_html_e('Ajax Numbers', 'testimonial-maker'); ?>
                                    <span class="pro-badge"
                                        style="font-size: 8px; background: #d63638; color: #fff; padding: 1px 3px; border-radius: 2px; margin-left: 2px; font-weight: bold; vertical-align: middle;"><?php esc_html_e('PRO', 'testimonial-maker'); ?></span>
                                </span>
                            </label>

                            <!-- Ajax Infinite Scroll -->
                            <label class="tml-pagi-type-card tml-pro-locked"
                                style="opacity: 0.6; cursor: not-allowed; position: relative;">
                                <input type="radio" disabled style="display:none;">
                                <i class="fa fa-refresh"
                                    style="font-size: 1.75rem; color: rgba(0,0,0,0.38); margin-bottom: 10px; display: block; transition: all 0.2s ease;"></i>
                                <span style="font-size: 0.8rem; font-weight: 500; display: block;">
                                    <?php esc_html_e('Infinite Scroll', 'testimonial-maker'); ?>
                                    <span class="pro-badge"
                                        style="font-size: 8px; background: #d63638; color: #fff; padding: 1px 3px; border-radius: 2px; margin-left: 2px; font-weight: bold; vertical-align: middle;"><?php esc_html_e('PRO', 'testimonial-maker'); ?></span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Testimonials Per Page -->
                    <div class="tml-mui-form-group"
                        style="flex-direction: row; justify-content: space-between; align-items: center;">
                        <div>
                            <label class="tml-mui-label"
                                style="margin-bottom:0;"><?php esc_html_e('Testimonials to Show Per Page', 'testimonial-maker'); ?></label>
                            <div class="tml-mui-description">
                                <?php esc_html_e('Set the limit of testimonials loaded per page/view.', 'testimonial-maker'); ?>
                            </div>
                        </div>
                        <div>
                            <input type="number" class="tml-mui-input" value="6"
                                style="width:80px; text-align: center; font-weight: 600;" disabled>
                        </div>
                    </div>

                    <!-- Alignment -->
                    <div class="tml-mui-form-group"
                        style="flex-direction: row; justify-content: space-between; align-items: center;">
                        <div>
                            <label class="tml-mui-label"
                                style="margin-bottom:0;"><?php esc_html_e('Alignment', 'testimonial-maker'); ?></label>
                            <div class="tml-mui-description">
                                <?php esc_html_e('Choose position alignment for the pagination buttons.', 'testimonial-maker'); ?>
                            </div>
                        </div>
                        <div>
                            <div class="tml-mui-toggle-group" style="opacity: 0.6; pointer-events: none;">
                                <label class="tml-mui-toggle-label">
                                    <input type="radio" disabled style="display:none;">
                                    <i class="fa fa-align-left"></i>
                                </label>
                                <label class="tml-mui-toggle-label">
                                    <input type="radio" checked disabled style="display:none;">
                                    <i class="fa fa-align-center"></i>
                                </label>
                                <label class="tml-mui-toggle-label">
                                    <input type="radio" disabled style="display:none;">
                                    <i class="fa fa-align-right"></i>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Margin (Spacing) Customizer -->
                    <div class="tml-mui-form-group"
                        style="flex-direction: column; align-items: flex-start; gap: 12px; border-bottom: 1px solid var(--tml-border); padding-bottom: 24px;">
                        <div>
                            <label class="tml-mui-label"
                                style="margin-bottom:0;"><?php esc_html_e('Margin (Spacing)', 'testimonial-maker'); ?></label>
                            <div class="tml-mui-description">
                                <?php esc_html_e('Adjust spatial distance around the pagination container (in px).', 'testimonial-maker'); ?>
                            </div>
                        </div>
                        <div class="tml-responsive-grid"
                            style="width: 100%; grid-template-columns: repeat(4, 1fr) !important; max-width: 440px; margin-top: 5px;">
                            <div class="tml-responsive-column-item" style="padding: 10px 5px !important; opacity: 0.6;">
                                <label
                                    style="margin-bottom: 6px !important; font-size: 0.7rem !important;"><?php esc_html_e('Top', 'testimonial-maker'); ?></label>
                                <input type="number" class="tml-mui-input" value="20" style="width: 70px !important;"
                                    disabled>
                            </div>
                            <div class="tml-responsive-column-item" style="padding: 10px 5px !important; opacity: 0.6;">
                                <label
                                    style="margin-bottom: 6px !important; font-size: 0.7rem !important;"><?php esc_html_e('Right', 'testimonial-maker'); ?></label>
                                <input type="number" class="tml-mui-input" value="0" style="width: 70px !important;"
                                    disabled>
                            </div>
                            <div class="tml-responsive-column-item" style="padding: 10px 5px !important; opacity: 0.6;">
                                <label
                                    style="margin-bottom: 6px !important; font-size: 0.7rem !important;"><?php esc_html_e('Bottom', 'testimonial-maker'); ?></label>
                                <input type="number" class="tml-mui-input" value="20" style="width: 70px !important;"
                                    disabled>
                            </div>
                            <div class="tml-responsive-column-item" style="padding: 10px 5px !important; opacity: 0.6;">
                                <label
                                    style="margin-bottom: 6px !important; font-size: 0.7rem !important;"><?php esc_html_e('Left', 'testimonial-maker'); ?></label>
                                <input type="number" class="tml-mui-input" value="0" style="width: 70px !important;"
                                    disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination Color (2x2 Spaced Grid) -->
                    <div class="tml-mui-form-group"
                        style="flex-direction: row; justify-content: space-between; align-items: center; border-top: 1px solid var(--tml-border); border-bottom: none; margin-bottom: 0; padding-bottom: 0; margin-top: 20px; padding-top: 20px;">
                        <div>
                            <label class="tml-mui-label"
                                style="margin-bottom:0;"><?php esc_html_e('Pagination Colors', 'testimonial-maker'); ?></label>
                            <div class="tml-mui-description">
                                <?php esc_html_e('Set colors and hover states for pagination button elements.', 'testimonial-maker'); ?>
                            </div>
                        </div>
                        <div class="tml-color-pickers-block" style="opacity: 0.6; pointer-events: none;">
                            <div class="tml-color-picker-item">
                                <label
                                    class="tml-color-picker-label"><?php esc_html_e('Color', 'testimonial-maker'); ?></label>
                                <input type="text" class="tml-color-field" value="#333333" disabled>
                            </div>
                            <div class="tml-color-picker-item">
                                <label
                                    class="tml-color-picker-label"><?php esc_html_e('Background', 'testimonial-maker'); ?></label>
                                <input type="text" class="tml-color-field" value="#ffffff" disabled>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- DISPLAY SETTINGS TAB -->
            <div id="tml-tab-display" class="tml-tab-content" style="padding:0; border:none; box-shadow:none;">
                <div class="tml-mui-container" style="background:#fff; min-height:500px; padding:0; gap:0;">
                    <!-- Vertical Tabs -->
                    <div class="tml-mui-sidebar"
                        style="width:240px; border-right:1px solid var(--tml-border); padding: 16px 0; background: rgba(0, 0, 0, 0.02); flex-shrink: 0;">
                        <a href="#" class="tml-mui-nav-item tml-v-tab active" data-vtab="basic">
                            <i class="fa fa-cogs"></i> <?php esc_html_e('Basic Preferences', 'testimonial-maker'); ?>
                        </a>
                        <a href="#" class="tml-mui-nav-item tml-v-tab" data-vtab="content">
                            <i class="fa fa-file-text-o"></i>
                            <?php esc_html_e('Testimonial Content', 'testimonial-maker'); ?>
                        </a>
                        <a href="#" class="tml-mui-nav-item tml-v-tab" data-vtab="reviewer">
                            <i class="fa fa-user"></i>
                            <?php esc_html_e('Reviewer Information', 'testimonial-maker'); ?>
                        </a>
                        <a href="#" class="tml-mui-nav-item tml-v-tab" data-vtab="star">
                            <i class="fa fa-star-o"></i> <?php esc_html_e('Star Rating', 'testimonial-maker'); ?>
                        </a>
                        <a href="#" class="tml-mui-nav-item tml-v-tab" data-vtab="image">
                            <i class="fa fa-picture-o"></i>
                            <?php esc_html_e('Reviewer Image', 'testimonial-maker'); ?>
                        </a>
                        <a href="#" class="tml-mui-nav-item tml-v-tab" data-vtab="video">
                            <i class="fa fa-video-camera"></i>
                            <?php esc_html_e('Video Testimonial', 'testimonial-maker'); ?>
                            <span
                                style="background: #cbd5e1; color: #ffffff; padding: 2px 5px; border-radius: 3px; font-family: sans-serif; font-size: 8px; font-weight: bold; line-height: 1; margin-left: 6px; display: inline-block; vertical-align: middle;">PRO</span>
                        </a>
                        <a href="#" class="tml-mui-nav-item tml-v-tab" data-vtab="social">
                            <i class="fa fa-share-alt"></i>
                            <?php esc_html_e('Social Media', 'testimonial-maker'); ?>
                            <span
                                style="background: #cbd5e1; color: #ffffff; padding: 2px 5px; border-radius: 3px; font-family: sans-serif; font-size: 8px; font-weight: bold; line-height: 1; margin-left: 6px; display: inline-block; vertical-align: middle;">PRO</span>
                        </a>

                    </div>

                    <!-- Vertical Content -->
                    <div class="tml-mui-content" style="flex:grow; padding:24px; box-sizing: border-box;">
                        <!-- BASIC PREFERENCES -->
                        <div id="tml-vtab-basic" class="tml-v-content active">
                            <div class="tml-mui-card">
                                <div class="tml-mui-card-title">
                                    <?php esc_html_e('Basic Preferences', 'testimonial-maker'); ?>
                                </div>

                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Section Title', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Show/Hide the testimonial section title.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <?php $ds_sec_title = $get_val('tml_ds_section_title', 'hide'); ?>
                                    <label class="tml-mui-switch">
                                        <input type="hidden" name="tml_ds_section_title" value="hide">
                                        <input type="checkbox" name="tml_ds_section_title" value="show" <?php checked($ds_sec_title, 'show'); ?>>
                                        <span class="tml-mui-slider"></span>
                                    </label>
                                </div>

                                <div id="tml-section-title-suboptions"
                                    style="margin-left: 20px; border-left: 3px solid #6200ee; padding-left: 20px; margin-top: -10px; margin-bottom: 25px; display: <?php echo ($ds_sec_title === 'show') ? 'block' : 'none'; ?>; transition: all 0.3s ease;">
                                    <div class="tml-mui-form-group" style="margin-bottom: 0;">
                                        <label class="tml-mui-label"
                                            style="font-weight: 600; font-size: 13px; color: #444;"><?php esc_html_e('Section Title Text', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description" style="margin-bottom: 8px;">
                                            <?php esc_html_e('Enter the title text to show above the testimonial section.', 'testimonial-maker'); ?>
                                        </div>
                                        <input type="text" name="tml_ds_section_title_text" class="tml-mui-input"
                                            value="<?php echo esc_attr($get_val('tml_ds_section_title_text', 'Testimonials')); ?>"
                                            style="max-width: 400px; width: 100%;">
                                    </div>
                                </div>
                                <script>
                                    jQuery(document).ready(function ($) {
                                        $('input[name="tml_ds_section_title"]').on('change', function () {
                                            if ($(this).is(':checked')) {
                                                $('#tml-section-title-suboptions').slideDown(250);
                                            } else {
                                                $('#tml-section-title-suboptions').slideUp(250);
                                            }
                                        });
                                    });
                                </script>



                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Preloader', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Enable/Disable preloader.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <?php $ds_preloader = $get_val('tml_ds_preloader', 'disabled'); ?>
                                    <label class="tml-mui-switch">
                                        <input type="hidden" name="tml_ds_preloader" value="disabled">
                                        <input type="checkbox" name="tml_ds_preloader" value="enabled" <?php checked($ds_preloader, 'enabled'); ?>>
                                        <span class="tml-mui-slider"></span>
                                    </label>
                                </div>

                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Average Rating', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Show/Hide average rating.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <?php $ds_avg_rating = $get_val('tml_ds_avg_rating', 'hide'); ?>
                                    <label class="tml-mui-switch">
                                        <input type="hidden" name="tml_ds_avg_rating" value="hide">
                                        <input type="checkbox" name="tml_ds_avg_rating" value="show" <?php checked($ds_avg_rating, 'show'); ?>>
                                        <span class="tml-mui-slider"></span>
                                    </label>
                                </div>

                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Ajax Testimonial Search', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Enable/Disable ajax search for testimonial.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <?php $ds_ajax_search = $get_val('tml_ds_ajax_search', 'disabled'); ?>
                                    <label class="tml-mui-switch">
                                        <input type="hidden" name="tml_ds_ajax_search" value="disabled">
                                        <input type="checkbox" name="tml_ds_ajax_search" value="enabled" <?php checked($ds_ajax_search, 'enabled'); ?>>
                                        <span class="tml-mui-slider"></span>
                                    </label>
                                </div>

                                <div id="tml-search-suboptions"
                                    style="margin-left: 20px; border-left: 3px solid #6200ee; padding-left: 20px; margin-top: -10px; margin-bottom: 25px; display: <?php echo ($ds_ajax_search === 'enabled') ? 'block' : 'none'; ?>; transition: all 0.3s ease;">
                                    <!-- Search Width -->
                                    <div class="tml-mui-form-group" style="margin-bottom: 20px;">
                                        <label class="tml-mui-label"
                                            style="font-weight: 600; font-size: 13px; color: #444;"><?php esc_html_e('Search Box Width', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description" style="margin-bottom: 8px;">
                                            <?php esc_html_e('Choose whether the search input spans full width or is centered in a container.', 'testimonial-maker'); ?>
                                        </div>
                                        <select name="tml_ds_ajax_search_width" class="tml-mui-input"
                                            style="max-width: 250px;">
                                            <option value="container" <?php selected($get_val('tml_ds_ajax_search_width', 'container'), 'container'); ?>>Container (Centered, 600px)</option>
                                            <option value="full" <?php selected($get_val('tml_ds_ajax_search_width', 'container'), 'full'); ?>>Full Width (100%)</option>
                                        </select>
                                    </div>

                                    <!-- Search Shape -->
                                    <div class="tml-mui-form-group" style="margin-bottom: 0;">
                                        <label class="tml-mui-label"
                                            style="font-weight: 600; font-size: 13px; color: #444;"><?php esc_html_e('Search Box Shape', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description" style="margin-bottom: 8px;">
                                            <?php esc_html_e('Select the geometric style for your search bar input.', 'testimonial-maker'); ?>
                                        </div>
                                        <select name="tml_ds_ajax_search_shape" class="tml-mui-input"
                                            style="max-width: 250px;">
                                            <option value="round" <?php selected($get_val('tml_ds_ajax_search_shape', 'round'), 'round'); ?>>Round (Soft Pill Shape)</option>
                                            <option value="square" <?php selected($get_val('tml_ds_ajax_search_shape', 'round'), 'square'); ?>>Square (Clean Modern Rectangle)</option>
                                        </select>
                                    </div>
                                </div>
                                <script>
                                    jQuery(document).ready(function ($) {
                                        $('input[name="tml_ds_ajax_search"]').on('change', function () {
                                            if ($(this).is(':checked')) {
                                                $('#tml-search-suboptions').slideDown(250);
                                            } else {
                                                $('#tml-search-suboptions').slideUp(250);
                                            }
                                        });
                                    });
                                </script>

                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Card Box Shadow', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Show/Hide box shadow on testimonial cards.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <?php $ds_card_shadow = $get_val('tml_ds_card_shadow', 'show'); ?>
                                    <label class="tml-mui-switch">
                                        <input type="hidden" name="tml_ds_card_shadow" value="hide">
                                        <input type="checkbox" name="tml_ds_card_shadow" value="show" <?php checked($ds_card_shadow, 'show'); ?>>
                                        <span class="tml-mui-slider"></span>
                                    </label>
                                </div>

                                <!-- Background Color -->
                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center; border-bottom:none; margin-bottom:0; padding-bottom:0;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Background Color', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Set testimonial item background color.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div>
                                        <input type="text" class="tml-color-picker" name="tml_background_color"
                                            value="<?php echo esc_attr($get_val('tml_background_color', '#ffffff')); ?>">
                                    </div>
                                </div>

                            </div>
                        </div>


                        <!-- TESTIMONIAL CONTENT -->
                        <div id="tml-vtab-content" class="tml-v-content" style="display:none;">
                            <div class="tml-mui-card">
                                <div class="tml-mui-card-title">
                                    <?php esc_html_e('Testimonial Content Settings', 'testimonial-maker'); ?>
                                </div>

                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Testimonial Content', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Show or hide testimonial content text.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <?php $ds_content_show = $get_val('tml_ds_content_show', 'show'); ?>
                                    <label class="tml-mui-switch">
                                        <input type="hidden" name="tml_ds_content_show" value="hide">
                                        <input type="checkbox" name="tml_ds_content_show" value="show" <?php checked($ds_content_show, 'show'); ?>>
                                        <span class="tml-mui-slider"></span>
                                    </label>
                                </div>

                                <div class="tml-mui-form-group">
                                    <label
                                        class="tml-mui-label"><?php esc_html_e('Content Display Type', 'testimonial-maker'); ?></label>
                                    <div class="tml-mui-description" style="margin-bottom: 8px;">
                                        <?php esc_html_e('Choose how the content is displayed.', 'testimonial-maker'); ?>
                                    </div>
                                    <?php $content_type = $get_val('tml_ds_content_type', 'full'); ?>
                                    <div class="tml-mui-toggle-group">
                                        <label
                                            class="tml-mui-toggle-label <?php echo $content_type == 'full' ? 'active' : ''; ?>">
                                            <input type="radio" name="tml_ds_content_type" value="full" <?php checked($content_type, 'full'); ?> style="display:none;"> Full
                                        </label>
                                        <label
                                            class="tml-mui-toggle-label <?php echo $content_type == 'limit' ? 'active' : ''; ?>">
                                            <input type="radio" name="tml_ds_content_type" value="limit" <?php checked($content_type, 'limit'); ?> style="display:none;"> Limit
                                        </label>
                                    </div>
                                </div>

                                <div class="tml-mui-form-group">
                                    <label
                                        class="tml-mui-label"><?php esc_html_e('Length', 'testimonial-maker'); ?></label>
                                    <div class="tml-mui-description" style="margin-bottom: 8px;">
                                        <?php esc_html_e('Set the maximum length of the testimonial content.', 'testimonial-maker'); ?>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 16px;">
                                        <input type="number" name="tml_ds_content_length"
                                            value="<?php echo esc_attr($get_val('tml_ds_content_length', '50')); ?>"
                                            class="tml-mui-input" style="width: 100px;">
                                        <?php $length_type = $get_val('tml_ds_content_length_type', 'words'); ?>
                                        <div class="tml-mui-toggle-group">
                                            <label
                                                class="tml-mui-toggle-label <?php echo $length_type == 'words' ? 'active' : ''; ?>">
                                                <input type="radio" name="tml_ds_content_length_type" value="words"
                                                    <?php checked($length_type, 'words'); ?> style="display:none;">
                                                Words
                                            </label>
                                            <label
                                                class="tml-mui-toggle-label <?php echo $length_type == 'chars' ? 'active' : ''; ?>">
                                                <input type="radio" name="tml_ds_content_length_type" value="chars"
                                                    <?php checked($length_type, 'chars'); ?> style="display:none;">
                                                Characters
                                            </label>
                                        </div>
                                    </div>
                                </div>


                                <div class="tml-mui-form-group"
                                    style="display: flex !important; flex-direction: row !important; justify-content: space-between; align-items: center; margin-top: 24px !important; margin-bottom: 24px !important;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0; font-size: 0.875rem; color: #475569; font-weight: 500;"><?php esc_html_e('Read More', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description"
                                            style="margin-top: 4px; font-size: 0.75rem; color: #94a3b8; font-style: italic;">
                                            <?php esc_html_e('Show/Hide testimonial read more button.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div
                                        style="display: inline-flex; align-items: center; background: #b0c4de; border-radius: 4px; padding: 4px 8px; font-family: sans-serif; font-size: 11px; font-weight: bold; color: #ffffff; line-height: 1;">
                                        SHOW
                                        <span
                                            style="border: 1px solid #ffffff; color: #ffffff; padding: 1px 4px; border-radius: 3px; margin-left: 6px; font-size: 8px; font-weight: bold; line-height: 1;">PRO</span>
                                    </div>
                                </div>

                                <div class="tml-mui-form-group"
                                    style="display: flex !important; flex-direction: row !important; justify-content: space-between; align-items: center; margin-top: 24px !important; margin-bottom: 24px !important;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom: 0; font-size: 0.875rem; color: #475569; font-weight: 500;"><?php esc_html_e('Read More Action Type', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description"
                                            style="margin-top: 4px; font-size: 0.75rem; color: #94a3b8; font-style: italic;">
                                            <?php esc_html_e('Select read more link action type.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div class="tml-mui-toggle-group"
                                        style="opacity: 0.85; pointer-events: none; user-select: none; display: inline-flex; align-items: center; border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden; padding: 0;">
                                        <span class="tml-mui-toggle-label active"
                                            style="margin: 0; background-color: #7fb4f5 !important; border: none !important; color: #ffffff !important; padding: 8px 16px; font-size: 13px; font-weight: 500; border-radius: 0;">Expand</span>
                                        <span class="tml-mui-toggle-label"
                                            style="margin: 0; background-color: #ffffff !important; border: none !important; color: #94a3b8 !important; padding: 8px 16px; font-size: 13px; font-weight: 500; border-radius: 0;">Popup</span>
                                    </div>
                                </div>

                                <div
                                    style="color: #475569; font-size: 0.875rem; margin-top: 28px; padding-top: 16px; border-top: 1px solid rgba(0,0,0,0.06); font-family: sans-serif;">
                                    <?php esc_html_e('Looking to make your customer Testimonial Content more captivating with advanced customization options?', 'testimonial-maker'); ?>
                                    <a href="https://awplife.com/demo/testimonial-premium/" target="_blank"
                                        style="color: #2563eb; text-decoration: none; font-weight: 500;"><?php esc_html_e('Upgrade to Pro!', 'testimonial-maker'); ?></a>
                                </div>
                            </div>
                        </div>

                        <!-- REVIEWER INFO -->
                        <div id="tml-vtab-reviewer" class="tml-v-content" style="display:none;">
                            <div class="tml-mui-card">
                                <div class="tml-mui-card-title">
                                    <?php esc_html_e('Reviewer Info Settings', 'testimonial-maker'); ?>
                                </div>

                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Full Name', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Show or hide the reviewer full name.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <?php $ds_name_show = $get_val('tml_ds_name_show', 'show'); ?>
                                    <label class="tml-mui-switch">
                                        <input type="hidden" name="tml_ds_name_show" value="hide">
                                        <input type="checkbox" name="tml_ds_name_show" value="show" <?php checked($ds_name_show, 'show'); ?>>
                                        <span class="tml-mui-slider"></span>
                                    </label>
                                </div>

                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Designation', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Show or hide the reviewer identity or position.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <?php $ds_desig_show = $get_val('tml_ds_designation_show', 'show'); ?>
                                    <label class="tml-mui-switch">
                                        <input type="hidden" name="tml_ds_designation_show" value="hide">
                                        <input type="checkbox" name="tml_ds_designation_show" value="show" <?php checked($ds_desig_show, 'show'); ?>>
                                        <span class="tml-mui-slider"></span>
                                    </label>
                                </div>

                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center; margin-top: 20px; border-top: 1px solid rgba(0,0,0,0.06); padding-top: 20px;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Website Link', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Show or hide the reviewer website link.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <?php $ds_website_show = $get_val('tml_ds_website_show', 'show'); ?>
                                    <label class="tml-mui-switch">
                                        <input type="hidden" name="tml_ds_website_show" value="hide">
                                        <input type="checkbox" name="tml_ds_website_show" value="show" <?php checked($ds_website_show, 'show'); ?>>
                                        <span class="tml-mui-slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- STAR RATING -->
                        <div id="tml-vtab-star" class="tml-v-content" style="display:none;">
                            <div class="tml-mui-card">
                                <div class="tml-mui-card-title">
                                    <?php esc_html_e('Star Rating Settings', 'testimonial-maker'); ?>
                                </div>

                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Star Rating', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Show or hide the rating.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <?php $show_star = $get_val('tml_show_star_rating', 'true'); ?>
                                    <label class="tml-mui-switch">
                                        <input type="hidden" name="tml_show_star_rating" value="false">
                                        <input type="checkbox" name="tml_show_star_rating" value="true" <?php checked($show_star, 'true'); ?>>
                                        <span class="tml-mui-slider"></span>
                                    </label>
                                </div>

                                <div class="tml-mui-form-group">
                                    <label
                                        class="tml-mui-label"><?php esc_html_e('Rating Icon Style', 'testimonial-maker'); ?></label>
                                    <div class="tml-mui-description" style="margin-bottom: 8px;">
                                        <?php esc_html_e('Choose a star rating icon style.', 'testimonial-maker'); ?>
                                    </div>
                                    <?php
                                    $active_rating_color = $get_val('tml_star_rating_color', '#FFD700');
                                    $rating_icons = array(
                                        'star' => '<i class="fa fa-star" style="color:' . esc_attr($active_rating_color) . ';"></i>',
                                        'heart' => '<i class="fa fa-heart" style="color:' . esc_attr($active_rating_color) . ';"></i>',
                                        'thumbs-up' => '<i class="fa fa-thumbs-up" style="color:' . esc_attr($active_rating_color) . ';"></i>',
                                        'smile' => '<i class="fa fa-smile-o" style="color:' . esc_attr($active_rating_color) . ';"></i>',
                                        'diamond' => '<i class="fa fa-diamond" style="color:' . esc_attr($active_rating_color) . ';"></i>',
                                        'badge' => '<i class="fa fa-certificate" style="color:' . esc_attr($active_rating_color) . ';"></i>',
                                        'trophy' => '<i class="fa fa-trophy" style="color:' . esc_attr($active_rating_color) . ';"></i>',
                                        'bell' => '<i class="fa fa-bell" style="color:' . esc_attr($active_rating_color) . ';"></i>'
                                    );
                                    $current_icon = $get_val('tml_rating_style', 'star');
                                    ?>
                                    <div style="display:flex; flex-wrap:wrap; gap:10px;">
                                        <?php foreach ($rating_icons as $val => $icon_html) { ?>
                                            <?php if ($val === 'star') { ?>
                                                <label class="tml-mui-icon-radio active"
                                                    style="width: 50px; height: 50px; padding: 0; border-color: #60a5fa !important;">
                                                    <input type="radio" name="tml_rating_style" value="star" checked
                                                        style="display:none;">
                                                    <span
                                                        style="font-size:22px; display:flex; align-items:center; justify-content:center;">
                                                        <?php echo wp_kses($icon_html, array('i' => array('class' => true, 'style' => true))); ?>
                                                    </span>
                                                </label>
                                            <?php } else { ?>
                                                <label class="tml-mui-icon-radio"
                                                    style="width: 50px; height: 50px; padding: 0; filter: blur(1.5px); opacity: 0.5; pointer-events: none; cursor: not-allowed; user-select: none;">
                                                    <span
                                                        style="font-size:22px; display:flex; align-items:center; justify-content:center;">
                                                        <?php echo wp_kses($icon_html, array('i' => array('class' => true, 'style' => true))); ?>
                                                    </span>
                                                </label>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                    <div
                                        style="color: #475569; font-size: 0.75rem; margin-top: 10px; font-family: sans-serif;">
                                        <?php esc_html_e('Heart, Thumbs-up, Smiley, Diamond, Sun, Trophy, and Bell icon styles are only available in the Pro version.', 'testimonial-maker'); ?>
                                        <a href="https://awplife.com/demo/testimonial-premium/" target="_blank"
                                            style="color: #2563eb; text-decoration: none; font-weight: 500;"><?php esc_html_e('Upgrade to Pro!', 'testimonial-maker'); ?></a>
                                    </div>
                                </div>

                                <div class="tml-mui-form-group">
                                    <label
                                        class="tml-mui-label"><?php esc_html_e('Rating Color', 'testimonial-maker'); ?></label>
                                    <div class="tml-mui-description" style="margin-bottom: 8px;">
                                        <?php esc_html_e('Set color for the rating icons.', 'testimonial-maker'); ?>
                                    </div>
                                    <div style="display:flex; gap:24px;">
                                        <div>
                                            <label
                                                style="font-size: 0.75rem; color: rgba(0,0,0,0.6); display: block; margin-bottom: 4px;">Default
                                                (Empty)</label>
                                            <input type="text" name="tml_ds_rating_default_color"
                                                value="<?php echo esc_attr($get_val('tml_ds_rating_default_color', '#E0E0E0')); ?>"
                                                class="tml-color-picker">
                                        </div>
                                        <div>
                                            <label
                                                style="font-size: 0.75rem; color: rgba(0,0,0,0.6); display: block; margin-bottom: 4px;">Rating
                                                (Filled)</label>
                                            <input type="text" name="tml_star_rating_color"
                                                value="<?php echo esc_attr($get_val('tml_star_rating_color', '#FFD700')); ?>"
                                                class="tml-color-picker">
                                        </div>
                                    </div>
                                </div>

                                <div style="display:flex; gap: 24px;">
                                    <div class="tml-mui-form-group" style="flex: 1;">
                                        <label
                                            class="tml-mui-label"><?php esc_html_e('Rating Icon Size (px)', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description" style="margin-bottom: 8px;">
                                            <?php esc_html_e('Size for the rating icon.', 'testimonial-maker'); ?>
                                        </div>
                                        <input type="number" name="tml_ds_rating_size"
                                            value="<?php echo esc_attr($get_val('tml_ds_rating_size', '19')); ?>"
                                            class="tml-mui-input" style="width:100%;">
                                    </div>
                                    <div class="tml-mui-form-group" style="flex: 1;">
                                        <label
                                            class="tml-mui-label"><?php esc_html_e('Icon Gap (px)', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description" style="margin-bottom: 8px;">
                                            <?php esc_html_e('Gap between the rating icons.', 'testimonial-maker'); ?>
                                        </div>
                                        <input type="number" name="tml_ds_rating_gap"
                                            value="<?php echo esc_attr($get_val('tml_ds_rating_gap', '2')); ?>"
                                            class="tml-mui-input" style="width:100%;">
                                    </div>
                                </div>

                                <div class="tml-mui-form-group">
                                    <label
                                        class="tml-mui-label"><?php esc_html_e('Rating Position', 'testimonial-maker'); ?></label>
                                    <div class="tml-mui-description" style="margin-bottom: 8px;">
                                        <?php esc_html_e('Select a position for the star rating.', 'testimonial-maker'); ?>
                                    </div>
                                    <select name="tml_ds_rating_pos" class="tml-mui-input" style="max-width: 300px;">
                                        <option value="above_name" <?php selected($get_val('tml_ds_rating_pos', 'below_name'), 'above_name'); ?>>Above Reviewer Name</option>
                                        <option value="below_name" <?php selected($get_val('tml_ds_rating_pos', 'below_name'), 'below_name'); ?>>Below Reviewer Name</option>
                                        <option value="above_content" <?php selected($get_val('tml_ds_rating_pos', 'below_name'), 'above_content'); ?>>Above Description</option>
                                        <option value="below_content" <?php selected($get_val('tml_ds_rating_pos', 'below_name'), 'below_content'); ?>>Below Description</option>
                                    </select>
                                </div>

                                <div class="tml-mui-form-group">
                                    <label
                                        class="tml-mui-label"><?php esc_html_e('Rating Alignment', 'testimonial-maker'); ?></label>
                                    <div class="tml-mui-description" style="margin-bottom: 8px;">
                                        <?php esc_html_e('Select an alignment for the star rating.', 'testimonial-maker'); ?>
                                    </div>
                                    <?php $alignment = $get_val('tml_star_rating_alignment', 'center'); ?>
                                    <div class="tml-mui-toggle-group" style="display: inline-flex;">
                                        <label
                                            class="tml-mui-toggle-label <?php echo $alignment == 'left' ? 'active' : ''; ?>"><input
                                                type="radio" name="tml_star_rating_alignment" value="left" <?php checked($alignment, 'left'); ?>
                                                style="display:none;"><?php esc_html_e('Left', 'testimonial-maker'); ?></label>
                                        <label
                                            class="tml-mui-toggle-label <?php echo $alignment == 'center' ? 'active' : ''; ?>"><input
                                                type="radio" name="tml_star_rating_alignment" value="center" <?php checked($alignment, 'center'); ?>
                                                style="display:none;"><?php esc_html_e('Center', 'testimonial-maker'); ?></label>
                                        <label
                                            class="tml-mui-toggle-label <?php echo $alignment == 'right' ? 'active' : ''; ?>"><input
                                                type="radio" name="tml_star_rating_alignment" value="right" <?php checked($alignment, 'right'); ?>
                                                style="display:none;"><?php esc_html_e('Right', 'testimonial-maker'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- REVIEWER IMAGE -->
                        <div id="tml-vtab-image" class="tml-v-content" style="display:none;">
                            <div class="tml-mui-card">
                                <div class="tml-mui-card-title">
                                    <?php esc_html_e('Reviewer Image Settings', 'testimonial-maker'); ?>
                                </div>

                                <div class="tml-mui-form-group"
                                    style="flex-direction: row; justify-content: space-between; align-items: center;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0;"><?php esc_html_e('Reviewer Image', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description">
                                            <?php esc_html_e('Show or hide the reviewer image.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <?php $ds_image_show = $get_val('tml_ds_image_show', 'show'); ?>
                                    <label class="tml-mui-switch">
                                        <input type="hidden" name="tml_ds_image_show" value="hide">
                                        <input type="checkbox" name="tml_ds_image_show" value="show" <?php checked($ds_image_show, 'show'); ?>>
                                        <span class="tml-mui-slider"></span>
                                    </label>
                                </div>

                                <input type="hidden" name="tml_ds_image_dim"
                                    value="<?php echo esc_attr($get_val('tml_ds_image_dim', 'thumbnail')); ?>">

                                <div class="tml-mui-form-group">
                                    <label
                                        class="tml-mui-label"><?php esc_html_e('Image Shape', 'testimonial-maker'); ?></label>
                                    <div class="tml-mui-description" style="margin-bottom: 12px;">
                                        <?php esc_html_e('Choose an image shape.', 'testimonial-maker'); ?>
                                    </div>
                                    <?php $current_shape = $get_val('tml_ds_image_shape', 'circle'); ?>
                                    <div style="display:flex; gap:16px;">
                                        <label class="tml-mui-icon-radio" style="flex: 1; max-width: 120px;">
                                            <div class="tml-radio-avatar" style="border-radius:50%;"><i
                                                    class="fa fa-user"></i></div>
                                            <input type="radio" name="tml_ds_image_shape" value="circle" <?php checked($current_shape, 'circle'); ?> style="display:none;">
                                            <span style="font-size: 14px; font-weight: 500;">Circle</span>
                                        </label>
                                        <label class="tml-mui-icon-radio" style="flex: 1; max-width: 120px;">
                                            <div class="tml-radio-avatar" style="border-radius:8px;"><i
                                                    class="fa fa-user"></i></div>
                                            <input type="radio" name="tml_ds_image_shape" value="rounded" <?php checked($current_shape, 'rounded'); ?> style="display:none;">
                                            <span style="font-size: 14px; font-weight: 500;">Rounded</span>
                                        </label>
                                        <label class="tml-mui-icon-radio" style="flex: 1; max-width: 120px;">
                                            <div class="tml-radio-avatar" style="border-radius:0;"><i
                                                    class="fa fa-user"></i></div>
                                            <input type="radio" name="tml_ds_image_shape" value="square" <?php checked($current_shape, 'square'); ?> style="display:none;">
                                            <span style="font-size: 14px; font-weight: 500;">Square</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="tml-mui-form-group">
                                    <label
                                        class="tml-mui-label"><?php esc_html_e('Image Size', 'testimonial-maker'); ?></label>
                                    <div class="tml-mui-description">
                                        <?php esc_html_e('Set display width and height of the image in pixels.', 'testimonial-maker'); ?>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:8px; margin-top: 12px;">
                                        <input type="number" name="tml_ds_image_size"
                                            value="<?php echo esc_attr($get_val('tml_ds_image_size', '80')); ?>"
                                            class="tml-mui-input"
                                            style="width:100px; height: 42px; box-sizing: border-box;" min="20"
                                            max="300">
                                        <span style="font-size:14px; color:#64748b; font-weight:500;">px</span>
                                    </div>
                                </div>



                                <div class="tml-mui-form-group">
                                    <label
                                        class="tml-mui-label"><?php esc_html_e('Reviewer Fallback Images', 'testimonial-maker'); ?></label>
                                    <div class="tml-mui-description" style="margin-bottom: 12px;">
                                        <?php esc_html_e('If no Featured Image is set, a reviewer fallback image can be used.', 'testimonial-maker'); ?>
                                    </div>
                                    <?php $fallback = $get_val('tml_ds_image_fallback', 'mystery'); ?>
                                    <div style="display:flex; flex-direction:column; gap:12px;">
                                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                                            <input type="radio" name="tml_ds_image_fallback" value="none" <?php checked($fallback, 'none'); ?>> No Fallback Image
                                        </label>
                                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                                            <input type="radio" name="tml_ds_image_fallback" value="mystery" <?php checked($fallback, 'mystery'); ?>> Mystery Person
                                        </label>
                                        <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                                            <input type="radio" name="tml_ds_image_fallback" value="avatar" <?php checked($fallback, 'avatar'); ?>> Smart Text Avatars
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="tml-vtab-video" class="tml-v-content" style="display:none;">
                            <div class="tml-mui-card">
                                <div
                                    style="color: #475569; font-size: 0.775rem; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid rgba(0,0,0,0.06); font-family: sans-serif; line-height: 1.5;">
                                    <?php
                                    printf(
                                        wp_kses(
                                            /* translators: 1: Video Record link, 2: Video Testimonials link, 3: Upgrade to Pro link */
                                            __('To allow customers to Record Videos or Collect them manually to easily display Video Testimonials and boost sales, <a href="%3$s" target="_blank" style="color: #2563eb; text-decoration: underline; font-weight: 500;">Upgrade to Pro!</a>', 'testimonial-maker'),
                                            array(
                                                'a' => array(
                                                    'href' => array(),
                                                    'target' => array(),
                                                    'style' => array(),
                                                ),
                                            )
                                        ),
                                        esc_url('https://awplife.com/demo/testimonial-premium/'),
                                        esc_url('https://awplife.com/demo/testimonial-premium/'),
                                        esc_url('https://awplife.com/demo/testimonial-premium/')
                                    );
                                    ?>
                                </div>

                                <div class="tml-mui-form-group"
                                    style="display: flex !important; flex-direction: row !important; justify-content: space-between; align-items: center; margin-top: 24px !important; margin-bottom: 24px !important;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom:0; font-size: 0.875rem; color: #475569; font-weight: 500;"><?php esc_html_e('Video Testimonial', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description"
                                            style="margin-top: 4px; font-size: 0.75rem; color: #94a3b8; font-style: italic;">
                                            <?php esc_html_e('Show/Hide video testimonial.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div
                                        style="display: inline-flex; align-items: center; background: #cbd5e1; border-radius: 4px; padding: 4px 8px; font-family: sans-serif; font-size: 11px; font-weight: bold; color: #ffffff; line-height: 1; pointer-events: none; user-select: none;">
                                        <span
                                            style="border: 1px solid #ffffff; color: #ffffff; padding: 1px 4px; border-radius: 3px; margin-right: 6px; font-size: 8px; font-weight: bold; line-height: 1;">PRO</span>
                                        HIDE
                                    </div>
                                </div>

                                <div class="tml-mui-form-group"
                                    style="display: flex !important; flex-direction: row !important; justify-content: space-between; align-items: center; margin-top: 24px !important; margin-bottom: 24px !important;">
                                    <div>
                                        <label class="tml-mui-label"
                                            style="margin-bottom: 0; font-size: 0.875rem; color: #475569; font-weight: 500;"><?php esc_html_e('Video Play Mode', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description"
                                            style="margin-top: 4px; font-size: 0.75rem; color: #94a3b8; font-style: italic;">
                                            <?php esc_html_e('Select a mode video play.', 'testimonial-maker'); ?>
                                        </div>
                                    </div>
                                    <div class="tml-mui-toggle-group"
                                        style="opacity: 0.85; pointer-events: none; user-select: none; display: inline-flex; align-items: center; border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden; padding: 0;">
                                        <span class="tml-mui-toggle-label"
                                            style="margin: 0; background-color: #ffffff !important; border: none !important; color: #94a3b8 !important; padding: 8px 16px; font-size: 13px; font-weight: 500; border-radius: 0;">Inline</span>
                                        <span class="tml-mui-toggle-label active"
                                            style="margin: 0; background-color: #7fb4f5 !important; border: none !important; color: #ffffff !important; padding: 8px 16px; font-size: 13px; font-weight: 500; border-radius: 0;">Popup</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="tml-vtab-social" class="tml-v-content" style="display:none;">
                            <div class="tml-mui-card">
                                <div
                                    style="color: #475569; font-size: 0.775rem; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid rgba(0,0,0,0.06); font-family: sans-serif; line-height: 1.5;">
                                    <?php
                                    printf(
                                        wp_kses(
                                            /* translators: 1: Social Media Profiles link, 2: Upgrade to Pro link */
                                            __('To display reviewer Social Media Profiles and customize their layout, colors, and styles on testimonials, <a href="%2$s" target="_blank" style="color: #2563eb; text-decoration: underline; font-weight: 500;">Upgrade to Pro!</a>', 'testimonial-maker'),
                                            array(
                                                'a' => array(
                                                    'href' => array(),
                                                    'target' => array(),
                                                    'style' => array(),
                                                ),
                                            )
                                        ),
                                        esc_url('https://awplife.com/demo/testimonial-premium/'),
                                        esc_url('https://awplife.com/demo/testimonial-premium/')
                                    );
                                    ?>
                                </div>

                                <div
                                    style="opacity: 0.6; filter: blur(0.6px); pointer-events: none; user-select: none;">
                                    <div class="tml-mui-card-title">
                                        <?php esc_html_e('Social Media Settings', 'testimonial-maker'); ?>
                                    </div>

                                    <div class="tml-mui-form-group"
                                        style="flex-direction: row; justify-content: space-between; align-items: center;">
                                        <div>
                                            <label class="tml-mui-label"
                                                style="margin-bottom:0;"><?php esc_html_e('Social Profiles', 'testimonial-maker'); ?></label>
                                            <div class="tml-mui-description">
                                                <?php esc_html_e('Show or hide social profiles.', 'testimonial-maker'); ?>
                                            </div>
                                        </div>
                                        <label class="tml-mui-switch">
                                            <input type="checkbox" disabled>
                                            <span class="tml-mui-slider"></span>
                                        </label>
                                    </div>

                                    <div class="tml-mui-form-group">
                                        <label
                                            class="tml-mui-label"><?php esc_html_e('Icon Color Type', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description" style="margin-bottom: 8px;">
                                            <?php esc_html_e('Choose icon color type.', 'testimonial-maker'); ?>
                                        </div>
                                        <div class="tml-mui-toggle-group">
                                            <label class="tml-mui-toggle-label active">Original</label>
                                            <label class="tml-mui-toggle-label">Custom</label>
                                        </div>
                                    </div>

                                    <div class="tml-mui-form-group tml-social-custom-colors" style="display:none;">
                                        <label
                                            class="tml-mui-label"><?php esc_html_e('Custom Icon Colors', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description" style="margin-bottom: 8px;">
                                            <?php esc_html_e('Set custom colors for social icons.', 'testimonial-maker'); ?>
                                        </div>
                                        <div style="display:flex; gap:24px; flex-wrap:wrap;">
                                            <div>
                                                <label
                                                    style="font-size: 0.75rem; color: rgba(0,0,0,0.6); display: block; margin-bottom: 4px;">Color</label>
                                                <input type="text" value="#888888" class="tml-color-picker" disabled>
                                            </div>
                                            <div>
                                                <label
                                                    style="font-size: 0.75rem; color: rgba(0,0,0,0.6); display: block; margin-bottom: 4px;">Hover
                                                    Color</label>
                                                <input type="text" value="#2271b1" class="tml-color-picker" disabled>
                                            </div>
                                            <div>
                                                <label
                                                    style="font-size: 0.75rem; color: rgba(0,0,0,0.6); display: block; margin-bottom: 4px;">Background</label>
                                                <input type="text" value="transparent" class="tml-color-picker"
                                                    disabled>
                                            </div>
                                            <div>
                                                <label
                                                    style="font-size: 0.75rem; color: rgba(0,0,0,0.6); display: block; margin-bottom: 4px;">Hover
                                                    Background</label>
                                                <input type="text" value="#f0f6fc" class="tml-color-picker" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tml-mui-form-group">
                                        <label
                                            class="tml-mui-label"><?php esc_html_e('Icon Border', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description" style="margin-bottom: 8px;">
                                            <?php esc_html_e('Set social icon border properties.', 'testimonial-maker'); ?>
                                        </div>
                                        <div style="display:flex; gap:16px; align-items:flex-end; flex-wrap:wrap;">
                                            <div>
                                                <label
                                                    style="font-size: 0.75rem; color: rgba(0,0,0,0.6); display: block; margin-bottom: 4px;">Width
                                                    (px)</label>
                                                <input type="number" value="1" class="tml-mui-input" style="width:80px;"
                                                    disabled>
                                            </div>
                                            <div>
                                                <label
                                                    style="font-size: 0.75rem; color: rgba(0,0,0,0.6); display: block; margin-bottom: 4px;">Style</label>
                                                <select class="tml-mui-input" style="width: 120px;" disabled>
                                                    <option value="solid">Solid</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label
                                                    style="font-size: 0.75rem; color: rgba(0,0,0,0.6); display: block; margin-bottom: 4px;">Color</label>
                                                <input type="text" value="#eeeeee" class="tml-color-picker" disabled>
                                            </div>
                                            <div>
                                                <label
                                                    style="font-size: 0.75rem; color: rgba(0,0,0,0.6); display: block; margin-bottom: 4px;">Hover
                                                    Color</label>
                                                <input type="text" value="#2271b1" class="tml-color-picker" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tml-mui-form-group">
                                        <label
                                            class="tml-mui-label"><?php esc_html_e('Margin (px)', 'testimonial-maker'); ?></label>
                                        <div class="tml-mui-description" style="margin-bottom: 8px;">
                                            <?php esc_html_e('Set margin for social profiles.', 'testimonial-maker'); ?>
                                        </div>
                                        <div style="display:flex; gap:16px; flex-wrap:wrap;">
                                            <div>
                                                <label
                                                    style="font-size: 0.75rem; color: rgba(0,0,0,0.6); display: block; margin-bottom: 4px;">Top</label>
                                                <input type="number" value="15" class="tml-mui-input"
                                                    style="width:80px;" disabled>
                                            </div>
                                            <div>
                                                <label
                                                    style="font-size: 0.75rem; color: rgba(0,0,0,0.6); display: block; margin-bottom: 4px;">Right</label>
                                                <input type="number" value="0" class="tml-mui-input" style="width:80px;"
                                                    disabled>
                                            </div>
                                            <div>
                                                <label
                                                    style="font-size: 0.75rem; color: rgba(0,0,0,0.6); display: block; margin-bottom: 4px;">Bottom</label>
                                                <input type="number" value="5" class="tml-mui-input" style="width:80px;"
                                                    disabled>
                                            </div>
                                            <div>
                                                <label
                                                    style="font-size: 0.75rem; color: rgba(0,0,0,0.6); display: block; margin-bottom: 4px;">Left</label>
                                                <input type="number" value="0" class="tml-mui-input" style="width:80px;"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sticky Live Preview Action Button -->
    <button type="button" class="tml-sticky-preview-btn" id="tml-trigger-preview">
        <i class="fa fa-eye"></i>
        <span><?php esc_html_e('Live Preview', 'testimonial-maker'); ?></span>
    </button>

    <!-- Sticky Reset to Defaults Button -->
    <button type="button" class="tml-sticky-reset-btn" id="tml-trigger-reset">
        <i class="fa fa-refresh"></i>
        <span><?php esc_html_e('Reset', 'testimonial-maker'); ?></span>
    </button>

    <!-- Reset Confirmation Dialog -->
    <div class="tml-reset-confirm-overlay" id="tml-reset-confirm-overlay">
        <div class="tml-reset-confirm-box">
            <div class="tml-reset-confirm-icon">
                <i class="fa fa-exclamation-triangle"></i>
            </div>
            <h3><?php esc_html_e('Reset All Settings?', 'testimonial-maker'); ?></h3>
            <p><?php esc_html_e('This will permanently reset ALL testimonial settings back to their original defaults. This action cannot be undone.', 'testimonial-maker'); ?>
            </p>
            <div class="tml-reset-confirm-actions">
                <button type="button" class="tml-reset-cancel-btn" id="tml-reset-cancel-btn">
                    <i class="fa fa-times"></i> <?php esc_html_e('Cancel', 'testimonial-maker'); ?>
                </button>
                <button type="button" class="tml-reset-confirm-btn" id="tml-reset-confirm-btn">
                    <i class="fa fa-refresh"></i> <?php esc_html_e('Yes, Reset Now', 'testimonial-maker'); ?>
                </button>
            </div>
        </div>
    </div>

    <!-- Live Preview Modal Overlay Container -->
    <div class="tml-preview-modal" id="tml-preview-modal-overlay">
        <div class="tml-preview-modal-content">
            <div class="tml-preview-modal-header">
                <h3>
                    <i class="fa fa-eye" style="color:var(--tml-primary);"></i>
                    <?php esc_html_e('Real-Time Testimonial Slider Preview', 'testimonial-maker'); ?>
                </h3>
                <button type="button" class="tml-preview-close" id="tml-preview-close-btn">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="tml-preview-modal-body">
                <!-- Loader Overlay -->
                <div class="tml-preview-loader" id="tml-preview-loader-wrap">
                    <div class="tml-preview-spinner"></div>
                    <span><?php esc_html_e('Generating real-time live preview...', 'testimonial-maker'); ?></span>
                </div>

                <!-- Target container for dynamic rendered shortcode HTML -->
                <div id="tml-preview-render-target"></div>
            </div>
        </div>
    </div>

    <script>
        jQuery(document).ready(function ($) {
            var is_pro = false;
            // Tabs Logic with Persistence
            var activeTab = $('#tml_active_tab_field').val() || '#tml-tab-general';
            var selectedPreset = $('.tml-settings-wrapper input[name="tml_layout_preset"]:checked').val();
            var staticPresets = ['grid', 'masonry', 'list', 'isotope'];
            var sliderPresets = ['slider', 'carousel'];

            // Prevent loading pagination tab if layout is slider or carousel
            if (activeTab === '#tml-tab-pagination' && staticPresets.indexOf(selectedPreset) === -1) {
                activeTab = '#tml-tab-general';
                $('#tml_active_tab_field').val('#tml-tab-general');
            }
            // Prevent loading slider config tab if layout is grid, masonry, list
            if (activeTab === '#tml-tab-slider' && sliderPresets.indexOf(selectedPreset) === -1) {
                activeTab = '#tml-tab-general';
                $('#tml_active_tab_field').val('#tml-tab-general');
            }

            if (!activeTab || activeTab === '#' || activeTab === 'undefined') {
                activeTab = '#tml-tab-general';
            }
            $('.tml-mui-nav-item:not(.tml-v-tab):not(.tml-s-tab)[href="' + activeTab + '"]').addClass('active').siblings().removeClass('active');
            $('.tml-tab-content').removeClass('active');
            $(activeTab).addClass('active');

            $('.tml-mui-nav-item:not(.tml-v-tab):not(.tml-s-tab)').on('click', function (e) {
                if ($(this).hasClass('tml-pro-locked')) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
                e.preventDefault();
                var tabId = $(this).attr('href');
                if (!tabId || tabId === '#' || tabId === 'undefined') return;

                $('.tml-mui-nav-item:not(.tml-v-tab):not(.tml-s-tab)').removeClass('active');
                $(this).addClass('active');
                $('.tml-tab-content').removeClass('active');
                $(tabId).addClass('active');
                $('#tml_active_tab_field').val(tabId);
            });

            // Vertical Tabs Logic with Persistence
            var activeVTab = $('#tml_active_vtab_field').val() || 'basic';
            if (activeVTab) {
                var $vtab = $('.tml-v-tab[data-vtab="' + activeVTab + '"]');
                if ($vtab.length) {
                    $('.tml-v-tab').removeClass('active');
                    $vtab.addClass('active');
                    $('.tml-v-content').hide();
                    $('#tml-vtab-' + activeVTab).show();
                }
            }

            $('.tml-v-tab').on('click', function (e) {
                e.preventDefault();
                var vtabId = $(this).data('vtab');
                $('.tml-v-tab').removeClass('active');
                $(this).addClass('active');

                $('.tml-v-content').hide();
                $('#tml-vtab-' + vtabId).show();
                $('#tml_active_vtab_field').val(vtabId);
            });

            // Slider Config Subtabs Logic with Persistence
            var activeSTab = $('#tml_active_stab_field').val() || 'basics';
            var $stab = $('.tml-s-tab[data-stab="' + activeSTab + '"]');
            if ($stab.length) {
                $('.tml-s-tab').removeClass('active');
                $stab.addClass('active');
                $('.tml-s-content').hide();
                $('#tml-stab-' + activeSTab).show();
            }

            $('.tml-s-tab').on('click', function (e) {
                e.preventDefault();
                var stabId = $(this).data('stab');
                $('.tml-s-tab').removeClass('active');
                $(this).addClass('active');

                $('.tml-s-content').hide();
                $('#tml-stab-' + stabId).show();
                $('#tml_active_stab_field').val(stabId);
            });

            // Initialize Color Picker
            if (typeof $.fn.wpColorPicker !== 'undefined') {
                $('.tml-color-picker, .tml-color-field').wpColorPicker({
                    change: function (event, ui) {
                        var color = ui.color.toString();
                        var name = $(this).attr('name');
                        if (name === 'tml_star_rating_color') {
                            $('.tml-mui-icon-radio i').css('color', color);
                        }
                    }
                });
            }

            // Bulletproof real-time color update for rating icons in selection radio list
            $(document).on('change input propertychange', 'input[name="tml_star_rating_color"]', function () {
                var color = $(this).val();
                if (color) {
                    $('.tml-mui-icon-radio i').css('color', color);
                }
            });

            // Template Grid Selection
            $('.tml-template-card').on('click', function (e) {
                if (!$(e.target).is('input[type="radio"]')) {
                    var $radio = $(this).find('input[name="testimonial_carousel_design"]');
                    if (!$radio.prop('checked')) {
                        $radio.prop('checked', true).trigger('change');
                    }
                }
            });

            // Pagination Type Card Selection
            $('.tml-pagi-type-card').on('click', function (e) {
                if ($(this).hasClass('tml-pro-locked')) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
                $('.tml-pagi-type-card').removeClass('selected');
                $(this).addClass('selected');
                $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
            });

            // Layout Preset Selection
            $('.tml-preset-card').on('click', function (e) {
                if ($(this).hasClass('tml-pro-locked')) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
                $('.tml-preset-card').removeClass('selected');
                $(this).addClass('selected');
                $(this).find('input[name="tml_layout_preset"]').prop('checked', true).trigger('change');

                // Dynamically update columns based on preset
                var preset = $(this).find('input[name="tml_layout_preset"]').val();
                var cols = 3; // default for grid, carousel, multirow, masonry

                if (preset === 'slider' || preset === 'list') {
                    cols = 1;
                }

                $('#tml_col_ld').val(cols);
                $('#tml_col_d').val(cols);
                $('#tml_col_l').val(Math.min(cols, 2));
                $('#tml_col_t').val(1);
                $('#tml_col_m').val(1);
            });

            // Toggle Group active class handler
            $('.tml-mui-toggle-label').on('click', function () {
                $(this).closest('.tml-mui-toggle-group').find('.tml-mui-toggle-label').removeClass('active');
                $(this).addClass('active');
                $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
            });




            // Initialize Sortable for Categories
            if ($('#tml-category-sortable-list').length > 0) {
                $('#tml-category-sortable-list').sortable({
                    helper: 'clone',
                    appendTo: 'body',
                    start: function (event, ui) {
                        ui.helper.width(ui.item.width());
                        ui.helper.css('z-index', 999999);
                    },
                    update: function (event, ui) {
                        var order = [];
                        $('.tml-cat-item').each(function () {
                            order.push($(this).data('id'));
                        });
                        $('#tml_category_order').val(order.join(','));
                    }
                });
            }

            // Initialize Sortable for Ratings
            if ($('#tml-rating-sortable-list').length > 0) {
                $('#tml-rating-sortable-list').sortable({
                    helper: 'clone',
                    appendTo: 'body',
                    start: function (event, ui) {
                        ui.helper.width(ui.item.width());
                        ui.helper.css('z-index', 999999);
                    },
                    update: function (event, ui) {
                        var order = [];
                        $('.tml-rating-item').each(function () {
                            order.push($(this).data('id'));
                        });
                        $('#tml_rating_order').val(order.join(','));
                    }
                });
            }

            // Initialize Sortable for Visual Layout Zones
            if ($('.tml-visual-zone').length > 0) {
                $('.tml-visual-zone').sortable({
                    connectWith: '.tml-visual-zone',
                    items: '.tml-layout-field-item',
                    placeholder: 'tml-layout-field-item-placeholder',
                    tolerance: 'pointer',
                    revert: 150,
                    cursor: 'grabbing',
                    opacity: 0.85,
                    forcePlaceholderSize: true,
                    start: function (event, ui) {
                        ui.placeholder.height(ui.item.outerHeight());
                        $('.tml-visual-zone').addClass('tml-zone-sorting-active');
                    },
                    over: function (event, ui) {
                        $(this).addClass('tml-zone-sorting-hover');
                    },
                    out: function (event, ui) {
                        $(this).removeClass('tml-zone-sorting-hover');
                    },
                    stop: function (event, ui) {
                        $('.tml-visual-zone').removeClass('tml-zone-sorting-active tml-zone-sorting-hover');
                        updateFieldLayoutValue();
                    },
                    update: function (event, ui) {
                        updateFieldLayoutValue();
                    }
                }).disableSelection();

                function updateFieldLayoutValue() {
                    var layout = [];
                    var flatOrder = [];
                    $('.tml-visual-zone').each(function () {
                        var zoneName = $(this).data('zone');
                        var fields = [];
                        $(this).find('.tml-layout-field-item').each(function () {
                            var fid = $(this).data('id');
                            fields.push(fid);
                            flatOrder.push(fid);
                        });

                        // Toggle placeholder class based on child elements
                        $(this).toggleClass('has-items', fields.length > 0);

                        // Dynamic alignment class based on content field presence
                        var hasContent = fields.indexOf('content') !== -1;
                        if (hasContent) {
                            $(this).addClass('tml-align-left').removeClass('tml-align-center');
                        } else {
                            $(this).addClass('tml-align-center').removeClass('tml-align-left');
                        }

                        layout.push(zoneName + ':' + fields.join(','));
                    });

                    $('#tml_ds_field_layout').val(layout.join('|'));
                    $('#tml_ds_field_order').val(flatOrder.join(','));
                }
            }

            // Handle Radio Button Change Events
            $('input[type="radio"]').on('change', function () {
                var name = $(this).attr('name');
                var val = $(this).val();

                // Show/Hide Social Custom Colors
                if (name == 'tml_social_icon_type') {
                    if (val == 'custom') {
                        $('.tml-social-custom-colors').show();
                    } else {
                        $('.tml-social-custom-colors').hide();
                    }
                }
            });
            // Slider Tab Toggle Switch Text
            $('.tml-toggle-input').on('change', function () {
                var text = $(this).is(':checked') ? 'ENABLED' : 'DISABLED';
                $(this).siblings('.tml-toggle-text').text(text);
            });

            // Direction Toggle Styling
            $('input[name="tml_rtl"]').on('change', function () {
                $(this).closest('div').find('label').css({ 'background': '#fff', 'color': '#333', 'border-color': '#ccc' });
                $(this).parent('label').css({ 'background': '#2271b1', 'color': '#fff', 'border-color': '#2271b1' });
            });
            // Vertical Sub-Tabs Switching
            $('.tml-vertical-tab-link').on('click', function (e) {
                e.preventDefault();
                var target = $(this).attr('href');

                // Update links
                $('.tml-vertical-tab-link').removeClass('active');
                $(this).addClass('active');

                // Update panels
                $('.tml-sub-tab-panel').removeClass('active');
                $(target).addClass('active');

                // Store active sub-tab
                $('#tml_active_subtab_field').val(target);
            });

            // Restore active sub-tab on load
            var activeSubTab = $('#tml_active_subtab_field').val();
            if (activeSubTab && $(activeSubTab).length) {
                $('.tml-vertical-tab-link[href="' + activeSubTab + '"]').trigger('click');
            }
            // Navigation Position Preview
            function updateNavPreview() {
                var pos = $('#tml_nav_position').val();
                var prev = $('#tml-nav-preview-arrows .prev');
                var next = $('#tml-nav-preview-arrows .next');

                // Reset styles
                prev.css({ left: 'auto', right: 'auto', top: 'auto', bottom: 'auto', transform: 'none' });
                next.css({ left: 'auto', right: 'auto', top: 'auto', bottom: 'auto', transform: 'none' });

                switch (pos) {
                    case 'vertical_outer':
                        prev.css({ left: '-20px', top: '50%', transform: 'translateY(-50%)' });
                        next.css({ right: '-20px', top: '50%', transform: 'translateY(-50%)' });
                        break;
                    case 'vertical_inner':
                        prev.css({ left: '5px', top: '50%', transform: 'translateY(-50%)' });
                        next.css({ right: '5px', top: '50%', transform: 'translateY(-50%)' });
                        break;
                    case 'top_right':
                        prev.css({ right: '25px', top: '-15px' });
                        next.css({ right: '5px', top: '-15px' });
                        break;
                    case 'top_left':
                        prev.css({ left: '5px', top: '-15px' });
                        next.css({ left: '25px', top: '-15px' });
                        break;
                    case 'top_center':
                        prev.css({ left: '50%', top: '-15px', transform: 'translateX(-110%)' });
                        next.css({ left: '50%', top: '-15px', transform: 'translateX(10%)' });
                        break;
                    case 'bottom_left':
                        prev.css({ left: '5px', bottom: '-15px' });
                        next.css({ left: '25px', bottom: '-15px' });
                        break;
                    case 'bottom_right':
                        prev.css({ right: '25px', bottom: '-15px' });
                        next.css({ right: '5px', bottom: '-15px' });
                        break;
                    case 'bottom_center':
                        prev.css({ left: '50%', bottom: '-15px', transform: 'translateX(-110%)' });
                        next.css({ left: '50%', bottom: '-15px', transform: 'translateX(10%)' });
                        break;
                    case 'vertical_center':
                        prev.css({ left: '-15px', top: '50%', transform: 'translateY(-50%)' });
                        next.css({ right: '-15px', top: '50%', transform: 'translateY(-50%)' });
                        break;
                }
            }

            $('#tml_nav_position').on('change', updateNavPreview);
            updateNavPreview(); // Run on load
        });
    </script>

    <script>
        jQuery(document).ready(function ($) {
            var sliderPresets = ['slider', 'carousel'];
            var staticPresets = ['grid', 'masonry', 'list', 'isotope'];

            function toggleSliderTab() {
                var selected = $('.tml-settings-wrapper input[name="tml_layout_preset"]:checked').val();

                // Toggle Limit row visibility: only show for slider/carousel
                if (sliderPresets.indexOf(selected) !== -1) {
                    $('#tml-limit-setting-row').show();
                } else {
                    $('#tml-limit-setting-row').hide();
                }

                // SLIDER CONFIG tab
                if (sliderPresets.indexOf(selected) !== -1) {
                    var el = $('#tml-slider-config-tab')[0];
                    if (el) el.style.setProperty('display', 'flex', 'important');
                } else {
                    if ($('#tml-slider-config-tab').hasClass('active')) {
                        $('#tml-slider-config-tab').removeClass('active');
                        $('.tml-tab-content').removeClass('active');
                        $('a[href="#tml-tab-general"]').addClass('active');
                        $('#tml-tab-general').addClass('active');
                        $('#tml_active_tab_field').val('#tml-tab-general');
                    }
                    var el = $('#tml-slider-config-tab')[0];
                    if (el) el.style.setProperty('display', 'none', 'important');
                }

                // PAGINATION tab
                if (staticPresets.indexOf(selected) !== -1) {
                    var el = $('#tml-pagination-tab')[0];
                    if (el) el.style.setProperty('display', 'flex', 'important');
                } else {
                    if ($('#tml-pagination-tab').hasClass('active')) {
                        $('#tml-pagination-tab').removeClass('active');
                        $('.tml-tab-content').removeClass('active');
                        $('a[href="#tml-tab-general"]').addClass('active');
                        $('#tml-tab-general').addClass('active');
                        $('#tml_active_tab_field').val('#tml-tab-general');
                    }
                    var el = $('#tml-pagination-tab')[0];
                    if (el) el.style.setProperty('display', 'none', 'important');
                }
            }

            function toggleFieldLayoutTab() {
                var selectedDesign = $('input[name="testimonial_carousel_design"]:checked').val();
                var $layoutTabLink = $('.tml-v-tab[data-vtab="layout"]');

                if (selectedDesign == '17') {
                    $layoutTabLink.removeClass('tml-hide-tab');
                } else {
                    $layoutTabLink.addClass('tml-hide-tab');
                    // If the active vertical tab was 'layout', switch back to 'basic'
                    if ($layoutTabLink.hasClass('active')) {
                        $layoutTabLink.removeClass('active');
                        $('.tml-v-tab[data-vtab="basic"]').addClass('active');
                        $('.tml-v-content').hide();
                        $('#tml-vtab-basic').show();
                        $('#tml_active_vtab_field').val('basic');
                    }
                }
            }

            // Run on page load
            toggleSliderTab();
            toggleFieldLayoutTab();

            // Run whenever a preset is changed
            $('input[name="tml_layout_preset"]').on('change', function () {
                toggleSliderTab();
            });

            // Run whenever a template/design is changed
            $('input[name="testimonial_carousel_design"]').on('change', function () {
                $('.tml-template-card').removeClass('selected');
                $('input[name="testimonial_carousel_design"]:checked').closest('.tml-template-card').addClass('selected');
                toggleFieldLayoutTab();
            });

            // ==========================================================
            // LIVE PREVIEW MODAL AJAX SYSTEM
            // ==========================================================

            var $modal = $('#tml-preview-modal-overlay');
            var $loader = $('#tml-preview-loader-wrap');
            var $target = $('#tml-preview-render-target');

            // Open Modal and trigger AJAX preview render
            $('#tml-trigger-preview').on('click', function (e) {
                e.preventDefault();

                // Show the modal backdrop and RESET loader state
                $modal.addClass('active');
                $loader.removeClass('tml-loader-hidden').show();
                $target.html('');

                // Grab all options from the form
                // Since we are inside the WordPress meta box, the form is $('form#post')
                var formData = $('form#post').serializeArray();

                // Append custom action for our AJAX callback
                formData.push({ name: 'action', value: 'tml_save_preview_settings' });

                // Post via AJAX
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: $.param(formData),
                    success: function (response) {
                        if (response.success) {
                            // Inject the dynamic HTML of the shortcode
                            $target.html(response.data.html);

                            // Hide loader - double method to bypass any CSS !important overrides
                            $loader.addClass('tml-loader-hidden');
                            $loader[0].style.setProperty('display', 'none', 'important');

                            // Trigger resize event to force carousel recalculations
                            setTimeout(function () {
                                $(window).trigger('resize');
                            }, 150);
                        } else {
                            $target.html('<div style="padding: 40px; color: #ef4444; font-weight: 600; text-align: center; font-size: 1rem;"><i class="fa fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 12px; display: block;"></i>Error: ' + response.data.message + '</div>');
                            $loader.addClass('tml-loader-hidden');
                            $loader[0].style.setProperty('display', 'none', 'important');
                        }
                    },
                    error: function () {
                        $target.html('<div style="padding: 40px; color: #ef4444; font-weight: 600; text-align: center; font-size: 1rem;"><i class="fa fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 12px; display: block;"></i>Failed to generate live preview. Please try again.</div>');
                        $loader.addClass('tml-loader-hidden');
                        $loader[0].style.setProperty('display', 'none', 'important');
                    }
                });
            });

            // Close Modal when close button is clicked
            $('#tml-preview-close-btn').on('click', function () {
                $modal.removeClass('active');
                $target.html('');
            });

            // Close Modal when clicking outside the modal content
            $modal.on('click', function (e) {
                if ($(e.target).is($modal)) {
                    $modal.removeClass('active');
                    $target.html('');
                }
            });

            // ==========================================================
            // RESET TO DEFAULTS SYSTEM
            // ==========================================================

            var $resetOverlay = $('#tml-reset-confirm-overlay');
            var $resetConfirmBtn = $('#tml-reset-confirm-btn');

            // Open confirmation dialog
            $('#tml-trigger-reset').on('click', function () {
                $resetOverlay.addClass('active');
            });

            // Cancel — close dialog
            $('#tml-reset-cancel-btn').on('click', function () {
                $resetOverlay.removeClass('active');
            });

            // Close on backdrop click
            $resetOverlay.on('click', function (e) {
                if ($(e.target).is($resetOverlay)) {
                    $resetOverlay.removeClass('active');
                }
            });

            // Confirm Reset — AJAX call
            $resetConfirmBtn.on('click', function () {
                var $btn = $(this);
                var originalHtml = $btn.html();

                // Show loading state on button
                $btn.html('<i class="fa fa-spinner fa-spin"></i> <?php esc_html_e("Resetting...", 'testimonial-maker'); ?>').prop('disabled', true);

                var postId = $('input[name="post_ID"]').val();
                var nonce = $('input[name="tml_shortcode_nonce"]').val();

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'tml_reset_shortcode_settings',
                        post_ID: postId,
                        tml_shortcode_nonce: nonce
                    },
                    success: function (response) {
                        if (response.success) {
                            // Success — show tick and reload page
                            $btn.html('<i class="fa fa-check"></i> <?php esc_html_e("Done! Reloading...", 'testimonial-maker'); ?>');
                            setTimeout(function () {
                                window.location.reload();
                            }, 800);
                        } else {
                            alert('Error: ' + response.data.message);
                            $btn.html(originalHtml).prop('disabled', false);
                            $resetOverlay.removeClass('active');
                        }
                    },
                    error: function () {
                        alert('<?php esc_html_e("Failed to reset settings. Please try again.", 'testimonial-maker'); ?>');
                        $btn.html(originalHtml).prop('disabled', false);
                        $resetOverlay.removeClass('active');
                    }
                });
            });

            // Admin Preview Read More Expand Action Handler
            $(document).on('click', '.expand-btn', function (e) {
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
        });
    </script>