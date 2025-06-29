<?php 

$permalink = isset($url) ? $url : get_the_permalink();
if ( empty( $image_id ) ) {
    $image_url = get_template_directory_uri() . '/assets/images/empty_avatar.svg';
}
?>

<div class="item item-<?php echo $post_type; ?>">

    <div class="image">
        <a href="<?php echo esc_url( $permalink ); ?>">
            <img src="<?php echo esc_attr( $image_url )?>" alt="<?php echo esc_attr( $image_alt )?>">
        </a>
    </div>

    <div class="heading">
        <div class="title">
            <div class="name">
                <a href="<?php echo esc_url( $permalink ); ?>">
                    <?php
                        echo wp_kses_post( $title );
                    ?>
                </a>
            </div>

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
        $company = null;

        if ( function_exists( 'yoast_get_primary_term_id' ) ) :
            $primary_company_id = yoast_get_primary_term_id( 'companies' );
            if ( $primary_company_id ) :
                $company = get_term( $primary_company_id );
            endif;
        endif;

        if ( ! $company && ! empty( $companies ) ) :
            $company = $companies[0];
        endif;

        if ( $company && ! is_wp_error( $company ) ) :
            $company_logo_id = get_term_meta( $company->term_id, '_company_logo', true );
            $logo_src = wp_get_attachment_image_url( $company_logo_id );
            
            if ( $logo_src ) : ?>
                <div class="logo">
                    <img src="<?php echo esc_url( $logo_src )?>" alt="<?php echo esc_attr( $company->name )?>">
                </div>
            <?php endif;
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
                    <?php pll_e( 'man' == $gender ? 'Completed' : 'She graduated', 'baza' ); ?>:
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
        
        <a class="show-more-link" href="<?php echo esc_url( $permalink ); ?>"><?php pll_e('More details', 'baza'); ?></a>
    </div>
</div>