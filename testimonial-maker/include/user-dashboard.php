<?php
if (!defined('ABSPATH')) {
    exit;
}

// Register Dashboard Shortcode
add_shortcode('TML_DASHBOARD', 'tml_user_dashboard_shortcode');

function tml_user_dashboard_shortcode($atts) {
    if (!is_user_logged_in()) {
        return '<div class="tml-dashboard-notice" style="padding:20px; background:#f9f9f9; border-left:4px solid #0073aa;">' . 
               __('Please log in to view your testimonials.', 'testimonial-maker') . 
               '</div>';
    }

    $current_user_id = get_current_user_id();

    $args = array(
        'post_type' => 'testimonial-maker',
        'author' => $current_user_id,
        'posts_per_page' => -1,
        'post_status' => array('publish', 'pending', 'draft', 'private')
    );

    $testimonials = get_posts($args);

    ob_start();
    ?>
    <div class="tml-user-dashboard">
        <h3 style="margin-bottom:20px;"><?php esc_html_e('My Testimonials', 'testimonial-maker'); ?></h3>
        
        <?php if (empty($testimonials)) { ?>
            <p><?php esc_html_e('You have not submitted any testimonials yet.', 'testimonial-maker'); ?></p>
        <?php } else { ?>
            <table class="tml-dashboard-table" style="width:100%; border-collapse:collapse; text-align:left;">
                <thead>
                    <tr style="background:#f1f1f1; border-bottom:2px solid #ddd;">
                        <th style="padding:12px;"><?php esc_html_e('Title', 'testimonial-maker'); ?></th>
                        <th style="padding:12px;"><?php esc_html_e('Date', 'testimonial-maker'); ?></th>
                        <th style="padding:12px;"><?php esc_html_e('Status', 'testimonial-maker'); ?></th>
                        <th style="padding:12px;"><?php esc_html_e('Rating', 'testimonial-maker'); ?></th>
                        <th style="padding:12px;"><?php esc_html_e('Actions', 'testimonial-maker'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($testimonials as $t) { 
                        $meta = get_post_meta($t->ID, 'awl_testimonial'.$t->ID, true);
                        $rating = isset($meta['star_rating']) ? intval($meta['star_rating']) : 5;
                        
                        $status_label = '';
                        $status_color = '';
                        switch($t->post_status) {
                            case 'publish':
                                $status_label = __('Approved', 'testimonial-maker');
                                $status_color = 'green';
                                break;
                            case 'pending':
                                $status_label = __('Pending', 'testimonial-maker');
                                $status_color = 'orange';
                                break;
                            default:
                                $status_label = ucfirst($t->post_status);
                                $status_color = 'gray';
                        }
                    ?>
                    <tr id="tml-row-<?php echo esc_attr($t->ID); ?>" style="border-bottom:1px solid #eee;">
                        <td style="padding:12px;"><strong><?php echo esc_html($t->post_title); ?></strong></td>
                        <td style="padding:12px;"><?php echo esc_html(date_i18n(get_option('date_format'), strtotime($t->post_date))); ?></td>
                        <td style="padding:12px;"><span style="color:<?php echo esc_attr($status_color); ?>; font-weight:bold;"><?php echo esc_html($status_label); ?></span></td>
                        <td style="padding:12px;">
                            <?php for ($i=1; $i<=5; $i++) {
                                echo ($i <= $rating) ? '<span style="color:#ffb600;">★</span>' : '<span style="color:#ddd;">★</span>';
                            } ?>
                        </td>
                        <td style="padding:12px;">
                            <button class="tml-delete-btn" data-id="<?php echo esc_attr($t->ID); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce('tml_delete_'.$t->ID)); ?>" style="background:#dc3232; color:#fff; border:none; padding:5px 10px; border-radius:3px; cursor:pointer; font-size:12px;">
                                <?php esc_html_e('Delete', 'testimonial-maker'); ?>
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>

    <script>
        jQuery(document).ready(function($) {
            $('.tml-delete-btn').on('click', function(e) {
                e.preventDefault();
                if (!confirm('<?php echo esc_js(__("Are you sure you want to delete this testimonial? This action cannot be undone.", 'testimonial-maker')); ?>')) {
                    return;
                }
                
                var btn = $(this);
                var id = btn.data('id');
                var nonce = btn.data('nonce');
                
                btn.text('...');
                btn.prop('disabled', true);
                
                $.ajax({
                    url: '<?php echo esc_url(admin_url("admin-ajax.php")); ?>',
                    type: 'POST',
                    data: {
                        action: 'tml_delete_user_testimonial',
                        post_id: id,
                        nonce: nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#tml-row-' + id).fadeOut(300, function() {
                                $(this).remove();
                            });
                        } else {
                            alert(response.data.message || 'Error deleting.');
                            btn.text('Delete').prop('disabled', false);
                        }
                    }
                });
            });
        });
    </script>
    <?php
    return ob_get_clean();
}

// Handle AJAX Deletion
add_action('wp_ajax_tml_delete_user_testimonial', 'tml_handle_user_delete');
function tml_handle_user_delete() {
    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Not logged in.'));
    }

    $post_id = isset($_POST['post_id']) ? intval(wp_unslash($_POST['post_id'])) : 0;
    $nonce = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';

    if (!wp_verify_nonce($nonce, 'tml_delete_' . $post_id)) {
        wp_send_json_error(array('message' => 'Security check failed.'));
    }

    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'testimonial-maker' || $post->post_author != get_current_user_id()) {
        wp_send_json_error(array('message' => 'Unauthorized.'));
    }

    wp_delete_post($post_id, true);
    wp_send_json_success();
}
?>
