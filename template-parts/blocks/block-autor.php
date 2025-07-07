<?php
$author_id = get_the_author_meta('ID');

$first_name = get_the_author_meta('first_name');
$last_name = get_the_author_meta('last_name');

if (!empty($first_name) && !empty($last_name)) {
    $author_name = trim($first_name . ' ' . $last_name);
} elseif (!empty($first_name)) {
    $author_name = $first_name;
} elseif (!empty($last_name)) {
    $author_name = $last_name;
} else {
    $author_name = get_the_author_meta('display_name');
    if (empty($author_name)) {
        $author_name = get_the_author_meta('user_nicename');
    }
}

$author_position = get_the_author_meta('description');

$user_logo_id = get_user_meta($author_id, 'user_logo', true);
if ($user_logo_id) {
    $author_avatar = wp_get_attachment_image_url($user_logo_id, 'thumbnail');
} else {
    $author_avatar = get_avatar_url($author_id, array('size' => 200));
}

$author_url = get_the_author_meta('user_url');
$has_valid_url = !empty($author_url) && filter_var($author_url, FILTER_VALIDATE_URL);
?>

<div class="block block-author">
    <div class="block-title"><?php pll_e('Author', 'baza')?></div>

    <div class="author">
        <div class="image">
            <?php if ($has_valid_url) : ?>
                <a href="<?php echo esc_url($author_url); ?>" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>">
                </a>
            <?php else : ?>
                <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>">
            <?php endif; ?>
        </div>

        <div class="heading">
            <div class="title">
                <?php if ($has_valid_url) : ?>
                    <a href="<?php echo esc_url($author_url); ?>" target="_blank" rel="noopener noreferrer" class="author-link">
                        <span class="name"><?php echo esc_html($author_name); ?></span>
                    </a>
                <?php else : ?>
                    <span class="name"><?php echo esc_html($author_name); ?></span>
                <?php endif; ?>
                
                <?php if (!empty($author_position)) : ?>
                    <span class="position"><?php echo esc_html($author_position); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>