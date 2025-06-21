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