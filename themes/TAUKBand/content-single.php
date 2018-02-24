<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php if ( is_singular('shows') ) : ?>
	<?php 
		$show_array = get_post_meta(get_the_ID(),'showdetails',true);
		$show = $show_array[0];
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
		if ( has_post_thumbnail() ) { $img_url = wp_get_attachment_url( get_post_thumbnail_id() ); }
	?>
	
	<header class="page-header">
		<h1 class="page-title"><div id="two-column"><h2 class="single-show-title"><?php echo $show['headliner']; ?></h2></div><div id="two-column"><div class="tickets"><a href="<?php $show['tickets-link'] ?>" target="_blank"><img src="https://www.taukband.com/wp-content/uploads/2016/02/buytickets.png" width="70%" class="alignright"></a></div><div class="clear"></div></div><div class="clear"></div></h1>
		<hr>
		<div class="entry-meta">
			<div id="twothirds-column">
				<div class="white-openbands"><?php echo $show['opening-bands']; ?></div>
			</div>
			<div id="three-column">
				<a href="<?php echo $show['venue-website']; ?>" target="_blank"><p style="text-align:right; font-size:14px;">@<?php echo $show['venue']; ?></p></a>
			</div>
			<div class="clear"></div>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

<?php elseif ( is_singular('photos') ) : ?>
	<?php 
		$album_array = get_post_meta(get_the_ID(),'albumdetails',true);
		$album = $album_array[0];
		if ( has_post_thumbnail() ) { $img_url = wp_get_attachment_url( get_post_thumbnail_id() ); }
	?>
	<header class="page-header">
		<h1 class="page-title"><h2><?php the_title(); ?></h2><hr><?php echo $album['description']; ?></h1>
	</header>

<?php else : ?>
	<header class="page-header">
		<h1 class="page-title"><h2><?php the_title(); ?></h2><hr></h1>

		<div class="entry-meta">
			<?php wp_advocate_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

<?php endif; ?>
    
    <div class="noimg"></div>

	<?php if ( is_singular('shows') ) : ?>
		<div class="entry-content post-content">
		<h3>Show Info</h3>
		<hr>
		<div id="three-column">
			<?php if ( $img_url != '' ) {
				echo '<img src="' . $img_url . '" width="100%">';
			} else {
				echo '<img src="https://www.taukband.com/wp-content/uploads/2016/02/tauk-tiny-black-logo.png" width="100%">';
			} ?>
		</div>
		<div id="twothirds-column">
			<ul>
				<li><strong>Location:</strong> <?php echo '<a href="' . $googlemaps . '" target="_blank">' . $show['city-state'] . '</a>'; ?></li>
				<li><?php if ( $show['end-date'] != '' ) { echo '<li><strong>Show Dates:</strong> ' . $fixdate . ' - ' . $fixenddate . '</li>'; } else { echo '<li><strong>Show Date:</strong> ' . $fixdate . '</li>'; } ?></li> 
				<li><strong>Headliner:</strong> <?php echo $show['headliner']; ?></li>
				<li><?php echo $show['opening-bands']; ?></li>
				<li><strong>Venue:</strong> <?php echo '<a href="' . $show['venue-website'] . '" target="_blank">' . $show['venue'] . '&raquo;</a>'; ?></li>
				<li><strong>Doors Open:</strong> <?php echo $show['time']; ?></li>
				<li><strong>Tickets:</strong> <?php echo '<a href="' . $show['tickets-link'] . '" target="_blank">Buy Now &raquo;</a>'; ?></li>
			</ul>
		</div>
		<div class="clear"></div>
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'wp-advocate' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->

	<?php elseif ( is_singular('photos') ) : ?>
		<div class="entry-content post-content">
			<a href="https://www.taukband.com/photos/">&laquo; Back to the Galleries</a>
			<?php the_content(); ?>
		</div>

	<?php else : ?>

		<div class="entry-content post-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'wp-advocate' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->

	<?php endif; ?>
	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
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
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php edit_post_link( __( 'Edit', 'wp-advocate' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
