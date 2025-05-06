<?php 
$post_id = isset($fields['actuality_event_link']) ? (int) $fields['actuality_event_link'] : 0;

if ( !$post_id ) {
    return;
}

$post             = get_post( $post_id );
$link             = get_permalink( $post_id );
$title            = get_the_title( $post_id );
$excerpt          = apply_filters( 'the_excerpt', $post->post_excerpt );
$shedule_date     = get_post_meta( $post_id, '_event_shedule_date', true );
$timestamp        = strtotime( $shedule_date );
$date_format      = get_option( 'date_format' );
$time_format      = get_option( 'time_format' );
$shedule_date_formatted = wp_date( $date_format, $timestamp );
$shedule_time     = wp_date( $time_format, $timestamp );
?>

<div class="events-header">
    <div class="title">
        <?php echo pll__('Events', 'baza');?>
    </div>
    <a href="" class="show-more-link"><?php echo pll__('All events', 'baza');?></a>
</div>

<section class="section section-main version-hot-event">

    <?php if ( has_post_thumbnail( $post_id ) ): ?>
        <div class="image">
            <?php echo get_the_post_thumbnail( $post_id, 'hero_event_image' ); ?>
        </div>
    <?php endif; ?>

    <div class="container">
        <div class="content">
            <div class="content-header">
                <?php if (!empty($title)) : ?>
                    <h1 class="section-title">
                        <?php 
                            $processed_heading = preg_replace('/\*(.*?)\*/', '<span>$1</span>', $title);
                            echo $processed_heading;
                        ?>
                    </h1>
                <?php endif; ?>

                <?php
                    if(!empty($excerpt)) :
                        $processed_text = preg_replace('/\*(.*?)\*/', '<span>$1</span>', $excerpt);
                        ?>
                        <div class="text text-before">
                            <?php echo $processed_text; ?>
                        </div>
                        <?php
                    endif;
                ?>

                <div class="info">
                    <?php if (!empty($shedule_date_formatted)) : ?>
                        <div class="item item-date">
                            <span><?php echo $shedule_date_formatted; ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($shedule_time)) : ?>
                        <div class="item item-time">
                            <span><?php echo $shedule_time; ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="buttons">
                <a href="<?php echo $link;?>" class="button button-view-event">
                    <span><?php echo pll__('View event', 'baza');?></span>
                </a>
            </div>
        </div>
    </div>
</section>