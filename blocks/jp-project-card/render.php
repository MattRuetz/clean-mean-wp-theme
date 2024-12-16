<?php

/**
 * Jake Portfolio Project Card Block Template.
 */

// Get the post object if not provided
$post = get_post();
if (!$post) return;

// Get the featured image
$featured_image = get_the_post_thumbnail($post->ID, 'large');
$permalink = get_permalink($post->ID);
$title = get_the_title($post->ID);
$excerpt = wp_trim_words(get_the_content(), 20); // Get first 20 words of content
?>

<div class="jp-project-card">
    <?php if ($featured_image) : ?>
        <div class="jp-project-card__image">
            <a href="<?php echo esc_url($permalink); ?>">
                <?php echo $featured_image; ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="jp-project-card__content">
        <h3 class="jp-project-card__title">
            <a href="<?php echo esc_url($permalink); ?>">
                <?php echo esc_html($title); ?>
            </a>
        </h3>

        <div class="jp-project-card__excerpt">
            <?php echo esc_html($excerpt); ?>
        </div>

        <div class="jp-project-card__footer">
            <a href="<?php echo esc_url($permalink); ?>" class="jp-project-card__link">
                View Project
            </a>
        </div>
    </div>
</div>