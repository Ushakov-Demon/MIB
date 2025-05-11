<div class="program-tabs">
    <ul class="tabs">
        <li class="active"><a href="#tab-about-program"><i class="icon-star"></i><?php echo pll__('About the program'); ?></a></li>
        <li><a href="#tab-teachers"><i class="icon-chalkboard"></i><?php echo pll__('Teachers'); ?></a></li>
        <li><a href="#tab-graduates"><i class="icon-graduates"></i><?php echo pll__('Graduates'); ?></a></li>
        <li><a href="#tab-program-content"><i class="icon-ballot-check"></i><?php echo pll__('Program content'); ?></a></li>
        <li><a href="#tab-admission-requirements"><i class="icon-landmark"></i><?php echo pll__('Admission requirements'); ?></a></li>
        <li><a href="#tab-listeners"><i class="icon-users"></i><?php echo pll__('Listeners'); ?></a></li>
    </ul>
</div>

<div class="tabs-container">
    <div id="tab-about-program" class="tab-content">
        <?php 
            include get_template_directory() . '/template-parts/program/blocks/program_stats.php';
            include get_template_directory() . '/template-parts/program/blocks/program_accreditation.php';
            include get_template_directory() . '/template-parts/program/blocks/program_results_mission.php';
            include get_template_directory() . '/template-parts/program/blocks/program_benefits.php';
            include get_template_directory() . '/template-parts/program/blocks/program_accordion.php';
        ?>
    </div>
    <div id="tab-teachers" class="tab-content">
        <h3 class="tab-title"><?php echo pll__('Teachers'); ?></h3>

        <?php 
            include get_template_directory() . '/template-parts/program/blocks/program_teachers.php';
        ?>
    </div>
    <div id="tab-graduates" class="tab-content">
        <h3 class="tab-title"><?php echo pll__('Graduates'); ?></h3>

        <?php 
            include get_template_directory() . '/template-parts/program/blocks/program_graduates.php';
        ?>
    </div>
    <div id="tab-program-content" class="tab-content">
        <h3 class="tab-title"><?php echo pll__('Program content'); ?></h3>

        <?php 
            include get_template_directory() . '/template-parts/program/blocks/program_content.php';
        ?>
    </div>
    <div id="tab-admission-requirements" class="tab-content">
        <h3 class="tab-title"><?php echo pll__('Admission requirements'); ?></h3>

    </div>
    <div id="tab-listeners" class="tab-content">
        <h3 class="tab-title"><?php echo pll__('Listeners'); ?></h3>

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

        // echo '<pre>';
        //     var_dump( $tab );
        // echo '</pre>';
    }
?>
