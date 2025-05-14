<?php
if ( empty( $conditions_list ) ) {
    return;
}
?>
<div class="accordion-item">
    <div class="accordion-header">
        <?php
        if( ! empty( $conditions_block_title ) ) :
        ?>
        <div class="accordion-title">
            <?php echo pll__( $conditions_block_title, 'baza' ); ?>
        </div>
        <?php
        endif;
        ?>
    </div>

    <div class="accordion-content">
        <div class="program-admission-requirements">
            <?php
            foreach( $conditions_list as $condition ) :
            ?>
            <div class="col">
                <?php
                if ( ! empty( $condition['conditions_items_title'] ) ) :
                    ?>
                    <h3><?php pll_e( $condition['conditions_items_title'], 'baza' )?></h3>
                    <?php
                endif;

                if ( ! empty( $condition['condition_element'] ) ) :
                    pll_e( $condition['condition_element'], 'baza' );
                endif;
                ?>
            </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>
</div>