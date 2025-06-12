<?php

$members_query = apply_filters('mib_get_posts', 'members', -1);

if ($members_query->have_posts()) : 
    ?>
    <section class="section section-members">
        <div class="container">
            <div class="items">
                <?php 
                while ( $members_query->have_posts() ) : 
                    $members_query->the_post(); 
                    $item_id   = get_the_ID();
                    $position  = get_post_meta( $item_id, '_position', true );
                    $linkedin  = get_post_meta( $item_id, '_linkedin', true );
                    $facebook  = get_post_meta( $item_id, '_facebook', true );
                    $show_link = get_post_meta( $item_id, '_member_show_link', true );
                    $name      = get_the_title();
                    $permalink = get_permalink();
                    $image_id  = get_post_thumbnail_id();
                    
                    $image_data   = wp_get_attachment_image_src( $image_id, 'large' );
                    $image_url    = $image_data[0] ?? '';
                    $image_width  = $image_data[1] ?? '';
                    $image_height = $image_data[2] ?? '';
                    
                    $image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

                    $tag_before = '';
                    $tag_after = '';
                    
                    if ( $show_link == 'yes' ) {
                        $tag_before = '<a href="' . esc_url($permalink) . '">';
                        $tag_after = '</a>';
                    } else {
                        $tag_before = '<span>';
                        $tag_after = '</span>';
                    }
                ?>
                    <div class="item">
                        <?php if ( $image_id ): ?>
                            <div class="image">
                                <?php echo $tag_before; ?>
                                    <img src="<?php echo esc_url($image_url); ?>" 
                                        alt="<?php echo esc_attr($image_alt); ?>"
                                        width="<?php echo esc_attr($image_width); ?>"
                                        height="<?php echo esc_attr($image_height); ?>">
                                <?php echo $tag_after; ?>
                            </div>
                        <?php endif; ?>

                        <div class="content">
                            <?php if (!empty($name)): ?>
                                <h3 class="name">
                                    <?php echo $tag_before; ?>
                                        <?php echo esc_html($name); ?>
                                    <?php echo $tag_after; ?>
                                </h3>
                            <?php endif; ?>

                            <?php if (!empty($position)): ?>
                                <div class="position"><?php echo esc_html($position); ?></div>
                            <?php endif; ?>

                            <?php if (!empty($linkedin) || !empty($facebook)): ?>
                                <div class="social-links">
                                    <?php if (!empty($linkedin)): ?>
                                        <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" class="social-link linkedin">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3.125 14V4.65625H0.21875V14H3.125ZM1.6875 3.375C2.125 3.375 2.53125 3.21875 2.875 2.875C3.1875 2.5625 3.375 2.15625 3.375 1.6875C3.375 1.25 3.1875 0.84375 2.875 0.5C2.53125 0.1875 2.125 0 1.6875 0C1.21875 0 0.8125 0.1875 0.5 0.5C0.15625 0.84375 0 1.25 0 1.6875C0 2.15625 0.15625 2.5625 0.5 2.875C0.8125 3.21875 1.21875 3.375 1.6875 3.375ZM14 14V8.875C14 7.4375 13.7812 6.375 13.375 5.6875C12.8125 4.84375 11.875 4.40625 10.5312 4.40625C9.84375 4.40625 9.28125 4.59375 8.78125 4.90625C8.3125 5.1875 7.96875 5.53125 7.78125 5.9375H7.75V4.65625H4.96875V14H7.84375V9.375C7.84375 8.65625 7.9375 8.09375 8.15625 7.71875C8.40625 7.21875 8.875 6.96875 9.5625 6.96875C10.2188 6.96875 10.6562 7.25 10.9062 7.8125C11.0312 8.15625 11.0938 8.6875 11.0938 9.4375V14H14Z" fill="currentColor"/>
                                            </svg>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (!empty($facebook)): ?>
                                        <a href="<?php echo esc_url($facebook); ?>" target="_blank" rel="noopener noreferrer" class="social-link facebook">
                                            <svg width="9" height="16" viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.78125 16H5.71875V8.84375H8L8.375 6H5.71875V4.03125C5.71875 3.59375 5.78125 3.25 5.96875 3.03125C6.15625 2.78125 6.5625 2.65625 7.125 2.65625H8.625V0.125C8.0625 0.0625 7.3125 0 6.4375 0C5.3125 0 4.4375 0.34375 3.78125 1C3.09375 1.65625 2.78125 2.5625 2.78125 3.75V6H0.375V8.84375H2.78125V16Z" fill="currentColor"/>
                                            </svg>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php 
wp_reset_postdata();
?>