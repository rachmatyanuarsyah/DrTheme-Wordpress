<?php
/**
 * @package DrTheme
 * @since DrTheme 1.0.0
 */
?>
<article <?php DrTheme_post_id(); ?> <?php post_class(); ?><?php DrTheme_semantics("post"); ?>>
	<header class="entry-header">
		<h1 class="entry-title p-name" itemprop="name headline">
			<span class="fa-stack">
				<i class="fa fa-circle fa-stack-2x primary"></i>
				<i class="fa fa-chain fa-stack-1x fa-inverse"></i>
			</span>
			<a href="<?php the_permalink(); ?>" class="u-url url" title="<?php printf( esc_attr__( 'Permalink to %s', 'drtheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" itemprop="url">
				<?php the_title(); ?>
			</a>
		</h1>
		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">      
				<?php DrTheme_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary p-summary" itemprop="description">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	<?php else : ?>
		<?php DrTheme_the_post_thumbnail('<div class="entry-media">', '</div>'); ?>
		<div class="entry-content e-content" itemprop="description articleBody">
			<?php DrTheme_publisher_tag();?>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'drtheme' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'drtheme' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php if(!is_home() || !is_front_page()) : ?>
			<?php get_template_part( 'entry', 'footer' ); ?>
		<?php endif; ?>
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->