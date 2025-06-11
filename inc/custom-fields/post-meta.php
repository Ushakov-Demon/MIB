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
    Container::make( 'post_meta', __( 'Turn on remaining date' ) )
        ->where( 'post_type', '=', 'programs' )
        ->set_context( 'side' )
        ->set_priority( 'high' )
        ->add_fields( array(
            Field::make( 'checkbox', 'show_remaining_date', __( 'Show remaining' ) ),
    ) );

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
        ->add_tab( __('Main'), array(
            Field::make( 'text', 'tr_program_language', __( 'Language' ) ),
            Field::make( 'association', 'tr_progaram_accriditation', __( 'Accriditation' ) )
                ->set_types( array(
                    array(
                        'type'      => 'post',
                        'post_type' => 'accreditations',
                    )
                ) )
        ) )
        ->add_tab( __( 'Prices and Summary' ), array(
            Field::make( 'text', 'tr_program_regular_price', __( 'Price' ) )
                ->set_attribute( 'type', 'number' )
                ->set_width( 33 ),
            Field::make( 'text', 'tr_program_regular_price_label', __( 'Price label' ) )
                ->set_width( 33 ),
            Field::make( 'text', 'tr_program_sale_price', __( 'Sale price' ) )
                ->set_attribute( 'type', 'number' )
                ->set_width( 33 ),
            Field::make( 'text', 'tr_program_additional_price', __( 'Additional price' ) )
                ->set_attribute( 'type', 'number' )
                ->set_width( 33 ),
            Field::make( 'select', 'tr_program_additional_price_currency', __( 'Currency (for Additional price)' ) )
                ->set_width( 33 )
                ->set_options( MIB_CURRENCIES ),
            Field::make( 'date', 'tr_program_sale_price_date_end', __( 'Apply sale price before date' ) )
                ->set_width( 33 ),
            Field::make( 'text', 'tr_program_regular_price_info', __( 'Price info' ) )
                ->set_width( 33 ),
            Field::make( 'text', 'tr_program_completed_studies', __( 'Completed studies' ) )
                ->set_width( 33 ),
            Field::make( 'text', 'tr_program_enhanced_qualifications', __( 'Enhanced qualifications' ) )
                ->set_width( 33 ),
        ) )
        ->add_tab( __( 'Shedule & format' ), array(
            Field::make( 'date', 'tr_program_date_start', __( 'Date start' ) )
                ->set_storage_format( $date_format )
                ->set_width( 20 ),
            Field::make( 'text', 'tr_program_period_length', __( 'Course length' ) )
                ->set_attribute( 'type', 'number' )
                ->set_attribute( 'min', '1' )
                ->set_default_value( 5 )
                ->set_width( 20 ),
            Field::make( 'select', 'tr_program_period', __( 'Period' ) )
                ->add_options( $period_options )
                ->set_default_value( 'months' )
                ->set_width( 20 ),
            Field::make( 'text', 'tr_program_number_of_courses', __( 'Number of courses' ) )
                ->set_attribute( 'type', 'number' )
                ->set_width( 20 ),
            Field::make( 'text', 'tr_program_format',  __( 'Format' ) )
                ->set_width( 20 ),
        ) )
        ->add_tab( __( 'Param stats' ), array(
            Field::make( 'text', 'tr_program_stats_hours', __( 'Learning hours' ) )
                ->set_attribute( 'type', 'number' )
                ->set_width( 20 ),
            Field::make( 'text', 'tr_program_stats_offline', __( 'Offline percentage' ) )
                ->set_attribute( 'type', 'number' )
                ->set_width( 20 ),
            Field::make( 'text', 'tr_program_stats_teachers', __( 'Number of teachers' ) )
                ->set_attribute( 'type', 'number' )
                ->set_width( 20 ),
            Field::make( 'text', 'tr_program_stats_cases', __( 'Number of real cases' ) )
                ->set_attribute( 'type', 'number' )
                ->set_width( 20 ),

            Field::make( 'separator', 'tr_program_stats_separator', __( 'Labels for Stats' ) ),

            Field::make( 'textarea', 'tr_program_stats_hours_label', __( 'Learning hours Text' ) )
                ->set_width( 20 ),
            Field::make( 'textarea', 'tr_program_stats_offline_label', __( 'Offline percentage Text' ) )
                ->set_width( 20 ),
            Field::make( 'textarea', 'tr_program_stats_teachers_label', __( 'Number of teachers Text' ) )
                ->set_width( 20 ),
            Field::make( 'textarea', 'tr_program_stats_cases_label', __( 'Number of real cases Text' ) )
                ->set_width( 20 ),
        ) )
        ->add_tab( __( 'Members' ) , array(
            Field::make( 'association', 'tr_program_teachers', __( 'Teachers' ) )
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
            Field::make( 'date_time', 'event_shedule_date', __( 'Choice date and time' ) ),
            Field::make( 'select', 'event_format', __( 'Online || Offline' ) )
            ->set_width( 25 )
            ->add_options( array(
                'online'  => __( 'Online' ),
                'offline' => __( 'Offline' ),
            ) )
    ) );

    Container::make( 'post_meta', __( 'Event data' ) )
        ->where( 'post_type', '=', 'events' )
        ->add_fields( array(
            // About talk block
            Field::make( 'separator', 'about_talk_sep', __( 'About talk' ) ),
            Field::make( 'textarea', 'about_talk_title', __( 'Title block' ) ),
            Field::make( 'complex', 'about_talk_list', __( 'Topics' ) )
                ->set_collapsed( true )
                ->add_fields( array(
                    Field::make( 'text', 'about_talk_topic', __( 'Single topic' ) )
                ) )
                ->set_header_template( '
                    <% if (about_talk_topic) { %>
                        <%- about_talk_topic %>
                    <% } %>
                ' ),
            // Invitation block
            Field::make( 'separator', 'invitation_sep', __( 'Invitation' ) ),
            Field::make( 'text', 'invitation_block_title', __( 'Title' ) )
                ->set_default_value( 'Запрошуємо' ),
            Field::make( 'complex', 'invitations', __( 'invitations list' ) )
                ->set_collapsed( true )
                ->add_fields( array(
                    Field::make( 'image', 'invite_icon', __( 'Icon' ) )
                        ->set_width( 25 ),
                    Field::make( 'textarea', 'invite_text', __( 'Text' ) )
                        ->set_width( 75 ),
                ) )
                ->set_header_template( '
                    <% if (invite_text) { %>
                        <%- invite_text %>
                    <% } %>
                ' ),
            // Brief announcement
            Field::make( 'separator', 'announcement_sep', __( 'Brief announcement' ) ),
            Field::make( 'textarea', 'announcement_title', __( 'Title block' ) ),
            Field::make( 'rich_text', 'announcement_content', __( 'Desc content' ) ),
            Field::make( 'image', 'special_guest_icon', __( 'Special guest icon' ) )
                ->set_width( 25 ),
            Field::make( 'textarea', 'special_guest_text', __( 'Special guest text' ) )
                ->set_width( 75 ),
            // Plan block
            Field::make( 'separator', 'event_plan_sep', __( 'Plan' ) ),
            Field::make( 'textarea', 'event_plan_title', __( 'Title plan section' ) )
                ->set_default_value( 'План зустрічі' ),
            Field::make( 'complex', 'event_plan', __( 'Event plan list' ) )
                ->set_collapsed( true )
                ->add_fields( array( 
                    Field::make( 'text', 'plan_item_time_between', __( 'Time' ) )
                        ->set_width( 25 ),
                    Field::make( 'text', 'plan_item_time_topic', __( 'Topic' ) )
                        ->set_width( 75 ),
                    Field::make( 'select', 'plan_item_have_presenter', __( 'Have presenter' ) )
                        ->add_options( array(
                            'yes' => __( 'Yes' ),
                            'no'  => __( 'No' ),
                        ) )
                        ->set_default_value( 'yes' )
                        ->set_width( 50 ),
                    Field::make( 'select', 'plan_item_presenter_member', __( 'Select from members or add manualy' ) )
                        ->add_options( array(
                            'member'    => __( 'Select from members' ),
                            'manualy'   => __( 'Add manualy' ),
                        ) )
                        ->set_default_value( 'member' )
                        ->set_conditional_logic( array(
                            array(
                                'field'   => 'plan_item_have_presenter',
                                'compare' => '!=',
                                'value'   => 'no',
                            )
                        ) )
                        ->set_width( 50 ),
                    Field::make( 'image', 'plan_item_icon', __( 'Item icon' ) )
                        ->set_width( 50 )
                        ->set_conditional_logic( array(
                            array(
                                'field'   => 'plan_item_have_presenter',
                                'compare' => '=',
                                'value'   => 'no',
                            ),
                        ) ),
                    Field::make( 'association', 'plan_item_presenter', __( 'Presenter' ) )
                        ->set_max( 1 )
                        ->set_types( array(
                            array(
                                'type'      => 'post',
                                'post_type' => 'teachers',
                            ),
                            array(
                                'type'      => 'post',
                                'post_type' => 'students',
                            )
                        ) )
                        ->set_conditional_logic( array(
                            array(
                                'field'   => 'plan_item_have_presenter',
                                'compare' => '!=',
                                'value'   => 'no',
                            ),
                            array(
                                'field'   => 'plan_item_presenter_member',
                                'compare' => '=',
                                'value'   => 'member',
                            )
                        ) ),
                        Field::make( 'image', 'presenter_icon', __( 'Presenter icon' ) )
                            ->set_width( 25 )
                            ->set_conditional_logic( array(
                                array(
                                    'field'   => 'plan_item_have_presenter',
                                    'compare' => '!=',
                                    'value'   => 'no',
                                ),
                                array(
                                    'field'   => 'plan_item_presenter_member',
                                    'compare' => '=',
                                    'value'   => 'manualy',
                                )
                            ) ),
                        Field::make( 'text', 'presenter_name', __( 'Presenter name' ) )
                            ->set_width( 37 )
                            ->set_conditional_logic( array(
                                array(
                                    'field'   => 'plan_item_have_presenter',
                                    'compare' => '!=',
                                    'value'   => 'no',
                                ),
                                array(
                                    'field'   => 'plan_item_presenter_member',
                                    'compare' => '=',
                                    'value'   => 'manualy',
                                )
                            ) ),
                        Field::make( 'text', 'presenter_message', __( 'Presenter message' ) )
                            ->set_width( 37 )
                            ->set_conditional_logic( array(
                                array(
                                    'field'   => 'plan_item_have_presenter',
                                    'compare' => '!=',
                                    'value'   => 'no',
                                ),
                                array(
                                    'field'   => 'plan_item_presenter_member',
                                    'compare' => '=',
                                    'value'   => 'manualy',
                                )
                            ) ),
                ) )
                ->set_header_template( '
                            <% if (plan_item_time_topic) { %>
                                <%- plan_item_time_topic %>
                            <% } %>
                        ' ),
    ) );

    // ==== TEATCHERS post type
    Container::make( 'post_meta', __( 'Teatcher data' ) )
        ->where( 'post_type', '=', 'teachers' )
        ->add_fields( array(
            Field::make( 'textarea', 'positions_in_companies', __( 'Positions in companies' ) ),
            Field::make( 'textarea', 'teach_review_message', __( 'Review message' ) ),
    ) );

    // ==== STUDENT post type
    Container::make( 'post_meta', __( 'Student data' ) )
        ->where( 'post_type', '=', 'students' )
        ->add_fields( array(
            Field::make( 'select', 'st_gender', __( 'Gender' ) )
                ->add_options( array(
                    'man' => __( 'Man' ),
                    'woman' => __( 'Woman' ),
                ) )
                ->set_width( 50 ),
            Field::make( 'text', 'st_year_graduation', __( 'Year of graduation' ) )
                ->set_width( 50 ),
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
            Field::make( 'textarea', 'st_review_message', __( 'Review message' ) ),
    ) );

    // ==== ACCREDITATION post type
    Container::make( 'post_meta', __( 'Accreditation data' ) )
    ->where( 'post_type', '=', 'accreditations' )
    ->set_context('side')
    ->set_priority('high')
    ->add_fields( array(
        Field::make( 'image', 'accr_white_logo', __( 'Certificate White Logo' ) ),
        Field::make( 'image', 'accr_certificate', __( 'Certificate' ) ),
        Field::make( 'text', 'accr_site_url', __( 'Site url' ) ),
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

    // ==== MEBMBERS
    Container::make('post_meta', __('Team Information'))
        ->where('post_type', '=', 'members')
        ->add_fields(array(
            Field::make('text', 'position', __('Position'))
                ->set_width(100),
            Field::make('text', 'linkedin', __('LinkedIn URL'))
                ->set_width(50),
            Field::make('text', 'facebook', __('Facebook URL'))
                ->set_width(50),
    ));
}