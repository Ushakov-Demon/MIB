<?php

// $post_ID                = get_the_ID();
// $positions_in_companies = get_post_meta( $post_ID, '_positions_in_companies', true );
// $reviwe_message         = get_post_meta( $post_ID, '_teach_review_message', true );
// $content                = apply_filters( 'the_content', get_the_content() );

$post_ID  = get_the_ID();
$position = get_post_meta( $post_ID, '_positions_in_companies', true );
$courses  = apply_filters( 'mib_get_posts_relationships', array( 'post_type' => 'teachers', 'post_id' => $post_ID, 'field' => 'tr_program_teachers' ) );

get_header();
?>

<main id="primary" class="site-main">

    <?php display_breadcrumbs(); ?>

    <div class="container-teacher">

        <div class="content">

            <div class="single-header">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="photo">
                        <?php the_post_thumbnail( 'medium' ); ?>
                    </div>
                <?php endif; ?>

                <div class="single-header-content">
                    <h1><?php echo get_the_title(); ?></h1>

                    <?php if($position): ?>
                        <div class="position">
                            <?php echo $position; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php
            if ( ! empty( $courses ) ) :
                ?>
                <div class="completed">
                    <div class="label">
                        <?php pll_e('Courses', 'baza'); ?>:
                    </div>

                    <div class="completed-items">
                        <?php
                        foreach ( $courses as $course ) :
                            $course_href = get_the_permalink( $course->ID );
                            ?>
                            <a class="completed-item" href="<?php echo $course_href?>">
                                <?php
                                echo $course->post_title;
                                ?>
                            </a>
                            <?php
                        endforeach;
                        ?>
                    </div>
                </div>
                <?php
            endif;
            ?>

            <?php if (get_the_content()) : ?>
                <?php apply_filters( 'the_content', the_content() ); ?>
            <?php endif; ?>
            
        </div>
    </div>

</main>

<?php
get_footer();