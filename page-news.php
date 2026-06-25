<?php
/**
 * Template for News page.
 *
 * Ports the Hompark news layout into WordPress while keeping post data dynamic.
 *
 * @package Deweboo Real-Estate
 */

get_header();

$theme_uri     = get_template_directory_uri();
$page_id = get_queried_object_id();
$builder_content = deweboo_realestate_get_builder_content(
	$page_id,
	array( '[deweboo_latest_posts]', '[deweboo_news_grid]' )
);
$current_page  = max( 1, get_query_var( 'paged' ) );
$news_query    = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => 4,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'paged'          => $current_page,
	)
);

$fallback_intro = __( 'Stay informed with real estate market trends, buying guides, and property investment updates from Dreamasa Homes.', 'deweboo-realestate' );
$static_tags    = array( 'Property Market', 'Home Buying', 'Real Estate Tips', 'Apartments', 'Villas', 'Investment', 'Mortgage', 'Neighborhood Guides', 'Property Prices' );
$gallery_images = array(
	'gallery-thumb01.jpg',
	'gallery-thumb02.jpg',
	'gallery-thumb03.jpg',
	'gallery-thumb04.jpg',
	'gallery-thumb05.jpg',
	'gallery-thumb06.jpg',
);
?>

<!-- News Header -->
<header class="page-header" data-stellar-background-ratio="1.15">
	<div class="container">
		<h1><?php the_title(); ?></h1>
		<p><?php esc_html_e( 'Latest real estate news, property insights, and practical buying advice', 'deweboo-realestate' ); ?></p>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'deweboo-realestate' ); ?></a></li>
			<li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
		</ol>
	</div>
</header>

