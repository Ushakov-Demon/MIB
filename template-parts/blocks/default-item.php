<?php

if (!defined('ABSPATH')) exit;

$post_ID        = get_the_ID();
$post_type      = get_post_type();
$title          = get_the_title();
$post_permalink = get_the_permalink();
$excerpt        = get_the_excerpt();
$thumbnail_id   = get_post_thumbnail_id();
?>

<div class="item default-item">
    <?php if ($thumbnail_id) : ?>
        <div class="item-image">
            <img src="<?php echo wp_get_attachment_image_url($thumbnail_id, 'medium'); ?>" alt="<?php echo esc_attr($title); ?>">
        </div>
    <?php endif; ?>
    
    <div class="item-content">
        <h3 class="item-title">
            <a href="<?php echo esc_url($post_permalink); ?>">
                <?php echo esc_html($title); ?>
            </a>
        </h3>
        
        <?php if (!empty($excerpt)) : ?>
            <p class="item-excerpt">
                <?php echo esc_html($excerpt); ?>
            </p>
        <?php endif; ?>
    </div>
</div>