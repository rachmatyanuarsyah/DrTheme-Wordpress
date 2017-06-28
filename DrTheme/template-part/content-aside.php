<?php
/**
 * The template for displaying posts in the Aside Post Format on index and archive pages
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
		<div class="entry-summary p-summary entry-title p-name" itemprop="name description">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	<?php else : ?>
		<div class="entry-content e-content p-summary entry-title p-name" itemprop="name headline description articleBody">
			<?php DrTheme_publisher_tag();?>
			<?php DrTheme_the_post_thumbnail('<p>', '</p>'); ?>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'drtheme' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'drtheme' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
	<?php endif; ?>

	<?php get_template_part( 'entry', 'footer' ); ?>
</article><!-- #post-<?php the_ID(); ?> -->
