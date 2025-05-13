<?php

$post_ID                = get_the_ID();
$positions_in_companies = get_post_meta( $post_ID, '_positions_in_companies', true );
// $reviwe_message         = get_post_meta( $post_ID, '_teach_review_message', true );
// $content                = apply_filters( 'the_content', get_the_content() );

get_header();
?>

<main id="primary" class="site-main">

    <?php display_breadcrumbs(); ?>

    <div class="single-teacher">

        <?php if ( has_post_thumbnail() ) : ?>
            <div class="photo">
                <?php the_post_thumbnail( 'large' ); ?>
            </div>
        <?php endif; ?>

        <div class="content">
            <div class="single-teacher-header">
                <h1><?php echo get_the_title(); ?></h1>

                <?php if($positions_in_companies): ?>
                    <div class="position">
                        <?php echo $positions_in_companies; ?>
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