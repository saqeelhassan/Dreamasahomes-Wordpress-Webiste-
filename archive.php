<?php
/**
 * The template for displaying archive pages
 *
 * @package Deweboo Real-Estate
 */

get_header();
?>

<!-- Archive Header -->
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h1>
					<?php
					if ( is_post_type_archive() ) {
						post_type_archive_title();
					} elseif ( is_category() ) {
						single_cat_title();
					} elseif ( is_tag() ) {
						single_tag_title();
					} elseif ( is_tax() ) {
						single_term_title();
					} else {
						esc_html_e( 'Archive', 'DREAMASAHOMES' );
					}
					?>
				</h1>

				<?php
				// Archive description
				$term_description = term_description();
				if ( ! empty( $term_description ) ) {
					echo '<div class="archive-description">' . wp_kses_post( $term_description ) . '</div>';
				}
				?>
			</div>
		</div>
	</div>
</section>

<!-- Archive Content -->
<div class="container">
	<div class="row">
		<main id="main-content" class="col-lg-8">
			<?php
			if ( have_posts() ) {
				?>
				<div class="archive-grid">
					<?php
					$index = 0;
					while ( have_posts() ) {
						the_post();
						$delay = ( $index % 3 ) * 0.05;
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'archive-item wow fadeInUp' ); ?> data-wow-delay="<?php echo esc_attr( $delay ); ?>s">
							<div class="item-card">
								<!-- Featured Image -->
								<?php
								if ( has_post_thumbnail() ) {
									?>
									<a href="<?php the_permalink(); ?>" class="item-image">
										<?php the_post_thumbnail( 'medium' ); ?>
										<div class="overlay">
											<span class="view-btn">
												<?php esc_html_e( 'View Details', 'DREAMASAHOMES' ); ?> <i class="fas fa-arrow-right"></i>
											</span>
										</div>
									</a>
									<?php
								}
								?>

								<!-- Item Info -->
								<div class="item-info">
									<div class="item-meta">
										<span class="date"><?php echo esc_html( get_the_date() ); ?></span>
										<?php
										// Show terms for custom post types
										if ( 'property' === get_post_type() ) {
											$terms = get_the_terms( get_the_ID(), 'property_type' );
											if ( $terms && ! is_wp_error( $terms ) ) {
												echo '<span class="term">' . esc_html( $terms[0]->name ) . '</span>';
											}
										} elseif ( 'apartment' === get_post_type() ) {
											$terms = get_the_terms( get_the_ID(), 'apartment_size' );
											if ( $terms && ! is_wp_error( $terms ) ) {
												echo '<span class="term">' . esc_html( $terms[0]->name ) . '</span>';
											}
										}
										?>
									</div>

									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

									<p class="excerpt">
										<?php echo wp_trim_words( get_the_excerpt(), 15 ); ?>
									</p>

									<a href="<?php the_permalink(); ?>" class="read-more">
										<?php esc_html_e( 'Learn More', 'DREAMASAHOMES' ); ?> <i class="fas fa-arrow-right"></i>
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
					the_posts_pagination( array(
						'prev_text' => '<span>' . esc_html__( 'Previous', 'DREAMASAHOMES' ) . '</span>',
						'next_text' => '<span>' . esc_html__( 'Next', 'DREAMASAHOMES' ) . '</span>',
						'mid_size'  => 2,
					) );
					?>
				</div>
				<?php
			} else {
				?>
				<div class="no-posts-message">
					<h2><?php esc_html_e( 'No items found', 'DREAMASAHOMES' ); ?></h2>
					<p><?php esc_html_e( 'Sorry, we could not find any items matching your request.', 'DREAMASAHOMES' ); ?></p>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
						<?php esc_html_e( 'Go Back Home', 'DREAMASAHOMES' ); ?>
					</a>
				</div>
				<?php
			}
			?>
		</main>

		<!-- Sidebar -->
		<aside class="col-lg-4">
			<?php
			// Custom filters for properties
			if ( is_post_type_archive( 'property' ) || is_tax( 'property_type' ) ) {
				?>
				<div class="widget property-filters">
					<h3 class="widget-title"><?php esc_html_e( 'Filter Properties', 'DREAMASAHOMES' ); ?></h3>

					<div class="filter-group">
						<h5><?php esc_html_e( 'Property Type', 'DREAMASAHOMES' ); ?></h5>
						<ul>
							<?php
							$terms = get_terms( array(
								'taxonomy'   => 'property_type',
								'hide_empty' => true,
							) );

							foreach ( $terms as $term ) {
								$count = $term->count;
								?>
								<li>
									<a href="<?php echo esc_url( get_term_link( $term ) ); ?>">
										<?php echo esc_html( $term->name ); ?>
										<span class="count"><?php echo esc_html( $count ); ?></span>
									</a>
								</li>
								<?php
							}
							?>
						</ul>
					</div>
				</div>
				<?php
			}

			// Custom filters for apartments
			if ( is_post_type_archive( 'apartment' ) || is_tax( 'apartment_size' ) ) {
				?>
				<div class="widget apartment-filters">
					<h3 class="widget-title"><?php esc_html_e( 'Filter Apartments', 'DREAMASAHOMES' ); ?></h3>

					<div class="filter-group">
						<h5><?php esc_html_e( 'Size', 'DREAMASAHOMES' ); ?></h5>
						<ul>
							<?php
							$terms = get_terms( array(
								'taxonomy'   => 'apartment_size',
								'hide_empty' => true,
							) );

							foreach ( $terms as $term ) {
								$count = $term->count;
								?>
								<li>
									<a href="<?php echo esc_url( get_term_link( $term ) ); ?>">
										<?php echo esc_html( $term->name ); ?>
										<span class="count"><?php echo esc_html( $count ); ?></span>
									</a>
								</li>
								<?php
							}
							?>
						</ul>
					</div>
				</div>
				<?php
			}

			// Regular sidebar widgets
			if ( is_active_sidebar( 'primary-sidebar' ) ) {
				dynamic_sidebar( 'primary-sidebar' );
			}
			?>
		</aside>
	</div>
