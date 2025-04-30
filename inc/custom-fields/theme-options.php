<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'theme_options_fields' );

function theme_options_fields(){
    $pages_options = apply_filters( 'mib_get_posts_list_options', 'page' );

    Container::make( 'theme_options', __( 'Theme options' ) )
        ->add_fields( array(
            Field::make( 'separator', 'theme_pages_set_sep', __( 'Pages settings' ) ),
            Field::make( 'select', 'events_arhive_page', __( 'Events arhive page' ) )
                ->add_options( $pages_options ),
            Field::make( 'select', 'programs_arhive_page', __( 'Programs arhive page' ) )
                ->add_options( $pages_options ),
        ) );
};