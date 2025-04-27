<?php
get_header();

$actuality_posts_per_page = 24;
$alternating_posts = apply_filters( 'mib_get_alternating_posts', $actuality_posts_per_page, 2 );
?>

<main id="primary" class="site-main">

    <div class="hero-header">
        
        <div class="breadcrumb-container">
            <div class="container">
                <?php
                    if ( function_exists('yoast_breadcrumb') ) {
                        yoast_breadcrumb( '<div id="breadcrumbs">','</div>' );
                    }
                ?>
            </div>
        </div>

        <div class="hero-header-wrapper">

            <div class="container">
                <h1><?php the_archive_title(); ?></h1>
            </div>
        </div>
    </div>

    <?php include get_template_directory() . '/template-parts/sections/actuality_previews-section.php'; ?>

    <div class="more-posts">
        <a class="view-more-link"><?php pll_e('View more results', 'baza'); ?></a>
    </div>

</main>

<?php
get_footer();