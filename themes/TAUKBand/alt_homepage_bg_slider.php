<?php
/**
 * Template Name: Alt_Homepage, w/ Background Image Slider
 * Description: Alternative homepage template that displays gallery images as background image slider, and with footer widgets.
 */
get_header(); ?>
    
    
    <?php if ( is_active_sidebar( 'sidebar-alt' ) ) : ?>
    
      <div id="alt-sidebar-wrap" class="clearfix">
        <div id="alt-sidebar" class="widget-area" role="complementary">
		<?php
			$livedownloads_array = get_option('livedownloadsslides');
			$shortcode = $next = '';
			$shortcode .= '[slider transition=fade duration=8000]';
			foreach ( $livedownloads_array as $livedownload ) {
				$img_url = wp_get_attachment_URL($livedownload['image']);
				$shortcode .= $next;
				if ( $livedownload['link-url'] != '' ) {
					$shortcode .= '<a href="' . $livedownload['link-url'] . '" target="_blank"><img src="' . $img_url . '" width="100%"></a>';
				}
				else {
					$shortcode .= '<a href="http://nugs.net/tauk" target="_blank"><img src="' . $img_url . '" width="100%"></a>';
				}
				$next = '[next-slide]';
			}
			$shortcode .= '[/slider]';
		?>
	
		<aside id="new-album-homepage-widget" class="widget widget_text" role="complementary">
			<div class="widget-title">NEW MUSIC</div>
			<div class="textwidget"><?php echo do_shortcode($shortcode); ?></div>
		</aside>
		<?php
			$highlight_reel = get_option('highlights',false);
			$shortcode = '';
			$shortcode .= '[slider]';
			$next = '';	
			foreach ( $highlight_reel as $highlight ) {
				$imgURL = wp_get_attachment_URL($highlight['image']);
				$shortcode .= $next;
				$shortcode .= '<a href="' . $imgURL . '"><img src="' . $imgURL . '" width="100%"></a>';
				$next = '[next-slide]';
			}
			$shortcode .= '[/slider]';
		?>
		
		<aside id="highlights-widget-area" class="widget widget_text" role="complementary">
			<div class="widget-title">HIGHLIGHTS</div>
			<div class="textwidget"><?php echo do_shortcode($shortcode); ?></div>
		</aside>

		<aside id="tour-widget-area" class="widget widget_text" role="complementary">
			<div class="widget-title"><a href="/shows" title="TOUR">TOUR</a></div>
			<div class="textwidget">
				<?php 
					$args = array( 'post_type' => 'shows', 'posts_per_page' => '1000', 'orderby'=>'title','order'=>'DESC' );
					$loop = new WP_Query( $args ); 
				?>
				<?php if ( $loop->have_posts() ) : ?>

					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
						<?php 
							$show_array = get_post_meta(get_the_ID(),'showdetails',true); 
							$show = $show_array[0]; 
							$showdate = $show['show-date'];
							$showdate_array = explode('-',$showdate);
							$day = $showdate_array[0];
							$month = $showdate_array[1];
							$year = $showdate_array[2];
							$fixdate = "$year$month$day";
							$enddate = $show['end-date'];
							$enddate_array = explode('-',$enddate);
							$endday = $enddate_array[0];
							$endmonth = $enddate_array[1];
							$endyear = substr($enddate_array[2],2);
							$fixenddate = "$endmonth/$endday/$endyear";
							$today = date('d');
							$thismonth = date('m');
							$thisyear = date('Y');
							$todaysdate = "$thisyear$thismonth$today";
							if ( $todaysdate <= $fixdate || $todaysdate <= $fixenddate ) { 
								$val = "upcoming";
							}
							else {
								$val = "past";
						}
							update_post_meta(get_the_ID(),'showstatus',$val); 
							update_post_meta(get_the_ID(),'orderbyshowdate',$fixdate);
						?>
					<?php endwhile; ?>
				<?php endif; ?>
				<?php rewind_posts(); ?>
				<?php $args = array( 
					'post_type' => 'shows', 
					'posts_per_page' => '1000', 
					'orderby'=>'meta_value_num',
					'meta_key' => 'orderbyshowdate',
					'order' => 'ASC'
				);
				$loop = new WP_Query( $args ); ?>
				<?php if ( $loop->have_posts() ) : ?>
					<?php /* Adds Odd/Even Classes */
						$i=0;
						$class=array('odd','even'); 
					?>
					<div id="homepage-tour-widget">
					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
						<?php 
							$showstatus = get_post_meta(get_the_ID(),'showstatus',true); 
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
						?>
						<?php if ( $showstatus != 'past' ) : ?>
				                	<div class="<?php echo $class[$i++%2]; ?> tour-widget">
								<div id="widget-twothirds-column">
									<div class="red-date"><strong>
										<?php 
											echo $fixdate; 
											if ( $show['end-date'] != '' ) { 
												echo ' - ' . $fixenddate; 
											}  
										?></strong>
									</div>
									<strong><?php echo $show['headliner']; ?></strong>
								</div>
								<div id="widget-three-column">
									<div class="city-state"><?php echo '<a href="' . $googlemaps . '" target="_blank">' . $show['city-state']; ?></a></div>
									<div class="tickets-widget"><a href="<?php echo $show['tickets-link']; ?>" target="_blank"><img src="https://www.taukband.com/wp-content/uploads/2016/02/ticketswidgetbutton.png" width="100px"></a></div>
								</div>
								<div class="clear"></div>
							</div>
						<?php endif; ?>
					<?php endwhile; ?>
					</div>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>

			</div>
		</aside>
        	<?php dynamic_sidebar('sidebar-alt'); ?>
        </div>
      </div>
    	
    <?php endif; ?>
    
        
<?php get_footer(); ?>