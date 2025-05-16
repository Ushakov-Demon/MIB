<?php

$actuality_posts_per_page = 2;
$alternating_posts = apply_filters( 'mib_get_alternating_posts', $actuality_posts_per_page, 2 );

get_header();
?>

<main id="primary" class="site-main">

    <?php if (get_the_content()) : ?>
        <?php apply_filters( 'the_content', the_content() ); ?>
    <?php endif; ?>

</main>

<?php
get_footer();