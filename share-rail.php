<?php
/*
Plugin Name: Share Rail
Plugin URI: http://studio.bloafer.com/wordpress-plugins/share-rail/
Description: Use this plugin to apply floating shares to your posts and pages.
Version: 0.9
Author: Kerry James
Author URI: http://studio.bloafer.com/
*/

global $shareRail;
$shareRail = new shareRail();

class shareRail {
	var $pluginName = "Share Rail";
	var $version = "0.9";
	var $gcX = "541";
	var $gcY = "942";
	var $nonceField = "";
	function shareRail(){
		$this->nonceField = md5($this->pluginName . $this->version);
		$this->editFields["settings"]["share-rail-class-attachment"] = array("default"=>"#the_content", "label"=>"Element Class attachment", "type"=>"text", "description"=>"This is where the rail attaches to");
		$this->editFields["settings"]["share-rail-jquery-use-google"] = array("default"=>false, "label"=>"Use Google's jQuery", "type"=>"check", "description"=>"If you do not have jQuery installed you can use jQuery on Google by enabling this option");
		$this->editFields["settings"]["share-rail-jquery-prefix"] = array("default"=>"$", "label"=>"jQuery prefix", "type"=>"drop", "description"=>"The jQuery prefix used for jQuery, On some installations you may need to change it to 'jQuery'", "data"=>array("$"=>"$", "jQuery"=>"jQuery"));
		$this->editFields["settings"]["share-rail-show-on-pages"] = array("default"=>false, "label"=>"Show on pages", "type"=>"check", "description"=>"Do you want this to show on pages?");
		$this->editFields["settings"]["share-rail-show-on-posts"] = array("default"=>false, "label"=>"Show on posts", "type"=>"check", "description"=>"Do you want this to show on posts?");
		$this->editFields["settings"]["share-rail-show-on-homepage"] = array("default"=>false, "label"=>"Show on homepage", "type"=>"check", "description"=>"Do you want this to show on the homepage?");
		$this->editFields["settings"]["share-rail-vertical-offset"] = array("default"=>"10", "label"=>"Vertical Offset", "type"=>"text", "description"=>"How many pixels from the top of the screen do you want to start moving? default is 10");
		$this->editFields["settings"]["share-rail-twitter-active"] = array("default"=>false, "label"=>"Show Twitter", "type"=>"check", "description"=>"You can switch the Twitter feed on and off here");
		$this->editFields["settings"]["share-rail-twitter-username"] = array("default"=>false, "label"=>"Twitter Username", "type"=>"text", "description"=>"The username is required to allow tweets");
		$this->editFields["settings"]["share-rail-facebook-active"] = array("default"=>false, "label"=>"Show Facebook", "type"=>"check", "description"=>"You can switch the Facebook feed on and off here");
		$this->editFields["settings"]["share-rail-google-analytics-social"] = array("default"=>false, "label"=>"Use Google Social Interaction Analytics", "type"=>"check", "description"=>"If you have Google Analytics installed you can use this to track social interactions");
		$this->editFields["settings"]["share-rail-google-active"] = array("default"=>false, "label"=>"Show Google +1", "type"=>"check", "description"=>"You can switch the Google +1 feed on and off here");
		$this->editFields["settings"]["share-rail-google-load"] = array("default"=>true, "label"=>"Load Google +1 API", "type"=>"check", "description"=>"You can switch the Google +1 API on and off here, if you already have a Google +1 plugin running untick this");
		$this->editFields["settings"]["share-rail-stumble-active"] = array("default"=>false, "label"=>"Show Stumble Upon", "type"=>"check", "description"=>"You can switch the Stumble Upon feed on and off here");
		$this->editFields["settings"]["share-rail-linkedin-active"] = array("default"=>false, "label"=>"Show LinkedIn", "type"=>"check", "description"=>"You can switch the LinkedIn feed on and off here");
		$this->editFields["settings"]["share-rail-custom-content"] = array("default"=>false, "label"=>"Custom content", "type"=>"textarea", "description"=>"You can add your own custom content to the bottom of the rail by using this box");
		$this->editFields["settings"]["share-rail-custom-css"] = array("default"=>false, "label"=>"Custom CSS", "type"=>"textarea", "description"=>"You can add your own CSS here");

		add_action('admin_menu', array(&$this, 'hook_admin_menu'));
		add_action('wp_footer', array(&$this, 'hook_wp_footer'));
		add_action('wp_head', array(&$this, 'hook_wp_head'));

	}
	function isVisible(){
		$returnVar = false;
		if(is_page()){
			if(get_option("share-rail-show-on-pages", $this->editFields["settings"]["share-rail-show-on-pages"]["default"])){
				$returnVar = true;
			}
		}
		if(is_single()){
			if(get_option("share-rail-show-on-posts", $this->editFields["settings"]["share-rail-show-on-posts"]["default"])){
				$returnVar = true;
			}
		}
		if(is_home()){
			if(get_option("share-rail-show-on-homepage", $this->editFields["settings"]["share-rail-show-on-homepage"]["default"])){
				$returnVar = true;
			}
		}
		return $returnVar;
	}
	function messageInfo($text, $type="updated"){
		return '<div id="message" class="' . $type . '"><p>' . $text . '</p></div>';
	}
	function hook_admin_menu(){
		if(current_user_can('manage_options')){
			add_menu_page('Share Rail', 'Share Rail', 7, 'share-rail/incs/settings.php', '', '');
		}
	}
	function hook_wp_head(){
		if($this->isVisible()){
			ob_start();
			include "incs/head.php";
			$head = ob_get_contents();
			ob_end_clean();
			print $head;
		}
	}
	function hook_wp_footer(){
		if($this->isVisible()){
			ob_start();
			include "incs/rail.php";
			$rail = ob_get_contents();
			ob_end_clean();
			ob_start();
			include "incs/footer.php";
			$footer = ob_get_contents();
			ob_end_clean();
			print $rail . $footer;
		}
	}
}
?>