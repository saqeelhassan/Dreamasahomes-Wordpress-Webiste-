<?php
/**
 * Front page template using Hompark index layout.
 *
 * @package Deweboo Real-Estate
 */

get_header();

$front_page_id   = get_queried_object_id();
$builder_content = deweboo_realestate_get_builder_content(
	$front_page_id,
	array( '[deweboo_hero_section]' )
);

if ( '' !== $builder_content ) {
	?>
	<main class="page-builder-content">
		<div class="container">
			<?php echo wp_kses_post( $builder_content ); ?>
		</div>
	</main>
	<?php
	get_footer();
	return;
}
?>

<!-- Hero Slider Section -->
<header class="slider">
	<div class="slider-container">
		<div class="swiper-wrapper">
			<!-- Slide 1 -->
			<div class="swiper-slide" data-background="<?php echo esc_url( get_template_directory_uri() . '/images/slider/slide01.webp' ); ?>" data-stellar-background-ratio="1.15">
				<div class="container">
					<h1><span><?php esc_html_e( 'Prime', 'DREAMASAHOMES' ); ?></span> <?php esc_html_e( 'Residences for Sale', 'DREAMASAHOMES' ); ?></h1>
					<h2><?php esc_html_e( 'Premium apartments and villas in top locations', 'DREAMASAHOMES' ); ?></h2>
					<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Book a Free Consultation', 'DREAMASAHOMES' ); ?> <i class="fas fa-caret-right"></i></a>
					<figure><img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/services-icon01.png' ); ?>" alt="<?php esc_attr_e( 'Icon', 'DREAMASAHOMES' ); ?>"></figure>
				</div>
			</div>
			<!-- end swiper-slide -->

			<!-- Slide 2 -->
			<div class="swiper-slide" data-background="<?php echo esc_url( get_template_directory_uri() . '/images/slider/slide02.webp' ); ?>" data-stellar-background-ratio="1.15">
				<div class="container">
					<h1><span><?php esc_html_e( 'Cityline', 'DREAMASAHOMES' ); ?></span> <?php esc_html_e( 'Premium Flats', 'DREAMASAHOMES' ); ?></h1>
					<h2><?php esc_html_e( 'Modern homes designed for comfort and long-term value', 'DREAMASAHOMES' ); ?></h2>
					<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Book a Free Consultation', 'DREAMASAHOMES' ); ?> <i class="fas fa-caret-right"></i></a>
					<figure><img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/services-icon08.png' ); ?>" alt="<?php esc_attr_e( 'Icon', 'DREAMASAHOMES' ); ?>"></figure>
				</div>
			</div>
			<!-- end swiper-slide -->

			<!-- Slide 3 -->
			<div class="swiper-slide" data-background="<?php echo esc_url( get_template_directory_uri() . '/images/slider/slide03.webp' ); ?>" data-stellar-background-ratio="1.15">
				<div class="container">
					<h1><span><?php esc_html_e( 'DreamasaHomes', 'DREAMASAHOMES' ); ?></span> <?php esc_html_e( 'Real Estate Experts', 'DREAMASAHOMES' ); ?></h1>
					<h2><?php esc_html_e( 'Find your next home with confidence', 'DREAMASAHOMES' ); ?></h2>
					<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Book a Free Consultation', 'DREAMASAHOMES' ); ?> <i class="fas fa-caret-right"></i></a>
					<figure><img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/services-icon07.png' ); ?>" alt="<?php esc_attr_e( 'Icon', 'DREAMASAHOMES' ); ?>"></figure>
				</div>
			</div>
			<!-- end swiper-slide -->
		</div>
		<!-- end swiper-wrapper -->

		<!-- Slider Controls -->
		<div class="inner-elements">
			<div class="container">
				<div class="pagination"></div>
				<div class="button-prev"><?php esc_html_e( 'PREV', 'DREAMASAHOMES' ); ?></div>
				<div class="button-next"><?php esc_html_e( 'NEXT', 'DREAMASAHOMES' ); ?></div>
				<div class="social-media">
					<h6><?php esc_html_e( 'SOCIAL MEDIA', 'DREAMASAHOMES' ); ?></h6>
					<ul>
						<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
						<li><a href="#"><i class="fab fa-twitter"></i></a></li>
						<li><a href="#"><i class="fab fa-google"></i></a></li>
						<li><a href="#"><i class="fab fa-youtube"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</header>
