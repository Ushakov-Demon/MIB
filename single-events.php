<?php
$post_id = get_the_ID();
// About talk block

$title            = get_the_title();
$is_landing       = carbon_get_post_meta( $post_id, 'event_landing' );
$about_talk_title = carbon_get_post_meta( $post_id, 'about_talk_title' );
$about_talk_text  = carbon_get_post_meta( $post_id, 'about_talk_text' );
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

<section class="section section-main version-events<?php echo $is_landing ? ' version-black version-events-landing' : ''; ?>">

    <?php if ( has_post_thumbnail( $post_id ) && ! $is_landing ): ?>
        <div class="image">
            <?php echo get_the_post_thumbnail( $post_id, 'hero_event_image' ); ?>
        </div>
    <?php endif; ?>

    <?php if ( ! $is_landing ) : ?>
        <?php display_breadcrumbs(); ?>
    <?php endif; ?>

    <div class="container">
        <div class="content">

            <div class="content-header">

                <?php if ( $is_landing ) : ?>
                    <div class="content-header-logos">
                        <?php 
                            get_template_part( 'template-parts/blocks/block', 'logo' );
                            include_once get_template_directory() . '/template-parts/blocks/block-certificate-logo.php';
                        ?>
                    </div>
                <?php endif; ?>

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
                        <div class="item item-online">
                            <span class="online"><?php _e( 'Online' ); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="buttons">
                <a href="#form-request" class="button button-register" data-ps2id-offset="123">
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

            <?php if ( $about_talk_text ) : ?>
                <div class="section-text">
                    <?php echo $about_talk_text; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($about_talk_list)) : ?>
                <div class="<?php echo $is_landing ? 'items-landing items-column-3' : 'items'; ?>">
                    <?php 
                        foreach ( $about_talk_list as $item ) : 
                        $item_title = $item['about_talk_topic']; 
                        $item_text  = $item['about_talk_topic_text']; 
                        $item_icon  = $item['about_talk_topic_icon'];
                        if ( $item_icon ) {
                            $image_url = wp_get_attachment_image_url( $item_icon, 'full' );
                            $image_alt = get_post_meta( $item_icon, '_wp_attachment_image_alt', true );
                        }
                    ?>
                    <div class="item">
                        <?php if( $is_landing ) : ?>
                            
                            <?php if( $item_icon ) : ?>
                                <div class="image">
                                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
                                </div>
                            <?php endif; ?>

                            <h2 class="title"><span><?php echo $item_title; ?></span></h2>

                            <?php if( $item_text ) : ?>
                                <div class="excerpt">
                                    <?php echo $item_text; ?>
                                </div>
                            <?php endif; ?>

                            <?php else: ?>

                            <?php echo $item_title; ?>

                        <?php endif; ?>
                    </div>
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

        <?php if (!empty($special_guest_icon_src) && !empty($special_guest_text)) : ?>
            <div class="special-guest">
                <div class="image"><img src="<?php echo $special_guest_icon_src; ?>" alt="<?php echo $special_guest_icon_alt; ?>"></div>
                <div class="label"><?php echo $special_guest_text; ?></div>
            </div>
        <?php endif; ?>
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