<?php
/**
 * @package DrTheme
 * @since DrTheme 1.0.0
 */
?>

<article <?php DrTheme_post_id(); ?> <?php post_class(); ?><?php DrTheme_semantics("post"); ?>>
	<?php get_template_part( 'entry', 'header' ); ?>

	<div class="entry-content e-content" itemprop="articleBody description">
		<?php DrTheme_publisher_tag();?>
		<?php DrTheme_the_post_thumbnail('<p>', '</p>'); ?>
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'drtheme' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'drtheme' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<?php get_template_part( 'entry', 'footer' ); ?>
</article><!-- #post-<?php the_ID(); ?> -->
