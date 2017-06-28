<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package DrTheme
 * @since DrTheme 1.0.0
 */
?>

	</div><!-- #main -->
	
	<footer id="colophon" role="contentinfo">
		
		<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
			<div id="footer-widget" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div><!-- #tertiary .widget-area -->
		<?php endif; ?>
	   
		<div class="site-generator">
			<?php DrTheme_site_generator_credit();?>
		</div>
		
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>