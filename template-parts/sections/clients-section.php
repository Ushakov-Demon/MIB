<?php

if ( ! defined( 'ABSPATH' ) ) exit;

$args = [
    'taxonomy'   => 'companies',
    'hide_empty' => false,
];

$terms = get_terms( $args );

if ( empty( $terms ) ) return;
?>

<section class="section section-clients">
    <div class="container">
        <?php if ( ! empty( $company_logos_heading ) ) : ?>
            <div class="section-title">
                <?php echo wp_kses_post( $company_logos_heading ); ?>
            </div>
        <?php endif; ?>

        <div class="section-filter">
            <ul class="filter" id="filter-clients">
                <li class="item item-title">За програмами</li>
                <li class="item filter-all active" data-target="all">
                    <a href="#" class="filter-link"><span>Всі</span></a>
                </li>
                <li class="item filter-" data-target="">
                    <a href="#" class="filter-link"><span>Клієнти відкритих програм</span></a>
                </li>
                <li class="item filter-" data-target="">
                    <a href="#" class="filter-link"><span>Клієнти корпоративних програм</span></a>
                </li>
                <li class="item filter-" data-target="">
                    <a href="#" class="filter-link"><span>Клієнти дипломних програм</span></a>
                </li>
            </ul>
        </div>

        <div class="section-category-wrapper">

            <div class="section-category">

                <h3 class="section-title">Клієнти відкритих програм</h3>

                <div class="items">
                    <?php foreach ( $terms as $item ) :
                        $logo_id = get_term_meta( $item->term_id, '_company_logo', true );
                        $url     = get_term_meta( $item->term_id, '_company_url', true );
                        
                        if ( empty( $logo_id ) ) continue;
                        
                        $logo_url = wp_get_attachment_image_url( $logo_id, 'medium' );
                        $logo_alt = get_post_meta( $logo_id, '_wp_attachment_image_alt', true ) ?: $item->name;
                        
                        $has_url = ! empty( $url );
                        $tag_open = $has_url ? '<a href="' . esc_url( $url ) . '" class="item" target="_blank" rel="nofollow noopener">' : '<div class="item">';
                        $tag_close = $has_url ? '</a>' : '</div>';
                    ?>
                        <?php echo $tag_open; ?>
                            <div class="image"><img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>"></div>
                            <div class="name"><?php echo esc_html( $item->name ); ?></div>
                        <?php echo $tag_close; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="section-category">

                <h3 class="section-title">Клієнти корпоративних програм</h3>

                <div class="items">
                    <?php foreach ( $terms as $item ) :
                        $logo_id = get_term_meta( $item->term_id, '_company_logo', true );
                        $url     = get_term_meta( $item->term_id, '_company_url', true );
                        
                        if ( empty( $logo_id ) ) continue;
                        
                        $logo_url = wp_get_attachment_image_url( $logo_id, 'medium' );
                        $logo_alt = get_post_meta( $logo_id, '_wp_attachment_image_alt', true ) ?: $item->name;
                        
                        $has_url = ! empty( $url );
                        $tag_open = $has_url ? '<a href="' . esc_url( $url ) . '" class="item" target="_blank" rel="nofollow noopener">' : '<div class="item">';
                        $tag_close = $has_url ? '</a>' : '</div>';
                    ?>
                        <?php echo $tag_open; ?>
                            <div class="image"><img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>"></div>
                            <div class="name"><?php echo esc_html( $item->name ); ?></div>
                        <?php echo $tag_close; ?>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

    </div>
</section>
