<?php
/**
 * Vision Habitat 2026
 * Functions & Theme Setup
 */

function vh_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    register_nav_menus([
        'primary' => __('Menu principal', 'vision-habitat'),
        'footer'  => __('Menu footer', 'vision-habitat'),
    ]);
}
add_action('after_setup_theme', 'vh_theme_setup');


function vh_enqueue_assets() {

    $dist_path = get_template_directory() . '/assets/dist/';
    $dist_uri  = get_template_directory_uri() . '/assets/dist/';

    $main_js   = $dist_path . 'main.bundle.js';
    $style_js  = $dist_path . 'style.bundle.js';
    $style_css = $dist_path . 'style.bundle.css';

    // Si le build n'existe pas, on ne charge rien
    if ( ! file_exists($main_js) ) {
        return;
    }

    // CSS extrait (production)
    if ( file_exists($style_css) ) {
        wp_enqueue_style(
            'vh-style',
            $dist_uri . 'style.bundle.css',
            [],
            filemtime($style_css)
        );
    } else {
        // Fallback (dev) : injection via JS
        if ( file_exists($style_js) ) {
            wp_enqueue_script( 
                'vh-style',
                $dist_uri . 'style.bundle.js',
                [],
                filemtime($style_js),
                true
            );
        }
    }

    // JS principal
    wp_enqueue_script(
        'vh-main',
        $dist_uri . 'main.bundle.js',
        [],
        filemtime($main_js),
        true
    );
}
add_action('wp_enqueue_scripts', 'vh_enqueue_assets');