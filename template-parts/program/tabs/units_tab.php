<?php

$offset  = is_admin_bar_showing() ? 196 : 164;
?>

<div class="tab-content" id="units">
    <div class="program-units">

        <div class="units-items">
            <?php
            foreach ( $units as $key => $unit ):
                $activeClass = ($key === 0) ? ' active' : '';
            ?>
                <div class="unit<?php echo $activeClass; ?>" id="unit-<?php echo $key + 1; ?>" data-unit-title="<?php pll_e( $unit['unit_name'], 'baza' )?>">
                    <?php
                    if ( ! empty( $unit['unit_name'] ) ) :
                    ?>
                    <h3 class="tab-title"><?php pll_e( $unit['unit_name'], 'baza' )?></h3>
                    <?php
                    endif;
                    ?>
                    <div class="modules">
                        <?php
                        foreach ( $unit['unit_modules'] as $module_key =>  $module ) :
                        ?>
                        <div class="item" id="unit-<?php echo $key + 1; ?>-module-<?php echo $module_key + 1; ?>">
                            <?php
                            if ( ! empty( $module['module_name'] ) ) :
                            ?>
                            <h2 class="name">
                                <?php pll_e( 'Module', 'baza' )?> <?php echo $module_key + 1; ?>. <?php echo $module['module_name']?>
                            </h2>
                            <?php
                            endif;
                            ?>
                            <?php
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

        <?php if ( count($units) > 1 ): ?>
            <a class="next-unit-button" href="#units" data-ps2id-offset="<?php echo $offset; ?>" id="next-unit-button">
                <span class="next-unit-conntent"><?php pll_e( 'Next unit', 'baza' )?>: <span id="next-unit-title"></span></span>
                <span class="show-more-link"><?php pll_e( 'View', 'baza' )?></span>
            </a>
        <?php endif; ?>
    </div>
</div>