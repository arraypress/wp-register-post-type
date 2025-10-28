<?php
/**
 * Post Type Registration Class
 *
 * @package     ArrayPress\WP\RegisterPostType
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 * @author      David Sherlock
 */

declare( strict_types=1 );

namespace ArrayPress\WP\RegisterPostType;

use ArrayPress\WP\RegisterPostType\Helpers\LabelGenerator;
use ArrayPress\WP\RegisterPostType\Helpers\IconResolver;

class PostType {

	/**
	 * Post type slug
	 *
	 * @var string
	 */
	private string $post_type;

	/**
	 * Post type configuration
	 *
	 * @var array
	 */
	private array $config;

	/**
	 * Whether rewrite rules need to be flushed
	 *
	 * @var bool
	 */
	private static bool $needs_flush = false;

	/**
	 * Constructor.
	 *
	 * @param string $post_type Post type slug.
	 * @param array  $config    Configuration array.
	 */
	public function __construct( string $post_type, array $config ) {
		$this->post_type = $post_type;
		$this->config    = $this->parse_config( $config );

		// Register immediately if init has fired, otherwise wait
		if ( did_action( 'init' ) ) {
			$this->register();
		} else {
			add_action( 'init', [ $this, 'register' ] );
		}

		// Handle rewrite flush on activation
		add_action( 'activated_plugin', [ $this, 'maybe_flush_rewrites' ] );
	}

	/**
	 * Parse and normalize configuration.
	 *
	 * @param array $config Raw configuration.
	 *
	 * @return array Parsed configuration.
	 */
	private function parse_config( array $config ): array {
		$defaults = [
			'labels'         => [],
			'public'         => true,
			'has_archive'    => true,
			'show_in_rest'   => true,
			'supports'       => [ 'title', 'editor', 'thumbnail' ],
			'menu_position'  => null,
			'menu_icon'      => null,
			'capability_type' => 'post',
			'rewrite'        => true,
			'permalink'      => [],
			'admin_columns'  => []
		];

		$config = wp_parse_args( $config, $defaults );

		// Generate labels if not provided
		if ( ! empty( $config['labels'] ) && ( ! empty( $config['labels']['singular'] ) || ! empty( $config['labels']['plural'] ) ) ) {
			$config['labels'] = LabelGenerator::generate(
				$config['labels']['singular'] ?? '',
				$config['labels']['plural'] ?? '',
				$config['labels']
			);
		}

		// Resolve icon
		if ( ! empty( $config['icon'] ) ) {
			$config['menu_icon'] = IconResolver::resolve( $config['icon'] );
			unset( $config['icon'] );
		}

		// Parse menu position
		if ( ! empty( $config['menu_position'] ) && is_string( $config['menu_position'] ) ) {
			$config['menu_position'] = $this->parse_menu_position( $config['menu_position'] );
		}

		// Handle permalink/rewrite
		if ( ! empty( $config['permalink'] ) ) {
			$config['rewrite'] = $this->parse_permalink( $config['permalink'] );
			unset( $config['permalink'] );
		}

		return $config;
	}

	/**
	 * Parse menu position string to numeric position.
	 *
	 * @param string $position Position string like 'after:posts' or 'before:pages'.
	 *
	 * @return int|null Numeric position or null.
	 */
	private function parse_menu_position( string $position ): ?int {
		// Map of common positions
		$positions = [
			'dashboard'  => 2,
			'posts'      => 5,
			'media'      => 10,
			'pages'      => 20,
			'comments'   => 25,
			'appearance' => 60,
			'plugins'    => 65,
			'users'      => 70,
			'tools'      => 75,
			'settings'   => 80
		];

		// Handle 'after:X' or 'before:X'
		if ( preg_match( '/^(after|before):(.+)$/', $position, $matches ) ) {
			$type = $matches[1];
			$ref  = $matches[2];

			if ( isset( $positions[ $ref ] ) ) {
				return $type === 'after' ? $positions[ $ref ] + 1 : $positions[ $ref ] - 1;
			}
		}

		// Handle direct numeric
		if ( is_numeric( $position ) ) {
			return (int) $position;
		}

		return null;
	}

	/**
	 * Parse permalink configuration.
	 *
	 * @param array $permalink Permalink configuration.
	 *
	 * @return array|bool Rewrite configuration.
	 */
	private function parse_permalink( array $permalink ) {
		if ( isset( $permalink['disabled'] ) && $permalink['disabled'] ) {
			return false;
		}

		$defaults = [
			'slug'       => $this->post_type,
			'with_front' => true,
			'feeds'      => true,
			'pages'      => true
		];

		return wp_parse_args( $permalink, $defaults );
	}

	/**
	 * Register the post type.
	 *
	 * @return void
	 */
	public function register(): void {
		// Remove custom keys that aren't part of register_post_type args
		$admin_columns = $this->config['admin_columns'] ?? [];
		unset( $this->config['admin_columns'] );

		// Register the post type
		register_post_type( $this->post_type, $this->config );

		// Handle admin columns if specified
		if ( ! empty( $admin_columns ) ) {
			$this->setup_admin_columns( $admin_columns );
		}

		// Mark that we might need to flush rewrites
		self::$needs_flush = true;
	}

	/**
	 * Setup admin columns.
	 *
	 * @param array $columns Column configuration.
	 *
	 * @return void
	 */
	private function setup_admin_columns( array $columns ): void {
		if ( ! empty( $columns['thumbnail'] ) ) {
			add_filter( "manage_{$this->post_type}_posts_columns", function( $cols ) {
				$new_cols = [];
				foreach ( $cols as $key => $label ) {
					if ( $key === 'title' ) {
						$new_cols['thumbnail'] = __( 'Thumbnail' );
					}
					$new_cols[ $key ] = $label;
				}
				return $new_cols;
			} );

			add_action( "manage_{$this->post_type}_posts_custom_column", function( $column, $post_id ) {
				if ( $column === 'thumbnail' ) {
					echo get_the_post_thumbnail( $post_id, [ 50, 50 ] );
				}
			}, 10, 2 );
		}
	}

	/**
	 * Maybe flush rewrite rules.
	 *
	 * @return void
	 */
	public function maybe_flush_rewrites(): void {
		if ( self::$needs_flush ) {
			flush_rewrite_rules();
			self::$needs_flush = false;
		}
	}

}