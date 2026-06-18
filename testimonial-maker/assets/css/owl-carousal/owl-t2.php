<?php if (!defined('ABSPATH'))
    exit; ?>
<style>
    /* Template 22 - Premium Centered Quote Card */


    /* Card base */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial {
        text-align: center;
        background:
            <?php echo esc_attr($tml_background_color ? $tml_background_color : '#ffffff'); ?>
        ;
        border-radius: 18px;
        padding: 0 0 28px 0;
        position: relative;
        overflow: hidden;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial::before {
        content: none !important;
        display: none !important;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial:hover {
        transform: translateY(-6px);
    }

    /* Content wrapper (description + rating) */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-content {
        width: 100%;
        padding: 24px 28px 0;
        box-sizing: border-box;
    }

    /* Quote icon background */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .tml-description {
        line-height: 1.75;
        margin-bottom: 20px;
        padding: 0;
        position: relative;
        font-style: italic;
        opacity: 0.88;
        font-size: 14px;
        color: #4a4a4a;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .tml-description::before {
        content: none !important;
        display: none !important;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .tml-description::after {
        content: none !important;
        display: none !important;
    }

    /* Star rating */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-rating {
        margin: 0 0 20px 0;
        display: block;
        text-align: center;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-rating i {
        font-size: 14px;
        margin: 0 1px;
    }

    /* Divider before avatar */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .pic {
        width: <?php echo esc_attr($tml_ds_image_size ? $tml_ds_image_size : '72'); ?>px !important;
        height:<?php echo esc_attr($tml_ds_image_size ? $tml_ds_image_size : '72'); ?>px !important;
        margin: 0 auto 14px auto;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #fff;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        position: relative;
        z-index: 2;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        flex-shrink: 0;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial:hover .pic {
        transform: scale(1.08);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.18);
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .pic img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        display: block;
    }

    /* Thin separator line before author */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .tml-divider {
        display: none;
    }

    /* Author name */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-title {
        font-size: 15px;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0 0 3px 0;
        letter-spacing: 0.01em;
    }

    /* Designation */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .tml-designation {
        display: inline-block;
        font-size: 12px;
        font-weight: 600;
        color:
            <?php echo esc_attr($tml_background_color ? $tml_background_color : '#4f8ef7'); ?>
        ;
        opacity: 0.85;
        margin-top: 2px;
        letter-spacing: 0.03em;
    }

    /* Website link */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-link {
        display: block;
        margin-top: 6px;
        font-size: 11.5px;
        max-width: 100%;
        padding: 0 20px;
        box-sizing: border-box;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-transform: lowercase;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-link a {
        color: #888;
        text-decoration: none !important;
        font-weight: 500;
        transition: color 0.25s ease;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-link a:hover {
        color:
            <?php echo esc_attr($tml_background_color ? $tml_background_color : '#4f8ef7'); ?>
            !important;
        text-decoration: none !important;
    }

    /* Mobile adaptations */
    @media screen and (max-width: 480px) {
        #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial {
            padding-bottom: 22px;
        }

        #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-content {
            padding: 18px 20px 0;
        }

        #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .tml-description {
            font-size: 13px;
            line-height: 1.65;
        }

        #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .pic {
            width: 62px;
            height: 62px;
        }
    }
</style>