<!-- end slider -->

<!-- Intro Section -->
<section class="intro">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6">
				<figure>
					<div class="pattern-bg" data-stellar-ratio="1.07"></div>
					<div class="holder" data-stellar-ratio="1.10">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/side-image01.webp' ); ?>" alt="<?php esc_attr_e( 'Image', 'DREAMASAHOMES' ); ?>">
					</div>
				</figure>
			</div>
			<div class="col-lg-6 wow fadeInUp">
				<div class="content-box">
					<b>01</b>
					<h4><span><?php esc_html_e( 'Pozniaky', 'DREAMASAHOMES' ); ?></span> <?php esc_html_e( 'Construction LLC', 'DREAMASAHOMES' ); ?></h4>
					<h3><?php esc_html_e( 'Find homes that match your lifestyle and budget', 'DREAMASAHOMES' ); ?></h3>
					<p><?php esc_html_e( 'Browse verified real estate listings with clear pricing, trusted documentation, and expert support from inquiry to closing.', 'DREAMASAHOMES' ); ?></p>
					<a href="<?php echo esc_url( home_url( '/properties/' ) ); ?>">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/icon-m2.png' ); ?>" alt="">
						<?php esc_html_e( 'Explore available properties', 'DREAMASAHOMES' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end intro -->

<!-- Logos Section -->
<section class="logos">
	<div class="container">
		<div class="row">
			<?php
			$logos = array(
				array( 'image' => 'logo01.jpg', 'name' => 'TABLE' ),
				array( 'image' => 'logo02.jpg', 'name' => 'PLANE' ),
				array( 'image' => 'logo03.jpg', 'name' => 'CONNECT' ),
				array( 'image' => 'logo04.jpg', 'name' => 'GLASSES' ),
				array( 'image' => 'logo05.jpg', 'name' => 'PIXEL' ),
				array( 'image' => 'logo06.jpg', 'name' => 'ATTACH' ),
			);

			foreach ( $logos as $index => $logo ) {
				$delay = $index * 0.05;
				?>
				<div class="col-lg-2 col-md-4 col-sm-6 col-6 wow fadeInUp" data-wow-delay="<?php echo esc_attr( $delay ); ?>s">
					<figure>
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/' . $logo['image'] ); ?>" alt="<?php echo esc_attr( $logo['name'] ); ?>">
						<h6><?php echo esc_html( $logo['name'] ); ?></h6>
					</figure>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</section>
<!-- end logos -->

<!-- Benefits Section -->
<section class="benefits">
	<div class="container">
		<div class="row">
			<div class="col-12 wow fadeInUp">
				<b>02</b>
				<h4><span><?php esc_html_e( 'Dreamasahomes', 'DREAMASAHOMES' ); ?></span> <?php esc_html_e( 'Property', 'DREAMASAHOMES' ); ?></h4>
				<h3><?php esc_html_e( 'Why buyers choose DreamasaHomes', 'DREAMASAHOMES' ); ?></h3>
			</div>

			<?php
			$benefits = array(
				array(
					'icon'   => 'icon-benefits01.png',
					'title'  => 'Near Public Transit',
					'count'  => 28,
					'suffix' => 'min',
				),
				array(
					'icon'   => 'icon-benefits02.png',
					'title'  => 'Verified Listings',
					'count'  => 32,
					'suffix' => '+',
				),
				array(
					'icon'   => 'icon-benefits03.png',
					'title'  => 'Lower Utility Costs',
					'count'  => 15,
					'suffix' => '%',
				),
				array(
					'icon'   => 'icon-benefits04.png',
					'title'  => 'Developer Warranty',
					'count'  => 3,
					'suffix' => 'years',
				),
				array(
					'icon'   => 'icon-benefits05.png',
					'title'  => 'Average Apartment Size',
					'count'  => 79,
					'suffix' => 'm²',
				),
			);

			foreach ( $benefits as $index => $benefit ) {
				$delay = $index * 0.05;
				?>
				<div class="col wow fadeInUp" data-wow-delay="<?php echo esc_attr( $delay ); ?>s">
					<figure>
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/' . $benefit['icon'] ); ?>" alt="<?php echo esc_attr( $benefit['title'] ); ?>">
						<b></b>
					</figure>
					<h6><?php echo esc_html( $benefit['title'] ); ?></h6>
					<span class="odometer" data-count="<?php echo esc_attr( $benefit['count'] ); ?>" data-status="yes">0</span>
					<span class="extra"><?php echo esc_html( $benefit['suffix'] ); ?></span>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</section>
<!-- end benefits -->

<!-- Recent Gallery Section -->
<section class="recent-gallery">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-5 wow fadeInUp">
				<b>03</b>
				<h4><span><?php esc_html_e( 'Property', 'DREAMASAHOMES' ); ?></span> <?php esc_html_e( 'Inner Gallery', 'DREAMASAHOMES' ); ?></h4>
				<h3><?php esc_html_e( 'Explore featured property interiors', 'DREAMASAHOMES' ); ?></h3>
				<a href="<?php echo esc_url( home_url( '/properties/' ) ); ?>" class="link"><?php esc_html_e( 'See all properties', 'DREAMASAHOMES' ); ?> <i class="fas fa-caret-right"></i></a>
			</div>

			<div class="col-lg-7">
				<div class="row inner">
					<?php
					$galleries = array(
						'gallery-thumb01.jpg',
						'gallery-thumb02.jpg',
						'gallery-thumb03.jpg',
					);

					foreach ( $galleries as $index => $gallery ) {
						$delay = $index * 0.05;
						?>
						<div class="col-md-4 wow fadeInUp" data-wow-delay="<?php echo esc_attr( $delay ); ?>s">
							<figure data-stellar-ratio="1.07">
								<a href="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/' . $gallery ); ?>" data-fancybox>
									<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/' . $gallery ); ?>" alt="<?php esc_attr_e( 'Gallery', 'DREAMASAHOMES' ); ?>">
								</a>
							</figure>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end recent-gallery -->

<!-- Property Calculator Section -->
<section class="property-calculator">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6">
				<figure>
					<div class="pattern-bg" data-stellar-ratio="1.03"></div>
					<div class="holder" data-stellar-ratio="1.07">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/side-image02.jpg' ); ?>" alt="<?php esc_attr_e( 'Image', 'DREAMASAHOMES' ); ?>">
					</div>
				</figure>
			</div>

			<div class="col-lg-6 wow fadeInUp">
				<div class="content-box">
					<b>04</b>
					<h4><span><?php esc_html_e( 'Dreamasahomes', 'DREAMASAHOMES' ); ?></span> <?php esc_html_e( 'Living Spaces', 'DREAMASAHOMES' ); ?></h4>
					<h3><?php esc_html_e( 'Estimate your home buying budget', 'DREAMASAHOMES' ); ?></h3>
					<p><?php esc_html_e( 'Use our financing and area calculator to compare property options and choose the right home for your goals.', 'DREAMASAHOMES' ); ?></p>
					<ul>
						<li><img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/bank-logos01.jpg' ); ?>" alt="<?php esc_attr_e( 'Bank Logo', 'DREAMASAHOMES' ); ?>"></li>
						<li><img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/bank-logos02.jpg' ); ?>" alt="<?php esc_attr_e( 'Bank Logo', 'DREAMASAHOMES' ); ?>"></li>
					</ul>
					<a href="#">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/icon-calculator.png' ); ?>" alt="">
						<?php esc_html_e( 'Living Space Calculator', 'DREAMASAHOMES' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end property-calculator -->

<!-- Property Plans Section -->
<section class="property-plans">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6 wow fadeInUp">
				<b>05</b>
				<h4><span><?php esc_html_e( 'Dreamasahomes', 'DREAMASAHOMES' ); ?></span> <?php esc_html_e( 'Living Spaces', 'DREAMASAHOMES' ); ?></h4>
				<h3><?php esc_html_e( 'Available floor plans and pricing options', 'DREAMASAHOMES' ); ?></h3>
				<p><?php esc_html_e( 'We are waiting for you in our sales office for having all these opportunities with affordable prices and appropriate payment opportunities.', 'DREAMASAHOMES' ); ?></p>
				<table>
					<tbody>
						<tr>
							<td><?php esc_html_e( 'Total area:', 'DREAMASAHOMES' ); ?></td>
							<td><?php esc_html_e( '680 metre square', 'DREAMASAHOMES' ); ?></td>
						</tr>
						<tr>
							<td><?php esc_html_e( 'Total Floor:', 'DREAMASAHOMES' ); ?></td>
							<td><?php esc_html_e( '24 Floor', 'DREAMASAHOMES' ); ?></td>
						</tr>
						<tr>
							<td><?php esc_html_e( 'Parking Lot:', 'DREAMASAHOMES' ); ?></td>
							<td><?php esc_html_e( '5 Large', 'DREAMASAHOMES' ); ?></td>
						</tr>
						<tr>
							<td><?php esc_html_e( 'Social Area:', 'DREAMASAHOMES' ); ?></td>
							<td><?php esc_html_e( '860 m²', 'DREAMASAHOMES' ); ?></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="col-lg-6 wow fadeInUp" data-wow-delay="0.05s">
				<ul class="nav nav-pills" id="pills-tab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="pill" href="#tab-one"><?php esc_html_e( '1 Room 47m²', 'DREAMASAHOMES' ); ?></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="pill" href="#tab-two" role="tab"><?php esc_html_e( '2 Rooms 65m²', 'DREAMASAHOMES' ); ?></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="pill" href="#tab-three" role="tab"><?php esc_html_e( '3 Rooms 90m²', 'DREAMASAHOMES' ); ?></a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade show active" id="tab-one">
						<figure>
							<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/plan01.jpg' ); ?>" alt="<?php esc_attr_e( 'Floor Plan', 'DREAMASAHOMES' ); ?>">
						</figure>
					</div>
					<div class="tab-pane fade" id="tab-two">
						<figure>
							<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/plan02.jpg' ); ?>" alt="<?php esc_attr_e( 'Floor Plan', 'DREAMASAHOMES' ); ?>">
						</figure>
					</div>
					<div class="tab-pane fade" id="tab-three">
						<figure>
							<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/plan03.jpg' ); ?>" alt="<?php esc_attr_e( 'Floor Plan', 'DREAMASAHOMES' ); ?>">
						</figure>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end property-plans -->

<!-- Get Consultation Section -->
<section class="get-consultation" data-background="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/section-bg01.jpg' ); ?>" data-stellar-background-ratio="0.9">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-8 fadeInUp wow">
				<div class="content-box">
					<b>06</b>
					<h4><span><?php esc_html_e( 'Dreamasahomes', 'DREAMASAHOMES' ); ?></span> <?php esc_html_e( 'Living Spaces', 'DREAMASAHOMES' ); ?></h4>
					<h3><?php esc_html_e( 'Ready to buy your next property?', 'DREAMASAHOMES' ); ?></h3>
					<p><?php esc_html_e( 'Talk to our real estate sales team for pricing, availability, legal guidance, and private viewing appointments.', 'DREAMASAHOMES' ); ?></p>
					<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Schedule a Visit', 'DREAMASAHOMES' ); ?> <i class="fas fa-caret-right"></i></a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- end get-consultation -->

<!-- Recent Posts Section -->
<section class="recent-posts">
	<div class="container">
		<div class="row">
			<div class="col-12 wow fadeInUp">
				<b>07</b>
				<h4><span><?php esc_html_e( 'Dreamasahomes', 'DREAMASAHOMES' ); ?></span> <?php esc_html_e( 'Living Spaces', 'DREAMASAHOMES' ); ?></h4>
				<small><?php esc_html_e( 'Real estate market updates and buyer tips', 'DREAMASAHOMES' ); ?></small>
			</div>

			<?php
			$recent_posts_query = new WP_Query(
				array(
					'posts_per_page' => 3,
					'post_type'      => 'post',
					'orderby'        => 'date',
					'order'          => 'DESC',
				)
			);

			if ( $recent_posts_query->have_posts() ) {
				$post_index = 0;
				while ( $recent_posts_query->have_posts() ) {
					$recent_posts_query->the_post();
					$delay = $post_index * 0.10;
					$post_index++;
					?>
					<div class="col-lg-4 wow fadeInUp" data-wow-delay="<?php echo esc_attr( $delay ); ?>s">
						<div class="post-box">
							<?php
							if ( has_post_thumbnail() ) {
								?>
								<figure>
									<?php the_post_thumbnail( 'medium' ); ?>
								</figure>
								<?php
							} else {
								$image_index = $post_index; // 1-based index for fallback.
								?>
								<figure>
									<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/recent-news0' . $image_index . '.jpg' ); ?>" alt="<?php esc_attr_e( 'News', 'DREAMASAHOMES' ); ?>">
								</figure>
								<?php
							}
							?>
							<span><?php echo esc_html( get_the_date( 'j, F Y' ) ); ?></span>
							<h6><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h6>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 15 ) ); ?></p>
						</div>
					</div>
					<?php
				}
				wp_reset_postdata();
			}
			?>
		</div>
	</div>
</section>
<!-- end recent-posts -->

<!-- Property Customization Section -->
<section class="property-customization">
	<div class="video-bg">
		<video src="<?php echo esc_url( get_stylesheet_directory_uri() . '/hompark/videos/video01.mp4' ); ?>" loop autoplay muted></video>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-12 wow fadeInUp">
				<b>08</b>
				<h4><span><?php esc_html_e( 'Dreamasahomes', 'DREAMASAHOMES' ); ?></span> <?php esc_html_e( 'Living Spaces', 'DREAMASAHOMES' ); ?></h4>
				<h3><?php esc_html_e( 'Choose finishes and upgrades before move-in', 'DREAMASAHOMES' ); ?></h3>
			</div>

			<?php
			$services = array(
				'services-icon01.png' => 'Water Taps',
				'services-icon02.png' => 'Furniture',
				'services-icon03.png' => 'Electricity',
				'services-icon04.png' => 'Wood Edition',
				'services-icon05.png' => 'Ceramics',
				'services-icon06.png' => 'Pipelines',
				'services-icon07.png' => 'Concrete Work',
				'services-icon08.png' => 'Hummer',
				'services-icon09.png' => 'Digging',
				'services-icon10.png' => 'Raiser',
				'services-icon11.png' => 'Fasteners',
				'services-icon12.png' => 'Blueprint',
			);

			$service_position = 0;
			foreach ( $services as $service_icon => $service_label ) {
				$delay     = ( $service_position % 8 ) * 0.05;
				$icon_name = str_replace( array( 'services-icon', '.png' ), '', $service_icon );
				$service_position++;
				?>
				<div class="col-lg-2 col-md-4 col-sm-6 col-6 wow fadeInUp" data-wow-delay="<?php echo esc_attr( $delay ); ?>s">
					<figure data-toggle="tooltip" data-placement="top" title="<?php esc_attr_e( 'Quality construction and finishing options available', 'DREAMASAHOMES' ); ?>">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/' . $service_icon ); ?>" alt="<?php echo esc_attr( $icon_name ); ?>">
						<figcaption><?php echo esc_html( $service_label ); ?></figcaption>
					</figure>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</section>
<!-- end property-customization -->

<!-- Certificates Section -->
<section class="certificates">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-4 col-md-12 wow fadeInUp">
				<b>09</b>
				<h4><span><?php esc_html_e( 'Property', 'DREAMASAHOMES' ); ?></span> <?php esc_html_e( 'Certificates', 'DREAMASAHOMES' ); ?></h4>
				<small><?php esc_html_e( 'Legal documents and compliance records', 'DREAMASAHOMES' ); ?></small>
			</div>

			<?php
			$certificates = array(
				'certificate01.jpg',
				'certificate02.jpg',
				'certificate03.jpg',
				'certificate04.jpg',
			);

			foreach ( $certificates as $index => $cert ) {
				$delay = $index * 0.05;
				?>
				<div class="col-lg-2 col-md-3 col-sm-6 col-6 wow fadeInUp" data-wow-delay="<?php echo esc_attr( $delay ); ?>s">
					<figure>
						<a href="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/' . $cert ); ?>" data-fancybox>
							<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/' . $cert ); ?>" alt="<?php esc_attr_e( 'Certificate', 'DREAMASAHOMES' ); ?>">
						</a>
					</figure>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</section>
<!-- end certificates -->

<?php
get_footer();
