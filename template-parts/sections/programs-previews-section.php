<?php
$programs = apply_filters( 'mib_get_posts', 'programs', $programs_per_page );

?>
<section class="programs">

    <div class="container">
        <div class="section-heiding">
            <?php
            if ( ! empty( $programs_section_small_text ) ) :
                ?>
                <span class="pre-text">
                    <?php echo esc_html( $programs_section_small_text )?>
                </span>
                <?php
            endif;
            ?>

            <div>
                <?php
                if ( ! empty( $programs_section_title ) ) :
                    ?>
                    <h2 class="section-title">
                        <?php echo esc_html( $programs_section_title )?>
                    </h2>
                    <?php
                endif;

                if ( ! empty( $programs_section_link_text ) && ! empty( $programs_section_link ) ) :
                ?>
                    <a href="<?php echo esc_url( $programs_section_link )?>" class="link_to">
                        <?php echo esc_html( $programs_section_link_text )?>
                    </a>
                <?php
                endif;
                ?>
            </div>

            <?php
            if ( ! empty( $programs_section_desc ) ) :
            ?>
            <div class="hending-desc">
                <?php
                echo esc_html( $programs_section_desc );
                ?>
            </div>
            <?php
            endif;
            ?>
        </div>

        <div class="section-body">
        <?php
            if ($programs->have_posts()):
                while($programs->have_posts()):
                    $programs->the_post();
                    $post_ID = get_the_ID();
                    $title = get_the_title();
                    $post_permalink = get_the_permalink();
                    $icon_url = get_post_meta($post_ID, '_tr_program_icon', true);
                    $desc = get_the_excerpt($post_ID);
            ?>
                <div class="item">
                    <?php if (!empty($icon_url)): ?>
                        <div class="icon">
                            <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($title); ?>">
                        </div>
                    <?php endif; ?>
                    
                    <h3 class="title"><?php echo esc_html($title); ?></h3>
                    
                    <?php if (!empty($desc)): ?>
                        <div class="excerpt"><?php echo wp_kses_post($desc); ?></div>
                    <?php endif; ?>
                    
                    <a href="<?php echo esc_url($post_permalink); ?>" class="button-show-more">
                        <?php pll_e('Learn more', 'baza'); ?>
                    </a>
                </div>
            <?php
                endwhile;
            else:
                echo __('Items not found');
            endif;
            ?>
        </div>
    </div>
</section>