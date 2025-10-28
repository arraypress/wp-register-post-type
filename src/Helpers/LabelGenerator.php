<?php
/**
 * Label Generator Helper
 *
 * Automatically generates all required labels from singular and plural forms.
 *
 * @package     ArrayPress\WP\RegisterPostType
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 * @author      David Sherlock
 */

declare( strict_types=1 );

namespace ArrayPress\WP\RegisterPostType\Helpers;

class LabelGenerator {

	/**
	 * Generate all labels from singular and plural forms.
	 *
	 * @param string $singular Singular form (e.g., 'Product').
	 * @param string $plural   Plural form (e.g., 'Products').
	 * @param array  $overrides Optional label overrides.
	 *
	 * @return array Complete set of labels.
	 */
	public static function generate( string $singular, string $plural = '', array $overrides = [] ): array {
		// If no plural provided, try to make one
		if ( empty( $plural ) ) {
			$plural = self::pluralize( $singular );
		}

		$singular_lower = strtolower( $singular );
		$plural_lower   = strtolower( $plural );

		$labels = [
			'name'                     => $plural,
			'singular_name'            => $singular,
			'add_new'                  => sprintf( 'Add New %s', $singular ),
			'add_new_item'             => sprintf( 'Add New %s', $singular ),
			'edit_item'                => sprintf( 'Edit %s', $singular ),
			'new_item'                 => sprintf( 'New %s', $singular ),
			'view_item'                => sprintf( 'View %s', $singular ),
			'view_items'               => sprintf( 'View %s', $plural ),
			'search_items'             => sprintf( 'Search %s', $plural ),
			'not_found'                => sprintf( 'No %s found', $plural_lower ),
			'not_found_in_trash'       => sprintf( 'No %s found in Trash', $plural_lower ),
			'parent_item_colon'        => sprintf( 'Parent %s:', $singular ),
			'all_items'                => sprintf( 'All %s', $plural ),
			'archives'                 => sprintf( '%s Archives', $singular ),
			'attributes'               => sprintf( '%s Attributes', $singular ),
			'insert_into_item'         => sprintf( 'Insert into %s', $singular_lower ),
			'uploaded_to_this_item'    => sprintf( 'Uploaded to this %s', $singular_lower ),
			'featured_image'           => 'Featured Image',
			'set_featured_image'       => 'Set featured image',
			'remove_featured_image'    => 'Remove featured image',
			'use_featured_image'       => 'Use as featured image',
			'menu_name'                => $plural,
			'filter_items_list'        => sprintf( 'Filter %s list', $plural_lower ),
			'items_list_navigation'    => sprintf( '%s list navigation', $plural ),
			'items_list'               => sprintf( '%s list', $plural ),
			'item_published'           => sprintf( '%s published', $singular ),
			'item_published_privately' => sprintf( '%s published privately', $singular ),
			'item_reverted_to_draft'   => sprintf( '%s reverted to draft', $singular ),
			'item_scheduled'           => sprintf( '%s scheduled', $singular ),
			'item_updated'             => sprintf( '%s updated', $singular ),
		];

		// Merge with any overrides
		return array_merge( $labels, $overrides );
	}

	/**
	 * Simple pluralization.
	 *
	 * @param string $singular Singular form.
	 *
	 * @return string Plural form.
	 */
	private static function pluralize( string $singular ): string {
		// Simple English pluralization rules
		if ( preg_match( '/(s|ss|sh|ch|x|z)$/i', $singular ) ) {
			return $singular . 'es';
		} elseif ( preg_match( '/([^aeiou])y$/i', $singular ) ) {
			return preg_replace( '/y$/i', 'ies', $singular );
		} else {
			return $singular . 's';
		}
	}

}