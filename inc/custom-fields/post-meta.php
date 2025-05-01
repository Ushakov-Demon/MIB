<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
add_action( 'carbon_fields_register_fields', 'custom_posts_meta_data' );

function custom_posts_meta_data() {
    $date_format     = get_option( 'date_format' );
    $period_options  = [
        'days'   => 'Days',
        'weeks'  => 'Weeks',
        'months' => 'Months',
        'years'  => 'Years',
    ];

    $members_activities_options = apply_filters( 'mib_get_array_by_option', 'activity_list', 'activity_item' );
    $members_statuses_options   = apply_filters( 'mib_get_array_by_option', 'member_statuses_list', 'statuses_item' );
    $members_cities_options     = apply_filters( 'mib_get_array_by_option', 'cities_list', 'city_item' );

    // ==== PROGRAMS post type
    Container::make( 'post_meta', __( 'Training course icon' ) )
        ->where( 'post_type', '=', 'programs' )
        ->set_context( 'side' )
        ->set_priority( 'high' )
        ->add_fields( array(
            Field::make( 'image', 'tr_program_icon', __( 'Add icon' ) )
    ) );

    Container::make( 'post_meta', __( 'Announcement' ) )
        ->where( 'post_type', 'IN', ['programs', 'accreditations'] )
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
        ) )
        ->add_tab( __( 'Shedule & format' ), array(
            Field::make( 'date', 'tr_program_date_start', __( 'Date start' ) )
                ->set_storage_format( $date_format )
                ->set_width( 33 ),
            Field::make( 'text', 'tr_program_period_length', __( 'Course length' ) )
                ->set_attribute( 'type', 'number' )
                ->set_attribute( 'min', '1' )
                ->set_default_value( 5 )
                ->set_width( 33 ),
            Field::make( 'select', 'tr_program_period', __( 'Period' ) )
                ->add_options( $period_options )
                ->set_default_value( 'months' )
                ->set_width( 33 ),
            Field::make( 'text', 'tr_program_format',  __( 'Format' ) )
         ) )
        ->add_tab( __( 'Members' ) , array(
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

    // ==== TEATCHERS post type
    Container::make( 'post_meta', __( 'Teatcher data' ) )
        ->where( 'post_type', '=', 'teachers' )
        ->add_fields( array(
            Field::make( 'textarea', 'positions_in_companies', __( 'Positions in companies' ) ),
            Field::make( 'textarea', 'teach_reviwe_message', __( 'Reviwe message' ) ),
    ) );

    // ==== STUDENT post type
    Container::make( 'post_meta', __( 'Student data' ) )
        ->where( 'post_type', '=', 'students' )
        ->add_fields( array(
            Field::make( 'select', 'st_activity', __( 'Activity' ) )
                ->add_options( $members_activities_options )
                ->set_width( 33 ),
            Field::make( 'select', 'st_status', __( 'Status' ) )
                ->add_options( $members_statuses_options )
                ->set_width( 33 ),
            Field::make( 'select', 'st_city', __( 'City' ) )
                ->add_options( $members_cities_options )
                ->set_width( 33 ),
            Field::make( 'textarea', 'st_positions_in_companies', __( 'Positions in companies' ) ),
            Field::make( 'textarea', 'st_reviwe_message', __( 'Reviwe message' ) ),
    ) );

    // ==== PAGE post type
    // add_black_page_body_class function
    Container::make( 'post_meta', __( 'Page settings' ) )
        ->where( 'post_type', 'IN', ['page'] )
        ->set_context( 'side' )
        ->set_priority( 'high' )
        ->add_fields( array(
            Field::make( 'checkbox', 'ps_black_page', __( 'Black Page Design' ) )
    ) );
}