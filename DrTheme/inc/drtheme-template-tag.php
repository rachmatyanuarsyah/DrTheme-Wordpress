<?php
/**
 * Custom DrTheme template tags
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package DrTheme
 * @subpackage DrTheme-template-tag
 * @since DrTheme 1.0.0
 */
/**
 *  add breadcrumb before article
 * 
 * @since DrTheme 1.0.0
 */
 
function Drtheme_before_article(){
	if(!is_front_page()){
 	?>
	 	<nav class="breadcrumbs">
			<ul class="unstyled" itemscope itemtype="http://schema.org/BreadcrumbList">
				<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<i class="fa fa-home info"></i>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="item">
						<span itemprop="name"><?php _e('Home','drtheme');?></span>
					</a>
					<meta itemprop="position" content="1" />
				</li>
				<?php if( is_home()) : ?>
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<i class="fa fa-arrow-circle-right info"></i>
						<span itemprop="name"><?php _e('Blog','drtheme');?></span>
						<meta itemprop="position" content="2" />
					</li>
				<?php elseif( is_single() && 'post' == get_post_type()): ?>
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<i class="fa fa-arrow-circle-right info"></i>
						<span itemprop="name"><?php _e('Blog','drtheme');?></span>
						<meta itemprop="position" content="2" />
					</li>
					<?php echo DrTheme_page_parent_breadcumb(3);?>
				<?php else :?>
				<?php echo DrTheme_page_parent_breadcumb();?>
				<?php endif; ?>
			</ul>
		</nav>
	<?php
	}
}
add_action('before_article','Drtheme_before_article');

/**
 *Helper function: get id page parent Breadcumb from post
 *
 * @since DrTheme 1.0.0
 * @param (integer) $pos = The position lavel for sematic
 * @return echos output
 */
function DrTheme_page_parent_breadcumb($pos=2){
	global $post;
	/* Get an array of Ancestors and Parents if they exist */
	$parents = get_post_ancestors( $post->ID );
	/* Get the top Level page->ID count base 1, array base 0 so -1 */ 
	$id = ($parents) ? get_post($parents[count($parents)-1]): array('post_id'=>$post->ID,'post_title'=>$post->post_title);
	if (!empty($parents)){
		printf('<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
			<i class="fa fa-arrow-circle-right info"></i>
			<a href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a>
			<meta itemprop="position" content="2" /></li>
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
			<i class="fa fa-arrow-circle-right info"></i>
			<span itemprop="name">%3$s</span>
			<meta itemprop="position" content="3" />
			</li>',
			esc_url( get_permalink($id->ID) ),
			esc_attr($id->post_title),
			esc_attr($post->post_title)
		);
	} else {
		printf('<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
			<i class="fa fa-arrow-circle-right info"></i>
			<span itemprop="name">%1$s</span>
			<meta itemprop="position" content="%2$s" />
			</li>',
			esc_attr($post->post_title),
			$pos
		);
	}
}

