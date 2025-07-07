<?php

$page_id = get_the_ID();
$offset  = is_admin_bar_showing() ? 196 : 164;

if ( empty( $free_content ) && empty( $program_missions ) ) {
    return;
}

$is_sidebar = ( !empty( $units[0]['unit_modules'] ) || !empty( $program_missions ) );
?>
<div class="program-content-row<?php if ( $is_sidebar ) : ?> issidebar<?php endif; ?>">
    <?php
    if ( ! empty( $free_content ) ) :
    ?>
    <div class="program-main">
        <?php
        echo $free_content;
        ?>
    </div>
    <?php
    endif;
    ?>

    <?php if ( $is_sidebar ) : ?><div class="program-sidebar"><?php endif; ?>

        <?php if ( !empty( $units[0]['unit_modules'] ) ) : ?>

            <div class="units">

            <div class="units-sidebar-title">
                <?php pll_e( 'Program start dates', 'baza' )?> <?php echo get_the_title( $page_id ); ?>
            </div>

            <?php 
            foreach ( $units as $key => $unit ):
                $activeClass = ($key === 0) ? ' active' : '';
            ?>
                <div class="unit">
                    <?php
                    if ( ! empty( $unit['unit_name'] ) ) :
                    ?>
                        <h3 class="units-title"><?php pll_e( $unit['unit_name'], 'baza' )?></h3>
                    <?php
                    endif;
                    ?>
                    <div class="modules">
                        <?php
                        foreach ( $unit['unit_modules'] as $module_key => $module ) :
                        ?>
                            <div class="item">
                                <i class="icon-calendar"></i>
                                <a class="link unit-module-link" 
                                    href="#units" 
                                    data-ps2id-offset="<?php echo $offset; ?>" 
                                    data-unit="unit-<?php echo $key + 1; ?>" 
                                    data-module="module-<?php echo $module_key + 1; ?>">
                                    <?php pll_e( 'Module', 'baza' )?> <?php echo $module_key + 1; ?>
                                </a>
                                <div class="shedule"><?php echo $module['module_shedule']; ?></div>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
            <?php
            endforeach; ?>
        </div>

        <?php 
        endif; 

        if ( ! empty( $program_missions ) ) :
        ?>
        <div class="program-mission">
            <?php
                echo $program_missions;
            ?>
        </div>
        <?php
        endif;
        ?>

    <?php if ( $is_sidebar ) : ?></div><?php endif; ?>
</div>