<?php 
/*
* 	=============== Gad Lab Meteo ===============
*	Shortcodes
*/

// If this file is called directly, abort. //
if ( ! defined( 'WPINC' ) ) {die;} // end if

/*  ----------------------------------------
    Display plugin content with shortcodes :
    ----------------------------------------
    [meteo type="today"]
    [meteo type="forecast"]
    [meteo type="hours"]
*/

function meteo_decode($atts) {
    // Get json meteo data file from prevision-meteo.ch
	// GUIDELINE : https://www.prevision-meteo.ch/uploads/pdf/recuperation-donnees-meteo.pdf
    $response = wp_remote_get('https://prevision-meteo.ch/services/json/le-marchairuz');
    if (is_wp_error($response)) {
        return 'La récupération des données météo a échoué. Essayez de recharger la page.';
    }
	// Decode json data received
    $json = json_decode(wp_remote_retrieve_body($response), true);
    if (null === $json) {
        return 'Erreur de décodage des données météo: le format attendu est "json".';
    }

    // Retrieves display type from shortcode attributes
    $atts = shortcode_atts(array('type' => 'today'), $atts, 'meteo');
    $meteo_type = $atts['type'];

    // Select the view to be displayed by type
    switch ($meteo_type) {
        case 'today':
            return meteo_view_today($json);
        case 'forecast':
            return meteo_view_forecast($json);
        case 'hours':
            return meteo_view_hours($json);
        default:
            return 'Ce type de vue météo n’est pas pris en charge.';
    }
}

// Output current weather information
function meteo_view_today($json) {
    return '<div class="meteo_today">'
        . '<a href="/informations/previsions-meteo/" title="Consulter les prévisions détaillées..."><p>'
        . $json['current_condition']['tmp'] . '° <img src="' 
        . $json['current_condition']['icon'] . '" alt="icon"></p><p><strong>'
        . $json['current_condition']['condition'] . '</strong></p><p>Vent : '
        . $json['current_condition']['wnd_dir'] . ' à ' 
        . $json['current_condition']['wnd_spd'] . ' km/h<br/>'
        . '<i class="fas fa-sun"></i> <i class="fas fa-arrow-up"></i> ' 
        . $json['city_info']['sunrise']
        . ' <i class="fas fa-arrow-down"></i> ' 
        . $json['city_info']['sunset'] . '<br/>'
        . '&nbsp;<i class="fas fa-tint"></i>&nbsp; Humidité : ' 
        . $json['current_condition']['humidity'] . '%'
        . '</p></a></div><!--/meteo_today-->';
}

// Output 4-days weather forecasts
function meteo_view_forecast($json) {
    $html = '<table class="meteo_forecast">'
          . '<tbody>';
    for ($i = 0; $i < 4; $i++) {
        $dayForecast = $json['fcst_day_' . $i];
        $html .= '<tr><td><strong>' 
            . $dayForecast['day_short'] . '&nbsp;' 
            . $dayForecast['date'] . '</strong><br/><img src="' 
            . $dayForecast['icon_big'] . '" alt="icon"><br/><span class="tmin">' 
            . $dayForecast['tmin'] . '°</span> / <span class="tmax">' 
            . $dayForecast['tmax'] . '°</span><br/>'
            . $dayForecast['condition']
            . '</td>';
    }
    $html .= '</tr></tbody></table><!--/meteo_forecast-->';
    return $html;
}

// Output today 24 hours weather forecast
function meteo_view_hours($json) {
    $hoursHtml = '<table class="meteo_hours">'
        .'<caption>Prévision horaire du '
		.$json['fcst_day_0']['day_short'].'&nbsp;'
		.$json['fcst_day_0']['date'].'</caption>'
        . '<thead>'
        . '<tr>';
	// Build table header with rows
    foreach ($json['fcst_day_0']['hourly_data'] as $hour => $data) {
        $formattedHour = substr($hour, 0, -3) . ':00'; // Format string from "3H00" to "03:00"
        $hoursHtml .= '<th>' . $formattedHour . '</th>';
    }
    $hoursHtml .= '</tr>'
        . '</thead>'
        . '<tbody>'
        . '<tr>';
	// Build table data cells inside a row
    $colPos = 0;
    foreach ($json['fcst_day_0']['hourly_data'] as $data) {
        $hoursHtml .= '<td class="col-position-'. $colPos++ .'"><img src="'
            . $data['ICON'] . '" alt="icon"><br/>'
            . $data['TMP2m'] . '°</td>';
    }
    $hoursHtml .= '</tr>'
        . '</tbody>'
        . '</table><!--/meteo_hours-->';
    return $hoursHtml;
}

/*
Register All Shorcodes At Once
*/
add_action( 'init', 'glm_register_shortcodes');
function glm_register_shortcodes(){
    // Gad Lab Meteo Shortcodes
    add_shortcode('meteo', 'meteo_decode');
};