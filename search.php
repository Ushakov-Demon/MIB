<?php 
get_header(); 

// Page IDs for each post type
// TODO: Need add to settings
$programs_page_id = 148;
$news_page_id = 153;
$events_page_id = 155;
$teachers_page_id = 20; 
$students_page_id = 22;

// Number of posts to show per type when viewing all results
// TODO: Need add to settings
$posts_per_type_all = array(
    'programs' => 5,
    'post' => 6,
    'events' => 6,
    'teachers' => 5,
    'students' => 4,
);

// View all texts for each post type
$view_all_texts = array(
    'programs' => pll__('All programs', 'baza'),
    'post' => pll__('All news', 'baza'),
    'events' => pll__('All events', 'baza'),
    'teachers' => pll__('All teachers', 'baza'),
    'students' => pll__('All students', 'baza'),
);

// Group headers for search results
$group_headers = array(
    'programs' => pll__('Programs', 'baza'),
    'post' => pll__('News', 'baza'),
    'events' => pll__('Events', 'baza'),
    'teachers' => pll__('Teachers', 'baza'),
    'students' => pll__('Students', 'baza'),
);

// Function to get correct page URL with Polylang support
function get_post_type_page_url($page_id, $post_type) {
    $current_lang = function_exists('pll_current_language') ? pll_current_language() : false;
    $translated_page_id = function_exists('pll_get_post') ? pll_get_post($page_id, $current_lang) : $page_id;
    return get_permalink($translated_page_id);
}

// Function to get "Show more" URL for specific post type
function get_show_more_url($search_query, $post_type) {
    return home_url('/?s=' . urlencode($search_query) . '&post_type=' . $post_type);
}

// Get search parameters
$search_query = get_search_query();
$current_post_type = isset($_GET['post_type']) ? sanitize_text_field($_GET['post_type']) : 'all';
$posts_per_page = -1; // Show all posts without pagination

// Get search counts for sidebar
$search_counts = mib_get_search_counts($search_query);
?>

