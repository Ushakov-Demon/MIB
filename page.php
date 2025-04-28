<?php
get_header();
$is_home = is_front_page();
?>

<main id="primary" class="site-main<?php if(!$is_home): ?> site-page<?php endif; ?>">

    <?php
        if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb( '<div class="breadcrumb-container"><div class="container"><div id="breadcrumbs">','</div></div></div>' );
        }
    ?>
    <?php if (get_the_content()) : ?>
        <?php the_content(); ?>
    <?php endif; ?>
</main>

<?php
get_footer();