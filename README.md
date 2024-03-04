# gadlab-meteo
**WP Plugin** : Hourly and daily weather forecasts for a given place in Switzerland.

### Settings
Get json meteo data file from https://prevision-meteo.ch/service/

1. Enter the name or ZIP code of the location for which you wish to display the weather forecast and hit [ENTER] key. If necessary, select your location within the dropdown menu that appears below, to indicate precisely the exact position.
2. Go to third sections’s page called « JSON » and clic in the field filled with the URL of json’s data. Select and copy the link.
3. Go to wordpress menu «[Settings > Gad Lab Meteo](/wp-admin/options-general.php?page=gadlab-meteo)»
4. Paste the link in the field named «json file’s url» under «URL’s settings» section


### Usage
Add following shortcodes to your posts: 

- [meteo type="today"] · Display today weather (short version)
- [meteo type="hours"] · Display today weather informations in 24 hours format
- [meteo type="forecast"] · Display weather forecast for today and the next three days
