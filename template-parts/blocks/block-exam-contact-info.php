<?php

$title         = $exam_contact_title ?? '';
$address       = $exam_contact_address ?? '';
$address_title = $exam_contact_address_title ?? '';
$phone         = $exam_contact_phone ?? '';
$phone_title   = $exam_contact_phone_title ?? '';
?>

<div class="exam-block">
    <?php if ( ! empty( $title ) ) : ?>
        <div class="title"><?php echo esc_html( $title ); ?></div>
    <?php endif; ?>

    <div class="info">
        <?php if ( ! empty( $address ) ) : ?>
            <div class="item">
                <div class="label"><?php echo esc_html( pll__('Address') ); ?>:</div>
                <div class="value"><?php echo esc_html( $address ); ?></div>
                <div class="value-info"><?php echo esc_html( $address_title ); ?></div>
            </div>
        <?php endif; ?>
        
        <?php if ( !empty( $phone ) ) : ?>
            <div class="item">
                <div class="label"><?php echo esc_html( pll__('Phone' ) ); ?>:</div>
                <div class="value"><?php echo esc_html( $phone ); ?></div>
                <div class="value-info"><?php echo esc_html( $phone_title ); ?></div>
            </div> 
        <?php endif; ?>
    </div>
</div>