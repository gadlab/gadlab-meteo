<?php
/*  -----------------------
    Admin settings page
    -----------------------
*/
// Add settings page to Admin Settings Menu
function glm_meteo_add_admin_page() {
    add_options_page(
        'Gad Lab Météo · Réglages', // Page title
        'Gad Lab Météo', // Menu title
        'manage_options', // Capacity required
        'glm-meteo-settings', // Page slug
        'glm_meteo_render_admin_page' // Page rendering function
    );
}
add_action('admin_menu', 'glm_meteo_add_admin_page');

// Display the admin page content
function glm_meteo_render_admin_page() {
    ?>
    <div class="wrap">
        <h2>Gad Lab Météo · Réglages</h2>
        <form action="options.php" method="post">
            <?php
            // Display of settings sections and their fields
            settings_fields('glm_meteo_settings');
            do_settings_sections('glm-meteo-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Save settings, sections and fields
function glm_meteo_settings_init() {
    register_setting('glm_meteo_settings', 'glm_meteo_options');

    add_settings_section(
        'glm_meteo_settings_section',
        'Paramètres Généraux',
        'glm_meteo_settings_section_cb',
		'glm_theme_func',
		'glm_theme_func_settings',
		'glm_theme_func_faq',
        'glm-meteo-settings'
    );
}

add_action('admin_init', 'glm_meteo_settings_init');

function glm_meteo_settings_section_cb() {
    echo '<p>Personnalisez ici les paramètres de votre plugin météo.</p>';
}
function glm_theme_func(){
	echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div><h2>Theme</h2></div>';
}
function glm_theme_func_settings(){
	echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div><h2>Settings</h2></div>';
}
function glm_theme_func_faq(){
	echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div><h2>FAQ</h2></div>';
}

// Activating and deactivating the plugin
function glm_meteo_activate() {
    // Actions to be taken on plugin activation
}
register_activation_hook(__FILE__, 'glm_meteo_activate');

function glm_meteo_deactivate() {
    // What to do when the plugin is deactivated
}
register_deactivation_hook(__FILE__, 'glm_meteo_deactivate');
