<?php

if ( ! defined('ABSPATH') ) {
    die('Direct access not permitted.');
}

foreach ( glob( (__DIR__) . '/hooks/*.php' ) as $filename ) {
    require_once $filename;
}

foreach ( glob( (__DIR__) . '/functions/*.php' ) as $filename ) {
    require_once $filename;
}

// Register Custom Post Type
function repair_link_post_type() {

	$labels = array(
		'name'                  => _x( 'Enlaces dañados', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Enlace dañado', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Enlaces dañados', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Enlace dañado', 'text_domain' ),
		'description'           => __( 'Lista de los enlaces dañados en tus entradas', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
        'menu_icon'             => 'dashicons-admin-links',
		'menu_position'         => 5,
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => false,
		'rewrite'               => false,
        'capabilities' => array(
            'create_posts' => false, // Removes support for the "Add New" function ( use 'do_not_allow' instead of false for multisite set ups )
          ),
		'capability_type'       => 'page',
	);
	register_post_type( 'repair_link_post', $args );

}
add_action( 'init', 'repair_link_post_type', 0 );


/**
 * Crear pagina en el dashboard para explicar como usar el shortcode
 */


function add_link_repair(){
    add_menu_page('Extra Quotes', 'Extra Quotes', 'publish_posts', 'extra-quotes', 'page_content', 'dashicons-format-quote', 16);
}
add_action('admin_menu', 'add_link_repair');

function page_content(){
    include "panel-extra-quotes.php";
}