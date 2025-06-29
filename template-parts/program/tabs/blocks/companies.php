<?php
if ( isset( $cousre_companies_list ) && empty( $cousre_companies_list ) ) {
    return;
}
?>

<div class="companies-list">
    <?php
    if ( ! empty( $cousre_companies_title ) ) :
    ?>
    <h3><?php pll_e( $cousre_companies_title, 'baza' )?></h3>
    <?php
    endif;
    ?>
    <div class="items">
    <?php
    foreach ( $cousre_companies_list as $item ) :
        $company  = get_term( $item['id'] );
        $logo_id  = carbon_get_term_meta( $item['id'], 'company_logo' );

        if ( empty( $logo_id ) ) {
            continue;
        }

        $logo_src = esc_url( wp_get_attachment_url( $logo_id ) );
        $link     = carbon_get_term_meta( $item['id'], 'company_url' );

        $after  = '';
        $before = '';

        if ( ! empty( $link ) ) {
            $after = "<a href ='" . esc_url( $link ) . "' target='_blank'>";
            $before = "</a>";
        }
    ?>
        <div class="item">
            <?php echo $after?>
            <img src="<?php echo $logo_src?>" alt="<?php echo $company->name?>">
            <?php echo $before?>
        </div>
    <?php
    endforeach;
    ?>
    </div>
</div>
