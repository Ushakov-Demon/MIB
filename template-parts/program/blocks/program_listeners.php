<?php
if ( ! $has_listeners ) {
    return;
}
?>
<div id="tab-listeners" class="tab-content">
    <h3 class="tab-title"><?php echo pll__('Listeners', 'baza'); ?></h3>
    
    <?php
    if ( ! empty( $listners_tab_repeater ) ) :
        ?>
        <div class="program-listeners">
            <?php
            foreach ( $listners_tab_repeater as $item ) :
                $image_src = wp_get_attachment_image_url( $item['listners_image'], 'large' );
                ?>
                <div class="item">
                    <img src="<?php echo esc_url( $image_src )?>" alt="">
                </div>
                <?php
            endforeach;
            ?>
        </div>
        <?php
    endif;

    if ( ! empty( $listners_tab_content ) ) :
        echo $listners_tab_content;
    endif;
    ?>
</div>