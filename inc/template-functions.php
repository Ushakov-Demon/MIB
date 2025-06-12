<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package baza
 */

// Scripts and css
function baza_dev_scripts_and_styles() {

    // JS
	wp_enqueue_script( 'baza-owl-carousel-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/owl.carousel.min.js', array('jquery'), false);
	wp_enqueue_script( 'baza-inputmask-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/jquery.inputmask.min.js', array('jquery'), false);
    wp_enqueue_script( 'baza-notiny-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/notiny.min.js', array('jquery'), false);
	wp_enqueue_script( 'baza-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/jq.js', array('jquery'), false);
    wp_enqueue_script( 'baza-menu-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/menu.js', array('jquery'), false);
    wp_enqueue_script( 'baza-tooltip-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/tooltip.js', array('jquery'), false);

    // CSS
	wp_enqueue_style( 'baza-owl-carousel', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/owl.carousel.min.css', array(), false );
	wp_enqueue_style( 'baza-photoswipe', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/photoswipe.css', array(), false );
    wp_enqueue_style( 'baza-animate', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/animate.min.css', array(), false );
	wp_enqueue_style( 'baza-styles', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/style.css', array(), false );

    wp_localize_script( 'baza-js', 'dataObj', [
		'ajaxUrl' => admin_url( 'admin-ajax.php' )
	] );
}

add_action( 'wp_enqueue_scripts', 'baza_dev_scripts_and_styles' , 999 );

// Admin css
function my_custom_admin_styles() {
    wp_enqueue_style( 'baza-admin-styles', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/admin.css', array(), false );
}
add_action('admin_enqueue_scripts', 'my_custom_admin_styles');

 // Remove styles
function baza_dev_dequeue_styles() {
    wp_dequeue_style( 'contact-form-7' );
    wp_dequeue_style( 'trp-language-switcher-style' );
}
add_action( 'wp_enqueue_scripts', 'baza_dev_dequeue_styles', 9999999 );

function remove_filter_everything_styles() {
    wp_dequeue_style('wpc-filter-everything');
    wp_deregister_style('wpc-filter-everything');
    
    wp_dequeue_style('filter-everything');
    wp_deregister_style('filter-everything');
    
    wp_dequeue_style('wpc-widgets');
    wp_deregister_style('wpc-widgets');
    
    wp_dequeue_style('filter-everything-pro');
    wp_deregister_style('filter-everything-pro');
    
    wp_dequeue_style('filter-everything-inline');
    wp_deregister_style('filter-everything-inline');
    
    wp_dequeue_style('filter-everything.min.css');
    wp_deregister_style('filter-everything.min.css');

    wp_dequeue_style('wpc-filter-everything-custom');
    wp_deregister_style('wpc-filter-everything-custom');
    
}

add_action('wp_enqueue_scripts', 'remove_filter_everything_styles', 100);
add_action('wp_print_styles', 'remove_filter_everything_styles', 100);

function disable_mobile_zoom() {
    remove_action('wpseo_head', array(YoastSEO()->meta, 'viewport'), 1);
    add_action('wp_head', 'add_custom_viewport_meta', 1);
}
add_action('wp', 'disable_mobile_zoom');

function add_custom_viewport_meta() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />';
}

function remove_filter_everything_inline_styles() {
    wp_add_inline_style('filter-everything', '');
    ob_start(function($buffer) {
        $pattern = '/<style[^>]*id=["\']filter-everything-inline[^>]*>.*?<\/style>/is';
        return preg_replace($pattern, '', $buffer);
    });
}
add_action('wp_head', 'remove_filter_everything_inline_styles', 1);

// Images sizes
function images_sizes() {
    add_image_size('hero_event_image', 1200, 800, true);
}
add_action('after_setup_theme', 'images_sizes');

// Allow SVG uploads
function allow_svg_uploads($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

// Breadcrumbs
function display_breadcrumbs() {
    if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb(
            '<div class="breadcrumb-container"><div class="container"><div id="breadcrumbs">',
            '</div></div></div>'
        );
    }
}

function translate_home_breadcrumb($links) {
    $links[0]['text'] = __('Home', 'baza');
    return $links;
}
add_filter('wpseo_breadcrumb_links', 'translate_home_breadcrumb');
add_filter('wpseo_breadcrumb_links', 'universal_add_breadcrumb_parent');

function yoast_search_breadcrumb($links) {
    if (is_search()) {
        if (!empty($links)) {
            array_pop($links);
        }

        $links[] = array(
            'text' => pll__('Search', 'baza'),
            'url' => false, 
            'is_front' => false
        );
    }
    
    return $links;
}
add_filter('wpseo_breadcrumb_links', 'yoast_search_breadcrumb');

function universal_add_breadcrumb_parent($links, $config = array()) {

    if (empty($config)) {
        $config = array(
            'events' => 155,
            'programs' => 148,
            'accreditations' => 521,
            'teachers' => 20,
            'students' => 22,
            'members' => 77,
            'post' => 153,
        );
    }

    $current_post_type = get_post_type();
    
    if (!isset($config[$current_post_type]) || !is_singular($current_post_type)) {
        return $links;
    }

    $default_page_id = $config[$current_post_type];
    $current_lang = function_exists('pll_current_language') ? pll_current_language() : false;
    $translated_page_id = function_exists('pll_get_post') ? pll_get_post($default_page_id, $current_lang) : $default_page_id;

    if ($translated_page_id) {
        $translated_link = get_permalink($translated_page_id);
        $translated_title = get_the_title($translated_page_id);

        array_splice($links, 1, 0, array(array(
            'url'  => $translated_link,
            'text' => $translated_title,
            'id'   => $translated_page_id
        )));
    }

    return $links;
}

// Add all favicon and app icon related tags to the site header
function add_complete_favicons() {
    $img_path = trailingslashit(get_stylesheet_directory_uri()) . 'assets/images/';
    //echo '<link rel="shortcut icon" href="' . $img_path . 'favicon.ico" />' . "\n";
    echo '<link rel="icon" href="' . $img_path . 'favicon.svg" type="image/svg+xml" />' . "\n";
    echo '<link rel="icon" type="image/png" sizes="96x96" href="' . $img_path . 'favicon-96x96.png" />' . "\n";
    echo '<link rel="apple-touch-icon" href="' . $img_path . 'apple-touch-icon.png" />' . "\n";
    echo '<link rel="manifest" href="' . $img_path . 'site.webmanifest" />' . "\n";
}
add_action('wp_head', 'add_complete_favicons');
 
// Sanitize SVG
function sanitize_svg($svg_content) {
    $svg_content = preg_replace('/<\?xml.*?\?>/is', '', $svg_content);
    $svg_content = preg_replace('/<script.*?>.*?<\/script>/is', '', $svg_content);
    $svg_content = preg_replace('/<style.*?>.*?<\/style>/is', '', $svg_content);
    $svg_content = preg_replace('/\son\w+="[^"]*"/i', '', $svg_content);
    $svg_content = preg_replace('/<!\[CDATA\[.*?\]\]>/s', '', $svg_content);
    
    return $svg_content;
}

// Get SVG
function get_svg($attachment_id_or_url, $alt_text = '') {
    if (!$attachment_id_or_url) {
        return '';
    }
    
    $is_svg = false;
    $svg_content = null;
    $image_url = null;
    
    if (is_numeric($attachment_id_or_url)) {
        $attachment_id = $attachment_id_or_url;
        $mime_type = get_post_mime_type($attachment_id);
        
        if ($mime_type === 'image/svg+xml') {
            $is_svg = true;
            $file_path = get_attached_file($attachment_id);
            
            if ($file_path && file_exists($file_path)) {
                $svg_content = file_get_contents($file_path);
            }
        } else {
            $image_url = wp_get_attachment_image_url($attachment_id, 'medium');
        }
    } else {
        $file_extension = pathinfo($attachment_id_or_url, PATHINFO_EXTENSION);
        
        if (strtolower($file_extension) === 'svg') {
            $is_svg = true;
            $upload_dir = wp_upload_dir();
            $file_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $attachment_id_or_url);
            
            if (file_exists($file_path)) {
                $svg_content = file_get_contents($file_path);
            } else {
                $image_url = $attachment_id_or_url;
            }
        } else {
            $image_url = $attachment_id_or_url;
        }
    }
    
    if ($is_svg && $svg_content) {
        return '<span class="icon">' . sanitize_svg($svg_content) . '</span>';
    } elseif ($image_url) {
        return '<img src="' . esc_url($image_url) . '" class="icon ' . ($is_svg ? 'icon-svg' : 'icon-img') . '" alt="' . esc_attr($alt_text) . '">';
    }
    
    return '';
}
 
// Menu icon
add_filter('walker_nav_menu_start_el', 'custom_menu_icon_walker', 10, 4);
    function custom_menu_icon_walker($item_output, $item, $depth, $args) {
        $icon_id = carbon_get_nav_menu_item_meta($item->ID, 'menu_item_icon');

        if (!empty($icon_id)) {
            $icon_html = get_svg($icon_id, $item->title);
            
            if ($icon_html) {
                $item_output = str_replace('<a', '<a class="has-menu-icon"', $item_output);
                
                $a_pos = strpos($item_output, '>');
                if ($a_pos !== false) {
                    $item_output = substr_replace($item_output, '>' . $icon_html, $a_pos, 1);
                }
            }
        }

    return $item_output;
}

// remove jQuery migrate
add_action('wp_default_scripts', function ($scripts) {
    if (!empty($scripts->registered['jquery'])) {
        $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
    }
});

remove_action('wp_head', 'wp_generator');

// Shortcodes
function current_year_shortcode() {
    return date('Y');
}
add_shortcode('Y', 'current_year_shortcode');

// Photoswipe
function generate_photoswipe_lightbox_script($gallery_selector, $item_selector) {
    ob_start();
    ?>
    <script type="module">
        import PhotoSwipeLightbox from '<?php echo esc_url(get_stylesheet_directory_uri()) ?>/assets/js/photoswipe-lightbox.esm.min.js';
        const lightbox = new PhotoSwipeLightbox({
            gallerySelector: '<?php echo esc_js($gallery_selector); ?>',
            arrowPrevSVG: '',
            arrowNextSVG: '',
            childSelector: '<?php echo esc_js($item_selector); ?>',
            escKey: false,
            pswpModule: () => import('<?php echo esc_url(get_stylesheet_directory_uri()) ?>/assets/js/photoswipe.esm.min.js')
        });
        lightbox.init();
    </script>
    <?php
    return ob_get_clean();
}

// Block category position
add_filter('block_categories_all', function($categories, $post) {
    $exists = false;
    foreach ($categories as $key => $category) {
        if ($category['slug'] === 'mib') {
            unset($categories[$key]);
            $exists = true;
            break;
        }
    }
    
    if ($exists) {
        array_unshift($categories, [
            'slug' => 'mib',
            'title' => __('MIB'),
            'icon' => 'smiley'
        ]);
    } else {
        array_unshift($categories, [
            'slug' => 'mib',
            'title' => __('MIB'),
            'icon' => 'smiley'
        ]);
    }
    
    return $categories;
}, 10, 2);

// CF7
remove_filter( 'the_content', 'wpautop' );
add_filter( 'wpcf7_autop_or_not', '__return_false' );

add_filter('wpcf7_form_elements', 'replace_cf7_submit_with_button');
function replace_cf7_submit_with_button($html) {
    $pattern = '/<input class="(.*?)wpcf7-submit(.*?)" type="submit" value="([^"]*)"(.*?)>/';
    $replacement = '<div class="form-submit"><button class="button $1wpcf7-submit$2"$4>$3</button></div>';
    $html = preg_replace($pattern, $replacement, $html);
    return $html;
}

function enqueue_cf7_custom_scripts() {
    wp_enqueue_script('cf7-custom-script', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/forms.js', array('jquery'), false, true);
    wp_add_inline_script('cf7-custom-script', 'var sendAgainTranslation = "' . (function_exists('pll__') ? pll__('Send Again') : 'Send Again') . '";', 'before');
 }
 add_action('wp_enqueue_scripts', 'enqueue_cf7_custom_scripts');

// Cusom color
function custom_gutenberg_colors() {
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('White'),
            'slug'  => 'section-light',
            'color' => '#ffffff',
        ),
        array(
            'name'  => __('Primary'),
            'slug'  => 'section-dark',
            'color' => '#5E9CB9',
        ),
        array(
            'name'  => __('Black'),
            'slug'  => 'section-dark',
            'color' => '#000000',
        ),
    ));
    remove_theme_support('editor-font-sizes');
}
add_action('after_setup_theme', 'custom_gutenberg_colors');

// Custom language switcher with custom flags
function custom_language_switcher() {
    if (!function_exists('pll_current_language')) {
        return;
    }

    $current_lang = pll_current_language();
    $languages = pll_the_languages(array('raw' => 1));
    
    // Path to custom flags
    $custom_flags_path = get_template_directory_uri() . '/assets/images/flags/';

    $has_translations = false;
    
    foreach ($languages as $lang_code => $lang) {
        if ($lang_code != $current_lang) {
            $translated_post = pll_get_post(get_the_ID(), $lang_code);
            
            if ($translated_post) {
                $has_translations = true;
                break;
            }
        }
    }
    
    if (!$has_translations) {
        return;
    }

    echo '<ul class="language">';
    echo '<li class="active">';
    
    echo '<a href="' . $languages[$current_lang]['url'] . '">';
    echo '<img src="' . $custom_flags_path . $current_lang . '.svg" alt="' . $languages[$current_lang]['name'] . ' flag" class="lang-flag" />';
    echo '<span>' . $languages[$current_lang]['name'] . '</span></a>';
    
    echo '<ul>';
    
    foreach ($languages as $lang_code => $lang) {
        if ($lang_code != $current_lang) {
            $translated_post = pll_get_post(get_the_ID(), $lang_code);
            
            if ($translated_post) {
                echo '<li><a href="' . $lang['url'] . '">';
                echo '<img src="' . $custom_flags_path . $lang_code . '.svg" alt="' . $lang['name'] . ' flag" class="lang-flag" />';
                echo $lang['name'] . '</a></li>';
            }
        }
    }
    
    echo '</ul></li></ul>';
}

// Translated actuality page ID with Polylang support
function get_translated_page_id($default_id) {

    if (function_exists('pll_get_post')) {
        $translated_id = pll_get_post($default_id);
        return $translated_id ? $translated_id : $default_id;
    }
    
    return $default_id;
}

// Filter nav menu
function process_menu_text($text) {
    if (strpos($text, '*') !== false) {
        return preg_replace('/\*(.*?)\*/', '<b>$1</b>', $text);
    }
    
    return $text;
}

function filter_nav_menu_item_title($title, $item, $args, $depth) {
    return '<span>' . process_menu_text($title) . '</span>';
}
add_filter('nav_menu_item_title', 'filter_nav_menu_item_title', 10, 4);

// Translatable theme mod {text}
function get_translatable_theme_mod($setting_id, $default = '') {
    $text = get_theme_mod($setting_id, $default);
    
    if (empty($text)) {
        return $default;
    }
    
    preg_match_all('/{([^}]+)}/', $text, $matches);
    
    if (!empty($matches[1])) {
        foreach ($matches[1] as $key => $string_to_translate) {
            if (function_exists('pll__')) {
                $translated_string = pll__($string_to_translate);
            } else {
                $translated_string = $string_to_translate;
            }
            
            $text = str_replace(
                $matches[0][$key],
                $translated_string,
                $text
            );
        }
    }
    
    return $text;
}

function the_translatable_customizer_text($setting_id, $default = '', $echo = true) {
    $text = get_translatable_theme_mod($setting_id, $default);
    
    if ($echo) {
        echo $text;
    } else {
        return $text;
    }
}

// Translate menu
add_filter('wp_nav_menu_objects', 'translate_menu_items_automatically', 10, 2);

function translate_menu_items_automatically($menu_items, $args) {
    if (!function_exists('pll_current_language') || !function_exists('pll_get_post')) {
        return $menu_items;
    }
    
    $current_lang = pll_current_language();
    
    if (empty($current_lang) || $current_lang == pll_default_language()) {
        return $menu_items;
    }
    
    foreach ($menu_items as $key => $item) {
        if ($item->type == 'post_type') {
            $translated_id = pll_get_post($item->object_id, $current_lang);
            
            if ($translated_id) {
                $translated_post = get_post($translated_id);
                
                if ($translated_post) {
                    $menu_items[$key]->title = $translated_post->post_title;
                    $menu_items[$key]->url = get_permalink($translated_id);
                    $menu_items[$key]->object_id = $translated_id;
                }
            }
        }

        else if ($item->type == 'taxonomy' && function_exists('pll_get_term')) {
            $translated_term_id = pll_get_term($item->object_id, $current_lang);
            
            if ($translated_term_id) {
                $translated_term = get_term($translated_term_id);
                
                if (!is_wp_error($translated_term)) {
                    $menu_items[$key]->title = $translated_term->name;
                    $menu_items[$key]->url = get_term_link($translated_term_id);
                    $menu_items[$key]->object_id = $translated_term_id;
                }
            }
        }
        else if ($item->type == 'custom') {
            
        }
    }
    
    return $menu_items;
}

// Level in menu
function add_menu_level_class($classes, $item, $args, $depth) {
    $classes[] = 'level-' . $depth;
    return $classes;
}
add_filter('nav_menu_css_class', 'add_menu_level_class', 10, 4);

// Function to automatically highlight text between asterisks with a span
function highlight_text_with_stars($text) {
    if (!is_string($text)) {
        return $text;
    }
    
    $pattern = '/\*(.*?)\*/';
    $replacement = '<span class="highlight">$1</span>';
    
    return preg_replace($pattern, $replacement, $text);
}
 
// Extended get_theme_mod with automatic text highlighting
function get_themed_mod($name, $default = false) {
    $value = get_theme_mod($name, $default);
    
    if (is_string($value)) {
        return highlight_text_with_stars($value);
    }
    
    return $value;
}

// Modify gallery block
function modify_gallery_block_html($block_content, $block) {
    if ($block['blockName'] === 'core/gallery') {
        $pattern = '/<figure class="(.*?)wp-block-gallery(.*?)">/';
        $replacement = '<figure class="wp-block-gallery owl-carousel">';
        $block_content = preg_replace($pattern, $replacement, $block_content);
    }
    return $block_content;
}

add_filter('render_block', 'modify_gallery_block_html', 10, 2);

// Share article
function share_article_buttons() {
    $current_url = esc_url(get_permalink());
    $post_title = get_the_title();
    $post_excerpt = get_the_excerpt();
    $copy_text = pll__('Copy link', 'baza');
    $copied_text = pll__('Link copied', 'baza');
    
    $thumbnail_id = get_post_thumbnail_id();
    $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'large');
    
    $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($current_url) . 
                   '&t=' . urlencode($post_title);
    
    $linkedin_url = 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($current_url) . 
                   '&title=' . urlencode($post_title) . 
                   '&summary=' . urlencode($post_excerpt);
    
    $share_html = '
    <div class="block block-share-article">
        <div class="block-title">' . pll__('Share the article') . '</div>
        <div class="share-buttons">
            <a href="' . $facebook_url . '" target="_blank" class="share-btn facebook-btn">
                <svg width="9" height="16" viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.78125 16H5.71875V8.84375H8L8.375 6H5.71875V4.03125C5.71875 3.59375 5.78125 3.25 5.96875 3.03125C6.15625 2.78125 6.5625 2.65625 7.125 2.65625H8.625V0.125C8.0625 0.0625 7.3125 0 6.4375 0C5.3125 0 4.4375 0.34375 3.78125 1C3.09375 1.65625 2.78125 2.5625 2.78125 3.75V6H0.375V8.84375H2.78125V16Z" fill="currentColor"/>
                </svg>
            </a>
            <a href="' . $linkedin_url . '" target="_blank" class="share-btn linkedin-btn">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.125 14V4.65625H0.21875V14H3.125ZM1.6875 3.375C2.125 3.375 2.53125 3.21875 2.875 2.875C3.1875 2.5625 3.375 2.15625 3.375 1.6875C3.375 1.25 3.1875 0.84375 2.875 0.5C2.53125 0.1875 2.125 0 1.6875 0C1.21875 0 0.8125 0.1875 0.5 0.5C0.15625 0.84375 0 1.25 0 1.6875C0 2.15625 0.15625 2.5625 0.5 2.875C0.8125 3.21875 1.21875 3.375 1.6875 3.375ZM14 14V8.875C14 7.4375 13.7812 6.375 13.375 5.6875C12.8125 4.84375 11.875 4.40625 10.5312 4.40625C9.84375 4.40625 9.28125 4.59375 8.78125 4.90625C8.3125 5.1875 7.96875 5.53125 7.78125 5.9375H7.75V4.65625H4.96875V14H7.84375V9.375C7.84375 8.65625 7.9375 8.09375 8.15625 7.71875C8.40625 7.21875 8.875 6.96875 9.5625 6.96875C10.2188 6.96875 10.6562 7.25 10.9062 7.8125C11.0312 8.15625 11.0938 8.6875 11.0938 9.4375V14H14Z" fill="currentColor"/>
                </svg>
            </a>
            <a href="#" class="share-btn copy-link-btn" data-url="' . $current_url . '" data-copy-text="' . $copy_text . '" data-copied-text="' . $copied_text . '">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.8125 6.1875C9.46875 5.84375 9.09375 5.59375 8.6875 5.375C8.53125 5.3125 8.375 5.34375 8.25 5.46875L8.125 5.59375C7.84375 5.84375 7.6875 6.1875 7.65625 6.53125C7.625 6.6875 7.71875 6.84375 7.84375 6.9375C8.125 7.0625 8.375 7.21875 8.5625 7.4375C9.59375 8.46875 9.59375 10.125 8.5625 11.1562L6.21875 13.5C5.1875 14.5312 3.53125 14.5312 2.5 13.5C1.46875 12.4688 1.46875 10.8125 2.5 9.78125L3.9375 8.34375C4.03125 8.25 4.0625 8.125 4.03125 8C3.9375 7.625 3.90625 7.21875 3.875 6.8125C3.875 6.5 3.46875 6.34375 3.25 6.5625C2.875 6.9375 2.28125 7.53125 1.28125 8.53125C-0.4375 10.25 -0.4375 13.0312 1.28125 14.7188C2.96875 16.4375 5.75 16.4375 7.46875 14.7188C10.0312 12.1562 9.90625 12.2812 10.0938 12.0312C11.5 10.3438 11.4062 7.78125 9.8125 6.1875ZM14.6875 1.3125C13 -0.40625 10.2188 -0.40625 8.5 1.3125C5.9375 3.875 6.0625 3.75 5.875 4C4.46875 5.6875 4.5625 8.25 6.15625 9.84375C6.5 10.1875 6.875 10.4375 7.28125 10.6562C7.4375 10.7188 7.59375 10.6875 7.71875 10.5625L7.84375 10.4375C8.125 10.1875 8.28125 9.84375 8.3125 9.5C8.34375 9.34375 8.25 9.1875 8.125 9.09375C7.84375 8.96875 7.59375 8.8125 7.40625 8.59375C6.375 7.5625 6.375 5.90625 7.40625 4.875L9.75 2.53125C10.7812 1.5 12.4375 1.5 13.4688 2.53125C14.5 3.5625 14.5 5.21875 13.4688 6.25L12.0312 7.6875C11.9375 7.78125 11.9062 7.90625 11.9375 8.03125C12.0312 8.40625 12.0625 8.8125 12.0938 9.21875C12.0938 9.53125 12.5 9.6875 12.7188 9.46875C13.0938 9.09375 13.6875 8.5 14.6875 7.5C16.4062 5.78125 16.4062 3 14.6875 1.3125Z" fill="currentColor"/>
                </svg>
            </a>
        </div>
    </div>';
    
    return $share_html;
}

