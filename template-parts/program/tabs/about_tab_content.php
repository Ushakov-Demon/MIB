<div id="tab-about-program" class="tab-content active">
    <?php
        include get_template_directory() . '/template-parts/program/blocks/block-program-params-stats.php';

        foreach( $about_tab_content as $key => $block ) :

            $block_type = $block['_type'];
            extract( $block );

            if ( file_exists( get_template_directory() . "/template-parts/program/tabs/blocks/$block_type.php" ) ) {
                include get_template_directory() . "/template-parts/program/tabs/blocks/$block_type.php";
            } else {
                switch ( $block_type ) {
                    case 'editor_block':
                        include get_template_directory() . "/template-parts/program/tabs/blocks/program_results_mission.php";
                        break;
                }
            }

        endforeach;
    ?>
</div>

<div id="tab-teachers" class="tab-content">
    <div class="program-teachers">
        <div class="items">
            <?php
                foreach ( $teachers as $key => $teacher ) :

                    if ( intval( $per_page ) > $key ) {

                        $post_type      = get_post_type();
                        $item_id        = $teacher['id'];
                        $image_id       = get_post_thumbnail_id( $item_id );
                        $image_url      = wp_get_attachment_url( $image_id );
                        $image_alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                        $title          = get_the_title( $item_id );
                        $position       = get_post_meta( $item_id, '_positions_in_companies', true );
                        $reviwe_message = get_post_meta( $item_id, '_teach_reviwe_message', true );
                        $companies      = wp_get_post_terms( $item_id, 'companies' );
                        $url            = get_permalink( $item_id );

                        include get_template_directory() . '/template-parts/blocks/block-person-item.php';
                    }
                endforeach;
            ?>
        </div>
    </div>
</div>

<div id="tab-graduates" class="tab-content">
    <div class="program-graduates">
        <div class="items">
            <?php 
                $students = apply_filters( 'mib_get_posts', 'students');
                
                if ( $students->have_posts() ) {
                    while ( $students->have_posts() ) {
                        $students->the_post();
                        $item_id        = get_the_ID();
                        $image_id       = get_post_thumbnail_id();
                        $image_url      = wp_get_attachment_url( $image_id );
                        $image_alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                        $title          = get_the_title();
                        $position       = get_post_meta( $item_id, '_st_positions_in_companies', true );
                        $reviwe_message = get_post_meta( $item_id, '_st_review_message', true );
                        $courses        = apply_filters( 'mib_get_posts_relationships', array( 'post_type' => 'students', 'post_id' => $item_id, 'field' => 'tr_program_students' ) );
                        $companies      = wp_get_post_terms( $item_id, 'companies' );

                        include get_template_directory() . '/template-parts/blocks/block-person-item.php';
                    }
                }
            ?>
        </div>
    </div>
</div>

<div id="tab-program-content" class="tab-content">
    <?php include get_template_directory() . '/template-parts/program/blocks/program_structure.php'; ?>
</div>

<div id="tab-admission-requirements" class="tab-content">
    <?php include get_template_directory() . '/template-parts/program/blocks/program_admission_requirements.php'; ?>
</div>

<div id="tab-listeners" class="tab-content">
    <?php include get_template_directory() . '/template-parts/program/blocks/program_listeners.php'; ?>
</div>