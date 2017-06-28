<?php
/**
 * The template used to display Tag Archive pages
 *
 * @package DrTheme
 * @since DrTheme 1.0.0
 */

get_header(); ?>
	<section id="primary">
		<main id="content" role="main">
			<?php if ( have_posts() ) : ?>
				
				<header class="page-header">
					<h1 class="page-title"><?php
						printf( __( 'Tag Archives: %s', 'drtheme' ), '<span>' . single_tag_title( '', false ) . '</span>' );
					?></h1>
					<?php
					$tag_description = tag_description();
					if ( ! empty( $tag_description ) )
						echo apply_filters( 'tag_archive_meta', '<div class="tag-archive-meta">' . $tag_description . '</div>' );
					?>
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
						get_template_part( 'template-part/content', get_post_format() );
					?>
				<?php endwhile; ?>
				<?php DrTheme_content_nav( 'nav-below' ); ?>
				
			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title p-entry-title"><?php _e( 'Nothing Found', 'drtheme' ); ?></h1>
					</header><!-- .entry-header -->
					<div class="entry-content e-entry-content">
						<p>
							<?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'drtheme' ); ?>
						</p>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
				
			<?php endif; ?>
		</main><!-- #content -->
    </section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>