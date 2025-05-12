<?php 
if (!empty($accreditation_text) || !empty($certificate_image)) : ?>
<section class="section section-single-accreditations">
    <div class="container">
        <div class="accreditation-info">
            <?php if (!empty($accreditation_text)) : ?>
                <div class="accreditation-text">
                    <?php echo $accreditation_text; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($accreditation_url)) : ?>
                <div class="accreditation-footer">
                    <?php if (!empty($accreditation_info)) : ?>
                        <div class="text">
                            <?php echo $accreditation_info; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($accreditation_url)) : ?>
                        <a class="button" href="<?php echo esc_url($accreditation_url); ?>" target="_blank">
                            <?php echo pll__('Visit accreditation'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="accreditation-image">
            <?php if (!empty($certificate_image)) : ?>
                <div class="certificate-image">
                    <img src="<?php echo wp_get_attachment_image_url($certificate_image, 'full'); ?>" 
                            alt="<?php echo get_post_meta($certificate_image, '_wp_attachment_image_alt', true); ?>" />
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>