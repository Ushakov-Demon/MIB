<div class="program-graduates">
    <div class="items">
        <?php 
            $students = mib_get_posts( 'students' );
            
            if ( $students->have_posts() ) {
                while ( $students->have_posts() ) {
                    $students->the_post();
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