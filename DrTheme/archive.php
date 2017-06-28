<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package DrTheme
 * @since DrTheme 1.0.0
 */

get_header(); ?>
	<section id="primary">
		<main id="content" role="main">
			<?php if ( have_posts() ) : ?>
				<header class="page-header">
					<h1 class="page-title">
					<?php
						if ( is_date() ) :
							$link = "";
							if ( is_day() ) {
								$link .= ' <a href="'.get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d') ).'">'.get_the_time('d').'.</a>';
							}
							if ( is_month() || is_day() ) {
								$link .= ' <a href="'.get_month_link( get_the_time('Y'), get_the_time('m') ).'">'.get_the_date( 'F' ).'</a>';
							}
							if ( is_year() || is_month() || is_day() ) {
								$link .= ' <a href="'.get_year_link( get_the_time('Y') ).'">'.get_the_time('Y').'</a>';
							}
							printf( __( 'Archives: %s', 'drtheme' ), '<span itemprop="breadcrumb">' . $link . '</span>' );
						elseif ( get_post_format() ) :
							printf( __( 'Archives: %s', 'drtheme' ), '<span>' . get_post_format_string( get_post_format() ) . '</span>' );
						else :
							_e( 'Archives', 'drtheme' );
						endif;
					?>
					</h1>
				</header>

				<?php rewind_posts(); ?>

				<?php DrTheme_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						 get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php DrTheme_content_nav( 'nav-below' ); ?>

			<?php else : ?>
	
				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title p-entry-title"><?php _e( 'Nothing Archive Found', 'drtheme' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content e-entry-content">
						<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'drtheme' ); ?></p>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

		</main><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>