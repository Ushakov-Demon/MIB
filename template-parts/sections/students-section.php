<?php
$is_slider  = 'slider' == $students_section_items_view_style;
$view_class = $is_slider ? ' owl-carousel' : '';
$wrap_id    = $is_slider ? 'students-items' : 'students-items-list';
$students   = apply_filters( 'mib_get_posts', 'students', $students_per_page );

?>
<section class="section section-students">
    <div class="container">
        
        <?php if ( ! empty($students_section_title) ) : ?>
            <div class="section-title">
                <span>
                    <?php
                        pll_e( $students_section_title, 'baza' );
                    ?>                  
                </span>

                <?php
                if ( ! empty( $students_section_link_to ) ) :
                    $link = get_permalink( $students_section_link_to );
                    ?>
                    <a class="section-link" href="<?php echo esc_url( $link )?>">
                        <?php
                            pll_e( $students_section_link_text, 'baza' );
                        ?>
                    </a>
                    <?php
                endif;
                ?>
            </div>
        <?php endif; ?>

        <div class="items<?php echo esc_attr( $view_class )?>" id="<?php echo esc_attr( $wrap_id )?>">
            <?php
                if ( $students->have_posts() ) {
                    while ( $students->have_posts() ) {
                        $students->the_post();
                        $post_type      = get_post_type();
                        $item_id        = get_the_ID();
                        $image_id       = get_post_thumbnail_id();
                        $image_url      = wp_get_attachment_url( $image_id );
                        $image_alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                        $title          = get_the_title();
                        $position       = get_post_meta( $item_id, '_st_positions_in_companies', true );
                        $reviwe_message = get_post_meta( $item_id, '_st_review_message', true );
                        $courses        = apply_filters( 'mib_get_posts_relationships', array( 'post_type' => 'students', 'post_id' => $item_id, 'field' => 'tr_program_students' ) );
                        $companies      = wp_get_post_terms( $item_id, 'companies' );

                        include get_template_directory() . '/template-parts/blocks/block-person-item.php';
                    }
                }
            ?>
        </div>
    </div>
</section>