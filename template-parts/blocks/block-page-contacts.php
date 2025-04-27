<div class="block-page-contacts">
    <div class="block">
        <div class="label"><?php pll_e('General phone number', 'baza')?>:</div>

        <div class="footer-phone">
            <?php 
                get_template_part('template-parts/blocks/block', 'phone', [
                    'phone' => get_theme_mod('phone'),
                    'class' => 'phone-link'
                ]);
            ?>
            <span class="highlight">(<?php pll_e('multichannel', 'baza')?>)</span>
        </div>
    </div>

    <div class="block">
        <div class="label"><?php pll_e('Address', 'baza')?>:</div>
        <address>
            <?php echo highlight_text_with_stars( get_translatable_theme_mod('address') ); ?>
        </address>
    </div>

    <div class="block">
        <div class="label"><?php pll_e('Phone for education program inquiries', 'baza')?>:</div>

        <?php 
            get_template_part('template-parts/blocks/block', 'phone', [
                'phone' => get_theme_mod('phone_2'),
                'show_icons' => false,
                'wrapper_class' => 'phone',
            ]);
        ?>
    </div>

    <div class="block">
        <div class="label"><?php pll_e('Phone for education program inquiries', 'baza')?>:</div>

        <?php 
            get_template_part('template-parts/blocks/block', 'phone', [
                'phone' => get_theme_mod('phone_3'),
                'show_icons' => false,
                'wrapper_class' => 'phone',
            ]);
        ?>
    </div>

    <div class="block block-social">
        <div class="label"><?php pll_e('We are on social', 'baza')?>:</div>
        <?php get_template_part( 'template-parts/blocks/block', 'social-links', array('show_icons' => true) ); ?>
    </div>

    <div class="block block-additional">
    
        <?php if(get_theme_mod('phone_4')): ?>
            <p>
                <span><?php pll_e('Phone of the School of NPQ', 'baza')?>:</span>
                <?php 
                    get_template_part('template-parts/blocks/block', 'phone', [
                        'phone' => get_theme_mod('phone_4'),
                        'show_icons' => false,
                        'wrapper_class' => '',
                    ]);
                ?>, 
                <?php 
                    get_template_part('template-parts/blocks/block', 'phone', [
                        'phone' => get_theme_mod('phone_5'),
                        'show_icons' => false,
                        'wrapper_class' => '',
                    ]);
                ?>
            </p>
        <?php endif; ?>

        <?php if(get_theme_mod('email')): ?>
            <p>
                <span><?php pll_e('Marketing department', 'baza')?>:</span>
                <a class="footer-email" href="mailto:<?php echo get_theme_mod('email_2'); ?>"><?php echo get_theme_mod('email_2'); ?></a>
            </p>
        <?php endif; ?>

        <?php if(get_theme_mod('email_2')): ?>
            <p>
                <span><?php pll_e('Information department', 'baza')?>:</span>
                <a class="footer-email" href="mailto:<?php echo get_theme_mod('email'); ?>"><?php echo get_theme_mod('email'); ?></a>
            </p>
        <?php endif; ?>
    </div>
</div>