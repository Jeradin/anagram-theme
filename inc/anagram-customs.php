<?php

/**
 * Admin Custom functions for Currents
 */


// Removes Comments from admin menu
add_action( 'admin_menu', 'anagram_admin_menus' );
function anagram_admin_menus() {
		if (!current_user_can('manage_options')) {

		    remove_menu_page( 'edit-comments.php' );
		    //remove_menu_page('edit.php');
		    remove_menu_page('tools.php'); // Tools

			remove_menu_page( 'themes.php' );
			//remove_submenu_page( 'themes.php', 'nav-menus.php' );

		}
		add_menu_page('Nav Menus','Nav Menus', 'edit_theme_options', 'nav-menus.php', '','dashicons-editor-justify', 50);

}
// Removes Comments from post and pages
add_action('init', 'remove_comment_support', 100);

function remove_comment_support() {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
}
// Removes Comments from admin bar
function anagram_admin_bar_render() {
    global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', 'anagram_admin_bar_render' );



//Allow gform for editors
function add_gf_cap()
{
    $role = get_role( 'editor' );
    $role->add_cap( 'gform_full_access' );
    // add $cap capability to this role object
	$role->add_cap( 'edit_theme_options' );
}

add_action( 'admin_init', 'add_gf_cap' );


// Move Yoast to bottom
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');


/**
 * If an email address is entered in the username box, then look up the matching username and authenticate as per normal, using that.
 *
 * @param string $user
 * @param string $username
 * @param string $password
 * @return Results of autheticating via wp_authenticate_username_password(), using the username found when looking up via email.
 */
function dr_email_login_authenticate( $user, $username, $password ) {
	if ( !empty( $username ) )

		$user = get_user_by('email', $username);
	if ( $user )
		$username = $user->user_login;

	return wp_authenticate_username_password( null, $username, $password );
}
remove_filter( 'authenticate', 'wp_authenticate_username_password', 20, 3 );
add_filter( 'authenticate', 'dr_email_login_authenticate', 20, 3 );


/**
 * Modify the string on the login page to prompt for username or email address
 */
function username_or_email_login() {
	?><script type="text/javascript">
	// Form Label
	document.getElementById('loginform').childNodes[1].childNodes[1].childNodes[0].nodeValue = 'Username or Email';

	// Error Messages
	if ( document.getElementById('login_error') )
		document.getElementById('login_error').innerHTML = document.getElementById('login_error').innerHTML.replace( 'username', 'Username or Email' );
	</script><?php
}
add_action( 'login_form', 'username_or_email_login' );


/*Custom Tiny MCS buttons*/
add_filter( 'mce_buttons', 'my_mce_buttons' );
function my_mce_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}

