<?php
/**
 * The template for search results
 *
 * @package DREAMASAHOMES
 */

get_header();
?>

<!-- Search Header -->
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h1>
					<?php
					if ( is_search() ) {
						/* translators: %s: search query */
						printf( esc_html__( 'Search Results for: %s', 'DREAMASAHOMES' ), '<span>' . get_search_query() . '</span>' );
					}
					?>
				</h1>
			</div>
		</div>
	</div>
</section>

<!-- Search Results -->
<div class="container">
	<div class="row">
		<main id="main-content" class="col-lg-8">
			<?php
			if ( have_posts() ) {
				?>
				<div class="search-results">
					<?php
					while ( have_posts() ) {
						the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'search-result-item' ); ?>>
							<div class="result-content">
								<?php
								if ( has_post_thumbnail() ) {
									?>
									<a href="<?php the_permalink(); ?>" class="result-thumbnail">
										<?php the_post_thumbnail( 'medium' ); ?>
									</a>
									<?php
								}
								?>

								<div class="result-info">
									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

									<div class="result-meta">
										<span class="post-type"><?php echo esc_html( get_post_type_object( get_post_type() )->labels->singular_name ); ?></span>
										<span class="post-date"><?php echo esc_html( get_the_date() ); ?></span>
										<span class="post-author">
											<?php esc_html_e( 'by', 'DREAMASAHOMES' ); ?>
											<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
												<?php the_author(); ?>
											</a>
										</span>
									</div>

									<p class="result-excerpt">
										<?php echo wp_trim_words( get_the_excerpt(), 25 ); ?>
									</p>

									<a href="<?php the_permalink(); ?>" class="read-more">
										<?php esc_html_e( 'Read More', 'DREAMASAHOMES' ); ?> <i class="fas fa-arrow-right"></i>
									</a>
								</div>
							</div>
						</article>
						<?php
					}

					// Pagination
					the_posts_pagination( array(
						'prev_text' => esc_html__( 'Previous', 'DREAMASAHOMES' ),
						'next_text' => esc_html__( 'Next', 'DREAMASAHOMES' ),
					) );
					?>
				</div>
				<?php
			} else {
				?>
				<div class="no-results">
					<h2><?php esc_html_e( 'No Results Found', 'DREAMASAHOMES' ); ?></h2>
					<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'DREAMASAHOMES' ); ?></p>

					<?php get_search_form(); ?>
				</div>
				<?php
			}
			?>
		</main>

		<!-- Sidebar -->
		<aside class="col-lg-4">
			<?php
			if ( is_active_sidebar( 'primary-sidebar' ) ) {
				dynamic_sidebar( 'primary-sidebar' );
			}
			?>

			<!-- Search Widget -->
			<div class="widget">
				<h3 class="widget-title"><?php esc_html_e( 'Search Again', 'DREAMASAHOMES' ); ?></h3>
				<?php get_search_form(); ?>
			</div>
		</aside>
	</div>
</div>

<?php
get_footer();
