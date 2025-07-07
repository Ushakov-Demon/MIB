<?php
if ( empty( $results_course_items ) && empty( $results_course_m_title ) ) {
    return;
}
?>
<div class="program-results-course-multiple">
    <div class="program-results-course-multiple-title">
        <?php
        if ( ! empty( $results_course_m_title ) ) :
            ?>
            <h3 class="title">
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
    </div>

    <div class="program-results-courses">
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
            <div class="accordion-item" id="program-results-courses-accordion-<?php echo $item_key; ?>">
                <?php
                if ( ! empty( $item['results_course_item_second_title'] ) ) :
                ?>
                <div class="accordion-header">
                    <div class="accordion-title">
                        <?php
                            pll_e( $item['results_course_item_second_title'], 'baza' );
                        ?>
                    </div>
                </div>
                <?php
                endif;
                ?>
                <div class="accordion-content">
                    <?php
                    pll_e( $item['results_course_item_second_part'], 'baza' );

                    if ( ! empty( $item['results_course_m_short_infos'] ) ) :
                    ?>
                    <div class="short-info">
                        <?php
                        foreach( $item['results_course_m_short_infos'] as $info_item ) :
                        ?>
                        <div class="short-info-item">
                            <?php
                            if ( ! empty( $info_item['rcm_fact_icon'] ) ) :
                                $icon_src = esc_url( wp_get_attachment_image_url( $info_item['rcm_fact_icon'] ) );
                            ?>
                            <div class="short-info-image">
                                <img src="<?php echo $icon_src?>" alt="<?php pll_e( $info_item['rcm_fact_name'], 'baza' ); ?>">
                            </div>
                            <?php
                            endif;
                            ?>
                            <div class="short-info-text">
                            <?php
                            if ( ! empty( $info_item['rcm_fact_name'] ) ) :
                            ?>
                            <div class="short-info-name">
                                <?php
                                pll_e( $info_item['rcm_fact_name'], 'baza' );
                                ?>
                            </div>
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
                    </div>
                    <?php
                    endif;
                    ?>
                </div>
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