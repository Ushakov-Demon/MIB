
<?php if (!empty($repeater_counter_items)): ?>
    <div class="repeater-counter-block">
        <ul class="items">
            <?php foreach ($repeater_counter_items as $item): ?>
                <li class="item">
                    <span class="item-text"><?php echo esc_html($item['repeater_counter_item']); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>