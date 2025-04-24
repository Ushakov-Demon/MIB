<?php
add_filter( 'mib_get_posts', 'mib_get_posts', 10 );

function mib_get_posts( string $post_type = 'post', int $per_page = 0, int $page = 1 ) {
    if ( 0 == $per_page ) {
        $per_page = get_option( 'posts_per_page' );
    }

    $posts_q_args = [
        'post_type'      => $post_type,
        'post_status'    => 'publish',
        'order_by'       => 'date',
        'order'          => 'DESC',
        'posts_per_page' => $per_page,
        'paged'          => $page,
    ];

    $posts = new WP_Query( $posts_q_args );

    wp_reset_postdata();

    return $posts;
}