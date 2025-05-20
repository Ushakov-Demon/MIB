<?php
$post_id       = get_the_id();
$has_about     = isset( $about_tab_content );
$has_teachers  = isset( $show_titchers ) && "yes" == $show_titchers;
$has_students  = isset( $show_students ) && "yes" == $show_students;
// $has_structure = isset( $program_structure_tab_content ) && ! empty( $program_structure_tab_content );
$has_structure = true;
$has_listeners = ! empty( $listners_tab_content ) || ! empty( $listners_tab_repeater );
?>

<div class="program-tabs">
    <ul class="tabs">
        <?php
        if ( $has_about ) :
            ?>
            <li class="active">
                <a href="#tab-about-program">
                    <i class="icon-star"></i>

                    <?php echo pll__('About the program'); ?>
                </a>
            </li>
            <?php
        endif;

        if ( $has_teachers ) :
        ?>
        <li>
            <a href="#tab-teachers">
                <i class="icon-chalkboard"></i>

                <?php echo pll__('Teachers'); ?>
            </a>
        </li>
        <?php
        endif;

        if ( $has_students ) :
        ?>
        <li>
            <a href="#tab-graduates">
                <i class="icon-graduates"></i>

                <?php echo pll__('Graduates'); ?>
            </a>
        </li>
        <?php
        endif;

        if ( $has_structure ) :
        ?>
        <li>
            <a href="#tab-program-content">
                <i class="icon-ballot-check"></i>

                <?php echo pll__('Program content'); ?>
            </a>
        </li>
        <?php
        endif;
        ?>
        <li>
            <a href="#tab-admission-requirements">
                <i class="icon-landmark"></i>

                <?php echo pll__('Admission requirements'); ?>
            </a>
        </li>
        <?php
        if ( $has_listeners ) :
        ?>
        <li>
            <a href="#tab-listeners">
                <i class="icon-users"></i>

                <?php echo pll__('Listeners'); ?>
            </a>
        </li>
        <?php
        endif;
        ?>
    </ul>
</div>

<div class="tabs-container">
    <?php
    foreach ( $fields as $key => $field ) {
        switch( $key ) {
            case 'about_tab_content':
                include get_template_directory() . '/template-parts/program/tabs/about_tab_content.php';
                break;
            case 'show_titchers':
                if ( "yes" == $field ) {
                    include get_template_directory() . '/template-parts/program/tabs/teachers-tab.php';
                };
                break;
            case 'show_students':
                if ( "yes" == $field ) {
                    include get_template_directory() . '/template-parts/program/tabs/graduates-tab.php';
                };
                break;
            case 'program_structure_tab_content':
                //if ( ! empty( $field ) ) {
                    include get_template_directory() . '/template-parts/program/tabs/program-structure-tab.php';
                //};
                break;
            case 'use_admission_conditions':
                include get_template_directory() . '/template-parts/program/blocks/program_admission_requirements.php';
                break;
            case 'listners_tab_content':
            case 'listners_tab_repeater':
                if ( ! empty( $field ) ) {
                    include get_template_directory() . '/template-parts/program/blocks/program_listeners.php';
                };
                break;
        }
    }
    ?>
</div>
