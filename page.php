<?php
/**
 * Default editable page template.
 *
 * @package Deweboo Real-Estate
 */

get_header();
?>

<section class="page-header">
	<div class="container">
		<h1><?php the_title(); ?></h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'deweboo-realestate' ); ?></a></li>
			<li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
		</ol>
	</div>
</section>

<main class="container" style="padding: 60px 0;">
	<?php
	while ( have_posts() ) {
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
				<?php
				the_content();
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'deweboo-realestate' ),
						'after'  => '</div>',
					)
				);
				?>
			</div>
		</article>
		<?php
	}
	?>
</main>

<?php
get_footer();
