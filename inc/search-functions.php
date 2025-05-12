<?php
/**
 * Advanced search function for multiple post types
 */
function mib_search_posts($search_query, $post_type = 'all', $posts_per_page = -1) {
    $args = array(
        'post_status' => 'publish',
        's' => $search_query,
        'posts_per_page' => $posts_per_page,
        'no_found_rows' => true,
        'update_post_meta_cache' => true,
        'update_post_term_cache' => true,
    );
    
    $all_post_types = array('programs', 'post', 'events', 'teachers', 'students');
    
    if ($post_type !== 'all' && in_array($post_type, $all_post_types)) {
        $args['post_type'] = $post_type;
    } else {
        $args['post_type'] = $all_post_types;
    }
    
    return new WP_Query($args);
}

/**
 * Get search result counts for each post type
 */
function mib_get_search_counts($search_query) {
    $post_types = array(
        'programs' => array(
            'type' => 'programs',
            'label' => pll__('Study programs', 'baza'),
            'count' => 0
        ),
        'post' => array(
            'type' => 'post',
            'label' => pll__('News', 'baza'),
            'count' => 0
        ),
        'events' => array(
            'type' => 'events',
            'label' => pll__('Events', 'baza'),
            'count' => 0
        ),
        'teachers' => array(
            'type' => 'teachers',
            'label' => pll__('Teachers', 'baza'),
            'count' => 0
        ),
        'students' => array(
            'type' => 'students',
            'label' => pll__('Students', 'baza'),
            'count' => 0
        )
    );
    
    foreach ($post_types as $key => $post_type) {
        $query = new WP_Query(array(
            'post_type' => $post_type['type'],
            'post_status' => 'publish',
            's' => $search_query,
            'posts_per_page' => -1,
            'fields' => 'ids',
            'no_found_rows' => false
        ));
        
        $post_types[$key]['count'] = $query->found_posts;
        wp_reset_postdata();
    }
    
    return $post_types;
}

/**
 * Get template for specific post type
 */
function mib_get_search_item_template($post_type) {
    $templates = array(
        'programs' => '/template-parts/blocks/block-item.php',
        'post' => '/template-parts/blocks/news-item.php',
        'events' => '/template-parts/blocks/news-item.php',
        'teachers' => '/template-parts/blocks/block-person-item.php',
        'students' => '/template-parts/blocks/block-person-item.php'
    );
    
    return $templates[$post_type] ?? '/template-parts/blocks/default-item.php';
}
