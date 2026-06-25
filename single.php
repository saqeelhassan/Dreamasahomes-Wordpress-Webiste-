<?php
/**
 * The template for displaying single posts/custom post types
 *
 * @package Deweboo Real-Estate
 */

get_header();
?>

<!-- Page Header -->
<header class="page-header" data-stellar-background-ratio="1.15">
	<div class="container">
		<h1><?php single_post_title(); ?></h1>
		<p><?php esc_html_e( 'Explore property and post details', 'DREAMASAHOMES' ); ?></p>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'DREAMASAHOMES' ); ?></a></li>
			<li class="breadcrumb-item active" aria-current="page"><?php single_post_title(); ?></li>
		</ol>
	</div>
</header>

<!-- Single Post/CPT -->
<div class="container">
	<div class="row">
		<main id="main-content" class="col-lg-8">
			<?php
			while ( have_posts() ) {
				the_post();

				// Get post type info
				$post_type       = get_post_type();
				$post_type_obj   = get_post_type_object( $post_type );
				$post_type_label = $post_type_obj->labels->singular_name;
				$is_property     = 'property' === $post_type;

				$property_price     = get_post_meta( get_the_ID(), '_property_price', true );
				$property_location  = get_post_meta( get_the_ID(), '_property_location', true );
				$property_area      = get_post_meta( get_the_ID(), '_property_area', true );
				$property_bedrooms  = get_post_meta( get_the_ID(), '_property_bedrooms', true );
				$property_bathrooms = get_post_meta( get_the_ID(), '_property_bathrooms', true );
				$property_status    = get_post_meta( get_the_ID(), '_property_status', true );
				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( $is_property ? 'single-post-item single-property-item' : 'single-post-item' ); ?>>
					<!-- Featured Image -->
					<?php
					if ( has_post_thumbnail() ) {
						?>
						<figure class="featured-image <?php echo esc_attr( $is_property ? 'property-featured-image' : '' ); ?> wow fadeInUp">
							<?php the_post_thumbnail( 'large' ); ?>
						</figure>
						<?php
					}
					?>

					<!-- Post Header -->
					<?php if ( $is_property ) : ?>
					<div class="property-info-panel">
					<?php endif; ?>
					<header class="entry-header wow fadeInUp">
						<div class="entry-meta">
							<span class="post-type">
								<?php echo esc_html( $post_type_label ); ?>
							</span>
							<span class="post-date">
								<?php echo esc_html( get_the_date() ); ?>
							</span>
							<span class="post-author">
								<?php esc_html_e( 'By', 'DREAMASAHOMES' ); ?>
								<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
									<?php the_author(); ?>
								</a>
							</span>
						</div>

						<h1 class="entry-title"><?php the_title(); ?></h1>

						<?php if ( $is_property ) : ?>
							<div class="property-quick-meta">
								<?php if ( ! empty( $property_price ) ) : ?>
									<span class="property-chip property-chip-price">&#128176; <?php echo esc_html( $property_price ); ?></span>
								<?php endif; ?>
								<?php if ( ! empty( $property_status ) ) : ?>
									<span class="property-chip property-chip-status status-<?php echo esc_attr( $property_status ); ?>"><?php echo esc_html( ucfirst( $property_status ) ); ?></span>
								<?php endif; ?>
								<?php if ( ! empty( $property_location ) ) : ?>
									<span class="property-chip">&#128205; <?php echo esc_html( $property_location ); ?></span>
								<?php endif; ?>
							</div>

							<div class="property-stats-grid">
								<?php if ( ! empty( $property_area ) ) : ?>
									<div class="property-stat-card">
										<span class="property-stat-icon">&#9632;</span>
										<small><?php esc_html_e( 'Area', 'DREAMASAHOMES' ); ?></small>
										<strong><?php echo esc_html( $property_area ); ?> m&sup2;</strong>
									</div>
								<?php endif; ?>
								<?php if ( '' !== (string) $property_bedrooms ) : ?>
									<div class="property-stat-card">
										<span class="property-stat-icon">&#127968;</span>
										<small><?php esc_html_e( 'Bedrooms', 'DREAMASAHOMES' ); ?></small>
										<strong><?php echo esc_html( $property_bedrooms ); ?></strong>
									</div>
								<?php endif; ?>
								<?php if ( '' !== (string) $property_bathrooms ) : ?>
									<div class="property-stat-card">
										<span class="property-stat-icon">&#128703;</span>
										<small><?php esc_html_e( 'Bathrooms', 'DREAMASAHOMES' ); ?></small>
										<strong><?php echo esc_html( $property_bathrooms ); ?></strong>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php
						// Show categories/taxonomies
						$taxonomies = get_object_taxonomies( $post_type, 'objects' );
						foreach ( $taxonomies as $taxonomy ) {
							$terms = get_the_terms( get_the_ID(), $taxonomy->name );
							if ( $terms && ! is_wp_error( $terms ) ) {
								?>
								<div class="entry-terms">
									<strong><?php echo esc_html( $taxonomy->label ); ?>:</strong>
									<?php
									$term_links = array();
									foreach ( $terms as $term ) {
										$term_links[] = '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
									}
									echo wp_kses_post( implode( ', ', $term_links ) );
									?>
								</div>
								<?php
							}
						}
						?>
					</header>
					<?php if ( $is_property ) : ?>
					</div><!-- /.property-info-panel -->
					<?php endif; ?>

					<!-- Post Content -->
					<div class="entry-content wow fadeInUp">
						<?php
						the_content();

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'DREAMASAHOMES' ),
							'after'  => '</div>',
						) );
						?>
					</div>

					<?php if ( $is_property ) : ?>
					<!-- Property CTA -->
					<div class="property-cta-box wow fadeInUp">
						<h4><?php esc_html_e( 'Interested in this property?', 'DREAMASAHOMES' ); ?></h4>
						<p><?php esc_html_e( 'Get in touch with our team and schedule a viewing today.', 'DREAMASAHOMES' ); ?></p>
						<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="property-cta-btn"><?php esc_html_e( 'Contact Us', 'DREAMASAHOMES' ); ?></a>
					</div>
					<?php endif; ?>

					<!-- Post Footer -->
					<footer class="entry-footer wow fadeInUp">
						<?php
						$tags = get_the_tags();
						if ( $tags ) {
							?>
							<div class="entry-tags">
								<strong><?php esc_html_e( 'Tags:', 'DREAMASAHOMES' ); ?></strong>
								<?php
								$tag_links = array();
								foreach ( $tags as $tag ) {
									$tag_links[] = '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="tag-link">' . esc_html( $tag->name ) . '</a>';
								}
								echo wp_kses_post( implode( ', ', $tag_links ) );
								?>
							</div>
							<?php
						}
						?>

						<!-- Share Buttons -->
						<div class="share-buttons">
							<strong><?php esc_html_e( 'Share:', 'DREAMASAHOMES' ); ?></strong>
							<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>" target="_blank" class="share-btn facebook">
								<i class="fab fa-facebook-f"></i>
							</a>
							<a href="https://twitter.com/intent/tweet?url=<?php echo esc_url( get_permalink() ); ?>&text=<?php echo esc_attr( get_the_title() ); ?>" target="_blank" class="share-btn twitter">
								<i class="fab fa-twitter"></i>
							</a>
							<a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo esc_url( get_permalink() ); ?>" target="_blank" class="share-btn linkedin">
								<i class="fab fa-linkedin-in"></i>
							</a>
						</div>
					</footer>
				</article>

				<?php
				// Previous/Next Post Navigation
				the_post_navigation( array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'DREAMASAHOMES' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'DREAMASAHOMES' ) . '</span> <span class="nav-title">%title</span>',
				) );

				// Comments section
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			}
			wp_reset_postdata();
			?>
		</main>

		<!-- Sidebar -->
		<aside class="col-lg-4">
			<?php
			if ( is_active_sidebar( 'primary-sidebar' ) ) {
				dynamic_sidebar( 'primary-sidebar' );
			}

			// Related posts for properties
			if ( 'property' === get_post_type() ) {

				// ── Property Details widget ────────────────────────────
				$sidebar_price     = get_post_meta( get_the_ID(), '_property_price', true );
				$sidebar_location  = get_post_meta( get_the_ID(), '_property_location', true );
				$sidebar_area      = get_post_meta( get_the_ID(), '_property_area', true );
				$sidebar_bedrooms  = get_post_meta( get_the_ID(), '_property_bedrooms', true );
				$sidebar_bathrooms = get_post_meta( get_the_ID(), '_property_bathrooms', true );
				$sidebar_status    = get_post_meta( get_the_ID(), '_property_status', true );

				if ( $sidebar_price || $sidebar_location || $sidebar_area || '' !== (string) $sidebar_bedrooms || '' !== (string) $sidebar_bathrooms || $sidebar_status ) {
					?>
					<div class="widget sidebar-property-details">
						<h3 class="widget-title"><?php esc_html_e( 'Property Details', 'DREAMASAHOMES' ); ?></h3>
						<ul class="sidebar-detail-list">
							<?php if ( ! empty( $sidebar_price ) ) : ?>
								<li>
									<span class="detail-label"><?php esc_html_e( 'Price', 'DREAMASAHOMES' ); ?></span>
									<span class="detail-value detail-price"><?php echo esc_html( $sidebar_price ); ?></span>
								</li>
							<?php endif; ?>
							<?php if ( ! empty( $sidebar_status ) ) : ?>
								<li>
									<span class="detail-label"><?php esc_html_e( 'Status', 'DREAMASAHOMES' ); ?></span>
									<span class="detail-value status-badge status-<?php echo esc_attr( $sidebar_status ); ?>"><?php echo esc_html( ucfirst( $sidebar_status ) ); ?></span>
								</li>
							<?php endif; ?>
							<?php if ( ! empty( $sidebar_location ) ) : ?>
								<li>
									<span class="detail-label"><?php esc_html_e( 'Location', 'DREAMASAHOMES' ); ?></span>
									<span class="detail-value"><?php echo esc_html( $sidebar_location ); ?></span>
								</li>
							<?php endif; ?>
							<?php if ( ! empty( $sidebar_area ) ) : ?>
								<li>
									<span class="detail-label"><?php esc_html_e( 'Area', 'DREAMASAHOMES' ); ?></span>
									<span class="detail-value"><?php echo esc_html( $sidebar_area ); ?> m&sup2;</span>
								</li>
							<?php endif; ?>
							<?php if ( '' !== (string) $sidebar_bedrooms ) : ?>
								<li>
									<span class="detail-label"><?php esc_html_e( 'Bedrooms', 'DREAMASAHOMES' ); ?></span>
									<span class="detail-value"><?php echo esc_html( $sidebar_bedrooms ); ?></span>
								</li>
							<?php endif; ?>
							<?php if ( '' !== (string) $sidebar_bathrooms ) : ?>
								<li>
									<span class="detail-label"><?php esc_html_e( 'Bathrooms', 'DREAMASAHOMES' ); ?></span>
									<span class="detail-value"><?php echo esc_html( $sidebar_bathrooms ); ?></span>
								</li>
							<?php endif; ?>
						</ul>
					</div>
					<?php
				}

				// ── Contact CTA widget ─────────────────────────────────
				?>
				<div class="widget sidebar-contact-cta">
				<?php
				// ── Why Choose Us widget (always visible) ─────────────
				?>
				<div class="widget sidebar-features">
					<h3 class="widget-title"><?php esc_html_e( 'Why Choose Us', 'DREAMASAHOMES' ); ?></h3>
					<ul class="sidebar-features-list">
						<li>
							<span class="sf-icon">&#10003;</span>
							<div>
								<strong><?php esc_html_e( 'Expert Guidance', 'DREAMASAHOMES' ); ?></strong>
								<p><?php esc_html_e( 'Professional advice at every step of your property journey.', 'DREAMASAHOMES' ); ?></p>
							</div>
						</li>
						<li>
							<span class="sf-icon">&#10003;</span>
							<div>
								<strong><?php esc_html_e( 'Verified Listings', 'DREAMASAHOMES' ); ?></strong>
								<p><?php esc_html_e( 'Every property is verified for accuracy and legal compliance.', 'DREAMASAHOMES' ); ?></p>
							</div>
						</li>
						<li>
							<span class="sf-icon">&#10003;</span>
							<div>
								<strong><?php esc_html_e( 'Flexible Payments', 'DREAMASAHOMES' ); ?></strong>
								<p><?php esc_html_e( 'Tailored payment plans to suit every budget.', 'DREAMASAHOMES' ); ?></p>
							</div>
						</li>
						<li>
							<span class="sf-icon">&#10003;</span>
							<div>
								<strong><?php esc_html_e( 'After-Sale Support', 'DREAMASAHOMES' ); ?></strong>
								<p><?php esc_html_e( 'We stay with you long after the deal is done.', 'DREAMASAHOMES' ); ?></p>
							</div>
						</li>
					</ul>
				</div>

				<?php
				// ── Browse by Property Type (always visible) ───────────
				$prop_types = get_terms( array(
					'taxonomy'   => 'property_type',
					'hide_empty' => false,
				) );
				if ( ! empty( $prop_types ) && ! is_wp_error( $prop_types ) ) {
					?>
					<div class="widget sidebar-categories">
						<h3 class="widget-title"><?php esc_html_e( 'Browse by Type', 'DREAMASAHOMES' ); ?></h3>
						<ul class="sidebar-cat-list">
							<?php foreach ( $prop_types as $ptype ) : ?>
								<li>
									<a href="<?php echo esc_url( get_term_link( $ptype ) ); ?>">
										<?php echo esc_html( $ptype->name ); ?>
										<span class="cat-count"><?php echo esc_html( $ptype->count ); ?></span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<?php
				}
				?>

				<div class="widget sidebar-contact-cta">
					<h3 class="widget-title"><?php esc_html_e( 'Enquire About This Property', 'DREAMASAHOMES' ); ?></h3>
					<p><?php esc_html_e( 'Interested in this listing? Get in touch with our team today.', 'DREAMASAHOMES' ); ?></p>
					<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="sidebar-cta-btn">
						<?php esc_html_e( 'Contact Us', 'DREAMASAHOMES' ); ?>
					</a>
				</div>

				<?php
				// ── Related Properties widget ──────────────────────────
				$tax_terms = wp_get_post_terms( get_the_ID(), 'property_type', array( 'fields' => 'ids' ) );
				$related_args = array(
					'post_type'      => 'property',
					'posts_per_page' => 3,
					'post__not_in'   => array( get_the_ID() ),
					'orderby'        => 'rand',
				);
				// Filter by same type if terms exist, else fall back to any property
				if ( ! empty( $tax_terms ) && ! is_wp_error( $tax_terms ) ) {
					$related_args['tax_query'] = array(
						array(
							'taxonomy' => 'property_type',
							'field'    => 'term_id',
							'terms'    => $tax_terms,
						),
					);
				}
				$related = new WP_Query( $related_args );

				if ( $related->have_posts() ) {
					?>
					<div class="widget related-properties">
						<h3 class="widget-title"><?php esc_html_e( 'Related Properties', 'DREAMASAHOMES' ); ?></h3>
						<div class="related-list">
							<?php
							while ( $related->have_posts() ) {
								$related->the_post();
								?>
								<div class="related-item">
									<?php
									if ( has_post_thumbnail() ) {
										?>
										<a href="<?php the_permalink(); ?>" class="related-thumb">
											<?php the_post_thumbnail( 'thumbnail' ); ?>
										</a>
										<?php
									}
									?>
									<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<?php
				}
				wp_reset_postdata();
			}
			?>
		</aside>
	</div>
</div>

<style>
	/* ── Page wrapper ─────────────────────────────────────── */
	.single-post-item {
		margin-bottom: 60px;
	}

	/* Space between breadcrumb and main content */
	.page-header + .container,
	.page-header ~ .container {
		margin-top: 60px;
	}

	/* ── Featured image ───────────────────────────────────── */
	.property-featured-image {
		overflow: hidden;
		margin-bottom: 0;
	}

	.property-featured-image img {
		width: 100%;
		height: 420px;
		object-fit: cover;
		display: block;
		box-shadow: 10px 10px 50px rgba(0, 0, 0, 0.2);
	}

	/* ── Property info panel ──────────────────────────────── */
	.property-info-panel {
		background: #fff;
		border-top: 3px solid #9f8054;
		border-bottom: 1px solid #eaebee;
		padding: 30px 25px 20px;
		margin-top: 30px;
	}

	.entry-header {
		margin: 30px 0;
		padding: 20px 0;
		border-bottom: 1px solid #eaebee;
	}

	.single-property-item .entry-header {
		margin: 0;
		padding: 0;
		border: none;
	}

	/* ── Entry meta (date / author) ──────────────────────── */
	.entry-meta {
		display: flex;
		flex-wrap: wrap;
		gap: 16px;
		font-size: 13px;
		color: #888;
		margin-bottom: 12px;
	}

	.entry-meta span {
		display: inline-flex;
		align-items: center;
		gap: 4px;
	}

	.entry-meta a {
		color: #9f8054;
		text-decoration: none;
	}

	.entry-meta a:hover {
		text-decoration: underline;
	}

	/* ── Title ────────────────────────────────────────────── */
	.entry-title {
		font-family: "Playfair Display", serif;
		font-size: 34px;
		font-weight: 700;
		line-height: 1.25;
		color: #26282b;
		margin: 8px 0 20px;
	}

	/* ── Chips / quick meta ───────────────────────────────── */
	.property-quick-meta {
		display: flex;
		flex-wrap: wrap;
		gap: 6px;
		margin-bottom: 22px;
	}

	.property-chip {
		display: inline-block;
		padding: 5px 14px;
		background: #f5f1ec;
		font-size: 12px;
		font-weight: 600;
		color: #26282b;
		letter-spacing: .03em;
		text-transform: uppercase;
	}

	.property-chip-price {
		background: #ebcfa7;
		color: #26282b;
		font-size: 13px;
		font-weight: 700;
	}

	.property-chip-status.status-available {
		background: #d4edda;
		color: #155724;
	}

	.property-chip-status.status-sold {
		background: #f8d7da;
		color: #721c24;
	}

	.property-chip-status.status-reserved {
		background: #fff3cd;
		color: #856404;
	}

	/* ── Stats grid ───────────────────────────────────────── */
	.property-stats-grid {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 1px;
		margin: 0 0 24px;
		background: #eaebee;
		border: 1px solid #eaebee;
	}

	.property-stat-card {
		display: flex;
		flex-direction: column;
		align-items: center;
		text-align: center;
		padding: 20px 10px;
		background: #fff;
	}

	.property-stat-icon {
		font-size: 20px;
		margin-bottom: 6px;
		color: #9f8054;
		line-height: 1;
	}

	.property-stat-card small {
		display: block;
		font-size: 10px;
		text-transform: uppercase;
		letter-spacing: .08em;
		color: #9f8054;
		font-weight: 600;
		margin-bottom: 4px;
	}

	.property-stat-card strong {
		font-size: 18px;
		font-weight: 700;
		color: #26282b;
		line-height: 1;
	}

	/* ── Divider ──────────────────────────────────────────── */
	.property-panel-divider {
		border: none;
		border-top: 1px solid #eaebee;
		margin: 20px 0;
	}

	/* ── Taxonomy terms ───────────────────────────────────── */
	.entry-terms {
		font-size: 13px;
		color: #888;
		margin-top: 8px;
	}

	.entry-terms strong {
		color: #26282b;
		font-weight: 600;
	}

	.entry-terms a {
		color: #9f8054;
		text-decoration: none;
	}

	.entry-terms a:hover {
		text-decoration: underline;
	}

	/* ── Contact CTA ──────────────────────────────────────── */
	.property-cta-box {
		background: #26282b;
		padding: 40px 30px;
		text-align: center;
		margin-top: 30px;
		position: relative;
	}

	.property-cta-box::before {
		content: "";
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		height: 3px;
		background: #9f8054;
	}

	.property-cta-box h4 {
		margin: 0 0 10px;
		font-family: "Playfair Display", serif;
		font-size: 22px;
		font-weight: 700;
		color: #ebcfa7;
	}

	.property-cta-box p {
		margin: 0 0 20px;
		font-size: 14px;
		color: rgba(255, 255, 255, 0.7);
	}

	.property-cta-btn {
		display: inline-block;
		height: 54px;
		line-height: 54px;
		background: #9f8054;
		color: #fff !important;
		padding: 0 35px;
		font-weight: 600;
		font-size: 13px;
		text-transform: uppercase;
		text-decoration: none;
		letter-spacing: .05em;
		transition: background 0.25s ease;
	}

	.property-cta-btn:hover {
		background: #ebcfa7;
		color: #26282b !important;
		text-decoration: none;
	}

	/* ── Entry content ────────────────────────────────────── */
	.entry-content {
		margin: 30px 0;
		line-height: 1.8;
		font-size: 16px;
		color: #26282b;
		overflow-wrap: break-word;
		word-break: break-word;
	}

	.entry-content p { margin-bottom: 16px; }

	/* ── Entry footer (tags / share) ──────────────────────── */
	.entry-footer {
		margin-top: 40px;
		padding: 25px;
		background: #f5f1ec;
		border-left: 3px solid #9f8054;
	}

	.entry-tags {
		margin-bottom: 16px;
	}

	.tag-link {
		display: inline-block;
		margin: 0 5px 5px 0;
		padding: 5px 14px;
		background: #fff;
		border: 1px solid #eaebee;
		color: #26282b;
		text-decoration: none;
		font-size: 12px;
		font-weight: 600;
		text-transform: uppercase;
		letter-spacing: .03em;
		transition: all 0.25s ease;
	}

	.tag-link:hover {
		background: #9f8054;
		color: #fff;
		border-color: #9f8054;
		text-decoration: none;
	}

	.share-buttons {
		display: flex;
		align-items: center;
		gap: 8px;
		flex-wrap: wrap;
	}

	.share-buttons strong {
		font-size: 12px;
		font-weight: 600;
		text-transform: uppercase;
		letter-spacing: .05em;
		color: #26282b;
		margin-right: 4px;
	}

	.share-btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 38px;
		height: 38px;
		background: #26282b;
		color: #fff;
		text-decoration: none;
		font-size: 14px;
		transition: background 0.25s ease;
	}

	.share-btn:hover {
		background: #9f8054;
		text-decoration: none;
	}

	/* ── Sidebar ──────────────────────────────────────────── */
	.related-properties,
	.sidebar-property-details,
	.sidebar-contact-cta {
		background: #fff;
		border: 1px solid #eaebee;
		border-top: 3px solid #9f8054;
		padding: 25px;
		margin-bottom: 25px;
	}

	.related-properties .widget-title,
	.sidebar-property-details .widget-title,
	.sidebar-contact-cta .widget-title {
		font-family: "Playfair Display", serif;
		font-size: 17px;
		font-weight: 700;
		color: #26282b;
		margin: 0 0 18px;
		padding-bottom: 12px;
		border-bottom: 1px solid #eaebee;
	}

	/* ── Property Details list ────────────────────────────── */
	.sidebar-detail-list {
		list-style: none;
		margin: 0;
		padding: 0;
	}

	.sidebar-detail-list li {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 10px 0;
		border-bottom: 1px solid #f0ede8;
		font-size: 13px;
	}

	.sidebar-detail-list li:last-child {
		border-bottom: none;
	}

	.detail-label {
		color: #888;
		font-weight: 600;
		text-transform: uppercase;
		letter-spacing: .04em;
		font-size: 11px;
	}

	.detail-value {
		color: #26282b;
		font-weight: 600;
		text-align: right;
	}

	.detail-price {
		color: #9f8054;
		font-size: 14px;
	}

	.status-badge {
		display: inline-block;
		padding: 3px 10px;
		font-size: 11px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: .04em;
	}

	.status-badge.status-available { background: #d4edda; color: #155724; }
	.status-badge.status-sold      { background: #f8d7da; color: #721c24; }
	.status-badge.status-reserved  { background: #fff3cd; color: #856404; }

	/* ── Contact CTA widget ───────────────────────────────── */
	.sidebar-contact-cta p {
		font-size: 13px;
		color: #888;
		line-height: 1.6;
		margin-bottom: 16px;
	}

	.sidebar-cta-btn {
		display: block;
		text-align: center;
		height: 48px;
		line-height: 48px;
		background: #9f8054;
		color: #fff !important;
		font-size: 12px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: .06em;
		text-decoration: none;
		transition: background 0.25s ease;
	}

	.sidebar-cta-btn:hover {
		background: #26282b;
		text-decoration: none;
	}

	/* ── Why Choose Us widget ─────────────────────────────── */
	.sidebar-features-list {
		list-style: none;
		margin: 0;
		padding: 0;
	}

	.sidebar-features-list li {
		display: flex;
		gap: 12px;
		align-items: flex-start;
		padding: 12px 0;
		border-bottom: 1px solid #f0ede8;
	}

	.sidebar-features-list li:last-child {
		border-bottom: none;
	}

	.sf-icon {
		flex-shrink: 0;
		width: 26px;
		height: 26px;
		background: #9f8054;
		color: #fff;
		font-size: 13px;
		font-weight: 700;
		display: flex;
		align-items: center;
		justify-content: center;
		margin-top: 2px;
	}

	.sidebar-features-list li div strong {
		display: block;
		font-size: 13px;
		font-weight: 700;
		color: #26282b;
		margin-bottom: 2px;
	}

	.sidebar-features-list li div p {
		margin: 0;
		font-size: 12px;
		color: #888;
		line-height: 1.5;
	}

	/* ── Browse by Type widget ────────────────────────────── */
	.sidebar-cat-list {
		list-style: none;
		margin: 0;
		padding: 0;
	}

	.sidebar-cat-list li {
		border-bottom: 1px solid #f0ede8;
	}

	.sidebar-cat-list li:last-child {
		border-bottom: none;
	}

	.sidebar-cat-list li a {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 11px 0;
		font-size: 13px;
		font-weight: 600;
		color: #26282b;
		text-decoration: none;
		transition: color 0.25s ease;
	}

	.sidebar-cat-list li a:hover {
		color: #9f8054;
		text-decoration: none;
	}

	.cat-count {
		background: #ebcfa7;
		color: #26282b;
		font-size: 11px;
		font-weight: 700;
		padding: 2px 8px;
		min-width: 24px;
		text-align: center;
	}

	.related-list {
		display: flex;
		flex-direction: column;
		gap: 14px;
	}

	.related-item {
		display: flex;
		gap: 12px;
		align-items: center;
		padding-bottom: 14px;
		border-bottom: 1px solid #eaebee;
	}

	.related-item:last-child {
		border-bottom: none;
		padding-bottom: 0;
	}

	.related-thumb {
		flex-shrink: 0;
		width: 70px;
		height: 70px;
		overflow: hidden;
	}

	.related-thumb img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		transition: transform 0.3s ease;
	}

	.related-item:hover .related-thumb img {
		transform: scale(1.08);
	}

	.related-item h5 {
		margin: 0;
		font-size: 13px;
		font-weight: 600;
		line-height: 1.4;
		color: #26282b;
	}

	.related-item h5 a {
		color: inherit;
		text-decoration: none;
	}

	.related-item h5 a:hover {
		color: #9f8054;
		text-decoration: none;
	}

	/* ── Post navigation ──────────────────────────────────── */
	.post-navigation {
		border-top: 1px solid #eaebee;
		padding: 20px 0;
		margin-top: 30px;
	}

	.nav-previous a,
	.nav-next a {
		text-decoration: none;
		color: #26282b;
		font-size: 14px;
		font-weight: 600;
	}

	.nav-previous a:hover,
	.nav-next a:hover {
		color: #9f8054;
		text-decoration: none;
	}

	.nav-subtitle {
		display: block;
		font-size: 11px;
		text-transform: uppercase;
		letter-spacing: .08em;
		color: #9f8054;
		margin-bottom: 2px;
	}

	/* ── Responsive ───────────────────────────────────────── */
	@media (max-width: 991px) {
		.property-featured-image img {
			height: 300px;
		}
	}

	@media (max-width: 767px) {
		.entry-title {
			font-size: 26px;
		}

		.property-featured-image img {
			height: 220px;
		}

		.property-stats-grid {
			grid-template-columns: repeat(3, 1fr);
		}

		.property-stat-card {
			padding: 14px 6px;
		}

		.property-stat-card strong {
			font-size: 15px;
		}

		.entry-meta {
			gap: 8px;
		}

		.property-cta-box {
			padding: 28px 20px;
		}
	}
</style>

<?php
get_footer();
