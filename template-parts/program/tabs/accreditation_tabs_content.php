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
