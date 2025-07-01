<?php
if ( empty( $results_course_items ) ) {
    return;
}
?>
<div class="results-course-multiple">
    <?php
    if ( ! empty( $results_course_m_title ) ) :
        ?>
        <h3>
            <?php pll_e( $results_course_m_title, 'baza' ); ?>
        </h3>
        <?php
    endif;

    if ( ! empty( $results_course_m_subtitle ) ) :
    ?>
        <span class="subtitle">
            <?php pll_e( $results_course_m_subtitle, 'baza' ); ?>
        </span>
    <?php
    endif;
    ?>

    <div class="items">
        <?php
        foreach( $results_course_items as $item_key => $item  ) :
        ?>
        <div class="item">
            <?php
            if ( ! empty( $item['results_course_item_first_title'] ) ) :
            ?>
            <h4>
                <?php pll_e( $item['results_course_item_first_title'], 'baza' ); ?>
            </h4>
            <?php
            endif;

            if ( ! empty( $item['results_course_item_first_part'] ) ) :
                pll_e( $item['results_course_item_first_part'], 'baza' );
            endif;

            if ( ! empty( $item['results_course_item_second_part'] ) ) :
            ?>
            <div class="bottom-part">
                <?php
                if ( ! empty( $item['results_course_item_second_title'] ) ) :
                ?>
                <div class="hending">
                    <?php
                    pll_e( $item['results_course_item_second_title'], 'baza' );
                    ?>
                </div>
                <?php
                endif;
                ?>
                <div class="collapse-content">
                    <?php
                        pll_e( $item['results_course_item_second_part'], 'baza' );
                    ?>
                </div>
            </div><!-- .bottom-part -->
            <?php
            endif;

            if ( ! empty( $item['results_course_m_short_infos'] ) ) :
            ?>
            <div class="short-infos">
                <?php
                foreach( $item['results_course_m_short_infos'] as $info_item ) :
                ?>
                <div class="item">
                    <?php
                    if ( ! empty( $info_item['rcm_fact_icon'] ) ) :
                        $icon_src = esc_url( wp_get_attachment_image_url( $info_item['rcm_fact_icon'] ) );
                    ?>
                    <img src="<?php echo $icon_src?>" alt="">
                    <?php
                    endif;
                    ?>
                    <div class="text-side">
                    <?php
                    if ( ! empty( $info_item['rcm_fact_name'] ) ) :
                    ?>
                    <span class="item-name">
                        <?php
                        pll_e( $info_item['rcm_fact_name'], 'baza' );
                        ?>
                    </span>
                    <?php
                    endif;

                    if ( ! empty( $info_item['rcm_fact_content'] ) ):
                    ?>
                    <p>
                        <?php
                        pll_e( $info_item['rcm_fact_content'], 'baza' );
                        ?>
                    </p>
                    <?php
                    endif;
                    ?>
                    </div>
                </div>
                <?php
                endforeach;
                ?>
            </div><!-- .short-infos -->
            <?php
            endif;
            ?>
        </div><!-- .item -->
        <?php
        endforeach;
        ?>
    </div><!-- .items -->
</div><!-- .results-course-multiple -->