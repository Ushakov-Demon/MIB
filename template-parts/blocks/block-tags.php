<?php

// TODO: Need tags sorting 

$tags = get_terms([
    'taxonomy' => 'post_tag',
    'hide_empty' => true,
]);

if ($tags) :
    echo '<div class="tags">';
    
    foreach ($tags as $tag) {

        $current_url = home_url( add_query_arg( null, null ) );
        
        $tag_link = add_query_arg( [
            'post_type' => 'programs',
            'tag' => $tag->slug
        ], $current_url );
        
        echo '<a href="' . esc_url($tag_link) . '" class="button-tag">' . esc_html($tag->name) . '</a>';
    }
    
    echo '</div>';
endif;