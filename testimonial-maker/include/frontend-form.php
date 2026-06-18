<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

// Register the frontend form shortcode
add_shortcode('TML_FORM', 'tml_frontend_submission_form');

function tml_frontend_submission_form($atts)
{
    $atts = shortcode_atts(array(
        'id' => '',
        'display' => 'inline',
    ), $atts);

    // Default form configuration
    $form_fields = array(
        'name' => array('label' => 'Your Name', 'placeholder' => '', 'required' => 'yes'),
        'designation' => array('label' => 'Designation', 'placeholder' => 'e.g. CEO, Manager', 'required' => 'no'),
        'website' => array('label' => 'Website URL', 'placeholder' => 'e.g. https://example.com', 'required' => 'no'),
        'category' => array('label' => 'Select Category', 'placeholder' => '', 'required' => 'no'),
        'content' => array('label' => 'Your Review', 'placeholder' => '', 'required' => 'yes'),
        'image' => array('label' => 'Profile Image', 'placeholder' => '', 'required' => 'no'),
        'rating' => array('label' => 'Rating', 'placeholder' => '', 'required' => 'yes'),
        'social' => array('label' => 'Social Profiles', 'placeholder' => '', 'required' => 'no')
    );
    $active_fields = array('name', 'designation', 'website', 'category', 'content', 'image', 'rating');

    $form_settings = array();
    if (!empty($atts['id'])) {
        $meta_fields = get_post_meta($atts['id'], 'tml_form_fields', true);
        $meta_active = get_post_meta($atts['id'], 'tml_form_active_fields', true);
        $form_settings = get_post_meta($atts['id'], 'tml_form_settings', true);
        if (!is_array($form_settings)) {
            $form_settings = array();
        }
        if (is_array($meta_fields) && is_array($meta_active) && !empty($meta_active)) {
            $form_fields = $meta_fields;
            $active_fields = $meta_active;
        }
    }

    // Also filter out any unauthorized PRO fields
    $active_fields = array_values(array_diff($active_fields, array('video', 'social', 'recaptcha')));

    $get_fset = function ($key, $default = '') use ($form_settings) {
        return isset($form_settings[$key]) ? $form_settings[$key] : $default;
    };

    ob_start();

    if ($atts['display'] == 'popup') {
        echo '<button id="tml-open-form-btn" class="btn btn-primary" style="padding:10px 20px; background:#0073aa; color:#fff; border:none; border-radius:4px; cursor:pointer; font-weight:bold;">' . esc_html__('Write a Review', 'testimonial-maker') . '</button>';
        echo '<div id="tml-form-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; align-items:center; justify-content:center;">';
        echo '<div style="position:relative; width:100%; max-width:600px; background:#fff; border-radius:8px; max-height:90vh; overflow-y:auto; box-shadow:0 5px 15px rgba(0,0,0,0.3);">';
        echo '<span id="tml-close-form-btn" style="position:absolute; top:15px; right:20px; font-size:28px; cursor:pointer; color:#666; line-height:1;">&times;</span>';
    }
    ?>
    <?php
    $layout = $get_fset('form_layout', 'style_one');
    ?>
    <div class="tml-frontend-form-wrapper <?php echo esc_attr($layout); ?>"
        style="<?php echo ($atts['display'] == 'popup') ? 'box-shadow:none; margin:0; width:100%; max-width:100%;' : ''; ?>">
        <form id="tml-frontend-form" method="post" enctype="multipart/form-data">
            <div id="tml-form-message"></div>

            <?php if (in_array('name', $active_fields)): ?>
                <div class="tml-form-group">
                    <?php if (!empty($form_fields['name']['label'])): ?><label
                            for="tml_name"><?php echo esc_html($form_fields['name']['label']); ?><?php echo ($form_fields['name']['required'] == 'yes') ? ' *' : ''; ?></label><?php endif; ?>
                    <div class="tml-field-input-wrapper">
                        <input type="text" name="tml_name" id="tml_name" <?php echo ($form_fields['name']['required'] == 'yes') ? 'required' : ''; ?> placeholder="<?php echo esc_attr($form_fields['name']['placeholder']); ?>"
                            class="form-control">
                    </div>
                </div>
            <?php endif; ?>




            <?php if (in_array('designation', $active_fields)): ?>
                <div class="tml-form-group">
                    <?php if (!empty($form_fields['designation']['label'])): ?><label
                            for="tml_designation"><?php echo esc_html($form_fields['designation']['label']); ?><?php echo ($form_fields['designation']['required'] == 'yes') ? ' *' : ''; ?></label><?php endif; ?>
                    <div class="tml-field-input-wrapper">
                        <input type="text" name="tml_designation" id="tml_designation" <?php echo ($form_fields['designation']['required'] == 'yes') ? 'required' : ''; ?>
                            placeholder="<?php echo esc_attr($form_fields['designation']['placeholder']); ?>"
                            class="form-control">
                    </div>
                </div>
            <?php endif; ?>
            <?php if (in_array('website', $active_fields)): ?>
                <div class="tml-form-group">
                    <?php if (!empty($form_fields['website']['label'])): ?><label
                            for="tml_website"><?php echo esc_html($form_fields['website']['label']); ?><?php echo ($form_fields['website']['required'] == 'yes') ? ' *' : ''; ?></label><?php endif; ?>
                    <div class="tml-field-input-wrapper">
                        <input type="url" name="tml_website" id="tml_website" <?php echo ($form_fields['website']['required'] == 'yes') ? 'required' : ''; ?>
                            placeholder="<?php echo esc_attr($form_fields['website']['placeholder']); ?>" class="form-control">
                    </div>
                </div>
            <?php endif; ?>


            <?php if (in_array('category', $active_fields)): ?>
                <div class="tml-form-group">
                    <?php if (!empty($form_fields['category']['label'])): ?><label
                            for="tml_category_id"><?php echo esc_html($form_fields['category']['label']); ?><?php echo ($form_fields['category']['required'] == 'yes') ? ' *' : ''; ?></label><?php endif; ?>
                    <div class="tml-field-input-wrapper">
                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'testimonial-categories',
                            'hide_empty' => false,
                        ));
                        ?>
                        <select name="tml_category_id" id="tml_category_id" class="form-control" <?php echo ($form_fields['category']['required'] == 'yes') ? 'required' : ''; ?>
                            style="width:100%; height:40px; cursor:pointer;">
                            <option value="">Select Category...</option>
                            <?php if (!empty($categories) && !is_wp_error($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo esc_attr($cat->term_id); ?>"><?php echo esc_html($cat->name); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <option value="new">+ Create New Category...</option>
                        </select>

                        <div id="tml-new-category-wrapper" style="display:none; margin-top:8px;">
                            <input type="text" name="tml_new_category_name" id="tml_new_category_name"
                                placeholder="Enter New Category Name" class="form-control">
                        </div>
                    </div>
                </div>
            <?php endif; ?>



            <?php if (in_array('content', $active_fields)): ?>
                <div class="tml-form-group">
                    <?php if (!empty($form_fields['content']['label'])): ?><label
                            for="tml_review"><?php echo esc_html($form_fields['content']['label']); ?><?php echo ($form_fields['content']['required'] == 'yes') ? ' *' : ''; ?></label><?php endif; ?>
                    <div class="tml-field-input-wrapper">
                        <textarea name="tml_review" id="tml_review" rows="5" <?php echo ($form_fields['content']['required'] == 'yes') ? 'required' : ''; ?>
                            placeholder="<?php echo esc_attr($form_fields['content']['placeholder']); ?>" class="form-control"
                            style="resize:vertical;"></textarea>
                    </div>
                </div>
            <?php endif; ?>


            <?php if (in_array('image', $active_fields)): ?>
                <div class="tml-form-group">
                    <?php if (!empty($form_fields['image']['label'])): ?><label
                            for="tml_image"><?php echo esc_html($form_fields['image']['label']); ?></label><?php endif; ?>
                    <div class="tml-field-input-wrapper">
                        <div style="display:flex; align-items:center; gap:16px;">
                            <div style="flex:1;">
                                <input type="file" name="tml_image" id="tml_image" accept="image/*" class="form-control"
                                    style="padding:4px; height:auto; line-height:1.2;">
                            </div>
                            <div style="flex-shrink:0;">
                                <img id="tml-image-preview" src=""
                                    style="display:none; width:50px; height:50px; border-radius:50%; object-fit:cover; border:2px solid var(--tml-primary, #0073aa); box-shadow:0 2px 4px rgba(0,0,0,0.1);">
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>



            <?php if (in_array('rating', $active_fields)): ?>
                <div class="tml-form-group">
                    <?php if (!empty($form_fields['rating']['label'])): ?><label
                            style="display:block; margin-bottom:8px; font-weight:600; color:#333;"><?php echo esc_html($form_fields['rating']['label']); ?>
                            *</label><?php endif; ?>
                    <div class="tml-field-input-wrapper">
                        <div style="display:flex; align-items:center; gap:16px; margin-top:8px;">
                            <input type="hidden" name="tml_rating" id="tml_rating" value="5">
                            <span class="tml-frontend-stars" style="cursor: pointer; display: inline-flex; gap: 8px;">
                                <i class="fa fa-star frontend-star" data-val="1"
                                    style="font-size:32px; color:#ffb600; transition: transform 0.2s, color 0.2s;"></i>
                                <i class="fa fa-star frontend-star" data-val="2"
                                    style="font-size:32px; color:#ffb600; transition: transform 0.2s, color 0.2s;"></i>
                                <i class="fa fa-star frontend-star" data-val="3"
                                    style="font-size:32px; color:#ffb600; transition: transform 0.2s, color 0.2s;"></i>
                                <i class="fa fa-star frontend-star" data-val="4"
                                    style="font-size:32px; color:#ffb600; transition: transform 0.2s, color 0.2s;"></i>
                                <i class="fa fa-star frontend-star" data-val="5"
                                    style="font-size:32px; color:#ffb600; transition: transform 0.2s, color 0.2s;"></i>
                            </span>
                            <span id="tml-frontend-rating-label"
                                style="font-weight:600; color:#666; font-size:15px; user-select:none;">5 Stars</span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (in_array('social', $active_fields)): ?>
                <div class="tml-form-group tml-social-profiles-group" style="margin-bottom:20px;">
                    <?php if (!empty($form_fields['social']['label'])): ?><label
                            style="display:block; margin-bottom:8px; font-weight:600; color:#333;"><?php echo esc_html($form_fields['social']['label']); ?></label><?php endif; ?>
                    <div class="tml-field-input-wrapper">
                        <!-- Social Select Buttons -->
                        <div style="display:flex; gap:10px; margin-bottom:15px; flex-wrap:wrap;">
                            <button type="button" class="tml-social-toggle-btn" data-target="facebook"
                                style="display:inline-flex; align-items:center; gap:8px; padding:6px 12px; border:1px solid #1877f2; background:none; color:#1877f2; border-radius:20px; font-weight:600; cursor:pointer; font-size:13px; transition:all 0.2s; outline:none; box-shadow:none;">
                                <i class="fa fa-facebook"></i> Facebook
                            </button>
                            <button type="button" class="tml-social-toggle-btn" data-target="twitter"
                                style="display:inline-flex; align-items:center; gap:8px; padding:6px 12px; border:1px solid #1da1f2; background:none; color:#1da1f2; border-radius:20px; font-weight:600; cursor:pointer; font-size:13px; transition:all 0.2s; outline:none; box-shadow:none;">
                                <i class="fa fa-twitter"></i> Twitter/X
                            </button>

                        </div>

                        <!-- Input Containers (Initially hidden) -->
                        <div style="display:flex; flex-direction:column; gap:10px;">
                            <div id="tml-social-input-facebook" class="tml-social-input-wrapper"
                                style="display:none; align-items:center; gap:10px;">
                                <span
                                    style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; background:#1877f2; color:#fff; border-radius:6px; font-size:16px; flex-shrink:0;"><i
                                        class="fa fa-facebook"></i></span>
                                <input type="url" name="tml_social[facebook]" placeholder="Facebook Profile URL"
                                    class="form-control"
                                    style="flex:1; border:1px solid #ccc; padding:8px 12px; border-radius:4px; height:38px; box-sizing:border-box;">
                            </div>
                            <div id="tml-social-input-twitter" class="tml-social-input-wrapper"
                                style="display:none; align-items:center; gap:10px;">
                                <span
                                    style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; background:#1da1f2; color:#fff; border-radius:6px; font-size:16px; flex-shrink:0;"><i
                                        class="fa fa-twitter"></i></span>
                                <input type="url" name="tml_social[twitter]" placeholder="Twitter/X Profile URL"
                                    class="form-control"
                                    style="flex:1; border:1px solid #ccc; padding:8px 12px; border-radius:4px; height:38px; box-sizing:border-box;">
                            </div>

                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php wp_nonce_field('tml_submit_testimonial_nonce', 'tml_nonce'); ?>
            <input type="hidden" name="tml_form_id" value="<?php echo esc_attr($atts['id']); ?>">
            <input type="hidden" name="action" value="tml_submit_testimonial">

            <div class="tml-form-group tml-form-buttons-group"
                style="display:flex; gap:10px; flex-wrap:wrap; margin-top:25px; padding-top:20px; border-top:1px solid #eee;">
                <button type="submit" id="tml-submit-btn" class="btn btn-primary"
                    style="padding: 10px 20px; border:none; cursor:pointer; border-radius:4px; font-weight:600;"><?php echo esc_html($get_fset('submit_text', 'Submit Testimonial')); ?></button>
                <button type="reset" id="tml-reset-btn" class="btn btn-secondary"
                    style="padding: 10px 20px; border:1px solid #ccc; cursor:pointer; background-color:#fff; color:#555; border-radius:4px; font-weight:600; transition:all 0.2s;"><?php esc_html_e('Reset Form', 'testimonial-maker'); ?></button>
            </div>
        </form>
    </div>



    <style>
        .tml-frontend-form-wrapper {
            max-width: <?php echo esc_attr($get_fset('form_width', '680')); ?>px;
            margin: 0 auto;
            margin-top: <?php echo esc_attr($get_fset('form_margin_top', '40')); ?>px;
            background: <?php echo esc_attr($get_fset('form_bg', '#f9f9f9')); ?>; padding: 25px;
            border-radius: 8px;
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .tml-form-group {
            margin-bottom: 15px;
        }

        .tml-form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color:
                <?php echo esc_attr($get_fset('label_color', '#333')); ?>
            ;
            text-align: left;
        }

        .tml-form-group input,
        .tml-form-group textarea,
        .tml-form-group select {
            width: 100%;
            padding: 10px;
            background:
                <?php echo esc_attr($get_fset('input_bg', '#ffffff')); ?>
            ;
            border: 1px solid #ccc;
            border-radius:
                <?php echo esc_attr($get_fset('input_radius', '4')); ?>
                px;
            box-sizing: border-box;
        }

        #tml-reset-btn:hover {
            background-color: #f3f4f6 !important;
            border-color: #9ca3af !important;
            color: #111827 !important;
        }

        #tml-submit-btn {
            background-color:
                <?php echo esc_attr($get_fset('btn_bg_color', '#0073aa')); ?>
                !important;
            color:
                <?php echo esc_attr($get_fset('btn_text_color', '#ffffff')); ?>
                !important;
            transition: opacity 0.2s !important;
        }

        #tml-submit-btn:hover {
            opacity: 0.9 !important;
        }



        #tml-form-message {
            margin-bottom: 15px;
            font-weight: bold;
            padding: 10px;
            border-radius: 4px;
            display: none;
        }

        .tml-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            display: block !important;
        }

        .tml-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            display: block !important;
        }
    </style>
    <script>
        jQuery(document).ready(function ($) {
            // Dynamic Image Preview
            $('#tml_image').on('change', function () {
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#tml-image-preview').attr('src', e.target.result).show();
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#tml-image-preview').hide().attr('src', '');
                }
            });

            // Toggle New Category Input field
            $('#tml_category_id').on('change', function () {
                if ($(this).val() === 'new') {
                    $('#tml-new-category-wrapper').slideDown(200);
                    $('#tml_new_category_name').prop('required', true);
                } else {
                    $('#tml-new-category-wrapper').slideUp(200);
                    $('#tml_new_category_name').prop('required', false).val('');
                }
            });

            // Reset Button State and Visuals
            $('#tml-frontend-form').on('reset', function () {
                setTimeout(function () {
                    // Reset rating field
                    $('#tml_rating').val('');
                    $('#tml-frontend-rating-label').text('Select Rating');
                    $('.tml-frontend-stars .frontend-star').removeClass('fa-star').addClass('fa-star-o').css('color', '#ccc');

                    // Reset category selectors
                    $('#tml-new-category-wrapper').hide();
                    $('#tml_new_category_name').prop('required', false).val('');

                    // Clear custom image preview if exists
                    $('#tml-image-preview').hide().attr('src', '');

                    // Clear message
                    if (!window.tml_submitting_reset) {
                        $('#tml-form-message').hide().removeClass('tml-success tml-error').text('');
                    }
                }, 50);
            });

            // Frontend Interactive Star Rating
            $('.tml-frontend-stars .frontend-star').on('click', function () {
                var val = $(this).data('val');
                $('#tml_rating').val(val);
                $('#tml-frontend-rating-label').text(val + ' Star' + (val > 1 ? 's' : ''));
                $(this).parent().children('.frontend-star').each(function () {
                    if ($(this).data('val') <= val) {
                        $(this).removeClass('fa-star-o').addClass('fa-star').css('color', '#ffb600');
                    } else {
                        $(this).removeClass('fa-star').addClass('fa-star-o').css('color', '#ccc');
                    }
                });
            });

            $('.tml-frontend-stars .frontend-star').on('mouseenter', function () {
                var val = $(this).data('val');
                $(this).parent().children('.frontend-star').each(function () {
                    if ($(this).data('val') <= val) {
                        $(this).css('color', '#ffd000').css('transform', 'scale(1.15)');
                    } else {
                        $(this).css('color', '#ccc').css('transform', 'scale(1)');
                    }
                });
            }).on('mouseleave', function () {
                var currentVal = $('#tml_rating').val();
                $(this).parent().children('.frontend-star').each(function () {
                    $(this).css('transform', 'scale(1)');
                    if ($(this).data('val') <= currentVal) {
                        $(this).removeClass('fa-star-o').addClass('fa-star').css('color', '#ffb600');
                    } else {
                        $(this).removeClass('fa-star').addClass('fa-star-o').css('color', '#ccc');
                    }
                });
            });

            // Toggle Social Profile Input Fields
            $('.tml-social-toggle-btn').on('click', function (e) {
                e.preventDefault();
                var target = $(this).data('target');
                var wrapper = $('#tml-social-input-' + target);

                if (wrapper.is(':visible')) {
                    wrapper.hide();
                    wrapper.find('input').val('');
                    $(this).css('background', 'none').css('color', $(this).css('border-color'));
                } else {
                    wrapper.css('display', 'flex').hide().slideDown(200);
                    var activeColor = $(this).css('border-color');
                    $(this).css('background', activeColor).css('color', '#fff');
                }
            });

            $('#tml-frontend-form').on('submit', function (e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(this);
                var submitBtn = $('#tml-submit-btn');

                submitBtn.prop('disabled', true).text('<?php echo esc_js(__("Submitting...", "testimonial-maker")); ?>');
                $('#tml-form-message').removeClass('tml-success tml-error').html('');

                $.ajax({
                    url: '<?php echo esc_url(admin_url("admin-ajax.php")); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            $('#tml-form-message').addClass('tml-success').html(response.data.message);

                            window.tml_submitting_reset = true;
                            form[0].reset();
                            setTimeout(function () {
                                window.tml_submitting_reset = false;
                            }, 200);

                            // Keep success message visible for 4 seconds, then fade out smoothly
                            setTimeout(function () {
                                $('#tml-form-message').fadeOut(1000, function () {
                                    $(this).removeClass('tml-success').text('').css('display', '');
                                });
                            }, 4000);
                        } else {
                            $('#tml-form-message').addClass('tml-error').html(response.data.message);
                        }
                    },
                    error: function () {
                        $('#tml-form-message').addClass('tml-error').html('<?php echo esc_js(__("An error occurred. Please try again.", "testimonial-maker")); ?>');
                    },
                    complete: function () {
                        submitBtn.prop('disabled', false).text('<?php echo esc_js(__("Submit Testimonial", "testimonial-maker")); ?>');
                    }
                });
            });
        });
    </script>
    <?php
    if ($atts['display'] == 'popup') {
        echo '</div></div>';
        ?>
        <script>
            jQuery(document).ready(function ($) {
                $('#tml-open-form-btn').on('click', function (e) {
                    e.preventDefault();
                    $('#tml-form-modal').css('display', 'flex').hide().fadeIn(300);
                    $('body').css('overflow', 'hidden');
                });
                $('#tml-close-form-btn, #tml-form-modal').on('click', function (e) {
                    if (e.target !== this) return;
                    $('#tml-form-modal').fadeOut(300, function () {
                        $('body').css('overflow', '');
                    });
                });
            });
        </script>
        <?php
    }

    return ob_get_clean();
}

