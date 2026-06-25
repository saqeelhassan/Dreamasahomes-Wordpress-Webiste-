<?php
/**
 * Deweboo Real-Estate Theme Setup WP-CLI Command
 * 
 * Add this file to wp-content/mu-plugins/ or wp-content/plugins/DREAMASAHOMES-cli/
 * 
 * Usage:
 *   wp DREAMASAHOMES-setup all              # Run full setup
 *   wp DREAMASAHOMES-setup pages            # Create pages only
 *   wp DREAMASAHOMES-setup menus            # Create menus only
 *   wp DREAMASAHOMES-setup categories       # Create categories only
 *   wp DREAMASAHOMES-setup status           # Check setup status
 *   wp DREAMASAHOMES-setup reset            # Remove all created items (careful!)
 * 
 * @package Deweboo Real-Estate_WP_CLI
 */

if ( ! defined( 'WP_CLI' ) ) {
	return;
}

class Deweboo_RealEstate_Setup_Command {

	/**
	 * Run full Deweboo Real-Estate theme setup
	 *
	 * [<type>]
	 * : Setup type: all, pages, menus, categories
	 * ---
	 * default: all
	 * ---
	 *
	 * ## EXAMPLES
	 *
	 *     wp DREAMASAHOMES-setup all
	 *     wp DREAMASAHOMES-setup pages
	 *     wp DREAMASAHOMES-setup menus
	 *
	 * @when after_wp_load
	 */
	public function __invoke( $args = array() ) {
		$type = isset( $args[0] ) ? $args[0] : 'all';

		switch ( $type ) {
			case 'pages':
				$this->create_pages();
				break;
			case 'menus':
				$this->create_menus();
				break;
			case 'categories':
				$this->create_categories();
				break;
			case 'status':
				$this->show_status();
				break;
			case 'reset':
				$this->reset_setup();
				break;
			case 'all':
			default:
				$this->create_pages();
				$this->create_menus();
				$this->configure_reading();
				$this->create_categories();
				WP_CLI::success( 'Deweboo Real-Estate theme setup completed!' );
				break;
		}
	}

	/**
	 * Create all necessary pages
	 */
	private function create_pages() {
		$pages = array(
			array(
				'post_title'   => 'Home',
				'post_name'    => 'home',
				'post_content' => '[deweboo_hero_section]',
			),
			array(
				'post_title'   => 'About Us',
				'post_name'    => 'about-us',
				'post_content' => '[deweboo_about_section]',
			),
			array(
				'post_title'   => 'Contact Us',
				'post_name'    => 'contact-us',
				'post_content' => '[deweboo_contact_form]',
			),
			array(
				'post_title'   => 'Properties',
				'post_name'    => 'properties',
				'post_content' => 'Browse our available properties',
			),
			array(
				'post_title'   => 'Blog',
				'post_name'    => 'blog',
				'post_content' => '[deweboo_latest_posts]',
			),
			array(
				'post_title'   => 'News',
				'post_name'    => 'news',
				'post_content' => '[deweboo_news_grid]',
			),
			array(
				'post_title'   => 'Facilities',
				'post_name'    => 'facilities',
				'post_content' => '[deweboo_facilities_section]',
			),
			array(
				'post_title'   => 'FAQ',
				'post_name'    => 'faq',
				'post_content' => '[deweboo_faq_section]',
			),
			array(
				'post_title'   => 'Privacy Policy',
				'post_name'    => 'privacy-policy',
				'post_content' => 'Your privacy policy content here.',
			),
			array(
				'post_title'   => 'Terms & Conditions',
				'post_name'    => 'terms',
				'post_content' => 'Your terms and conditions content here.',
			),
		);

		WP_CLI::line( 'Creating pages...' );

		foreach ( $pages as $page ) {
			if ( ! get_page_by_path( $page['post_name'] ) ) {
				wp_insert_post( array(
					'post_title'   => $page['post_title'],
					'post_name'    => $page['post_name'],
					'post_content' => $page['post_content'],
					'post_type'    => 'page',
					'post_status'  => 'publish',
				) );
				WP_CLI::line( '  ✓ Created: ' . $page['post_title'] );
			} else {
				WP_CLI::line( '  ~ Already exists: ' . $page['post_title'] );
			}
		}

		WP_CLI::success( 'Pages setup complete!' );
	}

