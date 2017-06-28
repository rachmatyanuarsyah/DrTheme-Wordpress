<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package DrTheme
 * @since DrTheme 1.0.0
 */
?>
<?php 
	$drtheme_option = DrTheme_get_global_options();
	if(is_front_page()==$drtheme_option['DrTheme_enable_sidebar_front_page'] || is_single()) :
?>
		<aside id="sidebar">
			<div id="secondary" class="widget-area" role="complementary">
				<?php do_action( 'before_sidebar' ); ?>
				<div class="sidebar">
					<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
						<section id="search" class="widget widget_search">
							<?php get_search_form(); ?>
						</section>
						<section id="archives" class="widget">
							<h3 class="widget-title"><?php _e( 'Archives', 'drtheme' ); ?></h3>
							<ul>
								<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
							</ul>
						</section>
						<section id="meta" class="widget">
							<h3 class="widget-title"><?php _e( 'Meta', 'drtheme' ); ?></h3>
							<ul>
								<?php wp_meta(); ?>
							</ul>
						</section>
					<?php endif; // end sidebar widget area ?>
				</div>
			</div><!-- #secondary .widget-area -->
			<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
				<div id="tertiary" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'sidebar-2' ); ?>
				</div><!-- #tertiary .widget-area -->
			<?php endif; ?>
		</aside>
<?php endif; ?>