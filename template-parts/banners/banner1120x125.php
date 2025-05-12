<?php if( $banner_image ): ?>
    <a href="<?php echo esc_url( $banner_url ); ?>" class="banner banner-1120x125">
        <img src="<?php echo esc_url( wp_get_attachment_url( $banner_image ) ); ?>" alt="<?php echo esc_attr( $banner_title ); ?>">
        <?php if( $banner_title && $banner_text ): ?>
            <div class="banner-content">
                <div class="banner-title"><?php echo esc_html( $banner_title ); ?></div>
                <div class="banner-text"><?php echo wp_kses_post( $banner_text ); ?></div>
            </div>
        <?php endif; ?>
        <i class="icon-arrow-right"></i>
    </a>
<?php endif; ?>
