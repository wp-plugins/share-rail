<?php
$jQueryAttachment = get_option("share-rail-class-attachment", $shareRail->editFields["settings"]["share-rail-class-attachment"]["default"]);

$facebookActive = get_option("share-rail-facebook-active", $shareRail->editFields["settings"]["share-rail-facebook-active"]["default"]);
$googleActive = get_option("share-rail-google-active", $shareRail->editFields["settings"]["share-rail-google-active"]["default"]);

$verticalOffset = get_option("share-rail-vertical-offset", $shareRail->editFields["settings"]["share-rail-vertical-offset"]["default"]);

if(trim($verticalOffset)==""){
	$verticalOffset = 10;
}

?>
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
$(document).ready(function(){
	if($("#shareRail").length>=1){
		var attachmentContainer = $("<?php print $jQueryAttachment ?>");
		var shareRailOrignalTop = $("#shareRail").css("top");
		var shareRailOrignalLeft = $("#shareRail").css("left");
		var shareRail = $("#shareRail").html();
		$("#shareRail").remove();
		if($(attachmentContainer).length>=1){
			$(attachmentContainer).append('<div id="shareRail" />').css("position", "relative");
			$("#shareRail").html(shareRail);
			var railOffset = $("#shareRail").offset();
			var attachmentContainerOffset = $(attachmentContainer).offset();
			$(window).scroll(function () {
				var vPos = ($(window).scrollTop() - (attachmentContainerOffset.top-<?php print $verticalOffset ?>));
				if(vPos>=0){
					$("#shareRail").css("top", <?php print $verticalOffset ?>).css("left", railOffset.left).css("position", "fixed");
				}else{
					$("#shareRail").css("top", shareRailOrignalTop).css("left", shareRailOrignalLeft).css("position", "absolute");
				}
			});
		}
	}
});
</script>


