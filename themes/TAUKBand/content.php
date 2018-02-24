<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( is_post_type_archive('shows') ) { 
		$shows_array = get_post_meta(get_the_ID(),'showdetails',true);
		$show = $shows_array[0];
		$showdate = $show['show-date'];
		$showdate_array = explode('-',$showdate);
		$day = $showdate_array[0];
		$month = $showdate_array[1];
		$year = substr($showdate_array[2],2);
		$fixdate = "$month/$day/$year";
		$enddate = $show['end-date'];
		$enddate_array = explode('-',$enddate);
		$endday = $enddate_array[0];
		$endmonth = $enddate_array[1];
		$endyear = substr($enddate_array[2],2);
		$fixenddate = "$endmonth/$endday/$endyear";
		$location = $show['city-state'];
		$location_array = explode(' ', trim($location) );
		$city = $location_array[0];
		$state = $location_array[1];
		$googlemaps = "https://www.google.com/maps/place/$city+$state";
	}?>
	<header class="entry-header">
		<?php if (!is_post_type_archive('shows') ) : ?>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wp-advocate' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2> 
		<?php else : ?>
			<div id="twothirds-column-shows">
				<h3><?php echo $show['headliner']; ?></h3>
				<div class="red-date"><strong>
					<?php 
						if ( $show['end-date'] != '' ) { 
							echo $fixdate . ' - ' . $fixenddate; 
						}  
						else { 
							echo $fixdate; 
						}
						if ( $show['time'] != '' ) {
							echo ' | ' . $show['time'];
						}
					?></strong>
				</div>
				<h4 class="not-bold">
					<?php echo $show['opening-bands']; ?>
				</h4>
				<?php echo do_shortcode('[addtoany]'); ?>
			</div>
			<div id="three-column-shows">
				<?php echo '<div class="tickets"><a href="' . $show['tickets-link'] .'" target="_blank"><img src="http://www.taukband.com/wp-content/uploads/2016/02/buytickets.png" width="80%" class="alignright"></a></div><span style="font-size:19px; text-align:right; float:right;">' . $show['city-state'] . '<a href="' . $googlemaps . '" target="_blank"><img src="http://www.taukband.com/wp-content/uploads/2016/03/Google-Maps-icon.png" width="25" class="alignright" style="margin:2.5px;"></a></span><div class="clear"></div><h5 align="right"><a href="' . $show['venue-website'] . '" target="_blank">' . $show['venue'] . '</a></h5>'; ?>
			</div>
			<div class="clear"></div>
		<?php endif; ?>
		
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php wp_advocate_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
    	<div id="arhive-content" style="background:white;">
		<?php if ( !is_post_type_archive('shows') ) : ?>
			<div id="three-column">
    				<?php if ( has_post_thumbnail() ) : $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo $fixdate . ' - ' . $show['headliner']; ?>"><img src="<?php echo $url; ?>" width="100%"></a>
	     			<?php else : ?>
					<div class="noimg"></div>
	   			<?php endif; ?>
			</div>
		    	<div id="twothirds-column">
				<?php
				 if ( has_excerpt() ) {
					the_excerpt();
				 } else {
				 	echo wp_advocate_excerpt(25); 
				 }
				?>
			</div>
			<div class="clear"></div>
		<?php endif; ?>
	</div>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'wp-advocate' ), 'after' => '</div>' ) ); ?>
<!-- .entry-content -->

	<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
	<footer class="entry-meta">
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'wp-advocate' ) );
				if ( $categories_list && wp_advocate_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( '<span class="meta-cat"></span> %1$s', 'wp-advocate' ), $categories_list ); ?>
			</span>

			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'wp-advocate' ) );
				if ( $tags_list ) :
			?>
			<span class="tag-links">
				<?php printf( __( '<span class="meta-tag"></span> %1$s', 'wp-advocate' ), $tags_list ); ?>
			</span>

			<?php endif; // End if $tags_list ?>
		
		<?php edit_post_link( __( 'Edit', 'wp-advocate' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- #entry-meta -->
    <?php endif; // End if 'post' == get_post_type() ?>
</article><!-- #post-<?php the_ID(); ?> -->