// Archive title
add_filter('get_the_archive_title', function ($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_tax()) { //for custom post types
        $title = sprintf(__('%1$s'), single_term_title('', false));
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    }
    return $title;
});

// CF7 form list
add_filter( 'mib_get_cf7_forms_options', 'mib_get_cf7_forms_options_callback' );
function mib_get_cf7_forms_options_callback( $options ) {
    $options = array( '' => __( 'Select a form' ) );

    if ( class_exists( 'WPCF7_ContactForm' ) ) {

        $forms = WPCF7_ContactForm::find();
        if ( $forms ) {
            foreach ( $forms as $form ) {
                $options[ $form->id() ] = $form->title();
            }
        }
    }
    return $options;
}

// Add black class in body
function add_black_page_body_class( $classes ) {
    if ( 'yes' == get_post_meta( get_the_ID(), '_ps_black_page', true ) ) {
        $classes[] = 'mib-black-page';
    }
    return $classes;
}
add_filter( 'body_class', 'add_black_page_body_class' );

// Remove slugs
function remove_slug_field() {
    remove_meta_box('slugdiv', 'events', 'normal');
}
add_action('admin_menu', 'remove_slug_field');

// Admin menu add
function add_companies_menu_item() {
    add_menu_page(
        'Компанії',
        'Компанії',
        'manage_categories',
        'edit-tags.php?taxonomy=companies',
        '',
        'dashicons-building',
        25
    );
}
add_action('admin_menu', 'add_companies_menu_item');

