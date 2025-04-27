<?php
$title_text_tag_before = isset( $is_announcing ) && $is_announcing ? "<span>" : "<a href=" . esc_url($post_permalink) . ">";
$title_text_tag_after  = isset( $is_announcing ) && $is_announcing ? "</span>" : "</a>" ;
?>
<div class="item <?php echo isset( $announcing ) ?? $announcing?>">
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
        <?php 
        echo $title_text_tag_before;
            echo esc_html($title);
        echo $title_text_tag_after;
        ?>
    </h2>
    
    <?php if (!empty($desc)): ?>
        <div class="excerpt"><?php echo wp_kses_post($desc); ?></div>
    <?php endif; ?>

    <?php
    if ( ! isset( $is_announcing ) || ! $is_announcing ) :
    ?>
    <div class="item-footer">
        <a href="<?php echo esc_url($post_permalink); ?>" class="show-more-link">
            <?php if (!empty($button_text)): ?>
                <?php pll_e($button_text, 'baza'); ?>
                <?php else: ?>
                <?php pll_e('Learn more', 'baza'); ?>
            <?php endif; ?>
        </a>
    </div>
    <?php
    endif;
    ?>
</div>