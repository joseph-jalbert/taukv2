<?php
/**
 * Template Name: Full-width, no sidebar
 * Description: A full-width template with no sidebar
 */
get_header(); ?>

    <div id="content" class="clearfix full-width-content">
        <header class="page-header">
		<?php if ( is_page('music') ) : ?>
			<h1 class="page-title"><h2>TAUK Discography</h2><hr>Listen to the Music</h1>
		<?php elseif ( is_page('photos') ) : ?>
			<h1 class="page-title"><h2>TAUK Galleries</h2><hr>Photo Galleries from Our Tours & Shows - Click to view galleries</h1>
		<?php elseif ( is_page('videos') ) : ?>
			<h1 class="page-title"><h2>Watch TAUK Videos</h2><hr>Featured Video & Video Playlists</h1>
		<?php elseif ( is_page('live-downloads') ) : ?>
			<h1 class="page-title"><h2>TAUK is now on Nugs.net</h2><hr>Download Live Music from TAUK On Tour!</h1>
		<?php endif; ?>
	</header>
        <div id="main" class="clearfix" role="main">
		<?php if ( is_page('photos') ) : ?>
			<div class="entry-content post-content">
				<?php 
					$args = array( 'post_type' => 'photos', 'posts_per_page' => '100', 'orderby'=>'date','order'=>'DESC' );
					$loop = new WP_Query( $args );
				?>
				<?php if ( $loop->have_posts() ) : ?>
					<?php $i = 1; ?>
					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
						<?php 
							$album_array = get_post_meta(get_the_ID(),'albumdetails',true); 
							$album = $album_array[0];
						?>
		
						<div id="five-column" style="margin-bottom: 10px;"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail', array('class' => 'align-thumbnail')); ?><h4><?php the_title(); ?> &raquo;</h4></a></div>
						<?php if ( $i%5 == 0 ) : ?>
							<div class="clear"></div>
						<?php endif; $i++; ?>
	
					<?php endwhile; ?>
				<?php endif; ?>
				<?php rewind_posts(); ?>
			</div>
		<?php elseif ( is_page('live-downloads') ) : ?>
			<div class="entry-content post-content">
			<br>
			<?php 
				$livedownloads_array = get_option('livedownloadspage');
				$i = 1;
				foreach ($livedownloads_array as $livedownload) {
					$img_url = wp_get_attachment_url($livedownload['image']);
					if ( $livedownload['link-url'] != '' ) {
						echo '<div id="three-column"><a href="' . $livedownload['link-url'] . '" target="_blank"><img src="' . $img_url . '" title="TAUK @ ' . $livedownload['venue'] . ' | ' . $livedownload['date'] . '"></a></div>';
					}
					else {
						echo '<div id="three-column"><a href="http://nugs.net/tauk" target="_blank"><img src="' . $img_url . '" title="TAUK @ ' . $livedownload['venue'] . ' | ' . $livedownload['date'] . '"></a></div>';
					}
					if ( $i%3 == 0 ) { echo '<div class="clear"></div><br>'; }
					$i++;
				}
			?>
			<?php the_content(); ?>
			</div>

		<?php else : ?>

				<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template( '', true );
				?>

				<?php endwhile; // end of the loop. ?>
		<?php endif; ?>
	</div>
</div>

<?php get_footer(); ?>