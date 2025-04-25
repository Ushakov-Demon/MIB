<?php

function create_custom_post_types_and_taxonomies() {
    $programs_labels = array(
        'name'                  => 'Програми навчання',
        'singular_name'         => 'Програма навчання',
        'menu_name'             => 'Програми навчання',
        'name_admin_bar'        => 'Програма навчання',
        'archives'              => 'Архіви програм',
        'attributes'            => 'Атрибути програми',
        'parent_item_colon'     => 'Батьківська програма:',
        'all_items'             => 'Всі програми',
        'add_new_item'          => 'Додати нову програму',
        'add_new'               => 'Додати нову',
        'new_item'              => 'Нова програма',
        'edit_item'             => 'Редагувати програму',
        'update_item'           => 'Оновити програму',
        'view_item'             => 'Переглянути програму',
        'view_items'            => 'Переглянути програми',
        'search_items'          => 'Пошук програм',
        'not_found'             => 'Не знайдено',
        'not_found_in_trash'    => 'Не знайдено в кошику',
        'featured_image'        => 'Головне зображення',
        'set_featured_image'    => 'Встановити головне зображення',
        'remove_featured_image' => 'Видалити головне зображення',
        'use_featured_image'    => 'Використати як головне зображення',
        'insert_into_item'      => 'Вставити в програму',
        'uploaded_to_this_item' => 'Завантажено до цієї програми',
        'items_list'            => 'Список програм',
        'items_list_navigation' => 'Навігація по списку програм',
        'filter_items_list'     => 'Фільтрувати список програм',
    );
    
    $programs_args = array(
        'label'               => 'Програма навчання',
        'description'         => 'Програми навчання',
        'labels'              => $programs_labels,
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        'taxonomies'          => array('program_category', 'post_tag'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 21,
        'menu_icon'           => 'dashicons-welcome-learn-more',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'show_in_rest'        => true,
    );
    
    $events_labels = array(
        'name'                  => __( 'Події' ),
        'singular_name'         => __( 'Подія' ),
        'menu_name'             => __( 'Події' ),
        'name_admin_bar'        => __( 'Подія' ),
        'archives'              => __( 'Архіви подій' ),
        'attributes'            => __( 'Атрибути подій' ),
        'parent_item_colon'     => __( 'Батьківська подія:' ),
        'all_items'             => __( 'Всі події' ),
        'add_new_item'          => __( 'Додати нову подію' ),
        'add_new'               => __( 'Додати нову' ),
        'new_item'              => __( 'Нова подія' ),
        'edit_item'             => __( 'Редагувати подію' ),
        'update_item'           => __( 'Оновити подію' ),
        'view_item'             => __( 'Переглянути подію' ),
        'view_items'            => __( 'Переглянути події' ),
        'search_items'          => __( 'Пошук подій' ),
        'not_found'             => __( 'Не знайдено' ),
        'not_found_in_trash'    => __( 'Не знайдено в кошику' ),
        'featured_image'        => __( 'Головне зображення' ),
        'set_featured_image'    => __( 'Встановити головне зображення' ),
        'remove_featured_image' => __( 'Видалити головне зображення' ),
        'use_featured_image'    => __( 'Використати як головне зображення' ),
        'insert_into_item'      => __( 'Вставити в подію' ),
        'uploaded_to_this_item' => __( 'Завантажено до цієї події' ),
        'items_list'            => __( 'Список подій' ),
        'items_list_navigation' => __( 'Навігація по списку подій' ),
        'filter_items_list'     => __( 'Фільтрувати список подій' ),
    );
    
    $events_args = array(
        'label'               => __( 'Події' ),
        'description'         => '',
        'labels'              => $events_labels,
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt'),
        'taxonomies'          => array('event_category', 'post_tag'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 21,
        'menu_icon'           => 'dashicons-calendar',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'show_in_rest'        => true,
    );
    
    register_post_type('programs', $programs_args);
    register_post_type('events', $events_args);
    
    $program_cat_labels = array(
        'name'              => 'Категорії програм',
        'singular_name'     => 'Категорія програми',
        'search_items'      => 'Шукати категорії програм',
        'all_items'         => 'Всі категорії програм',
        'parent_item'       => 'Батьківська категорія програми',
        'parent_item_colon' => 'Батьківська категорія програми:',
        'edit_item'         => 'Редагувати категорію програми',
        'update_item'       => 'Оновити категорію програми',
        'add_new_item'      => 'Додати нову категорію програми',
        'new_item_name'     => 'Назва нової категорії програми',
        'menu_name'         => 'Категорії програм',
    );

    register_taxonomy('program_category', 'programs', array(
        'hierarchical'      => true,
        'labels'            => $program_cat_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'program-category'),
        'show_in_rest'      => true,
    ));
    
    $event_cat_labels = array(
        'name'              => 'Категорії подій',
        'singular_name'     => 'Категорія події',
        'search_items'      => 'Шукати категорії подій',
        'all_items'         => 'Всі категорії подій',
        'parent_item'       => 'Батьківська категорія події',
        'parent_item_colon' => 'Батьківська категорія події:',
        'edit_item'         => 'Редагувати категорію події',
        'update_item'       => 'Оновити категорію події',
        'add_new_item'      => 'Додати нову категорію події',
        'new_item_name'     => 'Назва нової категорії події',
        'menu_name'         => 'Категорії подій',
    );

    register_taxonomy('event_category', 'events', array(
        'hierarchical'      => true,
        'labels'            => $event_cat_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'event-category'),
        'show_in_rest'      => true,
    ));
}

add_action('init', 'create_custom_post_types_and_taxonomies', 0);