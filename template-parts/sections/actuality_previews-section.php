<?php
$post_id               = get_the_ID();
$per_page              = $actuality_posts_per_page ?? 4;
$actuality_post_type   = isset( $actuality_post_type ) ? $actuality_post_type : 'mixed';
$alternating_posts     = [];
$events_arhive_page    = get_option( '_events_arhive_page' );
$is_events_achive      = $post_id == $events_arhive_page;
$pagination_class      = isset( $actuality_posts_section_pagination ) && 'on' == $actuality_posts_section_pagination ? ' section-news-list': '';
$actuality_posts_title = isset( $actuality_posts_title ) ? $actuality_posts_title : pll__( 'Actual' );

if ( "mixed" == $actuality_post_type ) {
    $alternating_posts = apply_filters( 'mib_get_alternating_posts', $per_page );
} else {
    $posts_query = mib_get_posts( $actuality_post_type, $per_page );

    $alternating_posts['posts']         = $posts_query->posts;
    $alternating_posts['max_num_pages'] = $posts_query->max_num_pages;
    $alternating_posts['page']          = $posts_query->page;

}

$max_num_pages    = $alternating_posts['max_num_pages'];
$current_page_num = $alternating_posts['page'];
?>

<section class="section section-news<?php echo esc_attr( $pagination_class )?>"
         data-page-id="<?php echo esc_attr( get_the_ID() )?>"
         data-type="<?php echo $actuality_post_type?>"
         data-per-page="<?php echo esc_attr( $actuality_posts_per_page )?>"
         data-max-pages="<?php echo esc_attr( $max_num_pages )?>"
         data-current-page_num="<?php echo esc_attr( $current_page_num )?>">
    <div class="container">

        <?php
        if ( ! empty( $actuality_posts_title ) ) :
            ?>
            <div class="section-heiding">
                <div class="section-title">
                    <?php echo esc_html( $actuality_posts_title )?>
                </div>

                <?php  if ( ! empty( $actuality_posts_desc ) ) :
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
            <?php
        endif;
        ?>

        <?php 
        if ( 'mixed' == $actuality_post_type ) :
            ?>
            <div class="section-filter">
                <ul class="filter" id="filter-news">
                    <li class="item filter-all active" data-target="all">
                        <a href="#" class="filter-link">
                            <span>
                                <?php pll_e( 'All', 'baza' ); ?>
                            </span>
                        </a>
                    </li>

                    <li class="item filter-news" data-target="news">
                        <a href="#" class="filter-link">
                            <span>
                                <?php pll_e( 'News', 'baza' ); ?>
                            </span>
                        </a>
                    </li>

                    <li class="item filter-events" data-target="events">
                        <a href="#" class="filter-link">
                            <span>
                                <?php pll_e( 'Events', 'baza' ); ?>
                            </span>
                        </a>
                    </li>
                </ul>

                <?php
                if ( ! $is_events_achive && ! empty( $actuality_posts_link ) ) :
                    ?>
                    <a class="section-link" href="<?php echo esc_url( get_permalink( $actuality_posts_link ) ); ?>">
                        <?php pll_e( 'All posts', 'baza' ); ?>
                    </a>
                    <?php
                endif;
                ?>
            </div>
            <?php 
        endif;
        ?>

        <div class="items-wrapper">
            <div class="items sort-items">
                <?php
                if ( ! empty( $alternating_posts['posts'] ) ):
                    foreach ( $alternating_posts['posts'] as $item ) :
                        $post_ID        = $item->ID;
                        $post_type      = $item->post_type;
                        $shedule_date   = 'events' == $post_type ? get_post_meta( $item->ID, '_event_shedule_date', true ) : '';
                        $thumbnail      = get_the_post_thumbnail_url( $item->ID );
                        $title          = $item->post_title;
                        $excerpt        = $item->post_excerpt;
                        $permalink      = get_the_permalink( $item->ID );
            
                    include get_template_directory() . '/template-parts/blocks/news-item.php';

                    endforeach;
                    if ( isset( $actuality_posts_section_pagination ) && 'on' == $actuality_posts_section_pagination && $current_page_num < $max_num_pages ) {
                        include get_template_directory() . '/template-parts/blocks/block-show-more.php';
                    };
                else:
                    echo __( 'Items not found', 'baza' );
                endif;
                ?>
            </div>
        </div>

    </div>
</section>