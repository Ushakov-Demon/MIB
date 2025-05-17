<?php

if (!defined('ABSPATH')) exit;

$heading   = get_option('_manager_contact_heading') ?? '';
$avatar_id = get_option('_manager_avatar') ?? '';
$name      = get_option('_manager_name') ?? '';
$position  = get_option('_manager_position') ?? '';
$form_id   = get_option('_contact_form_id') ?? '';

if (empty($form_id)) return;
?>

<section class="section section-manager-contact" id="manager-contact">
    <div class="container">
        
        <div class="manager-contact-wrapper">
            <div class="manager-info">
                <?php 
                $avatar_url = wp_get_attachment_image_url( $avatar_id, 'thumbnail' );
                $avatar_alt = get_post_meta( $avatar_id, '_wp_attachment_image_alt', true ) ?: $name;
                ?>
                <div class="manager-avatar">
                    <img src="<?php echo esc_url($avatar_url); ?>" alt="<?php echo esc_attr($avatar_alt); ?>" loading="lazy">
                </div>
                <div class="manager-details">
                    <div class="manager-name"><?php echo __( esc_html( $name ), 'baza' ); ?></div>
                    <?php if ( ! empty( $position ) ) : ?>
                        <div class="manager-position"><?php echo __( esc_html( $position ), 'baza' ); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="manager-contact-form">
                <?php if ( ! empty( $heading ) ) : ?>
                    <div class="section-title"><?php echo __( wp_kses_post( $heading ), 'baza' ); ?></div>
                <?php endif; ?>

                <?php 
                    if (function_exists('wpcf7_contact_form_tag_func')) {
                        echo do_shortcode('[contact-form-7 id="' . esc_attr($form_id) . '"]');
                    } else {
                        echo '<p>' . __('Contact Form 7 plugin is not active.') . '</p>';
                    }
                ?>
            </div>
        </div>
    </div>
</section>