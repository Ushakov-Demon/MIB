
<?php
$program_id = get_the_ID();

$accreditations = carbon_get_post_meta($program_id, 'tr_progaram_accriditation');

if (!empty($accreditations)) {
    echo '<div class="logo">';
    
    foreach ($accreditations as $accr) {

        $accr_id = $accr['id'];
        $accr_post = get_post($accr_id);
        
        $logo_id = carbon_get_post_meta($accr_id, 'accr_white_logo');
        $permalink = get_permalink( $accr_id );

        if (!empty($logo_id)) {
            $logo_url = wp_get_attachment_image_url($logo_id, 'full');
            echo '<a href="' . esc_url($permalink) . '"><img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_the_title($accr_id)) . '" class="accreditation-logo"></a>';
        }
    }

    echo '</div>';
}
?>