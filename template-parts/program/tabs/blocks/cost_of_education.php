<?php
$sale_price          = get_post_meta( $post_id, '_tr_program_sale_price', true );
$sale_price_date_end = get_post_meta( $post_id, '_tr_program_sale_price_date_end', true );
$time_difference     = ! empty( $sale_price_date_end ) ? mib_get_time_difference( $sale_price_date_end ) : ['days' => -1] ; 
?>
<div class="accordion-item" id="accordion-program-cost">
    <div class="accordion-header">
        <?php
        if ( ! empty( $cod_title ) ) :
            ?>
            <div class="accordion-title">
                <?php pll_e( $cod_title, 'baza' ); ?>
            </div>
            <?php
        endif;
        ?>
    </div>

    <div class="accordion-content">
        <div class="program-cost">
            <?php
            echo mib_get_course_price( $post_id );
            ?>
            
            <?php
            if ( 0 < $time_difference['days'] ) :
                $diff_sum = intval( get_post_meta( $post_id, '_tr_program_regular_price', true ) ) - intval( $sale_price );

                $diff_sum_txt = preg_replace( '/(..)(?=(...)*$)/', '$1 ', $diff_sum );

                $info_txt = sprintf( pll__( "<span>Attention!</span> Early registration terms apply to the program.<br>A discount of %s UAH until %s." ), $diff_sum_txt, $sale_price_date_end );
            ?>
            <div class="price-info">
                <?php echo $info_txt ?>
            </div>
            <?php
            endif;

            if ( ! empty( $cod_description ) ) :
            ?>
            <div class="price-info-description">
                <?php
                pll_e( $cod_description, 'baza' );
                ?>
            </div>
            <?php
            endif;
            if ( ! empty( $cod_included_in_coast ) ) :
            ?>
            <div class="price-info-description">
                <?php
                pll_e( $cod_included_in_coast, 'baza' );
                ?>
            </div>
            <?php
            endif;
            ?>
        </div>
    </div>
</div>