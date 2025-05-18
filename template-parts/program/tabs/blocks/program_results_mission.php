<?php
if ( empty( $free_content ) && empty( $program_missions ) ) {
    return;
}
?>
<div class="program-results-mission">
    <?php
    if ( ! empty( $free_content ) ) :
    ?>
    <div class="program-results">
        <?php
        echo $free_content;
        ?>
    </div>
    <?php
    endif;

    if ( ! empty( $program_missions ) ) :
    ?>
    <div class="program-mission">
        <?php
            echo $program_missions;
        ?>
    </div>
    <?php
    endif;
    ?>
</div>