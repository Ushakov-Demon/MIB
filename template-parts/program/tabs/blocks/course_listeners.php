<div class="accordion-item" id="accordion-program-listeners">
    <div class="accordion-header">
        <?php
        if ( ! empty( $listenrs_block_title ) ) :
            ?>
            <div class="accordion-title">
                <?php echo pll__( $listenrs_block_title ); ?>
            </div>
            <?php
        endif;
        ?>
    </div>

    <div class="accordion-content">
        <?php
        if ( ! empty( $listenrs_block_content ) ) : ?>
            <div class="program-listeners-desctiprion">
                <?php echo $listenrs_block_content; ?>
            </div>
            <?php
            endif;
        ?>
        
        <div class="program-listeners">
            <?php
            if ( ! empty( $lesteners_items_repeater ) ) :
                foreach ( $lesteners_items_repeater as $item ) :
                    $image_src = wp_get_attachment_image_url( $item['listeners_item_image'], 'large' );
                    ?>
                    <div class="item">
                        <img src="<?php echo esc_url( $image_src )?>" alt="">
                    </div>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</div>