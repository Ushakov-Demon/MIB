<?php
if ( empty( $duc_documents_list ) ) {
    return;
}
?>
<div class="accordion-item">
    <div class="accordion-header">
        <?php
        if ( ! empty( $duc_title ) ) :
            ?>
            <div class="accordion-title">
                <?php pll_e( $duc_title, 'baza' ); ?>
            </div>
            <?php
        endif;
        ?>
    </div>

    <div class="accordion-content">
        <div class="program-documents">
            <?php
            foreach( $duc_documents_list as $item ) :
                $doc_url = '';
                $file_url = wp_get_attachment_url( $item['duc_item_file'] );
                $link_url = get_permalink( $item['duc_item_url'] );

                if ( ! empty( $file_url ) ) {
                    $doc_url = 'href="' . esc_url( $file_url ) . '" download';
                } else {
                    $doc_url = 'href="' . esc_url( $link_url ) . '" target="_blank"';
                }
                
            ?>
            <a class="item program-documents-link" <?php echo $doc_url; ?>>
                <?php
                if ( ! empty( $item['duc_item_name'] ) ) :
                    ?>
                    <div class="label">
                        <?php pll_e( $item['duc_item_name'], 'baza' )?>
                    </div>
                    <?php
                endif;
                ?>
                <span class="show-more-link">
                    <?php echo pll__('Learn more', 'baza'); ?>
                </span>
            </a>
            <?php
            endforeach;
            ?>
        </div>
    </div>
</div>