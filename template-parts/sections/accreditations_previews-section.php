<?php
$accreditations = apply_filters( 'mib_get_posts', 'accreditations', $accreditations_posts_per_page );
?>
<section class="accreditations">
    <div class="section-heiding">
        <?php
        if ( ! empty( $accreditations_posts_title ) ) :
            ?>
            <h2 class="section-title">
                <?php echo esc_html( $accreditations_posts_title )?>
            </h2>
            <?php
        endif;
        ?>
    </div>

    <div class="section-body">
        <?php
        if ( $accreditations->have_posts() ):
            while( $accreditations->have_posts() ) :
                $accreditations->the_post();
                $post_ID        = get_the_ID();
                $title          = get_the_title();
                $post_permalink = get_the_permalink();
                $desc           = get_the_excerpt( $post_ID );
        ?>
        <!-- single item HTML -->
        <?php
            endwhile;
        else:
            // TODO: Need create && include template
            echo __( 'Items not found' );
        endif;
        ?>
    </div>
</section>