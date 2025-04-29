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
        
        <?php if ( ! empty( $history_description ) ) : ?>
            <div class="description">
                <?php echo wp_kses_post( $history_description ); ?>
            </div>
        <?php endif; ?>
        
        <div class="items owl-carousel" id="history-timeline-items">
            <?php foreach ( $history_items as $item ) :
            
                $year = $item['history_item_year'];
                $image_id =  wp_get_attachment_image( $item['history_item_image'], 'medium_large' );
                $description = $item['history_item_description'];
            ?>
                <div class="timeline-item">
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
            <?php endforeach; ?>
        </div>
    </div>
</section>