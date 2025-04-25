<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
add_action( 'carbon_fields_register_fields', 'custom_posts_meta_data' );

function custom_posts_meta_data() {
    // ==== PROGRAMS post type
    Container::make( 'post_meta', __( 'Training course icon' ) )
        ->where( 'post_type', '=', 'programs' )
        ->set_context( 'side' )
        ->set_priority( 'high' )
        ->add_fields( array(
            Field::make( 'image', 'tr_program_icon', __( 'Add icon' ) )
        ) );

    // ==== EVENTS post type
    Container::make( 'post_meta', __( 'Event shedule date' ) )
    ->where( 'post_type', '=', 'events' )
    ->set_context( 'side' )
    ->set_priority( 'high' )
    ->add_fields( array(
        Field::make( 'date_time', 'event_shedule_date', __( 'Choice date and time' ) )
    ) );
}