<?php
get_header();
$post_ID                = get_the_ID();
$activity               = get_post_meta( $post_ID, '_st_activity', true );
$status                 = get_post_meta( $post_ID, '_st_status', true );
$city                   = get_post_meta( $post_ID, '_st_city', true );
$positions_in_companies = get_post_meta( $post_ID, '_st_positions_in_companies', true );
$image_id               = get_post_thumbnail_id();
$image_url              = wp_get_attachment_url( $post_ID );
$image_alt              = get_post_meta( $post_ID, '_wp_attachment_image_alt', true );
$courses                = apply_filters( 'mib_get_posts_relationships', array( 'post_type' => 'students', 'post_id' => $post_ID, 'field' => 'tr_program_students' ) );
$companies              = wp_get_post_terms( $post_ID, 'companies' );
$content                = apply_filters( 'the_content', get_the_content() );

get_footer();