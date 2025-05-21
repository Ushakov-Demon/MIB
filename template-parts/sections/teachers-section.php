<?php
$is_slider  = 'slider' == $teachers_section_items_view_style;
$view_class = $is_slider ? ' owl-carousel' : '';
$wrap_id    = $is_slider ? 'teachers-items' : 'teachers-items-list';
$teachers   = mib_get_posts( 'teachers', $teachers_per_page );
?>
<section class="section section-teachers">
    <div class="container">
        
        <?php if ( ! empty($teachers_section_title) ) : ?>
            <div class="section-title">
                <span>
                    <?php
                        pll_e( $teachers_section_title, 'baza' );
                    ?>                  
                </span>

                <?php
                if ( ! empty( $teachers_section_link_to ) ) :
                    $link = get_permalink( $teachers_section_link_to );
                    ?>
                    <a class="section-link" href="<?php echo esc_url( $link )?>">
                        <?php
                            pll_e( $teachers_section_link_text, 'baza' );
                        ?>
                    </a>
                    <?php
                endif;
                ?>
            </div>
        <?php endif; ?>

        <div class="items<?php echo esc_attr( $view_class )?>" id="<?php echo esc_attr( $wrap_id )?>">
            <?php
                if ( $teachers->have_posts() ) {
                    while ( $teachers->have_posts() ) {
                        $teachers->the_post();
                        $item_id        = get_the_ID();
                        $post_type      = get_post_type( $item_id );
                        $image_id       = get_post_thumbnail_id();
                        $image_url      = wp_get_attachment_url( $image_id );
                        $image_alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                        $title          = get_the_title();
                        $position       = get_post_meta( $item_id, '_positions_in_companies', true );
                        $specializations = wp_get_post_terms( $item_id, 'teacher_specializations' );
                        $companies      = wp_get_post_terms( $item_id, 'companies' );

                        include get_template_directory() . '/template-parts/blocks/block-person-item.php';
                    }
                }
            ?>
        </div>
    </div>
</section>