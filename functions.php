<?php
/**
 * Deweboo Real-Estate Theme Functions
 * 
 * @package Deweboo Real-Estate
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load theme setup and initialization
require_once get_template_directory() . '/inc/theme-setup.php';

// Load WP-CLI commands if available
if ( defined( 'WP_CLI' ) ) {
	require_once get_template_directory() . '/inc/wp-cli-setup.php';
}

/**
 * One-time migration: remove legacy placeholder shortcodes from page content.
 *
 * Older setup versions stored shortcodes like [deweboo_hero_section] directly in
 * page content. This keeps Gutenberg from starting as a clean editable canvas.
 */
function deweboo_realestate_migrate_placeholder_page_content() {
	if ( 'yes' === get_option( 'deweboo_placeholder_content_migrated_112', 'no' ) ) {
		return;
	}

	$placeholders = array(
		'[deweboo_hero_section]',
		'[deweboo_about_section]',
		'[deweboo_contact_form]',
	);

	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
			'posts_per_page' => -1,
		)
	);

	foreach ( $pages as $page ) {
		if ( in_array( trim( (string) $page->post_content ), $placeholders, true ) ) {
			wp_update_post(
				array(
					'ID'           => (int) $page->ID,
					'post_content' => '',
				)
			);
		}
	}

	update_option( 'deweboo_placeholder_content_migrated_112', 'yes' );
}
add_action( 'admin_init', 'deweboo_realestate_migrate_placeholder_page_content' );

/**
 * Return rendered block content only when page content is meaningful.
 *
 * @param int   $post_id Post ID.
 * @param array $legacy_placeholders Legacy placeholder shortcodes.
 * @return string
 */
function deweboo_realestate_get_builder_content( $post_id, $legacy_placeholders = array() ) {
	$post_id = absint( $post_id );
	if ( ! $post_id ) {
		return '';
	}

	$raw_content = (string) get_post_field( 'post_content', $post_id );
	$normalized  = trim( $raw_content );

	if ( '' === $normalized ) {
		return '';
	}

	if ( ! empty( $legacy_placeholders ) && in_array( $normalized, $legacy_placeholders, true ) ) {
		return '';
	}

	// Remove Gutenberg block comments and test whether any real text remains.
	$without_block_comments = preg_replace( '/<!--\s*\/?wp:[^>]*-->/', '', $raw_content );
	$plain_text             = trim( wp_strip_all_tags( (string) $without_block_comments ) );
	$plain_text             = str_replace( array( "\xC2\xA0", '&nbsp;' ), ' ', $plain_text );
	$plain_text             = preg_replace( '/\s+/', ' ', (string) $plain_text );

	if ( ! empty( $legacy_placeholders ) ) {
		$shortcode_only_text = (string) $plain_text;
		foreach ( $legacy_placeholders as $placeholder ) {
			$shortcode_only_text = str_replace( $placeholder, '', $shortcode_only_text );
		}

		if ( '' === trim( $shortcode_only_text ) ) {
			return '';
		}
	}

	if ( '' === trim( $plain_text ) ) {
		return '';
	}

	$rendered = (string) apply_filters( 'the_content', $raw_content );
	if ( '' === trim( wp_strip_all_tags( $rendered ) ) && '' === trim( preg_replace( '/\s+/', '', $rendered ) ) ) {
		return '';
	}

	return $rendered;
}

/**
 * Set up theme defaults and register support for various WordPress features.
 */
function deweboo_realestate_theme_setup() {
	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Add support for title tag
	add_theme_support( 'title-tag' );

	// Add support for post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add custom logo support
	add_theme_support( 'custom-logo', array(
		'height'      => 120,
		'width'       => 360,
		'flex-height' => true,
		'flex-width'  => true,
		'unlink-homepage-logo' => true,
	) );

	// Register navigation menus
	register_nav_menus( array(
		'primary'   => esc_html__( 'Primary Menu', 'deweboo-realestate' ),
		'secondary' => esc_html__( 'Secondary Menu', 'deweboo-realestate' ),
		'footer'    => esc_html__( 'Footer Menu', 'deweboo-realestate' ),
	) );

	// Mark the theme as using wide blocks
	add_theme_support( 'align-wide' );

	// Add support for editor styles
	add_theme_support( 'editor-styles' );

	// Add support for responsive embeds
	add_theme_support( 'responsive-embeds' );

	// Add support for HTML5 markup
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	// Load text domain for translations
	load_theme_textdomain( 'deweboo-realestate', get_template_directory() . '/languages' );
}

add_action( 'after_setup_theme', 'deweboo_realestate_theme_setup' );

/**
 * Add logo size controls in Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function deweboo_realestate_customize_logo_controls( $wp_customize ) {
	$wp_customize->add_setting(
		'deweboo_logo_header_height',
		array(
			'default'           => 64,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'deweboo_logo_header_height',
		array(
			'label'       => esc_html__( 'Header Logo Height (px)', 'deweboo-realestate' ),
			'section'     => 'title_tagline',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 24,
				'max'  => 200,
				'step' => 1,
			),
		)
	);

	$wp_customize->add_setting(
		'deweboo_logo_footer_height',
		array(
			'default'           => 56,
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'deweboo_logo_footer_height',
		array(
			'label'       => esc_html__( 'Footer Logo Height (px)', 'deweboo-realestate' ),
			'section'     => 'title_tagline',
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 24,
				'max'  => 200,
				'step' => 1,
			),
		)
	);
}

add_action( 'customize_register', 'deweboo_realestate_customize_logo_controls' );

/**
 * Output logo size CSS from Customizer settings.
 */