if ( ! function_exists( 'DrTheme_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since DrTheme 1.0.0
 */
function DrTheme_content_nav( $nav_id ) {
	global $wp_query;
?>
	<nav id="<?php echo $nav_id; ?>">
		<h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'drtheme' ); ?></h1>
		<?php if ( is_single() ) : // navigation links for single posts ?>
		
			<?php previous_post_link( '<div class="nav-previous">%link</div>', '<i class="fa fa-angle-left"></i> %title' ); ?>
			<?php next_post_link( '<div class="nav-next">%link</div>', '%title <i class="fa fa-angle-right"></i>' ); ?>
		
		<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>
	
			<?php if ( get_next_posts_link() ) : ?>
				<div class="nav-previous"><?php next_posts_link( __( '<i class="fa fa-angle-left"></i> Older posts', 'drtheme' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <i class="fa fa-angle-right"></i>', 'drtheme' ) ); ?></div>
			<?php endif; ?>

		<?php endif; ?>
	</nav><!-- #<?php echo $nav_id; ?> -->
<?php
}
endif; // DrTheme_content_nav



if ( ! function_exists( 'DrTheme_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own DrTheme_posted_on to override in a child theme
 *
 * @since DrTheme 1.0.0
 */
function DrTheme_posted_on() {
	//get title tag
	$title = sprintf( __( 'View all posts by %s', 'drtheme' ), get_the_author() );
	// Get the author name; wrap it in a link.
	//'.get_avatar( get_the_author_meta('ID'), 40 ).'
	$byline = sprintf(
		/* translators: %s: post author */
		__( '<span class="sep">Published by </span> %s', 'drtheme' ),
		'<span class="author p-author vcard hcard h-card" itemprop="author" itemscope itemtype="http://schema.org/Person">
			<a class="url uid u-url u-uid fn p-name" href="'.esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ).'" title="'.$title.'" rel="author" itemprop="url">
				<i class="fa fa-user-circle fa-lg"></i>&nbsp;
				<span itemprop="name">'.esc_html( get_the_author() ).'</span>
			</a>
		</span>'
	);
	printf( __( '<address class="byline"> %1$s </address> at <a href="%2$s" title="%2$s" rel="bookmark" class="url u-url"><i class="fa fa-calendar"></i>&nbsp;%4$s</a><hr/>', 'drtheme' ),
		$byline,
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		DrTheme_time_link()
	);
}
endif;

/**
 * create publisher semantic tag
 */
 function DrTheme_publisher_tag(){
 	$image=array();
	if ( has_custom_logo() ) {
		$image = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) ); 
	} else {
		$image = DRTHEME_IMAGE. 'logo.jpg';
	}
	$url=(has_custom_logo())? current( $image ):$image;
 	printf(__('<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
		<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
			<meta itemprop="url" content="%1$s">
			<meta itemprop="width" content="600">
			<meta itemprop="height" content="60">
		</div>
		<meta itemprop="name" content="%2$s">
		</div>','drtheme'),
		$url,
		esc_attr(get_the_author())
	);
 }
if ( ! function_exists( 'DrTheme_time_link' ) ) :
/**
 * Gets a nicely formatted string for the published date.
 */
function DrTheme_time_link() {
	$time_string = '<time class="entry-date updated published dt-updated dt-published" datetime="%1$s" itemprop="dateModified datePublished">%2$s</time>';

	$time_string = sprintf( $time_string,
		get_the_modified_date( DATE_W3C ),
		get_the_modified_date()
	);

	return  $time_string;
}
endif;

/**
 * Adds post-thumbnail support :)
 *
 * @param (string) $before is html output use before content output
 * @param (string) $after is html output use after content output
 * @since DrTheme 1.0.0
 */
function DrTheme_the_post_thumbnail($before = "", $after = "") {
	if ( '' != get_the_post_thumbnail() ) {
		$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'post-thumbnail');
		$class = "aligncenter";

		if ($image['1'] < "300")
			$class="alignright";

		echo $before;
		the_post_thumbnail( "post-thumbnail", array( "class" => $class . " photo u-photo-featured ", "itemprop" => "image","itemtype"=> "https://schema.org/ImageObject") );
		printf(__('<meta itemprop="url" content="%1$s"><meta itemprop="width" content="800"><meta itemprop="height" content="800">','drtheme'),
		current($image));
		echo $after;
	}else{
		 printf(__('<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject"><meta itemprop="url" content="%1$s"><meta itemprop="width" content="800"><meta itemprop="height" content="800"></div>'
		 ,'drtheme'),
		 DRTHEME_IMAGE. 'thumbnail1.jpg');
	}
}

/**
 * Returns true if a blog has more than 1 category
 *
 * @since DrTheme 1.0.0
 */
function DrTheme_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so DrTheme_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so DrTheme_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in DrTheme_categorized_blog
 *
 * @since DrTheme 1.0.0
 */
function DrTheme_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'DrTheme_category_transient_flusher' );
add_action( 'save_post', 'DrTheme_category_transient_flusher' );

/**
 * Helper function for adding site generator
 * 
 * @param (array) $args The array of arguments to be used in creating the field
 * @return echos output
 * @since DrTheme 1.0.0
 */
function DrTheme_site_generator_credit(){
	printf('&copy; <a href="%1$s" title="%2$s" rel="home" class="site-url" > %3$s </a>  %4$s %5$s %6$s', 
		esc_url(home_url( '/' )),
		esc_attr( get_bloginfo( 'name', 'display' )),
		esc_attr(get_bloginfo( 'name', 'display' )),
		(date("Y") > '2016')? ' 2016 - '.date("Y"):date("Y"),
		_x('This site is  Created by','drtheme'),
		sprintf('<a href="http://creative.jakartareview.info" target="_top">%s</a>',
			_x('Dr Software Lab&lsquo;s','drtheme')
		)
	); 
}

/**
 * helper function get the attachment id
 * 
 * @return (integer)
 * @since DrTheme 1.0.0
 */
function DrTheme_get_attachment_id_by_url($url) {
	// Split the $url into two parts with the wp-content directory as the separator
	$parsed_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );
	// Get the host of the current site and the host of the $url, ignoring www
	$this_host = str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
	$file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );
	// Return nothing if there aren't any $url parts or if the current host and $url host do not match
	if ( ! isset( $parsed_url[1] ) || empty( $parsed_url[1] ) || ( $this_host != $file_host ) ) {
		return;
	}
	// Now we're going to quickly search the DB for any attachment GUID with a partial path match
	// Example: /uploads/2013/05/test-image.jpg
	global $wpdb;
	$attachment = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $parsed_url[1] ), ARRAY_A );
	// Returns null if no attachment is found
	return $attachment;
}

