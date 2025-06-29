<?php
add_filter( 'mib_get_posts'                         , 'mib_get_posts', 10 );
add_filter( 'mib_get_alternating_posts'             , 'mib_get_alternating_posts', 10 );
add_action( 'wp_ajax_custom_post_type_filter'       , 'mib_custom_post_type_filter' );
add_action( 'wp_ajax_nopriv_custom_post_type_filter', 'mib_custom_post_type_filter' );
add_filter( 'mib_get_posts_list_options'            , 'mib_get_posts_list_options' );
add_filter( 'mib_get_posts_relationships'           , 'mib_get_posts_relationships' );
add_filter( 'mib_has_gutenberg_block'               , 'mib_has_gutenberg_block', 10, 2 );
add_filter( 'mib_get_course_categories'             , 'mib_get_course_categories' );
add_filter( 'mib_get_array_by_option'               , 'mib_get_array_by_option', 10, 2 );

/**
 * @param array|string $post_type optional. Default 'post'.
 * @param int $per_page optional. Defaut 'posts_per_page' option.
 * @param int $page optional. Default 1.
 * 
 * @param array $tax_params. Must by contains array params for tax_query
 * @see https://developer.wordpress.org/reference/classes/wp_query/#taxonomy-parameters
 * 
 * @return object WP_Query
 */
function mib_get_posts( $post_type = 'post', int $per_page = 0, int $page = 1, array $tax_params = [], $post_status = 'publish' ) {
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

    if ( is_tax() ) {
        $current_taxonomy_term = get_queried_object();
        
        $posts_q_args['tax_query'] = array(
            array(
                'taxonomy' => $current_taxonomy_term->taxonomy,
                'field'    => 'term_id',
                'terms'    => $current_taxonomy_term->term_id,
            ),
        );
    }

    if ( ! empty( $tax_params ) ) {
        $posts_q_args['tax_query'] = $tax_params;
    };

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
function mib_get_alternating_posts( int $per_page = 0, int $page = 1 ) : array {
    if ( 0 == $per_page ) {
        $per_page = get_option( 'posts_per_page' );
    }

    if ( 0 > ( $per_page % 2 ) ) {
        $per_page += 1;
    }

    $post_posts = new WP_Query( [
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'posts_per_page' => $per_page/2,
        'paged'          => $page,
    ] );

    $program_posts = new WP_Query( [
        'post_type'      => 'events',
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'posts_per_page' => $per_page/2,
        'paged'          => $page,
    ] );

    $max_pages = [
        $post_posts->max_num_pages,
        $program_posts->max_num_pages,
    ];

    $alternating_posts = [];
    $i = 0;
    $j = 0;

    $alternating_posts['max_num_pages'] = max( $max_pages );
    $alternating_posts['page']          = $page;

    while ( $i < count( $post_posts->posts ) || $j < count( $program_posts->posts ) ) {
        if ( isset( $post_posts->posts[ $i ] ) ) {
            $alternating_posts['posts'][] = $post_posts->posts[ $i ];
            $i++;
        }
        if ( isset( $program_posts->posts[ $j ] ) ) {
            $alternating_posts['posts'][] = $program_posts->posts[ $j ];
            $j++;
        }
    }

    wp_reset_postdata();

    return $alternating_posts;
}

function mib_custom_post_type_filter(){
    if ( ! isset( $_POST['filterTaget'] ) || ! isset( $_POST['perPage'] ) ) return;

    $current   = isset( $_POST['pageId'] ) ?? $_POST['pageId'];
    $post_type = false;
    $posts     = false;
    $per_page  = intval( $_POST['perPage'] );
    $output    = "";
    $page_num  = $_POST['pageNum'];

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
        $cats_param = [];
        if ( isset( $_POST['filterCats'] ) && isset( $_POST['filterCats']['term'] ) && isset( $_POST['filterCats']['operator'] ) ) {
            $cats_param = [
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => [intval( $_POST['filterCats']['term'] )],
                'operator' => $_POST['filterCats']['operator'],
            ];
        }
        $query = mib_get_posts( $post_type, $per_page, $page_num, $cats_param );

        if ( $query->have_posts() ) {
            $posts = $query->posts;
        }
    } else {
        $res   = mib_get_alternating_posts( $per_page, $page_num );
        $posts = $res["posts"];
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

        if ( isset( $_POST['isPaginavi'] ) && 'true' == $_POST['isPaginavi']  ) {
            include get_template_directory() . '/template-parts/blocks/block-show-more.php';
        }
        $output = ob_get_clean();
    }

    wp_send_json( $output );
}

