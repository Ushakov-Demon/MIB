<div class="program-teachers">
    <div class="items">
        <?php 
            $teachers = apply_filters( 'mib_get_posts', 'teachers');
            
            if ( $teachers->have_posts() ) {
                while ( $teachers->have_posts() ) {
                    $teachers->the_post();
                    $item_id        = get_the_ID();
                    $image_id       = get_post_thumbnail_id();
                    $image_url      = wp_get_attachment_url( $image_id );
                    $image_alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                    $title          = get_the_title();
                    $position       = get_post_meta( $item_id, '_positions_in_companies', true );
                    $reviwe_message = get_post_meta( $item_id, '_teach_reviwe_message', true );
                    $companies      = wp_get_post_terms( $item_id, 'companies' );

                    include get_template_directory() . '/template-parts/blocks/block-person-item.php';
                }
            }
        ?>
    </div>
</div>