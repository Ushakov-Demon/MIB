<div class="item">
    <?php if (!empty($icon_url)): ?>
        <a class="image" href="<?php echo esc_url($post_permalink); ?>">
            <?php echo get_svg(esc_url($icon_url), esc_attr($title)); ?>
        </a>
    <?php endif; ?>
    
    <h2 class="title">
        <a href="<?php echo esc_url($post_permalink); ?>">
            <?php echo esc_html($title); ?>
        </a>
    </h2>
    
    <?php if (!empty($desc)): ?>
        <div class="excerpt"><?php echo wp_kses_post($desc); ?></div>
    <?php endif; ?>

    <div class="item-footer">
        <a href="<?php echo esc_url($post_permalink); ?>" class="show-more-link">
            <?php pll_e('Learn more', 'baza'); ?>
        </a>
    </div>
</div>