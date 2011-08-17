<?php
$currentURL = "http" . (($_SERVER["SERVER_PORT"]==443)?"s":"") . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$pageTitle = get_the_title();

$random = rand(111111, 999999);

if(trim($pageTitle)==""){
	$pageTitle = get_bloginfo('name');
}

$twitterUsername = get_option("share-rail-twitter-username", $shareRail->editFields["settings"]["share-rail-twitter-username"]["default"]);

$twitterActive = get_option("share-rail-twitter-active", $shareRail->editFields["settings"]["share-rail-twitter-active"]["default"]);
$facebookActive = get_option("share-rail-facebook-active", $shareRail->editFields["settings"]["share-rail-facebook-active"]["default"]);
$googleActive = get_option("share-rail-google-active", $shareRail->editFields["settings"]["share-rail-google-active"]["default"]);

$customContent = get_option("share-rail-custom-content", $shareRail->editFields["settings"]["share-rail-custom-content"]["default"]);

if($twitterActive || $facebookActive || $googleActive){
?>

<div id="shareRail">
<?php if(trim($twitterUsername)!="" && $twitterActive){ ?>
<div class="railRow">
  <iframe id="tweet_frame_<?php print $random ?>" name="tweet_frame_<?php print $random ?>" class="twitter-share-button" allowtransparency="true" frameborder="0" role="presentation" scrolling="no" src="http://platform.twitter.com/widgets/tweet_button.html?url=<?php print urlencode($currentURL)  ?>&via=<?php print $twitterUsername ?>&text=<?php print $pageTitle ?>&count=vertical" width="55" height="63"></iframe>
</div>
<?php } ?>
<?php if($facebookActive){ ?>
<div class="railRow">
  <fb:like href="<?php print $currentURL ?>" layout="box_count"></fb:like>
</div>
<?php } ?>
<?php if($googleActive){ ?>
<div class="railRow">
  <g:plusone size="tall" count="true" href="<?php print $currentURL  ?>"></g:plusone>
</div>
<?php } ?>
<?php if(trim($customContent)!=""){ ?>
<div class="railRow">
<?php print $customContent ?>
</div>
<?php } ?>
</div>
<?php } ?>
