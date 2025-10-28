# WordPress Register Post Type

A powerful, elegant library for registering custom post types in WordPress with smart defaults, automatic label generation, and permalink management.

## Features

- 🎯 **Simple API** - Register post types with minimal configuration
- 🏷️ **Auto Labels** - Generates all 28 labels from singular/plural forms
- 🎨 **Icon Shortcuts** - Use simple names like 'cart' instead of 'dashicons-cart'
- 📍 **Smart Menu Positioning** - Use semantic positions like 'after:posts'
- 🔗 **Permalink Management** - Easy slug configuration with auto-flush
- 📊 **Admin Column Helpers** - Quick thumbnail column setup
- ✨ **Clean Code** - Modern PHP 7.4+, fully typed, well-documented
- 🚀 **Zero Config** - Works great with just singular/plural labels

## Installation

Install via Composer:

```bash
composer require arraypress/wp-register-post-type
```

## Quick Start

### Minimal Example

```php
use function ArrayPress\WP\RegisterPostType\register_custom_post_type;

register_custom_post_type( 'product', [
    'labels' => [
        'singular' => 'Product',
        'plural'   => 'Products'
    ]
] );
```

That's it! This creates a fully functional post type with:
- ✅ All 28 labels auto-generated
- ✅ Public and queryable
- ✅ REST API enabled
- ✅ Archive page enabled
- ✅ Title, editor, and thumbnail support

### Full Example

```php
register_custom_post_type( 'product', [
    'labels' => [
        'singular' => 'Product',
        'plural'   => 'Products'
    ],
    'icon'          => 'cart',              // Simple icon name
    'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
    'has_archive'   => true,
    'show_in_rest'  => true,
    'menu_position' => 'after:posts',       // Semantic positioning
    'permalink'     => [
        'slug'       => 'shop/products',
        'with_front' => false
    ],
    'admin_columns' => [
        'thumbnail' => true                 // Add thumbnail column
    ]
] );
```

## Configuration Options

### Labels

The library automatically generates all 28 WordPress post type labels from just two inputs:

```php
'labels' => [
    'singular' => 'Product',
    'plural'   => 'Products'  // Optional - auto-pluralized if not provided
]
```

**Generated labels include:**
- name, singular_name, add_new, add_new_item, edit_item
- new_item, view_item, view_items, search_items
- not_found, not_found_in_trash, parent_item_colon
- all_items, archives, attributes, insert_into_item
- uploaded_to_this_item, featured_image, set_featured_image
- remove_featured_image, use_featured_image, menu_name
- filter_items_list, items_list_navigation, items_list
- item_published, item_published_privately, item_reverted_to_draft
- item_scheduled, item_updated

You can override any generated label:

```php
'labels' => [
    'singular'  => 'Product',
    'plural'    => 'Products',
    'all_items' => 'All My Products'  // Override specific label
]
```

### Icon Shortcuts

Use simple, memorable names instead of full dashicon strings:

| Shortcut | Dashicon |
|----------|----------|
| `cart` | dashicons-cart |
| `product`, `products` | dashicons-products |
| `store`, `shop` | dashicons-store |
| `calendar`, `event` | dashicons-calendar |
| `people`, `team` | dashicons-groups |
| `book`, `books` | dashicons-book |
| `portfolio` | dashicons-portfolio |
| `image`, `images` | dashicons-format-image |
| `video` | dashicons-format-video |
| `audio` | dashicons-format-audio |
| `download` | dashicons-download |
| `star` | dashicons-star-filled |
| `heart` | dashicons-heart |
| `location`, `map` | dashicons-location |
| `email`, `mail` | dashicons-email |

**Examples:**
```php
'icon' => 'cart'                    // Uses dashicons-cart
'icon' => 'dashicons-admin-post'    // Use full dashicon name
'icon' => 'data:image/svg+xml...'   // Use base64 SVG
'icon' => 'path/to/icon.png'        // Use custom image
```

### Menu Position

Use semantic positioning instead of remembering numbers:

```php
'menu_position' => 'after:posts'     // Right after Posts menu
'menu_position' => 'before:media'    // Right before Media menu
'menu_position' => 'after:pages'     // Right after Pages
'menu_position' => 'after:comments'  // Right after Comments
'menu_position' => 30                // Or use numeric position
```

**Available reference points:**
- `dashboard` (2)
- `posts` (5)
- `media` (10)
- `pages` (20)
- `comments` (25)
- `appearance` (60)
- `plugins` (65)
- `users` (70)
- `tools` (75)
- `settings` (80)

### Permalink Structure

Configure custom URL structure:

```php
'permalink' => [
    'slug'       => 'shop/products',    // Custom slug
    'with_front' => false,              // Don't prepend site's base
    'feeds'      => true,               // Enable feeds
    'pages'      => true                // Enable pagination
]
```

**Examples:**

```php
// Simple slug
'permalink' => [
    'slug' => 'products'
]
// Result: yoursite.com/products/product-name/

// Nested structure
'permalink' => [
    'slug' => 'shop/products'
]
// Result: yoursite.com/shop/products/product-name/

// Disable rewrites entirely
'permalink' => [
    'disabled' => true
]
```

