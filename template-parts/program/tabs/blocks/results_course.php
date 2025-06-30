<?php
$has_accreditation = isset( $results_course_show_accreditation ) && "yes" == $results_course_show_accreditation; 
$post_id           = get_the_ID();
?>

<div class="accordion-item" id="accordion-course-results">
    <div class="accordion-header">
        <?php
        if ( ! empty( $results_course_title ) ) :
        ?>
        <div class="accordion-title">
            <?php echo pll__( $results_course_title ); ?>
        </div>
        <?php
        endif;
        ?>
    </div>

    <div class="accordion-content">

        <?php
        if ( ! empty( $results_course_desc ) ) :
        ?>
        <div class="description">
            <?php echo pll__( $results_course_desc ); ?>
        </div>
        <?php
        endif;
        ?>

        <?php 
            if ( $has_accreditation ) :
            $accriditations = carbon_get_post_meta( $post_id, 'tr_progaram_accriditation' );
        ?>

        <div class="program-accreditations">
            <div class="items-wrapper">
                <div class="items">
                    
                    <?php foreach ( $accriditations as $item ) :
                        $post_ID        = $item['id'];
                        $title          = get_the_title( $accr_id );
                        $image          = get_post_thumbnail_id( $post_ID );
                        $desc           = get_the_excerpt( $post_ID );
                        $post_permalink = get_permalink( $accr_id );
                        $desc           = get_the_excerpt( $post_ID );
                    ?>
                    
                    <?php include get_template_directory() . '/template-parts/blocks/block-item.php'; ?>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <?php endif; ?>

        <?php 
        if ( ! empty( $results_course_block_image ) ) :
            $image_url = wp_get_attachment_url( $results_course_block_image, 'full' );
            $alt_text  = get_post_meta( $results_course_block_image, '_wp_attachment_image_alt', true );
        ?>
            <img class="w100" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $alt_text ); ?>">
         <?php endif; ?>
    </div>
</div>