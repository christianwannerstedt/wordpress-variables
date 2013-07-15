wordpress-variables
===================

A simple wordpress plugin to register variables and use them in your theme


### Installation

1. Clone this repository into the `/wp-content/plugins/` directory of your wordpress installation:
```git clone git://github.com/christianwannerstedt/wordpress-variables.git```
2. Activate the plugin through the 'Plugins' menu in WordPress


### Usage

Add variables in your themes functions.php file:
```php
if (class_exists('WordpressVariables') && $wpWordpressVariables){
	$wpWordpressVariables->register_variables(array(
		"color" => array(
			"name" => "Background color",
			"help" => "The background color of the sidebar"
		),
		"keywords" => array(
			"width" => "larger"
		),
		"description" => array(
			"name" => "Meta description",
			"type" => "textarea",
			"width" => "larger",
			"height" => "100px"
		)
	));
}
```


### Options
- name: The variable name that will be displayed in the administration. If not set this will default to the object key.
- key: If you wish to use a different key value for the db-option storage, you can overide it here.
- help: Will display a help text next to the field in the administration.
- width: The width of the admin field. You can use "smallest", "smaller", "small", "medium", "large", "larger", "largest" or any other value, i.e. "150px" or "50%". Defaults to "medium".
- height: Specify a custom height of the admin field, i.e. "150px".