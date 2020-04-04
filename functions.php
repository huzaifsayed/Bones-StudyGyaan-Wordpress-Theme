<?php
/*
Author: Eddie Machado
URL: http://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, etc.
*/

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  //Allow editor style.
  add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

  // let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
  require_once( 'library/custom-post-type.php' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // Custom Logo - StudyGyaan
  add_theme_support( 'custom-logo' );

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'bones_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 680;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 100 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 150 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-660' => __('660px by 150px'),
        'bones-thumb-600' => __('600px by 150px'),
        'bones-thumb-300' => __('300px by 100px'),
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* THEME CUSTOMIZE *********************/

/* 
  A good tutorial for creating your own Sections, Controls and Settings:
  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722
  
  Good articles on modifying the default options:
  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162
  
  To do:
  - Create a js for the postmessage transport method
  - Create some sanitize functions to sanitize inputs
  - Create some boilerplate Sections, Controls and Settings
*/

function bones_theme_customizer($wp_customize) {
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections 

  // $wp_customize->remove_section('title_tagline');
  // $wp_customize->remove_section('colors');
  // $wp_customize->remove_section('background_image');
  // $wp_customize->remove_section('static_front_page');
  // $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
  // $wp_customize->remove_control('blogdescription');
  
  // Uncomment the following to change the default section titles
  $wp_customize->get_section('colors')->title = __( 'Theme Background Color' );
  $wp_customize->get_section('background_image')->title = __( 'Theme Background Images' );
}

add_action( 'customize_register', 'bones_theme_customizer' );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
  ));

  register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Frontbar - Sidebar 2', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
  ));
  
  register_sidebar(array(
		'id' => 'sidebar3',
		'name' => __( 'Bottom Float - Sidebar 3', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'bonestheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'bonestheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!

// Adding Place holder to Search Form
function html5_search_form( $form ) { 
  $form = '<section class="search"><form class="search-form" role="search" method="get" id="search-form" action="' . home_url( '/' ) . '" >
 <label class="screen-reader-text" for="s">' . __('',  'domain') . '</label>
  <input type="search" value="' . get_search_query() . '" class="search-input" name="s" id="s" placeholder="Search articles" />
  <button type="submit" id="searchsubmit" class="submit search-button"><span class="dashicons dashicons-search"></span></button>
  </form></section>';
  return $form;
}

add_filter( 'get_search_form', 'html5_search_form' );

// Loading Dashiicon after Logout
function load_dashicons(){
  wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'load_dashicons');

/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function bones_fonts() {
  wp_enqueue_style('googleFonts', '//fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
}

add_action('wp_enqueue_scripts', 'bones_fonts');

/**
 * Change the excerpt more string
 */
function wpshout_change_and_link_excerpt( $more ) {
	if ( is_admin() ) {
		return $more;
	}
	// Change text, make it link, and return change
	return '&hellip; <a href="' . get_the_permalink() . '">Continue Reading »</a>';
 }
add_filter( 'excerpt_more', 'wpshout_change_and_link_excerpt', 999 );

/*
 * Prepend Facebook, Twitter and Google+ social share buttons to the post's content
 *
 */
function the_post_sharer( $content ) {

  global $post;

  // Get the post's URL that will be shared
  $post_url   = urlencode( esc_url( get_permalink($post->ID) ) );
  
  // Get the post's title
  $post_title = urlencode( $post->post_title );
  $post_image = get_the_post_thumbnail_url($post->ID);

  // Compose the share links for Facebook, Twitter, Pinterest and Linkendin
  $twitter_sharing_url = esc_url('http://twitter.com/share?text='.$post_title.'&url='.$post_url);
  $facebook_sharing_url = esc_url('https://www.facebook.com/sharer/sharer.php?u='.$post_url);
  $pinterest_sharing_url = esc_url('http://pinterest.com/pin/create/button/?url='.$post_url.'&media='.$post_image.'&description='.$post_title);
  $linkedin_sharing_url = esc_url('http://www.linkedin.com/shareArticle?mini=true&title=' . $post_title . '&url=' . $post_url);

  // Wrap the buttons
  $output = '<div id="share-buttons" class="post-sharer">Share: ';
  
      // Add the links inside the wrapper
      $output .= '<a id="facebook" target="_blank" href="' . $facebook_sharing_url . '" class="share-button facebook">Facebook</a>';
      $output .= '<a id="twitter" target="_blank" href="' . $twitter_sharing_url . '" class="share-button twitter">Twitter</a>';
      $output .= '<a id="pinterest" target="_blank" href="' . $pinterest_sharing_url . '" class="share-button pinterest">Pinterest</a>';
      $output .= '<a id="linkedin" target="_blank" href="' . $linkedin_sharing_url . '" class="share-button linkedin">Linkedin</a>';
      
  $output .= '</div>';

  // Return the buttons and the original content
  return $output . $content;

}

// Display Php File Name
// add_action('wp_head', 'show_template');
// function show_template() {
//     global $template;
//     echo basename($template);
// }

// Changing h3 to p tag
function themeslug_commentform_title( $args ) {
        
  $args['title_reply_before'] = '<p id="reply-title" class="h3 comment-reply-title">';
        $args['title_reply_after']  = '</p>';

 return  $args;
 
}
add_filter( 'comment_form_defaults', 'themeslug_commentform_title' );

// Writing Custom Post Sharer AddtoAny shortocde
// Add Shortcode
// The shortcode function
function post_sharer_shortcode() { 
 
  $site_url = get_template_directory_uri();;

  // Advertisement code pasted inside a variable
  // echo '<!-- AddToAny BEGIN --><div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="'. $site_url .'" data-a2a-title="'. $site_title .'" id="my_centered_buttons"><a class="has-text-align-center a2a_button_facebook"></a><a class="has-text-align-center a2a_button_twitter"></a><a class="has-text-align-center a2a_button_pinterest"></a><a class="has-text-align-center a2a_button_linkedin"></a><a class="has-text-align-center a2a_button_telegram"></a><a class="has-text-align-center a2a_button_whatsapp"></a></div><script async="" src="'. $site_url .'/wp-content/themes/Bones%20-%20StudyGyaan/library/js/sharebuttons/sharebuttons.js"></script><!-- AddToAny END --><style type="text/css">#my_centered_buttons { display: flex; justify-content: center; }</style>';
  // echo '<!-- AddToAny BEGIN --><div class="a2a_kit a2a_kit_size_32 a2a_default_style" id="my_centered_buttons"><a class="a2a_dd"></a><a class="a2a_button_facebook"></a><a class="a2a_button_twitter"></a><a class="a2a_button_pinterest"></a><a class="a2a_button_whatsapp"></a><a class="a2a_button_linkedin"></a><a class="a2a_button_telegram"></a></div><script async src="'. $site_url .'/library/js/sharebuttons/sharebuttons.js"></script><style type="text/css">#my_centered_buttons { display: flex; justify-content: center; }</style><!-- AddToAny END -->';
  echo '<!-- AddToAny BEGIN --><div class="a2a_kit a2a_kit_size_32 a2a_default_style" id="my_centered_buttons"><a class="a2a_button_facebook"></a><a class="a2a_button_twitter"></a><a class="a2a_button_pinterest"></a><a class="a2a_button_whatsapp"></a><a class="a2a_button_linkedin"></a><a class="a2a_button_telegram"></a><a class="a2a_button_reddit"></a></div><script async src="'. $site_url .'/library/js/sharebuttons/sharebuttons.js"></script><style type="text/css">#my_centered_buttons { display: flex; justify-content: center; }</style><!-- AddToAny END -->';

   
  }
// Register shortcode
add_shortcode('post_sharer_code', 'post_sharer_shortcode'); 

// Remove URL Field from Comment form
function wpb_disable_comment_url($fields) { 
  unset($fields['url']);
  return $fields;
}
add_filter('comment_form_default_fields','wpb_disable_comment_url');
// End Remove URL Field from Comment form

// Disable HTML in Comments
function wpb_comment_post( $incoming_comment ) {
  $incoming_comment['comment_content'] = htmlspecialchars($incoming_comment['comment_content']);
  $incoming_comment['comment_content'] = str_replace( "'", '&apos;', $incoming_comment['comment_content'] );
  return( $incoming_comment );
  }
  function wpb_comment_display( $comment_to_display ) {
   $comment_to_display = str_replace( '&apos;', "'", $comment_to_display );
   return $comment_to_display;
}
add_filter( 'preprocess_comment', 'wpb_comment_post', '', 1);
add_filter( 'comment_text', 'wpb_comment_display', '', 1);
add_filter( 'comment_text_rss', 'wpb_comment_display', '', 1);
add_filter( 'comment_excerpt', 'wpb_comment_display', '', 1);
remove_filter( 'comment_text', 'make_clickable', 9 );
// ENd Disable HTML in Comments

/* DON'T DELETE THIS CLOSING TAG */ ?>

