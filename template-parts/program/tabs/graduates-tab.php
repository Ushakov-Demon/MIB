<?php
$students = carbon_get_post_meta( $post_id, 'tr_program_students' );
?>
<div id="tab-graduates" class="tab-content">
    <div class="program-graduates">
        <h3 class="tab-title"><?php echo pll__('Students'); ?></h3>

        <div class="items">
            <?php 
                if ( ! empty( $students ) ) {
                    foreach ( $students as $item ) {
                        $item_id        = $item['id'];
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
                }
            ?>
        </div>
    </div>
</div>