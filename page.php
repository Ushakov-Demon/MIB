<?php
get_header();

$has_hero = apply_filters( 'mib_has_gutenberg_block', get_the_content(), 'main_top' );
?>

<main id="primary" class="site-main">

    <?php
        if ( function_exists('yoast_breadcrumb') && ! $has_hero ) {
            yoast_breadcrumb( '<div class="breadcrumb-container"><div class="container"><div id="breadcrumbs">','</div></div></div>' );
        }
    ?>
    <?php if (get_the_content()) : ?>
        <?php the_content(); ?>
    <?php endif; ?>
</main>

<?php
get_footer();