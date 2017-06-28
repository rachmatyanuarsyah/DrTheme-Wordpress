<?php
/**
 * DrTheme functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package DrTheme
 * @since DrTheme 1.0.0
 */

/**
 * define our theme 
 * 
 * @since 1.0.0
 */
define('DRTHEME_DIR', get_template_directory()); // the theme directory
define('DRTHEME_URL', get_template_directory_uri()); // the theme directory URL
define('DRTHEME_FONT', DRTHEME_DIR . '/assets/font/' );// image folder
define('DRTHEME_IMAGE', DRTHEME_URL . '/assets/img/' );// image folder
define('DRTHEME_INC', DRTHEME_DIR . '/inc/');//file inc folder
define('DRTHEME_SCRIPTS', DRTHEME_URL . '/assets/js/' );//js folder 
define('DRTHEME_STYLES', DRTHEME_URL . '/assets/css/' ); //style folder
define('DRTHEME_SHORTNAME', 'DrTheme'); // used to prefix the individual setting field id see DrTheme_options_page_fields()
define('DRTHEME_PAGE_BASENAME', 'drtheme-settings'); // the settings page slug
/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 670; /* pixels */

/**
 * Set a default theme color array for WP.com.
 */
$themecolors = array(
	'bg' => 'fff',
	'border' => 'ccc',
	'text' => '333',
	'shadow' => 'fff'
);

/**
 * Adds back compat handling for WP versions 4.4.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) )
	require  DRTHEME_INC . 'drtheme-back-compat.php' ;

if ( ! function_exists( 'DrTheme_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override DrTheme_setup() in a child theme, add your own DrTheme_setup to your child theme's
 * functions.php file.
 */
function DrTheme_setup() {
	global $themecolors;
	
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'drtheme', DRTHEME_DIR . '/languages' );
	
	// call require theme option
	if ( is_admin() )
		require_once('inc/drtheme_settings.php');

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 668, 9999 ); // Unlimited height, soft crop

	// Register custom image size for image post formats.
	add_image_size( 'DrTheme-image-post', 668, 1288 );

	// Switches default core markup for search form to output valid HTML5.
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'widgets' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'drtheme' ),
	) );

	// Add support for the Aside, Gallery Post Formats...
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );
	/**
	 * This theme supports jetpacks "infinite-scroll"
	 *
	 * @see http://jetpack.me/support/infinite-scroll/
	 */
	add_theme_support( 'infinite-scroll', array('container' => 'content', 'footer' => 'colophon') );

	/**
	 * This theme supports the "title-tag" feature
	 *
	 * @see https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Draw attention to supported WebSemantics
	 */
	add_theme_support( 'microformats2' );
	add_theme_support( 'microformats' );
	add_theme_support( 'microdata' );

	// This theme supports a custom header
	$custom_header_args = array(
		'width'			=> 824,
		'height'		=> 100,
		'header-text'	=> false,
		'default-image'	=> DRTHEME_IMAGE . 'header820X150.jpg'
	);
	add_theme_support( 'custom-header', $custom_header_args );

	// custom logo support
	add_theme_support( 'custom-logo', array(
		'height'      => 200,
		'width'       => 183,
	) );


	// This theme supports custom backgrounds
	$custom_background_args = array(
		'default-color' => $themecolors['bg'],
		'default-image' => DRTHEME_IMAGE . 'noise.png',
	);
	add_theme_support( 'custom-background', $custom_background_args );

	// Nicer WYSIWYG editor
	add_editor_style( DRTHEME_STYLES.'editor-style.css' );
}
endif; // DrTheme_setup

/**
 * Tell WordPress to run DrTheme_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'DrTheme_setup' );

if ( ! function_exists( 'DrTheme_get_global_options' ) ):
/** Call the function and collect in variable
 * Should be used in template files like this:
 * <?php echo $drtheme_option['name of option']; ?>
 * 
 * @since 1.0.0
 * @return array
 */
function DrTheme_get_global_options() {
	$drtheme_option = array();
	$drtheme_option_names = array (
		'theme_Dr_options'
	);
 
	// loop for get_option
	foreach ($drtheme_option_names as $drtheme_option_name) {
		if (get_option($drtheme_option_name)!= FALSE) {
		$option	= get_option($drtheme_option_name);
		
		// now merge in main $wptuts_option array!
		$drtheme_option = array_merge($drtheme_option, $option);
		}
	}
	return $drtheme_option;
}
endif; // DrTheme_get_global_options

$drtheme_option = DrTheme_get_global_options();

/**
 * Adds "custom-color" support
 *
 * @since 1.0.0
 */
