<?php
/*  -----------------------
    Add admin settings page
    -----------------------
*/
function glm_menu_page() {
    add_menu_page(
        __( 'GLM Setting Page', 'glm' ),
        __( 'GLM Setting Page', 'glm' ),
        'manage_options',
        'glm_setting_page',
        'glm_setting_page',
        '',
        6
    );
}
add_action('admin_menu', 'glm_menu_page');
    
function glm_setting_page() {
?>
<h2><?php _e('My Plugin Title', 'glm'); ?></h2>
<?php
}