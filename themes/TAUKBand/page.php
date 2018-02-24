<?php get_header(); ?>

    <div id="content" class="clearfix">
        
        <div id="main" class="col620 clearfix" role="main">
				
				<header class="page-header">
					<?php if ( is_page('join-our-email-list') ) : ?>
						<h1 class="page-title"><h2>Join Our Email List</h2><hr>Sign up for our exclusive updates & get the latest from the band</h1>
					<?php elseif ( is_page('staukers') ) : ?>
						<h1 class="page-title"><h2>Join the STAUKERS</h2><hr>Interested in promoting for a TAUK show or festival? Enter your details below and we’ll get in touch!</h1>
					<?php elseif ( is_page('about') ) : ?>
						<h1 class="page-title"><h2>About TAUK</h2>
							<hr>
							<div id="four-column"><strong>Matt Jalbert<br>(Guitar)</strong></div>
							<div id="four-column"><strong>Charlie Dolan<br>(Bass)</strong></div>
							<div id="four-column"><strong>"A.C." Carter<br>(Keyboards)</strong></div>
							<div id="four-column"><strong>Isaac Teel<br>(Drums)</strong></div>
							<div class="clear"></div>
						</h1>
					<?php elseif ( is_page('contact') ) : ?>
						<h1 class="page-title"><div id="two-column"><h2 align="center">Contact Us</h2></div><div id="two-column"><h2 align="center">Info</h2></div></h1>
						<hr>
					<?php elseif ( is_page('e-shop') ) : ?>
						<h1 class="page-title"><h2>TAUK Shop</h2><hr>CDs, Digital Downloads, Clothing, Stickers, Posters & More!</h1>
					<?php else : ?>
					<?php endif; ?>

				</header>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || '0' != get_comments_number() )
							comments_template( '', true );
					?>

				<?php endwhile; // end of the loop. ?>

        </div> <!-- end #main -->

        <?php get_sidebar('page'); // page sidebar  ?>

    </div> <!-- end #content -->
        
<?php get_footer(); ?>