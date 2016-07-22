<?php

/**
 * Admin Custom functions for Theme
 */




//http://codex.wordpress.org/Function_Reference/get_allowed_mime_types
function anagram_allowed_myme_types($mime_types){
    //Creating a new array will reset the allowed filetypes
    $mime_types = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif' => 'image/gif',
        'png' => 'image/png',
        'pdf' => 'application/pdf',
        'mp3|m4a|m4b' => 'audio/mpeg',
        'zip' => 'application/zip',
		'gz|gzip' => 'application/x-gzip',
		'rar' => 'application/rar',
        //'bmp' => 'image/bmp',
        //'tif|tiff' => 'image/tiff'
    );
    return $mime_types;
}
add_filter('upload_mimes', 'anagram_allowed_myme_types', 1, 1);

function anagram_remove_myme_types($mime_types){
    $mime_types['avi'] = 'video/avi'; //Adding avi extension
    unset($mime_types['pdf']); //Removing the pdf extension
    return $mime_types;
}
//add_filter('upload_mimes', 'anagram_remove_myme_types', 1, 1);


add_action( 'admin_init', 'anagram_block_users_from_uploading_small_images' );

function anagram_block_users_from_uploading_small_images()
{
    //if( !current_user_can( 'administrator') )
        add_filter( 'wp_handle_upload_prefilter', 'anagram_block_small_images_upload' );
}


/**
 * anagram_block_small_images_upload function.
 *
 * @access public
 * @param mixed $file
 * @return void
 */
function anagram_block_small_images_upload( $file )
{
    // Mime type with dimensions, check to exit earlier
    $mimes = array( 'image/jpeg', 'image/png', 'image/gif' );

    if( !in_array( $file['type'], $mimes ) )
        return $file;

    $img = getimagesize( $file['tmp_name'] );
    $minimum = array( 'width' => 1200 );
    //$minimum = array( 'width' => 1200, 'height' => 480 );

    if ( $img[0] < $minimum['width'] )
        $file['error'] =
            'Image too small. Minimum width is '
            . $minimum['width']
            . 'px. Uploaded image width is '
            . $img[0] . 'px';

/*
    elseif ( $img[1] < $minimum['height'] )
        $file['error'] =
            'Image too small. Minimum height is '
            . $minimum['height']
            . 'px. Uploaded image height is '
            . $img[1] . 'px';
*/

    return $file;
}





//Sort post types
function custom_sort_pre_get_posts( $query ) {



    if ( isset( $query->query_vars[ 'post_type' ] ) && ($query->query_vars[ 'post_type' ] == 'event' ) && !isset($_GET['orderby']) ) {
        $query->set( 'orderby', 'meta_value' );
        $query->set( 'order', 'DESC' );
         $query->set( 'meta_key', 'start_date' );
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
//add_filter('pre_get_posts' , 'custom_sort_pre_get_posts');

