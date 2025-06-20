<?php
if ( ! $has_structure ) {
    return;
}
?>
<div id="program-content" class="tab-content">
    <div class="program-structure">
        <?php
        if ( 'no' == $use_program_content && isset( $program_structure_tab_title ) && ! empty( $program_structure_tab_title ) ) :
            ?>
            <h3 class="tab-title"><?php echo pll__( $program_structure_tab_title, 'baza' ); ?>:</h3>
            <?php
        endif;

        // echo $program_structure_tab_content;
        if ( 'no' !== $use_program_content && ! empty ( $course_content_items ) ) :
            if ( ! empty( $course_content_title ) ) :
                ?>
                <h3 class="tab-title">
                    <?php echo pll__( $course_content_title, 'baza' ); ?>
                </h3>
                <?php
            endif;
            ?>

            <div class="program-content">

                <div class="program-content-text">
                    <?php pll_e( $course_content_desc, 'baza' )?>
                </div>

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
        endif;

        if ( ! empty( $program_structure_tab_methods ) ) :
            ?>
            <div class="program-methods">
                <?php
                if ( ! empty( $program_structure_tab_methods_title ) ) :
                ?>
                <h3><?php pll_e( $program_structure_tab_methods_title, 'baza' )?></h3>
                <?php
                endif;
                ?>
                <div class="methods-container">
                    <?php
                    foreach ( $program_structure_tab_methods as $method ) :
                        ?>
                        <div class="item"><?php pll_e( $method['program_method'], 'baza' )?></div>
                        <?php
                    endforeach;
                    ?>
                </div>
            </div>
            <?php
        endif;    

        echo $program_structure_tab_content;
        ?>
    </div>
</div>