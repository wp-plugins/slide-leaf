<?php
/*
Plugin Name: Leaf slide
Description: A slider with the effect of the book
Version: 1.0
Author: DevUp
Author URI: http://devup.com.ua
*/

	define("SLIDE_DIR", plugin_dir_path(__FILE__));
	define("SLIDE_URL", plugin_dir_url(__FILE__));

	add_action('media_buttons', 'slide_leaf', 15);
	add_action("wp_footer", 'include_scripts_page_filles');
	add_action("wp_enqueue_media", 'include_media_admin_filles');

	function slide_leaf($editor_id) { 

		echo'<a href="#" class="button custom-media" data-toggle="modal" data-target=".slide-leaf" id="slide_leaf_container" >'.
		'<span class="dashicons dashicons-images-alt2"></span>'.
		'Add Leaf slide'.
		'</a>';

		require(SLIDE_DIR . 'includes/admin.php');
	}

	function include_scripts_page_filles() {
		wp_enqueue_script('angular', SLIDE_URL . 'asset/js/angular.min.js', array(), null, false);
		wp_enqueue_script('angular-leaf', SLIDE_URL	 . 'asset/js/angular-leaf.js?123', array('angular'), null, false);
		wp_enqueue_script('slide-leaf.js', SLIDE_URL . 'asset/js/slide-leaf.js', array('angular-leaf'), null, false);

		wp_enqueue_style('angular-leaf.css', SLIDE_URL . 'asset/css/angular-leaf.css');
	}

	function include_media_admin_filles() {
		wp_enqueue_script('angular', SLIDE_URL . 'asset/js/bootstrap.min.js', array('jquery'));
		wp_enqueue_script('script', SLIDE_URL . 'asset/js/script.js', array('jquery'));

		wp_enqueue_style('bootstrap.css', SLIDE_URL . 'asset/css/bootstrap.css');
		wp_enqueue_style('admin.css', SLIDE_URL . 'asset/css/admin.css');

	}

	add_shortcode("slideLeaf", function ($atts, $content="") {
		$type = $atts['type'];
		$header = $atts['header'];
		$speed = $atts['speed'];
		$width = $atts['width'];
		$height = $atts['height'];
		$color = $atts['color'];


		$content = explode(" , ", $content);

		$images = "";

		foreach ($content as $key => $value) {
			
			$images .= "<leaf>";
			$images .= "<img src='" .  trim($value) . "' >";
			$images .= "</leaf>";
		}
		

		$book = "<div ng-app='app' >".
				"<book slide-type='{$type}' >".
					"<topic ng-color='{$color}' >".
						"<h3>$header</h3>".
					"</topic>".
					"<content ng-width='{$width}' ng-height='{$height}' ng-speed='{$speed}' >".
						$images . 
					"</content>".
					"<control  ng-color='{$color}' >".
						"<span thumb='left' ></span>".
						"<span thumb='right' ></span>".
					"</control>".
				"</book>".
			"</div>";
			
		return $book;
		
	});
?>
