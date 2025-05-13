<?php
if ( empty( $advantages_block_repeater ) ) {
    return;
}

$image_block_src = "/wp-content/themes/mib/assets/images/benefits.png";

if ( ! empty( $advantages_block_image ) ) {
    $image_block_src = wp_get_attachment_image_url( $advantages_block_image, 'full' );
}
?>
<section class="section section-program-benefits">
    <div class="container">        
        <div class="image">
            <img src="<?php echo $image_block_src?>" alt="">
        </div>

        <div class="content">
            <?php
            if ( ! empty( $advantages_block_title ) ) :
                ?>
                <h3><?php pll_e( $advantages_block_title )?></h3>
                <?php
            endif;
            ?>
            <div class="items">
                <?php
                foreach ( $advantages_block_repeater as $advantage ) :
                    ?>
                    <div class="item">
                        <?php
                        if ( ! empty( $advantage['advantage_title'] ) ) :
                        ?>
                        <div class="label">
                            <?php pll_e( $advantage['advantage_title'] )?>
                        </div>
                        <?php
                        endif;

                        if ( ! empty( $advantage['advantage_cont'] ) ) :
                        ?>
                        <div class="text"><?php pll_e( $advantage['advantage_cont'] )?></div>
                        <?php
                        endif;
                        ?>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>
</section>