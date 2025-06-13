<?php
get_header();

$actuality_posts_per_page = 4;
$actuality_posts_title    = pll__('Current', 'baza');
$alternating_posts        = mib_get_alternating_posts( $actuality_posts_per_page, 2 );

?>

	<main id="primary" class="site-main">

		<?php display_breadcrumbs(); ?>

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

						<div class="block block-last-events">
							<div class="block-title">
								<?php pll_e('Latest events', 'baza')?>
							</div>

							<div class="items items-last-events">
								<?php
									if ( ! empty( $alternating_posts["posts"] ) ) :
										foreach ( $alternating_posts["posts"] as $item ) :

											$post_ID      = $item->ID;
											if ( get_the_ID() === $post_ID ) continue; 
											
											$post_type    = $item->post_type;
											$shedule_date = ( $post_type === 'events' ) ? get_post_meta( $post_ID, '_event_shedule_date', true ) : '';
											$title        = get_the_title( $post_ID );
											$permalink    = get_the_permalink( $post_ID );
									
											include get_template_directory() . '/template-parts/blocks/news-item-small.php';
										endforeach;
									else :
										echo __( 'Items not found', 'baza' );
									endif;									
								?>
							</div>
						</div>

					</div>
					<div class="content">
						<?php if (get_the_content()) : ?>
							<?php the_content(); ?>
						<?php endif; ?>

						<?php include get_template_directory() . '/template-parts/blocks/block-autor.php'; ?>

						<?php echo share_article_buttons(); ?>
					</div>
				</div>
			</div>
		</section>

		<?php include get_template_directory() . '/template-parts/sections/actuality_previews-section.php'; ?>
		
	</main>

<?php
get_footer();
