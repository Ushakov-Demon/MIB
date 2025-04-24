<?php

$alternating_posts = apply_filters( 'mib_get_alternating_posts', 5, 2 );
?>

<section class="actualy">
    <div class="section-heiding">
        <?php
        if ( ! empty( $actuality_posts_title ) ) :
        ?>
        <h2 class="section-title">
            <?php echo esc_html( $actuality_posts_title )?>
        </h2>
        <?php
        endif;

        if ( ! empty( $actuality_posts_desc ) ) :
        ?>
        <div class="hending-desc">
            <?php
            echo esc_html( $actuality_posts_desc );
            ?>
        </div>
        <?php
        endif;
        ?>
    </div>

    <div class="filter-wrap">
        <!-- Filter items html -->
    </div>

    <div class="section-body">
        <?php
        if ( ! empty( $alternating_posts ) ):
            foreach ( $alternating_posts as $item ) :
                $post_type      = $item->post_type;
                $shedule_date   = 'events' == $post_type ? get_post_meta( $item->ID, '_event_shedule_date', true ) : '';
                $thumbnail      = get_the_post_thumbnail_url( $item->ID );
                $title          = $item->post_title;
                $excerpt        = $item->post_excerpt;
                $permalink      = get_the_permalink( $item->ID );
        ?>

        <?php
            endforeach;
        else:
            // TODO: Need create && include template
            echo __( 'Items not found' );
        endif;
        ?>
    </div>
</section>