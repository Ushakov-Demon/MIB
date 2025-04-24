<?php
$programs = apply_filters( 'mib_get_posts', 'programs', $programs_per_page );
?>
<section class="programs">
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
        if ( $programs->have_posts() ):
            while( $programs->have_posts() ) :
                $programs->the_post();
                $post_ID        = get_the_ID();
                $title          = get_the_title();
                $post_permalink = get_the_permalink();
                $icon_url       = get_post_meta( $post_ID, '_tr_program_icon', true );
                $desc           = get_the_excerpt( $post_ID );

        ?>
        <!-- single item HTML -->
        <?php
            endwhile;
        else:
            // TODO: Need create && include template
            echo __( 'Items not found' );
        endif;
        ?>
    </div>
</section>