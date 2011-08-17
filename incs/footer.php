<?php
$jQueryAttachment = get_option("share-rail-class-attachment", $shareRail->editFields["settings"]["share-rail-class-attachment"]["default"]);

$facebookActive = get_option("share-rail-facebook-active", $shareRail->editFields["settings"]["share-rail-facebook-active"]["default"]);
$googleActive = get_option("share-rail-google-active", $shareRail->editFields["settings"]["share-rail-google-active"]["default"]);

$verticalOffset = get_option("share-rail-vertical-offset", $shareRail->editFields["settings"]["share-rail-vertical-offset"]["default"]);


$jQueryPrefix = get_option("share-rail-jquery-prefix", $shareRail->editFields["settings"]["share-rail-jquery-prefix"]["default"]);

if(trim($verticalOffset)==""){
	$verticalOffset = 10;
}
if(trim($jQueryPrefix)==""){
	$jQueryPrefix = "$";
}
?>
<!-- Share Rail from Bloafer http://studio.bloafer.com/wordpress-plugins/share-rail/ -->
<?php if($facebookActive){ ?>
<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js#appId=248371728526501&amp;xfbml=1"></script>
<?php } ?>
<script type="text/javascript">
<?php if($googleActive){ ?>
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
<?php } ?>
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
});
</script>


