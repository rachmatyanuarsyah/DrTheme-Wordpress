<?php
/**
 * The Template for displaying all single posts.
 *
 * @package DrTheme
 * @since DrTheme 1.0.0
 */

get_header(); ?>

	<section id="primary">
		<main id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				
				<?php get_template_part( 'content', get_post_format() ); ?>
				
				<?php echo do_action('before-footer-author'); ?>
				
				<div class="author-info p-author vcard hcard h-card" itemprop="author" itemscope itemtype="http://schema.org/Person">
					<span class="about-author"><?php _e('About The Author','drtheme');?></span>
					<div class="author-meta">
						<?php echo get_avatar( get_the_author_meta('ID'), 80 ); ?>
						<?php printf('<a class="url uid u-url u-uid fn p-name" href="%1$s" title="%2$s" rel="author" itemprop="url"><span itemprop="name">%3$s</span></a>',
						 esc_url( get_author_posts_url( get_the_author_meta( 'ID' ))),
						 sprintf( __( 'View all posts by %s', 'drtheme' ), get_the_author() ),
						 esc_html( get_the_author() )
						);?>
						
					</div>
					<div class="author-note note p-note" itemprop="description">
						<p><?php echo get_the_author_meta('description'); ?></p>
					</div>
				</div>
				<?php DrTheme_content_nav( 'nav-below' ); ?>
			<?php // If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
				comments_template( '', true );
			?>
			<?php endwhile; // end of the loop. ?>
		</main><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>