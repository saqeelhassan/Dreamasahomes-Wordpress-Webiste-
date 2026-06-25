<?php
/**
 * Theme Setup - Auto Create Pages and Configure WordPress
 * 
 * This file handles automatic setup when the theme is activated.
 * It creates all necessary pages, menus, and configures WordPress settings.
 * 
 * @package Deweboo Real-Estate
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Trigger theme setup on theme activation
 */
function deweboo_theme_activation_setup() {
	if ( 'yes' === get_option( 'deweboo_theme_setup_completed', 'no' ) ) {
		return;
	}

	deweboo_create_pages();
	deweboo_create_menus();
	deweboo_configure_reading_settings();
	deweboo_create_categories();

	update_option( 'deweboo_theme_setup_completed', 'yes' );
	
	// Flush rewrite rules
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'deweboo_theme_activation_setup' );

/**
 * Create all necessary pages for the theme
 */
function deweboo_create_pages() {
	$pages = array(
		array(
			'post_title'   => 'Home',
			'post_name'    => 'home',
			'post_content' => '[deweboo_hero_section]',
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'meta_input'   => array(
				'_wp_page_template' => 'page-home.php',
			),
		),
		array(
			'post_title'   => 'About Us',
			'post_name'    => 'about-us',
			'post_content' => '[deweboo_about_section]',
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'meta_input'   => array(
				'_wp_page_template' => 'page-about.php',
			),
		),
		array(
			'post_title'   => 'Contact Us',
			'post_name'    => 'contact-us',
			'post_content' => '[deweboo_contact_form]',
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'meta_input'   => array(
				'_wp_page_template' => 'page-contact.php',
			),
		),
		array(
			'post_title'   => 'Properties',
			'post_name'    => 'properties',
			'post_content' => 'Browse our available properties',
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'meta_input'   => array(
				'_wp_page_template' => 'page-properties.php',
			),
		),
		array(
			'post_title'   => 'Blog',
			'post_name'    => 'blog',
			'post_content' => 'Explore our latest articles and insights about real estate, property investments, and market trends.',
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'meta_input'   => array(
				'_wp_page_template' => 'page-blog.php',
			),
		),
		array(
			'post_title'   => 'News',
			'post_name'    => 'news',
			'post_content' => 'Stay updated with the latest news and insights about real estate market trends and property developments.',
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'meta_input'   => array(
				'_wp_page_template' => 'page-news.php',
			),
		),
		array(
			'post_title'   => 'Facilities',
			'post_name'    => 'facilities',
			'post_content' => 'Discover all the facilities and amenities we offer. Our properties are equipped with premium features designed for comfortable living.',
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'meta_input'   => array(
				'_wp_page_template' => 'page-facilities.php',
			),
		),
		array(
			'post_title'   => 'FAQ',
			'post_name'    => 'faq',
			'post_content' => 'Find answers to our most frequently asked questions about real estate, property investments, and our services.',
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'meta_input'   => array(
				'_wp_page_template' => 'page-faq.php',
			),
		),
		array(
			'post_title'   => 'Privacy Policy',
			'post_name'    => 'privacy-policy',
			'post_content' => 'Your privacy policy content here.',
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'meta_input'   => array(
				'_wp_page_template' => 'default',
			),
		),
		array(
			'post_title'   => 'Terms & Conditions',
			'post_name'    => 'terms',
			'post_content' => 'Your terms and conditions content here.',
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'meta_input'   => array(
				'_wp_page_template' => 'default',
			),
		),
	);

	foreach ( $pages as $page ) {
		// Check by slug first, then by assigned page template to avoid duplicates.
		$existing_page = get_page_by_path( $page['post_name'], OBJECT, 'page' );

		if ( ! $existing_page && ! empty( $page['meta_input']['_wp_page_template'] ) && 'default' !== $page['meta_input']['_wp_page_template'] ) {
			$pages_with_template = get_posts(
				array(
					'post_type'      => 'page',
					'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
					'posts_per_page' => 1,
					'fields'         => 'ids',
					'meta_key'       => '_wp_page_template',
					'meta_value'     => $page['meta_input']['_wp_page_template'],
				)
			);

			if ( ! empty( $pages_with_template ) ) {
				$existing_page = get_post( (int) $pages_with_template[0] );
			}
		}
		
		if ( ! $existing_page ) {
			wp_insert_post( $page );
		} elseif ( ! empty( $page['meta_input']['_wp_page_template'] ) ) {
			update_post_meta( $existing_page->ID, '_wp_page_template', $page['meta_input']['_wp_page_template'] );
		}
	}
}

/**
 * Create WordPress navigation menus
 */
