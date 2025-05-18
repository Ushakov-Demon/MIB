<?php

$title         = $exam_contact_title ?? '';
$address       = $exam_contact_address ?? '';
$address_label = $exam_contact_address_label ?? '';
$phone         = $exam_contact_phone ?? '';
$phone_label   = $exam_contact_phone_label ?? '';
?>

<div class="exam-block">
    <?php if ( ! empty( $title ) ) : ?>
        <h3 class="title"><?php echo esc_html( $title ); ?></h3>
    <?php endif; ?>

    <?php if ( ! empty( $address ) || ! empty( $phone ) ) : ?>
        <div class="info">
            <?php if ( ! empty( $address ) ) : ?>
                <div class="item">
                    <div class="label"><?php echo pll__('Address'); ?>:</div>
                    <div class="value"><?php echo esc_html( $address ); ?></div>
                    <div class="value-info"><?php echo esc_html( $address_label ); ?></div>
                </div>
            <?php endif; ?>
            
            <?php if ( !empty( $phone ) ) : ?>
                <div class="item">
                    <div class="label"><?php echo pll__('Phone' ); ?>:</div>
                    <div class="value"><?php echo esc_html( $phone ); ?></div>
                    <div class="value-info"><?php echo esc_html( $phone_label ); ?></div>
                </div> 
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="buttons">
        <a href="#consultation" class="button button-consultation"><?php echo pll__('Request a consultation'); ?></a>
        <a href="#question" class="link link-question"><?php echo pll__('Ask a question'); ?></a>
    </div>
</div>