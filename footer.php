<?php
	$copyright = get_translatable_theme_mod('copyright', '');

	$current_lang = get_locale();

	if( function_exists( 'pll_current_language' ) ) {
		$current_lang = pll_current_language();
	}
?>

	<footer class="footer">
		<div class="container">

			<div class="row">

				<div class="col col-1 footer-info-container">
					<?php get_template_part( 'template-parts/blocks/block', 'logo' ); ?>
				</div>

				<div class="col col-2 footer-menu-container">
					<div class="footer-menu">
						<div class="label"><?php pll_e('Section', 'baza')?></div>
						<?php
							wp_nav_menu(
								array(
									'menu' => '10',
									'depth' => 1,
									'lang' => $current_lang,
								)
							);
						?>
					</div>
					<div class="footer-menu">
						<div class="label"><?php pll_e('Study', 'baza')?></div>
						<?php
							wp_nav_menu(
								array(
									'menu' => '25',
									'depth' => 1,
									'lang' => $current_lang,
								)
							);
						?>
					</div>
					<div class="footer-menu">
						<div class="label"><?php pll_e('About business school', 'baza')?></div>
						<?php
							wp_nav_menu(
								array(
									'menu' => '12',
									'depth' => 1,
									'lang' => $current_lang,
								)
							);
						?>
					</div>
					<div class="footer-menu footer-menu-contacts">
						<?php get_template_part('template-parts/blocks/block', 'contacts'); ?>
					</div>
				</div>

			</div>
		</div>
		
		<div class="footer-after">
			<div class="container">
				<?php if ($copyright) : ?>
					<div class="footer-after-col footer-copyright">
						<?php echo do_shortcode(nl2br(esc_html($copyright))); ?>
					</div>
				<?php endif; ?>
				<div class="footer-after-col">
					<div class="footer-social">
						<?php get_template_part( 'template-parts/blocks/block', 'social-links', array('show_icons' => true) ); ?>
					</div>
					<?php custom_language_switcher(); ?>
				</div>
			</div>
		</div>
	</footer>
</div>

<?php wp_footer(); ?>

</body>
</html>
