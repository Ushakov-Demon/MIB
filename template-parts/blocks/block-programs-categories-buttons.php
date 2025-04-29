<?php

$categories = apply_filters( 'mib_get_course_categories', true );

if ( empty( $categories ) ) {
    return;
} ;
?>

<div class="buttons">
    <?php
    foreach ( $categories as $category ) :
        $href = get_term_link( $category->term_id );
    ?>
    <a href="<?php echo $href?>" class="button">
        <span><?php echo $category->name?></span>
    </a>
    <?php
    endforeach;
    ?>
</div>