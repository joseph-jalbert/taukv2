<?php get_header(); ?>

<?php if ( is_singular('photos') ) : ?>
	<div id="content" class="clearfix full-width-content">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', 'single' ); ?>
			<?php wp_advocate_content_nav( 'nav-below' ); ?>
		<?php endwhile; ?>
	</div>
	
<?php else : ?>
        <div id="content" class="clearfix">
        	<div id="main" class="col620 clearfix" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template( '', true );
				?>
                
                		<?php wp_advocate_content_nav( 'nav-below' ); ?>

			<?php endwhile; // end of the loop. ?>

        	</div> <!-- end #main -->

        	<?php get_sidebar(); ?>
  	</div> <!-- end #content -->

<?php endif; ?>
        
<?php get_footer(); ?>