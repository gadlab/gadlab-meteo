<?php
/**
  * @package gadlab-meteo
  * @version 1.0
  */
/*
Plugin Name: Gad Lab Meteo
Plugin URI: https://github.com/gadlab/gadlab-meteo
Description: Permet d'afficher les prévisions météo locale du col du Marchairuz avec un shortcode
Author: Gad Lab // web.sites.builder
Version: 1.0
Author URI: http://gadlab.net/
*/

function meteo_decode( $atts ) {

	/*	PRÉVISION MÉTÉO
		---------------------------------
		GUIDE DE RÉCUPÉRATION DES DONNÉES
		---------------------------------
		https://www.prevision-meteo.ch/uploads/pdf/recuperation-donnees-meteo.pdf
	*/

    // Set up default parameters
    extract(shortcode_atts(array(
     'type' => 'today'
    ), $atts));

	// Get json meteo data file and decode it
	$json = file_get_contents('https://prevision-meteo.ch/services/json/le-marchairuz');
	$json = json_decode($json);

	// Get the kind of meteo type to display
	$meteo_type = $atts['type'] ;

	// Set Output Code based on attribute's shortcode
  if ($meteo_type == 'meteo_today'){
    // Display today basic widget
    return '<a href="/informations/meteo/" title="Consulter les prévisions détaillées...">'
		.'<div id="meteo_today"><p style="color:#ffffff;font-size:2.5em;line-height:1.3em;padding:0;text-align:center;">'
		.$json->current_condition->tmp.'° <img src="'
		.$json->current_condition->icon.'" alt="icon"></p><p style="color:#ffffff;text-align:center;"><b>'
		.$json->current_condition->condition.'</b><br/>Vent : <b>'
		.$json->current_condition->wnd_dir.'</b> à <b>'
		.$json->current_condition->wnd_spd.' km/h</b><br/><i class="fas fa-sun" style="color:#fee034;"></i> <i class="fas fa-arrow-up"></i> '
		.$json->city_info->sunrise.' <i class="fas fa-arrow-down"></i> '
		.$json->city_info->sunset.'<br/>&nbsp;<i class="fas fa-tint" style="color:#00c3ff;"></i>&nbsp; Humidité : <b>'
		.$json->current_condition->humidity.'%</b></p></div></a><!-- /#widget_meteo -->';
	} else if ( $meteo_type == 'meteo_forecast' ){
    // Display 4 days forecast widget
		return '<table style="width:100%;color:white;border:0 none;border-collapse:collapse;text-align:center;"><tbody><tr><td id="col1" style="border-top:0 none; padding-top:0!important; padding-bottom:0!important; text-align:center;"><strong>'
		.$json->fcst_day_0->day_short.'&nbsp;'
		.$json->fcst_day_0->date.'</strong><br/><img src="'
		.$json->fcst_day_0->icon_big.'" alt="icon" style="width:100%;"><br/><span style="color:#00c3ff;font-weight:bold;">'
		.$json->fcst_day_0->tmin.'&deg;</span> / <span style="color:#fe8934;font-weight:bold;">'
		.$json->fcst_day_0->tmax.'&deg;</span><br/>'
		.$json->fcst_day_0->condition.'</td><!--/#col1--><td id="col2" style="border-top:0 none; padding-top:0!important; padding-bottom:0!important; text-align:center;"><strong>'
		.$json->fcst_day_1->day_short.'&nbsp;'
		.$json->fcst_day_1->date.'</strong><br/><img src="'
		.$json->fcst_day_1->icon_big.'" alt="icon" style="width:100%;"><br/><span style="color:#00c3ff;font-weight:bold;">'
		.$json->fcst_day_1->tmin.'&deg;</span> / <span style="color:#fe8934;font-weight:bold;">'
		.$json->fcst_day_1->tmax.'&deg;</span><br/>'
		.$json->fcst_day_1->condition.'</td><!--/#col2--><td id="col3" style="border-top:0 none; padding-top:0!important; padding-bottom:0!important; text-align:center;"><strong>'
		.$json->fcst_day_2->day_short.'&nbsp;'
		.$json->fcst_day_2->date.'</strong><br/><img src="'
		.$json->fcst_day_2->icon_big.'" alt="icon" style="width:100%;"><br/><span style="color:#00c3ff;font-weight:bold;">'
		.$json->fcst_day_2->tmin.'&deg;</span> / <span style="color:#fe8934;font-weight:bold;">'
		.$json->fcst_day_2->tmax.'&deg;</span><br/>'
		.$json->fcst_day_2->condition.'</td><!--/#col3--><td id="col4" style="border-top:0 none; padding-top:0!important; padding-bottom:0!important; text-align:center;"><strong>'
		.$json->fcst_day_3->day_short.'&nbsp;'
		.$json->fcst_day_3->date.'</strong><br/><img src="'
		.$json->fcst_day_3->icon_big.'" alt="icon" style="width:100%;"><br/><span style="color:#00c3ff;font-weight:bold;">'
		.$json->fcst_day_3->tmin.'&deg;</span> / <span style="color:#fe8934;font-weight:bold;">'
		.$json->fcst_day_3->tmax.'&deg;</span><br/>'
		.$json->fcst_day_3->condition.'</td><!--/#col4--></tr></tbody></table>';
	} else if ( $meteo_type == 'meteo_hours' ){
    //Display hourly forecast
		return '<style>table.meteo_marchairuz { width: 100%; background-color: rgb(0 0 0 / 25%); border-collapse: collapse; border: 0 none !important; color: #ffffff; } table.meteo_marchairuz td, table.meteo_marchairuz th { border: 1px solid #000000; color: white; font-weight: 400; padding: 5px 0; text-align: center; vertical-align:top; } table.meteo_marchairuz caption {font-weight: bold;}</style>'
		.'<table class="meteo_marchairuz"><thead><caption>Prévisions horaires du jour ( '
		.$json->fcst_day_0->day_short.'&nbsp;'
		.$json->fcst_day_0->date.' )</caption><tr><!--hours--><th>01:00</th><th>03:00</th><th>05:00</th><th>07:00</th><th>09:00</th><th>11:00</th><th>13:00</th><th>15:00</th><th>17:00</th><th>19:00</th><th>21:00</th><th>23:00</th></tr><!--/hours--></thead><tbody><tr><!--icons--><td style="padding-top:72px;"><img src="'
		.$json->fcst_day_0->hourly_data->{'0H00'}->ICON.'" alt="1h00"><br/><b>'
		.$json->fcst_day_0->hourly_data->{'0H00'}->TMP2m.'&nbsp;&deg;</b></td><td style="padding-top:60px;"><img src="'
		.$json->fcst_day_0->hourly_data->{'3H00'}->ICON.'" alt="3h00"><br/><b>'
		.$json->fcst_day_0->hourly_data->{'3H00'}->TMP2m.'&nbsp;&deg;</b></td><td style="padding-top:48px;"><img src="'
		.$json->fcst_day_0->hourly_data->{'5H00'}->ICON.'" alt="5h00"><br/><b>'
		.$json->fcst_day_0->hourly_data->{'5H00'}->TMP2m.'&nbsp;&deg;</b></td><td style="padding-top:36px;"><img src="'
		.$json->fcst_day_0->hourly_data->{'7H00'}->ICON.'" alt="7h00"><br/><b>'
		.$json->fcst_day_0->hourly_data->{'7H00'}->TMP2m.'&nbsp;&deg;</b></td><td style="padding-top:24px;"><img src="'
		.$json->fcst_day_0->hourly_data->{'9H00'}->ICON.'" alt="9h00"><br/><b>'
		.$json->fcst_day_0->hourly_data->{'9H00'}->TMP2m.'&nbsp;&deg;</b></td><td style="padding-top:12px;"><img src="'
		.$json->fcst_day_0->hourly_data->{'11H00'}->ICON.'" alt="1100"><br/><b>'
		.$json->fcst_day_0->hourly_data->{'11H00'}->TMP2m.'&nbsp;&deg;</b></td><td style="padding-top:0px;"><img src="'
		.$json->fcst_day_0->hourly_data->{'13H00'}->ICON.'" alt="13h00"><br/><b>'
		.$json->fcst_day_0->hourly_data->{'13H00'}->TMP2m.'&nbsp;&deg;</b></td><td style="padding-top:12px;"><img src="'
		.$json->fcst_day_0->hourly_data->{'15H00'}->ICON.'" alt="15h00"><br/><b>'
		.$json->fcst_day_0->hourly_data->{'15H00'}->TMP2m.'&nbsp;&deg;</b></td><td style="padding-top:24px;"><img src="'
		.$json->fcst_day_0->hourly_data->{'17H00'}->ICON.'" alt="17h00"><br/><b>'
		.$json->fcst_day_0->hourly_data->{'17H00'}->TMP2m.'&nbsp;&deg;</b></td><td style="padding-top:36px;"><img src="'
		.$json->fcst_day_0->hourly_data->{'19H00'}->ICON.'" alt="19h00"><br/><b>'
		.$json->fcst_day_0->hourly_data->{'19H00'}->TMP2m.'&nbsp;&deg;</b></td><td style="padding-top:48px;"><img src="'
		.$json->fcst_day_0->hourly_data->{'21H00'}->ICON.'" alt="21h00"><br/><b>'
		.$json->fcst_day_0->hourly_data->{'21H00'}->TMP2m.'&nbsp;&deg;</b></td><td style="padding-top:60px;"><img src="'
		.$json->fcst_day_0->hourly_data->{'23H00'}->ICON.'" alt="23h00"><br/><b>'
		.$json->fcst_day_0->hourly_data->{'23H00'}->TMP2m.'&nbsp;&deg;</b></td></tr><!--/icons--><tfoot><!--precipitation--><td style="color:#00c3ff;">'
		.$json->fcst_day_0->hourly_data->{'1H00'}->APCPsfc.'&nbsp;mm</td><td style="color:#00c3ff;">'
		.$json->fcst_day_0->hourly_data->{'3H00'}->APCPsfc.'&nbsp;mm</td><td style="color:#00c3ff;">'
		.$json->fcst_day_0->hourly_data->{'5H00'}->APCPsfc.'&nbsp;mm</td><td style="color:#00c3ff;">'
		.$json->fcst_day_0->hourly_data->{'7H00'}->APCPsfc.'&nbsp;mm</td><td style="color:#00c3ff;">'
		.$json->fcst_day_0->hourly_data->{'9H00'}->APCPsfc.'&nbsp;mm</td><td style="color:#00c3ff;">'
		.$json->fcst_day_0->hourly_data->{'11H00'}->APCPsfc.'&nbsp;mm</td><td style="color:#00c3ff;">'
		.$json->fcst_day_0->hourly_data->{'13H00'}->APCPsfc.'&nbsp;mm</td><td style="color:#00c3ff;">'
		.$json->fcst_day_0->hourly_data->{'15H00'}->APCPsfc.'&nbsp;mm</td><td style="color:#00c3ff;">'
		.$json->fcst_day_0->hourly_data->{'17H00'}->APCPsfc.'&nbsp;mm</td><td style="color:#00c3ff;">'
		.$json->fcst_day_0->hourly_data->{'19H00'}->APCPsfc.'&nbsp;mm</td><td style="color:#00c3ff;">'
		.$json->fcst_day_0->hourly_data->{'21H00'}->APCPsfc.'&nbsp;mm</td><td style="color:#00c3ff;">'
		.$json->fcst_day_0->hourly_data->{'23H00'}->APCPsfc.'&nbsp;mm</td></tfoot><!--/precipitation--></tbody></table>';
	};
}

// Declare shortcode in Wordpress
add_shortcode( 'meteo', 'meteo_decode' );
