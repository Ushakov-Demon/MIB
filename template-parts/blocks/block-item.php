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
<?php if ( ! isset( $is_announcing ) || ! $is_announcing ) :?>
<a class="item<?php echo $announcing?>" href="<?php echo esc_url( $post_permalink ); ?>">
<?php else : ?>
<div class="item pending">
<?php endif; ?>

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
        <span>
            <?php echo esc_html($title); ?>
        </span>
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
        <span class="show-more-link">
            <?php
                if ( ! empty( $button_text ) ) :
                    pll_e( $button_text, 'baza' );
                else:
                    pll_e( 'Learn more', 'baza' );
            endif; ?>
        </span>
    </div>
    <?php
    endif;
    ?>
<?php if ( ! isset( $is_announcing ) || ! $is_announcing ) :?>
</a>
<?php else : ?>
</div>
<?php endif; ?>