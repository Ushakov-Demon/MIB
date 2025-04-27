<section class="section section-students">
    <div class="container">
        <div class="section-title">
            <span>Випускники</span>
            <a class="section-link">Всі випускники</a>
        </div>
        <!-- TODO: if courosel add class owl-courosel and id students-items <div class="items owl-carousel" id="students-items"> -->
        <div class="items owl-carousel" id="students-items">
            <?php 
                for ($i = 0; $i < 10; $i++): 
                    include get_template_directory() . '/template-parts/blocks/block-student-item.php'; 
                endfor; 
            ?>
        </div>
    </div>
</section>