<main id="primary" class="site-main">
    <?php display_breadcrumbs(); ?>
    
    <div class="search-container">
        <?php if (!empty($search_query)) : ?>
            <div class="search-header">
                <h1 class="search-title">
                    <?php echo pll__('Search results', 'baza') . ' <span>' . esc_html($search_query) . '</span>'; ?>
                </h1>
            </div>
            
            <div class="search-content">
                
                <!-- Sidebar with filters -->
                <div class="search-sidebar">
                    <div class="search-filters">
                        <h3><?php echo pll__('Filter by type'); ?></h3>
                        <ul class="filter-list">
                            <li>
                                <a href="<?php echo home_url('/?s=' . urlencode($search_query)); ?>" 
                                   class="filter-link<?php echo ($current_post_type === 'all') ? ' active' : ''; ?>">
                                    <?php echo pll__('All results', 'baza'); ?>
                                    <span class="filter-count">
                                        <?php echo array_sum(array_column($search_counts, 'count')); ?>
                                    </span>
                                </a>
                            </li>
                            <?php foreach ($search_counts as $post_type => $data) : ?>
                                <?php if ($data['count'] > 0) : ?>
                                    <li>
                                        <a href="<?php echo home_url('/?s=' . urlencode($search_query) . '&post_type=' . $post_type); ?>" 
                                           class="filter-link<?php echo ($current_post_type === $post_type) ? ' active' : ''; ?>">
                                            <?php echo $data['label']; ?>
                                            <span class="filter-count"><?php echo $data['count']; ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                
                <!-- Main content -->
                <div class="search-results">
                    <?php 
                    // Get search results
                    if ($current_post_type === 'all') {
                        // For 'all' results, get custom amount of posts per type
                        $grouped_posts = array();
                        $post_types_to_search = array('programs', 'post', 'events', 'teachers', 'students');
                        
                        foreach ($post_types_to_search as $post_type) {
                            if ($search_counts[$post_type]['count'] > 0) {
                                // Get custom count for this post type
                                $count_for_type = isset($posts_per_type_all[$post_type]) ? $posts_per_type_all[$post_type] : 4;
                                $search_results_type = mib_search_posts($search_query, $post_type, $count_for_type);
                                
                                if ($search_results_type->have_posts()) {
                                    $grouped_posts[$post_type] = array();
                                    while ($search_results_type->have_posts()) {
                                        $search_results_type->the_post();
                                        $grouped_posts[$post_type][] = get_the_ID();
                                    }
                                    wp_reset_postdata();
                                }
                            }
                        }
                    } else {
                        // For specific type, get ALL posts without pagination
                        $search_results = mib_search_posts($search_query, $current_post_type, -1);
                        
                        $grouped_posts = array();
                        
                        if ($search_results->have_posts()) {
                            while ($search_results->have_posts()) {
                                $search_results->the_post();
                                $post_type = get_post_type();
                                
                                if (!isset($grouped_posts[$post_type])) {
                                    $grouped_posts[$post_type] = array();
                                }
                                
                                $grouped_posts[$post_type][] = get_the_ID();
                            }
                            wp_reset_postdata();
                        }
                    }
                    
                    // Display grouped posts
                    if (!empty($grouped_posts)) {
                        foreach ($grouped_posts as $post_type => $post_ids) {
                            // Add header before each group (only when showing all results)
                            if ($current_post_type === 'all' && isset($group_headers[$post_type])) {
                                echo '<h3 class="search-group-header">' . esc_html($group_headers[$post_type]) . '</h3>';
                            }
                            
                            $items_class = 'search-' . $post_type . '-items';
                            echo '<div class="' . esc_attr($items_class) . '">';
                            
                            foreach ($post_ids as $post_id) {
                                $post = get_post($post_id);
                                setup_postdata($post);
                                
                                $post_ID = get_the_ID();
                                $post_type = get_post_type();
                                
                                // Skip programs that are announcing
                                if ($post_type === 'programs') {
                                    $is_announcing = 'yes' == get_post_meta($post_ID, '_tr_program_is_announce', true);
                                    if ($is_announcing) {
                                        continue;
                                    }
                                }

                                $template_path = mib_get_search_item_template($post_type);
                                
                                // Prepare variables for different post types
                                switch ($post_type) {
                                    case 'programs':
                                        $title = get_the_title();
                                        $post_permalink = get_the_permalink();
                                        $image = get_post_meta($post_ID, '_tr_program_icon', true);
                                        $desc = get_the_excerpt($post_ID);
                                        $is_announcing = 'yes' == get_post_meta($post_ID, '_tr_program_is_announce', true);
                                        $announcing = $is_announcing ? ' pending' : '';
                                        break;

                                    case 'post':
                                    case 'events':
                                        $post = get_post($post_ID);
                                        $permalink = get_permalink($post_ID);
                                        $title = get_the_title($post_ID);
                                        $excerpt = get_the_excerpt($post_ID);
                                        $shedule_date = get_post_meta($post_ID, '_event_shedule_date', true);
                                        $timestamp = strtotime($shedule_date);
                                        $date_format = get_option('date_format');
                                        $time_format = get_option('time_format');
                                        $shedule_date_formatted = wp_date($date_format, $timestamp);
                                        $shedule_time = wp_date($time_format, $timestamp);
                                        break;
                                        
                                    case 'teachers':
                                        $item_id = get_the_ID();
                                        $image_id = get_post_thumbnail_id();
                                        $image_url = wp_get_attachment_url($image_id);
                                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                                        $title = get_the_title();
                                        $position = get_post_meta($item_id, '_positions_in_companies', true);
                                        $companies = wp_get_post_terms($item_id, 'companies');
                                        break;
                                        
                                    case 'students':
                                        $item_id = get_the_ID();
                                        $image_id = get_post_thumbnail_id();
                                        $image_url = wp_get_attachment_url($image_id);
                                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                                        $title = get_the_title();
                                        $position = get_post_meta($item_id, '_st_positions_in_companies', true);
                                        $reviwe_message = get_post_meta($item_id, '_st_review_message', true);
                                        $courses = apply_filters('mib_get_posts_relationships', array('post_type' => 'students', 'post_id' => $item_id, 'field' => 'tr_program_students'));
                                        $companies = wp_get_post_terms($item_id, 'companies');
                                        break;
                                }
                                
                                include get_template_directory() . $template_path;
                            }
                            wp_reset_postdata();
                            
                            // Add "Show all" item for each post type when viewing all results
                            if ($current_post_type === 'all') {
                                // Get custom count for this post type to check if we should show "Show all" button
                                $count_for_type = isset($posts_per_type_all[$post_type]) ? $posts_per_type_all[$post_type] : 4;
                                
                                if ($search_counts[$post_type]['count'] > $count_for_type) {
                                    // Get page URLs
                                    $page_urls = array(
                                        'programs' => get_post_type_page_url($programs_page_id, 'programs'),
                                        'post' => get_post_type_page_url($news_page_id, 'post'),
                                        'events' => get_post_type_page_url($events_page_id, 'events'),
                                        'teachers' => get_post_type_page_url($teachers_page_id, 'teachers'),
                                        'students' => get_post_type_page_url($students_page_id, 'students')
                                    );
                                    
                                    echo '<div class="search-content-buttons">';
                                    
                                    // First button - link to main page
                                    if (isset($page_urls[$post_type])) {
                                        echo '<a href="' . esc_url($page_urls[$post_type]) . '" class="button">';
                                        echo isset($view_all_texts[$post_type]) ? $view_all_texts[$post_type] : pll__('View all', 'baza');
                                        echo '</a>';
                                    }
                                    
                                    // Second button - "Show more" filter
                                    echo '<a href="' . esc_url(get_show_more_url($search_query, $post_type)) . '" class="show-more-link">';
                                    echo pll__('Show more', 'baza');
                                    echo '</a>';
                                    
                                    echo '</div>';
                                }
                            }
                            
                            echo '</div>'; // Close search-{type}-items
                        }
                        
                        // TODO: Pagination
                    }
                    
                    if (empty($grouped_posts)) {
                        echo '<div class="no-results-message">';
                        echo '<h2>' . pll__('Nothing found') . '</h2>';
                        echo '<p>' . pll__('Nothing was found for your request. Try changing your search query.') . '</p>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (empty($search_query)) : ?>
            <div class="no-search-query">
                <h1><?php echo pll__('Search'); ?></h1>
                <p><?php echo pll__('Enter your search query'); ?></p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php 
wp_reset_postdata();
get_footer(); 
?>