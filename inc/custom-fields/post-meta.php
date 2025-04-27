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

    Container::make( 'post_meta', __( 'Announcement' ) )
        ->where( 'post_type', '=', 'programs' )
        ->set_context( 'side' )
        ->set_priority( 'high' )
        ->add_fields( array(
            Field::make( 'checkbox', 'tr_program_is_announce', __( 'Is announcement' ) )
        ) );

    Container::make( 'post_meta', __( 'Training course data' ) )
        ->where( 'post_type', '=', 'programs' )
        ->add_tab( __( 'Main' ), array(
            Field::make( 'separator', 'program_prices_sep', __( 'Prices' ) ),
            Field::make( 'text', 'tr_program_regular_price', __( 'Price' ) )
                ->set_attribute( 'type', 'number' )
                ->set_width( 33 ),
            Field::make( 'text', 'tr_program_additional_price', __( 'Additional price' ) )
                ->set_attribute( 'type', 'number' )
                ->set_width( 33 ),
            Field::make( 'select', 'tr_program_additional_price_currency', __( 'Currency (for Additional price)' ) )
                ->set_width( 33 )
                ->set_options( MIB_CURRENCIES ),
            Field::make( 'text', 'tr_program_sale_price', __( 'Sale price' ) )
                ->set_attribute( 'type', 'number' )
                ->set_width( 50 ),
            Field::make( 'text', 'tr_program_sale_price_date_end', __( 'Apply sale price before date' ) )
                ->set_width( 50 ),
            Field::make( 'separator', 'program_members_sep', __( 'Members' ) ),
            Field::make( 'association', 'tr_program_teatchers', __( 'Teatchers' ) )
                ->set_types( array(
                    array(
                        'type'      => 'post',
                        'post_type' => 'teachers',
                    )
                ) ),
            Field::make( 'association', 'tr_program_students', __( 'Students' ) )
                ->set_types( array(
                    array(
                        'type'      => 'post',
                        'post_type' => 'students',
                    )
                ) ),
        ) );

    // ==== EVENTS post type
    Container::make( 'post_meta', __( 'Event shedule date' ) )
        ->where( 'post_type', '=', 'events' )
        ->set_context( 'side' )
        ->set_priority( 'high' )
        ->add_fields( array(
            Field::make( 'date_time', 'event_shedule_date', __( 'Choice date and time' ) )
        ) );

    // ==== TEATCHERS POST type
    Container::make( 'post_meta', __( 'Teatcher data' ) )
        ->where( 'post_type', '=', 'teachers' )
        ->add_fields( array(
            Field::make( 'textarea', 'positions_in_companies', __( 'Positions in companies' ) ),
        ) );
}