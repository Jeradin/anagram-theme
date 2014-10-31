<?php get_header(); ?>
	<?php while ( have_posts() ) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<h1 class="page-title"><?php the_title(); ?></h1>

		<div class="entry-meta">
			<?php the_time('m.d.Y'); // Display the time it was published ?>
			<?php // the author(); Uncomment this and it will display the post author ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'anagram_coal' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
			<div class="cat-links"><?php echo get_the_category_list(); // Display the categories this post belongs to, as links ?></div>
			<div class="tags-links"><?php echo get_the_tag_list( '| &nbsp;', '&nbsp;' ); // Display the tags this post has, as links separated by spaces and pipes ?></div>
	</footer><!-- .entry-meta -->

			<?php previous_post_link( '<li class="nav-previous previous">%link</li>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'anagram_coal' ) . '</span> %title' ); ?>
			<?php next_post_link( '<li class="nav-next next">%link</li>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'anagram_coal' ) . '</span>' ); ?>
		<?php
					// If comments are open or we have at least one comment, load up the default comment template provided by Wordpress
					if ( comments_open() || '0' != get_comments_number() )
						comments_template( '', true );
				?>
	<?php endwhile; // end of the loop. ?>
</article><!-- #post-## -->
<?php get_footer(); ?>