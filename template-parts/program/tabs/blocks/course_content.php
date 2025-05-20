<?php
if ( empty( $course_content_items ) ) {
    return;
}
?>
<div class="accordion-item">
    <div class="accordion-header">
        <?php
        if ( ! empty( $course_content_title ) ) :
        ?>
        <div class="accordion-title">
            <?php echo pll__( $course_content_title, 'baza' ); ?>
        </div>
        <?php
        endif;
        ?>
    </div>

    <div class="accordion-content">
        <div class="program-content">
            <?php
            if( ! empty( $course_content_desc ) ) :
                ?>
                <div class="program-content-text">
                    <?php pll_e( $course_content_desc, 'baza' )?>
                </div>
                <?php
            endif;
            ?>
            <div class="program-content-items">
                <?php
                foreach( $course_content_items as $item ) :
                ?>
                <div class="item">
                    <?php
                    if ( ! empty( $item['course_content_item_icon'] ) ) :
                        $icon_src = wp_get_attachment_image_url( $item['course_content_item_icon'], 'full' );
                        ?>
                        <div class="image">
                            <img src="<?php echo esc_url( $icon_src )?>" alt="">
                        </div>
                        <?php
                    endif;

                    if ( ! empty( $item['course_content_item_title'] ) ) :
                        ?>
                        <div class="label">
                            <?php echo pll__( $item['course_content_item_title'], 'baza' )?>
                        </div>
                        <?php
                    endif;

                    if ( ! empty( $item['course_content_item_desc'] ) ) :
                        ?>
                        <div class="text">
                            <?php echo pll__( $item['course_content_item_desc'], 'baza' )?>
                        </div>
                        <?php
                    endif;
                    ?>
                </div>
                <?php
                endforeach;
                ?>
            </div>
        </div>

        <?php
        if ( ! empty( $course_content_btn_label ) && ! empty( $course_content_btn_lnk ) ) :
        ?>
        <div class="program-content-all">
            <a href="<?php echo esc_url( $course_content_btn_lnk )?>" class="show-more-link">
                <?php echo pll__( $course_content_btn_label, 'baza' ); ?>
            </a>
        </div>
        <?php
        endif;
        ?>
    </div>
</div>