<!-- News Content -->
<div class="container news-page">
	<div class="row">
		<main id="main-content" class="col-lg-8">
			<div class="news-introduction wow fadeInUp">
				<?php if ( '' !== $builder_content ) : ?>
					<?php echo wp_kses_post( $builder_content ); ?>
				<?php else : ?>
					<p><?php echo esc_html( $fallback_intro ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( $news_query->have_posts() ) : ?>
				<div class="news-grid">
					<?php
					while ( $news_query->have_posts() ) :
						$news_query->the_post();
						$post_categories = get_the_category();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'news-item wow fadeInUp' ); ?>>
							<div class="news-card">
								<a href="<?php the_permalink(); ?>" class="news-image">
									<?php
									if ( has_post_thumbnail() ) {
										the_post_thumbnail( 'medium_large' );
									} else {
										?>
										<img src="<?php echo esc_url( $theme_uri . '/images/blog01.webp' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
										<?php
									}
									?>
									<span class="news-overlay"><?php esc_html_e( 'Read More', 'deweboo-realestate' ); ?></span>
								</a>

								<div class="news-content">
									<div class="news-meta">
										<span><?php echo esc_html( get_the_date( 'M d, Y' ) ); ?></span>
										<?php if ( ! empty( $post_categories ) ) : ?>
											<span><?php echo esc_html( $post_categories[0]->name ); ?></span>
										<?php endif; ?>
									</div>

									<h2 class="news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<p class="news-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '...' ) ); ?></p>
									<a href="<?php the_permalink(); ?>" class="news-read-more"><?php esc_html_e( 'Read Full Article', 'deweboo-realestate' ); ?> <i class="fas fa-arrow-right"></i></a>
								</div>
							</div>
						</article>
					<?php endwhile; ?>
				</div>

				<div class="pagination-wrapper">
					<?php
					echo wp_kses_post(
						paginate_links(
							array(
								'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
								'format'    => '?paged=%#%',
								'current'   => $current_page,
								'total'     => $news_query->max_num_pages,
								'prev_text' => esc_html__( 'Previous', 'deweboo-realestate' ),
								'next_text' => esc_html__( 'Next', 'deweboo-realestate' ),
							)
						)
					);
					?>
				</div>
			<?php else : ?>
				<div class="no-news-message">
					<h2><?php esc_html_e( 'No news found', 'deweboo-realestate' ); ?></h2>
					<p><?php esc_html_e( 'Sorry, we could not find any news articles at this time. Please check back later.', 'deweboo-realestate' ); ?></p>
				</div>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</main>

		<aside class="col-lg-4">
			<div class="news-sidebar-widget">
				<h4 class="widget-title"><?php esc_html_e( 'Categories', 'deweboo-realestate' ); ?></h4>
				<ul class="sidebar-list">
					<?php
					$sidebar_categories = get_categories( array( 'hide_empty' => true ) );
					foreach ( array_slice( $sidebar_categories, 0, 7 ) as $sidebar_category ) :
						?>
						<li><a href="<?php echo esc_url( get_category_link( $sidebar_category->term_id ) ); ?>"><?php echo esc_html( $sidebar_category->name ); ?></a><span><?php echo intval( $sidebar_category->count ); ?></span></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="news-sidebar-widget">
				<h4 class="widget-title"><?php esc_html_e( 'Search', 'deweboo-realestate' ); ?></h4>
				<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="news-search-form">
					<input type="text" name="s" placeholder="<?php esc_attr_e( 'Search articles and property updates', 'deweboo-realestate' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
					<button type="submit"><i class="fas fa-search"></i></button>
				</form>
			</div>

			<div class="news-sidebar-widget">
				<h4 class="widget-title"><?php esc_html_e( 'Tags', 'deweboo-realestate' ); ?></h4>
				<ul class="sidebar-tags">
					<?php
					$site_tags = get_tags(
						array(
							'hide_empty' => true,
							'number'     => 9,
						)
					);
					if ( ! empty( $site_tags ) ) :
						foreach ( $site_tags as $site_tag ) :
							?>
							<li><a href="<?php echo esc_url( get_tag_link( $site_tag->term_id ) ); ?>"><?php echo esc_html( $site_tag->name ); ?></a></li>
						<?php endforeach; ?>
					<?php else : ?>
						<?php foreach ( $static_tags as $static_tag ) : ?>
							<li><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>"><?php echo esc_html( $static_tag ); ?></a></li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>

			<div class="news-sidebar-widget">
				<h4 class="widget-title"><?php esc_html_e( 'Property Gallery', 'deweboo-realestate' ); ?></h4>
				<ul class="side-gallery">
					<?php foreach ( $gallery_images as $gallery_image ) : ?>
						<li>
							<a href="<?php echo esc_url( $theme_uri . '/images/' . $gallery_image ); ?>" data-fancybox>
								<img src="<?php echo esc_url( $theme_uri . '/images/' . $gallery_image ); ?>" alt="<?php esc_attr_e( 'Project gallery image', 'deweboo-realestate' ); ?>">
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<?php if ( is_active_sidebar( 'primary-sidebar' ) ) : ?>
				<?php dynamic_sidebar( 'primary-sidebar' ); ?>
			<?php endif; ?>
		</aside>
	</div>
</div>

