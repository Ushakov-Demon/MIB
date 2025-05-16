<?php

// $post_ID                = get_the_ID();
// $activity               = get_post_meta( $post_ID, '_st_activity', true );
// $status                 = get_post_meta( $post_ID, '_st_status', true );
// $city                   = get_post_meta( $post_ID, '_st_city', true );
// $positions_in_companies = get_post_meta( $post_ID, '_st_positions_in_companies', true );
// $image_id               = get_post_thumbnail_id();
// $image_url              = wp_get_attachment_url( $post_ID );
// $image_alt              = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
// $companies              = wp_get_post_terms( $post_ID, 'companies' );
// $content                = apply_filters( 'the_content', get_the_content() );

$post_ID  = get_the_ID();
$position = get_post_meta( $post_ID, '_st_positions_in_companies', true );
$courses  = apply_filters( 'mib_get_posts_relationships', array( 'post_type' => 'students', 'post_id' => $post_ID, 'field' => 'tr_program_students' ) );
$activity = get_post_meta( $post_ID, '_st_activity', true );
$status   = get_post_meta( $post_ID, '_st_status', true );
$city     = get_post_meta( $post_ID, '_st_city', true );

get_header();
?>

<main id="primary" class="site-main">

    <?php display_breadcrumbs(); ?>

    <div class="container-student">

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

                    <div class="completed">
                        <?php
                        if ( ! empty( $courses ) ) :
                            ?>
                            <div class="label">
                                <?php pll_e('Completed', 'baza'); ?>:
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
                            <?php
                        endif;
                        ?>
                    </div>
                </div>
            </div>

            <div class="student-info">
                <div class="items">
                    <?php if (!empty($activity)) : ?>
                        <div class="item student-activity">
                            <i class="icon-suitcase"></i>
                            <div class="label"><?php echo pll__('Activity'); ?></div>
                            <div class="value"><?php echo pll__($activity); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($status)) : ?>
                        <div class="item student-status">
                            <i class="icon-user-tie"></i>
                            <div class="label"><?php echo pll__('Status'); ?></div>
                            <div class="value"><?php echo pll__($status); ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($city)) : ?>
                        <div class="item student-city">
                            <i class="icon-city"></i>
                            <div class="label"><?php echo pll__('City'); ?></div>
                            <div class="value"><?php echo pll__($city); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (get_the_content()) : ?>
                <?php apply_filters( 'the_content', the_content() ); ?>
            <?php endif; ?>

            <?php echo share_article_buttons(); ?>

            <?php include get_template_directory() . '/template-parts/sections/actuality_previews-section.php'; ?>
            
        </div>
    </div>

</main>

<?php
get_footer();