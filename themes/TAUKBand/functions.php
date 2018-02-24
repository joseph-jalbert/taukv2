<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

        
if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css' );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css' );

// END ENQUEUE PARENT ACTION

function my_script(){ ?>

	<script type="text/javascript">
	   var isInIFrame = (window.location != window.parent.location);
	   if(isInIFrame==true){
	       //alert("It's in an iFrame");
	       document.getElementByClass("head").style.display = "none";
	       }
	   else {
	       //alert("It's NOT in an iFrame");
	       }
	</script>

<?php } 

add_action('wp_footer', 'my_script'); 

function custom_widget_link( $title ) {

	// assume there's a link attached to the title because it starts with www, http, or /
	if ( ( substr( $title, 0, 4) == "www." ) || ( substr( $title, 0, 4) == "http" ) || ( substr( $title, 0, 1) == "/" ) ) {

		// split our title in half
		$title_pieces = explode( "|", $title );

		// if there's two pieces
		if ( count( $title_pieces ) == 2 ) {

			// add http if it's just www
			if ( substr( $title, 0, 4) == "www." ) {
				$title_pieces[0] = str_replace( "www.", "http://www.", $title_pieces[0] );
			}
			// create new title from url and extracted title
			$title = '<a href="' . $title_pieces[0] . '" title="' . $title_pieces[1] . '" target="_blank">' . $title_pieces[1] . '</a>';
			
		}
	}

	return $title;
}
add_filter( "widget_title", "custom_widget_link" );