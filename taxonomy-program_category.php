<?php

$taxonomy = get_queried_object();
$taxonomy_id = $taxonomy->term_id;

$main_top_heading_text = $taxonomy->name;
$main_bottom_text = $taxonomy->description;

$main_top_version = 'white';
$main_top_heading_media = '';

$programs_per_page = '-1';
$programs_section_title = '';

get_header();
?>

	<main id="primary" class="site-main">

		<?php 
			include get_template_directory() . '/template-parts/sections/hero-section.php'; 
			include get_template_directory() . '/template-parts/sections/programs_previews-section.php'; 
		?>

	</main>

<?php
get_footer();