// Translate filter title
function filter_title_translation($title) {
    if (is_admin()) {
        return false;
    }

    if (function_exists('pll__') && !empty($title)) {
        return pll__($title);
    }
    return $title;
}

add_filter('wpc_filter_title', 'filter_title_translation');

function filter_item_translation($term_name) {
    if (is_admin()) {
        return false;
    }

    if (function_exists('pll__') && !empty($term_name)) {
        return pll__($term_name);
    }
    return $term_name;
}

add_filter('wpc_filter_post_meta_term_name', 'filter_item_translation', 1);

// Partners count shortcode
function partners_count_shortcode( $atts ) {

    $atts = shortcode_atts( array(
        'wrapper_class' => 'partners-count-wrapper',
    ), $atts );
    
    $terms = get_terms( array(
        'taxonomy' => 'companies',
        'hide_empty' => false,
    ) );
    
    if ( empty( $terms ) || is_wp_error( $terms ) ) {
        return '';
    }
    
    $all_partners_ids = [];
    $business_partner_ids = [];
    
    foreach ( $terms as $term ) {
        $is_partner                  = get_term_meta( $term->term_id, '_is_partner', true );
        $is_business_partner         = get_term_meta( $term->term_id, '_is_business_partner', true );
        $is_business_school          = get_term_meta( $term->term_id, '_is_business_school', true );
        $is_professional_association = get_term_meta( $term->term_id, '_is_professional_association', true );
        $is_company                  = get_term_meta( $term->term_id, '_is_company', true );
        
        if ( $is_partner || $is_business_partner || $is_business_school || $is_professional_association || $is_company ) {
            $all_partners_ids[] = $term->term_id;
        }
        
        if ( $is_business_partner ) {
            $business_partner_ids[] = $term->term_id;
        }
    }

    $all_partners_count = count( array_unique( $all_partners_ids ) );
    $business_partner_count = count( array_unique( $business_partner_ids ) );
    
    $output = '<div class="' . esc_attr( $atts['wrapper_class'] ) . '">';
    
    $output .= '<div class="item item-partners">';
    $output .= '<div class="value">' . $all_partners_count . '</div>';
    
    $partners_label = ($all_partners_count == 1) ? pll__( 'Partner' ) : pll__( 'Partners' );
    $output .= '<div class="label">' . $partners_label . '</div>';
    $output .= '</div>';
    
    $output .= '<div class="item item-business-partners">';
    $output .= '<div class="value">' . $business_partner_count . '</div>';
    
    $business_partners_label = ($business_partner_count == 1) ? pll__( 'Business partner' ) : pll__( 'Business partners' );
    $output .= '<div class="label">' . $business_partners_label . '</div>';
    $output .= '</div>';
    
    $output .= '</div>';
    
    return $output;
}
add_shortcode( 'partners_count', 'partners_count_shortcode' );

