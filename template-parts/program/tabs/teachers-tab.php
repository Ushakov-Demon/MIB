<div id="tab-teachers" class="tab-content">
    <div class="program-teachers">
        <h3 class="tab-title"><?php echo pll__('Teachers'); ?></h3>
        
        <div class="items">
            <?php
                foreach ( $teachers as $key => $teacher ) :
                    if ( intval( $per_page ) > $key ) {

                        $post_type      = get_post_type();
                        $item_id        = $teacher['id'];
                        $image_id       = get_post_thumbnail_id( $item_id );
                        $image_url      = wp_get_attachment_url( $image_id );
                        $image_alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                        $title          = get_the_title( $item_id );
                        $position       = get_post_meta( $item_id, '_positions_in_companies', true );
                        $reviwe_message = get_post_meta( $item_id, '_teach_reviwe_message', true );
                        $companies      = wp_get_post_terms( $item_id, 'companies' );
                        $url            = get_permalink( $item_id );

                        include get_template_directory() . '/template-parts/blocks/block-person-item.php';
                    }
                endforeach;
            ?>
        </div>
    </div>
</div>