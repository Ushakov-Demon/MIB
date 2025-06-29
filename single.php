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