</div>

<style>
	.archive-grid {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
		gap: 30px;
		margin: 40px 0;
	}

	@media ( max-width: 768px ) {
		.archive-grid {
			grid-template-columns: 1fr;
		}
	}

	.archive-item {
		position: relative;
	}

	.item-card {
		background: white;
		border-radius: 8px;
		overflow: hidden;
		box-shadow: 0 2px 8px rgba( 0, 0, 0, 0.1 );
		transition: all 0.3s ease;
		height: 100%;
		display: flex;
		flex-direction: column;
	}

	.item-card:hover {
		box-shadow: 0 8px 24px rgba( 0, 0, 0, 0.15 );
		transform: translateY( -5px );
	}

	.item-image {
		position: relative;
		display: block;
		overflow: hidden;
		height: 200px;
		background: #f0f0f0;
	}

	.item-image img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		transition: transform 0.3s ease;
	}

	.item-card:hover .item-image img {
		transform: scale( 1.05 );
	}

	.item-image .overlay {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: rgba( 40, 40, 40, 0.8 );
		display: flex;
		align-items: center;
		justify-content: center;
		opacity: 0;
		transition: opacity 0.3s ease;
	}

	.item-card:hover .item-image .overlay {
		opacity: 1;
	}

	.view-btn {
		color: white;
		font-weight: 600;
		display: flex;
		align-items: center;
		gap: 8px;
	}

	.item-info {
		padding: 20px;
		flex: 1;
		display: flex;
		flex-direction: column;
	}

	.item-meta {
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-size: 13px;
		color: #999;
		margin-bottom: 10px;
	}

	.item-meta .term {
		background: #282828;
		color: white;
		padding: 3px 8px;
		border-radius: 3px;
		font-size: 11px;
		text-transform: uppercase;
	}

	.item-card h3 {
		margin: 0 0 10px;
		font-size: 18px;
		line-height: 1.3;
	}

	.item-card h3 a {
		color: #282828;
		text-decoration: none;
		transition: color 0.3s ease;
	}

	.item-card h3 a:hover {
		color: #999;
	}

	.item-card .excerpt {
		flex: 1;
		font-size: 14px;
		color: #666;
		margin: 0 0 15px;
		line-height: 1.5;
	}

	.read-more {
		color: #282828;
		text-decoration: none;
		font-weight: 600;
		display: inline-flex;
		align-items: center;
		gap: 8px;
		transition: all 0.3s ease;
	}

	.read-more:hover {
		color: #999;
		transform: translateX( 5px );
	}

	.pagination-wrapper {
		margin: 40px 0;
		text-align: center;
	}

	.no-posts-message {
		text-align: center;
		padding: 60px 20px;
	}

	.widget-title {
		border-bottom: 2px solid #282828;
		padding-bottom: 10px;
	}

	.filter-group {
		margin-bottom: 20px;
	}

	.filter-group h5 {
		font-size: 14px;
		text-transform: uppercase;
		margin-bottom: 10px;
		color: #282828;
	}

	.filter-group ul {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.filter-group li {
		margin-bottom: 8px;
	}

	.filter-group a {
		color: #666;
		text-decoration: none;
		display: flex;
		justify-content: space-between;
		align-items: center;
		transition: color 0.3s ease;
		font-size: 14px;
	}

	.filter-group a:hover {
		color: #282828;
		font-weight: 600;
	}

	.filter-group .count {
		background: #f0f0f0;
		padding: 2px 6px;
		border-radius: 3px;
		font-size: 12px;
	}
</style>

<?php
get_footer();
