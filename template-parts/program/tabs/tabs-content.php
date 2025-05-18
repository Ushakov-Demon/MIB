<?php
$post_id = get_the_id();
$has_about = isset( $about_tab_content );
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
        ?>
        <li>
            <a href="#tab-teachers">
                <i class="icon-chalkboard"></i>

                <?php echo pll__('Teachers'); ?>
            </a>
        </li>

        <li>
            <a href="#tab-graduates">
                <i class="icon-graduates"></i>

                <?php echo pll__('Graduates'); ?>
            </a>
        </li>

        <li>
            <a href="#tab-program-content">
                <i class="icon-ballot-check"></i>

                <?php echo pll__('Program content'); ?>
            </a>
        </li>

        <li>
            <a href="#tab-admission-requirements">
                <i class="icon-landmark"></i>

                <?php echo pll__('Admission requirements'); ?>
            </a>
        </li>

        <li>
            <a href="#tab-listeners">
                <i class="icon-users"></i>

                <?php echo pll__('Listeners'); ?>
            </a>
        </li>
    </ul>
</div>

<div class="tabs-container">
    <?php
    foreach ( $fields as $key => $field ) {
        switch( $key ) {
            case 'about_tab_content';
                include get_template_directory() . '/template-parts/program/tabs/about_tab_content.php';
                break;
        }
    }
    ?>
</div>
