<div class="item">

    <?php if ($image): ?>
        <div class="image">
            <?php 
                echo wp_get_attachment_image(
                    $image,
                    'medium',
                    false,
                    array(
                        'class' => 'block-item-img',
                        'loading' => 'lazy',
                    )
                );
            ?>
        </div>
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
            <?php if (!empty($button_text)): ?>
                <?php pll_e($button_text, 'baza'); ?>
                <?php else: ?>
                <?php pll_e('Learn more', 'baza'); ?>
            <?php endif; ?>
        </a>
    </div>
</div>