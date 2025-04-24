<?php
use Carbon_Fields\Block;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'custom_posts_gutenberg_blocks' );

function custom_posts_gutenberg_blocks() {
    $def_per_page  = get_option( 'posts_per_page' );
    $home_url      = home_url();
    $blog_page     = get_option( 'page_for_posts' );
    $blog_page_url = ! is_null( $blog_page ) && ! empty( $blog_page ) ? get_the_permalink( $blog_page ) : $home_url;

    // ==== Main top Variative
    Block::make( 'main_top_variative',  __( 'Main HERO' ) )
        ->add_fields( array (
            Field::make( 'separator', 'main_top_variative_sep', __( 'Main HERO' ) ),
            Field::make( 'file', 'main_top_heading_media_before_text', __( 'Hending media before all text' ) )
                ->set_width( 33 )
                ->set_type( 
                    array( 'image' )
                ),
            Field::make( 'file', 'main_top_heading_media', __( 'Hending media' ) )
                ->set_width( 33 )
                ->set_type( 
                    array( 'image' )
                ),
            Field::make( 'file', 'main_top_heading_bg', __( 'Background' ) )
                ->set_width( 33 )
                ->set_type( 
                    array( 'image' )
                )
                ->set_conditional_logic( array(
                    array(
                        'field' => 'main_top_heading_type',
                        'value' => 'media',
                        'compare' => '=',
                    )
                ) ),
            Field::make( 'text', 'main_top_heading_text', __( 'h1' ) ),
            Field::make( 'rich_text', 'main_bottom_text', __( 'First text' ) ),
            Field::make( 'rich_text', 'main_bottom_second_text', __( 'Second text' ) ),
            Field::make( 'text', 'main_bottom_button_text', __( 'Button text' ) )
                ->set_width( 50 ),
            Field::make( 'text', 'main_bottom_button_link', __( 'Button link' ) )
                ->set_default_value( $shop_page_url )        
                ->set_width( 50 ),
        ) )
        ->set_inner_blocks( false )
        ->set_description( __( 'This a block for inner in Hero section page' ) )
        ->set_icon( 'cover-image' )
        ->set_category( 'mib', __( 'MIB' ), 'smiley' )
        ->set_mode( 'both' )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            extract( $fields );
    
            include_once __THEME_DIR__ . '/template-parts/sections/hero-section.php';
        } );

    // ==== Company Logos Repeater Block
    Block::make( 'company_logos_block', __( 'Our Clients' ) )
    ->add_fields( array(
        Field::make( 'separator', 'company_logos_sep', __( 'Our Clients' ) ),
        Field::make( 'text', 'company_logos_heading', __( 'Section Heading' ) )
            ->set_default_value( __( 'Our clients already include employees of these companies' ) ),
        Field::make( 'complex', 'company_logos_items', __( 'Company Items' ) )
            ->add_fields( array(
                Field::make( 'image', 'logo', __( 'Company Logo' ) )
                    ->set_width( 30 )
                    ->set_type( array( 'image' ) )
                    ->set_required( true ),
                Field::make( 'text', 'name', __( 'Company Name' ) )
                    ->set_width( 30 )
                    ->set_required( true ),
                Field::make( 'text', 'url', __( 'Company URL' ) )
                    ->set_width( 40 )
                    ->set_help_text( __( 'Full URL including https://' ) )
            ) )
            ->set_layout( 'tabbed-horizontal' )
            ->set_min( 1 )
    ) )
    ->set_inner_blocks( false )
    ->set_description( __( 'A block to display company logos with links' ) )
    ->set_icon( 'groups' )
    ->set_category( 'mib', __( 'MIB' ), 'smiley' )
    ->set_mode( 'both' )
    ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
        extract( $fields );
        
        // Include the template for rendering
        include_once __THEME_DIR__ . '/template-parts/sections/company-logos-section.php';
    } );
}
