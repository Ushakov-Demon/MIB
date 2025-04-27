<?php
get_header();

$alternating_posts = apply_filters( 'mib_get_alternating_posts', 4, 2 );
?>

	<main id="primary" class="site-main">

		<div class="breadcrumb-container">
			<div class="container">
				<?php
					if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb( '<div id="breadcrumbs">','</div>' );
					}
				?>
			</div>
        </div>

		<section class="section section-single">
			<div class="container">
				<h1><?php the_title(); ?></h1>
				
				<?php if (has_post_thumbnail()) : ?>
					<div class="hero-featured-image">
						<?php 
						$thumbnail_id = get_post_thumbnail_id();
						$full_image_with_metadata = wp_get_attachment_image(
							$thumbnail_id,
							'full',
							false,
							array(
								'class' => 'featured-image',
								'title' => get_the_title()
							)
						);
						
						echo $full_image_with_metadata;
						?>
					</div>
				<?php endif; ?>
				
				<div class="content-wrapper">
					<div class="side">
						<div class="block">
							<div class="block-title">
								<?php pll_e('Latest events', 'baza')?>
							</div>
							<div class="items items-last-events">
							<?php
								if ( ! empty( $alternating_posts ) ):
									foreach ( $alternating_posts as $item ) :
										$post_ID        = $item->ID;
										$post_type      = $item->post_type;
										$shedule_date   = 'events' == $post_type ? get_post_meta( $item->ID, '_event_shedule_date', true ) : '';
										$thumbnail      = false;
										$title          = $item->post_title;
										$excerpt        = $item->post_excerpt;
										$permalink      = get_the_permalink( $item->ID );
							
									include get_template_directory() . '/template-parts/blocks/news-item.php';

									endforeach;
								else:
									echo __( 'Items not found' );
								endif;
								?>
							</div>
						</div>
					</div>
					<div class="content">
						<?php if (get_the_content()) : ?>
							<?php the_content(); ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
		
	</main>

<?php
get_footer();