// Handle Ajax Submission
add_action('wp_ajax_tml_submit_testimonial', 'tml_handle_form_submission');
add_action('wp_ajax_nopriv_tml_submit_testimonial', 'tml_handle_form_submission');

function tml_handle_form_submission()
{
    // Verify nonce
    $nonce = isset($_POST['tml_nonce']) ? sanitize_text_field(wp_unslash($_POST['tml_nonce'])) : '';
    if (empty($nonce) || !wp_verify_nonce($nonce, 'tml_submit_testimonial_nonce')) {
        wp_send_json_error(array('message' => __('Security check failed.', 'testimonial-maker')));
    }

    $name = isset($_POST['tml_name']) ? sanitize_text_field(wp_unslash($_POST['tml_name'])) : '';
    $designation = isset($_POST['tml_designation']) ? sanitize_text_field(wp_unslash($_POST['tml_designation'])) : '';
    $website = isset($_POST['tml_website']) ? esc_url_raw(wp_unslash($_POST['tml_website'])) : '';
    $rating = isset($_POST['tml_rating']) ? intval($_POST['tml_rating']) : 5;
    $review = isset($_POST['tml_review']) ? sanitize_textarea_field(wp_unslash($_POST['tml_review'])) : '';

    if (empty($name) || empty($review)) {
        wp_send_json_error(array('message' => __('Name and Review are required fields.', 'testimonial-maker')));
    }

    // Insert post
    $post_data = array(
        'post_title' => $name,
        'post_content' => $review,
        'post_status' => 'pending',
        'post_type' => 'testimonial-maker',
    );

    $post_id = wp_insert_post($post_data);

    if (is_wp_error($post_id)) {
        wp_send_json_error(array('message' => __('Failed to submit testimonial.', 'testimonial-maker')));
    }

    // Handle Category Assignment / Creation
    $category_id = isset($_POST['tml_category_id']) ? sanitize_text_field(wp_unslash($_POST['tml_category_id'])) : '';
    $new_category_name = isset($_POST['tml_new_category_name']) ? sanitize_text_field(wp_unslash($_POST['tml_new_category_name'])) : '';
    if ($category_id === 'new' && !empty($new_category_name)) {
        // Check if term already exists
        $existing_term = term_exists($new_category_name, 'testimonial-categories');
        if ($existing_term) {
            $term_id = is_array($existing_term) ? $existing_term['term_id'] : $existing_term;
        } else {
            // Create term
            $inserted_term = wp_insert_term($new_category_name, 'testimonial-categories');
            if (!is_wp_error($inserted_term)) {
                $term_id = $inserted_term['term_id'];
            }
        }
        if (isset($term_id)) {
            wp_set_object_terms($post_id, (int) $term_id, 'testimonial-categories');
        }
    } elseif (!empty($category_id)) {
        wp_set_object_terms($post_id, (int) $category_id, 'testimonial-categories');
    }

    $testimonial_post_settings = array(
        'website_link' => $website,
        'designation' => $designation,
        'star_rating' => $rating,
    );
    update_post_meta($post_id, 'awl_testimonial' . $post_id, $testimonial_post_settings);

    // Handle Image Upload
    if (!empty($_FILES['tml_image']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        $attachment_id = media_handle_upload('tml_image', $post_id);
        if (!is_wp_error($attachment_id)) {
            set_post_thumbnail($post_id, $attachment_id);
        }
    }

    wp_send_json_success(array('message' => __('Thank you! Your testimonial has been submitted successfully and is pending approval.', 'testimonial-maker')));
}
?>