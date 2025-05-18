<?php

$title       = $schedule_title ?? '';
$description = $schedule_description ?? '';
$file        = $schedule_file ?? '';
$file_url    = wp_get_attachment_url( $file );
?>

<div class="schedule-block">
    <?php if ( ! empty( $title ) ) : ?>
        <div class="title"><?php echo esc_html( $title ); ?></div>
    <?php endif; ?>

    <?php if ( ! empty( $description ) ) : ?>
        <div class="description"><?php echo wp_kses_post( $description ); ?></div>
    <?php endif; ?>

    <?php if ( ! empty( $file_url ) ) : ?>
        <div class="schedule-file">
            <a href="<?php echo esc_url( $file_url ); ?>" target="_blank" class="button button-download" download>
                <?php echo pll__( 'Download file' ); ?>
            </a>
        </div>
    <?php endif; ?>
</div>