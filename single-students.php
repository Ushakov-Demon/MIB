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

$post_ID           = get_the_ID();
$position          = get_post_meta( $post_ID, '_st_positions_in_companies', true );
$courses           = apply_filters( 'mib_get_posts_relationships', array( 'post_type' => 'students', 'post_id' => $post_ID, 'field' => 'tr_program_students' ) );
$gender            = get_post_meta( $post_ID, '_st_gender', true );
$year_graduation   = get_post_meta( $post_ID, '_st_year_graduation', true );
$activity          = get_post_meta( $post_ID, '_st_activity', true );
$status            = get_post_meta( $post_ID, '_st_status', true );
$city              = get_post_meta( $post_ID, '_st_city', true );

$main_bottom_text = '';
$main_bottom_second_text = '';

$main_top_heading_text = false;
$main_top_version      = 'white version-teachers';

if ( has_post_thumbnail() ) {
    $main_top_heading_media_before_text = get_post_thumbnail_id();
}

$main_bottom_text .= '<div class="section-title">' . get_the_title() . '</div>';
$main_bottom_text .= '<div class="position">' . $position. '</div>';

if ( ! empty( $courses ) ) {
    $main_bottom_second_text .= '<div class="completed">';
    $main_bottom_second_text .= '<div class="label">' . 
    ( 'man' == $gender ? pll__('Completed', 'baza') : pll__( 'She graduated', 'baza' ) ) . 
    ':</div>';
    $main_bottom_second_text .= '<div class="completed-items">';

    foreach ( $courses as $course ) {
        $course_href = get_the_permalink( $course->ID );
        $course_title = $course->post_title;

        $main_bottom_second_text .= '<a class="completed-item" href="' . esc_url( $course_href ) . '">'
                            . esc_html( $course_title ) . '</a>';
    }

    $main_bottom_second_text .= '</div></div>';
}

get_header();
?>

<main id="primary" class="site-main">

    <?php include get_template_directory() . '/template-parts/sections/hero-section.php'; ?>

    <div class="container-student">

        <div class="content">
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