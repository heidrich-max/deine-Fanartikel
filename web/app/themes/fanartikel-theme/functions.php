<?php
/**
 * Fanartikel Theme Functions
 *
 * @package Fanartikel
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Theme setup
 */
function fanartikel_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'fanartikel'),
        'footer'  => __('Footer Menu', 'fanartikel'),
    ));
}
add_action('after_setup_theme', 'fanartikel_setup');

/**
 * Enqueue scripts and styles
 */
function fanartikel_scripts() {
    // Main stylesheet
    wp_enqueue_style(
        'fanartikel-style',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        '1.0.0'
    );

    // Main JavaScript
    wp_enqueue_script(
        'fanartikel-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        '1.0.0',
        true
    );

    // Google Fonts
    wp_enqueue_style(
        'fanartikel-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'fanartikel_scripts');

/**
 * Register widget areas
 */
function fanartikel_widgets_init() {
    register_sidebar(array(
        'name'          => __('Footer Widget Area', 'fanartikel'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here to appear in your footer.', 'fanartikel'),
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'fanartikel_widgets_init');
