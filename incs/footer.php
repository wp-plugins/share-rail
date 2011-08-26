<?php
global $shareRail;

$currentURL = "http" . (($_SERVER["SERVER_PORT"]==443)?"s":"") . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

$jQueryAttachment = get_option("share-rail-class-attachment", $shareRail->editFields["settings"]["share-rail-class-attachment"]["default"]);

$googleActive = get_option("share-rail-google-active", $shareRail->editFields["settings"]["share-rail-google-active"]["default"]);
$twitterActive = get_option("share-rail-twitter-active", $shareRail->editFields["settings"]["share-rail-twitter-active"]["default"]);
$stumbleActive = get_option("share-rail-stumble-active", $shareRail->editFields["settings"]["share-rail-stumble-active"]["default"]);
$facebookActive = get_option("share-rail-facebook-active", $shareRail->editFields["settings"]["share-rail-facebook-active"]["default"]);
$linkedinActive = get_option("share-rail-linkedin-active", $shareRail->editFields["settings"]["share-rail-linkedin-active"]["default"]);

$googleSocialActive = get_option("share-rail-google-analytics-social", $shareRail->editFields["settings"]["share-rail-google-analytics-social"]["default"]);



$googleLoad = get_option("share-rail-google-load", $shareRail->editFields["settings"]["share-rail-google-load"]["default"]);

$verticalOffset = get_option("share-rail-vertical-offset", $shareRail->editFields["settings"]["share-rail-vertical-offset"]["default"]);


$jQueryPrefix = get_option("share-rail-jquery-prefix", $shareRail->editFields["settings"]["share-rail-jquery-prefix"]["default"]);

if(trim($googleLoad)==""){ $googleLoad = true; }
if(trim($jQueryPrefix)==""){ $jQueryPrefix = "$"; }
if(trim($verticalOffset)==""){ $verticalOffset = 10; }
?>
<!-- Share Rail v<?php print $shareRail->version ?> from Bloafer http://studio.bloafer.com/wordpress-plugins/share-rail/ (<?php print $shareRail->gcX ?>,<?php print $shareRail->gcY ?>) -->
<?php if($facebookActive){ ?>
<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
<?php } ?>
<?php if($linkedinActive){ ?>
<script type="text/javascript" src="http://platform.linkedin.com/in.js"></script>
<?php } ?>

<script type="text/javascript">
  (function() {
<?php if($googleActive && $googleLoad){ ?>
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
<?php } ?>
<?php if($stumbleActive){ ?>
	var stscr = document.createElement('script'); stscr.type = 'text/javascript'; stscr.async = 'true';
	stscr.src ='http://www.stumbleupon.com/hostedbadge.php?s=5&r=<?php print urlencode($currentURL) ?>&a=1&d=shareRail_suhb';
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(stscr, s);
<?php } ?>
  })();
<?php print $jQueryPrefix ?>(document).ready(function(){
	if(<?php print $jQueryPrefix ?>("#shareRail").length>=1){
		var attachmentContainer = <?php print $jQueryPrefix ?>("<?php print $jQueryAttachment ?>");
		var shareRailOrignalTop = <?php print $jQueryPrefix ?>("#shareRail").css("top");
		var shareRailOrignalLeft = <?php print $jQueryPrefix ?>("#shareRail").css("left");
		var shareRail = <?php print $jQueryPrefix ?>("#shareRail").html();
		<?php print $jQueryPrefix ?>("#shareRail").remove();
		if(<?php print $jQueryPrefix ?>(attachmentContainer).length>=1){
			<?php print $jQueryPrefix ?>(attachmentContainer).append('<div id="shareRail" />').css("position", "relative");
			<?php print $jQueryPrefix ?>("#shareRail").html(shareRail);
			var railOffset = <?php print $jQueryPrefix ?>("#shareRail").offset();
			var attachmentContainerOffset = <?php print $jQueryPrefix ?>(attachmentContainer).offset();
			<?php print $jQueryPrefix ?>(window).scroll(function () {
				var vPos = (<?php print $jQueryPrefix ?>(window).scrollTop() - (attachmentContainerOffset.top-<?php print $verticalOffset ?>));
				if(vPos>=0){
					<?php print $jQueryPrefix ?>("#shareRail").css("top", <?php print $verticalOffset ?>).css("left", railOffset.left).css("position", "fixed");
				}else{
					<?php print $jQueryPrefix ?>("#shareRail").css("top", shareRailOrignalTop).css("left", shareRailOrignalLeft).css("position", "absolute");
				}
			});
		}
	}
<?php if($googleSocialActive){ ?>
<?php 	if($facebookActive){ ?>
	FB.Event.subscribe('edge.create', function(targetUrl) { _gaq.push(['_trackSocial', 'facebook', 'like', targetUrl]); });
	FB.Event.subscribe('message.send', function(targetUrl) { _gaq.push(['_trackSocial', 'facebook', 'send', targetUrl]); });
	FB.Event.subscribe('edge.remove', function(targetUrl) { _gaq.push(['_trackSocial', 'facebook', 'unlike', targetUrl]); });
<?php 	} ?>
<?php 	if($twitterActive){ ?>
	twttr.events.bind('tweet', function(event) {
		if (event) {
			_gaq.push(['_trackSocial', 'twitter', 'tweet', '<?php print $currentURL ?>']);
		}
	});
<?php 	} ?>
<?php } ?>
});
</script>


