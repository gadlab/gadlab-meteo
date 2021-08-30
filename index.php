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

/* Load plugin textdomain
----------------------------------------------------------------------------- */
function glm_load_textdomain() {
  load_plugin_textdomain( 'glm', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'glm_load_textdomain' );

/* Register and enqueue CSS file into page header
----------------------------------------------------------------------------- */
function add_glm_css() {
  wp_register_style( 'gadlab-meteo', '/wp-content/plugins/gadlab-meteo/styles/gadlab-meteo.css' );
  wp_enqueue_style( 'gadlab-meteo' );
}
add_action( 'wp_print_styles', 'add_glm_css' );

/* Create shortcode
----------------------------------------------------------------------------- */
function glm_decode( $atts ) {
  // Get the json data file to be parsed
  $data_json = file_get_contents( 'https://prevision-meteo.ch/services/json/le-marchairuz' );
  // Liste des paramètres retournés par le flux JSON:
  // https://www.prevision-meteo.ch/uploads/pdf/recuperation-donnees-meteo.pdf
  // Parse file to get Data
  $decoded = json_decode( $data_json );

  // Build the meteo elements in get_html_translation_table
  $glm_icon = '<img src="'.$decoded->current_condition->icon.'" alt="icon">';
  $glm_temp = $decoded->current_condition->tmp."°C";
  $glm_cond = $decoded->current_condition->condition;
  $glm_wind = _e( 'Wind', 'glm' ).' : <b>'.$decoded->current_condition->wnd_dir.'</b> '._e( 'at', 'glm' ).' <b>'.$decoded->current_condition->wnd_spd.' '._e( 'km/h', 'glm' ).'</b>';
  $glm_sun  = '<i class="fas fa-sun" style="color:#fee034;"></i> <i class="fas fa-arrow-up"></i> '.$decoded->city_info->sunrise.' <i class="fas fa-arrow-down"></i> '.$decoded->city_info->sunset;
  $glm_humid = '<i class="fas fa-tint" style="color:#00c3ff;"></i>&nbsp; '._e( 'Humidity', 'glm' ).' : <b>'.$decoded->current_condition->humidity.'%</b>';

  // Build the HTML widget
  $content  = '<a href="/informations/meteo/" title="'._e( 'Consult the detailed forecasts...', 'glm' ).'">';
  $content .= '<div id="meteo_today">';
  $content .= '<p class="meteo-temperature">'.$glm_temp.'&nbsp;'.$glm_icon.'</p>';
  $content .= '<p class="meteo-conditions">'.$glm_cond.'<br/>';
  $content .= $glm_wind.'<br/>';
  $content .= $glm_sun.'<br/>';
  $content .= $glm_humid.'</p>';
  $content .= '</div></a><!-- /#widget_meteo -->';

  return $content;
}
add_shortcode( 'meteo', 'glm_decode' );