add_filter( 'tiny_mce_before_init', 'my_mce_before_init' );
function my_mce_before_init( $settings ) {
	//$settings['theme_advanced_blockformats'] = 'p,a,div,span,h1,h2,h3,h4,h5,h6,tr,';
	$settings['theme_advanced_disable'] = 'formatselect';

    $style_formats = array(
    	array(
    		'title' => 'Button',
    		'selector' => 'a',
    		'classes' => 'button'
    	),
    	array(
    		'title' => 'Header',
    		'block' => 'h3'
    	),
    	array(
    		'title' => 'Highlight',
    		'inline' => 'span',
    		'classes' => 'highlight'
    	),
    	array(
    		'title' => 'Black Bold',
    		'inline' => 'span',
    		'classes' => 'blackbold'
    	),
        array(
        	'title' => 'Block Box',
        	'block' => 'div',
        	'classes' => 'blocktext',
        	'wrapper' => true
        )/*,
        array(
        	'title' => 'Bold Red Text',
        	'inline' => 'span',
        	'styles' => array(
        		'color' => '#f00',
        		'fontWeight' => 'bold'
        	)
        )*/
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}





function get_share_icons($permalink, $title='', $text='content'){
$shareicons = '<a onClick="MyWindow=window.open(\'http://twitter.com/home?status=Checkout this '.$text.' '.$title.' ('.$permalink.')\',\'MyWindow\',\'width=600,height=400\'); return false;" title="Share on Twitter" target="_blank" class="button sm"><i class="fa  fa-lg fa-twitter fa-fw"></i></a>

			<a href="http://www.facebook.com/share.php?u=$permalink" onClick="window.open(\'http://www.facebook.com/sharer.php?u=\'+encodeURIComponent(\''.$permalink.'\')+\'&title\'+encodeURIComponent(\''.$title.'\'),\'sharer\', \'toolbar=no,width=550,height=550\'); return false;" title="Share on Facebook" target="_blank" class="button sm"><i class="fa  fa-lg fa-facebook fa-fw"></i></a>

			<a onClick="MyWindow=window.open(\'http://www.linkedin.com/shareArticle?mini=true&url='.$permalink.'&title=<?php the_title(); ?>&source='. get_option('home').'\',\'MyWindow\',\'width=600,height=400\'); return false;" title="Share on LinkedIn" target="_blank" class="button sm"><i class="fa  fa-lg fa-linkedin fa-fw"></i></a>

			<a onClick="MyWindow=window.open(\'http://pinterest.com/pin/create/button/\',\'MyWindow\',\'width=600,height=400\'); return false;" count-layout="none" target="_blank" class="button sm"><i class="fa  fa-lg fa-pinterest fa-fw"></i></a>

			<a href="https://plus.google.com/share?url='.$permalink.'" onclick="javascript:window.open(this.href,
  \'\', \menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;" title="Share on Google+" target="_blank" class="button sm"><i class="fa  fa-lg fa-google-plus fa-fw"></i></a>

			<a href="mailto:?subject=I wanted you to see this site&amp;body=Check out this '.$text.' '.$permalink.'." title="Share by Email"  count-layout="none" class="button sm"><i class="fa  fa-lg fa-envelope-o fa-fw"></i></a>';

	     return $shareicons;

};



/*
*	Display Caption
*/
function be_display_image_and_caption($size='medium') {

	the_post_thumbnail($size);
	echo '<div class="caption">' . get_post( get_post_thumbnail_id() )->post_excerpt . '</div>';

}






	/**
	 * anagram_get_post_types
	 */
function anagram_get_post_types($items='', $listtype = 'text' ) {
 	$z=1;
 	if( empty($items) )  return false;
 	$count = count($items);
    $theitems = '';
		foreach( $items as $item):
		    $theitems .=  '<a href="'.get_permalink($item->ID).'">'.$item->post_title.'</a>';
			if($listtype == 'text'){
				if($z<$count-1&&!($z>$count)){ $theitems .= ', ';} elseif($z!=$count) { $theitems .= ' & ';};
			}else{
				$theitems .= '<br/>';
			};

			$z++;
		endforeach;

 return $theitems;

}

	/**
	 * get_custom_taxonomy
	 */
function get_custom_taxonomy($taxonomy ='', $separator = ' ', $type='slug', $theid = '' ) {
	global $post;
	$theid = $taxonomy=='' ? $post->ID : $theid;
	$taxonomy = $taxonomy=='' ? 'category' : $taxonomy;
   $terms = get_the_terms($theid , $taxonomy);

	if (  $terms && ! is_wp_error(  $terms ) ) :

    $thetax = array();
    foreach($terms as $terms) {    // concate
        $thetax[] =  $terms->$type;
    }

    return join( $separator, $thetax );

    endif;


}



/**
 * Modify the "Enter title here" text when adding new CPT, post or page
*/
function rc_change_default_title( $title ){
     $screen = get_current_screen();

     if  ( 'artist' == $screen->post_type ) {
          $title = 'Enter Artist Name';
     }
     return $title;
}
add_filter( 'enter_title_here', 'rc_change_default_title' );





//Sort post types
function custom_sort_pre_get_posts( $query ) {

if ( is_admin() )
	return;

    if ( isset( $query->query_vars[ 'post_type' ] ) && ($query->query_vars[ 'post_type' ] == 'festival' ) && !isset($_GET['orderby']) ) {
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'DESC' );
        $query->set( 'posts_per_page', -1 );
         //$query->set( 'meta_key', 'start_date' );
        /*$query->set( 'meta_query', array(
            array(
                'key' => 'start_date',
                //'value' => date( "m-d-Y" ),
              //  'compare' => '<='//,
                'type' => 'NUMBER'
            )
        ) );*/
    }

   // is_tax('work_type')

}
add_filter('pre_get_posts' , 'custom_sort_pre_get_posts');


//Page Slug Body Class
function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
$classes[] = $post->post_type . '-' . $post->post_name;
}
return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );






/**
 * Admin Custom functions for Currents
 */




/**
 * Hide all update notices except for admin
 */
function hide_update_notice_to_all_but_admin_users()
{
    if (!current_user_can('update_core')) {
        remove_action( 'admin_notices', 'update_nag', 3 );
    }
}
add_action( 'admin_notices', 'hide_update_notice_to_all_but_admin_users', 1 );



/*
 * Disable theme switch
 */
