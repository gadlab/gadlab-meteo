<?php 
/*
Plugin Name: Gad Lab Meteo
Plugin URI: https://gadlab.net/docs
Description: Hourly and daily weather forecasts for a given place in Switzerland. Usage: add following shortcodes to your posts: [meteo type="meteo_today"] [meteo type="meteo_hours"] [meteo type="meteo_forecast"]
Version: 2.3
Author: Gad Lab
Author URI: https://gadlab.net
Text Domain: glm
*/

// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if

// Let's Initialize Everything
if ( file_exists( plugin_dir_path( __FILE__ ) . 'core-init.php' ) ) {
require_once( plugin_dir_path( __FILE__ ) . 'core-init.php' );
}