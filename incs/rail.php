<?php
$random = rand(111111, 999999);

$currentURL = "http" . (($_SERVER["SERVER_PORT"]==443)?"s":"") . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

$twitterUsername = get_option("share-rail-twitter-username", $shareRail->editFields["settings"]["share-rail-twitter-username"]["default"]);

$googleActive = get_option("share-rail-google-active", $shareRail->editFields["settings"]["share-rail-google-active"]["default"]);
$twitterActive = get_option("share-rail-twitter-active", $shareRail->editFields["settings"]["share-rail-twitter-active"]["default"]);
$stumbleActive = get_option("share-rail-stumble-active", $shareRail->editFields["settings"]["share-rail-stumble-active"]["default"]);
$facebookActive = get_option("share-rail-facebook-active", $shareRail->editFields["settings"]["share-rail-facebook-active"]["default"]);
$linkedinActive = get_option("share-rail-linkedin-active", $shareRail->editFields["settings"]["share-rail-linkedin-active"]["default"]);
$pintrestActive = get_option("share-rail-pintrest-active", $shareRail->editFields["settings"]["share-rail-pintrest-active"]["default"]);

$customContent = get_option("share-rail-custom-content", $shareRail->editFields["settings"]["share-rail-custom-content"]["default"]);

if($twitterActive || $facebookActive || $googleActive || $stumbleActive || $linkedinActive){
?>

<div id="shareRail">
<?php if(trim($twitterUsername)!="" && $twitterActive){ ?>
<div class="railRow">
  <a href="http://twitter.com/share" data-count="vertical" data-via="<?php print $twitterUsername ?>" class="twitter-share-button">Tweet</a>
</div>
<?php } ?>
<?php if($facebookActive){ ?>
<div class="railRow">
  <fb:like layout="box_count"></fb:like>
</div>
<?php } ?>
<?php if($googleActive){ ?>
<div class="railRow">
  <g:plusone size="tall" count="true"></g:plusone>
</div>
<?php } ?>
<?php if($stumbleActive){ ?>
<div class="railRow">
  <div id="shareRail_suhb"></div>
</div>
<?php } ?>
<?php if($linkedinActive){ ?>
<div class="railRow">
  <script type="in/share" data-counter="top"></script>
</div>
<?php } ?>
<?php if($pintrestActive){ ?>
<div class="railRow">
  <a href="http://pinterest.com/pin/create/button/?url=<?php print urlencode($currentURL); ?>" class="pin-it-button" count-layout="vertical"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
</div>
<?php } ?>
<?php if(trim($customContent)!=""){ ?>
<div class="railRow">
<?php print stripslashes($customContent) ?>
</div>
<?php } ?>
</div>
<?php } ?>
