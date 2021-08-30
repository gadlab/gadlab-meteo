<?php
/**
*  @package gadlab-meteo
*  @version 2.0
*/

/*
Plugin Name: Gad Lab Meteo
Plugin URI: https://github.com/gadlab/gadlab-meteo
Description: Display local weather forecast of «The Marchairuz Pass».
Author: Gad Lab
Author URI: http://gadlab.net/
Version: 2.0
License: GPLv3 or later
Text Domain: glm
Domain Path: /languages
*/

if ( !defined( 'ABSPATH' ) ) die( 'No direct access allowed' );

/* LOAD PLUGIN TEXTDOMAIN
----------------------------------------------------------------------------- */
function glm_load_textdomain() {
  load_plugin_textdomain( 'glm', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'glm_load_textdomain' );

/* REGISTER AND ENQUEUE CSS FILE INTO PAGE HEADER
----------------------------------------------------------------------------- */
function add_glm_css() {
  wp_register_style( 'gadlab-meteo', '/wp-content/plugins/gadlab-meteo/styles/gadlab-meteo.css' );
  wp_enqueue_style( 'gadlab-meteo' );
}
add_action( 'wp_print_styles', 'add_glm_css' );

/* CREATE SHORTCODE
----------------------------------------------------------------------------- */
function glm_decode( $atts ) {
  // GET THE JSON DATA FILE TO BE PARSED
  $data_json = file_get_contents( 'https://prevision-meteo.ch/services/json/le-marchairuz' );
  // LISTE DES PARAMÈTRES RETOURNÉS PAR LE FLUX JSON:
  // https://www.prevision-meteo.ch/uploads/pdf/recuperation-donnees-meteo.pdf

  // PARSE FILE TO GET DATA
  $decoded = json_decode( $data_json );

  // BUILD THE METEO ELEMENTS IN GET_HTML_TRANSLATION_TABLE
  $glm_icon = '<img src="'.$decoded->current_condition->icon.'" alt="icon">';
  $glm_temp = $decoded->current_condition->tmp."°C";
  $glm_cond = $decoded->current_condition->condition;
  $glm_wind = _e( 'Wind', 'glm' ).' : <b>'.$decoded->current_condition->wnd_dir.'</b> '._e( 'at', 'glm' ).' <b>'.$decoded->current_condition->wnd_spd.' '._e( 'km/h', 'glm' ).'</b>';
  $glm_sun  = '<i class="fas fa-sun" style="color:#fee034;"></i> <i class="fas fa-arrow-up"></i> '.$decoded->city_info->sunrise.' <i class="fas fa-arrow-down"></i> '.$decoded->city_info->sunset;
  $glm_humid = '<i class="fas fa-tint" style="color:#00c3ff;"></i>&nbsp; '._e( 'Humidity', 'glm' ).' : <b>'.$decoded->current_condition->humidity.'%</b>';

  // SET UP DEFAULT PARAMETERS
  extract( shortcode_atts( array( 'type' => 'glm_today' ), $atts ) );
  // GET THE KIND OF METEO TYPE TO DISPLAY
	$glm_type = $atts['type'];

  // BUILD THE HTML WIDGET BASED ON $ATTS
  if ($glm_type == 'glm_today'){
    $out_today  = '<a href="/informations/meteo/" title="'._e( 'Consult the detailed forecasts...', 'glm' ).'">';
    $out_today .= '<div id="meteo_today">';
    $out_today .= '<p class="meteo-temperature">'.$glm_temp.'&nbsp;'.$glm_icon.'</p>';
    $out_today .= '<p class="meteo-conditions">'.$glm_cond.'<br/>';
    $out_today .= $glm_wind.'<br/>';
    $out_today .= $glm_sun.'<br/>';
    $out_today .= $glm_humid.'</p>';
    $out_today .= '</div></a><!-- /#widget_meteo -->';

    return $out_today;
  }
  else if ( $glm_type == 'glm_forecasts' ){

    $out_forecasts = '<p>GLM Forecasts</p>';

    return $out_forecasts;
  }
  else if ( $glm_type == 'glm_hourly' ){
    $out_hourly = '<p>GLM Hourly</p>';

    return $out_hourly;
  }
}
add_shortcode( 'meteo', 'glm_decode' );
