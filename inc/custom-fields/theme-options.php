<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'theme_options_fields' );

function theme_options_fields(){
    $pages_options = apply_filters( 'mib_get_posts_list_options', 'page' );
    $cf7_options   = apply_filters( 'mib_get_cf7_forms_options', [] );

    Container::make( 'theme_options', __( 'Theme options' ) )
        ->add_fields( array(
            Field::make( 'separator', 'theme_pages_set_sep', __( 'Pages settings' ) ),
            Field::make( 'select', 'events_arhive_page', __( 'Events arhive page' ) )
                ->add_options( $pages_options ),
            Field::make( 'select', 'programs_arhive_page', __( 'Programs arhive page' ) )
                ->add_options( $pages_options ),
            Field::make( 'separator', 'members_vars_sep', __( 'Members attributes' ) ),
            Field::make( 'complex', 'activity_list', __( 'Fields of activity' ) )
                ->add_fields( array(
                    Field::make( 'text', 'activity_item', __( 'Activity' ) )
                ) )
                ->set_collapsed( true )
                ->set_header_template( '
                    <% if (activity_item) { %>
                        <%- activity_item %>
                    <% } %>
                ' ),
            Field::make( 'complex', 'member_statuses_list', __( 'Statuses' ) )
                ->add_fields( array(
                    Field::make( 'text', 'statuses_item', __( 'Status' ) )
                ) )
                ->set_collapsed( true )
                ->set_header_template( '
                    <% if (statuses_item) { %>
                        <%- statuses_item %>
                    <% } %>
                ' ),
            Field::make( 'complex', 'cities_list', __( 'Cities' ) )
                ->add_fields( array(
                    Field::make( 'text', 'city_item', __( 'City' ) )
                ) )
                ->set_collapsed( true )
                ->set_header_template( '
                    <% if (city_item) { %>
                        <%- city_item %>
                    <% } %>
                ' ),

            Field::make('separator', 'manager_contact_sep', __('Contact Manager')),
            Field::make('text', 'manager_contact_heading', __('Section Heading'))
                ->set_default_value(__('Contact our manager')),
            Field::make('image', 'manager_avatar', __('Manager Avatar'))
                ->set_width(30)
                ->set_type(array('image'))
                ->set_required(true),
            Field::make('text', 'manager_name', __('Manager Name'))
                ->set_width(35)
                ->set_required(true),
            Field::make('text', 'manager_position', __('Manager Position'))
                ->set_width(35)
                ->set_required(true),
            Field::make('select', 'contact_form_id', __('Contact Form 7'))
                ->add_options( $cf7_options )
                ->set_required(true)
                ->set_help_text(__('Select a Contact Form 7 form')),
        ) );
};