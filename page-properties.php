<?php
/**
 * Template for Properties page - displays all properties
 *
 * @package Deweboo Real-Estate
 */

get_header();
?>

<!-- Properties Header -->
<header class="page-header" data-stellar-background-ratio="1.15">
	<div class="container">
		<h1><?php the_title(); ?></h1>
		<p><?php esc_html_e( 'Browse our selection of premium real estate properties', 'deweboo-realestate' ); ?></p>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'deweboo-realestate' ); ?></a></li>
			<li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
		</ol>
	</div>
</header>

<!-- Properties Content -->
<div class="container properties-page">
	<?php $has_primary_sidebar = is_active_sidebar( 'primary-sidebar' ); ?>
	<div class="row">
		<main id="main-content" class="<?php echo esc_attr( $has_primary_sidebar ? 'col-lg-9' : 'col-12' ); ?>">
			<!-- Page Introduction -->
			<?php
			while ( have_posts() ) {
				the_post();
				if ( ! empty( get_the_content() ) ) {
					?>
					<div class="page-introduction wow fadeInUp">
						<?php the_content(); ?>
					</div>
					<?php
				}
			}
			wp_reset_postdata();
			?>

			<!-- Properties Grid -->
			<?php
			// Query properties
			$properties_query = new WP_Query( array(
				'post_type'      => 'property',
				'posts_per_page' => 12,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'paged'          => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
			) );

			if ( $properties_query->have_posts() ) {
				?>
				<div class="properties-grid">
					<?php
					$index = 0;
					while ( $properties_query->have_posts() ) {
						$properties_query->the_post();
						$delay = ( $index % 3 ) * 0.05;
						$property_price     = get_post_meta( get_the_ID(), '_property_price', true );
						$property_location  = get_post_meta( get_the_ID(), '_property_location', true );
						$property_area      = get_post_meta( get_the_ID(), '_property_area', true );
						$property_bedrooms  = get_post_meta( get_the_ID(), '_property_bedrooms', true );
						$property_bathrooms = get_post_meta( get_the_ID(), '_property_bathrooms', true );
						$property_status    = get_post_meta( get_the_ID(), '_property_status', true );
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'property-item wow fadeInUp' ); ?> data-wow-delay="<?php echo esc_attr( $delay ); ?>s">
							<div class="property-card">
								<!-- Featured Image -->
								<?php
								if ( has_post_thumbnail() ) {
									?>
									<a href="<?php the_permalink(); ?>" class="property-image">
										<?php the_post_thumbnail( 'medium' ); ?>
										<div class="overlay">
											<span class="view-btn">
												<?php esc_html_e( 'View Details', 'deweboo-realestate' ); ?> <i class="fas fa-arrow-right"></i>
											</span>
										</div>
									</a>
									<?php
								} else {
									?>
									<a href="<?php the_permalink(); ?>" class="property-image property-image-placeholder">
										<span><?php esc_html_e( 'Dreamasa Homes', 'deweboo-realestate' ); ?></span>
									</a>
									<?php
								}
								?>

								<!-- Property Info -->
								<div class="property-info">
									<div class="property-meta">
										<span class="date"><?php echo esc_html( get_the_date() ); ?></span>
										<?php
										// Show property type
										$property_types = get_the_terms( get_the_ID(), 'property_type' );
										if ( $property_types && ! is_wp_error( $property_types ) ) {
											echo '<span class="property-type">' . esc_html( $property_types[0]->name ) . '</span>';
										}
										?>
									</div>

									<?php if ( $property_price || $property_status ) : ?>
										<div class="property-highlights">
											<?php if ( ! empty( $property_price ) ) : ?>
												<span class="highlight-chip highlight-price"><?php echo esc_html( $property_price ); ?></span>
											<?php endif; ?>
											<?php if ( ! empty( $property_status ) ) : ?>
												<span class="highlight-chip highlight-status status-<?php echo esc_attr( $property_status ); ?>"><?php echo esc_html( ucfirst( $property_status ) ); ?></span>
											<?php endif; ?>
										</div>
									<?php endif; ?>

									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

									<?php if ( $property_location ) : ?>
										<p class="property-location"><?php echo esc_html( $property_location ); ?></p>
									<?php endif; ?>

									<?php if ( $property_area || '' !== (string) $property_bedrooms || '' !== (string) $property_bathrooms ) : ?>
										<div class="property-stats">
											<?php if ( $property_area ) : ?>
												<span><?php echo esc_html( $property_area ); ?> m&sup2;</span>
											<?php endif; ?>
											<?php if ( '' !== (string) $property_bedrooms ) : ?>
												<span><?php echo esc_html( $property_bedrooms ); ?> <?php esc_html_e( 'Beds', 'deweboo-realestate' ); ?></span>
											<?php endif; ?>
											<?php if ( '' !== (string) $property_bathrooms ) : ?>
												<span><?php echo esc_html( $property_bathrooms ); ?> <?php esc_html_e( 'Baths', 'deweboo-realestate' ); ?></span>
											<?php endif; ?>
										</div>
									<?php endif; ?>

									<p class="excerpt">
										<?php echo wp_trim_words( get_the_excerpt(), 12, '...' ); ?>
									</p>

									<a href="<?php the_permalink(); ?>" class="read-more">
										<?php esc_html_e( 'Learn More', 'deweboo-realestate' ); ?> <i class="fas fa-arrow-right"></i>
									</a>
								</div>
							</div>
						</article>
						<?php
						$index++;
					}
					?>
				</div>

				<!-- Pagination -->
				<div class="pagination-wrapper">
					<?php
					echo wp_kses_post( paginate_links( array(
						'base'               => add_query_arg( 'paged', '%#%' ),
						'format'             => '',
						'total'              => $properties_query->max_num_pages,
						'current'            => max( 1, get_query_var( 'paged' ) ),
						'prev_text'          => '<span>' . esc_html__( 'Previous', 'deweboo-realestate' ) . '</span>',
						'next_text'          => '<span>' . esc_html__( 'Next', 'deweboo-realestate' ) . '</span>',
						'mid_size'           => 2,
						'show_all'           => false,
					) ) );
					?>
				</div>
				<?php
			} else {
				?>
				<div class="no-properties-message">
					<h2><?php esc_html_e( 'No properties found', 'deweboo-realestate' ); ?></h2>
					<p><?php esc_html_e( 'Sorry, we could not find any properties at this time. Please check back later.', 'deweboo-realestate' ); ?></p>
				</div>
				<?php
			}

			wp_reset_postdata();
			?>
		</main>

		<!-- Sidebar -->
		<?php if ( $has_primary_sidebar ) : ?>
		<aside class="col-lg-3">
			<?php
			// Sidebar widgets
			if ( $has_primary_sidebar ) {
				dynamic_sidebar( 'primary-sidebar' );
			}
			?>
		</aside>
		<?php endif; ?>
	</div>
