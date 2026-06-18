<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<style>
    /* Template 3 - Simple Centered Classic Layout (Avatar Centered Top, Divider, Content Centered Below) */

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial {
        background:
            <?php echo esc_attr($tml_background_color ? $tml_background_color : '#ffffff'); ?>
        ;
        border-radius: 16px;
        padding: 30px;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: visible;
        box-sizing: border-box;
        width: 100%;
        text-align: center;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial:hover {
        transform: translateY(-4px);
    }

    /* Beautiful Centered Rounded Avatar */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .pic {
        width: <?php echo esc_attr($tml_ds_image_size ? $tml_ds_image_size : '80'); ?>px !important;
        height: <?php echo esc_attr($tml_ds_image_size ? $tml_ds_image_size : '80'); ?>px !important;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        margin: 0 auto 15px auto;
        display: block;
        float: none !important;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial:hover .pic {
        transform: scale(1.06);
        box-shadow: 0 10px 22px rgba(0, 0, 0, 0.1);
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .pic img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        display: block;
    }

    /* Centered Title (Name) */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-title {
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 5px 0;
        line-height: 1.3;
        color: <?php echo esc_attr($tml_title_color ? $tml_title_color : '#111111'); ?>;
        text-align: center;
        width: 100%;
    }

    /* Centered Designation */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-designation {
        font-size: 13px;
        font-weight: 500;
        opacity: 0.8;
        margin: 0 0 8px 0;
        color: <?php echo esc_attr($tml_designation_color ? $tml_designation_color : '#666666'); ?>;
        text-align: center;
    }

    /* Centered Website Link */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-link {
        font-size: 11px;
        margin: 0 0 10px 0;
        text-align: center;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-link a {
        color: #2271b1;
        text-decoration: none !important;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-link a:hover {
        text-decoration: underline !important;
    }

    /* Centered Star rating container styling */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-rating {
        margin: 0 auto 12px auto !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        text-align: center !important;
        width: 100% !important;
    }

    /* Centered Description paragraph layout */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .tml-description {
        font-size: 14px;
        line-height: 1.6;
        font-style: italic;
        opacity: 0.9;
        text-align: center;
        color: <?php echo esc_attr($tml_description_color ? $tml_description_color : '#333333'); ?>;
        margin: 0;
        padding: 0;
        background: transparent;
        border: none;
        box-shadow: none;
        border-radius: 0;
        width: 100%;
    }

    /* Mobile Stacking adaptation (already centered, just padding adjustments) */
    @media only screen and (max-width: 480px) {
        #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial {
            padding: 25px 20px;
        }
    }
</style>