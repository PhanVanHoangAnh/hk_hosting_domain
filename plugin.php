<?php
/**
 * @wordpress-plugin
 * Plugin Name:       HK 2
 * Plugin URI:        https://hoangkhang.com.vn
 * Description:       HK Plugin for WordPress
 * Version:           @VERSION
 * Author:            Hoang Khang Incotech
 * Author URI:        https://hoangkhang.com.vn
 */

 # getResponse function
function hk_getResponse($path=null) // 'login', 'edu/courses', '/hello'
{
    require __DIR__.'/vendor/autoload.php';
    $app = require_once __DIR__.'/bootstrap/app.php';
    $hk_kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    if (!$path) {
        $path = isset($_REQUEST['path']) ? $_REQUEST['path'] : '/dashboard';
    }
    $response = $hk_kernel->handle(
        App\Wordpress\LaravelRequest::capture($path)
    );
        
    return $response;
}

function my_custom_shortcode($atts) {
    // auto load laravel framework
    hk_getResponse('/');

    $atts = shortcode_atts(
        array(
            'page' => 'main',  
        ),
        $atts,
        'my_custom'
    );

    switch ($atts['page']) {
        case 'hosting':
            $html = view('hk.hosting.index')->render();
            break;
        case 'domain':
            $html = view('hk.domain.index')->render();
            break;
        case 'main':
        default:
            $html = view('hk.main.index')->render();
            break;
    }

    return $html;
}
add_shortcode('my_custom', 'my_custom_shortcode');



function my_custom_menu() {
    // Add main menu
    add_menu_page(
        'Custom Menu Title',   // Page title
        'Custom Menu',         // Menu title
        'manage_options',      // Capability
        'custom_menu_slug',    // Menu slug
        'custom_menu_page',    // Function that displays the page content
        'dashicons-admin-generic', // Icon URL or Dashicon class
        6                      // Position in the menu
    );

    // Add submenu
    add_submenu_page(
        'custom_menu_slug',    // Parent menu slug
        'Submenu Title',       // Page title
        'Submenu',             // Submenu title
        'manage_options',      // Capability
        'custom_submenu_slug', // Menu slug
        'custom_submenu_page'  // Function that displays the page content
    );
}

add_action('admin_menu', 'my_custom_menu');

// Function for main menu page content
function custom_menu_page() {
    $response = hk_getResponse('/hk/hosting');

    // send response
    $response->send(); // => echo html******
}

// Function for submenu page content
function custom_submenu_page() {
    echo '<h1>Welcome to the Submenu Page</h1>';
}