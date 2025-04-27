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
}

add_action('wp_enqueue_scripts', 'remove_filter_everything_styles', 100);
add_action('wp_print_styles', 'remove_filter_everything_styles', 100);

// Allow SVG uploads
function allow_svg_uploads($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

/**
 * Add all favicon and app icon related tags to the site header
 */
function add_complete_favicons() {
    $img_path = trailingslashit(get_stylesheet_directory_uri()) . 'assets/images/';
    
    // SVG favicon (modern browsers)
    echo '<link rel="icon" href="' . $img_path . 'favicon.svg" type="image/svg+xml" />' . "\n";
    
    // Traditional favicon
    echo '<link rel="shortcut icon" href="' . $img_path . 'favicon.ico" />' . "\n";
    
    // Various sizes for different devices
    echo '<link rel="icon" type="image/png" sizes="96x96" href="' . $img_path . 'favicon-96x96.png" />' . "\n";
    
    // Apple Touch Icons
    echo '<link rel="apple-touch-icon" href="' . $img_path . 'apple-touch-icon.png" />' . "\n";
    
    // Web App Manifest for PWA
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