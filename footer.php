<?php
/**
 * The footer for our theme
 *
 * @package DREAMASAHOMES
 */

?>

	<!-- Footer Info Bar -->
	<section class="footer-bar">
		<div class="container">
			<div class="inner wow fadeIn">
				<div class="row">
					<div class="col-lg-4 wow fadeInUp" data-wow-delay="0.05s">
						<figure>
							<img src="<?php echo esc_url( get_template_directory_uri() . '/images/footer-icon01.png' ); ?>" alt="<?php esc_attr_e( 'Address Icon', 'DREAMASAHOMES' ); ?>">
						</figure>
						<h3><?php esc_html_e( 'Office Locations', 'DREAMASAHOMES' ); ?></h3>
						<p>
							<?php esc_html_e( 'Kyiv', 'DREAMASAHOMES' ); ?> | G. Stalingrada Avenue, 6<br>
							<?php esc_html_e( 'Vilnius', 'DREAMASAHOMES' ); ?> | Antakalnio St. 17
						</p>
					</div>
					<!-- end col-4 -->

					<div class="col-lg-4 wow fadeInUp" data-wow-delay="0.10s">
						<figure>
							<img src="<?php echo esc_url( get_template_directory_uri() . '/images/footer-icon02.png' ); ?>" alt="<?php esc_attr_e( 'Hours Icon', 'DREAMASAHOMES' ); ?>">
						</figure>
						<h3><?php esc_html_e( 'Working Hours', 'DREAMASAHOMES' ); ?></h3>
						<p>
							<?php esc_html_e( 'Monday to Friday', 'DREAMASAHOMES' ); ?> <strong>09:00</strong> <?php esc_html_e( 'to', 'DREAMASAHOMES' ); ?> <strong>18:30</strong><br>
							<?php esc_html_e( 'Saturday we work until', 'DREAMASAHOMES' ); ?> <strong>15:30</strong>
						</p>
					</div>
					<!-- end col-4 -->

					<div class="col-lg-4 wow fadeInUp" data-wow-delay="0.15s">
						<figure>
							<img src="<?php echo esc_url( get_template_directory_uri() . '/images/footer-icon03.png' ); ?>" alt="<?php esc_attr_e( 'Office Icon', 'DREAMASAHOMES' ); ?>">
						</figure>
						<h3><?php esc_html_e( 'Sales Office', 'DREAMASAHOMES' ); ?></h3>
						<p>
							<?php esc_html_e( 'Boryssa Himry 124 B Block Pozniaky', 'DREAMASAHOMES' ); ?><br>
							<?php esc_html_e( 'Kiev Oblast - Ukraine', 'DREAMASAHOMES' ); ?>
						</p>
					</div>
					<!-- end col-4 -->
				</div>
				<!-- end row -->
			</div>
			<!-- end inner -->
		</div>
		<!-- end container -->
	</section>
	<!-- end footer-bar -->

	<!-- Main Footer -->
	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 wow fadeInUp" data-wow-delay="0.05s">
					<?php
					if ( has_custom_logo() ) {
						the_custom_logo();
					} else {
						?>
						<img src="<?php echo esc_url( get_template_directory_uri() . '/images/logo-light.svg' ); ?>" alt="<?php esc_attr( get_bloginfo( 'name' ) ); ?>" class="logo">
						<?php
					}
					?>
					
					<p><?php esc_html_e( 'Dreamasa Homes offers trusted real estate listings, expert buying guidance, and premium homes for sale in high-demand locations.', 'DREAMASAHOMES' ); ?></p>
				</div>
				<!-- end col-4 -->

				<div class="col-lg-2 col-md-6 wow fadeInUp" data-wow-delay="0.10s">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'footer',
						'fallback_cb'    => null,
						'depth'          => 1,
						'container'      => false,
						'items_wrap'     => '<ul class="footer-menu">%3$s</ul>',
					) );
					?>
				</div>
				<!-- end col-2 -->

				<div class="col-lg-2 col-md-6 wow fadeInUp" data-wow-delay="0.15s">
					<ul class="footer-menu">
						<li><a href="<?php echo esc_url( home_url( '/properties/' ) ); ?>"><?php esc_html_e( 'Featured Properties', 'DREAMASAHOMES' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/property/' ) ); ?>"><?php esc_html_e( 'Properties Archive', 'DREAMASAHOMES' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/apartment/' ) ); ?>"><?php esc_html_e( 'Apartments for Sale', 'DREAMASAHOMES' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>"><?php esc_html_e( 'Real Estate News', 'DREAMASAHOMES' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Book a Consultation', 'DREAMASAHOMES' ); ?></a></li>
					</ul>
				</div>
				<!-- end col-2 -->

				<div class="col-lg-4 wow fadeInUp" data-wow-delay="0.20s">
					<div class="contact-box">
						<h5><?php esc_html_e( 'CALL CENTER', 'DREAMASAHOMES' ); ?></h5>
						<h3>+380(98)298-59-73</h3>
						<p><a href="mailto:info@dreamasahomes.com">info@dreamasahomes.com</a></p>
						<ul>
							<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
							<li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
							<li><a href="#"><i class="fab fa-youtube"></i></a></li>
						</ul>
					</div>
					<!-- end contact-box -->
				</div>
				<!-- end col-4 -->

				<div class="col-12">
					<span class="copyright">
						&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> | <?php esc_html_e( 'Real Estate & Luxury Homes', 'DREAMASAHOMES' ); ?>
					</span>
					<span class="creation">
						<?php esc_html_e( 'Site created by', 'DREAMASAHOMES' ); ?>
						<a href="https://gotechsight.com/" target="_blank" rel="noopener noreferrer">Go-Tech-Sight</a>
					</span>
				</div>
				<!-- end col-12 -->
			</div>
			<!-- end row -->
		</div>
		<!-- end container -->
	</footer>
	<!-- end footer -->

	<?php wp_footer(); ?>
</body>
</html>
