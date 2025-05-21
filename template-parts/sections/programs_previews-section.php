<?php
$tax_params = [];

if ( isset( $programs_target_category ) && ! empty ( $programs_target_category ) ) {
    $taxonomy  = $programs_target_category[0]['subtype'];
    $terms_ids = [];

    foreach ( $programs_target_category as $term ) {
        array_push( $terms_ids, $term['id'] );
    }

    $params = [
        'taxonomy' => $taxonomy,
        'terms'    => $terms_ids,
        'field'    => 'term_id',
        'operator' => 'IN',
    ];

    array_push( $tax_params, $params );
}

$programs = mib_get_posts( 'programs', $programs_per_page, 1, $tax_params );


if ( is_tax() ) {
    $current_taxonomy = get_queried_object();
    $columns          = get_term_meta( $current_taxonomy->term_id, '_programs_columns', true );
    $items_columns    = ( ! empty( $columns )) ? intval( $columns ) : 'column-3';
} else {
    $columns = 'column-3';
}

?>
<section class="section section-programs" id="programs-<?php echo sanitize_title($programs_section_title); ?>">
    <div class="container">

        <?php
            if ( ! empty( $programs_section_title ) ) :
        ?>
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

            <div class="section-title">
                <?php 
                    $processed_heading = preg_replace('/\*(.*?)\*/', '<span>$1</span>', $programs_section_title);
                    echo $processed_heading;
                ?>
            </div>

            <?php
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
        <?php
        endif;
        ?>

        <div class="items-wrapper">
            <div class="items items-<?php echo esc_html( $columns ); ?>">
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
                    endif;
                ?>
            </div>
        </div>
    </div>
</section>