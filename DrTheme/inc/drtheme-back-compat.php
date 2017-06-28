<?php
/**
 * DrTheme back compat handling
 *
 * Prevents DrTheme from running on WordPress versions prior to 4.4,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.4.
 *
 * @package DrTheme
 * @subpackage drtheme-back-compat
 * @since DrTheme 1.0.0
 */
 
/**
 * Prevent switching to DrTheme on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since DrTheme 1.0.0
 */
function DrTheme_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'DrTheme_upgrade_notice' );
}

add_action( 'after_switch_theme', 'DrTheme_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * DrTheme on WordPress versions prior to 4.4.
 *
 * @since DrTheme 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function DrTheme_upgrade_notice() {
	$message = sprintf( __( 'DrTheme Theme requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'drtheme' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}
 
 /**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.4.
 *
 * @since DrTheme 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function DrTheme_customize() {
	wp_die( sprintf( __( 'DrTheme Theme requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'drtheme' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'DrTheme_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.4.
 *
 * @since DrTheme 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function DrTheme_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'DrTheme Theme requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'drtheme' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'DrTheme_preview' );



