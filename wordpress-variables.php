<?php
/**
 * @package Wordpress Variables
 * @version 1.0
 */
/*
Plugin Name: Wordpress Variables
Description: A simple wordpress plugin to register variables and use them in your theme
Author: Christian Wannerstedt @ Kloon Production AB
Version: 1.0
Author URI: http://www.kloon.se
*/

define("WORDPRESS_VARIABLES_PRE", "wordpress-variables-");

class WordpressVariables {

    protected $pluginPath;
    protected $pluginUrl;
    protected $tableName;

	public function __construct(){
        // Set Plugin Path
        $this->pluginPath = dirname(__FILE__);

        // Set Plugin URL
        $this->pluginUrl = WP_PLUGIN_URL . '/wordpress-variables';

		add_action('admin_menu', array($this, 'admin_menu'));

		$this->vars = array();
	}

	public function register_variables($arr){
		foreach ($arr as $key => $value){
			if (!$value["key"]){
				$arr[$key]["key"] = $key;
			}
			if (!$value["name"]){
				$arr[$key]["name"] = ucfirst($key);
			}
		}

		$this->vars = $arr;
	}

	public function get_variable($key){
		return get_option(WORDPRESS_VARIABLES_PRE . $key);
	}


	// ****************************** Administration ******************************
	public function admin_menu() {
		add_menu_page(__('Wordpress variables', 'wordpress-vars'), __('WP Variables', 'wordpress-vars'), 'manage_options', 'wordpress-variables', array($this, 'wordpress_variables_view'));
	}


	// ****************************** Settings view ******************************
	public function wordpress_variables_view(){
		$this->assert_admin_access();

		// Update settings
		if ($this->is_action("update")){

			foreach($this->vars as $var){
				if ($var["type"] == "checkbox"){
					$val = (isset($_POST[WORDPRESS_VARIABLES_PRE . $var["key"]]) && $_POST[WORDPRESS_VARIABLES_PRE . $var["key"]] == 1) ? 1 : 0;
					update_option(WORDPRESS_VARIABLES_PRE . $var["key"], $val);

				} else {
		    		$val = stripslashes($_POST[WORDPRESS_VARIABLES_PRE . $var["key"]]);
					update_option(WORDPRESS_VARIABLES_PRE . $var["key"], $val);
				}
			}
		}

		wp_enqueue_style('wordpress_variables_admin_style', plugins_url('css/admin.css', __FILE__));
		require_once(dirname(__FILE__) .'/admin-view.php');
	}



	// ****************************** Utils ******************************
	function assert_admin_access(){
		if (!current_user_can('manage_options')){
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
	}
	function is_action($action){
		return (isset($_POST['wordpress-var-admin-action']) && $_POST['wordpress-var-admin-action'] == $action);
	}
	function fix_text($strText){
		return trim(htmlspecialchars(strip_tags($strText, ""), ENT_QUOTES));
	}

}

global $wordpressVariables;
$wordpressVariables = new WordpressVariables();
?>