add_action( 'admin_init', 'slt_lock_theme' );
function slt_lock_theme() {
global $submenu, $userdata;
get_currentuserinfo();
if ( $userdata->ID != 1 ) {
unset( $submenu['themes.php'][5] );
unset( $submenu['themes.php'][15] );
}
}




/*
 * Dashboard customization
 */
//hook the administrative header output
// Create the function to use in the action hook

function ntischool_remove_dashboard_widgets() {
		global $wp_meta_boxes;

	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}

// Hoook into the 'wp_dashboard_setup' action to register our function

add_action('wp_dashboard_setup', 'ntischool_remove_dashboard_widgets' );


// Add all custom post types to the "Right Now" box on the Dashboard
add_action( 'dashboard_glance_items' , 'ucc_right_now_content_table_end' );

function ucc_right_now_content_table_end() {
  $post_types = get_post_types( array( 'show_in_nav_menus' => true, '_builtin' => false ), 'objects' );

  foreach ( $post_types as $post_type => $post_type_obj ){
                $num_posts = wp_count_posts( $post_type );
                if ( $num_posts && $num_posts->publish ) {
                        printf(
                                '<li class="%1$s-count"><a href="edit.php?post_type=%1$s">%2$s %3$s</a></li>',
                                $post_type,
                                number_format_i18n( $num_posts->publish ),
                                $post_type_obj->label
                        );
                }
        }

};



//Editor double line break
function change_mce_options($init){
    $init["forced_root_block"] = false;
    $init["force_br_newlines"] = true;
    $init["force_p_newlines"] = false;
    $init["convert_newlines_to_brs"] = true;
    return $init;
}
add_filter('tiny_mce_before_init','change_mce_options');


//Add analytics to head if setup in site options
function anagram_google_analytics() {
if ( class_exists( 'Acf' ) ) {
	$anagram_google_analytics_id = get_field('google_analytics', 'options');
	if (get_field('google_analytics', 'options')) {
		echo "\n\t<script>\n";
		echo "\n\t(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){\n";
		echo "\t\t(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),\n";
		echo "\t\tm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\n";
		echo "\t\t})(window,document,'script','//www.google-analytics.com/analytics.js','ga');\n";
		echo "\t\tga('create', '$anagram_google_analytics_id', '".home_url('')."');\n";
		echo "\t\tga('send', 'pageview');\n";
		echo "\t</script>\n";


	}
	}//if ACF is active
}
add_action('wp_head', 'anagram_google_analytics');






// redirect /?s to /search/
// http://txfx.net/wordpress-plugins/nice-search/
function anagram_nice_search_redirect() {
	if (is_search() && strpos($_SERVER['REQUEST_URI'], '/wp-admin/') === false && strpos($_SERVER['REQUEST_URI'], '/search/') === false) {
		wp_redirect(home_url('/search/' . str_replace(array(' ', '%20'), array('+', '+'), urlencode(get_query_var( 's' )))), 301);
	    exit();
	}
}
add_action('template_redirect', 'anagram_nice_search_redirect');

function anagram_search_query($escaped = true) {
	$query = apply_filters('anagram_search_query', get_query_var('s'));
	if ($escaped) {
    	$query = esc_attr($query);
	}
 	return urldecode($query);
}
add_filter('get_search_query', 'anagram_search_query');




// Custom Login Logo //
function anagram_custom_login_logo() {
    echo '<style type="text/css">
	.login h1 a{
background:url("'.get_bloginfo('template_directory').'/img/anagram/admin-login-logo.png") no-repeat scroll center top transparent !important;
outline:none;
width:320px;
height: 60px;
}
    </style>'."\n";
}
add_action('login_head', 'anagram_custom_login_logo');




 //Below is for login page
 // add a favicon for your login
function login_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('template_directory').'/img/anagram/favicon.ico" />';
}
add_action('login_head', 'login_favicon');



/*
 * Dashboard customization
 */
//hook the administrative header output

function anagram_custom_logo() {
   echo '<style type="text/css">
      #wp-admin-bar-wp-logo {display:none!important;}
      </style>';
}
add_action('admin_head', 'anagram_custom_logo');
//custom Admin footer
function anagram_footer_admin () {
  echo 'Powered by <a href="http://anagr.am">Anagram</a> built on <a href="http://WordPress.org">WordPress</a>.';
}
add_filter('admin_footer_text', 'anagram_footer_admin');

// add a favicon for your admin

function admin_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('template_directory').'/img/anagram/favicon.ico" />';
}
add_action('admin_head', 'admin_favicon');



/* Clean up header  */

remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'start_post_rel_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'adjacent_posts_rel_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

