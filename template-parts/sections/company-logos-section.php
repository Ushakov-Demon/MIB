<?php
/**
 * Template part for displaying the company logos section
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Get the field values
$heading = $company_logos_heading ?? '';
$items = $company_logos_items ?? [];

// Check if we have items
if ( empty( $items ) ) return;
?>

<section class="section section-company-logos">
    <div class="container">
        <?php if ( ! empty( $heading ) ) : ?>
            <div class="section-title"><?php echo esc_html( $heading ); ?></div>
        <?php endif; ?>
        
        <div class="items" id="company-logos-items">
            <?php foreach ( $items as $item ) : 
                $logo_id = $item['logo'] ?? 0;
                $name = $item['name'] ?? '';
                $url = $item['url'] ?? '';
                
                if ( empty( $logo_id ) || empty( $name ) ) continue;
                
                $logo_url = wp_get_attachment_image_url( $logo_id, 'medium' );
                $logo_alt = get_post_meta( $logo_id, '_wp_attachment_image_alt', true ) ?: $name;
                
                $has_url = ! empty( $url );
                $tag_open = $has_url ? '<a href="' . esc_url( $url ) . '" class="item" target="_blank" rel="nofollow noopener">' : '<div class="item">';
                $tag_close = $has_url ? '</a>' : '</div>';
            ?>
                <?php echo $tag_open; ?>
                    <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>" loading="lazy">
                <?php echo $tag_close; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>