function DrTheme_customize_register( $wp_customize ) {
	global $themecolors;

	$wp_customize->add_section( 'DrTheme_settings_section', array(
		'title'       => __( 'DrTheme Theme Layout', 'drtheme' ),
		'description' => __('Allows you to customize Theme Layout.', 'drtheme'), //Descriptive tooltip
		'priority'    => 35
	) );

	$wp_customize->add_setting( 'DrTheme_textcolor' , array(
		'default'     => '#'.$themecolors['text'],
		'transport'   => 'refresh',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'DrTheme_textcolor', array(
		'label'      => __( 'Text Color', 'drtheme' ),
		'section'    => 'colors',
		'settings'   => 'DrTheme_textcolor',
	) ) );

	$wp_customize->add_setting( 'DrTheme_shadowcolor' , array(
		'default'     => '#'.$themecolors['shadow'],
		'transport'   => 'refresh',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'DrTheme_shadowcolor', array(
		'label'      => __( 'Shadow Color', 'drtheme' ),
		'section'    => 'colors',
		'settings'   => 'DrTheme_shadowcolor',
	) ) );

	$wp_customize->add_setting( 'DrTheme_bordercolor' , array(
		'default'     => '#'.$themecolors['border'],
		'transport'   => 'refresh',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'DrTheme_bordercolor', array(
		'label'      => __( 'Border Color', 'drtheme' ),
		'section'    => 'colors',
		'settings'   => 'DrTheme_bordercolor',
	) ) );

	$wp_customize->add_setting( 'DrTheme_columns' , array(
		'default'     => 'multi',
		'transport'   => 'refresh',
	) );

	$wp_customize->add_control( 'DrTheme_columns', array(
		'label'      => __( 'Page Structure', 'drtheme' ),
		'section'    => 'DrTheme_settings_section',
		'settings'   => 'DrTheme_columns',
		'type'       => 'select',
		'choices'    => array(
			'single'   => __( 'Single Column (Sidebar at the bottom)', 'drtheme' ),
			'multi'    => __( 'Multi Column (Sidebar at the right)', 'drtheme' ),
		)
	) );
}

add_action( 'customize_register', 'DrTheme_customize_register' );


/**6
 * Adds the custom CSS to the theme-header
 *
 * @since 1.0.0
 */
function DrTheme_customize_css() {
	global $themecolors;
?>
	<style type="text/css" id="DrTheme-custom-colors">
		body { text-shadow: 0 1px 0 <?php echo get_theme_mod( 'DrTheme_shadowcolor', '#' . $themecolors['shadow'] ); ?>; }
		body, a { color: <?php echo get_theme_mod( 'DrTheme_textcolor', '#' . $themecolors['text'] ); ?>; }
		.widget, #access {
			border-bottom: 1px solid <?php echo get_theme_mod( 'DrTheme_bordercolor', 'inherit' ); ?>;
			-moz-box-shadow: 0 1px 0 0 <?php echo get_theme_mod( 'DrTheme_shadowcolor', 'inherit' ); ?>;
			-webkit-box-shadow: 0 1px 0 0 <?php echo get_theme_mod( 'DrTheme_shadowcolor', 'inherit' ); ?>;
			box-shadow: 0 1px 0 0 <?php echo get_theme_mod( 'DrTheme_shadowcolor', 'inherit' ); ?>;
		}
		article.comment {
			border-top: 1px solid <?php echo get_theme_mod( 'DrTheme_shadowcolor', 'inherit' ); ?>;
			-moz-box-shadow: 0 -1px 0 0 <?php echo get_theme_mod( 'DrTheme_bordercolor', 'inherit' ); ?>;
			-webkit-box-shadow: 0 -1px 0 0 <?php echo get_theme_mod( 'DrTheme_bordercolor', 'inherit' ); ?>;
			box-shadow: 0 -1px 0 0 <?php echo get_theme_mod( 'DrTheme_bordercolor', 'inherit' ); ?>;
		}
	</style>
<?php
}
add_action( 'wp_head', 'DrTheme_customize_css');

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
/**function DrTheme_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'DrTheme_page_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function DrTheme_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar 1', 'drtheme' ),
		'id' => 'sidebar-1',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => "</section>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Sidebar 2', 'drtheme' ),
		'id' => 'sidebar-2',
		'description' => __( 'An optional second sidebar area', 'drtheme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => "</section>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) ); 
	register_sidebar( array(
		'name' => __( 'Footer Widget Area', 'drtheme' ),
		'id' => 'footer-1',
		'description' => __( 'The footer widget area', 'drtheme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
    ) );
}
add_action( 'widgets_init', 'DrTheme_widgets_init' );

if ( ! function_exists( 'DrTheme_enqueue_scripts' ) ) :
/**
 * Enqueue theme scripts
 *
 * @uses wp_enqueue_scripts() To enqueue scripts
 *
 * @since DrTheme 1.0.0
 */
