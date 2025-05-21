<div class="accordion-item">
    <div class="accordion-header">
        <?php
        if ( ! empty( $listenrs_block_title ) ) :
            ?>
            <div class="accordion-title">
                <?php echo pll__( $listenrs_block_title ); ?>
            </div><!-- .accordion-title -->
            <?php
        endif;
        ?>
    </div><!-- .accordion-header -->

    <div class="accordion-content">
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
        </div><!-- .program-listeners -->

        <?php
        if ( ! empty( $listenrs_block_content ) ) :
            echo $listenrs_block_content;
        endif;
        ?>
    </div><!-- .accordion-content -->
</div><!-- .accordion-item -->