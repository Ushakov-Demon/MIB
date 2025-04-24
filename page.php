<?php
get_header();
$is_home = is_front_page();
?>

<main id="primary" class="site-main<?php if(!$is_home): ?> site-page<?php endif; ?>">

    <div class="breadcrumb-container">
        <div class="container">
            <?php
                if ( function_exists('yoast_breadcrumb') ) {
                    yoast_breadcrumb( '<div id="breadcrumbs">','</div>' );
                }
            ?>
        </div>
    </div>

    <div class="header-title">
        <div class="container">
            <h1><?php the_title(); ?></h1>
        </div>
    </div>
    
    <?php if (get_the_content()) : ?>
        <?php the_content(); ?>
    <?php endif; ?>

</main>

<?php
get_footer();