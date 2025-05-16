<?php

if ( ! defined( 'ABSPATH' ) ) exit;

$args = [
    'taxonomy'   => 'companies',
    'hide_empty' => false,
];

$terms = get_terms( $args );

if ( empty( $terms ) ) return;

$client_categories = array(
    'open_programs' => array(
        'title' => pll__( 'Open Programs Clients' ),
        'field' => 'is_open_programs_client'
    ),
    'corporate_programs' => array(
        'title' => pll__( 'Corporate Programs Clients' ),
        'field' => 'is_corporate_programs_client'
    ),
    'graduate_programs' => array(
        'title' => pll__( 'Graduate/Diploma Programs Clients' ),
        'field' => 'is_graduate_programs_client'
    )
);
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
                <li class="item item-title"><?php echo pll__( 'By programs' ); ?></li>
                <li class="item filter-all active" data-target="all">
                    <a href="#" class="filter-link"><span><?php echo pll__( 'All' ); ?></span></a>
                </li>
                <li class="item filter-open-programs" data-target="open_programs">
                    <a href="#" class="filter-link"><span><?php echo pll__( 'Open Programs Clients' ); ?></span></a>
                </li>
                <li class="item filter-corporate-programs" data-target="corporate_programs">
                    <a href="#" class="filter-link"><span><?php echo pll__( 'Corporate Programs Clients' ); ?></span></a>
                </li>
                <li class="item filter-graduate-programs" data-target="graduate_programs">
                    <a href="#" class="filter-link"><span><?php echo pll__( 'Graduate/Diploma Programs Clients' ); ?></span></a>
                </li>
            </ul>
        </div>

        <div class="section-category-wrapper">
            <?php foreach ( $client_categories as $category_key => $category_data ) :
                $has_clients = false;
                $clients_html = '';
                
                foreach ( $terms as $item ) :
                    $logo_id = get_term_meta( $item->term_id, '_company_logo', true );
                    $url     = get_term_meta( $item->term_id, '_company_url', true );
                    $is_client = get_term_meta( $item->term_id, '_is_client', true );
                    $is_category_client = get_term_meta( $item->term_id, '_' . $category_data['field'], true );
                    
                    if ( ! $is_client || ! $is_category_client ) continue;
                    
                    if ( empty( $logo_id ) ) continue;
                    
                    $logo_url = wp_get_attachment_image_url( $logo_id, 'medium' );
                    $logo_alt = get_post_meta( $logo_id, '_wp_attachment_image_alt', true ) ?: $item->name;
                    
                    $has_url = ! empty( $url );
                    $tag_open = $has_url ? '<a href="' . esc_url( $url ) . '" class="item" target="_blank" rel="nofollow noopener">' : '<div class="item">';
                    $tag_close = $has_url ? '</a>' : '</div>';
                    
                    $clients_html .= $tag_open;
                    $clients_html .= '<div class="image"><img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $logo_alt ) . '"></div>';
                    $clients_html .= '<div class="name">' . esc_html( $item->name ) . '</div>';
                    $clients_html .= $tag_close;
                    
                    $has_clients = true;
                endforeach;
                
                if ( $has_clients ) : ?>
                    <div class="category" data-category="<?php echo esc_attr( $category_key ); ?>">
                        <h3 class="section-title"><?php echo esc_html( $category_data['title'] ); ?></h3>
                        <div class="items">
                            <?php echo $clients_html; ?>
                        </div>
                    </div>
                <?php endif;
                
            endforeach; ?>

        </div>

    </div>
</section>
