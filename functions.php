<?php

// adding og image from the function.php because yoast didnt work
function dgsoft_fb(){
    if( is_single() ) {
        echo '<meta property="og:image" content="'. get_the_post_thumbnail_url(get_the_ID(),'full')   .'" />';
    }
}
add_action('wp_head', 'dgsoft_fb');

// Function to change email address
function wpb_sender_email( $original_email_address ) {
  return 'noreply@typout.com';
}
// Function to change sender name
function wpb_sender_name( $original_email_from ) {
  return 'Typout';
}
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

// adding css and javascript files 
function typout_files() {
  wp_enqueue_script('typout-js', get_theme_file_uri('/js/scripts.js'), NULL, '1.11', true);
  wp_enqueue_style('typout_styles', get_stylesheet_uri(), array(), '1.11');
  wp_localize_script('typout-js', 'typout_data', array(
    'nonce' => wp_create_nonce('wp_rest'),
  ));
}
add_action('wp_enqueue_scripts', 'typout_files');

function typout_setup() {
  // add featured image support
  add_theme_support('post-thumbnails');
  add_image_size('small_thumbnail', 260, 240, true);
  // add title for each page
  add_theme_support('title-tag');
}
 add_action('after_setup_theme', 'typout_setup');

// redirect users to the hompage instead of the backend page

add_action('admin_init', 'redirect_users_to_homepage');

function redirect_users_to_homepage(){

  $user = wp_get_current_user();

  if($user->roles[0] == 'subscriber' AND count($user->roles) == 1) {
    wp_redirect(site_url('/'));
    exit; 
  }
}

// removing wordpress black bar

add_action('wp_loaded', 'no_black_bar');

function no_black_bar(){
  show_admin_bar(false);
}

add_filter('login_headerurl', 'our_header_url');

function our_header_url(){
  return site_url('/');
}

add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginCSS() {
  wp_enqueue_style('typout_styles', get_stylesheet_uri());
}

add_filter('login_headertitle', 'ourLoginTitle');

function ourLoginTitle() {
  return get_bloginfo('typout');
}

