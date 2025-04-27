<?php
$current_url = home_url(add_query_arg(null, null));
$menu_locations = get_nav_menu_locations();
$menu_description = '';

foreach ($menu_locations as $location => $menu_id) {
    $menu_items = wp_get_nav_menu_items($menu_id);
    
    if ($menu_items) {
        foreach ($menu_items as $item) {
            if (untrailingslashit($item->url) === untrailingslashit($current_url)) {
                $menu_description = $item->description;
                break 2;
            }
        }
    }
}

if ($menu_description) {
    if (function_exists('pll__')) {
        $menu_description = pll__($menu_description);
    }
    echo '<div class="description">' . esc_html($menu_description) . '</div>';
}