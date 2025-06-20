<?php
    $post_id                    = get_the_ID(); 
    $is_home                    = is_front_page();
    $post_type                  = get_post_type( $post_id );
    $is_events_arhive           = $post_id == get_option( '_events_arhive_page' );
    $is_programs_archive        = $post_id == get_option( '_programs_arhive_page' );
    $is_tax                     = is_tax();
    $is_programs_tax            = is_tax('program_category');
    $main_top_heading_text      = ! empty( $main_top_heading_text ) ? $main_top_heading_text : get_the_title();
    $main_top_version          .= ($post_type === 'programs') ? ' version-program' : '';
?>
<section class="section section-main<?php if ( !empty( $main_top_version ) ) : ?> version-<?php echo $main_top_version; ?><?php endif; ?>">
    
    <?php if( !$is_home ) :?>
        <?php display_breadcrumbs(); ?>
    <?php endif; ?>

    <div class="container">
        <div class="content">
            <div class="content-header">
                <?php if ( ! empty( $main_top_heading_media_before_text ) ) : ?>
                    <div class="image-before">
                        <?php
                            $before_img_atts = wp_get_attachment_image_src( $main_top_heading_media_before_text, 'full' );
                            $before_img_alt  = get_post_meta( $main_top_heading_media_before_text, '_wp_attachment_image_alt', true );
                        ?>
                        <img 
                            src="<?php echo esc_url( $before_img_atts[0] ); ?>" 
                            width="<?php echo esc_attr( $before_img_atts[1] ); ?>" 
                            height="<?php echo esc_attr( $before_img_atts[2] ); ?>" 
                            alt="<?php echo esc_attr( $before_img_alt ); ?>" 
                            class="before-image"
                        >
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $main_top_heading_text )) : ?>
                    <div class="section-title">
                        <?php 
                        $processed_heading = preg_replace( '/\*(.*?)\*/', '<span>$1</span>', $main_top_heading_text );
                        echo $processed_heading;
                        ?>
                    </div>
                <?php endif; ?>

                <?php
                    if ( ! empty( $main_bottom_text ) ) :
                        $processed_bottom_text = preg_replace( '/\*(.*?)\*/', '<span>$1</span>', $main_bottom_text );
                        ?>
                        <div class="text text-before">
                            <?php echo wp_kses_post( $processed_bottom_text ); ?>
                        </div>
                        <?php
                    endif;

                    if ( "programs" == $post_type && ! $is_tax ) {
                        include_once get_template_directory() . '/template-parts/blocks/block-certificate-logo.php';
                    }
                ?>
            </div>

            <?php if( ! $is_tax ): ?>

                <?php 
                    if ( "programs" !== $post_type && ! $is_events_arhive ) : 
                    ?>

                    <?php if( ! empty( $main_bottom_buttons ) ): ?>
                        <div class="buttons">
                            <?php foreach ( $main_bottom_buttons as $button ) : 
                                $button_text = isset( $button['button_text'] ) ? $button['button_text'] : '';
                                $button_link = isset( $button['button_link'] ) ? $button['button_link'] : '#';
                            ?>
                                <a href="<?php echo esc_url( $button_link ); ?>" class="button">
                                    <span><?php echo esc_html( $button_text ); ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    elseif ( $is_programs_archive ) :
                        include_once get_template_directory() . '/template-parts/blocks/block-programs-categories-buttons.php';
                    elseif ( "programs" == $post_type ) :
                        include_once get_template_directory() . '/template-parts/blocks/hero-single-program-bottom.php';
                        ?>
                        <div class="buttons">
                            <a href="#form-request" class="button button-register" data-ps2id-offset="123">
                                <span>
                                    <?php pll_e( 'Sign up for the program', 'baza' ); ?>
                                </span>
                            </a>
                            <?php echo mib_get_course_price( $post_id ); ?>
                        </div>
                    <?php
                endif;

                if ( ! empty( $main_bottom_second_text ) && ! $is_events_arhive ) :
                    $processed_second_text = preg_replace( '/\*(.*?)\*/', '<span>$1</span>', $main_bottom_second_text );
                    ?>
                    <div class="text text-after">
                        <?php echo wp_kses_post( $processed_second_text ); ?>
                    </div>
                    <?php                    
                endif;
                ?>

            <?php endif; ?>

            <?php if( $is_programs_tax ): ?>
                <?php echo mib_display_program_category_summary();  ?>
            <?php endif; ?>

        </div>

        <?php if ( ! empty( $main_top_heading_media ) ) : ?>
        <div class="image">
            <?php if ( ! empty( $main_top_heading_bg ) ) : ?>
                <div class="section-background">
                    <?php
                        $bg_img_atts = wp_get_attachment_image_src( $main_top_heading_bg, 'full' );
                        $bg_img_alt = get_post_meta( $main_top_heading_bg, '_wp_attachment_image_alt', true );
                    ?>
                    <img 
                        src="<?php echo esc_url( $bg_img_atts[0] ); ?>" 
                        width="<?php echo esc_attr( $bg_img_atts[1] ); ?>" 
                        height="<?php echo esc_attr( $bg_img_atts[2] ); ?>" 
                        alt="<?php echo esc_attr( $bg_img_alt ); ?>" 
                        class="background-image"
                    >
                </div>
            <?php endif; ?>

            <?php
                $main_img_atts = wp_get_attachment_image_src( $main_top_heading_media, 'full' );
                $main_img_alt  = get_post_meta( $main_top_heading_media, '_wp_attachment_image_alt', true );
            ?>
            <img 
                src="<?php echo esc_url( $main_img_atts[0] ); ?>" 
                width="<?php echo esc_attr( $main_img_atts[1] ); ?>" 
                height="<?php echo esc_attr( $main_img_atts[2] ); ?>" 
                alt="<?php echo esc_attr( $main_img_alt ); ?>" 
                class="main-image"
            >
        </div>
        <?php endif; ?>
    </div>
</section>