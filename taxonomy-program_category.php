<?php

$taxonomy               = get_queried_object();
$taxonomy_id            = $taxonomy->term_id;
$main_top_heading_text  = $taxonomy->name;
$main_bottom_text       = $taxonomy->description;
$main_top_version_value = get_term_meta( $taxonomy_id, '_main_top_version', true );
$main_top_version       = (!empty( $main_top_version_value )) ? $main_top_version_value : 'white';
$main_top_heading_media = '';
$programs_per_page      = '-1';
$programs_section_title = '';

get_header();
?>

	<main id="primary" class="site-main">

		<?php 
			include get_template_directory() . '/template-parts/sections/hero-section.php'; 
			include get_template_directory() . '/template-parts/sections/programs_previews-section.php'; 
			include get_template_directory() . '/template-parts/sections/manager_contact-section.php';
		?>

	</main>

<?php
get_footer();
