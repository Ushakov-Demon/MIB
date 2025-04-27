<div class="item">
    <div class="meta">
        <div class="date">
            <?php echo esc_html(date_i18n(get_option('date_format') . ', ' . get_option('time_format'), strtotime($shedule_date))); ?>
        </div>
    </div>
    
    <div class="title">
        <a href="<?php echo esc_url($permalink); ?>">
            <?php echo esc_html($title); ?>
        </a>
    </div>
</div>