function DrTheme_enqueue_scripts() {
	/*
	 * Adds JavaScript to pages with the comment form to support sites with
	 * threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){
		wp_enqueue_script( 'comment-reply' );
		wp_enqueue_script('ajaxValidate', DRTHEME_SCRIPTS . 'jquery.validate.min.js',array(), '1.16.0',true); 
	}
	// Load the html5 shiv.
	wp_enqueue_script( 'html5', DRTHEME_SCRIPTS . 'html5shiv.min.js', array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );
	
	wp_enqueue_style( 'DrTheme-fonts', fonts_url(), array(), null );
	wp_enqueue_style( 'fonicon', DRTHEME_STYLES . 'font-awesome.min.css');
	
	wp_enqueue_style( 'DrTheme-responsive', DRTHEME_STYLES . 'drtheme-responsive.css');
	wp_enqueue_style( 'DrTheme-menu', DRTHEME_STYLES . 'drtheme-menu.css');
	// Loads our main stylesheet.
	wp_enqueue_style( 'DrTheme-style', get_stylesheet_uri() );

	wp_register_script( 'DrTheme-menu-js', DRTHEME_SCRIPTS .'drtheme-menu.js', array('jquery'),null, true );
	wp_enqueue_script( 'DrTheme-theme-js', DRTHEME_SCRIPTS .'drtheme-script.js', array('DrTheme-menu-js'),null, true);

}
endif;

function fonts_url(){
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	if ( 'off' !== _x( 'on', 'Poiret One font: on or off', 'drtheme' ) ) {
		$fonts[] = 'Poiret One:400';
	}
	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
add_action( 'wp_enqueue_scripts', 'DrTheme_enqueue_scripts' );




/**
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since DrTheme 1.0.0
 */
function DrTheme_content_width() {
  if ( is_page_template( 'full-width-page.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
    global $content_width;
    $content_width = 880;
  }

  /*
  if ( has_post_format( 'image' ) || has_post_format( 'video' ) || is_attachment() ) {
    global $content_width;
    $content_width = 668;
  }
  */
}
add_action( 'template_redirect', 'DrTheme_content_width' );


/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @param string $url
 * @return string
 */
function DrTheme_enhanced_image_navigation( $url ) {
	if ( is_admin() ) {
		return $url;
	}

	global $post, $wp_rewrite;

	$id = (int) $post->ID;
	$object = get_post( $id );
	if ( wp_attachment_is_image( $post->ID ) && ( $wp_rewrite->using_permalinks() && ( $object->post_parent > 0 ) && ( $object->post_parent != $id ) ) )
		$url = $url . '#main';

	return $url;
}
add_filter( 'attachment_link', 'DrTheme_enhanced_image_navigation' );
/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function DrTheme_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . PHP_EOL, get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'DrTheme_pingback_header' );
/**
 * Display the id for the post div.
 *
 * @param string $id.
 */
function DrTheme_post_id( $post_id = null ) {
	if ($post_id) {
		echo 'id="' . $post_id  . '"';
	} else {
		echo 'id="' . DrTheme_get_post_id()  . '"';
	}
}

/**
 * Retrieve the id for the post div.
 *
 * @return string The post-id.
 */
function DrTheme_get_post_id() {
	$post_id = "post-" . get_the_ID();

	return apply_filters('DrTheme_post_id', $post_id, get_the_ID());
}


/**
 * custom walker that only shows the menuitem's ID's (and active items get active classes), delevering clean menu code (in WordPress > 3.0)
 */

class DrTheme_walker extends Walker_Nav_Menu{
	function start_el(&$output, $item, $depth, $args){
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$current_indicators = array('current-menu-item','current-menu-ancestor',' current-menu-parent');
		$newClasses = array();
		
		foreach($classes as $el){
			//check if it's indicating the current page, otherwise we don't need the class
			if (in_array($el, $current_indicators)){ 
				array_push($newClasses, $el);
			}
		}
		
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $newClasses), $item ) );
		if($class_names!='') $class_names = ' class="'. esc_attr( $class_names ) . '"';
		if($depth == 0){
			$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'  itemprop="name">';
		}else{
			$output .= $indent . '<li id="menu-item-'. $item->ID . '"  itemprop="name">';
		}
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		
		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'itemprop="url">';
		$item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class='sub-menu'>\n";
	}	
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}
}

/**
 * Create active class menu
 * 
 * @since DrTheme 1.0.0
 */
function special_nav_class($classes, $item){
	if( in_array( 'current-menu-ancestor', $classes) ){
		$classes[] = 'current-menu-item';
	}
	return $classes;
}
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

/**
 * function to flush theme option when switch
 * 
 * @since DrTheme 1.0.0
 */
function DrTheme_reset_options() { 
    remove_theme_mods();
}
add_action( 'after_switch_theme', 'DrTheme_reset_options' );

/**
 * call the semantics function
 */
require DRTHEME_INC . 'drtheme-semantic.php' ;

/**
 * call the template tag
 * @since 1.0.0
 */
require DRTHEME_INC . 'drtheme-template-tag.php';

/**
 * This theme was built with PHP, Semantic HTML, CSS, love, and SemPress.
 */
 
 //Disable xmlrpc
 	add_filter('xmlrpc_enabled', '__return_false');
