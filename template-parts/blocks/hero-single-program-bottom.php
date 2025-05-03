<?php
    $prefix              = "programs" == $post_type ? '_tr_program' : '';
    $start_str           = get_post_meta( $post_id, $prefix . '_date_start', true );
    $differences         = mib_get_time_difference( $start_str );
    $duration            = get_post_meta( $post_id, $prefix . '_period_length', true );
    $duration_period     = get_post_meta( $post_id, $prefix . '_period', true );
    $format              = get_post_meta( $post_id, $prefix . '_format', true );
    $language            = get_post_meta( $post_id, $prefix . '_language', true );

    $time_left = '';

    if ( 0 < $differences['months'] ) {
        $time_left = sprintf( '<strong>%s %s</strong>', $differences['months'],  pll__( 'months', 'baza' ) );
    } elseif ( 0 == $differences['months'] && 2 < $differences['days'] ) {
        $time_left = sprintf( '<strong>%s %s</strong>', $differences['days'],  pll__( 'days', 'baza' ) );
    } elseif ( 1 <= $differences['days'] ) {
        $time_left = '<stong>' . pll__( 'Tomorrow', 'baza' ) . '</strong>';
    }
?>

<div class="hero-short-details">
    <?php
    if ( ! empty( $time_left ) ):
        ?>
        <div class="item">
            <?php
                pll_e( 'Remaining', 'baza' );
                echo $time_left;
            ?>
        </div>
        <?php
    endif;

    if ( ! empty( $start_str ) ) :
        ?>
        <div class="item start-date"> <!-- add class start-date for adding icon in Event post type -->
            <?php
            if ( "programs" == $post_type ) {
                pll_e( 'Start of the program', 'baza' );
            }
            ?>

            <strong>
                <?php
                    echo $start_str;
                    if ( "programs" !== $post_type ) {
                        $day_week = date( 'l', $differences['unix_input_date'] );
                        echo ' (' . pll__( $day_week, 'baza' ) . ')';
                    }
                    ?>
            </strong>
        </div>
        <?php
    endif;

    if ( ! empty( $duration ) ) :
        ?>
        <div class="item">
            <?php
            pll_e( 'Duration', 'baza' );
            ?>

            <strong>
                <?php
                echo $duration . ' ' . pll__( $duration_period, 'baza' );
                ?>
            </strong>
        </div>
        <?php
    endif;

    if ( ! empty( $format ) ):
        ?>
        <div class="item">
            <?php
            pll_e( 'Program format', 'baza' );
            ?>

            <strong>
                <?php
                echo $format;
                ?>
            </strong>
        </div>
        <?php
    endif;
    
    if ( ! empty( $language ) ):
        ?>
        <div class="item">
            <?php
            pll_e( 'Program language', 'baza' );
            ?>

            <strong>
                <?php
                echo $language;
                ?>
            </strong>
        </div>
        <?php
    endif;
    ?>
</div>