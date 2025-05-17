<?php
$post_id        = get_the_ID();
$hours          = get_post_meta( $post_id, '_tr_program_stats_hours', true );
$offline        = get_post_meta( $post_id, '_tr_program_stats_offline', true );
$teachers       = get_post_meta( $post_id, '_tr_program_stats_teachers', true );
$cases          = get_post_meta( $post_id, '_tr_program_stats_cases', true );
$hours_label    = get_post_meta( $post_id, '_tr_program_stats_hours_label', true );
$offline_label  = get_post_meta( $post_id, '_tr_program_stats_offline_label', true );
$teachers_label = get_post_meta( $post_id, '_tr_program_stats_teachers_label', true );
$cases_label    = get_post_meta( $post_id, '_tr_program_stats_cases_label', true );

$has_stats = !empty( $hours ) || !empty( $offline ) || !empty( $teachers ) || !empty( $cases );

if ( $has_stats ) :
?>
<div class="program-stats">
    <?php if ( !empty( $hours ) ) : ?>
        <div class="item">
            <div class="count">
                <span class="count-value" data-count="<?php echo esc_attr( $hours ); ?>"><?php echo esc_html( $hours ); ?></span>
            </div>
            <div class="label">
                <?php if ( !empty( $hours_label ) ) : ?>
                    <?php echo nl2br( esc_html( $hours_label ) ); ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ( !empty( $offline ) ) : ?>
        <div class="item">
            <div class="count">
                <span class="count-value" data-count="<?php echo esc_attr( $offline ); ?>"><?php echo esc_html( $offline ); ?></span>
                <span class="after-count">%</span>
            </div>
            <div class="label">
                <?php if ( !empty( $offline_label ) ) : ?>
                    <?php echo nl2br( esc_html( $offline_label ) ); ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ( !empty( $teachers ) ) : ?>
        <div class="item">
            <div class="count">
                <span class="count-value" data-count="<?php echo esc_attr( $teachers ); ?>"><?php echo esc_html( $teachers ); ?></span>
                <span class="after-count small"><?php echo pll__( 'teachers' ); ?></span>
            </div>
            <div class="label">
                <?php if ( !empty( $teachers_label ) ) : ?>
                    <?php echo nl2br( esc_html( $teachers_label ) ); ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ( !empty( $cases ) ) : ?>
        <div class="item">
            <div class="count">
                <span class="count-value" data-count="<?php echo esc_attr( $cases ); ?>"><?php echo esc_html( $cases ); ?></span>
                <span class="after-count color">+</span>
            </div>
            <div class="label">
                <?php if ( !empty( $cases_label ) ) : ?>
                    <?php echo nl2br( esc_html( $cases_label ) ); ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>