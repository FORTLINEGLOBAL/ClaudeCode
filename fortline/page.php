<?php
/**
 * Page Template
 *
 * @package Fortline
 */

get_header();
?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<header class="post-header" style="padding: 80px 20px 60px; text-align: left;">
				<div class="container">
					<h1><?php the_title(); ?></h1>
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

	<?php
	endwhile;
	?>

<?php
get_footer();
