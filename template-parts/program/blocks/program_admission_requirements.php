<?php
if ( 'yes' == $use_admission_conditions &&  empty( $conditions_list ) ||
     'no' == $use_admission_conditions && empty( $admission_requirements_tab_content )  ) {
        return;
     }
?>
<div id="tab-admission-requirements" class="tab-content">
    <div class="program-admission-requirements">
        <?php
        if ( 'yes' == $use_admission_conditions &&  ! empty( $conditions_list ) ):
            if( ! empty( $conditions_block_title ) ) :
                ?>
                <h3>
                    <?php echo pll__( $conditions_block_title, 'baza' ); ?>
                </h3>
                <?php      
            endif;

            foreach( $conditions_list as $condition ) :
                if ( ! empty( $condition['conditions_items_title'] ) ) :
                    ?>
                    <h2><?php pll_e( $condition['conditions_items_title'], 'baza' )?></h2>
                    <?php
                endif;

                if ( ! empty( $condition['condition_element'] ) ) :
                    pll_e( $condition['condition_element'], 'baza' );
                endif;
            endforeach; 
        elseif ( 'no' == $use_admission_conditions || ! empty( $admission_requirements_tab_content ) ) :
            if ( ! empty( $admission_requirements_tab_title ) ) :
            ?>
            <h3><?php pll_e( $admission_requirements_tab_title, 'baza' )?></h3>
            <?php
            endif;
            
            pll_e( $admission_requirements_tab_content, 'baza' );
        endif;
        ?>
    </div><!-- .program-admission-requirements -->
</div>    