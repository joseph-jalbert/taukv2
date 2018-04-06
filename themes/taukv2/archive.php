<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package TAUKv2
 */

get_header(); ?>
<header class="page-header">

</header>
<aside id="tour-widget-area" class="widget widget_text" role="complementary">
  <div class="section-header">
	<h1 class="page-title">TAUK Tour <?php echo date('Y'); ?></h1>
  </div>
  <div class="textwidget">

	<?php $args = array(
	  'post_type' => 'shows',
	  'posts_per_page' => '1000',
	  'orderby'=>'meta_value_num',
	  'meta_key' => 'orderbyshowdate',
	  'order' => 'ASC'
	);
	$loop = new WP_Query( $args );

	if ( $loop->have_posts() ) : ?>
	  <div id="homepage-tour-widget">
		<table>
		  <thead>
			<td>Date</td>
			<td>Venue</td>
			<td>Location</td>
			<td></td>
			<td>Share</td>
			<td>Tickets</td>
		  </thead>
		  <tbody>
	  <?php
	  while ( $loop->have_posts()) : $loop->the_post(); ?>
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
		  $opener =$show['opening-bands'];
		  $location_array = explode(' ', trim($location) );
		  $city = $location_array[0];
		  $state = $location_array[1];
		  $googlemaps = "https://www.google.com/maps/place/$city+$state";
		?>
		<?php if ( $showstatus != 'past' ) : ?>
					  <tr class="<?php echo $class[$i++%2]; ?> tour-widget">
			<td class="date-data">
			  <span class="red-date">
				<?php
				  echo $fixdate;
				  if ( $show['end-date'] != '' ) {
					echo ' - ' . $fixenddate;
				  }
				?></strong>
			  </span>
			</td>
			<td>
			  <span class="venue"><?php echo $show['headliner']; ?></span>
			</td>
			<td class="location-data">
			  <span class="city-state"><?php echo '<a href="' . $googlemaps . '" target="_blank">' . $show['city-state']; ?></a></spacing>
			</td>
			<td class="opener-data">
				<span class="opener"><?php echo $opener; ?></span>
			</td>
			<td class="share-data">
			  <span class="share-show facebook"><a href="#"><i class="fab fa-facebook-square"></i></a></span>
			  <span class="share-show twitter"><a href="#"><i class="fab fa-twitter-square"></i></a></span>
			  <span class="share-show email"><a href="#"><i class="fas fa-envelope-square"></i></a></span>
			</td>
			<td>
			  <span class="tickets-widget"><a href="<?php echo $show['tickets-link']; ?>" target="_blank"><i class="fas fa-ticket-alt"></i></a></span>
			</td>
		  </tr>
		<?php
			endif;
		endwhile; ?>
		  </tbody>
		</table>
	  </div>
	<?php endif;
	wp_reset_postdata(); ?>
  </div>
</aside>
<?php
get_sidebar();
get_footer();
