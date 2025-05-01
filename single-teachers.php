<?php
get_header();
$post_ID                = get_the_ID();
$positions_in_companies = get_post_meta( $post_ID, '_positions_in_companies', true );
$reviwe_message         = get_post_meta( $post_ID, '_teach_reviwe_message', true );
$content                = apply_filters( 'the_content', get_the_content() );

echo $positions_in_companies;

get_footer();
