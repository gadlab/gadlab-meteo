<?php
// /wp-content/plugins/gad-lab-meteo/assets/inc/glm-admin.php
class glm_Admin_Form
{
    const ID = 'glm-admin-forms';
    public function init()
    {
        add_action('admin_menu', array($this, 'add_menu_page'), 20);
    }
    public function get_id()
    {
        return self::ID;
    }
    public function add_menu_page()
    {
        add_menu_page(
            esc_html__('Gad Lab Meteo', 'glm-admin'),
            esc_html__('Gad Lab Meteo', 'glm-admin'),
            'manage_options',
            $this->get_id(),
            array(&$this, 'load_view'),
            'dashicons-admin-page'
        );
        /*add_submenu_page(
            $this->get_id(),
            esc_html__('Submenu', 'glm-admin'),
            esc_html__('Submenu', 'glm-admin'),
            'manage_options',
            $this->get_id() . '_view1',
            array(&$this, 'load_view')
        );*/
    }
}