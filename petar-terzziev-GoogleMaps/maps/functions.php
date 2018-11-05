<?php // custom functions.php template @ digwp.com

// add feed links to header
if (function_exists('automatic_feed_links')) {
	automatic_feed_links();
} else {
	return;
}


// smart jquery inclusion
if (!is_admin()) {
	wp_deregister_script('jquery');
	wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"), false, '1.3.2');
	wp_enqueue_script('jquery');
}


// enable threaded comments
function enable_threaded_comments(){
	if (!is_admin()) {
		if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
			wp_enqueue_script('comment-reply');
		}
}
add_action('get_header', 'enable_threaded_comments');


// remove junk from head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);


// add google analytics to footer
function add_google_analytics() {
	echo '<script src="http://www.google-analytics.com/ga.js" type="text/javascript"></script>';
	echo '<script type="text/javascript">';
	echo 'var pageTracker = _gat._getTracker("UA-XXXXX-X");';
	echo 'pageTracker._trackPageview();';
	echo '</script>';
}
add_action('wp_footer', 'add_google_analytics');


// custom excerpt length
function custom_excerpt_length($length) {
	return 20;
}
add_filter('excerpt_length', 'custom_excerpt_length');


// custom excerpt ellipses for 2.9+
function custom_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'custom_excerpt_more');

/* custom excerpt ellipses for 2.8-
function custom_excerpt_more($excerpt) {
	return str_replace('[...]', '...', $excerpt);
}
add_filter('wp_trim_excerpt', 'custom_excerpt_more'); 
*/


// no more jumping for read more link
function no_more_jumping($post) {
	return '<a href="'.get_permalink($post->ID).'" class="read-more">'.'Continue Reading'.'</a>';
}
add_filter('excerpt_more', 'no_more_jumping');


// add a favicon to your 
function blog_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('wpurl').'/favicon.ico" />';
}
add_action('wp_head', 'blog_favicon');


// add a favicon for your admin
function admin_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('stylesheet_directory').'/images/favicon.png" />';
}
add_action('admin_head', 'admin_favicon');


// custom admin login logo
function custom_login_logo() {
	echo '<style type="text/css">
	h1 a { background-image: url('.get_bloginfo('template_directory').'/images/custom-login-logo.png) !important; }
	</style>';
}
add_action('login_head', 'custom_login_logo');


// disable all widget areas
function disable_all_widgets($sidebars_widgets) {
	//if (is_home())
		$sidebars_widgets = array(false);
	return $sidebars_widgets;
}
add_filter('sidebars_widgets', 'disable_all_widgets');


// kill the admin nag
if (!current_user_can('edit_users')) {
	add_action('init', create_function('$a', "remove_action('init', 'wp_version_check');"), 2);
	add_filter('pre_option_update_core', create_function('$a', "return null;"));
}


// category id in body and post class
function category_id_class($classes) {
	global $post;
	foreach((get_the_category($post->ID)) as $category)
		$classes [] = 'cat-' . $category->cat_ID . '-id';
		return $classes;
}
add_filter('post_class', 'category_id_class');
add_filter('body_class', 'category_id_class');


// get the first category id
function get_first_category_ID() {
	$category = get_the_category();
	return $category[0]->cat_ID;
}

add_action( 'wp_ajax_my_action', 'my_action_callback' );
add_action( 'wp_ajax_nopriv_my_action', 'my_action_callback' );

function my_action_callback(){
global $wpdb;
$exp=$_GET['in'].''.'%';
$sql=$wpdb->prepare("Select distinct city from wp_coordinates  where country=%s AND city like %s limit 5",array($_GET['country'],$exp));
$cities=$wpdb->get_results($sql);
 header("Content-type:application/json");
echo json_encode($cities, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
exit;
}



add_action( 'wp_ajax_my_action2', 'my_action2_callback' );
add_action( 'wp_ajax_nopriv_my_action2', 'my_action2_callback' );

function my_action2_callback(){
global $wpdb;
session_start();
if($_GET['country']=='null'&&$_GET['latfrom']!='null'&&$_GET['latto']!='null'&&$_GET['lngfrom']!='null'&&$_GET['lngto']!='null'&&$_GET['populationfrom']!='null'&&$_GET['populationto']!='null'){
	$sql='select lat, lng, city,population from wp_coordinates where timezone=\''.$_SESSION['l_timezone'].'\' AND country like \''.$_SESSION['l_country'].'%\' AND lat>\''.$_SESSION['l_latfrom'].'\' AND lat<\''.$_SESSION['l_latto'].'\'  AND lng>\''.$_SESSION['l_lngfrom'].'\' AND lng<\''.$_SESSION['l_lngto'].'\' AND population>=\''.$_SESSION['l_populationfrom'].'\' AND population<=\''.$_SESSION['l_populationto'].'\'';
	
$cities=$wpdb->get_results($sql);
 header("Content-type:application/json");
echo json_encode($cities, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
}
else{
$_SESSION['l_timezone']=$_GET['timezone'];
$_SESSION['l_country']=$country=$_GET['country']!='null' ? $_GET['country']:''; 
$_SESSION['l_latfrom']=$latf=$_GET['latfrom']!='' ? $_GET['latfrom']:'-90'; 
$_SESSION['l_latto']=$latt=$_GET['latto']!='' ? $_GET['latto']:'90'; 
$_SESSION['l_lngfrom']=$lngf=$_GET['lngfrom']!='' ? $_GET['lngfrom']:'-180'; 
$_SESSION['l_lngto']=$lngt=$_GET['lngto']!='' ? $_GET['lngto']:'180'; 
$_SESSION['l_populationfrom']=$populationf=$_GET['populationfrom']!='' ? $_GET['populationfrom']:'0'; 
$_SESSION['l_populationto']=$populationt=$_GET['populationto']!='' ? $_GET['populationto']:'1000000000'; 
$sql='select lat, lng, city,population from wp_coordinates where timezone=\''.$_GET['timezone'].'\' AND country like \''.$country.'%\' AND lat>\''.$latf.'\' AND lat<\''.$latt.'\'  AND lng>\''.$lngf.'\' AND lng<\''.$lngt.'\' AND population>=\''.$populationf.'\' AND population<=\''.$populationt.'\'';
if (isset($_GET['city'])&&$_GET['city']!=''){
	$sql='select lat, lng, city,population from wp_coordinates where timezone=\''.$_GET['timezone'].'\' AND country like \''.$country.'%\' AND city=\''.$_GET['city'].'\' AND lat>\''.$latf.'\' AND lat<\''.$latt.'\'  AND lng>\''.$lngf.'\' AND lng<\''.$lngt.'\' AND population>=\''.$populationf.'\' AND population<=\''.$populationt.'\'';
}



$cities=$wpdb->get_results($sql);
 header("Content-type:application/json");
echo json_encode($cities, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
}
exit;
}




add_action( 'wp_ajax_load_countries', 'load_countries_callback' );
add_action( 'wp_ajax_nopriv_load_countries', 'load_countries_callback' );

function load_countries_callback(){
global $wpdb;
$sql=$wpdb->prepare("Select distinct country from wp_coordinates  where timezone=%s",array($_GET['timezone']));
$cities=$wpdb->get_results($sql);
 header("Content-type:application/json");
echo json_encode($cities, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
exit;
}



?>