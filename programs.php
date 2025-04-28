<?php

/*
Template Name: Programs
*/

get_header();
?>
<main id="primary" class="site-main">

	<?php if (get_the_content()) : ?>
        <?php the_content(); ?>
    <?php endif; ?>

</main>

<?php
get_footer();