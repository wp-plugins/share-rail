<?php
/*
Plugin Name: Share Rail
Plugin URI: http://studio.bloafer.com/wordpress-plugins/share-rail/
Description: Use this plugin to apply floating shares to your posts and pages.
Version: 1.2
Author: Kerry James
Author URI: http://studio.bloafer.com/
*/

global $shareRail;
$shareRail = new shareRail();

class shareRail {
	var $pluginName = "Share Rail";
	var $version = "1.3";
	var $gcX = "511";
	var $gcY = "922";
	var $nonceField = "";
	var $jQueryDefaultPrefix = "jQuery";
	function shareRail(){
		$this->nonceField = md5($this->pluginName . $this->version);
		$this->editFields["settings"]["share-rail-class-attachment"] = array("default"=>"#the_content", "label"=>"Element Class attachment", "type"=>"text", "description"=>"This is where the rail attaches to");
		$this->editFields["settings"]["share-rail-jquery-use-google"] = array("default"=>false, "label"=>"Use Google's jQuery", "type"=>"check", "description"=>"If you do not have jQuery installed you can use jQuery on Google by enabling this option");
		$this->editFields["settings"]["share-rail-jquery-prefix"] = array("default"=>$this->jQueryDefaultPrefix, "label"=>"jQuery prefix", "type"=>"drop", "description"=>"The jQuery prefix used for jQuery, On some installations you may need to change it to '$'", "data"=>array("$"=>"$", "jQuery"=>"jQuery"));
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
		$this->editFields["settings"]["share-rail-pinterest-active"] = array("default"=>false, "label"=>"Show Pinterest", "type"=>"check", "description"=>"You can switch the Pinterest feed on and off here");
		$this->editFields["settings"]["share-rail-custom-content"] = array("default"=>false, "label"=>"Custom content", "type"=>"textarea", "description"=>"You can add your own custom content to the bottom of the rail by using this box");
		$this->editFields["settings"]["share-rail-custom-css"] = array("default"=>false, "label"=>"Custom CSS", "type"=>"textarea", "description"=>"You can add your own CSS here");
		$this->editFields["settings"]["share-rail-debug-active"] = array("default"=>false, "label"=>"Debug Option", "type"=>"check", "description"=>"This option will allow Bloafer developers to debug your plugin, by default this off");


		add_action('admin_init', array(&$this, 'hook_admin_init'));
		add_action('admin_menu', array(&$this, 'hook_admin_menu'));
		add_action('wp_footer', array(&$this, 'hook_wp_footer'));
		add_action('wp_head', array(&$this, 'hook_wp_head'));
		add_action('wp_enqueue_scripts', array(&$this, 'hook_wp_enqueue_scripts'));
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
			add_menu_page('Share Rail', 'Share Rail', 7, 'share-rail/incs/settings.php', '', plugins_url('share-rail/img/share.png'));
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
			include "incs/footer.php";
			$footerContent = ob_get_contents();
			ob_end_clean();
			print $footerContent;
		}
	}
	function hook_admin_init(){
		wp_enqueue_script( 'jquery' );
		$this->loadScript("facebook_api_core");
		$this->loadScript("twitter_api_core");
		$this->loadScript("linkedin_api_core");
		$this->loadScript("google_plusone_api_core");
	}
	function loadScript($library=false){
		if($library=="facebook_api_core"){
			wp_deregister_script( 'facebook_api_core' );
			wp_register_script( 'facebook_api_core', 'http://connect.facebook.net/en_US/all.js#xfbml=1');
			wp_enqueue_script( 'facebook_api_core' );
		}elseif($library=="linkedin_api_core"){
			wp_deregister_script( 'linkedin_api_core' );
			wp_register_script( 'linkedin_api_core', 'http://platform.linkedin.com/in.js');
			wp_enqueue_script( 'linkedin_api_core' );
		}elseif($library=="google_plusone_api_core"){
			wp_deregister_script( 'google_plusone_api_core' );
			wp_register_script( 'google_plusone_api_core', 'https://apis.google.com/js/plusone.js');
			wp_enqueue_script( 'google_plusone_api_core' );
		}elseif($library=="stumbleupon_api_core"){
			//wp_deregister_script( 'stumbleupon_api_core' );
			//wp_register_script( 'stumbleupon_api_core', 'http://www.stumbleupon.com/hostedbadge.php?s=5&a=1&d=shareRail_suhb', NULL, NULL, true);
			//wp_enqueue_script( 'stumbleupon_api_core' );
		}elseif($library=="twitter_api_core"){
			wp_deregister_script( 'twitter_api_core' );
			wp_register_script( 'twitter_api_core', 'http://platform.twitter.com/widgets.js');
			wp_enqueue_script( 'twitter_api_core' );
		}elseif($library=="jquery"){
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js');
			wp_enqueue_script( 'jquery' );
		}
	}
	function hook_wp_enqueue_scripts() {
		$googleActive = get_option("share-rail-google-active", $shareRail->editFields["settings"]["share-rail-google-active"]["default"]);
		$twitterActive = get_option("share-rail-twitter-active", $shareRail->editFields["settings"]["share-rail-twitter-active"]["default"]);
		$stumbleActive = get_option("share-rail-stumble-active", $shareRail->editFields["settings"]["share-rail-stumble-active"]["default"]);
		$facebookActive = get_option("share-rail-facebook-active", $shareRail->editFields["settings"]["share-rail-facebook-active"]["default"]);
		$linkedinActive = get_option("share-rail-linkedin-active", $shareRail->editFields["settings"]["share-rail-linkedin-active"]["default"]);
		$googleLoad = get_option("share-rail-google-load", $shareRail->editFields["settings"]["share-rail-google-load"]["default"]);

		$googlejQueryActive = get_option("share-rail-jquery-use-google", $shareRail->editFields["settings"]["share-rail-jquery-use-google"]["default"]);

		$twitterUsername = get_option("share-rail-twitter-username", $shareRail->editFields["settings"]["share-rail-twitter-username"]["default"]);
		$twitterActive = get_option("share-rail-twitter-active", $shareRail->editFields["settings"]["share-rail-twitter-active"]["default"]);

		wp_enqueue_script( 'jquery' );
		if($googlejQueryActive){ $this->loadScript("jquery"); }
		if($facebookActive){ $this->loadScript("facebook_api_core"); }
		if($linkedinActive){ $this->loadScript("linkedin_api_core"); }
		if($googleActive && $googleLoad){ $this->loadScript("google_plusone_api_core"); }
		if($stumbleActive){ $this->loadScript("stumbleupon_api_core"); }
		if(trim($twitterUsername)!="" && $twitterActive){ $this->loadScript("twitter_api_core"); }
	}    
}

 
?>