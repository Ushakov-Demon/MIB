<?php
/**
 * This template is included in 
 * wp-content/themes/mib/template-parts/sections/accreditations_previews-section.php && 
 * wp-content/themes/mib/template-parts/sections/programs_previews-section.php
 */
$title_text_tag_before = isset( $is_announcing ) && $is_announcing ? "<span>" : "<a href=" . esc_url($post_permalink) . ">";
$title_text_tag_after  = isset( $is_announcing ) && $is_announcing ? "</span>" : "</a>" ;

if ( ! isset( $announcing ) ) {
    $announcing = '';
}
?>
<div class="item<?php echo $announcing?>">
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
    
    <?php if ( ! empty( $desc )): ?>
        <div class="excerpt">
            <?php echo wp_kses_post( $desc ); ?>
        </div>
    <?php endif; ?>

    <?php
    if ( ! isset( $is_announcing ) || ! $is_announcing ) :
    ?>
    <div class="item-footer">
        <a href="<?php echo esc_url( $post_permalink ); ?>" class="show-more-link">
            <?php
                if ( ! empty( $button_text ) ) :
                    pll_e( $button_text, 'baza' );
                else:
                    pll_e( 'Learn more', 'baza' );
            endif; ?>
        </a>
    </div>
    <?php
    endif;
    ?>
</div>