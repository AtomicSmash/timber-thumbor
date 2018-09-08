<?php
/**
 * Plugin Name:     Thumbor
 * Plugin URI:      atomicsmash.co.uk
 * Description:     Thumbor testing
 * Author:          atomicsmash.co.uk
 * Author URI:      atomicsmash.co.uk
 * Version:         0.0.1
 */

if (!defined('ABSPATH')) exit; //Exit if accessed directly

// If autoload exists... autoload it baby... (this is for plugin developemnt and sites not using composer to pull plugins)
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require __DIR__ . '/vendor/autoload.php';
}

use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;

//ASTODO There needs to be a plugin version number saved to the database when activated, this will be useful for future plugin updates

class Thumbor {

    function __construct() {

        add_filter( 'wp_handle_upload', array( $this, 'resize_upload_through_thumbor' ), 10, 2 );

    }

    public function resize_upload_through_thumbor( $image_array,$image_array2 ){

        $logger = new Logger( 'thumbor' );
        // ASTODO hash the filename by date
        $uploads_directory = wp_upload_dir();
        $logger->pushHandler(new StreamHandler( $uploads_directory['basedir'] .'/thumbor.log', Logger::DEBUG));

        // Make sure upload is an image
        if ( strpos( $image_array['type'], 'image' ) !== false ) {

            $logger->info( "Image DIR:" . $image_array['file'] );
            $logger->info( "Image URL:" . $image_array['url'] );
            $logger->info( "--------------------------------" );

        }

        return $image_array;

    }


}

$thumbor = new Thumbor;
