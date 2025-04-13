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
    wp_enqueue_script( 'baza-woo-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/woo.js', array('jquery'), false);
    wp_enqueue_script( 'baza-notiny-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/notiny.min.js', array('jquery'), false);
	wp_enqueue_script( 'baza-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/jq.js', array('jquery'), false);

    // CSS

	wp_enqueue_style( 'baza-owl-carousel', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/owl.carousel.min.css', array(), false );
	wp_enqueue_style( 'baza-photoswipe', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/photoswipe.css', array(), false );
    wp_enqueue_style( 'baza-woo-styles', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/woo.css', array(), false );
	wp_enqueue_style( 'baza-styles', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/style.css', array(), false );

    
}

add_action( 'wp_enqueue_scripts', 'baza_dev_scripts_and_styles' , 999 );

// Admin css

function my_custom_admin_styles() {
    wp_enqueue_style( 'baza-admin-styles', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/admin.css', array(), false );
}
add_action('admin_enqueue_scripts', 'my_custom_admin_styles');

 // Remove styles

function baza_dev_dequeue_styles() {
    wp_dequeue_style( 'wooac-frontend' );
    wp_dequeue_style( 'contact-form-7' );
    wp_dequeue_style( 'trp-language-switcher-style' );
    wp_dequeue_style( 'wqpmb-style' );
    wp_dequeue_style( 'woocommerce-general' );
    wp_deregister_style( 'woocommerce-general' );
    wp_dequeue_style( 'wpc-filter-everything' );
    wp_deregister_style('wpc-filter-everything');
    wp_dequeue_style( 'woocommerce-smallscreen' );
    wp_deregister_style( 'wqpmb_internal' );
    wp_dequeue_style( 'woocommerce-layout' );
    wp_deregister_style( 'woocommerce-layout' );
    wp_dequeue_style( 'filter-everything-inline' );
    wp_deregister_style( 'filter-everything-inline' );
}

add_action( 'wp_enqueue_scripts', 'baza_dev_dequeue_styles', 9999999 );

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

// Sanitize SVG content

function sanitize_svg($svg_content) {
    $svg_content = preg_replace('/<script.*?>.*?<\/script>/is', '', $svg_content);
    $svg_content = preg_replace('/<style.*?>.*?<\/style>/is', '', $svg_content);
    $svg_content = preg_replace('/\s+xmlns=["\'][^"\']*["\']/', '', $svg_content);
    return $svg_content;
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
