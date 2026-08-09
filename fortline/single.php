<?php /* ARI: legacy page — send visitors to the single-page site */ if (function_exists("wp_safe_redirect") && !is_admin()) { wp_safe_redirect( home_url("/") ); exit; } ?>
<?php
/**
 * Single Post Template
 *
 * @package Fortline
 */

get_header();
?>

	<?php
	while ( have_posts() ) :
		the_post();
		$category = fortline_get_primary_category();
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<header class="post-header">
				<div class="container">
					<?php
					if ( $category ) :
						?>
						<span class="post-category"><?php echo esc_html( $category->name ); ?></span>
						<?php
					endif;
					?>

					<h1><?php the_title(); ?></h1>

					<div class="post-meta">
						<span><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></span>
						<span><?php printf( esc_html__( '%d minute read', 'fortline' ), fortline_reading_time() ); ?></span>
					</div>
				</div>
			</header>

			<div class="post-body">
				<?php
				the_content();

				wp_link_pages( array(
					'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'fortline' ),
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
				?>
			</div>

		</article>

		<div class="container back-to-posts">
			<a href="<?php echo esc_url( home_url( '/blog' ) ); ?>">&larr; <?php esc_html_e( 'Back to all articles', 'fortline' ); ?></a>
		</div>

		<?php
		// Related Posts
		$related = fortline_get_related_posts( get_the_ID(), 2 );

		if ( $related->have_posts() ) :
			?>
			<div class="container related-posts">
				<h3><?php esc_html_e( 'Related Articles', 'fortline' ); ?></h3>

				<div class="related-posts-grid">
					<?php
					while ( $related->have_posts() ) :
						$related->the_post();
						$rel_category = fortline_get_primary_category();
						?>
						<article class="post-card">
							<?php
							if ( has_post_thumbnail() ) :
								?>
								<a href="<?php the_permalink(); ?>">
									<?php
									the_post_thumbnail( 'medium', array(
										'class' => 'post-thumbnail',
										'alt'   => get_the_title(),
									) );
									?>
								</a>
								<?php
							else :
								?>
								<div class="post-thumbnail" style="background-color: var(--bg-section);"></div>
								<?php
							endif;
							?>

							<div class="post-content">
								<?php
								if ( $rel_category ) :
									?>
									<span class="post-category"><?php echo esc_html( $rel_category->name ); ?></span>
									<?php
								endif;
								?>

								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

								<p><?php the_excerpt(); ?></p>

								<a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e( 'Read More', 'fortline' ); ?> &rarr;</a>
							</div>
						</article>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
			<?php
		endif;
		?>

		<div class="container contact-cta">
			<h2><?php esc_html_e( 'Get in Touch', 'fortline' ); ?></h2>
			<p><?php esc_html_e( 'Interested in learning more about our defense-grade protection technology? We would love to hear from you.', 'fortline' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-primary"><?php esc_html_e( 'Contact Us', 'fortline' ); ?></a>
		</div>

	<?php
	endwhile;
	?>

<?php
get_footer();
