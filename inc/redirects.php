<?php 

function auto_news_redirect() {
    if (preg_match('/\/ua\/novosti-mib\/item\/\d+-(.+)\.html$/', $_SERVER['REQUEST_URI'], $matches)) {
        $slug = $matches[1];
        $new_url = home_url( $slug . '/');
        wp_redirect($new_url, 301);
        exit;
    }
}
add_action('template_redirect', 'auto_news_redirect');

function fix_program_category_404() {
    $uri = $_SERVER['REQUEST_URI'];
    $taxonomies = get_taxonomies(array('public' => true), 'objects');
    
    if (strpos($uri, '/mib/') === 0) {
        $uri_without_prefix = substr($uri, 4);
    } else {
        $uri_without_prefix = $uri;
    }
    
    foreach ($taxonomies as $taxonomy) {
        $taxonomy_slug = isset($taxonomy->rewrite['slug']) ? $taxonomy->rewrite['slug'] : $taxonomy->name;
        
        if (preg_match('|^/' . $taxonomy_slug . '/([^/]+)/?$|', $uri_without_prefix, $matches)) {
            $term_slug = $matches[1];
            $term = get_term_by('slug', $term_slug, $taxonomy->name);
            
            if ($term && $taxonomy->name === 'program_category') {
                global $wp_query;
                $wp_query->is_404 = false;
                $wp_query->is_tax = true;
                $wp_query->is_archive = true;
                $wp_query->queried_object = $term;
                $wp_query->queried_object_id = $term->term_id;

                status_header(200);
                break;
            }
        }
    }
}
add_action('template_redirect', 'fix_program_category_404', 5);