<?php
global $title;
add_meta_box("wordpress_var_content", $title, "wordpress_var_meta_box", "wordpress_var_content", "normal", "core");
?>

<div class="wrap">

	<div id="wordpress-var-container" class="metabox-holder">
		<?php do_meta_boxes('wordpress_var_content','normal', null); ?>
	</div>

</div>


<?php
function wordpress_var_meta_box($post, $metabox){
	global $wordpressVariables;
	?>

	<form name="wordpress-variables-settings-form" action="<?php echo admin_url('admin.php') .'?page=wordpress-variables'; ?>" method="post">
		<input type="hidden" name="wordpress-var-admin-action" value="update" />

		<div class="wordpress-variable-container">
			<ul>
				<?php
				foreach($wordpressVariables->vars as $var){ ?>
					<li>
						<label><?php echo $var["name"]; ?></label>

						<?php
						$name = "wordpress-variables-". $var["key"];
						$value = $wordpressVariables->get_variable($var["key"]);
						$css = '';
		    			$width = 0;

		    			switch ($var["width"]){
		    				case "smallest": $width = "50px"; break;
		    				case "smaller": $width = "100px"; break;
		    				case "small": $width = "200px"; break;
		    				case "medium": $width = "300px"; break;
		    				case "large": $width = "400px"; break;
		    				case "larger": $width = "500px"; break;
		    				case "largest": $width = "600px"; break;
		    				default: $width = "300px";
		    			}
		    			$css .= "width: ". $width .';';
			    		if ($var["height"]) $css .= 'height: '. $var["height"] .';';
			    		$style = ($css) ? ' style="'. $css . '"' : '';

			    		if ($var["type"] == "textarea"){ ?>
			    			<textarea name="<?php echo $name; ?>"<?php echo $style; ?>><?php echo $value; ?></textarea>
			    		<?php } else { ?>
				    		<input name="<?php echo $name; ?>" type="text" value="<?php echo $value; ?>"<?php echo $style; ?>>
			    		<?php }


			    		if ($var["help"]){ ?>
			    			<span><?php echo $var["help"]; ?></span>
			    		<?php } ?>



					</li>
				<?php } ?>
			</ul>
		</div>

		<button id="save-variables" class="button-primary">Update changes</button>
	</form>

	<?php
} ?>