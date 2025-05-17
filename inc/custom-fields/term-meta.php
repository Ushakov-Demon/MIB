<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
add_action( 'carbon_fields_register_fields', 'custom_terms_meta_data' );

function custom_terms_meta_data() {
    Container::make( 'term_meta', __( 'Company data' ) )
        ->where( 'term_taxonomy', '=', 'companies' )
        ->add_fields( array(
            Field::make( 'image', 'company_logo', __( 'Upload logo' ) ),
            Field::make( 'text', 'company_url', __( 'Company url' ) ),
            Field::make( 'text', 'company_phone', __( 'Company phone' ) ),
            Field::make( 'text', 'company_address', __( 'Company address' ) ),
            Field::make( 'text', 'company_email', __( 'Company email' ) ),
            Field::make( 'checkbox', 'is_slider', __( 'Slider' ) ),
            Field::make( 'checkbox', 'is_partner', __( 'Partner' ) ),
            Field::make( 'checkbox', 'is_business_partner', __( 'Business Partner' ) ),
            Field::make( 'checkbox', 'is_client', __( 'Client' ) ),
            Field::make( 'checkbox', 'is_open_programs_client', __( 'Open Programs Client' ) ),
            Field::make( 'checkbox', 'is_corporate_programs_client', __( 'Corporate Programs Client' ) ),
            Field::make( 'checkbox', 'is_graduate_programs_client', __( 'Graduate/Diploma Programs Client' ) ),
            Field::make( 'checkbox', 'is_business_school', __( 'Business School' ) ),
            Field::make( 'checkbox', 'is_professional_association', __( 'Professional Association' ) ),
            Field::make( 'checkbox', 'is_company', __( 'Company' ) ),
        ) );

    Container::make( 'term_meta', __( 'Program data' ) )
        ->where( 'term_taxonomy', '=', 'program_category' )
        ->add_fields( array(
            Field::make('select', 'programs_columns', __('Number of Columns'))
                ->set_options(array(
                    'column-1' => __('1 Column'),
                    'column-2' => __('2 Columns'),
                    'column-3' => __('3 Columns'),
                ))
                ->set_default_value('3')
                ->set_help_text(__('Select how many columns to display programs in this category')),
            Field::make( 'select', 'main_top_version', __('Select Main Top Version' ))
                ->add_options( array(
                    'white' => __( 'White', ),
                    'black' => __( 'Black', ),
                    'gray'  => __( 'Gray', ),
                    'home'  => __( 'Home' ),
                ) )
                ->set_default_value( 'white' ),
        ) );
}