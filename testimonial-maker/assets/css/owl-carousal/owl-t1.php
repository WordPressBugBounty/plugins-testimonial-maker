<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<style>
    /* Template 12 - Premium Centered Profile Floating Card (Redesigned) */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-item-wrapper {
        padding: 25px 0px 0px;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial {
        background:
            <?php echo esc_attr($tml_background_color ? $tml_background_color : '#ffffff'); ?>
        ;
        border-radius: 20px;
        padding: 60px 35px 35px;
        /* Large top padding to make space for the floating avatar */
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: visible;
        margin: 35px 0px 0px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial:hover {
        transform: translateY(-5px);
    }

    /* Beautiful top-floating Concentric Rotating Ring Avatar */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .pic {
        width: <?php echo esc_attr($tml_ds_image_size ? $tml_ds_image_size : '90'); ?>px !important;
        height: <?php echo esc_attr($tml_ds_image_size ? $tml_ds_image_size : '90'); ?>px !important;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        position: absolute;
        top: -<?php echo esc_attr($tml_ds_image_size ? intval($tml_ds_image_size / 2) : '45'); ?>px !important;
        /* Float perfectly on the top card border */
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: visible;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial:hover .pic {
        transform: translateX(-50%) scale(1.08);
        outline-color:
            <?php echo esc_attr(($tml_background_color == '#ffffff' || empty($tml_background_color)) ? '#2271b1' : '#fff'); ?>
        ;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18);
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .pic::before {
        content: "";
        position: absolute;
        top: -8px;
        left: -8px;
        right: -8px;
        bottom: -8px;
        border-radius: 50%;
        pointer-events: none;
        transition: all 0.4s ease;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial:hover .pic::before {
        transform: rotate(30deg);
        border-color: rgba(0, 0, 0, 0.15);
    }



    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .pic img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-content {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 15px;
        align-items: center;
        padding: 0;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .tml-description {
        line-height: 1.6;
        margin: 0;
        opacity: 0.95;
        position: relative;
        z-index: 2;
    }

    /* Beautiful elegant quotation backdrop mark inside description */
    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .tml-description::before {
        content: "\f10d";
        font-family: FontAwesome;
        font-size: 32px;
        color: rgba(0, 0, 0, 0.03);
        display: block;
        margin-bottom: 5px;
        line-height: 1;
        transition: all 0.3s ease;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial:hover .tml-description::before {
        transform: translateY(-2px) scale(1.1);
        color: rgba(0, 0, 0, 0.06);
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-title::after {
        display: none;
        /* Hide the old clunky purple hardcoded icon */
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .tml-designation {
        font-size: 13px;
        font-weight: 500;
        opacity: 0.8;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-link {
        font-size: 12px;
        text-transform: lowercase;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-link a {
        text-decoration: none;
        opacity: 0.8;
    }

    #tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?> .tml-testimonial .testimonial-link a:hover {
        opacity: 1;
        text-decoration: underline;
    }
</style>