function deweboo_realestate_output_logo_size_css() {
	$header_logo_height = (int) get_theme_mod( 'deweboo_logo_header_height', 64 );
	$footer_logo_height = (int) get_theme_mod( 'deweboo_logo_footer_height', 56 );

	$header_logo_height = max( 24, min( 200, $header_logo_height ) );
	$footer_logo_height = max( 24, min( 200, $footer_logo_height ) );

	echo '<style id="deweboo-logo-size-css">';
	echo '.navbar .container .upper-side .logo img,';
	echo '.navbar .container .upper-side .logo .custom-logo{height:' . esc_attr( $header_logo_height ) . 'px !important;width:auto;max-width:100%;}';
	echo '.footer .logo img,';
	echo '.footer .custom-logo{height:' . esc_attr( $footer_logo_height ) . 'px !important;width:auto;max-width:100%;}';
	echo '</style>';
}

add_action( 'wp_head', 'deweboo_realestate_output_logo_size_css', 120 );

/**
 * Enqueue styles and scripts.
 */
function deweboo_realestate_enqueue_assets() {
	$theme_uri = get_template_directory_uri();
	$version   = wp_get_theme()->get( 'Version' );

	// === STYLES ===
	
	// Bootstrap CSS
	wp_enqueue_style(
		'bootstrap',
		$theme_uri . '/css/bootstrap.min.css',
		array(),
		'5.1.3'
	);

	// FontAwesome CSS
	wp_enqueue_style(
		'fontawesome',
		$theme_uri . '/css/fontawesome.min.css',
		array(),
		'6.0.0'
	);

	// Animate CSS
	wp_enqueue_style(
		'animate',
		$theme_uri . '/css/animate.min.css',
		array(),
		'4.1.0'
	);

	// FancyBox CSS
	wp_enqueue_style(
		'fancybox',
		$theme_uri . '/css/fancybox.min.css',
		array(),
		'3.5.7'
	);

	// Odometer CSS
	wp_enqueue_style(
		'odometer',
		$theme_uri . '/css/odometer.min.css',
		array(),
		'1.0'
	);

	// Swiper CSS
	wp_enqueue_style(
		'swiper',
		$theme_uri . '/css/swiper.min.css',
		array(),
		'8.0.7'
	);

	// Main theme styles
	wp_enqueue_style(
		'deweboo-realestate-style',
		$theme_uri . '/css/style.css',
		array(
			'bootstrap',
			'fontawesome',
			'animate',
			'fancybox',
			'odometer',
			'swiper',
		),
		$version
	);

	// === SCRIPTS ===

	// jQuery (using WordPress bundled version)
	wp_enqueue_script(
		'jquery'
	);

	// Popper (required for Bootstrap 5)
	wp_enqueue_script(
		'popper',
		$theme_uri . '/js/popper.min.js',
		array(),
		'2.11.2',
		true
	);

	// Bootstrap JS
	wp_enqueue_script(
		'bootstrap',
		$theme_uri . '/js/bootstrap.min.js',
		array( 'jquery', 'popper' ),
		'5.1.3',
		true
	);

	// Swiper JS
	wp_enqueue_script(
		'swiper',
		$theme_uri . '/js/swiper.min.js',
		array(),
		'8.0.7',
		true
	);

	// FancyBox JS
	wp_enqueue_script(
		'fancybox',
		$theme_uri . '/js/fancybox.min.js',
		array(),
		'3.5.7',
		true
	);

	// Odometer JS
	wp_enqueue_script(
		'odometer',
		$theme_uri . '/js/odometer.min.js',
		array(),
		'1.0',
		true
	);

	// WOW JS (animation library)
	wp_enqueue_script(
		'wow',
		$theme_uri . '/js/wow.min.js',
		array(),
		'1.3.2',
		true
	);

	// Text Rotater JS
	wp_enqueue_script(
		'text-rotater',
		$theme_uri . '/js/text-rotater.js',
		array(),
		$version,
		true
	);

	// jQuery Stellar (parallax scrolling)
	wp_enqueue_script(
		'jquery-stellar',
		$theme_uri . '/js/jquery.stellar.js',
		array( 'jquery' ),
		'0.6.2',
		true
	);

	// Isotope JS (filtering/layout)
	wp_enqueue_script(
		'isotope',
		$theme_uri . '/js/isotope.min.js',
		array(),
		'3.0.6',
		true
	);

	// jQuery Form (for contact form)
	wp_enqueue_script(
		'jquery-form',
		$theme_uri . '/js/jquery.form.min.js',
		array( 'jquery' ),
		'4.3.0',
		true
	);

	// jQuery Validate
	wp_enqueue_script(
		'jquery-validate',
		$theme_uri . '/js/jquery.validate.min.js',
		array( 'jquery' ),
		'1.19.3',
		true
	);

	// Contact Form Handler
	wp_enqueue_script(
		'contact-form',
		$theme_uri . '/js/contact.form.min.js',
		array( 'jquery', 'jquery-form', 'jquery-validate' ),
		$version,
		true
	);

	// Main theme scripts (skip on Hompark/front page to prevent duplicate handlers)
	if ( ! is_front_page() && ! is_page_template( 'page-hompark.php' ) ) {
		wp_enqueue_script(
			'deweboo-realestate-scripts',
			$theme_uri . '/js/scripts.js',
			array(
				'jquery',
				'bootstrap',
				'swiper',
				'fancybox',
				'wow',
				'jquery-stellar',
			),
			$version,
			true
		);
	}

	// Deregister default WordPress emoji script (optional optimization)
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
}

