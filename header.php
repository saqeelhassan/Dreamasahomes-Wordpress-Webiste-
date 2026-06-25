<?php
/**
 * The header for our theme
 *
 * @package Homepark
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="format-detection" content="telephone=no">
	<meta name="theme-color" content="#282828"/>
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	
	<?php wp_body_open(); ?>

	<!-- Transition Overlay -->
	<div class="transition-overlay">
		<div class="layer"></div>
	</div>
	<!-- end transition-overlay -->

	<!-- Side Navigation -->
	<div class="side-navigation">
		<div class="menu">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'fallback_cb'    => 'homepark_fallback_menu',
				'depth'          => 2,
				'container'      => false,
				'items_wrap'     => '<ul>%3$s</ul>',
			) );
			?>
		</div>
		<!-- end menu -->

		<div class="side-content">
			<figure>
				<?php
				if ( has_custom_logo() ) {
					the_custom_logo();
				} else {
					?>
					<img src="<?php echo esc_url( get_template_directory_uri() . '/images/logo-light.svg' ); ?>" alt="<?php esc_attr( get_bloginfo( 'name' ) ); ?>">
					<?php
				}
				?>
			</figure>
			<p><?php esc_html_e( 'By aiming to take the life quality to an upper level with the whole realized Projects, Dreamasahomes continues to be the address of luxury.', 'homepark' ); ?></p>
			
			<ul class="gallery">
				<li><a href="<?php echo esc_url( get_template_directory_uri() . '/images/gallery-thumb01.jpg' ); ?>" data-fancybox><img src="<?php echo esc_url( get_template_directory_uri() . '/images/gallery-thumb01.jpg' ); ?>" alt="<?php esc_attr_e( 'Gallery', 'homepark' ); ?>"></a></li>
				<li><a href="<?php echo esc_url( get_template_directory_uri() . '/images/gallery-thumb02.jpg' ); ?>" data-fancybox><img src="<?php echo esc_url( get_template_directory_uri() . '/images/gallery-thumb02.jpg' ); ?>" alt="<?php esc_attr_e( 'Gallery', 'homepark' ); ?>"></a></li>
				<li><a href="<?php echo esc_url( get_template_directory_uri() . '/images/gallery-thumb03.jpg' ); ?>" data-fancybox><img src="<?php echo esc_url( get_template_directory_uri() . '/images/gallery-thumb03.jpg' ); ?>" alt="<?php esc_attr_e( 'Gallery', 'homepark' ); ?>"></a></li>
			</ul>

			<address>
				<?php esc_html_e( 'Kyiv', 'homepark' ); ?> | G. Stalingrada Avenue, 6<br>
				<?php esc_html_e( 'Vilnius', 'homepark' ); ?> | Antakalnio St. 17
			</address>
			<h6>+380(98)298-59-73</h6>
			<p><a href="mailto:info@dreamasahomes.com">info@dreamasahomes.com</a></p>
			
			<ul class="social-media">
				<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
				<li><a href="#"><i class="fab fa-twitter"></i></a></li>
				<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
				<li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
				<li><a href="#"><i class="fab fa-youtube"></i></a></li>
			</ul>
			<small>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> | <?php esc_html_e( 'Real Estate & Luxury Homes', 'homepark' ); ?></small>
		</div>
		<!-- end side-content -->
	</div>
	<!-- end side-navigation -->

	<!-- Main Navigation Bar -->
	<nav class="navbar">
		<div class="container">
			<div class="upper-side">
				<div class="logo">
					<?php
					if ( has_custom_logo() ) {
						the_custom_logo();
					} else {
						?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/images/logo-light.svg' ); ?>" alt="<?php esc_attr( get_bloginfo( 'name' ) ); ?>">
						</a>
						<?php
					}
					?>
				</div>
				<!-- end logo -->

				<div class="phone-email">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/images/icon-phone.png' ); ?>" alt="<?php esc_attr_e( 'Phone Icon', 'homepark' ); ?>">
					<div class="contact-text">
						<h4>+380(98)298-59-73</h4>
						<small><a href="mailto:info@dreamasahomes.com">info@dreamasahomes.com</a></small>
					</div>
				</div>
				<!-- end phone -->

				<div class="hamburger">
					<span></span>
					<span></span>
					<span></span>
					<span></span>
				</div>
				<!-- end hamburger -->
			</div>
			<!-- end upper-side -->

			<div class="menu">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'fallback_cb'    => 'homepark_fallback_menu',
					'depth'          => 2,
					'container'      => false,
					'items_wrap'     => '<ul>%3$s</ul>',
				) );
				?>
			</div>
			<!-- end menu -->
		</div>
		<!-- end container -->
	</nav>
	<!-- end navbar -->

<?php

/**
 * Fallback menu for when no menu is assigned.
 */
function homepark_fallback_menu() {
	$menu_items = array(
		array(
			'label' => __( 'Home', 'homepark' ),
			'url'   => home_url( '/' ),
		),
		array(
			'label' => __( 'About', 'homepark' ),
			'url'   => home_url( '/about/' ),
		),
		array(
			'label' => __( 'Properties', 'homepark' ),
			'url'   => home_url( '/properties/' ),
		),
		array(
			'label' => __( 'News', 'homepark' ),
			'url'   => home_url( '/news/' ),
		),
		array(
			'label' => __( 'Contact', 'homepark' ),
			'url'   => home_url( '/contact-us/' ),
		),
	);

	echo '<ul>';
	foreach ( $menu_items as $menu_item ) {
		echo '<li><a href="' . esc_url( $menu_item['url'] ) . '">' . esc_html( $menu_item['label'] ) . '</a></li>';
	}
	echo '</ul>';
}
?>
