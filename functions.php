<?php
if (!defined('ABSPATH'))
    exit;

// Theme Setup
function cleanmean_setup()
{
    // Add support for block templates
    add_theme_support('block-templates');
    add_theme_support('block-template-parts');

    // Add default posts and comments RSS feed links
    add_theme_support('automatic-feed-links');

    // Add support for core block patterns
    add_theme_support('core-block-patterns');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'cleanmean'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Add custom post type for Projects
    register_post_type('project', array(
        'labels' => array(
            'name' => __('Projects', 'cleanmean'),
            'singular_name' => __('Project', 'cleanmean')
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'projects'),
        'show_in_rest' => true,
    ));
}
add_action('after_setup_theme', 'cleanmean_setup');

// Enqueue scripts and styles
function cleanmean_scripts()
{
    // Enqueue main stylesheet (empty except for WP header)
    wp_enqueue_style('cleanmean-style', get_stylesheet_uri());

    // Enqueue your actual CSS files
    wp_enqueue_style('cleanmean-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
    wp_enqueue_style('cleanmean-header', get_template_directory_uri() . '/assets/css/header.css', array(), '1.0.0');
    wp_enqueue_style('cleanmean-footer', get_template_directory_uri() . '/assets/css/footer.css', array(), '1.0.0');
    wp_enqueue_style('cleanmean-projects', get_template_directory_uri() . '/assets/css/projects.css', array(), '1.0.0');
    wp_enqueue_style('cleanmean-responsive', get_template_directory_uri() . '/assets/css/responsive.css', array(), '1.0.0');

    // Your existing JS enqueue
    wp_enqueue_script('cleanmean-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'cleanmean_scripts');

// Register block patterns
function cleanmean_register_patterns()
{
    register_block_pattern_category('cleanmean', array(
        'label' => __('CleanMean', 'cleanmean')
    ));

    register_block_pattern(
        'cleanmean/simple-hero',
        array(
            'title'       => __('Simple Hero Section', 'cleanmean'),
            'description' => __('A full-width single-column hero section with heading, subheading, and call-to-action button', 'cleanmean'),
            'categories'  => array('cleanmean', 'featured', 'header'),
            'content'     => file_get_contents(get_template_directory() . '/patterns/simple-hero.html')
        )
    );

    register_block_pattern(
        'cleanmean/services-cards-3',
        array(
            'title'       => __('Services Cards 3', 'cleanmean'),
            'description' => __('A three-column services section', 'cleanmean'),
            'categories'  => array('cleanmean', 'services'),
            'content'     => file_get_contents(get_template_directory() . '/patterns/services-cards-3.html')
        )
    );

    register_block_pattern(
        'cleanmean/featured-projects',
        array(
            'title'       => __('Featured Projects', 'cleanmean'),
            'description' => __('A grid of featured projects', 'cleanmean'),
            'categories'  => array('cleanmean', 'featured'),
            'content'     => file_get_contents(get_template_directory() . '/patterns/featured-projects.html')
        )
    );

    register_block_pattern(
        'cleanmean/simple-cta',
        array(
            'title'       => __('Simple CTA', 'cleanmean'),
            'description' => __('A simple call-to-action section', 'cleanmean'),
            'categories'  => array('cleanmean', 'cta'),
            'content'     => file_get_contents(get_template_directory() . '/patterns/simple-cta.html')
        )
    );

    register_block_pattern(
        'cleanmean/simple-page-heading',
        array(
            'title'       => __('Simple Page Heading', 'cleanmean'),
            'description' => __('A simple page heading', 'cleanmean'),
            'categories'  => array('cleanmean', 'heading'),
            'content'     => file_get_contents(get_template_directory() . '/patterns/simple-page-heading.html')
        )
    );

    register_block_pattern(
        'cleanmean/simple-contact-area',
        array(
            'title'       => __('Simple Contact Area', 'cleanmean'),
            'description' => __('A simple contact area', 'cleanmean'),
            'categories'  => array('cleanmean', 'contact'),
            'content'     => file_get_contents(get_template_directory() . '/patterns/simple-contact-area.html')
        )
    );

    register_block_pattern(
        'cleanmean/before-after-gallery',
        array(
            'title'       => __('Before & After Gallery', 'cleanmean'),
            'description' => __('A gallery showing before and after transformations', 'cleanmean'),
            'categories'  => array('cleanmean', 'gallery'),
            'content'     => file_get_contents(get_template_directory() . '/patterns/before-after-gallery.html')
        )
    );

    register_block_pattern(
        'cleanmean/process-steps',
        array(
            'title'       => __('Process Steps', 'cleanmean'),
            'description' => __('A section showing step-by-step process', 'cleanmean'),
            'categories'  => array('cleanmean', 'features'),
            'content'     => file_get_contents(get_template_directory() . '/patterns/process-steps.html')
        )
    );
}
add_action('init', 'cleanmean_register_patterns');


// Expandable theme optimizations

// Here is where the theme checks which patterns are being used on the current
// page, and generates a dynamic css file for the page.

function get_current_template_content()
{
    // Get the currently assigned template
    $current_template = get_page_template_slug();

    if ($current_template) {
        error_log('CleanMean: Current template from WP: ' . $current_template);
        // Convert the template filename to our HTML version
        $template_path = str_replace('.php', '.html', $current_template);
        $full_path = get_template_directory() . '/templates/' . basename($template_path);

        if (file_exists($full_path)) {
            error_log('CleanMean: Loading template from: ' . $full_path);
            return file_get_contents($full_path);
        }
    }

    // Fallback to template hierarchy
    // if (is_front_page() && file_exists(get_template_directory() . '/templates/home-page.html')) {
    //     return file_get_contents(get_template_directory() . '/templates/home-page.html');
    // } elseif (is_single() && file_exists(get_template_directory() . '/templates/single.html')) {
    //     return file_get_contents(get_template_directory() . '/templates/single.html');
    // } elseif (is_page() && file_exists(get_template_directory() . '/templates/page.html')) {
    //     return file_get_contents(get_template_directory() . '/templates/page.html');
    // } elseif (file_exists(get_template_directory() . '/templates/index.html')) {
    //     return file_get_contents(get_template_directory() . '/templates/index.html');
    // }

    return '';
}

function cleanmean_enqueue_pattern_styles()
{
    static $already_run = false;
    if ($already_run) return;

    global $post;
    if (!$post) return;

    $template_content = get_current_template_content();
    $content = $post->post_content;
    $full_content = $template_content . $content;

    // Find both pattern references AND transformed patterns with metadata
    $patterns = array();

    // Look for direct pattern references
    preg_match_all('/"slug":"cleanmean\/([^"]+)"/', $full_content, $matches);
    if (!empty($matches[1])) {
        $patterns = array_merge($patterns, $matches[1]);
    }

    // Look for transformed patterns with metadata
    preg_match_all('/"patternName":"cleanmean\/([^"]+)"/', $full_content, $metadata_matches);
    if (!empty($metadata_matches[1])) {
        $patterns = array_merge($patterns, $metadata_matches[1]);
    }

    $patterns = array_unique($patterns); // Remove duplicates

    if (!empty($patterns)) {
        $combined_css = '';
        foreach ($patterns as $pattern) {
            $css_file = '/assets/css/patterns/' . $pattern . '.css';
            $full_css_path = get_template_directory() . $css_file;

            if (file_exists($full_css_path)) {
                $css_content = file_get_contents($full_css_path);
                $combined_css .= "/* Pattern: {$pattern} */\n";
                $combined_css .= $css_content . "\n\n";
                error_log('CleanMean: Added CSS for pattern: ' . $pattern);
            }
        }

        if (!empty($combined_css)) {
            // Generate a unique hash for this combination of patterns
            // $css_hash = md5(implode(',', $patterns));

            // Create cache directory if it doesn't exist
            // $cache_dir = get_template_directory() . '/assets/cache';
            // if (!file_exists($cache_dir)) {
            //     mkdir($cache_dir, 0755, true);
            // }

            // Cache file path
            // $cache_file = $cache_dir . '/patterns-' . $css_hash . '.css';
            // $cache_url = get_template_directory_uri() . '/assets/cache/patterns-' . $css_hash . '.css';

            // Only write the file if it doesn't exist
            // if (!file_exists($cache_file)) {
            //     file_put_contents($cache_file, $combined_css);
            //     error_log('CleanMean: Created new cached CSS file: ' . $cache_file);
            // }

            // Register a dummy stylesheet handle
            wp_register_style('cleanmean-patterns', false);
            wp_enqueue_style('cleanmean-patterns');

            // Add the actual CSS as inline styles
            wp_add_inline_style('cleanmean-patterns', $combined_css);
        }
    }

    $already_run = true;
}
add_action('wp_enqueue_scripts', 'cleanmean_enqueue_pattern_styles');

// Add a function to clean up old cache files (optional)
function cleanmean_cleanup_css_cache()
{
    $cache_dir = get_template_directory() . '/assets/cache';
    if (!is_dir($cache_dir)) return;

    $files = glob($cache_dir . '/patterns-*.css');
    $expired = time() - (7 * 24 * 60 * 60); // 7 days

    foreach ($files as $file) {
        if (filemtime($file) < $expired) {
            unlink($file);
            error_log('CleanMean: Removed expired CSS cache file: ' . $file);
        }
    }
}
add_action('wp_scheduled_delete', 'cleanmean_cleanup_css_cache');