add_action( 'wp_enqueue_scripts', 'deweboo_realestate_enqueue_assets' );

/**
 * Enqueue Hompark-specific assets only on the Hompark landing template.
 */
function deweboo_realestate_enqueue_hompark_assets() {
	if ( ! is_front_page() && ! is_page_template( 'page-hompark.php' ) ) {
		return;
	}

	$stylesheet_uri = get_stylesheet_directory_uri();
	$version        = wp_get_theme()->get( 'Version' );

	// Hompark stylesheet (depends on core theme styles already enqueued).
	wp_enqueue_style(
		'DREAMASAHOMES-style',
		$stylesheet_uri . '/hompark/css/style.css',
		array(
			'bootstrap',
			'fontawesome',
			'animate',
			'fancybox',
			'odometer',
			'swiper',
		),
		$version
	);

	// Hompark scripts (carousel, animations etc.).
	wp_enqueue_script(
		'DREAMASAHOMES-scripts',
		$stylesheet_uri . '/hompark/js/scripts.js',
		array(
			'jquery',
			'bootstrap',
			'swiper',
			'fancybox',
			'wow',
			'jquery-stellar',
			'isotope',
		),
		$version,
		true
	);
}

add_action( 'wp_enqueue_scripts', 'deweboo_realestate_enqueue_hompark_assets' );

/**
 * Remove the static-site contact form scripts on the WordPress contact page.
 * The page-contact.php template uses its own inline AJAX handler posting to
 * admin-ajax.php  — the bundled contact.form.min.js (which posts to the
 * non-existent php/process.php) must not run on that page.
 */
function deweboo_realestate_dequeue_contact_scripts() {
	if ( is_page_template( 'page-contact.php' ) ) {
		wp_dequeue_script( 'contact-form' );
		wp_dequeue_script( 'jquery-validate' );
		wp_dequeue_script( 'jquery-form' );
	}
}
add_action( 'wp_enqueue_scripts', 'deweboo_realestate_dequeue_contact_scripts', 20 );

/**
 * Render the preloader markup globally from the theme.
 */
function deweboo_realestate_render_preloader() {
	?>
	<div class="preloader" aria-hidden="true">
		<div class="layer"></div>
		<div class="inner">
			<figure>
				<img src="<?php echo esc_url( get_template_directory_uri() . '/images/preloader.gif' ); ?>" alt="<?php esc_attr_e( 'Loading', 'deweboo-realestate' ); ?>">
			</figure>
			<p>
				<span class="text-rotater" data-text="<?php echo esc_attr( get_bloginfo( 'name' ) . ' | Elements | Loading' ); ?>">
					<?php esc_html_e( 'Loading', 'deweboo-realestate' ); ?>
				</span>
			</p>
		</div>
	</div>
	<?php
}

add_action( 'wp_body_open', 'deweboo_realestate_render_preloader', 5 );

/**
 * Set up sidebar/widget areas.
 */