<style>
	.news-page {
		padding: 70px 0 100px;
	}

	.news-introduction {
		margin-bottom: 30px;
		padding: 24px 28px;
		background: #f5f1ec;
		border-left: 3px solid #9f8054;
	}

	.news-grid {
		display: grid;
		gap: 28px;
	}

	.news-card {
		background: #fff;
		border: 1px solid #eaebee;
		border-top: 3px solid #9f8054;
		overflow: hidden;
	}

	.news-image {
		display: block;
		position: relative;
		height: 280px;
		overflow: hidden;
	}

	.news-image img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		transition: transform 0.3s ease;
	}

	.news-card:hover .news-image img {
		transform: scale(1.04);
	}

	.news-overlay {
		position: absolute;
		inset: 0;
		display: flex;
		align-items: center;
		justify-content: center;
		background: rgba(38, 40, 43, 0.74);
		color: #fff;
		font-size: 12px;
		font-weight: 700;
		letter-spacing: 0.04em;
		text-transform: uppercase;
		opacity: 0;
		transition: opacity 0.25s ease;
	}

	.news-card:hover .news-overlay {
		opacity: 1;
	}

	.news-content {
		padding: 24px;
	}

	.news-meta {
		display: flex;
		gap: 8px;
		flex-wrap: wrap;
		margin-bottom: 12px;
	}

	.news-meta span {
		font-size: 11px;
		font-weight: 600;
		letter-spacing: 0.04em;
		text-transform: uppercase;
		padding: 5px 10px;
		background: #f5f1ec;
		color: #26282b;
	}

	.news-title {
		margin: 0 0 10px;
		font-size: 30px;
		font-family: "Playfair Display", serif;
		line-height: 1.2;
	}

	.news-title a {
		color: #26282b;
		text-decoration: none;
	}

	.news-title a:hover {
		color: #9f8054;
	}

	.news-excerpt {
		margin: 0 0 14px;
		color: #666;
		line-height: 1.7;
	}

	.news-read-more {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		font-size: 12px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.04em;
		text-decoration: none;
		color: #26282b;
	}

	.news-read-more:hover {
		color: #9f8054;
		text-decoration: none;
	}

	.pagination-wrapper {
		margin-top: 36px;
	}

	.pagination-wrapper .page-numbers {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		min-width: 44px;
		height: 44px;
		padding: 0 14px;
		margin-right: 6px;
		border: 1px solid #dee2e6;
		text-decoration: none;
		font-size: 13px;
		font-weight: 600;
		color: #26282b;
		background: #fff;
	}

	.pagination-wrapper .page-numbers.current,
	.pagination-wrapper .page-numbers:hover {
		background: #9f8054;
		border-color: #9f8054;
		color: #fff;
	}

	.no-news-message {
		padding: 40px 32px;
		background: #f5f1ec;
		border-left: 3px solid #9f8054;
	}

	.no-news-message h2 {
		font-family: "Playfair Display", serif;
		font-size: 30px;
		margin-bottom: 10px;
	}

	.news-sidebar-widget {
		border: 1px solid #eaebee;
		border-top: 3px solid #9f8054;
		padding: 22px;
		margin-bottom: 24px;
		background: #fff;
	}

	.news-sidebar-widget .widget-title {
		font-family: "Playfair Display", serif;
		font-size: 22px;
		margin: 0 0 14px;
		padding-bottom: 10px;
		border-bottom: 1px solid #eaebee;
	}

	.sidebar-list,
	.sidebar-tags {
		list-style: none;
		margin: 0;
		padding: 0;
	}

	.sidebar-list li {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 10px 0;
		border-bottom: 1px solid #f0ede8;
	}

	.sidebar-list li:last-child {
		border-bottom: none;
	}

	.sidebar-list li a {
		color: #666;
		text-decoration: none;
	}

	.sidebar-list li a:hover {
		color: #9f8054;
	}

	.sidebar-list li span {
		font-size: 11px;
		font-weight: 700;
		padding: 2px 8px;
		background: #ebcfa7;
		color: #26282b;
	}

	.news-search-form {
		display: flex;
		border: 1px solid #eaebee;
	}

	.news-search-form input {
		flex: 1;
		border: none;
		height: 48px;
		padding: 0 14px;
	}

	.news-search-form button {
		width: 48px;
		border: none;
		background: #9f8054;
		color: #fff;
	}

	.sidebar-tags {
		display: flex;
		flex-wrap: wrap;
		gap: 8px;
	}

	.sidebar-tags li a {
		display: inline-block;
		padding: 6px 12px;
		font-size: 11px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.04em;
		text-decoration: none;
		background: #f5f1ec;
		color: #26282b;
	}

	.sidebar-tags li a:hover {
		background: #9f8054;
		color: #fff;
	}

	.side-gallery {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 8px;
		list-style: none;
		margin: 0;
		padding: 0;
	}

	.side-gallery li a {
		display: block;
		height: 70px;
		overflow: hidden;
	}

	.side-gallery img {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}

	@media (max-width: 991px) {
		.news-page {
			padding: 50px 0 80px;
		}

		.news-title {
			font-size: 26px;
		}
	}

	@media (max-width: 767px) {
		.news-image {
			height: 220px;
		}

		.news-content {
			padding: 18px;
		}

		.news-title {
			font-size: 22px;
		}
	}
</style>

<?php
get_footer();
?>
