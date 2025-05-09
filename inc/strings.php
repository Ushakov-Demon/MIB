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
        'View certificate',
        'Completed',
        'More details',
        'Return to main page',
        'The address is incorrectly entered or this page no longer exists on the site',
        'Page not found',
        'Error',
        'Address',
        'multichannel',
        'Phone for education program inquiries',
        'We are on social',
        'Phone of the School of NPQ',
        'Latest events',
        'Author',
        'Copy link',
        'Link copied',
        'Current',
        'View more results',
        'Invite',
        'Event plan',
        'View event',
        'All events',
        'Sign up for the program',
        'UAH',
        'Total amount',
        'Share the article',
        'About the Program',
        'Teachers',
        'Graduates',
        'Program Content',
        'Admission Requirements',
        'Listeners',
    );
    
    foreach ($strings as $string) {
        pll_register_string($string, $string, 'Theme');
    }
}
add_action('init', 'register_customizer_strings_for_polylang');