<?php
$accreditations = mib_get_posts( 'accreditations', $accreditations_posts_per_page ); 
?>
<div class="program-accreditations">
    <div class="items">
        <?php
        if ( $accreditations->have_posts() ):
            while( $accreditations->have_posts() ) :
                $accreditations->the_post();
                $post_ID        = get_the_ID();
                $title          = get_the_title();
                $post_permalink = get_the_permalink();
                $desc           = get_the_excerpt( $post_ID );
                $image          = get_post_thumbnail_id( $post_ID );
                $button_text    = 'View certificate';
                $is_announcing  = 'yes' == get_post_meta($post_ID, '_tr_program_is_announce', true);
                $announcing     = $is_announcing ? ' pending' : '';

                include get_template_directory() . '/template-parts/blocks/block-item.php';

            endwhile;
        endif;
        ?>
    </div>
</div>