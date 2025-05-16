<div class="block">
    <div class="label"><?php pll_e('General phone number', 'baza')?>:</div>

    <div class="footer-phone">
        <?php 
            get_template_part('template-parts/blocks/block', 'phone', [
                'phone' => get_theme_mod('phone'),
                'class' => 'phone-link'
            ]);
        ?>
    </div>
</div>

<div class="block">
    <div class="label"><?php pll_e('Study', 'baza')?>:</div>

    <?php 
        get_template_part('template-parts/blocks/block', 'phone', [
            'phone' => get_theme_mod('phone_2'),
            'telegram' => get_theme_mod('telegram_username'),
            'viber' => get_theme_mod('phone_2'),
            'show_icons' => true
        ]);
    ?>
    <?php 
        get_template_part('template-parts/blocks/block', 'phone', [
            'phone' => get_theme_mod('phone_3'),
            'telegram' => get_theme_mod('telegram_username'),
            'viber' => get_theme_mod('phone_3'),
            'show_icons' => true
        ]);
    ?>
</div>

<?php if(get_theme_mod('email')): ?>
    <div class="block">
        <div class="label"><?php pll_e('Marketing department', 'baza')?>:</div>
        <a class="footer-email" href="mailto:<?php echo get_theme_mod('email_2'); ?>"><?php echo get_theme_mod('email_2'); ?></a>
    </div>
<?php endif; ?>

<?php if(get_theme_mod('email_2')): ?>
    <div class="block">
        <div class="label"><?php pll_e('Information department', 'baza')?>:</div>
        <a class="footer-email" href="mailto:<?php echo get_theme_mod('email'); ?>"><?php echo get_theme_mod('email'); ?></a>
    </div>
<?php endif; ?>