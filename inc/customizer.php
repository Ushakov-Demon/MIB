<?php
/**
 * baza Theme Customizer
 *
 * @package baza
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function baza_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'baza_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'baza_customize_partial_blogdescription',
			)
		);
	}

	// Site Information
    $wp_customize->add_section('site_info', array(
        'title'    => __('Site Information'),
        'priority' => 30,
    ));

    // Badge logo
    $wp_customize->add_setting('badge_logo', array(
        'default' => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'badge_logo_control',
        array(
            'label'    => __('Badge Logo', 'theme_textdomain'),
            'section'  => 'site_info',
            'settings' => 'badge_logo',
        )
    ));

    // Coordinates
    $wp_customize->add_setting('coordinates', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('coordinates', array(
        'label'   => __('Coordinates'),
        'section' => 'site_info',
        'type'    => 'text',
    ));

    // Address
    $wp_customize->add_setting('address', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('address', array(
        'label'   => __('Address'),
        'section' => 'site_info',
        'type'    => 'text',
    ));

	// Phone 1
    $wp_customize->add_setting('phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('phone', array(
        'label'   => __('Phone 1'),
        'section' => 'site_info',
        'type'    => 'text',
    ));

    // Phone 2
    $wp_customize->add_setting('phone_2', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('phone_2', array(
        'label'   => __('Phone 2'),
        'section' => 'site_info',
        'type'    => 'text',
    ));

    // Phone 2
    $wp_customize->add_setting('phone_3', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('phone_3', array(
        'label'   => __('Phone 3'),
        'section' => 'site_info',
        'type'    => 'text',
    ));

    // NPQ
    $wp_customize->add_setting('phone_4', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('phone_4', array(
        'label'   => __('Phone NPQ'),
        'section' => 'site_info',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('phone_5', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('phone_5', array(
        'label'   => __('Phone NPQ 2'),
        'section' => 'site_info',
        'type'    => 'text',
    ));

    // Email 1
    $wp_customize->add_setting('email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('email', array(
        'label'   => __('Email'),
        'section' => 'site_info',
        'type'    => 'email',
    ));

    // Email 2
    $wp_customize->add_setting('email_2', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('email_2', array(
        'label'   => __('Email 2'),
        'section' => 'site_info',
        'type'    => 'email',
    ));

    // Facebook 
    $wp_customize->add_setting('facebook', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('facebook', array(
        'label'   => __('Facebook'),
        'section' => 'site_info',
        'type'    => 'url',
    ));

    // Telegram username
    $wp_customize->add_setting('telegram_username', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('telegram_username', array(
        'label'   => __('Telegram username @name'),
        'section' => 'site_info',
        'type'    => 'text',
    ));

    // Instagram
    $wp_customize->add_setting('instagram', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('instagram', array(
        'label'   => __('Instagram'),
        'section' => 'site_info',
        'type'    => 'url',
    ));

    // TikTok
    $wp_customize->add_setting('tiktok', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('tiktok', array(
        'label'   => __('TikTok'),
        'section' => 'site_info',
        'type'    => 'url',
    ));

    // LinkedIn
    $wp_customize->add_setting('linkedin', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('linkedin', array(
        'label'   => __('LinkedIn'),
        'section' => 'site_info',
        'type'    => 'url',
    ));


    // YouTube
    $wp_customize->add_setting('youtube', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('youtube', array(
        'label'   => __('YouTube'),
        'section' => 'site_info',
        'type'    => 'url',
    ));

	// Copyright
	$wp_customize->add_setting('copyright', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('copyright', array(
        'label'   => __('Copyright'),
        'section' => 'site_info',
        'type'    => 'textarea',
    ));

}
add_action( 'customize_register', 'baza_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function baza_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function baza_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function baza_customize_preview_js() {
	wp_enqueue_script( 'baza-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'baza_customize_preview_js' );
