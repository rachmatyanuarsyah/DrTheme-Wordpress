<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package DrTheme
 * @since DrTheme 1.0.0
 */

get_header(); ?>
	<section id="primary">
		<main id="content" role="main">

			<article id="post-0" class="post error404 not-found">
				<header class="entry-header">
					<h1 class="entry-title p-entry-title">
						<?php _e( 'Well this is somewhat embarrassing, isn&rsquo;t it?', 'drtheme' ); ?>
					</h1>
				</header>

				<div class="entry-content e-entry-content">
					<p>
						<?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'drtheme' ); ?>
					</p>
			</article><!-- #post-0 -->
			
		</main><!-- #content -->
	</section><!-- #primary -->
	
<?php get_sidebar(); ?>
<?php get_footer(); ?>