// Unregister sidebar/widget area
function remove_sidebar_widget_area() {
    unregister_sidebar('sidebar-1');
}
add_action('widgets_init', 'remove_sidebar_widget_area', 11);

// Display program category taxonomy data summary 
function mib_display_program_category_summary() {
    if (!is_tax('program_category')) {
        return '';
    }
    
    $programs = mib_get_posts( 'programs', -1 );

    
    if (!$programs || $programs->post_count === 0) {
        return '';
    }
    
    $count                   = $programs->post_count;
    $nearest_start_date      = null;
    $languages               = [];
    $min_price               = PHP_INT_MAX;
    $max_price               = 0;
    $completed_studies       = 0;
    $enhanced_qualifications = 0;
    $total_completed_studies = 0;
    $total_enhanced_qualifications = 0;

    $current_time = current_time('timestamp');
    
    if ($programs->have_posts()) {
        while ($programs->have_posts()) {
            $programs->the_post();
            $post_id = get_the_ID();
            
            $start_date = get_post_meta($post_id, '_tr_program_date_start', true);
            if ($start_date) {
                $start_timestamp = strtotime($start_date);
                
                if ($start_timestamp > $current_time) {
                    if (is_null($nearest_start_date) || $start_timestamp < $nearest_start_date) {
                        $nearest_start_date = $start_timestamp;
                    }
                }
            }
            
            $language = get_post_meta($post_id, '_tr_program_language', true);
            if ($language && !in_array($language, $languages)) {
                $languages[] = $language;
            }

            $regular_price            = (int)get_post_meta($post_id, '_tr_program_regular_price', true);
            $sale_price               = (int)get_post_meta($post_id, '_tr_program_sale_price', true);
            $sale_end_date            = get_post_meta($post_id, '_tr_program_sale_price_date_end', true);
            
            $completed_studies        = (int)get_post_meta($post_id, '_tr_program_completed_studies', true);
            $enhanced_qualifications  = (int)get_post_meta($post_id, '_tr_program_enhanced_qualifications', true);
            $total_completed_studies += $completed_studies;
            $total_enhanced_qualifications += $enhanced_qualifications;
            $use_sale_price           = false;
            
            if ($sale_price && $sale_end_date) {
                $sale_end_timestamp = strtotime($sale_end_date);
                if ($sale_end_timestamp > $current_time) {
                    $use_sale_price = true;
                }
            }
            
            $actual_price = $use_sale_price && $sale_price > 0 ? $sale_price : $regular_price;
            
            if ($actual_price > 0 && $actual_price < $min_price) {
                $min_price = $actual_price;
            }
            
            if ($actual_price > $max_price) {
                $max_price = $actual_price;
            }
        }
    }
    
    wp_reset_postdata();
    
    $date_format             = get_option('date_format');
    $nearest_start_formatted = $nearest_start_date ? date_i18n($date_format, $nearest_start_date) : '';
    $languages_formatted     = !empty($languages) ? implode(', ', $languages) : '';
    
    $price_range = '';
    if ($min_price < PHP_INT_MAX && $max_price > 0) {
        if ($min_price === $max_price) {
            $price_range = $min_price . ' ' . pll__('UAH');
        } else {
            $price_range = $min_price . ' - ' . $max_price . ' ' . pll__( 'UAH' );
        }
    }
    
    $output = '<div class="program-category-summary">';

    $output .= '<div class="summary-item">
        <span class="label">' . pll__('Number of courses') . ':</span>
        <span class="value">' . $count . '</span>
    </div>';

    if ( ! empty( $nearest_start_formatted ) ) {
        $output .= '<div class="summary-item">
            <span class="label">' . pll__('Nearest start') . ':</span>
            <span class="value">' . $nearest_start_formatted . '</span>
        </div>';
    }
    
    if ( ! empty( $languages_formatted ) ) {
        $output .= '<div class="summary-item">
            <span class="label">' . pll__('Program language') . ':</span>
            <span class="value">' . $languages_formatted . '</span>
        </div>';
    }
    
    if ( ! empty( $price_range ) ) {
        $output .= '<div class="summary-item">
            <span class="label">' . pll__('Price range') . ':</span>
            <span class="value">' . $price_range . '</span>
        </div>';
    }

    if ( ! empty( $total_completed_studies ) ) {
        $output .= '<div class="summary-item">
            <span class="label">' . pll__('Completed studies') . ':</span>
            <span class="value">' . $total_completed_studies . '</span>
        </div>';
    }
    
    if ( ! empty( $total_enhanced_qualifications ) ) {
        $output .= '<div class="summary-item">
            <span class="label">' . pll__('Enhanced qualifications') . ':</span>
            <span class="value">' . $total_enhanced_qualifications . '</span>
        </div>';
    }
    
    $output .= '</div>';
    
    return $output;
}

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
                break;
            }
        }
    }
}
add_action('template_redirect', 'fix_program_category_404', 5);

// CF7 redirect after submit
function cf7_redirect_jquery_script() {
    $thank_you_page_id = get_option('_thank_you_page_redirect');
    
    if (!$thank_you_page_id) {
        return;
    }
    
    $translated_page_id = get_translated_page_id($thank_you_page_id);
    $thank_you_url = get_permalink($translated_page_id);
    
    if (!$thank_you_url) {
        return;
    }
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(document).on('wpcf7mailsent', function(event) {
                setTimeout(function() {
                    window.location.href = '<?php echo esc_url($thank_you_url); ?>';
                }, 200);
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'cf7_redirect_jquery_script');
