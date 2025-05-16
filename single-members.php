<?php

$post_ID  = get_the_ID();
$position = get_post_meta( $post_ID, '_position', true );

get_header();
?>

<main id="primary" class="site-main">

    <?php display_breadcrumbs(); ?>

    <div class="container-member">

        <?php if ( has_post_thumbnail() ) : ?>
            <div class="photo">
                <?php the_post_thumbnail( 'large' ); ?>
            </div>
        <?php endif; ?>

        <div class="content">
            <div class="single-header">
                <h1><?php echo get_the_title(); ?></h1>

                <?php if($position): ?>
                    <div class="position">
                        <?php echo $position; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (get_the_content()) : ?>
                <?php apply_filters( 'the_content', the_content() ); ?>
            <?php endif; ?>
        </div>
    </div>

</main>

<?php
get_footer();