### Admin Columns

Quick shortcuts for common admin columns:

```php
'admin_columns' => [
    'thumbnail' => true    // Add thumbnail column before title
]
```

### Common Options

All standard `register_post_type()` options are supported:

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `public` | `bool` | `true` | Public facing post type |
| `has_archive` | `bool` | `true` | Enable archive page |
| `show_in_rest` | `bool` | `true` | Enable Gutenberg & REST API |
| `supports` | `array` | `['title', 'editor', 'thumbnail']` | Features to support |
| `hierarchical` | `bool` | `false` | Allow parent/child relationships |
| `capability_type` | `string` | `'post'` | Capability type |
| `menu_position` | `int\|string` | `null` | Menu position |
| `menu_icon` | `string` | `null` | Menu icon |

## Real-World Examples

### E-Commerce Products

```php
register_custom_post_type( 'product', [
    'labels' => [
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
```

### Portfolio Items

```php
register_custom_post_type( 'portfolio', [
    'labels' => [
        'singular' => 'Portfolio Item',
        'plural'   => 'Portfolio'
    ],
    'icon'         => 'portfolio',
    'supports'     => [ 'title', 'editor', 'thumbnail' ],
    'has_archive'  => true,
    'menu_position' => 'after:pages'
] );
```

### Team Members

```php
register_custom_post_type( 'team', [
    'labels' => [
        'singular' => 'Team Member',
        'plural'   => 'Team'
    ],
    'icon'         => 'people',
    'supports'     => [ 'title', 'editor', 'thumbnail', 'page-attributes' ],
    'hierarchical' => true,
    'has_archive'  => false,
    'public'       => true,
    'menu_position' => 'after:users',
    'admin_columns' => [
        'thumbnail' => true
    ]
] );
```

### Events with Custom Permalink

```php
register_custom_post_type( 'event', [
    'labels' => [
        'singular' => 'Event',
        'plural'   => 'Events'
    ],
    'icon'         => 'calendar',
    'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
    'has_archive'  => true,
    'show_in_rest' => true,
    'permalink'    => [
        'slug'       => 'events',
        'with_front' => false
    ]
] );
```

### Documentation/Knowledge Base

```php
register_custom_post_type( 'documentation', [
    'labels' => [
        'singular' => 'Documentation',
        'plural'   => 'Docs'
    ],
    'icon'         => 'book',
    'supports'     => [ 'title', 'editor', 'comments', 'revisions' ],
    'hierarchical' => true,
    'has_archive'  => true,
    'show_in_rest' => true,
    'permalink'    => [
        'slug' => 'docs'
    ]
] );
```

### Testimonials

```php
register_custom_post_type( 'testimonial', [
    'labels' => [
        'singular' => 'Testimonial'
        // Plural auto-generated as 'Testimonials'
    ],
    'icon'         => 'star',
    'supports'     => [ 'title', 'editor', 'thumbnail' ],
    'has_archive'  => false,
    'show_in_menu' => true
] );
```

## How It Works

### Automatic Label Generation

The library uses intelligent pluralization:

```php
'Product' → 'Products'
'Category' → 'Categories'
'Person' → 'People' (you should provide this manually)
```

All 28 required labels are generated from these two inputs.

### Permalink Management

- Rewrites are automatically configured based on your `permalink` settings
- Rewrite rules are flushed on plugin activation (no manual flush needed)
- Supports complex structures like `shop/products/%category%`

### Icon Resolution

1. Checks if it's already a full dashicon name (`dashicons-*`)
2. Checks if it's a URL or path to an image
3. Checks if it's a base64 SVG
4. Looks up shortcut in icon map
5. Assumes it's a dashicon name and adds prefix

## Function Reference

### `register_custom_post_type( string $post_type, array $config )`

Register a custom post type.

**Parameters:**
- `$post_type` (string) - Post type slug (max 20 characters, lowercase)
- `$config` (array) - Configuration array

**Returns:** `PostType` instance

**Aliases:**
- `ArrayPress\WP\RegisterPostType\register_post_type()` - Same function

## Requirements

- PHP 7.4 or higher
- WordPress 5.0 or higher

## Best Practices

1. **Keep slugs short** - Max 20 characters for post type slug
2. **Use singular form for slug** - `product` not `products`
3. **Provide both singular and plural** - For best label generation
4. **Test permalink structure** - Always test your URLs after registration

## Troubleshooting

### Permalinks not working?

Try visiting **Settings → Permalinks** to manually flush rewrite rules.

### Post type not showing in REST API?

Make sure `show_in_rest` is `true` (it is by default).

### Custom icon not showing?

Check that your icon path is correct or use one of the built-in shortcuts.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

GPL-2.0-or-later

## Credits

Developed by [ArrayPress](https://arraypress.com/)

## Support

- [Documentation](https://github.com/arraypress/wp-register-post-type)
- [Issue Tracker](https://github.com/arraypress/wp-register-post-type/issues)