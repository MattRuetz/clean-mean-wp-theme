<?php
if (!defined('ABSPATH'))
    exit;

// Theme Setup
function cleanmean_setup()
{
    // Add default posts and comments RSS feed links
    add_theme_support('automatic-feed-links');

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
    wp_enqueue_style('cleanmean-style', get_stylesheet_uri());
    wp_enqueue_script('cleanmean-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'cleanmean_scripts');
