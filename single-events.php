<?php
$post_id = get_the_ID();
// About talk block

$title            = get_the_title();
$about_talk_title = carbon_get_post_meta( $post_id, 'about_talk_title' );
$about_talk_list  = carbon_get_post_meta( $post_id, 'about_talk_list' );
$is_online        = get_post_meta( $post_id, '_event_format', true );
$excerpt          = get_the_excerpt();
$shedule_date     = get_post_meta( $post_id, '_event_shedule_date', true );
$timestamp        = strtotime( $shedule_date );
$date_format      = get_option( 'date_format' );
$time_format      = get_option( 'time_format' );
$shedule_date_formatted = wp_date( $date_format, $timestamp );
$shedule_time     = wp_date( $time_format, $timestamp );

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

?>

<section class="section section-main version-events">

    <?php if ( has_post_thumbnail( $post_id ) ): ?>
        <div class="image">
            <?php echo get_the_post_thumbnail( $post_id, 'hero_event_image' ); ?>
        </div>
    <?php endif; ?>
    
    <?php display_breadcrumbs(); ?>

    <div class="container">
        <div class="content">
            <div class="content-header">
                <?php if (!empty($title)) : ?>
                    <h1 class="section-title">
                        <?php 
                            $processed_heading = preg_replace('/\*(.*?)\*/', '<span>$1</span>', $title);
                            echo $processed_heading;
                        ?>
                    </h1>
                <?php endif; ?>

                <?php
                    if(!empty($excerpt)) :
                        $processed_text = preg_replace('/\*(.*?)\*/', '<span>$1</span>', $excerpt);
                        ?>
                        <div class="text text-before">
                            <?php echo $processed_text; ?>
                        </div>
                        <?php
                    endif;
                ?>

                <?php include_once get_template_directory() . '/template-parts/blocks/block-certificate-logo.php'; ?>

                <div class="info">
                    <?php if (!empty($shedule_date_formatted)) : ?>
                        <div class="item item-date">
                            <span><?php echo $shedule_date_formatted; ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($shedule_time)) : ?>
                        <div class="item item-time">
                            <span><?php echo $shedule_time; ?></span>
                        </div>
                    <?php endif; ?>
                        
                    <?php if($is_online == 'online'): ?>
                        <div class="item item-zoom">
                            <span class="zoom">
                                <svg width="72" height="16" viewBox="0 0 72 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.9507 15.7238H2.27416C1.44393 15.7238 0.633876 15.2857 0.24909 14.5492C-0.196211 13.6933 -0.0344223 12.678 0.654047 12.0211L9.48326 3.34195H3.14486C1.40331 3.34195 0.00605954 1.94845 0.00605954 0.256279H11.6904C12.5207 0.256279 13.3306 0.694296 13.7154 1.43084C14.1609 2.28677 13.9989 3.30202 13.3104 3.95884L4.48132 12.6382H11.7917C13.5331 12.6382 14.9507 14.0317 14.9507 15.7238ZM65.1302 0.0374756C63.3079 0.0374756 61.6878 0.813817 60.5537 2.04801C59.4198 0.813817 57.7997 0.0374756 55.9773 0.0374756C52.6158 0.0374756 49.8618 2.86414 49.8618 6.16862V15.7238C51.6032 15.7238 53.0004 14.3303 53.0004 12.6382V6.14879C53.0004 4.55618 54.2559 3.2026 55.8759 3.14298C57.577 3.08322 58.9742 4.41683 58.9742 6.06906V12.6382C58.9742 14.3502 60.3918 15.7238 62.113 15.7238V6.12883C62.113 4.53635 63.3685 3.18264 64.9885 3.12301C66.6896 3.06325 68.0868 4.397 68.0868 6.04924V12.6183C68.0868 14.3304 69.5044 15.7038 71.2256 15.7038V6.14893C71.2458 2.86414 68.4918 0.0374756 65.1302 0.0374756ZM30.8267 8.00001C30.8267 12.3993 27.2019 15.9625 22.7267 15.9625C18.2514 15.9625 14.6267 12.3993 14.6267 8.00001C14.6267 3.60069 18.2514 0.0374756 22.7267 0.0374756C27.2019 0.0374756 30.8267 3.60069 30.8267 8.00001ZM27.6879 8.00001C27.6879 5.31269 25.4604 3.12301 22.7267 3.12301C19.993 3.12301 17.7654 5.31269 17.7654 8.00001C17.7654 10.6875 19.993 12.8771 22.7267 12.8771C25.4604 12.8771 27.6879 10.6875 27.6879 8.00001ZM48.2821 8.00001C48.2821 12.3993 44.6574 15.9625 40.1821 15.9625C35.7069 15.9625 32.0822 12.3993 32.0822 8.00001C32.0822 3.60069 35.7069 0.0374756 40.1821 0.0374756C44.6574 0.0374756 48.2821 3.60069 48.2821 8.00001ZM45.1436 8.00001C45.1436 5.31269 42.9161 3.12301 40.1823 3.12301C37.4487 3.12301 35.2211 5.31269 35.2211 8.00001C35.2211 10.6875 37.4486 12.8771 40.1823 12.8771C42.9161 12.8771 45.1436 10.6875 45.1436 8.00001Z" fill="white"/>
                                </svg>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="buttons">
                <a href="#form-request" class="button button-register">
                    <span><?php _e('Register');?></span>
                </a>
            </div>
        </div>
    </div>
