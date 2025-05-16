<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package baza
 */

?>

<main id="main" class="site-main page-404">
    <?php display_breadcrumbs(); ?>

    <section class="section section-404">
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
    </section>
</main>
