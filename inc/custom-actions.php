<?php
add_filter( 'mib_get_posts'                         , 'mib_get_posts', 10 );
add_filter( 'mib_get_alternating_posts'             , 'mib_get_alternating_posts', 10 );
add_action( 'wp_ajax_custom_post_type_filter'       , 'mib_custom_post_type_filter' );
add_action( 'wp_ajax_nopriv_custom_post_type_filter', 'mib_custom_post_type_filter' );
add_filter( 'mib_get_posts_list_options'            , 'mib_get_posts_list_options' );
add_filter( 'mib_get_posts_relationships'           , 'mib_get_posts_relationships' );

/**
 * @param array|string $post_type optional. Default 'post'.
 * @param int $per_page optional. Defaut 'posts_per_page' option.
 * @param int $page optional. Default 1.
 * 
 * @return object WP_Query
 */
function mib_get_posts( $post_type = 'post', int $per_page = 0, int $page = 1, $post_status = 'publish' ) {
    if ( 0 == $per_page ) {
        $per_page = get_option( 'posts_per_page' );
    }

    $posts_q_args = [
        'post_type'      => $post_type,
        'post_status'    => $post_status,
        'order_by'       => 'date',
        'order'          => 'DESC',
        'posts_per_page' => $per_page,
        'paged'          => $page,
    ];

    if ( function_exists( 'pll_current_language' ) && ! empty( pll_current_language() ) ) {
        $posts_q_args['lang'] = pll_current_language();
    }

    $posts = new WP_Query( $posts_q_args );

    wp_reset_postdata();

    return $posts;
}

/**
* Gets posts of type 'post' and 'programs' alternately.
*
* @param int $per_page Number of posts of each type per page. Defaults to 'posts_per_page'.
* @param int $page Current page. Defaults to 1.
*
* @return array Array of WP_Post objects where 'post' and 'programs' posts alternate.
*/
function mib_get_alternating_posts( int $per_page = 0, int $page = 1 ): array {
    if ( 0 == $per_page ) {
        $per_page = get_option( 'posts_per_page' );
    }

    $post_posts = new WP_Query( [
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'posts_per_page' => $per_page,
        'paged'          => $page,
    ] );

    $program_posts = new WP_Query( [
        'post_type'      => 'events',
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'posts_per_page' => $per_page,
        'paged'          => $page,
    ] );

    $alternating_posts = [];
    $i = 0;
    $j = 0;

    while ( $i < count( $post_posts->posts ) || $j < count( $program_posts->posts ) ) {
        if ( isset( $post_posts->posts[ $i ] ) ) {
            $alternating_posts[] = $post_posts->posts[ $i ];
            $i++;
        }
        if ( isset( $program_posts->posts[ $j ] ) ) {
            $alternating_posts[] = $program_posts->posts[ $j ];
            $j++;
        }
    }

    wp_reset_postdata();

    return $alternating_posts;
}

function mib_custom_post_type_filter(){
    if ( ! isset( $_POST['filterTaget'] ) || ! isset( $_POST['perPage'] ) ) return;

    $current   = isset( $_POST['currentPage'] ) ?? $_POST['currentPage'];
    $post_type = false;
    $posts     = false;
    $per_page  = intval( $_POST['perPage'] );
    $output    = "";

    switch ( $_POST['filterTaget'] ) {
        case "news" :
            $post_type = "post";
            break;
        case "events" :
            $post_type = "events";
            break;
        case "all" :
            $post_type = false;
            break;    
        default :
            $post_type = $_POST['filterTaget'];
    }

    if ( $post_type ) {
        $query = mib_get_posts( $post_type, $per_page );

        if ( $query->have_posts() ) {
            $posts = $query->posts;
        }
    } else {
        $posts = mib_get_alternating_posts( $per_page );
    }

    if ( ! empty( $posts ) ) {
        ob_start();
        foreach ( $posts as $item ) :
            $post_ID        = $item->ID;
            $post_type      = $item->post_type;
            $shedule_date   = 'events' == $post_type ? get_post_meta( $item->ID, '_event_shedule_date', true ) : '';
            $thumbnail      = get_the_post_thumbnail_url( $item->ID );
            $title          = $item->post_title;
            $excerpt        = $item->post_excerpt;
            $permalink      = get_the_permalink( $item->ID );

            include get_template_directory() . '/template-parts/blocks/news-item.php';
        endforeach;
        $output = ob_get_clean();
    }

    wp_send_json( $output );
}

function mib_get_posts_list_options( $post_type ) {
    $posts = mib_get_posts( $post_type, -1 );
    $out   = [
        '' => __( 'Select page' ),
    ];
    if ( $posts->posts && ! empty( $posts->posts ) ) {
        foreach( $posts->posts as $post ) {
            $out[$post->ID] = $post->post_title;
        }
    }

    return $out;
}

/**
 * @param array $args  Must have items : 
 * int||str 'post_id' - ID current post, 
 * str 'post_type' - corrent post_type , 
 * str 'to_post_type' - The type of post in which we are looking for an occurrence, 
 * str 'field' - The name of the field in which we are looking for an entry
 */
function mib_get_posts_relationships( $args ) {
    extract( $args );

    if ( ! isset( $to_post_type ) ) {
        $to_post_type = 'programs';
    }

    $search_value = sprintf( 'post:%s:%d', $post_type, $post_id );
    $search_array = array( 'value' => $search_value, 'id' => $post_id, 'type' => 'post', 'subtype' => $post_type );

    $params = [
        'post_type'  => $to_post_type,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key'     => $field,
                'value'   => serialize( array( $search_array ) ),
                'compare' => 'LIKE',
            ),
            array(
                'key'     => $field,
                'value'   => $search_value,
                'compare' => 'LIKE',
            ),
        ),
    ];

    return get_posts( $params );
}