function deweboo_create_menus() {
	// Check if menus already exist
	$primary_menu_exists = term_exists( 'Primary Menu', 'nav_menu' );
	$footer_menu_exists  = term_exists( 'Footer Menu', 'nav_menu' );
	$secondary_menu_exists = term_exists( 'Secondary Menu', 'nav_menu' );

	// Create Primary Menu if it doesn't exist
	if ( ! $primary_menu_exists ) {
		$primary_menu_id = wp_create_nav_menu( 'Primary Menu' );

		// Add items to Primary Menu
		if ( $primary_menu_id && ! is_wp_error( $primary_menu_id ) ) {
			$home_page = get_page_by_path( 'home' );
			$about_page = get_page_by_path( 'about-us' );
			$properties_page = get_page_by_path( 'properties' );
			$news_page = get_page_by_path( 'news' );
			$contact_page = get_page_by_path( 'contact-us' );

			// Add home link
			if ( $home_page ) {
				wp_update_nav_menu_item(
					$primary_menu_id,
					0,
					array(
						'menu-item-title'  => 'Home',
						'menu-item-object-id' => $home_page->ID,
						'menu-item-object'    => 'page',
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-position'  => 1,
					)
				);
			}

			// Add about link
			if ( $about_page ) {
				wp_update_nav_menu_item(
					$primary_menu_id,
					0,
					array(
						'menu-item-title'  => 'About',
						'menu-item-object-id' => $about_page->ID,
						'menu-item-object'    => 'page',
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-position'  => 2,
					)
				);
			}

			// Add properties link
			if ( $properties_page ) {
				wp_update_nav_menu_item(
					$primary_menu_id,
					0,
					array(
						'menu-item-title'  => 'Properties',
						'menu-item-object-id' => $properties_page->ID,
						'menu-item-object'    => 'page',
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-position'  => 3,
					)
				);
			}

			// Add news link
			if ( $news_page ) {
				wp_update_nav_menu_item(
					$primary_menu_id,
					0,
					array(
						'menu-item-title'  => 'News',
						'menu-item-object-id' => $news_page->ID,
						'menu-item-object'    => 'page',
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-position'  => 4,
					)
				);
			}

			// Add contact link
			if ( $contact_page ) {
				wp_update_nav_menu_item(
					$primary_menu_id,
					0,
					array(
						'menu-item-title'  => 'Contact',
						'menu-item-object-id' => $contact_page->ID,
						'menu-item-object'    => 'page',
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-position'  => 5,
					)
				);
			}

			// Assign menu to location
			$menu_locations = get_theme_mod( 'nav_menu_locations', array() );
			$menu_locations['primary'] = $primary_menu_id;
			set_theme_mod( 'nav_menu_locations', $menu_locations );
		}
	}

	// Create Footer Menu if it doesn't exist
	if ( ! $footer_menu_exists ) {
		$footer_menu_id = wp_create_nav_menu( 'Footer Menu' );

		if ( $footer_menu_id && ! is_wp_error( $footer_menu_id ) ) {
			$privacy_page = get_page_by_path( 'privacy-policy' );
			$terms_page = get_page_by_path( 'terms' );

			if ( $privacy_page ) {
				wp_update_nav_menu_item(
					$footer_menu_id,
					0,
					array(
						'menu-item-title'  => 'Privacy Policy',
						'menu-item-object-id' => $privacy_page->ID,
						'menu-item-object'    => 'page',
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-position'  => 1,
					)
				);
			}

			if ( $terms_page ) {
				wp_update_nav_menu_item(
					$footer_menu_id,
					0,
					array(
						'menu-item-title'  => 'Terms & Conditions',
						'menu-item-object-id' => $terms_page->ID,
						'menu-item-object'    => 'page',
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-position'  => 2,
					)
				);
			}

			// Assign menu to location
			$menu_locations = get_theme_mod( 'nav_menu_locations', array() );
			$menu_locations['footer'] = $footer_menu_id;
			set_theme_mod( 'nav_menu_locations', $menu_locations );
		}
	}

	// Create Secondary Menu if it doesn't exist
	if ( ! $secondary_menu_exists ) {
		$secondary_menu_id = wp_create_nav_menu( 'Secondary Menu' );

		if ( $secondary_menu_id && ! is_wp_error( $secondary_menu_id ) ) {
			// Assign menu to location
			$menu_locations = get_theme_mod( 'nav_menu_locations', array() );
			$menu_locations['secondary'] = $secondary_menu_id;
			set_theme_mod( 'nav_menu_locations', $menu_locations );
		}
	}
}

/**
 * Configure WordPress reading settings
 */
