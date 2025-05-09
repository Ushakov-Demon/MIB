<?php
$programs = apply_filters( 'mib_get_posts', 'programs', $programs_per_page );
?>
<section class="section section-programs">
    <div class="container">
        <div class="section-heiding">
            <?php
            if ( ! empty( $programs_section_small_text ) ) :
                ?>
                <div class="section-pre">
                    <?php echo esc_html( $programs_section_small_text )?>
                </div>
                <?php
            endif;
            ?>

            <?php
            if ( ! empty( $programs_section_title ) ) :
                ?>
                <div class="section-title">
                    <?php 
                        $processed_heading = preg_replace('/\*(.*?)\*/', '<span>$1</span>', $programs_section_title);
                        echo $processed_heading;
                    ?>
                </div>
                <?php
            endif;

            if ( ! empty( $programs_section_link_text ) && ! empty( $programs_section_link ) ) :
            ?>
                <a href="<?php echo esc_url( get_permalink($programs_section_link) )?>" class="section-link">
                    <?php echo esc_html( $programs_section_link_text )?>
                </a>
            <?php
            endif;
            ?>

            <?php
            if ( ! empty( $programs_section_desc ) ) :
            ?>
            <div class="section-description">
                <?php
                echo nl2br( $programs_section_desc );
                ?>
            </div>
            <?php
            endif;
            ?>
        </div>

        <div class="items-wrapper">
            <div class="items">
                <?php
                    if ($programs->have_posts()):
                        while($programs->have_posts()):
                            $programs->the_post();
                            $post_ID        = get_the_ID();
                            $title          = get_the_title();
                            $post_permalink = get_the_permalink();
                            $image          = get_post_meta( $post_ID, '_tr_program_icon', true );
                            $desc           = get_the_excerpt( $post_ID );
                            $is_announcing  = 'yes' == get_post_meta( $post_ID, '_tr_program_is_announce', true );
                            $announcing     = $is_announcing ? ' pending' : '';

                            include get_template_directory() . '/template-parts/blocks/block-item.php';

                        endwhile;
                    else:
                        echo __('Items not found');
                    endif;
                    ?>
            </div>
        </div>
    </div>
</section>