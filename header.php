<?php
	$home_url = home_url();
	$is_home = is_front_page();
	$page_id = get_the_ID();
	$body_class = '';

	$current_lang = get_locale();

	if( function_exists( 'pll_current_language' ) ) {
		$current_lang = pll_current_language();
	}
?>

 <!doctype html>
 <html <?php language_attributes(); ?>>
 <head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
 </head>
 
 <body <?php body_class($body_class); ?>>
 <?php wp_body_open(); ?>

 <div id="page" class="site">
	 
	 <header class="site-header">

	 	<?php get_template_part('template-parts/blocks/block', 'search'); ?>

		 <div class="container">
 
			 <div class="row">

				 <div class="col col-1">
					<?php get_template_part( 'template-parts/blocks/block', 'logo' ); ?>
				 </div>

				 <div class="col col-2">

					<div class="menu-wrapper">
						<a href="#" class="close-menu">
							<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M1 1L13 13M1 13L13 1" stroke="currentColor" stroke-width="2"/>
							</svg>
						</a>

						<div class="triangle triangle-1">
							<?php get_template_part('template-parts/blocks/block', 'triangle'); ?>
						</div>
						<div class="triangle triangle-2">
							<?php get_template_part('template-parts/blocks/block', 'triangle'); ?>
						</div>
						
						<div class="container">
							<div class="menu-first menu-js">
								<?php
									wp_nav_menu( array(
										'menu' => 10,
										'depth' => 3,
										'lang' => $current_lang,
									) );
								?>
							</div>
							<div class="menu-second">
								<div class="label"><?php pll_e('About us', 'baza')?></div>
								<?php
									wp_nav_menu( array(
										'menu' => 12,
										'depth' => 1,
										'lang' => $current_lang,
									) );
								?>
							</div>
							<div class="menu-last">
								<?php get_template_part('template-parts/blocks/block', 'contacts'); ?>
								<?php get_template_part( 'template-parts/blocks/block', 'social-links', array('show_icons' => false) ); ?>
							</div>
						</div>
					</div>

					<div class="menu-primary menu-js">
						<?php
							wp_nav_menu( array(
								'menu' => 10,
								'depth' => 3,
								'lang' => $current_lang,
							) );
						?>
					</div>

					<?php custom_language_switcher(); ?>

					<a class="search-toggle">
						<svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M15.875 14.6562L12.0938 10.875C12 10.8125 11.9062 10.75 11.8125 10.75H11.4062C12.375 9.625 13 8.125 13 6.5C13 2.9375 10.0625 0 6.5 0C2.90625 0 0 2.9375 0 6.5C0 10.0938 2.90625 13 6.5 13C8.125 13 9.59375 12.4062 10.75 11.4375V11.8438C10.75 11.9375 10.7812 12.0312 10.8438 12.125L14.625 15.9062C14.7812 16.0625 15.0312 16.0625 15.1562 15.9062L15.875 15.1875C16.0312 15.0625 16.0312 14.8125 15.875 14.6562ZM6.5 11.5C3.71875 11.5 1.5 9.28125 1.5 6.5C1.5 3.75 3.71875 1.5 6.5 1.5C9.25 1.5 11.5 3.75 11.5 6.5C11.5 9.28125 9.25 11.5 6.5 11.5Z" fill="currentColor"/>
						</svg>
					</a>

					<a class="menu-toggle">
						<i class="icon-menu"></i>
					</a>
 
				 </div>
			 </div>
 
		 </div>
	 </header>
 