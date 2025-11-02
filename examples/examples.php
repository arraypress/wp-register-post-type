<?php
/**
 * Register Custom Post Type Examples
 *
 * Practical examples of using the WP Register Post Type library.
 * Note: No need to wrap in admin_init - the library handles hook timing automatically!
 *
 * @package ArrayPress\WP\RegisterPostType
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Test 1: Simple post type with auto-generated labels
 */
register_cpt( 'product', [
	'labels'        => [
		'singular' => 'Product',
		'plural'   => 'Products'
	],
	'icon'          => 'cart',
	'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
	'has_archive'   => true,
	'show_in_rest'  => true,
	'menu_position' => 'after:posts',
	'permalink'     => [
		'slug'       => 'shop/products',
		'with_front' => false
	],
	'admin_columns' => [
		'thumbnail' => true
	]
] );

/**
 * Test 2: Portfolio with custom icon
 */
register_cpt( 'portfolio', [
	'labels'        => [
		'singular' => 'Portfolio Item',
		'plural'   => 'Portfolio'
	],
	'icon'          => 'portfolio',
	'supports'      => [ 'title', 'editor', 'thumbnail' ],
	'has_archive'   => true,
	'menu_position' => 'after:pages'
] );

/**
 * Test 3: Event with calendar icon
 */
register_cpt( 'event', [
	'labels'       => [
		'singular' => 'Event',
		'plural'   => 'Events'
	],
	'icon'         => 'calendar',
	'supports'     => [ 'title', 'editor', 'thumbnail' ],
	'has_archive'  => true,
	'show_in_rest' => true,
	'permalink'    => [
		'slug' => 'events'
	]
] );

/**
 * Test 4: Team member with hierarchical support
 */
register_cpt( 'team', [
	'labels'        => [
		'singular' => 'Team Member',
		'plural'   => 'Team'
	],
	'icon'          => 'people',
	'supports'      => [ 'title', 'editor', 'thumbnail', 'page-attributes' ],
	'hierarchical'  => true,
	'has_archive'   => true,
	'menu_position' => 'after:users'
] );

/**
 * Test 5: Testimonial with simple setup
 */
register_cpt( 'testimonial', [
	'labels'   => [
		'singular' => 'Testimonial'
		// Plural will be auto-generated as 'Testimonials'
	],
	'icon'     => 'star',
	'supports' => [ 'title', 'editor', 'thumbnail' ]
] );

/**
 * Test 6: Documentation with custom permalink
 */
register_cpt( 'documentation', [
	'labels'       => [
		'singular' => 'Documentation',
		'plural'   => 'Docs'
	],
	'icon'         => 'book',
	'supports'     => [ 'title', 'editor', 'comments', 'revisions' ],
	'has_archive'  => true,
	'show_in_rest' => true,
	'permalink'    => [
		'slug'       => 'docs/%category%',
		'with_front' => false
	]
] );

/**
 * Test 7: Download with numeric menu position
 */
register_cpt( 'download', [
	'labels'        => [
		'singular' => 'Download',
		'plural'   => 'Downloads'
	],
	'icon'          => 'download',
	'supports'      => [ 'title', 'editor', 'thumbnail' ],
	'has_archive'   => true,
	'menu_position' => 30,
	'admin_columns' => [
		'thumbnail' => true
	]
] );

/**
 * Test 8: Recipe without archive
 */
register_cpt( 'recipe', [
	'labels'      => [
		'singular' => 'Recipe',
		'plural'   => 'Recipes'
	],
	'icon'        => 'food',
	'supports'    => [ 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ],
	'has_archive' => false,
	'public'      => true
] );