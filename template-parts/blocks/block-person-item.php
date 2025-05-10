<?php
/**
 * This template is included in wp-content/themes/mib/template-parts/sections/students-section.php
 */
?>
<div class="item">
    <?php
    if ( ! empty( $image_id ) ) :
        ?>
        <div class="image">
            <img src="<?php echo esc_attr( $image_url )?>" alt="<?php echo esc_attr( $image_alt )?>">
        </div>
        <?php
    endif;
    ?>

    <div class="heading">
        <div class="title">
            <span class="name">
                <?php
                echo wp_kses_post( $title );
                ?>
            </span>

            <?php
            if ( ! empty( $position ) ) :
            ?>
                <span class="position">
                    <?php
                        pll_e( wp_kses_post( $position ), 'baza' );
                    ?>
                </span>
                <?php
            endif;
            ?>
        </div>
        <?php
        if ( ! empty( $companies ) ) :
            ?>
            <div class="logo">
                <?php
                foreach ( $companies as $company ) :
                    $company_logo_id = get_term_meta( $company->term_id, '_company_logo', true );
                    $logo_src        = wp_get_attachment_image_url( $company_logo_id );
                    ?>
                    <img src="<?php echo esc_url( $logo_src )?>" alt="<?php echo esc_attr( $company->name )?>">
                    <?php
                endforeach;
                ?>
            </div>
            <?php
        endif;
        ?>
    </div>

    <?php
    if ( ! empty( $reviwe_message ) ) :
        ?>
        <div class="quote">
            <?php
                pll_e( wp_kses_post( $reviwe_message ), 'baza' );
            ?>
        </div>
        <?php
    endif;
    ?>

    <div class="item-footer">
        <div class="completed">
        <?php
        if ( ! empty( $courses ) ) :
            ?>
            
                <div class="label">
                    <?php pll_e('Completed', 'baza'); ?>:
                </div>

                <div class="completed-items">
                    <?php
                    foreach ( $courses as $course ) :
                        $course_href = get_the_permalink( $course->ID );
                        ?>
                        <a class="completed-item" href="<?php echo $course_href?>">
                            <?php
                            echo $course->post_title;
                            ?>
                        </a>
                        <?php
                    endforeach;
                    ?>
                </div>
            
            <?php
        endif;
        ?>
        </div>
        <a class="show-more-link" href="#"><?php pll_e('More details', 'baza'); ?></a>
        
    </div>
</div>