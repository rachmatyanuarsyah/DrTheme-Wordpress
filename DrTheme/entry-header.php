	<header class="entry-header">
		<h1 class="entry-title p-name" itemprop="name headline">
			<span class="img-title-icon"></span>
			<a href="<?php the_permalink(); ?>" class="u-url url" title="<?php printf( esc_attr__( 'Permalink to %s', 'drtheme' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" itemprop="url">
				<?php the_title(); ?>
			</a>
		</h1>

		<div class="entry-meta">
			<?php DrTheme_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->