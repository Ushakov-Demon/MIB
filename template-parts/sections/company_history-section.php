<?php
// Check if we have items
if ( empty( $history_items ) ) return;
?>

<section class="section section-history">
    <div class="container">
        <?php if ( ! empty( $history_title ) ) : ?>
            <h1 class="section-title">
                <?php echo wp_kses_post( $history_title ); ?>
            </h1>
        <?php endif; ?>
        
        
            <div class="description">
                <?php if ( ! empty( $history_description ) ) : ?>
                    <div class="description-text">
                        <?php echo wp_kses_post( $history_description ); ?>
                    </div>
                <?php endif; ?>
                <div class="owl-outside">
                    <div class="owl-nav" id="history-timeline-nav">
                        <button type="button" role="presentation" class="owl-prev"><i class="icon-arrow"></i></button>
                        <button type="button" role="presentation" class="owl-next"><i class="icon-arrow"></i></button>
                    </div>
                </div>
            </div>

        <div class="items-wrapper">

            <div class="items owl-carousel" id="history-timeline-items">
                <?php foreach ( $history_items as $item ) :
                
                    $year = $item['history_item_year'];
                    $image_id =  wp_get_attachment_image( $item['history_item_image'], 'medium_large' );
                    $description = $item['history_item_description'];
                ?>
                    <div class="timeline-item">

                        <div class="timeline">
                            <div class="bar bar-tall"></div>
                            <div class="bar bar-short"></div>
                            <div class="bar bar-short"></div>
                            <div class="bar bar-short"></div>
                            <div class="bar bar-tall"></div>
                            <div class="bar bar-short"></div>
                            <div class="bar bar-short"></div>
                            <div class="bar bar-short"></div>
                            <div class="bar bar-tall"></div>
                        </div>

                        <div class="timeline-conntent">
                            
                            <?php if ( ! empty( $year ) ) : ?>
                                <div class="timeline-year">
                                    <span><?php echo wp_kses_post( $year ); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( ! empty( $image_id ) ) : ?>
                                <div class="timeline-image">
                                    <?php echo $image_id; ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( ! empty( $description ) ) : ?>
                                <div class="timeline-description">
                                    <?php echo wp_kses_post( $description ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>