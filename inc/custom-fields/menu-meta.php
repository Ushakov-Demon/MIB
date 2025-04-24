<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'crb_add_menu_icon_field');
function crb_add_menu_icon_field() {
   Container::make('nav_menu_item', __('Дополнительные настройки'))
       ->add_fields(array(
           Field::make('file', 'menu_item_icon', __('Menu icon'))
               ->set_type(array('image/svg+xml', 'image/png', 'image/jpeg', 'image/gif'))
               ->set_width(100)
       ));

    
}

