<?php
    $main_top_heading_text = !empty($main_top_heading_text) ? $main_top_heading_text : get_the_title();
    $main_top_heading_media;
    $main_top_heading_bg;
    $main_top_heading_media_before_text;
?>
<section class="section section-main">

    <div class="container">
        
        <div class="content">

            <div class="content-header">
                <?php if (!empty($main_top_heading_media_before_text)) : ?>
                    <div class="image-before">
                        <?php
                            $before_img_atts = wp_get_attachment_image_src($main_top_heading_media_before_text, 'full');
                            $before_img_alt = get_post_meta($main_top_heading_media_before_text, '_wp_attachment_image_alt', true);
                        ?>
                        <img 
                            src="<?php echo esc_url($before_img_atts[0]); ?>" 
                            width="<?php echo esc_attr($before_img_atts[1]); ?>" 
                            height="<?php echo esc_attr($before_img_atts[2]); ?>" 
                            alt="<?php echo esc_attr($before_img_alt); ?>" 
                            class="before-image"
                        >
                    </div>
                <?php endif; ?>

                <?php if (!empty($main_top_heading_text)) : ?>
                    <h1 class="section-title">
                        <?php 
                        $processed_heading = preg_replace('/\*(.*?)\*/', '<span>$1</span>', $main_top_heading_text);
                        echo $processed_heading;
                        ?>
                    </h1>
                <?php endif; ?>

                <?php
                    if(!empty($main_bottom_text)) :
                        $processed_bottom_text = preg_replace('/\*(.*?)\*/', '<span>$1</span>', $main_bottom_text);
                        ?>
                        <div class="text text-before">
                            <?php echo $processed_bottom_text; ?>
                        </div>
                        <?php
                    endif;
                ?>
            </div>

            <?php if(!empty($main_bottom_button_text)) :
                $processed_button_text = preg_replace('/\*(.*?)\*/', '<span>$1</span>', $main_bottom_button_text);
                ?>
                <a href="<?php echo esc_url($main_bottom_button_link); ?>" class="button">
                    <span><?php echo $processed_button_text; ?></span>
                </a>
                <?php
            endif;

            if(!empty($main_bottom_second_text)) :
                $processed_second_text = preg_replace('/\*(.*?)\*/', '<span>$1</span>', $main_bottom_second_text);
                ?>
                <div class="text text-after">
                    <?php echo $processed_second_text; ?>
                </div>
                <?php
            endif;
            ?>
        </div>

        <?php if (!empty($main_top_heading_media)) : ?>
        <div class="image">

            <?php if (!empty($main_top_heading_bg)) : ?>
                <div class="section-background">
                    <?php
                        $bg_img_atts = wp_get_attachment_image_src($main_top_heading_bg, 'full');
                        $bg_img_alt = get_post_meta($main_top_heading_bg, '_wp_attachment_image_alt', true);
                    ?>
                    <img 
                        src="<?php echo esc_url($bg_img_atts[0]); ?>" 
                        width="<?php echo esc_attr($bg_img_atts[1]); ?>" 
                        height="<?php echo esc_attr($bg_img_atts[2]); ?>" 
                        alt="<?php echo esc_attr($bg_img_alt); ?>" 
                        class="background-image"
                    >
                </div>
            <?php endif; ?>

            <?php
                $main_img_atts = wp_get_attachment_image_src($main_top_heading_media, 'full');
                $main_img_alt = get_post_meta($main_top_heading_media, '_wp_attachment_image_alt', true);
            ?>
            <img 
                src="<?php echo esc_url($main_img_atts[0]); ?>" 
                width="<?php echo esc_attr($main_img_atts[1]); ?>" 
                height="<?php echo esc_attr($main_img_atts[2]); ?>" 
                alt="<?php echo esc_attr($main_img_alt); ?>" 
                class="main-image"
            >
        </div>
        <?php endif; ?>
    </div>
</section>