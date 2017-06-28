<footer class="entry-meta">
	<?php 
	if (in_array(get_post_format(), array("aside", "link", "status", "quote"))) {
		DrTheme_posted_on();
	} else {
		_e( 'Posted ', 'drtheme' );
	}
	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( __( ', ', 'drtheme' ) );
	if ( $categories_list ) : ?>
		<span class="cat-links">
			<?php printf( __( 'in %1$s', 'drtheme' ), $categories_list ); ?>
		</span>
	<?php endif; // End if categories 
	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', __( ', ', 'drtheme' ) );
	if ( $tags_list ) : ?>
		<span class="tag-links" itemprop="keywords">
			<?php printf( __( 'Tagged Post : %1$s', 'drtheme' ), $tags_list ); ?>
		</span>
	<?php endif; ?>
	<?php edit_post_link( __( 'Edit Post', 'drtheme' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
	
</footer><!-- #entry-meta -->