<?php
$accriditations = carbon_get_post_meta( $post_id, 'tr_progaram_accriditation' );

if ( empty ( $accriditations ) ) {
    return;
}

foreach ( $accriditations as $item ) :
    $accr_id  = $item['id'];
    $name     = get_the_title( $accr_id );
    $logo_id  = carbon_get_post_meta( $accr_id, 'accr_white_logo' );
    $site_url = carbon_get_post_meta( $accr_id, 'accr_site_url' );
?>
<div class="program-accreditation">

    <h3 class="block-title">
        <?php
            echo sprintf( __( 'The program is accredited by the %s', 'baza' ), $name );
        ?>
    </h3>

        <?php
        if ( ! empty( $logo_id ) ) :
            $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
            $after    = "";
            $before   = "";

            if ( ! empty ( $site_url ) ) {
                $after = '<a href="' . esc_url( $site_url ) . '" target="_blank" rel="noopener noreferrer">';
                $before = '</a>';
            }
            ?>
            <div class="logo">
            
            <?php echo $after?>

            <img src="<?php echo esc_url( $logo_url ) ?>" alt="<?php echo esc_attr( $name ) ?>" class="accreditation-logo">

            <?php echo $before?>
            
            </div>
            <?php
        endif;
        ?>
    
    <?php
    if ( ! empty ( $site_url ) ) :
        ?>
        <a href="<?php echo esc_url( $site_url )?>" target="_blank" rel="noopener noreferrer" class="show-more-link">
            <?php echo pll__('Read more'); ?>
        </a>
        <?php
    endif;
    ?>
</div>

<?php
endforeach;