<?php
$accreditations = apply_filters( 'mib_get_posts', 'accreditations', $accreditations_posts_per_page );
?>
<section class="section section-accreditations">
    <div class="container">
        <div class="section-heiding">
            <?php
            if ( ! empty( $accreditations_posts_title ) ) :
                ?>
                <div class="section-title">
                    <?php echo esc_html( $accreditations_posts_title )?>
                </div>
                <?php
            endif;
            ?>
        </div>

        <div class="items-wrapper">
            <div class="items">
                <?php
                if ( $accreditations->have_posts() ):
                    while( $accreditations->have_posts() ) :
                        $accreditations->the_post();
                        $post_ID        = get_the_ID();
                        $title          = get_the_title();
                        $post_permalink = get_the_permalink();
                        $desc           = get_the_excerpt( $post_ID );
                        $image          = get_post_thumbnail_id( $post_ID );
                        $button_text    = 'View certificate';
                        $is_announcing  = 'yes' == get_post_meta($post_ID, '_tr_program_is_announce', true);
                        $announcing     = $is_announcing ? ' pending' : '';

                        include get_template_directory() . '/template-parts/blocks/block-item.php';

                    endwhile;
                else:
                    echo __( 'Items not found', 'baza' );
                endif;
                ?>
            </div>
        </div>
    </div>
</section>