function deweboo_realestate_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'deweboo-realestate' ),
		'id'            => 'primary-sidebar',
		'description'   => esc_html__( 'Main sidebar for pages and posts', 'deweboo-realestate' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets', 'deweboo-realestate' ),
		'id'            => 'footer-widgets',
		'description'   => esc_html__( 'Displays in footer area', 'deweboo-realestate' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'deweboo_realestate_widgets_init' );

/**
 * Register custom post types and taxonomies.
 */
function deweboo_realestate_register_post_types() {
	// Property Post Type
	register_post_type( 'property', array(
		'labels'             => array(
			'name'               => esc_html_x( 'Properties', 'post type general name', 'deweboo-realestate' ),
			'singular_name'      => esc_html_x( 'Property', 'post type singular name', 'deweboo-realestate' ),
			'menu_name'          => esc_html_x( 'Properties', 'admin menu', 'deweboo-realestate' ),
			'add_new_item'       => esc_html__( 'Add New Property', 'deweboo-realestate' ),
			'edit_item'          => esc_html__( 'Edit Property', 'deweboo-realestate' ),
			'new_item'           => esc_html__( 'New Property', 'deweboo-realestate' ),
			'view_item'          => esc_html__( 'View Property', 'deweboo-realestate' ),
			'view_items'         => esc_html__( 'View Properties', 'deweboo-realestate' ),
			'search_items'       => esc_html__( 'Search Properties', 'deweboo-realestate' ),
			'not_found'          => esc_html__( 'No properties found', 'deweboo-realestate' ),
			'not_found_in_trash' => esc_html__( 'No properties found in Trash', 'deweboo-realestate' ),
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'property' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-building',
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author' ),
	) );

	// Property Type Taxonomy
	register_taxonomy( 'property_type', 'property', array(
		'labels'            => array(
			'name'              => esc_html_x( 'Property Types', 'taxonomy general name', 'deweboo-realestate' ),
			'singular_name'     => esc_html_x( 'Property Type', 'taxonomy singular name', 'deweboo-realestate' ),
			'search_items'      => esc_html__( 'Search Property Types', 'deweboo-realestate' ),
			'all_items'         => esc_html__( 'All Property Types', 'deweboo-realestate' ),
			'edit_item'         => esc_html__( 'Edit Property Type', 'deweboo-realestate' ),
			'update_item'       => esc_html__( 'Update Property Type', 'deweboo-realestate' ),
			'add_new_item'      => esc_html__( 'Add New Property Type', 'deweboo-realestate' ),
			'new_item_name'     => esc_html__( 'New Property Type Name', 'deweboo-realestate' ),
		),
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'property-type' ),
	) );

	// Apartment Post Type
	register_post_type( 'apartment', array(
		'labels'             => array(
			'name'               => esc_html_x( 'Apartments', 'post type general name', 'deweboo-realestate' ),
			'singular_name'      => esc_html_x( 'Apartment', 'post type singular name', 'deweboo-realestate' ),
			'menu_name'          => esc_html_x( 'Apartments', 'admin menu', 'deweboo-realestate' ),
			'add_new_item'       => esc_html__( 'Add New Apartment', 'deweboo-realestate' ),
			'edit_item'          => esc_html__( 'Edit Apartment', 'deweboo-realestate' ),
			'new_item'           => esc_html__( 'New Apartment', 'deweboo-realestate' ),
			'view_item'          => esc_html__( 'View Apartment', 'deweboo-realestate' ),
			'view_items'         => esc_html__( 'View Apartments', 'deweboo-realestate' ),
			'search_items'       => esc_html__( 'Search Apartments', 'deweboo-realestate' ),
			'not_found'          => esc_html__( 'No apartments found', 'deweboo-realestate' ),
			'not_found_in_trash' => esc_html__( 'No apartments found in Trash', 'deweboo-realestate' ),
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'apartment' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 6,
		'menu_icon'          => 'dashicons-home',
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author' ),
	) );

	// Apartment Size Taxonomy
	register_taxonomy( 'apartment_size', 'apartment', array(
		'labels'            => array(
			'name'              => esc_html_x( 'Sizes', 'taxonomy general name', 'deweboo-realestate' ),
			'singular_name'     => esc_html_x( 'Size', 'taxonomy singular name', 'deweboo-realestate' ),
			'search_items'      => esc_html__( 'Search Sizes', 'deweboo-realestate' ),
			'all_items'         => esc_html__( 'All Sizes', 'deweboo-realestate' ),
			'edit_item'         => esc_html__( 'Edit Size', 'deweboo-realestate' ),
			'update_item'       => esc_html__( 'Update Size', 'deweboo-realestate' ),
			'add_new_item'      => esc_html__( 'Add New Size', 'deweboo-realestate' ),
			'new_item_name'     => esc_html__( 'New Size', 'deweboo-realestate' ),
		),
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'apartment-size' ),
	) );
}

add_action( 'init', 'deweboo_realestate_register_post_types' );

/**
 * Custom excerpt length.
 */
function deweboo_realestate_excerpt_length( $length ) {
	if ( is_admin() ) {
		return $length;
	}
	return 20; // Display 20 words in excerpts
}

add_filter( 'excerpt_length', 'deweboo_realestate_excerpt_length', 999 );

/**
 * Custom excerpt more text.
 */
function deweboo_realestate_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}
	return ' &hellip;';
}

add_filter( 'excerpt_more', 'deweboo_realestate_excerpt_more' );

/**
 * Register Property details meta box in admin.
 */
function deweboo_realestate_register_property_meta_box() {
	add_meta_box(
		'deweboo-property-details',
		esc_html__( 'Property Details', 'deweboo-realestate' ),
		'deweboo_realestate_render_property_meta_box',
		'property',
		'normal',
		'default'
	);
}

add_action( 'add_meta_boxes', 'deweboo_realestate_register_property_meta_box' );

/**
 * Render Property details fields.
 *
 * @param WP_Post $post Current post object.
 */