function mib_get_posts_list_options( $post_types ) {

    $post_types = ['page', 'programs', 'accreditations', 'teachers', 'students', 'members'];

    if ( is_string( $post_types ) ) {
        $post_types = array_map( 'trim', explode( ',', $post_types ) );
    }
    
    if ( ! is_array( $post_types ) ) {
        $post_types = [ $post_types ];
    }
    
    $out = [
        '' => __( 'Select page' ),
    ];
    
    foreach ( $post_types as $post_type ) {
        $post_type = trim( $post_type );
        
        if ( empty( $post_type ) ) {
            continue;
        }
        
        $posts = mib_get_posts( $post_type, -1 );
        
        if ( $posts->posts && ! empty( $posts->posts ) ) {
            $post_type_object = get_post_type_object( $post_type );
            $post_type_label = $post_type_object ? $post_type_object->labels->singular_name : ucfirst( $post_type );
            
            foreach( $posts->posts as $post ) {
                $out[$post->ID] = sprintf( 
                    __( '%s: %s' ), 
                    $post_type_label, 
                    $post->post_title 
                );
            }
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

/**
* Checks if the specified Gutenberg block is present in the content.
*
* @param string $content The page content string.
* @param string $block_name The name of the block to look for (e.g. 'main-top-variative' or 'main-top' ...).
* @return bool True if the block is found, false otherwise.
*/
function mib_has_gutenberg_block( string $content, string $block_name ) {
    $escaped_block_name = str_replace( '/', '\\/', $block_name );
    $pattern            = sprintf( '/%s/', $escaped_block_name );

    return (bool) preg_match( $pattern, $content );
}

function mib_get_course_categories() {
    $args = [
        'hide_empty' => true,
        'taxonomy'   => 'program_category',
    ];

    return get_terms( $args );
}

function mib_get_posts_categories() {
    $args = [
        'hide_empty' => true,
        'taxonomy'   => 'category',
    ];

    return get_terms( $args );
}

/**
 * Make options array for select, by custom theme option value
 * Theme option must by create in Carbon Fields , and must have type 'complex'
 * 
 * @param string $option_name: option name
 * @param string $item_key: item key name
 * 
 * @return array
 */
function mib_get_array_by_option( string $option_name, string $item_key ) : array {
    $options = carbon_get_theme_option( $option_name );

    $out = [ '' => __( 'Select an option' ) ];

    if ( is_array( $options ) ) {
        foreach ( $options as $option ) {
            $out[$option[$item_key]] = $option[$item_key];
        }
    }
    return $out;
}

/**
 * Shows the time interval from now until the specified time.
 * @param string $date_from, expects date in string format
 * 
 * @return array , days and months difference
 */
function mib_get_time_difference( string $date_from ) : array {
    $default_date_format = get_option( 'date_format' );
    $now                 = date( $default_date_format );
    $now_u               = strtotime( $now );

    $date_from_u         = strtotime( $date_from );
    $times_difference_u  = $date_from_u - $now_u;
    $days_difference     = $times_difference_u / ( 60 * 60 * 24 );

    $out = [
        'unix_input_date' => $date_from_u,
        'days'            => floor( $days_difference ),
        'months'          => 0,
    ];

    if ( 0 < ( floor( $days_difference / 30 ) ) ) {
        $out['months'] = round( $days_difference / 30, 1 );
    }

    return $out;
}

function mib_get_course_price( int $course_id ) {
    $reg_price                  = get_post_meta( $course_id, '_tr_program_regular_price', true );
    $price_currency             = get_post_meta( $course_id, '_tr_program_price_currency', true );
    $price_label                = get_post_meta( $course_id, '_tr_program_regular_price_label', true );
    $reg_price_info             = get_post_meta( $course_id, '_tr_program_regular_price_info', true );
    $sale_price                 = get_post_meta( $course_id, '_tr_program_sale_price', true );
    $additional_price           = get_post_meta( $course_id, '_tr_program_additional_price', true );
    $excerpt                    = get_the_excerpt( $course_id );
    $sale_price_date_end        = get_post_meta( $course_id, '_tr_program_sale_price_date_end', true );
    $additional_price_currency  = get_post_meta( $course_id, '_tr_program_additional_price_currency', true );
    $time_difference            = ! empty( $sale_price_date_end ) ? mib_get_time_difference( $sale_price_date_end ) : ['days' => -1] ;
    $label                      = pll__( 'Total amount', 'baza' );
    $currensy                   = get_post_meta( $course_id, '_tr_program_price_currency', true ) ?? __( 'UAH', 'baza' );
    
    $main_price = $reg_price;
    $old_price  = false;

    $reg_price_info_title = "";
    $price_label_html     = "";

    if ( ! empty( $reg_price_info ) ) {
        $reg_price_info_title = "<i class='icon-info' data-title='{$reg_price_info}'></i> ";
    }

    if ( ! empty( $price_label ) ) {
        $price_label_html = "<span class='price-label'>{$price_label}</span>";
    }

    if ( ! empty( $sale_price ) &&
         intval( $sale_price ) < intval( $reg_price ) &&
         0 < $time_difference['days']
        ) {
            $main_price = $sale_price;
            $old_price  = $reg_price; 
        };

    $price_html            = "<span class='price'>{$main_price} {$currensy}</span>" ;
    $old_price_html        = $old_price ? "<span class='old-price'>{$old_price} {$currensy}</span>" : '';
    $additional_price_html = ! empty ( $additional_price ) ? "<span class='additional-price'>+{$additional_price} {$additional_price_currency}</span>" : '';

    $html = "<div class='prices'>
                <div class='label'>{$label}{$reg_price_info_title}</div>
                <div class='prices-items'>
                    {$price_html}
                    {$price_label_html}
                    {$old_price_html}
                    {$additional_price_html}
                </div>
            </div>";

    return $html;  
}

function mib_get_course_categories_options() {
    $out = [
        '' => __( '-- Select category --' ),
    ];

    $cats = mib_get_course_categories();

    return $cats;
}

function mib_get_posts_categories_options() {
    $cats = mib_get_posts_categories();

    $out = [
        '' => __( '-- Select category --' ),
    ];

    foreach ( $cats as $term ) {
        $out[$term->term_id] = $term->name;
    }

    return $out;
}
