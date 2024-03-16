<?php 
/*
 	============= Gad Lab Meteo =============
	This file initializes all core components
*/
// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if

// Define Our Constants
define('GLM_CORE_INC',dirname( __FILE__ ).'/assets/inc/');
define('GLM_CORE_ADMIN',dirname( __FILE__ ).'/assets/admin/');
define('GLM_CORE_IMG',plugins_url( 'assets/img/', __FILE__ ));
define('GLM_CORE_CSS',plugins_url( 'assets/css/', __FILE__ ));
define('GLM_CORE_JS',plugins_url( 'assets/js/', __FILE__ ));
define('GLM_CORE_LANG',dirname( __FILE__ ).'/languages/');

/*  -----------------
    Register CSS file
    -----------------
*/
function glm_register_core_css(){
wp_enqueue_style('glm-core', GLM_CORE_CSS . 'glm-core.css',null,time(),'all');
};
add_action( 'wp_enqueue_scripts', 'glm_register_core_css' );  

/*  ------------------------
    Register JS/Jquery Ready
    ------------------------
*/
function glm_register_core_js(){
// Register Core Plugin JS	
wp_enqueue_script('glm-core', GLM_CORE_JS . 'glm-core.js','jquery',time(),true);
};
add_action( 'wp_enqueue_scripts', 'glm_register_core_js' ); 

/*  ----------------------------
    Includes all necessary files
    ----------------------------
*/ 
// Load the Functions
if ( file_exists( GLM_CORE_INC . 'glm-core-functions.php' ) ) {
	require_once GLM_CORE_INC . 'glm-core-functions.php';
}     
// Load the ajax Request
if ( file_exists( GLM_CORE_INC . 'glm-ajax-request.php' ) ) {
	require_once GLM_CORE_INC . 'glm-ajax-request.php';
} 
// Load the Shortcodes
if ( file_exists( GLM_CORE_INC . 'glm-shortcodes.php' ) ) {
	require_once GLM_CORE_INC . 'glm-shortcodes.php';
}
// Load the Admin page
if ( file_exists( GLM_CORE_ADMIN . 'glm-admin.php' ) ) {
	require_once GLM_CORE_ADMIN . 'glm-admin.php';
}

/*  ---------------------------------------
    Load plugin textdomain for localization
    ---------------------------------------
*/

function glm_load_textdomain() {
    load_plugin_textdomain( 'glm', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'glm_load_textdomain' );

