<?php
/**
 * Icon Resolver Helper
 *
 * Resolves icon shortcuts to full dashicon names.
 *
 * @package     ArrayPress\WP\RegisterPostType
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 * @author      David Sherlock
 */

declare( strict_types=1 );

namespace ArrayPress\WP\RegisterPostType\Helpers;

class IconResolver {

	/**
	 * Icon mappings for common shortcuts.
	 *
	 * @var array
	 */
	private static array $icon_map = [
		// Common shortcuts
		'document'  => 'dashicons-media-document',
		'docs'      => 'dashicons-media-document',
		'file'      => 'dashicons-media-document',
		'cart'      => 'dashicons-cart',
		'shop'      => 'dashicons-store',
		'store'     => 'dashicons-store',
		'product'   => 'dashicons-products',
		'products'  => 'dashicons-products',
		'portfolio' => 'dashicons-portfolio',
		'image'     => 'dashicons-format-image',
		'images'    => 'dashicons-format-gallery',
		'gallery'   => 'dashicons-format-gallery',
		'video'     => 'dashicons-format-video',
		'audio'     => 'dashicons-format-audio',
		'book'      => 'dashicons-book',
		'books'     => 'dashicons-book-alt',
		'calendar'  => 'dashicons-calendar-alt',
		'event'     => 'dashicons-calendar',
		'events'    => 'dashicons-calendar',
		'location'  => 'dashicons-location',
		'map'       => 'dashicons-location-alt',
		'team'      => 'dashicons-groups',
		'people'    => 'dashicons-groups',
		'users'     => 'dashicons-admin-users',
		'star'      => 'dashicons-star-filled',
		'heart'     => 'dashicons-heart',
		'download'  => 'dashicons-download',
		'upload'    => 'dashicons-upload',
		'email'     => 'dashicons-email',
		'mail'      => 'dashicons-email-alt',
		'phone'     => 'dashicons-phone',
		'comment'   => 'dashicons-admin-comments',
		'comments'  => 'dashicons-admin-comments',
		'tag'       => 'dashicons-tag',
		'tags'      => 'dashicons-tagcloud',
		'category'  => 'dashicons-category',
		'clipboard' => 'dashicons-clipboard',
		'post'      => 'dashicons-admin-post',
		'page'      => 'dashicons-admin-page',
		'media'     => 'dashicons-admin-media',
		'link'      => 'dashicons-admin-links',
	];

	/**
	 * Resolve icon string to full dashicon name or return as-is.
	 *
	 * @param string $icon Icon string.
	 *
	 * @return string Resolved icon.
	 */
	public static function resolve( string $icon ): string {
		// Already a dashicon
		if ( str_starts_with( $icon, 'dashicons-' ) ) {
			return $icon;
		}

		// URL to image
		if ( str_contains( $icon, '/' ) || str_contains( $icon, '.' ) ) {
			return $icon;
		}

		// Base64 SVG
		if ( str_starts_with( $icon, 'data:image' ) ) {
			return $icon;
		}

		// Try to resolve shortcut
		$icon_lower = strtolower( $icon );
		if ( isset( self::$icon_map[ $icon_lower ] ) ) {
			return self::$icon_map[ $icon_lower ];
		}

		// Assume it's a dashicon name without prefix
		return 'dashicons-' . $icon;
	}

}