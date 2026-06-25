<?php
/**
 * Template for FAQ page
 *
 * @package Deweboo Real-Estate
 */

get_header();
?>

<!-- FAQ Header -->
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
	</div>
</section>

<!-- FAQ Content -->
<div class="container">
	<div class="row">
		<main id="main-content" class="col-lg-8">
			<?php
			while ( have_posts() ) {
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="page-content wow fadeInUp">
						<?php
						the_content();

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'deweboo-realestate' ),
							'after'  => '</div>',
						) );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
						?>
					</div>
				</article>
				<?php
			}
			wp_reset_postdata();
			?>
		</main>

		<!-- Sidebar -->
		<aside class="col-lg-4">
			<!-- Contact CTA -->
			<div class="widget contact-cta">
				<h3 class="widget-title"><?php esc_html_e( 'Still Have Questions?', 'deweboo-realestate' ); ?></h3>
				<p><?php esc_html_e( 'Didn\'t find the answer you\'re looking for? Contact our team for more information.', 'deweboo-realestate' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="btn btn-primary">
					<?php esc_html_e( 'Contact Us', 'deweboo-realestate' ); ?>
				</a>
			</div>

			<hr>

			<?php
			// Sidebar widgets
			if ( is_active_sidebar( 'primary-sidebar' ) ) {
				dynamic_sidebar( 'primary-sidebar' );
			}
			?>
		</aside>
	</div>
</div>

<?php
get_footer();
?>
