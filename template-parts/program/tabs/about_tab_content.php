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