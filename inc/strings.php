<?php

function register_customizer_strings_for_polylang() {
    if (!function_exists('pll_register_string')) {
        return;
    }
    
    $strings = array(
        'All rights reserved',
        'Copyright',
        'Terms and Conditions',
        'Privacy Policy',
        'General phone number',
        'Section',
        'Study',
        'About business school',
        'Marketing department',
        'Information department',
        'About us',
        'Study programs',
        'Search',
        'Send Again',
        'Learn more',
        'Read more',
        'All',
        'News',
        'Events',
        'All posts',
    );
    
    foreach ($strings as $string) {
        pll_register_string($string, $string, 'Theme');
    }
}
add_action('init', 'register_customizer_strings_for_polylang');