function deweboo_realestate_render_property_meta_box( $post ) {
	wp_nonce_field( 'deweboo_realestate_save_property_meta', 'deweboo_property_meta_nonce' );

	$price     = get_post_meta( $post->ID, '_property_price', true );
	$location  = get_post_meta( $post->ID, '_property_location', true );
	$area      = get_post_meta( $post->ID, '_property_area', true );
	$bedrooms  = get_post_meta( $post->ID, '_property_bedrooms', true );
	$bathrooms = get_post_meta( $post->ID, '_property_bathrooms', true );
	$status    = get_post_meta( $post->ID, '_property_status', true );
	?>
	<p>
		<label for="property_price"><strong><?php esc_html_e( 'Price', 'deweboo-realestate' ); ?></strong></label><br>
		<input type="text" id="property_price" name="property_price" value="<?php echo esc_attr( $price ); ?>" class="widefat" placeholder="e.g. $450,000">
	</p>

	<p>
		<label for="property_location"><strong><?php esc_html_e( 'Location', 'deweboo-realestate' ); ?></strong></label><br>
		<input type="text" id="property_location" name="property_location" value="<?php echo esc_attr( $location ); ?>" class="widefat" placeholder="e.g. Kiev, Ukraine">
	</p>

	<p>
		<label for="property_area"><strong><?php esc_html_e( 'Area (m2)', 'deweboo-realestate' ); ?></strong></label><br>
		<input type="text" id="property_area" name="property_area" value="<?php echo esc_attr( $area ); ?>" class="widefat" placeholder="e.g. 120">
	</p>

	<div style="display:flex; gap:12px;">
		<p style="flex:1;">
			<label for="property_bedrooms"><strong><?php esc_html_e( 'Bedrooms', 'deweboo-realestate' ); ?></strong></label><br>
			<input type="number" min="0" id="property_bedrooms" name="property_bedrooms" value="<?php echo esc_attr( $bedrooms ); ?>" class="widefat">
		</p>

		<p style="flex:1;">
			<label for="property_bathrooms"><strong><?php esc_html_e( 'Bathrooms', 'deweboo-realestate' ); ?></strong></label><br>
			<input type="number" min="0" id="property_bathrooms" name="property_bathrooms" value="<?php echo esc_attr( $bathrooms ); ?>" class="widefat">
		</p>
	</div>

	<p>
		<label for="property_status"><strong><?php esc_html_e( 'Status', 'deweboo-realestate' ); ?></strong></label><br>
		<select id="property_status" name="property_status" class="widefat">
			<option value=""><?php esc_html_e( 'Select status', 'deweboo-realestate' ); ?></option>
			<option value="available" <?php selected( $status, 'available' ); ?>><?php esc_html_e( 'Available', 'deweboo-realestate' ); ?></option>
			<option value="sold" <?php selected( $status, 'sold' ); ?>><?php esc_html_e( 'Sold', 'deweboo-realestate' ); ?></option>
			<option value="reserved" <?php selected( $status, 'reserved' ); ?>><?php esc_html_e( 'Reserved', 'deweboo-realestate' ); ?></option>
		</select>
	</p>
	<?php
}

/**
 * Save Property details fields.
 *
 * @param int $post_id Current post id.
 */
