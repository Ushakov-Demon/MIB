<?php

/*
Template Name: Programs
*/

get_header();
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
                <h1 class="hero-header-title"><?php echo the_title(); ?></h1>
                <?php include get_template_directory() . '/template-parts/blocks/block-archive-description-from-menu.php'; ?>
                <?php include get_template_directory() . '/template-parts/blocks/block-tags.php'; ?>
            </div>
        </div>
    </div>

	<?php if (get_the_content()) : ?>
        <?php the_content(); ?>
    <?php endif; ?>

</main>

<?php
get_footer();