<?php get_header(); ?>

    <div id="content" class="clearfix">
        
        <div id="main" class="col620 clearfix" role="main">

				<?php if ( is_post_type_archive('shows') ) : ?>
					<header class="page-header">
						<h1 class="page-title"><h2>TAUK Tour <?php echo date('Y'); ?><hr></h2>Tour Dates, Venue Details & Tickets</h1>
					</header>
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
						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
							<?php $showstatus = get_post_meta(get_the_ID(),'showstatus',true); ?>
							<?php if ( $showstatus != 'past' ) : ?>
					                	<div class="<?php echo $class[$i++%2]; ?>">
									<?php get_template_part ( 'content', get_post_format() ); ?>
								</div>
							<?php endif; ?>
						<?php endwhile; ?>
					<?php endif; ?>
					<?php wp_reset_postdata(); ?>
				
				<?php elseif ( is_post_type_archive('post') ) : ?>
					TEST
					<?php if ( have_posts() ) : ?>
				<header class="page-header">
					<h1 class="page-title">
						<?php
							if ( is_day() ) :
								printf( __( 'Daily Archives: %s', 'wp-advocate' ), '<span>' . get_the_date() . '</span>' );
							elseif ( is_month() ) :
								printf( __( 'Monthly Archives: %s', 'wp-advocate' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );
							elseif ( is_year() ) :
								printf( __( 'Yearly Archives: %s', 'wp-advocate' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
							else :
								_e( 'Archives', 'wp-advocate' );
							endif;
						?>
					</h1>
				</header>
				
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
                  <div class="presspost">
					<?php
						/* Include the Post-Format-specific template for the content.
						 */
						get_template_part( 'content', get_post_format() );
					?>
                  </div>
				<?php endwhile; ?>

				<?php if (function_exists("wp_advocate_pagination")) {
							wp_advocate_pagination(); 
				} elseif (function_exists("wp_advocate_content_nav")) { 
							wp_advocate_content_nav( 'nav-below' );
				}?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'wp-advocate' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content post-content">
						<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'wp-advocate' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>
		<?php endif; ?>
        </div> <!-- end #main -->

        <?php get_sidebar(); ?>

    </div> <!-- end #content -->
        
<?php get_footer(); ?>