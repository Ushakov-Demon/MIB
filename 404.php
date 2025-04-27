<?php
/*
Template Name: 404
*/
?>

<?php get_header(); ?>

<main id="main" class="site-main page-404">
    <section class="section section-content section-404">
        <div class="container container-404">
        <div class="container">
            <div class="block-404">
                <h1><?php pll_e('Page not found', 'baza'); ?></h1>
                <p><?php pll_e('The address is incorrectly entered or this page no longer exists on the site', 'baza'); ?>.</p>
                <div class="return-to">
                    <a class="button go-home" href="<?php echo esc_url(home_url()); ?>">
                        <?php pll_e('Return to main page', 'baza'); ?>
                    </a>
                </div>
            </div>
        </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
