<?php
$customCSS = get_option("share-rail-custom-css", $shareRail->editFields["settings"]["share-rail-custom-css"]["default"]);
?><style>
#shareRail{
	position:absolute;
	top:-1px;
	left:-62px;
	width:62px;
	background:#F8F8F8;
	border:solid 1px #E9E9E9;
	z-index:101;
	padding:2px;
	padding-top:6px;
	padding-bottom:0px;
	text-align:center;
	-moz-border-radius: 5px;
	border-radius: 5px;
}
#shareRail .railRow{
	margin-bottom:5px;
}
#shareRail .railRow{
	margin-bottom:0px;
}
/*
#shareRail .railRow .fb_iframe_widget iframe{
	width:45px !important;
}
*/
<?php
print $customCSS;
$debug = get_option("share-rail-debug-active", $shareRail->editFields["settings"]["share-rail-custom-css"]["default"]);
if($debug){ if(isset($_GET["sr"]["css"])){ print $_GET["sr"]["css"]; }}
?>
</style>
