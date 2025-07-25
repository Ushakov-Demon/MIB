<div class="program-tabs">
    <ul class="tabs">
        <li class="active"><a href="#about-program"><i class="icon-star"></i><?php echo pll__('About the program', 'baza'); ?></a></li>
        <li><a href="#teachers"><i class="icon-chalkboard"></i><?php echo pll__('Teachers', 'baza'); ?></a></li>
        <li><a href="#graduates"><i class="icon-graduates"></i><?php echo pll__('Graduates', 'baza'); ?></a></li>
        <li><a href="#program-content"><i class="icon-ballot-check"></i><?php echo pll__('Program content', 'baza'); ?></a></li>
        <li><a href="#admission-requirements"><i class="icon-landmark"></i><?php echo pll__('Admission requirements', 'baza'); ?></a></li>
        <li><a href="#listeners"><i class="icon-users"></i><?php echo pll__('Listeners', 'baza'); ?></a></li>
    </ul>
</div>

<div class="tabs-container">
    <div id="about-program" class="tab-content">
        <?php 
            include get_template_directory() . '/template-parts/program/blocks/program_stats.php';
            include get_template_directory() . '/template-parts/program/blocks/program_accreditation.php';
            include get_template_directory() . '/template-parts/program/blocks/program_results_mission.php';
            include get_template_directory() . '/template-parts/program/blocks/program_benefits.php';
            include get_template_directory() . '/template-parts/program/blocks/program_accordion.php';
        ?>
    </div>
    <div id="teachers" class="tab-content">
        <h3 class="tab-title"><?php echo pll__('Teachers', 'baza'); ?></h3>

        <?php 
            include get_template_directory() . '/template-parts/program/blocks/program_teachers.php';
        ?>
    </div>
    <div id="graduates" class="tab-content">
        <h3 class="tab-title"><?php echo pll__('Graduates', 'baza'); ?></h3>

        <?php 
            include get_template_directory() . '/template-parts/program/blocks/program_graduates.php';
        ?>
    </div>
    <div id="program-content" class="tab-content">
        <h3 class="tab-title"><?php echo pll__('Program content', 'baza'); ?></h3>

        <?php 
            include get_template_directory() . '/template-parts/program/blocks/program_content.php';
            include get_template_directory() . '/template-parts/program/blocks/program_teaching_methods.php';
            include get_template_directory() . '/template-parts/program/blocks/program_structure.php';
        ?>
    </div>
    <div id="admission-requirements" class="tab-content">
        <h3 class="tab-title"><?php echo pll__('Admission requirements', 'baza'); ?></h3>

        <?php 
            include get_template_directory() . '/template-parts/program/blocks/program_admission_requirements.php';
        ?>
    </div>
    <div id="listeners" class="tab-content">
        <h3 class="tab-title"><?php echo pll__('Listeners', 'baza'); ?></h3>

        <?php 
            include get_template_directory() . '/template-parts/program/blocks/program_listeners.php';
        ?>
    </div>
</div>

<?php
    foreach ( $about_tab_content as $tab ) {
        $tab_type = $tab['_type'];

        // if(file_exists(get_template_directory() . "/template-parts/program/tabs/blocks/$tab_type.php")) {
        //     include get_template_directory() . "/template-parts/program/tabs/blocks/$tab_type.php";
        // }

        echo '<pre>';
            var_dump( $tab );
        echo '</pre>';
    }
?>
