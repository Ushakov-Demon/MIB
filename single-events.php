<?php
$post_id = get_the_ID();
// About talk block
$about_talk_title = carbon_get_post_meta( $post_id, 'about_talk_title' );
$about_talk_list  = carbon_get_post_meta( $post_id, 'about_talk_list' );

// Brief announcement
$announcement_title     = carbon_get_post_meta( $post_id, 'announcement_title' );
$announcement_content   = carbon_get_post_meta( $post_id, 'announcement_content' );
$special_guest_icon_id  = carbon_get_post_meta( $post_id, 'special_guest_icon' );
$special_guest_icon_src = wp_get_attachment_url( $special_guest_icon_id );
$special_guest_icon_alt = get_post_meta( $special_guest_icon_id, '_wp_attachment_image_alt', true );
$special_guest_text     = carbon_get_post_meta( $post_id, 'special_guest_text' );

// Invitation block
$invitation_block_title = carbon_get_post_meta( $post_id, 'invitation_block_title' );
$invitations            = carbon_get_post_meta( $post_id, 'invitations' );

// Plan
$plan_title = carbon_get_post_meta( $post_id, 'event_plan_title' );
$plan_list  = carbon_get_post_meta( $post_id, 'event_plan' );

get_header();

// About talk loop
if ( ! empty( $about_talk_list ) ) :
    foreach ( $about_talk_list as $item ) :
        $item_title = $item['about_talk_topic'];
    endforeach;
endif;

// Invitation loop
if ( ! empty( $invitations ) ) :
    foreach ( $invitations as $item ) :
        $invite_icon_id  = $item['invite_icon'];
        $invite_icon_src = wp_get_attachment_url( $invite_icon_id );
        $invite_icon_alt = get_post_meta( $invite_icon_id, '_wp_attachment_image_alt', true );
        $invite_text     = $item['invite_text'];
    endforeach;
endif;

// Plan loop
if ( ! empty( $plan_list ) ) :
    foreach ( $plan_list as $item ) :
        $time               = $item['plan_item_time_between'];
        $topic              = $item['plan_item_time_topic'];
        $have_presenter     = 'yes' == $item['plan_item_have_presenter'];
        $presenter_member   = 'member' == $item['plan_item_presenter_member'];
        $presenter          = $item['plan_item_presenter'];

        $item_title     = '';
        $item_icon_src  = '';
        $item_icon_alt  = '';
        $second_text    = ''; // Position
        
        if ( $have_presenter && $presenter_member ) {
            $presenter_id       = $presenter[0]['id'];
            $item_title         = get_the_title( $presenter_id );
            $icon_id            = get_post_thumbnail_id( $presenter_id );
            $titcher_positions  = carbon_get_post_meta( $presenter_id, 'positions_in_companies' );
            $student_position   = carbon_get_post_meta( $presenter_id, 'st_positions_in_companies' );
            $second_text        = ! empty( $titcher_positions ) ? $titcher_positions : $student_position;

        } elseif ( $have_presenter && ! $presenter_member ) {
            $item_title  = $item['presenter_name'];
            $icon_id     = $item['presenter_icon'];
            $second_text = $item['presenter_message'];
        }

        $item_icon_src  = wp_get_attachment_url( $icon_id );
        $icon_alt       = get_post_meta( $icon_id, '_wp_attachment_image_alt', true );
        $item_icon_alt  = ! empty( $icon_alt ) ? $icon_alt : $item_title;

        echo $time . '<br>';
        echo $item_title . '<br>';
        echo $second_text . '<br>';
        echo $topic . '<br>';
        echo $item_icon_src . '<br>';
        
    endforeach;
endif;

get_footer();