<?php
    $students = carbon_get_post_meta( $post_id, 'tr_program_students' );
    $per_page = $course_stutents_count ?? 4;

    if ( empty( $students ) ) {
        return;
    }
?>
<div class="accordion-item" id="accordion-stutents">
    <div class="accordion-header">
        <?php
        if ( ! empty( $course_stutents_block_title ) ) :
        ?>
        <div class="accordion-title">
            <?php echo pll__( $course_stutents_block_title ); ?>
        </div>
        <?php
        endif;
        ?>
    </div>

    <div class="accordion-content">
        <div class="program-graduates">
            <div class="items">
                <?php 
                foreach ( $students as $item ) {
                    $item_id        = $item['id'];
                    $post_type      = get_post_type( $item_id );
                    $image_id       = get_post_thumbnail_id( $item_id );
                    $image_url      = wp_get_attachment_url( $image_id );
                    $image_alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                    $title          = get_the_title( $item_id );
                    $position       = get_post_meta( $item_id, '_st_positions_in_companies', true );
                    $reviwe_message = get_post_meta( $item_id, '_st_review_message', true );
                    $arrgs          = [
                        'post_type' => 'students',
                        'post_id'   => $item_id,
                        'field'     => 'tr_program_students'
                    ];
                    $courses        = apply_filters( 'mib_get_posts_relationships', $arrgs );
                    $companies      = wp_get_post_terms( $item_id, 'companies' );

                    include get_template_directory() . '/template-parts/blocks/block-person-item.php';
                }
                ?>
            </div>
        </div>
    </div>
</div>    