<?php
/*  -----------------------
    Admin settings page
    -----------------------
*/
// Ajouter la page de réglages au menu Paramètres
function glm_meteo_add_admin_page() {
    add_options_page(
        'Réglages Météo', // Titre de la page
        'Météo', // Titre du menu
        'manage_options', // Capacité requise
        'glm-meteo-settings', // Slug de la page
        'glm_meteo_render_admin_page' // Fonction pour rendre la page
    );
}
add_action('admin_menu', 'glm_meteo_add_admin_page');

// Fonction pour afficher le contenu de la page d'admin
function glm_meteo_render_admin_page() {
    ?>
    <div class="wrap">
        <h2>Réglages Météo</h2>
        <form action="options.php" method="post">
            <?php
            // Affichage des sections de réglages et de leurs champs
            settings_fields('glm_meteo_settings');
            do_settings_sections('glm-meteo-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Enregistrer les réglages, sections, et champs
function glm_meteo_settings_init() {
    register_setting('glm_meteo_settings', 'glm_meteo_options');

    add_settings_section(
        'glm_meteo_settings_section',
        'Paramètres Généraux',
        'glm_meteo_settings_section_cb',
        'glm-meteo-settings'
    );

    // Ajoutez ici d'autres add_settings_field() au besoin
}

add_action('admin_init', 'glm_meteo_settings_init');

function glm_meteo_settings_section_cb() {
    echo '<p>Personnalisez ici les paramètres de votre plugin météo.</p>';
}

// Activation et désactivation du plugin
function glm_meteo_activate() {
    // Actions à réaliser à l'activation du plugin
}
register_activation_hook(__FILE__, 'glm_meteo_activate');

function glm_meteo_deactivate() {
    // Actions à réaliser à la désactivation du plugin
}
register_deactivation_hook(__FILE__, 'glm_meteo_deactivate');