function deweboo_realestate_save_property_meta_box( $post_id ) {
	if ( ! isset( $_POST['deweboo_property_meta_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['deweboo_property_meta_nonce'], 'deweboo_realestate_save_property_meta' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! isset( $_POST['post_type'] ) || 'property' !== $_POST['post_type'] ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = array(
		'_property_price'     => isset( $_POST['property_price'] ) ? sanitize_text_field( wp_unslash( $_POST['property_price'] ) ) : '',
		'_property_location'  => isset( $_POST['property_location'] ) ? sanitize_text_field( wp_unslash( $_POST['property_location'] ) ) : '',
		'_property_area'      => isset( $_POST['property_area'] ) ? sanitize_text_field( wp_unslash( $_POST['property_area'] ) ) : '',
		'_property_bedrooms'  => isset( $_POST['property_bedrooms'] ) ? absint( $_POST['property_bedrooms'] ) : '',
		'_property_bathrooms' => isset( $_POST['property_bathrooms'] ) ? absint( $_POST['property_bathrooms'] ) : '',
		'_property_status'    => isset( $_POST['property_status'] ) ? sanitize_key( wp_unslash( $_POST['property_status'] ) ) : '',
	);

	foreach ( $fields as $meta_key => $meta_value ) {
		if ( '' === (string) $meta_value ) {
			delete_post_meta( $post_id, $meta_key );
		} else {
			update_post_meta( $post_id, $meta_key, $meta_value );
		}
	}
}

add_action( 'save_post_property', 'deweboo_realestate_save_property_meta_box' );

function deweboo_realestate_wp_footer() {
	?>
	<script>
		(function() {
			function hidePreloader() {
				try {
					document.body.classList.add('page-loaded');
					var pre = document.querySelector('.preloader');
					if (pre) {
						pre.classList.add('preloader-hidden');
					}
				} catch (e) {
					// Fail silently; never block page.
				}
			}

			// Init WOW animations if library is present
			document.addEventListener('DOMContentLoaded', function() {
				if (typeof WOW !== 'undefined') {
					new WOW().init();
				}
				hidePreloader();
			});

			window.addEventListener('load', hidePreloader);
			setTimeout(hidePreloader, 3000);
		})();
	</script>
	<?php
}

add_action( 'wp_footer', 'deweboo_realestate_wp_footer' );

/**
 * Add custom body classes.
 */
function deweboo_realestate_body_classes( $classes ) {
	// Add class for when sidebar is active.
	if ( is_active_sidebar( 'primary-sidebar' ) ) {
		$classes[] = 'has-sidebar';
	}

	return $classes;
}

add_filter( 'body_class', 'deweboo_realestate_body_classes' );

/**
 * Force key page slugs to their canonical templates.
 */
function deweboo_realestate_force_core_page_templates( $template ) {
	$template_map = array(
		'about'      => 'page-about.php',
		'about-us'   => 'page-about.php',
		'aboutus'    => 'page-about.php',
		'properties' => 'page-properties.php',
		'property'   => 'page-properties.php',
		'news'       => 'page-news.php',
		'blog'       => 'page-news.php',
		'contact-us' => 'page-contact.php',
		'contact'    => 'page-contact.php',
	);

	foreach ( $template_map as $slug => $template_file ) {
		if ( is_page( $slug ) ) {
			$template_path = get_template_directory() . '/' . $template_file;
			if ( file_exists( $template_path ) ) {
				return $template_path;
			}
		}
	}

	if ( is_page() ) {
		$queried = get_queried_object();
		if ( $queried instanceof WP_Post && ! empty( $queried->post_name ) ) {
			$page_slug = sanitize_title( $queried->post_name );
			if ( false !== strpos( $page_slug, 'about' ) ) {
				$about_template = get_template_directory() . '/page-about.php';
				if ( file_exists( $about_template ) ) {
					return $about_template;
				}
			}
		}
	}

	return $template;
}

add_filter( 'template_include', 'deweboo_realestate_force_core_page_templates', 99 );

/**
 * Redirect duplicate home slugs to the canonical front page.
 */
function deweboo_realestate_redirect_duplicate_home_pages() {
	if ( is_page( array( 'home', 'homepage', 'hompark' ) ) && ! is_front_page() ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}

add_action( 'template_redirect', 'deweboo_realestate_redirect_duplicate_home_pages' );

/**
 * Redirect blog slug to the canonical news page.
 */
function deweboo_realestate_redirect_blog_to_news() {
	if ( is_page( 'blog' ) ) {
		wp_safe_redirect( home_url( '/news/' ), 301 );
		exit;
	}
}

add_action( 'template_redirect', 'deweboo_realestate_redirect_blog_to_news' );

/**
 * Build an SEO-friendly meta description per request.
 *
 * @return string
 */
function deweboo_realestate_get_meta_description() {
	$site_name = get_bloginfo( 'name' );

	if ( is_singular() ) {
		$post_id = get_queried_object_id();
		if ( $post_id ) {
			$excerpt = trim( wp_strip_all_tags( get_the_excerpt( $post_id ) ) );
			if ( '' !== $excerpt ) {
				return wp_trim_words( $excerpt, 30, '...' );
			}

			$content = trim( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ) );
			if ( '' !== $content ) {
				return wp_trim_words( $content, 30, '...' );
			}
		}
	}

	if ( is_post_type_archive( 'property' ) ) {
		return __( 'Browse properties for sale with verified details, transparent pricing, and expert support from Dreamasa Homes.', 'deweboo-realestate' );
	}

	if ( is_post_type_archive( 'apartment' ) ) {
		return __( 'Explore apartments for sale with floor plans, pricing insights, and location advantages.', 'deweboo-realestate' );
	}

	if ( is_tax() || is_category() || is_tag() ) {
		$term_text = trim( wp_strip_all_tags( term_description() ) );
		if ( '' !== $term_text ) {
			return wp_trim_words( $term_text, 30, '...' );
		}

		return __( 'Discover real estate listings and market updates filtered by your selected category.', 'deweboo-realestate' );
	}

	if ( is_search() ) {
		return __( 'Search Dreamasa Homes listings, apartments, and real estate news to find your next property.', 'deweboo-realestate' );
	}

	if ( is_404() ) {
		return __( 'The requested page was not found. Explore available properties and contact our sales team for assistance.', 'deweboo-realestate' );
	}

	return sprintf(
		/* translators: %s: site name */
		__( '%s is a real estate sales website featuring apartments, villas, and investment properties with trusted buying guidance.', 'deweboo-realestate' ),
		$site_name
	);
}

/**
 * Print baseline SEO tags unless a dedicated SEO plugin is active.
 */
function deweboo_realestate_output_seo_meta() {
	if ( is_admin() ) {
		return;
	}

	if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) ) {
		return;
	}

	$meta_description = deweboo_realestate_get_meta_description();
	$title            = wp_get_document_title();
	$current_url      = is_singular() ? get_permalink() : home_url( add_query_arg( array(), $GLOBALS['wp']->request ) );
	$og_type          = is_singular() ? 'article' : 'website';

	echo '<meta name="description" content="' . esc_attr( $meta_description ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $meta_description ) . '">' . "\n";
	echo '<meta property="og:type" content="' . esc_attr( $og_type ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $current_url ) . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta name="twitter:description" content="' . esc_attr( $meta_description ) . '">' . "\n";

	if ( is_singular() && has_post_thumbnail() ) {
		$thumbnail = get_the_post_thumbnail_url( get_queried_object_id(), 'full' );
		if ( $thumbnail ) {
			echo '<meta property="og:image" content="' . esc_url( $thumbnail ) . '">' . "\n";
			echo '<meta name="twitter:image" content="' . esc_url( $thumbnail ) . '">' . "\n";
		}
	}

	$schema = array(
		'@context' => 'https://schema.org',
		'@type'    => 'RealEstateAgent',
		'name'     => get_bloginfo( 'name' ),
		'url'      => home_url( '/' ),
		'email'    => get_option( 'admin_email' ),
	);

	$website_schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'WebSite',
		'name'            => get_bloginfo( 'name' ),
		'url'             => home_url( '/' ),
		'potentialAction' => array(
			'@type'       => 'SearchAction',
			'target'      => home_url( '/?s={search_term_string}' ),
			'query-input' => 'required name=search_term_string',
		),
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>' . "\n";
	echo '<script type="application/ld+json">' . wp_json_encode( $website_schema ) . '</script>' . "\n";
}

