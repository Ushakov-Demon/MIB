<?php
get_header();
?>

<main id="primary" class="site-main">

    <?php if (get_the_content()) : ?>
        <?php apply_filters( 'the_content', the_content() ); ?>
    <?php endif; ?>

    <section class="section section-program-form" id="form-request">
        <div class="container">
            <?php echo do_shortcode( '[contact-form-7 id="05a0afd"]' ); ?>
        </div>
    </section>

</main>

<?php
get_footer();