</section>

<?php if ( ! empty( $about_talk_list ) ) : ?>
    <section class="section section-about-talk">
        <div class="container">

            <?php if (!empty($about_talk_title)) : ?>
                <div class="section-title">
                    <?php 
                        $processed_heading = preg_replace( '/\*(.*?)\*/', '<span>$1</span>', $about_talk_title );
                        echo $processed_heading;
                    ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($about_talk_list)) : ?>
                <div class="items">
                    <?php 
                        foreach ( $about_talk_list as $item ) : 
                        $item_title = $item['about_talk_topic']; 
                    ?>
                    <div class="item"><?php echo $item_title; ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<section class="section section-brief">
    <div class="container">
        <?php if (!empty($announcement_title)) : ?>
            <div class="section-title">
                <?php echo nl2br($announcement_title); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($announcement_content)) : ?>
            <div class="text">
                <?php echo $announcement_content; ?>
            </div>
        <?php endif; ?>

        <div class="special-guest">
            <?php if (!empty($special_guest_icon_src)) : ?>
                <div class="image"><img src="<?php echo $special_guest_icon_src; ?>" alt="<?php echo $special_guest_icon_alt; ?>"></div>
            <?php endif; ?>
            <?php if (!empty($special_guest_text)) : ?>
                <div class="label"><?php echo $special_guest_text; ?></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if ( ! empty( $invitations ) ) : ?>
    <section class="section section-invite">
        <div class="container">
            <div class="section-title">
                <?php echo pll__('Invite', 'baza'); ?>
            </div>

            <div class="items">
                <?php foreach ( $invitations as $item ) :
                        $invite_icon_id  = $item['invite_icon'];
                        $invite_icon_src = wp_get_attachment_url( $invite_icon_id );
                        $invite_icon_alt = get_post_meta( $invite_icon_id, '_wp_attachment_image_alt', true );
                        $invite_text     = $item['invite_text']; ?>

                <div class="item">
                    <?php if (!empty($invite_icon_src)) : ?>
                        <div class="image"><img src="<?php echo $invite_icon_src; ?>" alt="<?php echo $invite_icon_alt; ?>"></div>
                    <?php endif; ?>
                    <?php if (!empty($invite_text)) : ?>
                        <div class="label"><?php echo $invite_text; ?></div>
                    <?php endif; ?>
                </div>

                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if ( ! empty( $plan_list ) ) : ?>
    <section class="section section-event-plan">
        <div class="container">
            <div class="section-title">
                <?php echo pll__('Event plan', 'baza'); ?>
            </div>

            <div class="items">
                <?php foreach ( $plan_list as $item ) :
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
                    $item_icon_alt  = ! empty( $icon_alt ) ? $icon_alt : $item_title; ?>

                    <div class="item">
                        <?php if (!empty($time)) : ?>
                            <div class="time">
                                <?php echo $time; ?>
                            </div>
                        <?php endif; ?>
                        <div class="item-content">
                            <?php if (!empty($item_icon_src)) : ?>
                                <div class="image"><img src="<?php echo $item_icon_src; ?>" alt="<?php echo $item_icon_alt; ?>"></div>
                            <?php endif; ?>
                            <?php if (!empty($item_title)) : ?>
                                <div class="heading">
                                    <div class="title">
                                        <div class="name"><?php echo $item_title; ?></div>
                                        <div class="position"><?php echo $second_text; ?></div>
                                        <div class="topic"><?php echo $topic; ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="section section-event-form" id="form-request">
    <div class="container">
        <?php echo do_shortcode( '[contact-form-7 id="05a0afd"]' ); ?>
    </div>
</section>

<?php

get_footer();