<div class="program-tabs">
    <ul class="tabs">
        <li class="active"><a href="#"><i class="icon-star"></i><?php echo pll__('About the Program'); ?></a></li>
        <li><a href="#"><i class="icon-chalkboard"></i><?php echo pll__('Teachers'); ?></a></li>
        <li><a href="#"><i class="icon-graduates"></i><?php echo pll__('Graduates'); ?></a></li>
        <li><a href="#"><i class="icon-ballot-check"></i><?php echo pll__('Program Content'); ?></a></li>
        <li><a href="#"><i class="icon-landmark"></i><?php echo pll__('Admission Requirements'); ?></a></li>
        <li><a href="#"><i class="icon-users"></i><?php echo pll__('Listeners'); ?></a></li>
    </ul>
</div>

<?php
    foreach ( $about_tab_content as $tab ) {
        $tab_type = $tab['_type'];

        if(file_exists(get_template_directory() . "/template-parts/program/tabs/blocks/$tab_type.php")) {
            
        }

        include get_template_directory() . "/template-parts/program/tabs/blocks/$tab_type.php";
        
        echo '<pre>';
            var_dump( $tab );
        echo '</pre>';
    }
?>
