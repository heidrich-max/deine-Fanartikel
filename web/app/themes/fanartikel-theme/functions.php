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
function fanartikel_setup()
{
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ]);
    add_theme_support('custom-logo', [
        'height' => 100,
        'width' => 400,
        'flex-height' => true,
        'flex-width' => true,
    ]);

    // Register navigation menus
    register_nav_menus([
        'primary' => __('Primary Menu', 'fanartikel'),
        'footer' => __('Footer Menu', 'fanartikel'),
    ]);

    // WooCommerce Support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'fanartikel_setup');

/**
 * WooCommerce Layout Wrappers
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', function () {
    echo '<main class="site-main woo-main"><div class="container">';
}, 10);

add_action('woocommerce_after_main_content', function () {
    echo '</div></main>';
}, 10);

/**
 * Enqueue scripts and styles
 */
function fanartikel_scripts()
{
    // Main stylesheet
    wp_enqueue_style(
        'fanartikel-style',
        get_template_directory_uri() . '/assets/css/main.css',
        [],
        '1.0.0',
    );

    // Main JavaScript
    wp_enqueue_script(
        'fanartikel-script',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        '1.0.0',
        true,
    );

    // Fabric.js CDN
    wp_enqueue_script(
        'fabric-js',
        'https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js',
        [],
        '5.3.1',
        true,
    );

    // Configurator JavaScript
    wp_enqueue_script(
        'fanartikel-configurator',
        get_template_directory_uri() . '/assets/js/configurator.js',
        ['fabric-js'],
        '1.0.0',
        true,
    );

    // Daten für den Konfigurator bereitstellen
    wp_localize_script('fanartikel-configurator', 'fanartikelConfig', [
        'mockupUrl' => get_template_directory_uri() . '/assets/images/christmas-ball.png',
        'backgroundUrl' => get_template_directory_uri() . '/assets/images/configurator/background.png',
        'ballsUrlBase' => get_template_directory_uri() . '/assets/images/configurator/balls/',
        'ajaxUrl' => admin_url('admin-ajax.php'),
    ]);

    // Google Fonts
    wp_enqueue_style(
        'fanartikel-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
        [],
        null,
    );
}
add_action('wp_enqueue_scripts', 'fanartikel_scripts');

/**
 * Register widget areas
 */
function fanartikel_widgets_init()
{
    register_sidebar([
        'name' => __('Footer Widget Area', 'fanartikel'),
        'id' => 'footer-1',
        'description' => __('Add widgets here to appear in your footer.', 'fanartikel'),
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ]);
}
add_action('widgets_init', 'fanartikel_widgets_init');

/**
 * WooCommerce Integration für den Konfigurator
 */

// 1. Design-Daten beim Hinzufügen zum Warenkorb speichern
add_filter('woocommerce_add_cart_item_data', function ($cart_item_data, $product_id, $variation_id) {
    if (isset($_POST['product_design_json'])) {
        $cart_item_data['fanartikel_design'] = sanitize_text_field($_POST['product_design_json']);
        // Einzigartiger Key für den Warenkorb, damit identische Produkte mit anderem Design separat gelistet werden
        $cart_item_data['unique_key'] = md5(microtime() . rand());
    }
    return $cart_item_data;
}, 10, 3);

// 2. Design-Info im Warenkorb anzeigen
add_filter('woocommerce_get_item_data', function ($item_data, $cart_item) {
    if (isset($cart_item['fanartikel_design'])) {
        $item_data[] = [
            'key' => __('Design', 'fanartikel'),
            'value' => __('Individuell konfiguriert', 'fanartikel'),
        ];
    }
    return $item_data;
}, 10, 2);

// 3. Design in der Bestellung speichern
add_action('woocommerce_checkout_create_order_line_item', function ($item, $cart_item_key, $values, $order) {
    if (isset($values['fanartikel_design'])) {
        $item->add_meta_data('_fanartikel_design', $values['fanartikel_design']);
    }
}, 10, 4);

/**
 * AJAX-Handler für den Warenkorb
 */
function fanartikel_ajax_add_to_cart()
{
    $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? absint($_POST['quantity']) : 1;
    $design_json = isset($_POST['design_json']) ? stripslashes($_POST['design_json']) : '';

    if (!$product_id) {
        // Fallback: Suche nach dem ersten Produkt, falls keine ID übergeben wurde
        $products = wc_get_products(array('limit' => 1));
        if (!empty($products)) {
            $product_id = $products[0]->get_id();
        }
    }

    if ($product_id) {
        $cart_item_data = array();
        if ($design_json) {
            $cart_item_data['fanartikel_design'] = $design_json;
            // Einzigartiger Key für unterschiedliche Designs
            $cart_item_data['unique_key'] = md5($design_json . microtime());
        }

        $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
        $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity, 0, array(), $cart_item_data);

        if ($passed_validation && $cart_item_key) {
            wp_send_json_success(array(
                'message' => __('Produkt erfolgreich hinzugefügt', 'fanartikel'),
                'cart_url' => wc_get_cart_url()
            ));
        }
    }

    wp_send_json_error(array('message' => __('Fehler beim Hinzufügen zum Warenkorb', 'fanartikel')));
}
add_action('wp_ajax_fanartikel_add_to_cart', 'fanartikel_ajax_add_to_cart');
add_action('wp_ajax_nopriv_fanartikel_add_to_cart', 'fanartikel_ajax_add_to_cart');
