<?php
// Helper function to get field value with fallback
function get_project_field($field_name, $post_id = null)
{
    if (function_exists('get_field')) {
        return get_field($field_name, $post_id);
    }

    // Fallback to get_post_meta
    $value = get_post_meta(get_the_ID(), $field_name, true);

    // Handle image fields
    if (in_array($field_name, ['before_image', 'after_image']) && is_numeric($value)) {
        return wp_get_attachment_image_src($value, 'full');
    }

    return $value;
}

// Get field values
$before_image = get_project_field('before_image');
$after_image = get_project_field('after_image');
$services = get_project_field('services_provided');
$date_complete = get_project_field('date_complete');

// Handle different image return formats
$before_url = is_array($before_image) ? ($before_image['url'] ?? $before_image[0]) : '';
$after_url = is_array($after_image) ? ($after_image['url'] ?? $after_image[0]) : '';
$before_alt = is_array($before_image) ? ($before_image['alt'] ?? '') : '';
$after_alt = is_array($after_image) ? ($after_image['alt'] ?? '') : '';
?>

<div class="km-project-card">
    <div class="km-project-images">
        <div class="km-before-after">
            <figure class="before-image">
                <?php if ($before_url): ?>
                    <img
                        src="<?php echo esc_url($before_url); ?>"
                        alt="<?php echo esc_attr($before_alt); ?>" />
                    <span class="image-label">Before</span>
                <?php else: ?>
                    <div style="background: #eee; padding: 20px;">No Before Image</div>
                <?php endif; ?>
            </figure>
            <figure class="after-image">
                <?php if ($after_url): ?>
                    <img
                        src="<?php echo esc_url($after_url); ?>"
                        alt="<?php echo esc_attr($after_alt); ?>" />
                    <span class="image-label">After</span>
                <?php else: ?>
                    <div style="background: #eee; padding: 20px;">No After Image</div>
                <?php endif; ?>
            </figure>
        </div>
    </div>
    <div class="km-project-info">
        <h3 class="km-project-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <div class="km-project-meta">
            <?php if (!empty($services)): ?>
                <div class="km-services-provided">
                    <ul>
                        <?php
                        $service_items = is_array($services) ? $services : explode("\n", $services);
                        foreach ($service_items as $service):
                        ?>
                            <li><?php echo esc_html($service); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if ($date_complete): ?>
                <div class="km-project-date">
                    <?php echo esc_html(date('F Y', strtotime($date_complete))); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>