	/**
	 * Create navigation menus
	 */
	private function create_menus() {
		WP_CLI::line( 'Creating menus...' );

		// Primary Menu
		if ( ! term_exists( 'Primary Menu', 'nav_menu' ) ) {
			$primary_menu_id = wp_create_nav_menu( 'Primary Menu' );

			if ( $primary_menu_id && ! is_wp_error( $primary_menu_id ) ) {
				$pages = array(
					array( 'slug' => 'home', 'title' => 'Home' ),
					array( 'slug' => 'about-us', 'title' => 'About' ),
					array( 'slug' => 'properties', 'title' => 'Properties' ),
					array( 'slug' => 'news', 'title' => 'News' ),
					array( 'slug' => 'contact-us', 'title' => 'Contact' ),
				);

				foreach ( $pages as $page ) {
					$page_obj = get_page_by_path( $page['slug'] );
					if ( $page_obj ) {
						wp_update_nav_menu_item(
							$primary_menu_id,
							0,
							array(
								'menu-item-title'      => $page['title'],
								'menu-item-object-id'  => $page_obj->ID,
								'menu-item-object'     => 'page',
								'menu-item-type'       => 'post_type',
								'menu-item-status'     => 'publish',
							)
						);
					}
				}

				$menu_locations = get_theme_mod( 'nav_menu_locations', array() );
				$menu_locations['primary'] = $primary_menu_id;
				set_theme_mod( 'nav_menu_locations', $menu_locations );

				WP_CLI::line( '  ✓ Created: Primary Menu' );
			}
		} else {
			WP_CLI::line( '  ~ Already exists: Primary Menu' );
		}

		// Footer Menu
		if ( ! term_exists( 'Footer Menu', 'nav_menu' ) ) {
			$footer_menu_id = wp_create_nav_menu( 'Footer Menu' );

			if ( $footer_menu_id && ! is_wp_error( $footer_menu_id ) ) {
				$pages = array(
					array( 'slug' => 'privacy-policy', 'title' => 'Privacy Policy' ),
					array( 'slug' => 'terms', 'title' => 'Terms & Conditions' ),
				);

				foreach ( $pages as $page ) {
					$page_obj = get_page_by_path( $page['slug'] );
					if ( $page_obj ) {
						wp_update_nav_menu_item(
							$footer_menu_id,
							0,
							array(
								'menu-item-title'      => $page['title'],
								'menu-item-object-id'  => $page_obj->ID,
								'menu-item-object'     => 'page',
								'menu-item-type'       => 'post_type',
								'menu-item-status'     => 'publish',
							)
						);
					}
				}

				$menu_locations = get_theme_mod( 'nav_menu_locations', array() );
				$menu_locations['footer'] = $footer_menu_id;
				set_theme_mod( 'nav_menu_locations', $menu_locations );

				WP_CLI::line( '  ✓ Created: Footer Menu' );
			}
		} else {
			WP_CLI::line( '  ~ Already exists: Footer Menu' );
		}

		// Secondary Menu
		if ( ! term_exists( 'Secondary Menu', 'nav_menu' ) ) {
			$secondary_menu_id = wp_create_nav_menu( 'Secondary Menu' );
			
			if ( $secondary_menu_id && ! is_wp_error( $secondary_menu_id ) ) {
				$menu_locations = get_theme_mod( 'nav_menu_locations', array() );
				$menu_locations['secondary'] = $secondary_menu_id;
				set_theme_mod( 'nav_menu_locations', $menu_locations );

				WP_CLI::line( '  ✓ Created: Secondary Menu' );
			}
		} else {
			WP_CLI::line( '  ~ Already exists: Secondary Menu' );
		}

		WP_CLI::success( 'Menus setup complete!' );
	}

	/**
	 * Configure WordPress reading settings
	 */
	private function configure_reading() {
		WP_CLI::line( 'Configuring reading settings...' );

		$home_page = get_page_by_path( 'home' );
		$blog_page = get_page_by_path( 'blog' );

		if ( $home_page ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $home_page->ID );
			WP_CLI::line( '  ✓ Set front page to: Home' );
		}

		if ( $blog_page ) {
			update_option( 'page_for_posts', $blog_page->ID );
			WP_CLI::line( '  ✓ Set posts page to: Blog' );
		}

