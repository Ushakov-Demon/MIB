
<?php
$program_id = get_the_ID();

$accreditations = carbon_get_post_meta($program_id, 'tr_progaram_accriditation');

if (!empty($accreditations)) {
    echo '<div class="logo">';
    
    foreach ($accreditations as $accr) {

        $accr_id = $accr['id'];
        $accr_post = get_post($accr_id);
        
        $logo_id = carbon_get_post_meta($accr_id, 'accr_white_logo');
        $site_url = carbon_get_post_meta($accr_id, 'accr_site_url'); // TODO: Change to single acreditaion URL

        if (!empty($logo_id)) {
            $logo_url = wp_get_attachment_image_url($logo_id, 'full');
            
            if (!empty($site_url)) {
                echo '<a href="' . esc_url($site_url) . '" target="_blank" rel="noopener noreferrer">';
            }
            
            echo '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr(get_the_title($accr_id)) . '" class="accreditation-logo">';
            
            if (!empty($site_url)) {
                echo '</a>';
            }
        }
    }

    echo '</div>';
}
?>