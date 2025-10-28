<?php
/**
 * Helper Functions
 *
 * @package     ArrayPress\WP\RegisterPostType
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 * @author      David Sherlock
 */

declare( strict_types=1 );

namespace ArrayPress\WP\RegisterPostType;

if ( ! function_exists( 'register_cpt' ) ) {
	/**
	 * Register a custom post type with smart defaults and automatic label generation.
	 *
	 * @param string $post_type Post type slug (max 20 characters).
	 * @param array  $config    Configuration array.
	 *
	 * @return PostType The PostType instance.
	 *
	 * @example
	 * ```php
	 * register_cpt( 'product', [
	 *     'labels' => [
	 *         'singular' => 'Product',
	 *         'plural'   => 'Products'
	 *     ],
	 *     'icon'       => 'cart',
	 *     'supports'   => [ 'title', 'editor', 'thumbnail' ],
	 *     'has_archive' => true,
	 *     'permalink' => [
	 *         'slug' => 'shop/products'
	 *     ]
	 * ] );
	 * ```
	 */
	function register_cpt( string $post_type, array $config = [] ): PostType {
		return new PostType( $post_type, $config );
	}
}