		WP_CLI::success( 'Reading settings configured!' );
	}

	/**
	 * Create blog categories
	 */
	private function create_categories() {
		$categories = array(
			array(
				'name'        => 'Real Estate',
				'slug'        => 'real-estate',
				'description' => 'Real Estate Articles and News',
			),
			array(
				'name'        => 'Property Tips',
				'slug'        => 'property-tips',
				'description' => 'Tips and Advice for Property Buyers',
			),
			array(
				'name'        => 'Market Updates',
				'slug'        => 'market-updates',
				'description' => 'Latest Real Estate Market Updates',
			),
			array(
				'name'        => 'News',
				'slug'        => 'news',
				'description' => 'Latest News from our Company',
			),
		);

		WP_CLI::line( 'Creating categories...' );

		foreach ( $categories as $category ) {
			if ( ! term_exists( $category['slug'], 'category' ) ) {
				wp_insert_term(
					$category['name'],
					'category',
					array(
						'slug'        => $category['slug'],
						'description' => $category['description'],
					)
				);
				WP_CLI::line( '  ✓ Created: ' . $category['name'] );
			} else {
				WP_CLI::line( '  ~ Already exists: ' . $category['name'] );
			}
		}

		WP_CLI::success( 'Categories setup complete!' );
	}

	/**
	 * Show setup status
	 */
	private function show_status() {
		WP_CLI::line( '' );
		WP_CLI::line( '🏠 Deweboo Real-Estate Theme Setup Status' );
		WP_CLI::line( str_repeat( '=', 50 ) );
		WP_CLI::line( '' );

		// Pages
		$pages = array( 'home', 'about-us', 'contact-us', 'properties', 'blog', 'news', 'facilities', 'faq', 'privacy-policy', 'terms' );
		$pages_created = 0;
		foreach ( $pages as $page_slug ) {
			if ( get_page_by_path( $page_slug ) ) {
				$pages_created++;
			}
		}
		WP_CLI::line( 'Pages: ' . $pages_created . '/' . count( $pages ) . ' created' );

		// Menus
		$menus_created = 0;
		$menus_needed = array( 'Primary Menu', 'Footer Menu', 'Secondary Menu' );
		foreach ( $menus_needed as $menu ) {
			if ( term_exists( $menu, 'nav_menu' ) ) {
				$menus_created++;
			}
		}
		WP_CLI::line( 'Menus: ' . $menus_created . '/' . count( $menus_needed ) . ' created' );

		// Categories
		$categories_created = 0;
		$categories_needed = array( 'real-estate', 'property-tips', 'market-updates', 'news' );
		foreach ( $categories_needed as $category ) {
			if ( term_exists( $category, 'category' ) ) {
				$categories_created++;
			}
		}
		WP_CLI::line( 'Categories: ' . $categories_created . '/' . count( $categories_needed ) . ' created' );

		// Front page
		$front_page = get_option( 'page_on_front' );
		WP_CLI::line( 'Front page configured: ' . ( $front_page ? 'Yes' : 'No' ) );

		WP_CLI::line( '' );
		WP_CLI::line( str_repeat( '=', 50 ) );
	}

	/**
	 * Reset setup (remove created items)
	 * 
	 * @warning This will delete pages and menus!
	 */
	private function reset_setup() {
		WP_CLI::confirm( 'Are you sure you want to delete all Deweboo Real-Estate-created pages and menus?' );

		WP_CLI::line( 'Removing setup items...' );

		// Delete pages
		$pages = array( 'home', 'about-us', 'contact-us', 'properties', 'blog', 'news', 'facilities', 'faq', 'privacy-policy', 'terms' );
		foreach ( $pages as $page_slug ) {
			$page = get_page_by_path( $page_slug );
			if ( $page ) {
				wp_delete_post( $page->ID, true );
				WP_CLI::line( '  ✓ Deleted: ' . $page->post_title );
			}
		}

		// Delete menus
		$menus = array( 'Primary Menu', 'Footer Menu', 'Secondary Menu' );
		foreach ( $menus as $menu_name ) {
			$menu = wp_get_nav_menu_object( $menu_name );
			if ( $menu ) {
				wp_delete_nav_menu( $menu->term_id );
				WP_CLI::line( '  ✓ Deleted menu: ' . $menu_name );
			}
		}

		WP_CLI::success( 'Reset complete! All Deweboo Real-Estate setup items have been removed.' );
	}
}

WP_CLI::add_command( 'DREAMASAHOMES-setup', 'Deweboo_RealEstate_Setup_Command' );