function deweboo_configure_reading_settings() {
	$home_page = get_page_by_path( 'home' );
	$blog_page = get_page_by_path( 'blog' );

	if ( $home_page ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_page->ID );
	}

	if ( $blog_page ) {
		update_option( 'page_for_posts', $blog_page->ID );
	}
}

/**
 * Create categories for blog posts
 */
function deweboo_create_categories() {
	$categories = array(
		array(
			'cat_name'             => 'Real Estate',
			'category_description' => 'Real Estate Articles and News',
			'category_nicename'    => 'real-estate',
		),
		array(
			'cat_name'             => 'Property Tips',
			'category_description' => 'Tips and Advice for Property Buyers',
			'category_nicename'    => 'property-tips',
		),
		array(
			'cat_name'             => 'Market Updates',
			'category_description' => 'Latest Real Estate Market Updates',
			'category_nicename'    => 'market-updates',
		),
		array(
			'cat_name'             => 'News',
			'category_description' => 'Latest News from our Company',
			'category_nicename'    => 'news',
		),
	);

	foreach ( $categories as $category ) {
		$existing = term_exists( $category['category_nicename'], 'category' );
		
		if ( ! $existing ) {
			wp_insert_term(
				$category['cat_name'],
				'category',
				array(
					'slug'        => $category['category_nicename'],
					'description' => $category['category_description'],
				)
			);
		}
	}
}

/**
 * Add custom theme options using Theme Customizer
 */
function deweboo_customize_register( $wp_customize ) {
	// Company Information Section
	$wp_customize->add_section(
		'deweboo_company_section',
		array(
			'title'       => __( 'Company Information', 'DREAMASAHOMES' ),
			'priority'    => 20,
			'description' => __( 'Configure your company details', 'DREAMASAHOMES' ),
		)
	);

	// Company Phone
	$wp_customize->add_setting(
		'deweboo_company_phone',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'deweboo_company_phone',
		array(
			'label'       => __( 'Company Phone', 'DREAMASAHOMES' ),
			'section'     => 'deweboo_company_section',
			'type'        => 'text',
		)
	);

	// Company Email
	$wp_customize->add_setting(
		'deweboo_company_email',
		array(
			'default'           => get_option( 'admin_email' ),
			'sanitize_callback' => 'sanitize_email',
		)
	);

	$wp_customize->add_control(
		'deweboo_company_email',
		array(
			'label'       => __( 'Company Email', 'DREAMASAHOMES' ),
			'section'     => 'deweboo_company_section',
			'type'        => 'email',
		)
	);

	// Company Address
	$wp_customize->add_setting(
		'deweboo_company_address',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'deweboo_company_address',
		array(
			'label'       => __( 'Company Address', 'DREAMASAHOMES' ),
			'section'     => 'deweboo_company_section',
			'type'        => 'textarea',
		)
	);

	// Hero Section Settings
	$wp_customize->add_section(
		'deweboo_hero_section',
		array(
			'title'       => __( 'Hero Section', 'DREAMASAHOMES' ),
			'priority'    => 21,
			'description' => __( 'Configure hero section settings', 'DREAMASAHOMES' ),
		)
	);

	// Hero Title
	$wp_customize->add_setting(
		'deweboo_hero_title',
		array(
			'default'           => 'Welcome to Our Properties',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'deweboo_hero_title',
		array(
			'label'       => __( 'Hero Title', 'DREAMASAHOMES' ),
			'section'     => 'deweboo_hero_section',
			'type'        => 'text',
		)
	);

	// Hero Subtitle
	$wp_customize->add_setting(
		'deweboo_hero_subtitle',
		array(
			'default'           => 'Find your perfect home',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'deweboo_hero_subtitle',
		array(
			'label'       => __( 'Hero Subtitle', 'DREAMASAHOMES' ),
			'section'     => 'deweboo_hero_section',
			'type'        => 'text',
		)
	);
}
add_action( 'customize_register', 'deweboo_customize_register' );

/**
 * Helper function - Get company phone
 */
function deweboo_get_company_phone() {
	return get_theme_mod( 'deweboo_company_phone', '' );
}

/**
 * Helper function - Get company email
 */
function deweboo_get_company_email() {
	return get_theme_mod( 'deweboo_company_email', get_option( 'admin_email' ) );
}

/**
 * Helper function - Get company address
 */
function deweboo_get_company_address() {
	return get_theme_mod( 'deweboo_company_address', '' );
}

/**
 * Helper function - Get hero title
 */
function deweboo_get_hero_title() {
	return get_theme_mod( 'deweboo_hero_title', 'Welcome to Our Properties' );
}

/**
 * Helper function - Get hero subtitle
 */
function deweboo_get_hero_subtitle() {
	return get_theme_mod( 'deweboo_hero_subtitle', 'Find your perfect home' );
}