add_action( 'wp_head', 'deweboo_realestate_output_seo_meta', 2 );

/**
 * Load existing frontend styles into Gutenberg editor.
 */
add_action( 'after_setup_theme', 'deweboo_realestate_add_editor_style' );
function deweboo_realestate_add_editor_style() {
	// Your theme already uses CSS selectors/classes heavily, so reuse the same stylesheet in the editor.
	add_editor_style( 'css/style.css' );
}

/**
 * Register content-only locked block patterns.
 *
 * These patterns are designed to be inserted into your classic theme pages where templates output
 * the rendered Gutenberg content via deweboo_realestate_get_builder_content().
 */
add_action( 'init', 'deweboo_realestate_register_locked_patterns' );
function deweboo_realestate_register_locked_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	$theme_uri = get_stylesheet_directory_uri();

	$about_gallery = array(
		$theme_uri . '/images/blog01.webp',
		$theme_uri . '/images/blog02.webp',
		$theme_uri . '/images/blog03.webp',
		$theme_uri . '/images/blog04.webp',
	);
	$about_video = $theme_uri . '/videos/video01.mp4';

	register_block_pattern(
		'deweboo-realestate/about-inner-locked',
		array(
			'title'       => __( 'About Section (Locked Layout)', 'deweboo-realestate' ),
			'categories'  => array( 'text' ),
			'description' => __( 'Matches `page-about.php` inner markup; only content is editable.', 'deweboo-realestate' ),
			'content'     => sprintf(
				'<!-- wp:group {"className":"row","lock":{"move":false,"remove":true}} -->
					<!-- wp:group {"className":"col-12","lock":{"move":false,"remove":true}} -->
						<!-- wp:html {"lock":{"move":false,"remove":true}} -->
							<h2><span>Dreamasa</span> Homes</h2>
						<!-- /wp:html -->
						<!-- wp:html {"lock":{"move":false,"remove":true}} -->
							<h5>By aiming to take the life quality to an upper level with the whole realized Projects of luxury.</h5>
						<!-- /wp:html -->
					<!-- /wp:group -->

					<!-- wp:group {"className":"col-lg-7","lock":{"move":false,"remove":true}} -->
						<!-- wp:paragraph {"lock":{"move":false,"remove":true}} -->Dreamasa Homes helps buyers discover apartments, villas, and investment properties in high-demand areas. Our team verifies legal documentation, compares pricing trends, and guides each client from first viewing to successful closing.<!-- /wp:paragraph -->
					<!-- /wp:group -->

					<!-- wp:group {"className":"col-lg-5","lock":{"move":false,"remove":true}} -->
						<!-- wp:paragraph {"lock":{"move":false,"remove":true}} -->Whether you are purchasing your first home or expanding your portfolio, we focus on location value, quality construction, and long-term return on investment.<!-- /wp:paragraph -->
					<!-- /wp:group -->

					<!-- wp:group {"className":"col-12","lock":{"move":false,"remove":true}} -->
						<!-- wp:group {"className":"gallery-container","lock":{"move":false,"remove":true}} -->
							<!-- wp:group {"className":"swiper-wrapper","lock":{"move":false,"remove":true}} -->
								<!-- wp:image {"className":"swiper-slide","sizeSlug":"full","lock":{"move":false,"remove":true}} -->
									<figure class="wp-block-image swiper-slide size-full"><img src="%1$s" alt="Gallery image"/></figure>
								<!-- /wp:image -->
								<!-- wp:image {"className":"swiper-slide","sizeSlug":"full","lock":{"move":false,"remove":true}} -->
									<figure class="wp-block-image swiper-slide size-full"><img src="%2$s" alt="Gallery image"/></figure>
								<!-- /wp:image -->
								<!-- wp:image {"className":"swiper-slide","sizeSlug":"full","lock":{"move":false,"remove":true}} -->
									<figure class="wp-block-image swiper-slide size-full"><img src="%3$s" alt="Gallery image"/></figure>
								<!-- /wp:image -->
								<!-- wp:image {"className":"swiper-slide","sizeSlug":"full","lock":{"move":false,"remove":true}} -->
									<figure class="wp-block-image swiper-slide size-full"><img src="%4$s" alt="Gallery image"/></figure>
								<!-- /wp:image -->
							<!-- /wp:group -->
							<!-- wp:html {"lock":{"move":false,"remove":true}} --><div class="gallery-pagination"></div><!-- /wp:html -->
						<!-- /wp:group -->

						<!-- wp:html {"lock":{"move":false,"remove":true}} --><h4>Take the life quality to an upper level</h4><!-- /wp:html -->
						<!-- wp:paragraph {"lock":{"move":false,"remove":true}} -->Our approach combines local market knowledge with data-driven property analysis, so every client receives accurate recommendations and confident negotiation support.<!-- /wp:paragraph -->
						<!-- wp:html {"lock":{"move":false,"remove":true}} --><br /><!-- /wp:html -->
					<!-- /wp:group -->

					<!-- wp:group {"className":"col-md-6","lock":{"move":false,"remove":true}} -->
						<!-- wp:html {"lock":{"move":false,"remove":true}} --><h6>Property Specifications</h6><!-- /wp:html -->
						<!-- wp:list {"lock":{"move":false,"remove":true}} -->
							<ul>
								<li>Verified ownership and legal documentation for listed properties.</li>
								<li>Detailed floor plans, area metrics, and room distribution.</li>
								<li>Transparent pricing details with no hidden charges.</li>
								<li>Construction quality checks and handover standards.</li>
								<li>Neighborhood analysis including schools, transit, and amenities.</li>
								<li>Flexible financing guidance for eligible buyers.</li>
							</ul>
						<!-- /wp:list -->
					<!-- /wp:group -->

					<!-- wp:group {"className":"col-md-6","lock":{"move":false,"remove":true}} -->
						<!-- wp:html {"lock":{"move":false,"remove":true}} --><h6>Property Benefits</h6><!-- /wp:html -->
						<!-- wp:list {"lock":{"move":false,"remove":true}} -->
							<ul>
								<li>Strong resale potential in high-growth real estate zones.</li>
								<li>Professional support for negotiation and offer strategy.</li>
								<li>Curated listings that match buyer goals and budget.</li>
								<li>Faster shortlisting with complete property comparisons.</li>
								<li>Guidance from inquiry, viewing, and paperwork to closing.</li>
								<li>After-sales assistance for a smooth move-in experience.</li>
							</ul>
						<!-- /wp:list -->
					<!-- /wp:group -->

					<!-- wp:group {"className":"col-lg-9","lock":{"move":false,"remove":true}} -->
						<!-- wp:html {"lock":{"move":false,"remove":true}} --><div class="video-content"><video src="%5$s" controls muted></video></div><!-- /wp:html -->
					<!-- /wp:group -->

					<!-- wp:group {"className":"col-12","lock":{"move":false,"remove":true}} -->
						<!-- wp:html {"lock":{"move":false,"remove":true}} -->
							<blockquote>
								<p>Our goal is simple: help every buyer find the right home at the right value with full confidence.</p>
								<strong>Dreamasa Homes Lead Engineer</strong>
							</blockquote>
							<p>We work with trusted developers, private sellers, and legal partners to provide reliable property choices. Every listing is reviewed for market positioning so buyers can make informed decisions quickly.</p>
							<p>If you are searching for apartments, houses, or investment opportunities, our advisors are ready to recommend properties that align with your plan and timeline.</p>
						<!-- /wp:html -->
					<!-- /wp:group -->
				<!-- /wp:group -->',
				$about_gallery[0],
				$about_gallery[1],
				$about_gallery[2],
				$about_gallery[3],
				$about_video
			),
		)
	);

	// News: only replaces the intro paragraph inside page-news.php.
	register_block_pattern(
		'deweboo-realestate/news-intro-locked',
		array(
			'title'       => __( 'News Intro (Locked)', 'deweboo-realestate' ),
			'categories'  => array( 'text' ),
			'description' => __( 'Replaces the intro paragraph in `page-news.php`.', 'deweboo-realestate' ),
			'content'     => '<!-- wp:paragraph {"lock":{"move":false,"remove":true}} -->Stay informed with real estate market trends, buying guides, and property investment updates from Dreamasa Homes.<!-- /wp:paragraph -->',
		)
	);

	// Contact: printed inside `.contact-form` in page-contact.php.
	register_block_pattern(
		'deweboo-realestate/contact-form-locked',
		array(
			'title'       => __( 'Contact Form (Locked)', 'deweboo-realestate' ),
			'categories'  => array( 'text' ),
			'description' => __( 'Renders text + a Contact Form 7 shortcode inside your contact form wrapper.', 'deweboo-realestate' ),
			'content'     => '<!-- wp:paragraph {"lock":{"move":false,"remove":true}} -->Send us your message and we will get back to you soon.<!-- /wp:paragraph --><!-- wp:shortcode {"lock":{"move":false,"remove":true}} -->[contact-form-7 title="Contact form 1"]<!-- /wp:shortcode -->',
		)
	);
}

?>
