<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package DrTheme
 * @since DrTheme 1.0.0
 */
?>

<article <?php DrTheme_post_id(); ?> <?php post_class(); ?><?php DrTheme_semantics("page"); ?>>
	<header class="entry-header">
		<h1 class="entry-title p-name" itemprop="name headline">
			<span class="img-title-icon"></span>
			<?php the_title(); ?>
		</h1>
	</header><!-- .entry-header -->
	
	<?php DrTheme_the_post_thumbnail('<div class="entry-media">', '</div>'); ?>
	
	<div class="entry-content e-content" itemprop="description text">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'drtheme' ), 'after' => '</div>' ) ); ?>
		<?php edit_post_link( __( 'Edit', 'drtheme' ), '<span class="edit-link">', '</span>' ); ?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
