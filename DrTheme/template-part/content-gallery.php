<?php
/**
 * The template for displaying posts in the Gallery Post Format on index and archive pages
 *
 * Learn more: http://codex.wordpress.org/Post_Formats
 *
 * @package DrTheme
 * @since DrTheme 1.0.0
 */
?>

<article <?php DrTheme_post_id(); ?> <?php post_class(); ?><?php DrTheme_semantics("post"); ?>>
	<?php get_template_part( 'entry', 'header' ); ?>

	<?php if ( is_search() ) : // Only display Excerpts for search pages ?>
		<div class="entry-summary p-summary" itemprop="description">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	<?php else : ?>
		<div class="entry-content e-content" itemprop="description">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'drtheme' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'drtheme' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
		</div><!-- .entry-content -->
	<?php endif; ?>

	<?php get_template_part( 'entry', 'footer' ); ?>
</article><!-- #post-<?php the_ID(); ?> -->
