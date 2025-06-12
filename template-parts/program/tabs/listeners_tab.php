<?php
if ( ! $has_listeners ) {
    return;
}
?>
<div id="listeners" class="tab-content">
    <?php
    if ( 'yes' == $use_course_listeners ) :
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

        <?php
        if ( ! empty( $listenrs_block_content ) ) : ?>
            <div class="program-listeners-desctiprion">
                <?php echo $listenrs_block_content; ?>
            </div>
            <?php
        endif;
    
    elseif ( 'no' == $use_course_listeners && ! empty( $listeners_tab_content ) ) :
        echo $listeners_tab_content;
    endif;
    ?>
</div>