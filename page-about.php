<?php
/**
 * Template for about page
 *
 * @package Deweboo Real-Estate
 */

get_header();

$theme_uri = get_template_directory_uri();

$page_id = get_queried_object_id();
$builder_content = deweboo_realestate_get_builder_content(
	$page_id,
	array( '[deweboo_about_section]' )
);
?>

<header class="page-header" data-stellar-background-ratio="1.15">
	<div class="container">
		<h1><?php the_title(); ?></h1>
		<p><?php esc_html_e( 'Learn about Dreamasa Homes, a trusted real estate sales team focused on verified listings and transparent buying support.', 'deweboo-realestate' ); ?></p>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'deweboo-realestate' ); ?></a></li>
			<!-- <li class="breadcrumb-item"><a href="#"><?php esc_html_e( 'Deweboo Real-Estate', 'deweboo-realestate' ); ?></a></li> -->
			<li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
		</ol>
	</div>
</header>

<section class="about-content">
	<div class="container">
		<?php if ( '' !== $builder_content ) : ?>
			<?php echo wp_kses_post( $builder_content ); ?>
		<?php else : ?>
		<div class="row">
			<div class="col-12">
				<h2><span><?php esc_html_e( 'Dreamasa', 'deweboo-realestate' ); ?></span> <?php esc_html_e( 'Homes', 'deweboo-realestate' ); ?></h2>
				<h5><?php esc_html_e( 'By aiming to take the life quality to an upper level with the whole realized Projects of luxury.', 'deweboo-realestate' ); ?></h5>
			</div>
			<div class="col-lg-7">
				<p><?php esc_html_e( 'Dreamasa Homes helps buyers discover apartments, villas, and investment properties in high-demand areas. Our team verifies legal documentation, compares pricing trends, and guides each client from first viewing to successful closing.', 'deweboo-realestate' ); ?></p>
			</div>
			<div class="col-lg-5">
				<p><?php esc_html_e( 'Whether you are purchasing your first home or expanding your portfolio, we focus on location value, quality construction, and long-term return on investment.', 'deweboo-realestate' ); ?></p>
			</div>

			<div class="col-12">
				<div class="gallery-container">
					<div class="swiper-wrapper">
						<div class="swiper-slide"><img src="<?php echo esc_url( $theme_uri . '/images/blog01.webp' ); ?>" alt="<?php esc_attr_e( 'Gallery image', 'deweboo-realestate' ); ?>"></div>
						<div class="swiper-slide"><img src="<?php echo esc_url( $theme_uri . '/images/blog02.webp' ); ?>" alt="<?php esc_attr_e( 'Gallery image', 'deweboo-realestate' ); ?>"></div>
						<div class="swiper-slide"><img src="<?php echo esc_url( $theme_uri . '/images/blog03.webp' ); ?>" alt="<?php esc_attr_e( 'Gallery image', 'deweboo-realestate' ); ?>"></div>
						<div class="swiper-slide"><img src="<?php echo esc_url( $theme_uri . '/images/blog04.webp' ); ?>" alt="<?php esc_attr_e( 'Gallery image', 'deweboo-realestate' ); ?>"></div>
					</div>
					<div class="gallery-pagination"></div>
				</div>
				<h4><?php esc_html_e( 'Take the life quality to an upper level', 'deweboo-realestate' ); ?></h4>
				<p><?php esc_html_e( 'Our approach combines local market knowledge with data-driven property analysis, so every client receives accurate recommendations and confident negotiation support.', 'deweboo-realestate' ); ?></p>
				<br>
			</div>

			<div class="col-md-6">
				<h6><?php esc_html_e( 'Property Specifications', 'deweboo-realestate' ); ?></h6>
				<ul>
					<li><?php esc_html_e( 'Verified ownership and legal documentation for listed properties.', 'deweboo-realestate' ); ?></li>
					<li><?php esc_html_e( 'Detailed floor plans, area metrics, and room distribution.', 'deweboo-realestate' ); ?></li>
					<li><?php esc_html_e( 'Transparent pricing details with no hidden charges.', 'deweboo-realestate' ); ?></li>
					<li><?php esc_html_e( 'Construction quality checks and handover standards.', 'deweboo-realestate' ); ?></li>
					<li><?php esc_html_e( 'Neighborhood analysis including schools, transit, and amenities.', 'deweboo-realestate' ); ?></li>
					<li><?php esc_html_e( 'Flexible financing guidance for eligible buyers.', 'deweboo-realestate' ); ?></li>
				</ul>
			</div>

			<div class="col-md-6">
				<h6><?php esc_html_e( 'Property Benefits', 'deweboo-realestate' ); ?></h6>
				<ul>
					<li><?php esc_html_e( 'Strong resale potential in high-growth real estate zones.', 'deweboo-realestate' ); ?></li>
					<li><?php esc_html_e( 'Professional support for negotiation and offer strategy.', 'deweboo-realestate' ); ?></li>
					<li><?php esc_html_e( 'Curated listings that match buyer goals and budget.', 'deweboo-realestate' ); ?></li>
					<li><?php esc_html_e( 'Faster shortlisting with complete property comparisons.', 'deweboo-realestate' ); ?></li>
					<li><?php esc_html_e( 'Guidance from inquiry, viewing, and paperwork to closing.', 'deweboo-realestate' ); ?></li>
					<li><?php esc_html_e( 'After-sales assistance for a smooth move-in experience.', 'deweboo-realestate' ); ?></li>
				</ul>
			</div>

			<div class="col-lg-9">
				<div class="video-content">
					<video src="<?php echo esc_url( $theme_uri . '/videos/video01.mp4' ); ?>" controls muted></video>
				</div>
			</div>

			<div class="col-12">
				<blockquote>
					<p><?php esc_html_e( 'Our goal is simple: help every buyer find the right home at the right value with full confidence.', 'deweboo-realestate' ); ?></p>
					<strong><?php esc_html_e( 'Dreamasa Homes Lead Engineer', 'deweboo-realestate' ); ?></strong>
				</blockquote>
				<p><?php esc_html_e( 'We work with trusted developers, private sellers, and legal partners to provide reliable property choices. Every listing is reviewed for market positioning so buyers can make informed decisions quickly.', 'deweboo-realestate' ); ?></p>
				<p><?php esc_html_e( 'If you are searching for apartments, houses, or investment opportunities, our advisors are ready to recommend properties that align with your plan and timeline.', 'deweboo-realestate' ); ?></p>
			</div>
		</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
