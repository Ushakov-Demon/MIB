<?php

if ( ! defined( 'ABSPATH' ) ) exit;

$args = [
    'taxonomy'   => 'companies',
    'hide_empty' => false,
];

$terms = get_terms( $args );

if ( empty( $terms ) ) return;

$partner_categories = array(
    'business-partner' => array(
        'title' => pll__( 'Business partners' ),
        'check_field' => '_is_business_partner',
        'filter_class' => 'filter-business-partners'
    ),
    'business-school' => array(
        'title' => pll__( 'Business schools' ),
        'check_field' => '_is_business_school',
        'filter_class' => 'filter-business-schools'
    ),
    'professional-association' => array(
        'title' => pll__( 'Professional associations' ),
        'check_field' => '_is_professional_association',
        'filter_class' => 'filter-professional-associations'
    ),
    'company' => array(
        'title' => pll__( 'Companies' ),
        'check_field' => '_is_company',
        'filter_class' => 'filter-companies'
    ),
    'partner' => array(
        'title' => pll__( 'Partners' ),
        'check_field' => '_is_partner',
        'filter_class' => 'filter-partners'
    ),
);
?>

<section class="section section-partners">
    <div class="container">
        <?php if ( ! empty( $partners_heading ) ) : ?>
            <div class="section-title">
                <?php echo wp_kses_post( $partners_heading ); ?>
            </div>
        <?php endif; ?>

        <div class="section-filter">
            <ul class="filter" id="filter-partners">
                <li class="item filter-all active" data-target="all">
                    <a href="#" class="filter-link"><span><?php echo pll__( 'All' ); ?></span></a>
                </li>
                <?php foreach ( $partner_categories as $category_key => $category_data ) : ?>
                    <li class="item <?php echo esc_attr( $category_data['filter_class'] ); ?>" data-target="<?php echo esc_attr( $category_key ); ?>">
                        <a href="#" class="filter-link"><span><?php echo esc_html( $category_data['title'] ); ?></span></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <?php 
        foreach ( $partner_categories as $category_key => $category_data ) :
            
            $has_items = false;
            foreach ( $terms as $check_item ) {
                $check_field = $category_data['check_field'];
                $check_value = get_term_meta( $check_item->term_id, $check_field, true );
                $logo_id = get_term_meta( $check_item->term_id, '_company_logo', true );
                
                if ( $check_value && ! empty( $logo_id ) ) {
                    $has_items = true;
                    break;
                }
            }
            
            if ( ! $has_items ) continue;
            
            $category_partner_types = [];
            foreach ( $terms as $check_item ) {
                $check_is_partner                  = get_term_meta( $check_item->term_id, '_is_partner', true );
                $check_is_business_partner         = get_term_meta( $check_item->term_id, '_is_business_partner', true );
                $check_is_business_school          = get_term_meta( $check_item->term_id, '_is_business_school', true );
                $check_is_professional_association = get_term_meta( $check_item->term_id, '_is_professional_association', true );
                $check_is_company                  = get_term_meta( $check_item->term_id, '_is_company', true );
                
                $check_belongs_to_category = false;
                if ( $category_key === 'partner' && $check_is_partner ) {
                    $check_belongs_to_category = true;
                } elseif ( $category_key === 'business-partner' && $check_is_business_partner ) {
                    $check_belongs_to_category = true;
                } elseif ( $category_key === 'business-school' && $check_is_business_school ) {
                    $check_belongs_to_category = true;
                } elseif ( $category_key === 'professional-association' && $check_is_professional_association ) {
                    $check_belongs_to_category = true;
                } elseif ( $category_key === 'company' && $check_is_company ) {
                    $check_belongs_to_category = true;
                }
                
                if ( $check_belongs_to_category ) {

                    if ( $category_key === 'business-partner' ) {
                        if ( $check_is_partner ) $category_partner_types['partner'] = true;
                        if ( $check_is_business_partner ) $category_partner_types['business-partner'] = true;
                        if ( $check_is_business_school ) $category_partner_types['business-school'] = true;
                        if ( $check_is_professional_association ) $category_partner_types['professional-association'] = true;
                        if ( $check_is_company ) $category_partner_types['company'] = true;
                    } else {

                        if ( $check_is_partner ) $category_partner_types['partner'] = true;
                        if ( $check_is_business_school ) $category_partner_types['business-school'] = true;
                        if ( $check_is_professional_association ) $category_partner_types['professional-association'] = true;
                        if ( $check_is_company ) $category_partner_types['company'] = true;
                    }
                }
            }
            
            $category_classes = 'category';
            foreach ( $category_partner_types as $type => $exists ) {
                $category_classes .= ' has-' . $type;
            }
            
            ?>
            <div class="<?php echo esc_attr( $category_classes ); ?>" data-category="<?php echo esc_attr( $category_key ); ?>">
                <h3 class="section-title"><?php echo esc_html( $category_data['title'] ); ?></h3>
                <div class="items">
                    <?php foreach ( $terms as $item ) :
                        $logo_id                      = get_term_meta( $item->term_id, '_company_logo', true );
                        $url                          = get_term_meta( $item->term_id, '_company_url', true );
                        $phone                        = get_term_meta( $item->term_id, '_company_phone', true );
                        $address                      = get_term_meta( $item->term_id, '_company_address', true );
                        $email                        = get_term_meta( $item->term_id, '_company_email', true );
                        $is_partner                   = get_term_meta( $item->term_id, '_is_partner', true );
                        $is_business_partner          = get_term_meta( $item->term_id, '_is_business_partner', true );
                        $is_business_school           = get_term_meta( $item->term_id, '_is_business_school', true );
                        $is_professional_association  = get_term_meta( $item->term_id, '_is_professional_association', true );
                        $is_company                   = get_term_meta( $item->term_id, '_is_company', true );

                        $data_category = implode(' ', array_filter([
                            $is_partner ? 'partner' : '',
                            $is_business_partner ? 'business-partner' : '',
                            $is_business_school ? 'business-school' : '',
                            $is_professional_association ? 'professional-association' : '',
                            $is_company ? 'company' : ''
                        ]));

                        $belongs_to_category = false;
                        if ( $category_key === 'partner' && $is_partner ) {
                            $belongs_to_category = true;
                        } elseif ( $category_key === 'business-partner' && $is_business_partner ) {
                            $belongs_to_category = true;
                        } elseif ( $category_key === 'business-school' && $is_business_school ) {
                            $belongs_to_category = true;
                        } elseif ( $category_key === 'professional-association' && $is_professional_association ) {
                            $belongs_to_category = true;
                        } elseif ( $category_key === 'company' && $is_company ) {
                            $belongs_to_category = true;
                        }
                        
                        if ( ! $belongs_to_category ) continue;
                        
                        if ( empty( $logo_id ) ) continue;
                        
                        $logo_url = wp_get_attachment_image_url( $logo_id, 'medium' );
                        $logo_alt = get_post_meta( $logo_id, '_wp_attachment_image_alt', true ) ?: $item->name;
                        
                        $item_classes = 'item';
                        if ( $is_partner ) {
                            $item_classes .= ' item-partner';
                        }
                        if ( $is_business_partner ) {
                            $item_classes .= ' item-business-partner';
                        }
                        if ( $is_business_school ) {
                            $item_classes .= ' item-business-school';
                        }
                        if ( $is_professional_association ) {
                            $item_classes .= ' item-professional-association';
                        }
                        if ( $is_company ) {
                            $item_classes .= ' item-company';
                        }
                        ?>
                        
                        <?php if ( ! empty( $url ) && ! $is_business_partner ) : ?>
                            <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener nofollow" class="<?php echo esc_attr( $item_classes ); ?>" data-category="<?php echo esc_attr( $data_category ); ?>">
                        <?php else : ?>
                            <div class="<?php echo esc_attr( $item_classes ); ?>" data-category="<?php echo esc_attr( $data_category ); ?>">
                        <?php endif; ?>
                            <div class="image">
                                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>">
                            </div>

                            <?php if ( ! empty( $item->name ) ) : ?>
                                <div class="name">
                                    <?php echo esc_html( $item->name ); ?>
                                </div>
                            <?php endif; ?>

                            <?php if( $is_business_partner && $category_key === 'business-partner' ): ?>

                                <?php if ( ! empty( $item->description ) ) : ?>
                                    <div class="description">
                                        <?php echo wp_kses_post( $item->description ); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ( ! empty( $address ) || ! empty( $phone ) || ! empty( $email ) || ! empty( $url ) ) : ?>
                                    <div class="info">
                                        <?php if ( ! empty( $address ) ) : ?>
                                            <div class="info-item">
                                                <div class="label"><?php echo pll__('Address'); ?>:</div>
                                                <div class="value"><?php echo esc_html( $address ); ?></div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ( ! empty( $phone ) ) : ?>
                                            <div class="info-item">
                                                <div class="label"><?php echo pll__('Tel/Fax'); ?>:</div>
                                                <div class="value"><?php echo esc_html( $phone ); ?></div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ( ! empty( $email ) ) : ?>
                                            <div class="info-item">
                                                <div class="label"><?php echo pll__('E-mail'); ?>:</div>
                                                <div class="value">
                                                    <a href="mailto:<?php echo esc_attr( $email ); ?>">
                                                        <?php echo esc_html( $email ); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ( ! empty( $url ) ) : ?>
                                            <div class="info-item">
                                                <div class="label"><?php echo pll__('URL'); ?>:</div>
                                                <div class="value">
                                                    <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener nofollow">
                                                        <?php echo esc_html( $url ); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                            <?php endif; ?>
                        
                        <?php if ( ! empty( $url ) && ! $is_business_partner ) : ?>
                            </a>
                        <?php else : ?>
                            </div>
                        <?php endif; ?>
                        
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>