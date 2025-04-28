<?php

get_header();

$actuality_posts_per_page = 24;
$alternating_posts = apply_filters( 'mib_get_alternating_posts', $actuality_posts_per_page, 2 );
?>

<main id="primary" class="site-main">

	<?php
        if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb( '<div class="breadcrumb-container"><div class="container"><div id="breadcrumbs">','</div></div></div>' );
        }
    ?>

	<section class="section section-news">
		<div class="container">
			
			<div class="items-wrapper">
				<div class="items">
					<?php
					if ( ! empty( $alternating_posts ) ):
						foreach ( $alternating_posts as $item ) :
							$post_ID        = $item->ID;
							$post_type      = $item->post_type;
							$shedule_date   = 'events' == $post_type ? get_post_meta( $item->ID, '_event_shedule_date', true ) : '';
							$thumbnail      = get_the_post_thumbnail_url( $item->ID );
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

			<?php include get_template_directory() . '/template-parts/blocks/block-show-more.php'; ?>

		</div>
	</section>

</main>

<?php
get_footer();