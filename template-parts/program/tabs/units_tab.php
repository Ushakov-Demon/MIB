<div class="tab-content" id="units">
    <div class="program-units">
        <h3><?php echo pll__('Units'); ?></h3>
    </div>

    <div class="units-items">
        <?php
        foreach ( $units as $key => $unit ):
        ?>
            <div class="unit" id="unit-{$key}">
                <?php
                if ( ! empty( $unit['unit_name'] ) ) :
                ?>
                <h4 class="unit-title"><?php pll_e( $unit['unit_name'], 'baza' )?></h4>
                <?php
                endif;
                ?>
                <div class="modules">
                    <?php
                    foreach ( $unit['unit_modules'] as $module ) :
                    ?>
                    <div class="item">
                        <?php
                        if ( ! empty( $module['module_name'] ) ) :
                        ?>
                        <h4><?php pll_e( $module['module_name'], 'baza' )?></h4>
                        <?php
                        endif;

                        if ( ! empty( $module['module_content'] ) ) :
                        ?>
                        <div class="content">
                            <?php echo $module['module_content']?>
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
        endforeach;
        ?>
    </div>
</div>