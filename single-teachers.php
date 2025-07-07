<?php

// $post_ID                = get_the_ID();
// $positions_in_companies = get_post_meta( $post_ID, '_positions_in_companies', true );
// $reviwe_message         = get_post_meta( $post_ID, '_teach_review_message', true );
// $content                = apply_filters( 'the_content', get_the_content() );

$post_ID   = get_the_ID();
$position  = get_post_meta( $post_ID, '_positions_in_companies', true );
$courses   = apply_filters( 'mib_get_posts_relationships', array( 'post_type' => 'teachers', 'post_id' => $post_ID, 'field' => 'tr_program_teachers' ) );
$companies = get_the_terms( $post_ID, 'companies' );

$main_bottom_text = '';
$main_bottom_second_text = '';

$main_top_heading_text = false;
$main_top_version      = 'white version-teachers';

if ( has_post_thumbnail() ) {
    $main_top_heading_media_before_text = get_post_thumbnail_id();
}

$main_bottom_text .= '<div class="section-title">' . get_the_title() . '</div>';
$main_bottom_text .= '<div class="position">' . $position. '</div>';

if ( ! empty( $companies ) && ! is_wp_error( $companies ) ) {
    $main_bottom_text .= '<div class="logos">';

    foreach ( $companies as $company ) {
        $company_logo_id = get_term_meta( $company->term_id, '_company_logo', true );
        $logo_src = wp_get_attachment_image_url( $company_logo_id, 'full' );

        if ( $logo_src ) {
            $main_bottom_text .= '<img src="' . esc_url( $logo_src ) . '" alt="' . esc_attr( $company->name ) . '">';
        }
    }

    $main_bottom_text .= '</div>';
}

if ( ! empty( $courses ) ) {
    $main_bottom_second_text .= '<div class="completed">';
    $main_bottom_second_text .= '<div class="label">' . pll__('Programs', 'baza') . ':</div>';
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

    <div class="container-teacher">

        <div class="content">

            <?php if (get_the_content()) : ?>
                <?php apply_filters( 'the_content', the_content() ); ?>
            <?php endif; ?>
            
        </div>
    </div>

</main>

<?php
get_footer();