if ( ! function_exists( 'DrTheme_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own DrTheme_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since DrTheme 1.0.0
 */
function DrTheme_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		case 'webmention' :
	?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment <?php $comment->comment_type; ?>" itemprop="comment" itemscope itemtype="http://schema.org/Comment">
				<div class="comment-content p-summary p-name" itemprop="text name description">
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<p><?php _e( 'Your comment is awaiting moderation.', 'drtheme' ); ?></p>
					<?php else :?>
						<?php comment_text(); ?>
					<?php endif; ?>
				</div>
				<header>
					<div class="comment-meta commentmetadata">
						<address class="comment-author p-author author vcard hcard h-card" itemprop="creator" itemscope itemtype="http://schema.org/Person">
							<?php printf( '<cite class="fn p-name" itemprop="name">%s</cite>', get_comment_author_link() ); ?>
						</address>
						<span class="sep">-</span>
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<time class="updated published dt-updated dt-published" datetime="<?php comment_time( 'c' ); ?>" itemprop="datePublished dateModified dateCreated">
							<?php
							/* translators: 1: date, 2: time */
							printf( __( '%1$s at %2$s', 'sempress' ), get_comment_date(), get_comment_time() ); ?>
							</time>
						</a>
						<?php edit_comment_link( __( '(Edit)', 'sempress' ), ' ' ); ?>
					</div>
				</header>
			</article>
		<?php
				break;
			default :
			?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>" class="comment <?php $comment->comment_type; ?>" itemprop="comment" itemscope itemtype="http://schema.org/Comment">
					<header>
						<address class="comment-author p-author author vcard hcard h-card" itemprop="creator" itemscope itemtype="http://schema.org/Person">
							<?php echo get_avatar( $comment, 50 ); ?>
							<?php printf( '<cite class="fn p-name" itemprop="name">%s</cite>', get_comment_author_link() ) ; ?>
						</address><!-- .comment-author .vcard -->
						<div class="comment-meta commentmetadata">
							<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
								<time class="updated published u-updated u-published" datetime="<?php comment_time( 'c' ); ?>" itemprop="datePublished dateModified dateCreated">
									<?php
									/* translators: 1: date, 2: time */
									printf( __( '%1$s at %2$s', 'drtheme' ), get_comment_date(), get_comment_time() ); ?>
								</time>
							</a>
							<?php edit_comment_link( __( '(Edit)', 'drtheme' ), ' ' ); ?>
						</div><!-- .comment-meta .commentmetadata -->
					</header>
					<div class="comment-content e-content p-summary p-name" itemprop="text name description">
						<?php if ( $comment->comment_approved == '0' ) : ?>
							<p><?php _e( 'Your comment is awaiting moderation.', 'drtheme' ); ?></p>
						<?php else :?>
							<?php comment_text(); ?>
						<?php endif; ?>
					</div>
					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div><!-- .reply -->
				</article><!-- #comment-## -->
			<?php
			break;
		endswitch;
}
endif; // ends check for DrTheme_comment()

// Generate Nonce for comment
function add_nonce_field_to_comment_form() {
    wp_nonce_field('comment_form_nonce_field');
}
 
// Add Nonce To Comment Form 
add_action('comment_form', 'add_nonce_field_to_comment_form');
 
// Check Nonce comment form Field Validity
function check_nonce_field_on_comment_form() {
    if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'comment_form_nonce_field')) {
       wp_die('Nonce Check Failed - Killing Request', 'DrTheme - Error message');
    }
}
 
// Add Nonce Check To Comment Form Post
add_action('pre_comment_on_post', 'check_nonce_field_on_comment_form');


/**
 * adds the new HTML5 input types to the comment-form
 *
 * @param string $form
 * @return string
 */
function DrTheme_comment_input_types($fields) {
	$fields['author'] = preg_replace('/<input/', '<input autocomplete="nickname name"', $fields['author']);
	$fields['email'] = preg_replace('/<input/','<input autocomplete="email" class="email"', $fields['email']);
	$fields['url'] = preg_replace('/<input/','<input autocomplete="url" class="url"', $fields['url']);
	return $fields;
}
add_filter("comment_form_default_fields", "DrTheme_comment_input_types");

/**
 * adds the new HTML5 input types to the comment-text-area
 *
 * @param string $field
 * @return string
 */
function DrTheme_comment_field_input_type($field) {
  return preg_replace('/<textarea/','<textarea required="required"', $field);
}
add_filter("comment_form_field_comment", "DrTheme_comment_field_input_type");

/**
 * clear cookies comment after submit form
 * @output
 */
function DrTheme_comment_delete_cookies(){
	unset($_COOKIE['comment_author_' . COOKIEHASH]);
	unset($_COOKIE['comment_author_email_' . COOKIEHASH]);
	unset($_COOKIE['comment_author_url_' . COOKIEHASH]);
	//unset($_COOKIE[]);
	// empty value and expiration one hour before
	setcookie('comment_author_' . COOKIEHASH, '', time() - 3600);
	setcookie('comment_author_email_' . COOKIEHASH, '', time() - 3600);
	setcookie('comment_author_url_' . COOKIEHASH, '', time() - 3600);
}
add_action('init', 'DrTheme_comment_delete_cookies');