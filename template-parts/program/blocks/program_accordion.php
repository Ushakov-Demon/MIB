

    <div class="accordion-item">
        <div class="accordion-header"><div class="accordion-title"><?php echo pll__('Completion documents'); ?></div></div>
        <div class="accordion-content">

            <?php 
                include get_template_directory() . '/template-parts/program/blocks/program_documents.php';
            ?>

        </div>
    </div>

    <div class="accordion-item">
        <div class="accordion-header"><div class="accordion-title"><?php echo pll__('Cost of education'); ?></div></div>
        <div class="accordion-content">
            
            <?php 
                include get_template_directory() . '/template-parts/program/blocks/program_cost.php';
            ?>
            
        </div>
    </div>

    <div class="accordion-item">
        <div class="accordion-header"><div class="accordion-title"><?php echo pll__('Admission Requirements'); ?></div></div>
        <div class="accordion-content">

            <?php 
                include get_template_directory() . '/template-parts/program/blocks/program_admission_requirements.php';
            ?>
            
        </div>
    </div>

    <div class="accordion-item">
        <div class="accordion-header"><div class="accordion-title"><?php echo pll__('Program Content'); ?></div></div>
        <div class="accordion-content">

            <?php 
                include get_template_directory() . '/template-parts/program/blocks/program_content.php';
            ?>

            <div class="program-content-all">
                <a href="#tab-program-content" class="show-more-link"><?php echo pll__('View all'); ?></a>
            </div>
            
        </div>
    </div>

    <div class="accordion-item">
        <div class="accordion-header"><div class="accordion-title"><?php echo pll__('Teachers'); ?></div></div>
        <div class="accordion-content">

            <?php 
                include get_template_directory() . '/template-parts/program/blocks/program_teachers.php';
            ?>

            <div class="program-content-all">
                <a href="#tab-teachers" class="show-more-link"><?php echo pll__('View all teachers'); ?></a>
            </div>
            
        </div>
    </div>

    <div class="accordion-item">
        <div class="accordion-header"><div class="accordion-title"><?php echo pll__('Graduates'); ?></div></div>
        <div class="accordion-content">

            <?php 
                include get_template_directory() . '/template-parts/program/blocks/program_graduates.php';
            ?>

            <div class="program-content-all">
                <a href="#tab-graduates" class="show-more-link"><?php echo pll__('View all graduates'); ?></a>
            </div>
            
        </div>
    </div>

    <div class="accordion-item">
        <div class="accordion-header"><div class="accordion-title"><?php echo pll__('Listeners'); ?></div></div>
        <div class="accordion-content">

            <?php 
                include get_template_directory() . '/template-parts/program/blocks/program_listeners.php';
            ?>
            
        </div>
    </div>