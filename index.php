<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display blog posts, archives, and search results.
 *
 * @package DREAMASAHOMES
 */

get_header();
?>

<!-- Blog/Archive Header -->
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h1>
					<?php
					if ( is_search() ) {
						/* translators: %s is search query */
						printf( esc_html__( 'Search Results for: %s', 'DREAMASAHOMES' ), '<span>' . get_search_query() . '</span>' );
					} elseif ( is_archive() ) {
						the_archive_title();
					} else {
						esc_html_e( 'Blog', 'DREAMASAHOMES' );
					}
					?>
				</h1>
			</div>
		</div>
	</div>
</section>

<!-- Blog Content -->
<div class="container" style="padding: 60px 0;">
	<div class="row">
		<main id="main-content" class="col-lg-8">
			<?php
			if ( have_posts() ) {
				?>
				<div class="blog-posts">
					<?php
					while ( have_posts() ) {
						the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post-item' ); ?> style="margin-bottom: 40px;">
							<div class="post-content" style="border-bottom: 1px solid #e0e0e0; padding-bottom: 30px;">
								<?php
								// Display post featured image
								if ( has_post_thumbnail() ) {
									?>
									<div class="post-image" style="margin-bottom: 20px;">
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail( 'large', array( 'style' => 'width: 100%; height: auto;' ) ); ?>
										</a>
									</div>
									<?php
								}
								?>
								
								<div class="post-meta" style="margin-bottom: 15px;">
									<span class="post-date" style="color: #999; margin-right: 20px;">
										<i class="fas fa-calendar"></i> <?php echo esc_html( get_the_date() ); ?>
									</span>
									<span class="post-author" style="color: #999; margin-right: 20px;">
										<i class="fas fa-user"></i> <?php the_author_posts_link(); ?>
									</span>
									<span class="post-category" style="color: #999;">
										<i class="fas fa-folder"></i> <?php the_category( ', ' ); ?>
									</span>
								</div>

								<h2 class="post-title" style="font-size: 24px; margin: 15px 0;">
									<a href="<?php the_permalink(); ?>" style="color: #333; text-decoration: none;">
										<?php the_title(); ?>
									</a>
								</h2>

								<div class="post-excerpt" style="color: #666; line-height: 1.6; margin: 15px 0;">
									<?php
									if ( has_excerpt() ) {
										the_excerpt();
									} else {
										echo wp_trim_words( get_the_content(), 55, '...' );
									}
									?>
								</div>

								<a href="<?php the_permalink(); ?>" class="read-more-link" style="color: #ebcfa7; font-weight: bold; text-decoration: none;">
									<?php esc_html_e( 'Read More', 'DREAMASAHOMES' ); ?> <i class="fas fa-caret-right"></i>
								</a>
							</div>
						</article>
						<?php
					}
					?>
				</div>

				<!-- Pagination -->
				<div class="pagination-section" style="margin: 40px 0; text-align: center;">
					<?php
					echo wp_kses_post( paginate_links( array(
						'type'      => 'list',
						'prev_text' => esc_html__( '&laquo; Previous', 'DREAMASAHOMES' ),
						'next_text' => esc_html__( 'Next &raquo;', 'DREAMASAHOMES' ),
					) ) );
					?>
				</div>
				<?php
			} else {
				?>
				<div class="no-posts" style="text-align: center; padding: 60px 20px;">
					<h2><?php esc_html_e( 'No Posts Found', 'DREAMASAHOMES' ); ?></h2>
					<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'DREAMASAHOMES' ); ?></p>
				</div>
				<?php
			}
			?>
		</main>

		<!-- Sidebar -->
		<aside id="sidebar" class="col-lg-4">
			<div class="sidebar-content">
				<?php
				if ( is_active_sidebar( 'primary-sidebar' ) ) {
					dynamic_sidebar( 'primary-sidebar' );
				} else {
					?>
					<div class="sidebar-widget" style="margin-bottom: 30px; padding: 20px; background: #f9f9f9;">
						<h3 style="margin-top: 0;"><?php esc_html_e( 'Recent Posts', 'DREAMASAHOMES' ); ?></h3>
						<ul style="list-style: none; padding: 0; margin: 0;">
							<?php
							$recent = new WP_Query( array(
								'posts_per_page' => 5,
								'post_type'      => 'post',
								'orderby'        => 'date',
								'order'          => 'DESC',
							) );
							if ( $recent->have_posts() ) {
								while ( $recent->have_posts() ) {
									$recent->the_post();
									?>
									<li style="padding: 8px 0; border-bottom: 1px solid #e0e0e0;">
										<a href="<?php the_permalink(); ?>" style="color: #333; text-decoration: none;">
											<?php the_title(); ?>
										</a>
									</li>
									<?php
								}
								wp_reset_postdata();
							}
							?>
						</ul>
					</div>
					<?php
				}
				?>
			</div>
		</aside>
	</div>
</div>

<?php
get_footer();
