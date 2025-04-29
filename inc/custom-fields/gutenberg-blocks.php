<?php
use Carbon_Fields\Block;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'custom_posts_gutenberg_blocks' );

function custom_posts_gutenberg_blocks() {
    $def_per_page  = get_option( 'posts_per_page' );
    $home_url      = home_url();
    $blog_page     = get_option( 'page_for_posts' );
    $blog_page_url = ! is_null( $blog_page ) && ! empty( $blog_page ) ? get_the_permalink( $blog_page ) : $home_url;
    $current_lang  = function_exists('pll_current_language') ? pll_current_language() : '';
    $pages_options = apply_filters( 'mib_get_posts_list_options', 'page' );
    $cf7_options   = apply_filters( 'mib_get_cf7_forms_options', [] );

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
            Field::make('select', 'main_top_version', __('Select Version'))
                ->add_options( array(
                    '' => __( 'Select a version' ),
                    'home' => __( 'Home' ),
                    'black' => __( 'Black', ),
                    'white' => __( 'White', )
                ) ),
            Field::make( 'rich_text', 'main_bottom_text', __( 'First text' ) ),
            Field::make( 'rich_text', 'main_bottom_second_text', __( 'Second text' ) ),
            Field::make( 'text', 'main_bottom_button_text', __( 'Button text' ) )
                ->set_width( 50 ),
            Field::make( 'text', 'main_bottom_button_link', __( 'Button link' ) )
                ->set_default_value( $blog_page_url )        
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

        ) )
        ->set_description( __( 'A block to display company logos with links' ) )
        ->set_icon( 'groups' )
        ->set_category( 'mib' )
        ->set_mode( 'both' )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            extract( $fields );
        
        // Include the template for rendering
        include_once __THEME_DIR__ . '/template-parts/sections/company_logos-section.php';
    } );

    // ==== Training programs
    Block::make( 'programs_previews', __( 'Training programs' ) )
        ->set_category( 'mib' )
        ->set_mode( 'both' )
        ->set_icon( 'welcome-learn-more' )
        ->add_fields( array(
            Field::make( 'separator', 'programs_previews_sep', __( 'Training programs' ) ),
            Field::make( 'text', 'programs_per_page', __( 'Posts per page' ) )
                ->set_width( 33 )
                ->set_attribute( 'type', 'number' )
                ->set_default_value( $def_per_page ),
            Field::make( 'text', 'programs_section_link_text', __( 'Link text' ) )
                ->set_width( 33 )
                ->set_default_value( 'Всі програми' ),

            Field::make( 'select', 'programs_section_link', __( 'Link' ) )
                ->set_width( 33 )
                ->add_options( $pages_options ),

            Field::make( 'text', 'programs_section_small_text', __( 'Section small text' ) )
                ->set_default_value( 'Програми навчання' )
                ->set_width( 50 ),
            Field::make( 'text', 'programs_section_title', __( 'Section title' ) )
                ->set_default_value( 'MBA — ексклюзивні програми' )
                ->set_width( 50 ),
            Field::make( 'textarea', 'programs_section_desc', __( 'Section Desription' ) )
        ) )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            extract( $fields );
        
        include_once __THEME_DIR__ . '/template-parts/sections/programs_previews-section.php';
    } );

    Block::make( 'actuality_posts_section', __( 'Mixed posts previews' ) )
        ->set_inner_blocks( false )
        ->set_category( 'mib' )
        ->set_mode( 'both' )
        ->set_icon( 'randomize' )
        ->add_fields( array(
            Field::make( 'separator', 'actuality_posts_sep', __( 'Mixed posts previews' ) ),
            Field::make( 'text', 'actuality_posts_per_page', __( 'Posts per page' ) )
                ->set_width( 33 )
                ->set_attribute( 'type', 'number' )
                ->set_default_value( $def_per_page ),
            Field::make( 'text', 'actuality_posts_link_text', __( 'Link text' ) )
                ->set_width( 33 )
                ->set_default_value( 'Всі записи' ),
            Field::make( 'text', 'actuality_posts_link', __( 'Link' ) )
                ->set_width( 33 ),
            Field::make( 'text', 'actuality_posts_title', __( 'Section title' ) )
                ->set_default_value( 'Актуальне' ),
            Field::make( 'textarea', 'actuality_posts_desc', __( 'Section Desription' ) )
        ) )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            extract( $fields );
        
        include_once __THEME_DIR__ . '/template-parts/sections/actuality_previews-section.php';
    } );

    Block::make( 'accreditations_posts_section', __( 'Accreditations previews' ) )
        ->set_inner_blocks( false )
        ->set_category( 'mib' )
        ->set_mode( 'both' )
        ->set_icon( 'media-document' )
        ->add_fields( array(
            Field::make( 'separator', 'accreditations_posts_sep', __( 'Accreditations previews' ) ),
            Field::make( 'text', 'accreditations_posts_per_page', __( 'Posts per page' ) )
                ->set_width( 33 )
                ->set_attribute( 'type', 'number' )
                ->set_default_value( $def_per_page ),
            Field::make( 'text', 'accreditations_posts_link_text', __( 'Link text' ) )
                ->set_width( 33 )
                ->set_default_value( 'Всі Акредитації' ),
            Field::make( 'text', 'accreditations_posts_link', __( 'Link' ) )
                ->set_width( 33 ),
            Field::make( 'text', 'accreditations_posts_title', __( 'Section title' ) )
                ->set_default_value( 'Акредитації' ),
        ) )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            extract( $fields );
        
        include_once __THEME_DIR__ . '/template-parts/sections/accreditations_previews-section.php';
    } );

    // ==== Manager Contact Block
    Block::make('manager_contact_block', __('Contact Manager'))
    ->add_fields(array(
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
    ))
    ->set_inner_blocks(false)
    ->set_description(__('A block to display manager contact with form'))
    ->set_icon('businessman')
    ->set_category('mib')
    ->set_mode('both')
    ->set_render_callback(function($fields, $attributes, $inner_blocks) {
        extract($fields);
        
        include_once __THEME_DIR__ . '/template-parts/sections/manager_contact-section.php';
    });

    // ==== Students Block
    Block::make( 'students_block', __( 'Students' ) )
        ->add_fields( array(
            Field::make( 'separator', 'students_sep', __( 'Students' ) ),
            Field::make( 'text', 'students_section_title', __( 'Section title' ) )
                ->set_default_value( 'Випускники' ),
            Field::make( 'text', 'students_per_page', __( 'Students per page' ) )
                ->set_width( 50 )
                ->set_attribute( 'type', 'number' )
                ->set_default_value( $def_per_page ),
            Field::make( 'select', 'students_section_items_view_style', __( 'View style' ) )
                ->add_options( array(
                    'grid'     => __( 'Grid' ),
                    'slider' => __( 'Slider' ),
                ) )
                ->set_width( 50 ),
            Field::make( 'text', 'students_section_link_text', __( 'Section link text' ) )
                ->set_width( 50 )
                ->set_default_value( 'Всі випускники' ),
            Field::make( 'select', 'students_section_link_to', __( 'Page for link' ) )
                ->set_width( 50 )
                ->add_options( $pages_options ),
        ) )
        ->set_icon( 'groups' )
        ->set_category( 'mib' )
        ->set_mode( 'both' )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            extract( $fields );
        
            // Include the template for rendering
            include_once __THEME_DIR__ . '/template-parts/sections/students-section.php';
    } );

    // ==== Contacts Block
    Block::make( 'contacts_block', __( 'Contacts' ) )
        ->add_fields( array(
            Field::make( 'separator', 'contacts_sep', __( 'Contacts Block' ) ),

        ) )
        ->set_icon( 'phone' )
        ->set_category( 'mib' )
        ->set_mode( 'both' )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            
        include_once __THEME_DIR__ . '/template-parts/blocks/block-page-contacts.php';
    } );

    // ==== Company History Block
    Block::make('company_history', __('Company History'))
    ->add_fields(array(
        Field::make('separator', 'history_sep', __('Company History Block')),
        
        Field::make('text', 'history_title', __('Title'))
            ->set_width(100),
            
        Field::make('rich_text', 'history_description', __('Description'))
            ->set_width(100),
            
        Field::make('complex', 'history_items', __('History Timeline'))
            ->add_fields(array(
                Field::make('text', 'history_item_year', __('Year'))
                    ->set_width(15)
                    ->set_required(true),
                    
                Field::make('image', 'history_item_image', __('Image'))
                    ->set_width(25)
                    ->set_type(array('image')),
                    
                Field::make('rich_text', 'history_item_description', __('Description'))
                    ->set_width(60)
                    ->set_required(true),
            ))
            ->set_header_template('<%- history_item_year %>')
            ->set_layout('tabbed-vertical')
    ))
    ->set_icon('calendar')
    ->set_category('mib')
    ->set_mode('both')
    ->set_render_callback(function($fields, $attributes, $inner_blocks) {
        extract( $fields );

        include_once __THEME_DIR__ . '/template-parts/sections/company_history-section.php';
    });
}