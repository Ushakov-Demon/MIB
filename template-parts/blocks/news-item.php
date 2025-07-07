<?php
$thumbnail_id = get_post_thumbnail_id($post_ID);
$image_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true) ?: $title;
?>

<div class="item<?php if (!empty($shedule_date)): ?> item-shedule<?php endif; ?>">
    
    <?php if (!empty($thumbnail_id)): ?>
        <a class="image" href="<?php echo esc_url($permalink); ?>">
            <?php 
            echo wp_get_attachment_image(
                $thumbnail_id, 
                'medium', 
                false, 
                array(
                    'alt' => esc_attr($image_alt),
                    'class' => 'news-thumbnail'
                )
            ); 
            ?>
        </a>
    <?php endif; ?>
    
    <div class="meta">
        <?php
            if ( "events" == $post_type ) :
                ?>

                <span class="category">
                    <?php pll_e('Events', 'baza'); ?>
                </span>

                <?php
                if ( ! empty( $shedule_date ) ):
                ?>

                <div class="date">
                    <?php echo esc_html(date_i18n(get_option('date_format') . ', ' . get_option('time_format'), strtotime($shedule_date))); ?>
                </div>
            
                <?php
                endif;
            else:
            ?>
                <span class="category">
                    <?php pll_e('News', 'baza'); ?>
                </span>

                <div class="date">
                    <?php echo esc_html( get_the_date( '', $post_ID ) ); ?>
                </div>
        <?php endif; ?>
    </div>
    
    <h3 class="title">
        <a href="<?php echo esc_url($permalink); ?>">
            <?php echo esc_html($title); ?>
        </a>
    </h3>
    
    <?php if (!empty($excerpt)): ?>
        <div class="excerpt">
            <?php 
                $clean_excerpt = str_replace( '&nbsp;', ' ', wp_strip_all_tags( $excerpt ) );
                echo esc_html( wp_trim_words($clean_excerpt, 20, '...') );
            ?>
        </div>
    <?php endif; ?>

    <div class="item-footer">
        <a href="<?php echo esc_url($permalink); ?>" class="more-link">
            <i class="icon-arrow"></i>
        </a>
    </div>
</div>