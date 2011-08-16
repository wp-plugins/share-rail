<?php
$googlejQueryActive = get_option("share-rail-jquery-use-google", $shareRail->editFields["settings"]["share-rail-jquery-use-google"]["default"]);

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
	text-align:center;
	-moz-border-radius: 5px;
	border-radius: 5px;
}
#shareRail .railRow{
	margin-bottom:5px;
}
</style>
<?php
if($googlejQueryActive){
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<?php } ?>
