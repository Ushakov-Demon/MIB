<?php
use Carbon_Fields\Block;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'custom_posts_gutenberg_blocks', 99 );

function custom_posts_gutenberg_blocks() {
    $post_id               = isset( $_GET['post'] ) ? intval( $_GET['post'] ) : false;
    $events_arhive_page    = get_option( '_events_arhive_page' );
    $programs_arhive_page  = get_option( '_programs_arhive_page' );
    $def_per_page          = get_option( 'posts_per_page' );
    $home_url              = home_url();
    $blog_page             = get_option( 'page_for_posts' );
    $blog_page_url         = ! is_null( $blog_page ) && ! empty( $blog_page ) ? get_the_permalink( $blog_page ) : $home_url;
    $current_lang          = function_exists('pll_current_language') ? pll_current_language() : '';
    $pages_options         = apply_filters( 'mib_get_posts_list_options', 'page' );
    $events_options        = apply_filters( 'mib_get_posts_list_options', 'events' );
    $posts_cats_options    = mib_get_posts_categories_options();
    $cf7_options           = apply_filters( 'mib_get_cf7_forms_options', [] );

    // ==== Main top Variative
    Block::make( 'main_top_variative',  __( 'Main HERO' ) )
        ->add_fields( array (
            Field::make( 'separator', 'main_top_variative_sep', __( 'Main HERO' ) ),
            Field::make( 'text', 'current_page_id' )
                ->set_default_value( $post_id )
                ->set_attribute( 'readOnly', true ),
            Field::make( 'file', 'main_top_heading_media_before_text', __( 'Hending media before all text' ) )
                ->set_width( 33 )
                ->set_type( 
                    array( 'image' )
                )
                ->set_conditional_logic( array(
                    array(
                        'field' => 'main_top_version',
                        'value' => array('home'),
                        'compare' => 'IN'
                    )
                ) ),
            Field::make( 'file', 'main_top_heading_media', __( 'Hending media' ) )
                ->set_width( 33 )
                ->set_type( 
                    array( 'image' )
                )
                ->set_conditional_logic( array(
                    array(
                        'field' => 'main_top_version',
                        'value' => array('home'),
                        'compare' => 'IN'
                    )
                ) ),
            Field::make( 'file', 'main_top_heading_bg', __( 'Background' ) )
                ->set_width( 33 )
                ->set_type( 
                    array( 'image' )
                )
                ->set_conditional_logic( array(
                    array(
                        'field' => 'main_top_version',
                        'value' => array('home'),
                        'compare' => 'IN'
                    )
                ) ),
            Field::make( 'textarea', 'main_top_heading_text', __( 'Title' ) ),
            Field::make( 'select', 'main_top_version', __('Select Version' ))
                ->add_options( array(
                    'white' => __( 'White', ),
                    'black' => __( 'Black', ),
                    'gray' => __( 'Gray', ),
                    'home' => __( 'Home' ),
                ) )
                ->set_default_value( 'white' ),
            Field::make( 'rich_text', 'main_bottom_text', __( 'Description text' ) ),
            Field::make( 'rich_text', 'main_bottom_second_text', __( 'Second text' ) )
                ->set_conditional_logic( array(
                    'relation' => 'OR',
                    array(
                        'field'   => 'current_page_id',
                        'value'   => $events_arhive_page,
                        'compare' => '!=',
                    ),
                    array(
                        'field'   => 'current_page_id',
                        'value'   => $programs_arhive_page,
                        'compare' => '!=',
                    ),
                ) ),
            Field::make( 'text', 'main_bottom_button_text', __( 'Button text' ) )
                ->set_conditional_logic( array(
                    'relation' => 'OR',
                    array(
                        'field'   => 'current_page_id',
                        'value'   => $events_arhive_page,
                        'compare' => '!=',
                    ),
                    array(
                        'field'   => 'current_page_id',
                        'value'   => $programs_arhive_page,
                        'compare' => '!=',
                    )
                ) )    
                ->set_width( 50 ),
            Field::make( 'select', 'main_bottom_button_link', __( 'Button link' ) )
            ->add_options( $pages_options )
            ->set_conditional_logic( array(
                'relation' => 'OR',
                array(
                    'field'   => 'current_page_id',
                    'value'   => $events_arhive_page,
                    'compare' => '!=',
                ),
                array(
                    'field'   => 'current_page_id',
                    'value'   => $programs_arhive_page,
                    'compare' => '!=',
                )
            ) )      
            ->set_width( 50 ),
            Field::make( 'complex', 'main_bottom_buttons', __( 'Buttons' ) )
                ->add_fields( array(
                    Field::make( 'text', 'button_text', __( 'Button text' ) )
                        ->set_width( 50 ),
                    Field::make( 'select', 'button_link', __( 'Button link' ) )
                        ->add_options( $pages_options )
                        ->set_width( 50 ),
                ) ),
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
        
        include_once __THEME_DIR__ . '/template-parts/sections/company_logos-section.php';
    } );

    // ==== Company Partners Block
    Block::make( 'partners_block', __( 'Our Partners' ) )
        ->add_fields( array(
            Field::make( 'separator', 'partners_sep', __( 'Our Partners' ) ),
            Field::make( 'text', 'partners_heading', __( 'Partners Heading' ) )
        ) )
        ->set_icon( 'groups' )
        ->set_category( 'mib' )
        ->set_mode( 'both' )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            extract( $fields );
        
        include_once __THEME_DIR__ . '/template-parts/sections/partners-section.php';
    } );

    // ==== Training programs
    Block::make( 'programs_previews', __( 'Training programs' ) )
        ->set_category( 'mib' )
        ->set_mode( 'both' )
        ->set_icon( 'welcome-learn-more' )
        ->add_fields( array(
            Field::make( 'separator', 'programs_previews_sep', __( 'Training programs' ) ),
            Field::make( 'text', 'programs_per_page', __( 'Posts per page' ) )
                ->set_width( 20 )
                ->set_attribute( 'type', 'number' )
                ->set_default_value( $def_per_page ),
            Field::make( 'association', 'programs_target_category', __( 'Programs Category' ) )
                ->set_width( 80 )
                ->set_types( array(
                    array(
                        'type'     => 'term',
                        'taxonomy' => 'program_category',
                    )
                ) ),
            Field::make( 'text', 'programs_section_link_text', __( 'Link text' ) )
                ->set_width( 50 )
                ->set_default_value( 'Всі програми' ),
            Field::make( 'select', 'programs_section_link', __( 'Link' ) )
                ->set_width( 50 )
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

    // ==== Mixed posts previews
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
                Field::make( 'select', 'actuality_post_type', __( 'Which posts to show?' ) )
                    ->set_width( 33 )
                    ->add_options( array(
                        'mixed' => __( 'Mixed' ),
                        'post'  => __( 'News' ),
                        'events' => __( 'Events' ),
                    ) )
                    ->set_default_value( 'mixed' ),
            Field::make( 'select', 'actuality_posts_section_pagination', __( 'Pagination' ) )
                ->set_width( 33 )
                ->add_options( array(
                    'off' => __( 'Off' ),
                    'on'  => __( 'On' ),
                ) ),    
            Field::make( 'select', 'actuality_posts_query_categories', __( 'Categories' ) )
                ->set_width( 50 )
                ->add_options( $posts_cats_options )
                ->set_conditional_logic( array(
                    array(
                        'field'   => 'actuality_post_type',
                        'value'   => 'post',
                        'compare' => '='
                    )
                ) ),
            Field::make( 'select', 'actuality_posts_query_categories_action', __( 'Action with selected categories' ) )
                ->set_width( 50 )
                ->add_options( array(
                    'include' => __( 'Include selected' ),
                    'exclude' => __( 'Exclude selected' ),
                ) )
                ->set_conditional_logic( array(
                    array(
                        'field'   => 'actuality_post_type',
                        'value'   => 'post',
                        'compare' => '='
                    )
                ) ),    
            Field::make( 'text', 'actuality_posts_link_text', __( 'Link text' ) )
                ->set_width( 50 )
                ->set_default_value( 'Всі записи' ),
            Field::make( 'select', 'actuality_posts_link', __( 'Link' ) )
                ->set_width( 30 )
                ->add_options( $pages_options ),
            Field::make( 'text', 'actuality_posts_title', __( 'Section title' ) )
                ->set_default_value( 'Актуальне' ),
            Field::make( 'textarea', 'actuality_posts_desc', __( 'Section Desription' ) )
        ) )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            extract( $fields );
        
        include_once __THEME_DIR__ . '/template-parts/sections/actuality_previews-section.php';
    } );

    // ==== Accreditations previews
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
            Field::make( 'select', 'accreditations_posts_link', __( 'Link' ) )
                ->set_width( 33 )
                ->add_options( $pages_options ),
            Field::make( 'text', 'accreditations_posts_title', __( 'Section title' ) )
                ->set_default_value( 'Акредитації' ),
        ) )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            extract( $fields );
        
        include_once __THEME_DIR__ . '/template-parts/sections/accreditations_previews-section.php';
    } );

    // ==== Program Page tabs
    Block::make( 'program_page_tabs', __( 'Program page tabs' ) )
        ->set_inner_blocks( false )
        ->set_category( 'mib' )
        ->set_mode( 'both' )
        ->set_icon( 'welcome-write-blog' )
        // About ****
        ->add_tab( __( 'About tab' ), array(
            Field::make( 'complex', 'about_tab_content' )
                ->add_fields( 'accriditation_block', array(
                    Field::make( 'checkbox', 'add_accriditation_block', __( 'Add Accreditation block' ) )
                        ->set_default_value( 'yes' )
                        ->help_text( __( 'Add Accreditation block installed in Training course data->Main->Accreditation.' ) ),
                ) )
                ->add_fields( 'editor_block', array(
                    Field::make( 'rich_text', 'free_content', __( 'Free content' ) ),
                    Field::make( 'rich_text', 'program_missions', __( 'Missions' ) ),
                ) )
                ->add_fields( 'advantages', array(
                    Field::make( 'image', 'advantages_block_image', __( 'Side image' ) )
                        ->set_width( 25 ),
                    Field::make( 'text', 'advantages_block_title', __( 'Block title' ) )
                        ->set_width( 75 ),
                    Field::make( 'complex', 'advantages_block_repeater', __( 'Advantages repeater' ) )
                        ->set_collapsed( true )
                        ->add_fields( array(
                            Field::make( 'text', 'advantage_title', __( 'Title' ) ),
                            Field::make( 'textarea', 'advantage_cont', __( 'Content' ) ),
                        ) )
                        ->set_header_template( '
                            <% if (advantage_title) { %>
                                <%- advantage_title %>
                            <% } %>
                        ' )
                        ->setup_labels( array(
                            'plural_name'   => 'Advantages',
                            'singular_name' => 'Advantage',
                        ) ),
                ) )
                ->add_fields( 'results_course', array(
                    Field::make( 'text', 'results_course_title', __( 'Title' ) )
                        ->set_width( 75 ),
                    Field::make( 'rich_text', 'results_course_desc', __( 'Description' ) )
                        ->set_width( 100 ),
                    Field::make( 'checkbox', 'results_course_show_accreditation', __( 'Add Accreditations List' ) )
                        ->set_default_value( 'no' ),
                    Field::make( 'checkbox', 'results_course_disable_accordion', __( 'Disable Accordion' ) )
                        ->set_default_value( 'no' ),
                        
                    Field::make( 'image', 'results_course_block_image', __( 'Bottom image block' ) )
                        ->set_width( 25 ),
                    Field::make( 'complex', 'results_diplomas', __( 'Diplomas' ) )
                        ->set_collapsed( true )
                        ->add_fields( array(
                            Field::make( 'select', 'diplom_url', __( 'Link' ) )
                                ->set_width( 25 )
                                ->add_options( $pages_options ),
                            Field::make( 'text', 'diplom_title', __( 'Title' ) )
                                ->set_width( 75 ),
                        ) )
                        ->set_header_template( '
                            <% if (diplom_title) { %>
                                <%- diplom_title %>
                            <% } %>
                        ' )
                        ->setup_labels( array(
                            'plural_name'   => 'Diplomas',
                            'singular_name' => 'Diploma',
                        ) ),
                    Field::make( 'complex', 'results_course_repeater', __( 'Results list' ) )
                        ->set_collapsed( true )
                        ->add_fields( array(
                            Field::make( 'textarea', 'result_content', __( 'Result' ) ),
                            Field::make( 'textarea', 'result_condition', __( 'Condition' ) )
                        ) )
                        ->set_header_template( '
                            <% if (result_content) { %>
                                <%- result_content %>
                            <% } %>
                        ' )
                        ->setup_labels( array(
                            'plural_name'   => 'Results',
                            'singular_name' => 'Result',
                        ) )
                ) )
                ->add_fields( 'results_course_multiple', array(
                    Field::make( 'text', 'results_course_m_title', __( 'Title block' ) ),
                    Field::make( 'text', 'results_course_m_subtitle', __( 'Small title block' ) ),
                    Field::make( 'complex', 'results_course_items', __( 'Items' ) )
                        ->add_fields( array(
                            Field::make( 'text', 'results_course_item_first_title', __( 'Item top title' ) ),
                            Field::make( 'rich_text', 'results_course_item_first_part', __( 'Item top content' ) ),
                            Field::make( 'text', 'results_course_item_second_title', __( 'Item bottom title' ) ),
                            Field::make( 'rich_text', 'results_course_item_second_part', __( 'Item bottom content' ) ),
                            Field::make( 'complex', 'results_course_m_short_infos', __( 'Short infos' ) )
                                ->set_collapsed( true )
                                ->add_fields( array(
                                    Field::make( 'image', 'rcm_fact_icon', __( 'Fact icon' ) )
                                        ->set_width( 20 ),
                                    Field::make( 'text', 'rcm_fact_name', __( 'Fact name' ) )
                                        ->set_width( 80 ),
                                    Field::make( 'textarea', 'rcm_fact_content', __( 'Comtent' ) ),
                                ) )
                                ->set_header_template( '
                                    <% if (rcm_fact_name) { %>
                                        <%- rcm_fact_name %>
                                    <% } %>
                                ' )
                                ->setup_labels( array(
                                    'plural_name'   => 'Facts',
                                    'singular_name' => 'Fact',
                                ) )
                        ) )
                        ->set_header_template( '
                            <% if (results_course_item_first_title) { %>
                                <%- results_course_item_first_title %>
                            <% } %>
                        ' )
                        ->setup_labels( array(
                            'plural_name'   => 'Items',
                            'singular_name' => 'Item',
                        ) ),
                ) )
                ->add_fields( 'program_content', array(
                    Field::make( 'text', 'program_content_title', __( 'Title' ) ),
                    Field::make( 'text', 'program_content_subtitle', __( 'Subtitle' ) ),
                    Field::make( 'complex', 'program_content_items', __( 'Modules' ) )
                        ->set_collapsed( true )
                        ->add_fields( array(
                            Field::make( 'text', 'assessment_type', __( 'Type of assessment' ) )
                                ->set_width( 50 ),
                            Field::make( 'text', 'assessment_time', __( 'Time of assessment' ) )
                                ->set_width( 50 ),
                            Field::make( 'rich_text', 'program_item_content', __( 'Content' ) )
                        ) )
                        ->setup_labels( array(
                            'plural_name'   => 'Modules',
                            'singular_name' => 'Module',
                        ) )
                ) )
                ->add_fields( 'documents_upon_completion', array(
                    Field::make( 'text', 'duc_title', __( 'Title' ) ),
                    Field::make( 'image', 'duc_image', __( 'Bottom banner' ) ),
                    Field::make( 'complex', 'duc_documents_list', __( 'Documents' ) )
                        ->set_collapsed( true )
                        ->add_fields( array(
                            Field::make( 'file', 'duc_item_file', __( 'Doc file' ) )
                                ->set_width( 20 ),
                            Field::make( 'text', 'duc_item_name', __( 'Name' ) )
                                ->set_width( 40 ),
                            Field::make( 'select', 'duc_item_url', __( 'Link' ) )
                                ->set_width( 40 )
                                ->add_options( $pages_options ),
                        ) )
                        ->set_header_template( '
                            <% if (duc_item_name) { %>
                                <%- duc_item_name %>
                            <% } %>
                        ' )
                        ->setup_labels( array(
                            'plural_name'   => 'Documents',
                            'singular_name' => 'Document',
                        ) )
                ) )
                ->add_fields( 'cost_of_education', array(
                    Field::make( 'text', 'cod_title', __( 'Title' ) ),
                    Field::make( 'rich_text', 'cod_description', __( 'Decription' ) ),
                    Field::make( 'rich_text', 'cod_included_in_coast', __( 'What is included in the payment' ) ),
                ) )
                ->add_fields( 'admission_conditions', array(
                    Field::make( 'text', 'conditions_block_title', __( 'Title' ) ),
                    Field::make( 'complex', 'conditions_list', __( 'Conditions' ) )
                        ->set_collapsed( true )
                        ->add_fields( array(
                            Field::make( 'text', 'conditions_items_title', __( 'Conditional title' ) ),
                            Field::make( 'rich_text', 'condition_element', __( 'Condition' ) ),
                        ) )
                        ->set_header_template( '
                            <% if (conditions_items_title) { %>
                                <%- conditions_items_title %>
                            <% } %>
                        ' )
                        ->setup_labels( array(
                            'plural_name'   => 'Conditions Lists',
                            'singular_name' => 'Condition List',
                        ) )
                ) )
                ->add_fields( 'companies', array(
                    Field::make( 'text', 'cousre_companies_title', __( 'Title block' ) ),
                    Field::make( 'association', 'cousre_companies_list', __( 'Companies list' ) )
                        ->set_types( array(
                            array(
                                'type'      => 'term',
                                'taxonomy'  => 'companies',
                            )
                        ) )
                ) )
                ->add_fields( 'course_content', array(
                    Field::make( 'text', 'course_content_title', __( 'Title' ) ),
                    Field::make( 'textarea', 'course_content_desc', __( 'Description' ) ),
                    Field::make( 'complex', 'course_content_items', __( 'Content items' ) )
                        ->set_collapsed( true )
                        ->add_fields( array(
                            Field::make( 'image', 'course_content_item_icon', __( 'Item icon' ) )
                                ->set_width( 25 ),
                            Field::make( 'text', 'course_content_item_title', __( 'Item title' ) )
                                ->set_width( 75 ),
                            Field::make( 'textarea', 'course_content_item_desc', __( 'Item content' ) ),
                        ) )
                        ->set_header_template( '<%- course_content_item_title %>' )
                        ->setup_labels( array(
                            'plural_name'   => 'Content items',
                            'singular_name' => 'Content item',
                        ) ),
                        Field::make( 'text', 'course_content_btn_label', __( 'Button text' ) )
                            ->set_width( 50 ),
                        Field::make( 'text', 'course_content_btn_lnk', __( 'Button link href' ) )
                            ->set_width( 50 )
                ) )
                ->add_fields( 'course_teachers', array(
                    Field::make( 'text', 'course_teachers_count', __( 'Per page' ) )
                        ->set_attribute( 'type', 'number' )
                        ->set_default_value( 2 )
                        ->set_width( 25 ),
                    Field::make( 'text', 'course_teachers_block_title', __( 'Block title' ) )
                        ->set_default_value( 'Teachers' )
                        ->set_width( 75 ),
                ) )
                ->add_fields( 'course_stutents', array(
                    Field::make( 'text', 'course_stutents_count', __( 'Per page' ) )
                        ->set_attribute( 'type', 'number' )
                        ->set_default_value( 2 )
                        ->set_width( 25 ),
                    Field::make( 'text', 'course_stutents_block_title', __( 'Block title' ) )
                        ->set_default_value( 'Graduates' )
                        ->set_width( 75 )
                ) )
                ->add_fields( 'course_listeners', array(
                    Field::make( 'text', 'listenrs_block_title', __( 'Title' ) )
                        ->set_default_value( 'Listeners' ),
                    Field::make( 'complex', 'lesteners_items_repeater', __( 'Items' ) )
                        ->set_collapsed( true )
                        ->add_fields( array(
                            Field::make( 'image', 'listeners_item_image', __( 'Image' ) )
                        ) )
                        ->setup_labels( array(
                            'plural_name'   => 'Items',
                            'singular_name' => 'Item',
                        ) ),
                    Field::make( 'rich_text', 'listenrs_block_content', __( 'Free content' ) )
                ) )
                ->setup_labels( array(
                    'plural_name'   => 'Sections',
                    'singular_name' => 'Section',
                ) )
        ) )

        // Titchers ****
        ->add_tab( __( 'Titchers tab' ), array(
            Field::make( 'checkbox', 'show_titchers', __( 'Show titchers' ) )
                ->help_text( __( 'The list of teachers set in the Training course data->Members->Teatchers section will be displayed.' ) )
                ->set_default_value( 'yes' )
                ->set_width( 25 ),
            Field::make( 'text', 'titchers_tab_title', __( 'Title' ) )
                ->set_default_value( 'Викладачі' )
                ->set_width( 75 ),
        ) )

        // Students ****
        ->add_tab( __( 'Students tab' ), array(
            Field::make( 'checkbox', 'show_students', __( 'Show students' ) )
                ->help_text( __( 'The list of teachers set in the Training course data->Members->Students section will be displayed.' ) )
                ->set_default_value( 'yes' )
                ->set_width( 25 ),
            Field::make( 'text', 'students_tab_title', __( 'Title' ) )
                ->set_default_value( 'Випускники' )
                ->set_width( 75 ),
        ) )

        // Program structure ****
        ->add_tab( __( 'Program structure' ), array(
            Field::make( 'select', 'use_program_content', __( 'Use Course Content' ) )
                ->add_options( array(
                    'yes' => __( 'Yes' ),
                    'no'  => __( 'No' ),
                ) )
                ->help_text( __( 'Use content from "About tab" (if filled in)' ) ),
            Field::make( 'text', 'program_structure_tab_title', __( 'Title' ) )
                ->set_default_value( 'Program structure' )
                ->set_conditional_logic( array(
                    array(
                        'field'     => 'use_program_content',
                        'value'     => 'no',
                        'compare'   => '=',
                    )
                ) ),
            Field::make( 'text', 'program_structure_tab_methods_title', __( 'Program Methods tab title' ) )
                ->set_default_value( 'Teaching methods:' ),    
            Field::make( 'complex', 'program_structure_tab_methods', __( 'Program methods' ) )
                ->set_collapsed( true )
                ->add_fields( array(
                    Field::make( 'text', 'program_method', __( 'Method' ) )
                ) )
                ->setup_labels( array(
                    'plural_name'   => 'Methods',
                    'singular_name' => 'Method',
                ) )
                ->set_header_template( '
                    <% if (program_method) { %>
                        <%- program_method %>
                    <% } %>
                ' ),
            Field::make( 'rich_text', 'program_structure_tab_content', __( 'Content' ) )
        ) )

        // Admission requirements ****
        ->add_tab( __( 'Admission requirements' ), array(
            Field::make( 'select', 'use_admission_conditions', __( 'Use Admission Conditions' ) )
                ->add_options( array(
                    'yes' => __( 'Yes' ),
                    'no'  => __( 'No' ),
                ) )
                ->help_text( __( 'Use content from "About tab" (if filled in)' ) ),
            Field::make( 'text', 'admission_requirements_tab_title', __( 'Title' ) )
                ->set_conditional_logic( array(
                    array(
                        'field'     => 'use_admission_conditions',
                        'value'     => 'no',
                        'compare'   => '=',
                    )
                ) ),
            Field::make( 'rich_text', 'admission_requirements_tab_content', __( 'Tab content' ) )
                ->set_conditional_logic( array(
                    array(
                        'field'     => 'use_admission_conditions',
                        'value'     => 'no',
                        'compare'   => '=',
                    )
                ) )
        ) )

        // Listeners ****
        ->add_tab( __( 'Listeners tab' ), array(
            Field::make( 'select', 'use_course_listeners', __( 'Use Course Listeners' ) )
                ->add_options( array(
                    'yes' => __( 'Yes' ),
                    'no'  => __( 'No' ),
                ) )
                ->help_text( __( 'Use content from "About tab" (if filled in)' ) ),
            Field::make( 'rich_text', 'listeners_tab_content', __( 'Tab content' ) )
                ->set_conditional_logic( array(
                    array(
                        'field'     => 'use_course_listeners',
                        'value'     => 'no',
                        'compare'   => '=',
                    )
                ) )
        ) )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            extract( $fields );
        
            include_once __THEME_DIR__ . '/template-parts/program/tabs/tabs-content.php';
    } );

    // ==== Manager Contact Block
    Block::make('manager_contact_block', __('Contact Manager'))
        ->add_fields(array(
            Field::make('separator', 'manager_contact_sep', __('Contact Manager')),
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

    // ==== Teachers Block
    Block::make( 'teachers_block', __( 'Teachers' ) )
        ->add_fields( array(
            Field::make( 'separator', 'teachers_sep', __( 'Teachers' ) ),
            Field::make( 'text', 'teachers_section_title', __( 'Section title' ) )
                ->set_default_value( 'Вчителі' ),
            Field::make( 'text', 'teachers_per_page', __( 'Teachers per page' ) )
                ->set_width( 50 )
                ->set_attribute( 'type', 'number' )
                ->set_default_value( $def_per_page ),
            Field::make( 'select', 'teachers_section_items_view_style', __( 'View style' ) )
                ->add_options( array(
                    'grid'   => __( 'Grid' ),
                    'slider' => __( 'Slider' ),
                ) )
                ->set_width( 50 ),
            Field::make( 'text', 'teachers_section_link_text', __( 'Section link text' ) )
                ->set_width( 50 )
                ->set_default_value( 'Всі вчителі' ),
            Field::make( 'select', 'teachers_section_link_to', __( 'Page for link' ) )
                ->set_width( 50 )
                ->add_options( $pages_options ),
        ) )
        ->set_icon( 'groups' )
        ->set_category( 'mib' )
        ->set_mode( 'both' )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            extract( $fields );
            
            // Include the template for rendering
            include_once __THEME_DIR__ . '/template-parts/sections/teachers-section.php';
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

    // ==== Actuality Event
    Block::make( 'actuality_event', __( 'Actuality Event' ) )
        ->add_fields( array(
            Field::make( 'separator', 'actuality_event_sep', __( 'Actuality Event' ) ),
            Field::make( 'select', 'actuality_event_link', __( 'Actuality Event' ) )
            ->set_width( 100 )
            ->add_options( $events_options ),
        ) )
        ->set_icon( 'media-document' )
        ->set_category( 'mib' )
        ->set_mode( 'both' )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            
        include_once __THEME_DIR__ . '/template-parts/sections/actuality_event-section.php';
    } );

    // ==== Program Form Registration Block
    Block::make('program_form_registration_block', __('Registration for the program'))
        ->add_fields(array(
            Field::make('separator', 'program_form_registration_sep', __('Registration for the program')),
            Field::make('text', 'program_form_registration_heading', __('Section Heading')),
            Field::make('select', 'contact_form_id', __('Contact Form 7'))
                ->add_options( $cf7_options )
                ->set_required(true)
                ->set_help_text(__('Select a Contact Form 7 form')),
        ))
        ->set_inner_blocks(false)
        ->set_icon('businessman')
        ->set_category('mib')
        ->set_mode('both')
        ->set_render_callback(function($fields, $attributes, $inner_blocks) {
            extract($fields);
            
            include_once __THEME_DIR__ . '/template-parts/sections/program_form-section.php';
    });

    // ==== Members Block
    Block::make('members_block', __('Members'))
        ->add_fields(array(
            Field::make('separator', 'members_sep', __('Members')),
        ))
        ->set_inner_blocks(false)
        ->set_icon('groups')
        ->set_category('mib')
        ->set_mode('both')
        ->set_render_callback(function($fields, $attributes, $inner_blocks) {

            include_once __THEME_DIR__ . '/template-parts/sections/members-section.php';
    });

    // ==== Clients Block
    Block::make('clients_block', __('Clients'))
        ->add_fields(array(
            Field::make('separator', 'clients_sep', __('Clients')),
        ))
        ->set_inner_blocks(false)
        ->set_icon('groups')
        ->set_category('mib')
        ->set_mode('both')
        ->set_render_callback(function($fields, $attributes, $inner_blocks) {

            include_once __THEME_DIR__ . '/template-parts/sections/clients-section.php';
    });

    // ==== Accreditations Block
    Block::make('accreditations_block', __('Accreditations'))
        ->add_fields(array(
            Field::make('separator', 'accreditations_sep', __('Accreditations')),
            Field::make('image', 'certificate_image', __('Certificate Image'))
                ->set_width(100)
                ->set_help_text(__('Upload PNG or JPG certificate')),
            Field::make('rich_text', 'accreditation_text', __('Accreditation Text'))
                ->set_width(100),
            Field::make('text', 'accreditation_info', __('Additional Info'))
                ->set_width(100),
            Field::make('text', 'accreditation_url', __('Accreditation URL'))
                ->set_width(100)
        ))
        ->set_inner_blocks(false)
        ->set_icon('awards')
        ->set_category('mib')
        ->set_mode('both')
        ->set_render_callback(function($fields, $attributes, $inner_blocks) {
            extract($fields);
            
            include_once __THEME_DIR__ . '/template-parts/sections/accreditations_single-section.php';
    });

    // ==== Banner 1120x125
    Block::make('banner_1120_125', __('Banner 1120x125'))
        ->add_fields(array(
            Field::make('separator', 'banner_1120x125_sep', __('Banner 1120x125')),
            Field::make('image', 'banner_image', __('Banner Image'))
                ->set_width(100)
                ->set_help_text(__('Upload PNG or JPG image for the banner')),
            Field::make('text', 'banner_title', __('Banner Title'))
                ->set_width(100),
            Field::make('textarea', 'banner_text', __('Banner Text'))
                ->set_width(100),
            Field::make('text', 'banner_url', __('Banner URL'))
                ->set_width(100)
        ))
        ->set_inner_blocks(false)
        ->set_icon('images-alt2')
        ->set_category('mib')
        ->set_mode('both')
        ->set_render_callback(function($fields, $attributes, $inner_blocks) {
            extract($fields);
        
        include_once __THEME_DIR__ . '/template-parts/banners/banner1120x125.php';
    });

    // ==== Repeater with Counter Block
    Block::make('repeater_counter', __('Repeater with counter'))
        ->add_fields(array(
            Field::make('separator', 'repeater_counter_sep', __('Repeater with counter')),

            Field::make('complex', 'repeater_counter_items', __('Items'))
                ->add_fields(array(
                    Field::make('text', 'repeater_counter_item', __('Item'))
                        ->set_width(100)
                        ->set_required(true),
                ))
        ))
        ->set_icon('grid-view')
        ->set_category('mib')
        ->set_mode('both')
        ->set_render_callback(function($fields, $attributes, $inner_blocks) {
            extract( $fields );

            include_once __THEME_DIR__ . '/template-parts/blocks/block-repeater-counter.php';
    });

    // ==== Exam Contact Information Block
    Block::make('exam_contact_info', __('Exam Contact Information'))
        ->add_fields(array(
            Field::make('separator', 'exam_contact_sep', __('Exam Contact Information')),

            Field::make('text', 'exam_contact_title', __('Title'))
                ->set_width(100),
            
            Field::make('text', 'exam_contact_address', __('Address'))
                ->set_width(50),
                
            Field::make('text', 'exam_contact_phone', __('Phone Number'))
                ->set_width(50),

            Field::make('text', 'exam_contact_address_label', __('Address Title'))
                ->set_width(50),
                
            Field::make('text', 'exam_contact_phone_label', __('Phone Number Title'))
                ->set_width(50),
        ))
        ->set_icon('phone')
        ->set_category('mib')
        ->set_mode('both')
        ->set_render_callback(function($fields, $attributes, $inner_blocks) {
            extract($fields);
            
            include_once __THEME_DIR__ . '/template-parts/blocks/block-exam-contact-info.php';
    });

    // ==== Schedule Block
    Block::make('schedule_block', __('Schedule'))
        ->add_fields(array(
            Field::make('separator', 'schedule_sep', __('Schedule Information')),

            Field::make('text', 'schedule_title', __('Title'))
                ->set_width(100),
            
            Field::make('textarea', 'schedule_description', __('Description'))
                ->set_width(100),
                
            Field::make('file', 'schedule_file', __('Schedule File'))
                ->set_type(array('application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'))
                ->set_width(100)
                ->set_help_text(__('Upload PDF or Word document with schedule details')),
        ))
        ->set_icon('calendar')
        ->set_category('mib')
        ->set_mode('both')
        ->set_render_callback(function($fields, $attributes, $inner_blocks) {
            extract($fields);
            
            include_once __THEME_DIR__ . '/template-parts/blocks/block-schedule.php';
    });

}