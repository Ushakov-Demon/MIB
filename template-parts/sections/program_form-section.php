<?php
if (!defined('ABSPATH')) exit;

$heading = $program_form_registration_heading ?? '';
$form_id = $contact_form_id ?? '';

if (empty($form_id)) return;
?>

<section class="section section-program-form" id="form-request">
    <div class="container">
        
        <?php if (!empty($heading)) : ?>
            <div class="section-title"><?php echo wp_kses_post($heading); ?></div>
        <?php endif; ?>

        <?php 
            if (function_exists('wpcf7_contact_form_tag_func')) {
                echo do_shortcode('[contact-form-7 id="' . esc_attr($form_id) . '"]');
            } else {
                echo '<p>' . __('Contact Form 7 plugin is not active.') . '</p>';
            }
        ?>
    </div>
</section>