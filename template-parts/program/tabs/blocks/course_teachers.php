<?php
$teachers = carbon_get_post_meta( $post_id, 'tr_program_teachers' );
$per_page = $course_teachers_count ?? 4;

if ( empty( $teachers ) ) {
    return;
}
?>
<div class="accordion-item">
    <div class="accordion-header">
        <div class="accordion-title">
            <?php echo pll__('Teachers'); ?>
        </div>
    </div>

    <div class="accordion-content">
        <div class="program-teachers">
            <div class="items">
                <?php
                    foreach ( $teachers as $key => $teacher ) :
                        if ( intval( $per_page ) > $key ) {
                            $item_id        = $teacher['id'];
                            $post_type      = get_post_type( $item_id );
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

        <div class="program-content-all">
            <a href="<?php echo get_permalink( 20 ) ?>" class="show-more-link" target="_blank"><?php echo pll__('View all teachers'); ?></a>
        </div>
    </div>
</div>