<?php
/**
 * Template for contact page
 *
 * @package Deweboo Real-Estate
 */

get_header();
?>

<!-- Page Header -->
<header class="page-header" data-stellar-background-ratio="1.15">
	<div class="container">
		<h1><?php the_title(); ?></h1>
		<p><?php esc_html_e( 'Contact our real estate sales team for listings, pricing, and property viewings', 'DREAMASAHOMES' ); ?></p>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'DREAMASAHOMES' ); ?></a></li>
			<li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
		</ol>
	</div>
</header>
<!-- end page-header -->

<!-- Contact Section -->
<section class="contact">
	<div class="container">

		<!-- Info Row -->
		<div class="row align-items-center">
			<div class="col-lg-6 wow fadeInUp">
				<b>07</b>
				<h4><span><?php esc_html_e( 'DREAMASAHOMES', 'DREAMASAHOMES' ); ?></span> <?php esc_html_e( 'Sales Office', 'DREAMASAHOMES' ); ?></h4>
				<small><?php esc_html_e( 'We help you buy the right property with confidence', 'DREAMASAHOMES' ); ?></small>
			</div>
			<!-- end col-6 -->
			<div class="col-lg-3 col-md-6 wow fadeInUp">
				<address>
					<strong><?php esc_html_e( 'Visit Us', 'DREAMASAHOMES' ); ?></strong>
					<p><?php esc_html_e( 'Khreshchatyk Street 15, Floor 17', 'DREAMASAHOMES' ); ?><br>
					<?php esc_html_e( 'Kyiv, Ukraine 78692', 'DREAMASAHOMES' ); ?></p>
				</address>
			</div>
			<!-- end col-3 -->
			<div class="col-lg-3 col-md-6 wow fadeInUp">
				<address>
					<strong><?php esc_html_e( 'Say Hello', 'DREAMASAHOMES' ); ?></strong>
					<p><a href="mailto:hello@dreamasahomes.com.ua">hello@dreamasahomes.com.ua</a><br>
					+380(98)298-59-73</p>
				</address>
			</div>
			<!-- end col-3 -->
		</div>
		<!-- end row -->

		<!-- Map + Form Row -->
		<div class="row align-items-center">
			<div class="col-lg-6">
				<div class="map">
					<div class="pattern-bg" data-stellar-ratio="1.03"></div>
					<!-- end pattern-bg -->
					<div class="holder" data-stellar-ratio="1.07">
						<iframe
							src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3025.2378765886474!2d-73.97644805915624!3d40.69075842971381!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25bb6c6fe52c7%3A0x2b3bb16e97b13c01!2sFort+Greene+Tennis+Courts!5e0!3m2!1sen!2str!4v1559831164025!5m2!1sen!2str"
							allowfullscreen
							loading="lazy"
							referrerpolicy="no-referrer-when-downgrade"
							title="<?php esc_attr_e( 'DREAMASAHOMES Location Map', 'DREAMASAHOMES' ); ?>">
						</iframe>
					</div>
					<!-- end holder -->
				</div>
				<!-- end map -->
			</div>
			<!-- end col-6 -->

			<div class="col-lg-6">
				<div class="contact-form">
					<?php
					$contact_page_id = get_queried_object_id();
					$builder_content = deweboo_realestate_get_builder_content(
						$contact_page_id,
						array( '[deweboo_contact_form]' )
					);

					if ( '' !== $builder_content ) {
						echo wp_kses_post( $builder_content );
					} elseif ( shortcode_exists( 'contact-form-7' ) ) {
						// Contact Form 7 output is expected to contain valid markup.
						echo do_shortcode( '[contact-form-7 title="Contact form 1"]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					} else {
						?>
						<div class="alert alert-warning" role="alert">
							<?php esc_html_e( 'Install and activate Contact Form 7, then add your form shortcode to this page in the WordPress editor.', 'DREAMASAHOMES' ); ?>
						</div>
						<?php
					}
					?>
				</div>
				<!-- end contact-form -->
			</div>
			<!-- end col-6 -->
		</div>
		<!-- end row -->

	</div>
	<!-- end container -->
</section>
<!-- end contact -->

<?php
get_footer();
