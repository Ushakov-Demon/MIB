<?php
$alternating_posts = apply_filters( 'mib_get_alternating_posts', $actuality_posts_per_page, 2 );
?>

<section class="section section-news">
    <div class="container">

        <div class="section-heiding">
            <?php
            if ( ! empty( $actuality_posts_title ) ) :
            ?>
            <div class="section-title">
                <?php echo esc_html( $actuality_posts_title )?>
            </div>
            <?php
            endif;

            if ( ! empty( $actuality_posts_desc ) ) :
            ?>
            <div class="section-description">
                <?php
                echo nl2br( $actuality_posts_desc );
                ?>
            </div>
            <?php
            endif;
            ?>
        </div>

        <div class="section-filter">
            <ul class="filter" id="filter-news">
                <li class="item filter-all active"><a href="#"><span><?php pll_e('All', 'baza'); ?></span></a></li>
                <li class="item filter-news"><a href="#"><span><?php pll_e('News', 'baza'); ?></span></a></li>
                <li class="item filter-events"><a href="#"><span><?php pll_e('Events', 'baza'); ?></span></a></li>
            </ul>
            <a class="section-link" href="<?php echo esc_url( get_permalink( $actuality_posts_link ) ); ?>"><?php pll_e('All posts', 'baza'); ?></a>
        </div>

        <div class="items-wrapper">
            <div class="items sort-items">
                <?php
                if ( ! empty( $alternating_posts ) ):
                    foreach ( $alternating_posts as $item ) :
                        $post_ID        = $item->ID;
                        $post_type      = $item->post_type;
                        $shedule_date   = 'events' == $post_type ? get_post_meta( $item->ID, '_event_shedule_date', true ) : '';
                        $thumbnail      = get_the_post_thumbnail_url( $item->ID );
                        $title          = $item->post_title;
                        $excerpt        = $item->post_excerpt;
                        $permalink      = get_the_permalink( $item->ID );
            
                    include get_template_directory() . '/template-parts/blocks/news-item.php';

                    endforeach;
                else:
                    echo __( 'Items not found' );
                endif;
                ?>
            </div>
        </div>
    </div>
</section>