<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package DrTheme
 * @since DrTheme 1.0.0
 */
?>
<!DOCTYPE html>

<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="http://microformats.org/profile/specs" />
	<link rel="profile" href="http://microformats.org/profile/hatom" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?><?php DrTheme_semantics("body"); ?>>
	
<div id="page">
	<?php do_action( 'before' ); ?>
	<!-- #branding -->
	<header id="branding" role="banner">
		<?php 
		$image=array();
		if ( has_custom_logo() ) {
			$image = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) ); 
		} else {
			$image = DRTHEME_IMAGE. 'logo.jpg';
		}?>
		<div class="u-photo photo logo" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
			<img itemprop="url" src="<?php echo (has_custom_logo())? current( $image ):$image; ?>" class='img-logo' alt="<?php bloginfo( 'name' ); ?>"/>
			<meta itemprop="width" content="<?php echo (has_custom_logo())? next( $image ):150; ?>" />
			<meta itemprop="height" content="<?php echo (has_custom_logo())? next( $image ):150; ?>" />
		</div>
		<?php ( get_header_image() )? $class_image= "show-site-image" : $class_image="no-site-image" ;?>
		<div class="branding-info <?php echo $class_image;?>">
			<div class="branding-text">
				<h1 id="site-title"<?php DrTheme_semantics("site-title"); ?>>
					<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"<?php DrTheme_semantics("site-url"); ?>>
						<?php bloginfo( 'name' ); ?>
					</a>
				</h1>
				<h2 id="site-description"<?php DrTheme_semantics("site-description"); ?>>
					<?php bloginfo( 'description' ); ?>
				</h2>
			</div>
			<?php if ( get_header_image() ) : ?>
				<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="header image" class="site-image" />
			<?php endif; ?>
		</div>
	</header>
	<!-- #access menu-->
	<h1 class="assistive-text section-heading">
		<a href="#access" title="<?php esc_attr_e( 'Main menu', 'drtheme' ); ?>">
			<?php _e( 'Main menu', 'drtheme' ); ?>
		</a>
	</h1>
	<div class="skip-link screen-reader-text">
		<a href="#content" title="<?php esc_attr_e( 'Skip to content', 'drtheme' ); ?>">
			<?php _e( 'Skip to content', 'drtheme' ); ?>
		</a>
	</div>
	<nav id="access" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement" >
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'ul','walker' => new DrTheme_walker()) ); ?>
	</nav>
	<div id="main">
		<?php do_action('before_article');?>
		