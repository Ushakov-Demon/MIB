<div class="side">
    
    <div class="block block-last-events">
        <div class="block-title">
            <?php pll_e('Latest events', 'baza')?>
        </div>

        <div class="items items-last-events">
            <?php /*
                if ( ! empty( $alternating_posts["posts"] ) ) :
                    foreach ( $alternating_posts["posts"] as $item ) :

                        $post_ID      = $item->ID;
                        if ( get_the_ID() === $post_ID ) continue; 
                        
                        $post_type    = $item->post_type;
                        $shedule_date = ( $post_type === 'events' ) ? get_post_meta( $post_ID, '_event_shedule_date', true ) : '';
                        $title        = get_the_title( $post_ID );
                        $permalink    = get_the_permalink( $post_ID );
                
                        include get_template_directory() . '/template-parts/blocks/news-item-small.php';
                    endforeach;
                else :
                    echo __( 'Items not found', 'baza' );
                endif;	
                */								
            ?>
        </div>
    </div>

</div>