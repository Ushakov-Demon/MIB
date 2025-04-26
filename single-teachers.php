<?php
get_header();
$post_ID                = get_the_ID();
$positions_in_companies = carbon_get_post_meta( $post_ID, 'positions_in_companies' );
$content                = apply_filters( 'the_content', get_the_content() );

echo $positions_in_companies;

get_footer();
