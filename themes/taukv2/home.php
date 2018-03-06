<?php
/**
 * Template Name: Custom Homepage
 * Description: Alternative homepage template that displays gallery images as background image slider, and with footer widgets.
 */
get_header(); ?>

<?php
  $highlight_reel = get_option('highlights',false);
  $shortcode = '';
  $shortcode .= '[slider]';
  $next = '';
  foreach ( $highlight_reel as $highlight ) {
    $link = $highlight['link'];
    $imgSRC = wp_get_attachment_URL($highlight['image']);
    $shortcode .= $next;
    $shortcode .= '<a href="' . $link . '" target="_blank"><img src="' . $imgSRC . '" width="100%"></a>';
    $next = '[next-slide]';
  }
  $shortcode .= '[/slider]';
?>

<!-- <aside id="highlights-widget-area" class="widget widget_text" role="complementary">
  <div class="textwidget"><?php echo do_shortcode($shortcode); ?></div>
</aside> -->

<aside id="tour-widget-area" class="widget widget_text" role="complementary">
  <div class="section-header">
    <h1 class="section-main">UPCOMING SHOWS</h1>
    <div class="see-more"><a href="/shows" title="TOUR">SEE ALL SHOWS</a></div>
  </div>
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
        <table>
          <thead>
            <td>Date</td>
            <td>Venue</td>
            <td>Location</td>
            <td>Share</td>
            <td>Tickets</td>
          </thead>
          <tbody>
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
                      <tr class="<?php echo $class[$i++%2]; ?> tour-widget">
            <td>
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
              <span class="vanue"><?php echo $show['headliner']; ?></span>
            </td>
            <td>
              <span class="city-state"><?php echo '<a href="' . $googlemaps . '" target="_blank">' . $show['city-state']; ?></a></spacing>
            </td>
            <td>
              <span class="share-show facebook"><a href="#"><i class="fab fa-facebook-square"></i></a></span>
              <span class="share-show twitter"><a href="#"><i class="fab fa-twitter-square"></i></a></span>
              <span class="share-show email"><a href="#"><i class="fas fa-envelope-square"></i></a></span>
            </td>
            <td>
              <span class="tickets-widget"><a href="<?php echo $show['tickets-link']; ?>" target="_blank"><i class="fas fa-ticket-alt"></i></a></span>
            </td>
          </tr>
        <?php endif; ?>
      <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
  </div>
</aside>

<div class="show-downloads">
    <div class="section-header">
        <h1 class="section-main">LIVE DOWNLOADS</h1>
        <div class="see-more"><a href="/shows" title="TOUR">ALL SHOWS</a></div>
  </div>
    <?php
      $live_shows = get_option('livedownloadsslides',false);

      foreach ( array_slice($live_shows, 0, 4) as $show ) {
        $link = $show['link-url'];
        $imgSRC = wp_get_attachment_URL($show['image']);
        $title = $show['title'];

        echo '<div class="show-slide">';
            echo '<a target="_blank" href="' . $link . '" alt="' . $title . '"><img src="' . $imgSRC . '"></img></a>';
        echo '</div>';
      }
    ?>

</div>


<?php
wp_reset_postdata();
get_footer(); ?>