</div>

<style>
	.properties-page {
		padding-top: 70px;
		padding-bottom: 100px;
	}

	.page-introduction {
		margin-bottom: 40px;
		padding: 36px 38px;
		background: #f5f1ec;
		border-left: 3px solid #9f8054;
		color: #26282b;
		line-height: 1.8;
		overflow-wrap: break-word;
		word-break: break-word;
	}

	.page-introduction p:last-child {
		margin-bottom: 0;
	}

	.properties-grid {
		display: grid;
		grid-template-columns: repeat(3, minmax(0, 1fr));
		gap: 30px;
	}

	.property-card {
		background: #fff;
		border: 1px solid #eaebee;
		border-top: 3px solid #9f8054;
		overflow: hidden;
		height: 100%;
		transition: transform 0.25s ease, box-shadow 0.25s ease;
	}

	.property-card:hover {
		transform: translateY( -4px );
		box-shadow: 10px 10px 40px rgba( 0, 0, 0, 0.08 );
	}

	.property-card .property-image {
		display: block;
		position: relative;
		height: 250px;
		background: #ebcfa7;
		overflow: hidden;
	}

	.property-image-placeholder {
		display: flex !important;
		align-items: center;
		justify-content: center;
		font-family: "Playfair Display", serif;
		font-size: 28px;
		color: #26282b;
		text-decoration: none;
	}

	.property-card .overlay {
		position: absolute;
		left: 0;
		right: 0;
		bottom: 0;
		top: 0;
		display: flex;
		align-items: center;
		justify-content: center;
		padding: 20px;
		background: rgba(38, 40, 43, 0.76);
		opacity: 0;
		transition: opacity 0.25s ease;
	}

	.property-card:hover .overlay {
		opacity: 1;
	}

	.property-card .view-btn {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		padding: 0 24px;
		height: 50px;
		font-size: 13px;
		font-weight: 600;
		text-transform: uppercase;
		letter-spacing: 0.04em;
		color: #fff;
		background: #9f8054;
	}

	.property-card .property-image img {
		width: 100%;
		height: 100%;
		display: block;
		object-fit: cover;
		transition: transform 0.3s ease;
	}

	.property-card:hover .property-image img {
		transform: scale(1.05);
	}

	.property-card .property-info {
		padding: 24px;
		overflow-wrap: break-word;
		word-break: break-word;
	}

	.property-info .property-meta {
		display: flex;
		flex-wrap: wrap;
		gap: 10px;
		margin-bottom: 14px;
	}

	.property-info .property-meta span {
		font-size: 11px;
		line-height: 1;
		padding: 5px 10px;
		background: #f5f1ec;
		color: #26282b;
		text-transform: uppercase;
		letter-spacing: 0.04em;
		font-weight: 600;
	}

	.property-highlights {
		display: flex;
		flex-wrap: wrap;
		gap: 8px;
		margin-bottom: 14px;
	}

	.highlight-chip {
		display: inline-block;
		padding: 6px 12px;
		font-size: 11px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.04em;
	}

	.highlight-price {
		background: #ebcfa7;
		color: #26282b;
	}

	.highlight-status.status-available {
		background: #d4edda;
		color: #155724;
	}

	.highlight-status.status-sold {
		background: #f8d7da;
		color: #721c24;
	}

	.highlight-status.status-reserved {
		background: #fff3cd;
		color: #856404;
	}

	.property-info h3 {
		font-size: 28px;
		line-height: 1.3;
		margin: 0 0 10px;
		font-family: "Playfair Display", serif;
	}

	.property-info h3 a {
		color: #26282b;
		text-decoration: none;
		overflow-wrap: break-word;
		word-break: break-word;
	}

	.property-info h3 a:hover {
		color: #9f8054;
		text-decoration: none;
	}

	.property-location {
		margin-bottom: 14px;
		font-size: 14px;
		color: #666;
	}

	.property-stats {
		display: flex;
		flex-wrap: wrap;
		gap: 0;
		margin-bottom: 16px;
		border: 1px solid #eaebee;
	}

	.property-stats span {
		flex: 1 1 33.33%;
		padding: 10px 12px;
		font-size: 12px;
		font-weight: 600;
		color: #26282b;
		text-align: center;
		border-right: 1px solid #eaebee;
	}

	.property-stats span:last-child {
		border-right: none;
	}

	.property-info .excerpt {
		margin-bottom: 16px;
		color: #666;
		line-height: 1.7;
		overflow-wrap: break-word;
		word-break: break-word;
		display: -webkit-box;
		line-clamp: 2;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
		overflow: hidden;
	}

	.property-info .read-more {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		font-weight: 600;
		color: #26282b;
		text-decoration: none;
		text-transform: uppercase;
		letter-spacing: 0.04em;
		font-size: 12px;
	}

	.property-info .read-more:hover {
		color: #9f8054;
		text-decoration: none;
	}

	.pagination-wrapper {
		margin-top: 45px;
	}

	.pagination-wrapper .nav-links,
	.pagination-wrapper .pagination {
		display: flex;
		flex-wrap: wrap;
		gap: 8px;
	}

	.pagination-wrapper .page-numbers {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-width: 46px;
		height: 46px;
		padding: 0 14px;
		border: 1px solid #dee2e6;
		background: #fff;
		color: #26282b;
		text-decoration: none;
		font-size: 13px;
		font-weight: 600;
	}

	.pagination-wrapper .page-numbers.current,
	.pagination-wrapper .page-numbers:hover {
		background: #9f8054;
		border-color: #9f8054;
		color: #fff;
	}

	.property-filters {
		background: #fff;
		border: 1px solid #eaebee;
		border-top: 3px solid #9f8054;
		padding: 25px;
	}

	.property-filters .widget-title {
		font-family: "Playfair Display", serif;
		font-size: 22px;
		margin-bottom: 20px;
		padding-bottom: 12px;
		border-bottom: 1px solid #eaebee;
	}

	.property-filters .filter-group h5 {
		font-size: 13px;
		margin-bottom: 10px;
		text-transform: uppercase;
		letter-spacing: 0.05em;
		color: #26282b;
	}

	.property-filters .filter-group ul {
		margin: 0;
		padding: 0;
		list-style: none;
	}

	.property-filters .filter-group li {
		margin-bottom: 0;
		border-bottom: 1px solid #f0ede8;
	}

	.property-filters .filter-group li:last-child {
		border-bottom: none;
	}

	.property-filters .filter-group a {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 10px 0;
		color: #666;
		text-decoration: none;
	}

	.property-filters .filter-group a:hover {
		color: #9f8054;
		text-decoration: none;
	}

	.property-sidebar-btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		height: 50px;
		padding: 0 24px;
		background: #9f8054;
		color: #fff;
		font-size: 12px;
		font-weight: 600;
		text-transform: uppercase;
		letter-spacing: 0.05em;
		text-decoration: none;
	}

	.property-sidebar-btn:hover {
		background: #26282b;
		color: #fff;
		text-decoration: none;
	}

	.no-properties-message {
		padding: 50px 35px;
		border-left: 3px solid #9f8054;
		background: #f5f1ec;
	}

	.no-properties-message h2 {
		font-family: "Playfair Display", serif;
		font-size: 34px;
		margin-bottom: 12px;
		color: #26282b;
	}

	.no-properties-message p {
		margin: 0;
		color: #666;
	}

	@media (max-width: 1199px) {
		.properties-grid {
			grid-template-columns: repeat(2, minmax(0, 1fr));
		}
	}

	@media (max-width: 767px) {
		.properties-page {
			padding-top: 50px;
			padding-bottom: 70px;
		}

		.page-introduction {
			padding: 24px 22px;
		}

		.properties-grid {
			grid-template-columns: 1fr;
			gap: 24px;
		}

		.property-card .property-image {
			height: 220px;
		}

		.property-info {
			padding: 20px;
		}

		.property-info h3 {
			font-size: 24px;
		}

		.property-stats span {
			flex: 1 1 100%;
			border-right: none;
			border-bottom: 1px solid #eaebee;
		}

		.property-stats span:last-child {
			border-bottom: none;
		}
	}
</style>

<?php
get_footer();
?>
