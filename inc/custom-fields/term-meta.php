<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
add_action( 'carbon_fields_register_fields', 'custom_terms_meta_data' );

function custom_terms_meta_data() {
    Container::make( 'term_meta', __( 'Company data' ) )
        ->where( 'term_taxonomy', '=', 'companies' )
        ->add_fields( array(
            Field::make( 'image', 'company_logo', __( 'Upload Logo' ) ),
            Field::make( 'text', 'company_url', __( 'Company url' ) ),
        ) );
}