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
}
add_action('init', 'cleanmean_register_patterns');

// Add this after your cleanmean_setup function