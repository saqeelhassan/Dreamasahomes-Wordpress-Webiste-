<?php
/**
 * The template for displaying 404 errors
 *
 * @package Deweboo Real-Estate
 */

get_header();
?>

<!-- 404 Error Section -->
<section class="error-404-section">
	<div class="container">
		<div class="row">
			<main id="main-content" class="col-12">
				<div class="error-container wow fadeInUp">
					<div class="error-code">
						<h1>404</h1>
					</div>

					<article id="post-0" class="post no-results not-found">
						<header class="entry-header">
							<h2 class="entry-title">
								<?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'DREAMASAHOMES' ); ?>
							</h2>
						</header>
						<!-- .entry-header -->

						<div class="entry-content">
							<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'DREAMASAHOMES' ); ?></p>

							<?php
							get_search_form();

							the_widget( 'WP_Widget_Recent_Posts' );
							?>

							<div class="widget widget-first">
								<h2 class="widget-title">
									<?php esc_html_e( 'Most Used Categories', 'DREAMASAHOMES' ); ?>
								</h2>
								<ul>
									<?php
									wp_list_categories( array(
										'orderby'            => 'count',
										'order'              => 'DESC',
										'show_count'         => 1,
										'title_li'           => '',
										'number'             => 10,
										'walker'             => new Walker_Category(),
										'hide_empty'         => 1,
									) );
									?>
								</ul>
							</div>

							<?php
							/* translators: %1$s: smiley */
							$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'DREAMASAHOMES' ), convert_smilies( ':)' ) ) . '</p>';
							the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

							the_widget( 'WP_Widget_Tag_Cloud' );
							?>
						</div>
						<!-- .entry-content -->
					</article>
					<!-- #post-0 -->

					<div class="error-actions">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
							<?php esc_html_e( 'Back to Home', 'DREAMASAHOMES' ); ?> <i class="fas fa-home"></i>
						</a>
					</div>
				</div>
			</main>
		</div>
	</div>
</section>

<style>
	.error-404-section {
		padding: 80px 0;
		text-align: center;
		min-height: calc(100vh - 200px);
		display: flex;
		align-items: center;
	}

	.error-container {
		padding: 40px;
		background: #f8f9fa;
		border-radius: 10px;
	}

	.error-code h1 {
		font-size: 120px;
		font-weight: bold;
		color: #282828;
		margin: 0;
		line-height: 1;
	}

	.error-404-section h2 {
		font-size: 32px;
		margin: 20px 0;
	}

	.error-404-section p {
		font-size: 18px;
		color: #666;
		margin-bottom: 30px;
	}

	.error-actions {
		margin-top: 40px;
	}

	.error-404-section .btn-primary {
		padding: 12px 30px;
		font-size: 16px;
		text-decoration: none;
		display: inline-block;
		background: #282828;
		color: white;
		border-radius: 5px;
		transition: all 0.3s ease;
	}

	.error-404-section .btn-primary:hover {
		background: #1a1a1a;
		color: white;
	}

	.error-404-section .widget {
		text-align: left;
		margin: 30px 0;
		padding: 20px;
		background: white;
		border-radius: 5px;
	}

	.error-404-section .widget-title {
		margin-top: 0;
		padding-bottom: 15px;
		border-bottom: 2px solid #282828;
	}

	.error-404-section .widget ul {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.error-404-section .widget li {
		padding: 8px 0;
		border-bottom: 1px solid #eee;
	}

	.error-404-section .widget li:last-child {
		border-bottom: none;
	}

	.error-404-section .widget a {
		color: #282828;
		text-decoration: none;
		transition: color 0.3s ease;
	}

	.error-404-section .widget a:hover {
		color: #666;
	}
</style>

<?php
get_footer();
