<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="noimg"></div>
	<div class="entry-content post-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'wp-advocate' ), 'after' => '</div>' ) ); ?>
        <?php edit_post_link( __( 'Edit', 'wp-advocate' ), '<span class="edit-link">', '</span>' ); ?>
	</div><!-- .entry-content -->
	
</article><!-- #post-<?php the_ID(); ?> -->
