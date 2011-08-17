<?php
if(!current_user_can('manage_options')){
	wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );
}
if(isset($_POST["crc"])){
	if($_POST["crc"]=="settings"){
		if( wp_verify_nonce($_POST[$shareRail->nonceField],'settings')){
			foreach($shareRail->editFields["settings"] as $editField=>$editValue){
				update_option($editField, $_POST[$editField]);
			}
			print $shareRail->messageInfo("Options updated");
		}else{
			print $shareRail->messageInfo("Nonce Failed", "error");
		}
	}
}
$random = rand(111111, 999999);

?><div class="wrap">
  <div class="icon32" id="icon-tools"><br></div><h2>Share Rail Settings</h2>
    <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=B7NRW58F3CDBC" style="float:right;" target="_blank"><img src="https://www.paypal.com/en_US/i/btn/x-click-but11.gif" alt="Donate" /></a>
    <p>The settings here are fairly straight forward so have a play find what works best. If you are having any problems using this plugin, please do not rate this plugin as 1 star on wordpress, visit our site for help (<a href="http://studio.bloafer.com/wordpress-plugins/share-rail/" target="_blank">Bloafer</a>), you can post a comment and we will work on addressing the issue</p>
    <form method="post" action="">
      <input type="hidden" name="crc" value="settings" />
      <?php wp_nonce_field('settings', $shareRail->nonceField); ?>
      <table class="form-table">
        <tbody>
<?php
	foreach($shareRail->editFields["settings"] as $editField=>$editValue){
		$$editField = get_option($editField, $editValue["default"]);
?>
        <tr valign="top">
          <th scope="row"><label for="<?php print $editField ?>"><?php print $editValue["label"] ?></label></th>
          <td>
		  <?php if($editValue["type"]=="text"){ ?>
            <input type="text" name="<?php print $editField ?>" id="<?php print $editField ?>" value="<?php echo $$editField; ?>" class="regular-text" />
          <?php }elseif($editValue["type"]=="check"){ ?>
            <input type="checkbox" name="<?php print $editField ?>" id="<?php print $editField ?>"<?php if($$editField){ ?> checked="checked"<?php } ?> />
          <?php }elseif($editValue["type"]=="drop" && isset($editValue["data"])){ ?>
            <select name="<?php print $editField ?>" id="<?php print $editField ?>">
              <?php foreach($editValue["data"] as $k=>$v){
				  ?>  <option value="<?php print $k ?>" <?php if($$editField==$k){ ?> selected="selected"<?php } ?>><?php print $v ?></option><?php
			  }
			  ?>
            </select>
          <?php }elseif($editValue["type"]=="textarea"){ ?>
            <textarea cols="30" rows="5" id="<?php print $editField ?>" name="<?php print $editField ?>"><?php echo $$editField; ?></textarea>
          <?php }elseif($editValue["type"]=="warn"){ ?>
            &nbsp;
          <?php }else{ ?>
            Incorrect settings field (<?php print $editField ?>)
          <?php } ?>
          
          <?php if(isset($editValue["description"])){ ?>
            <span class="description"><?php print $editValue["description"] ?></span>
          <?php } ?>
          </td>
        </tr>
<?php
	}
?>
      </tbody>
    </table>
    <p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>

  </form>
  <div class="icon32" id="icon-users"><br></div><h2>Do you like this? show your love :)</h2>
  <p>
  
<iframe id="tweet_frame_<?php print $random ?>" name="tweet_frame_<?php print $random ?>" class="twitter-share-button" allowtransparency="true" frameborder="0" role="presentation" scrolling="no" src="http://platform.twitter.com/widgets/tweet_button.html?url=<?php print urlencode("http://studio.bloafer.com/wordpress-plugins/share-rail/")  ?>&via=Bloafer&text=Im using Share Rail for Wordpress, its cool&count=vertical" width="55" height="63"></iframe>
<g:plusone size="tall" count="true" href="http://studio.bloafer.com/wordpress-plugins/share-rail/"></g:plusone>
<fb:like href="http://studio.bloafer.com/wordpress-plugins/share-rail/" layout="box_count"></fb:like>
<div id="shareRail_susphb"></div>
<script type="in/share" data-url="http://studio.bloafer.com/wordpress-plugins/share-rail/" data-counter="top"></script>

<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js#appId=248371728526501&amp;xfbml=1"></script>
<script type="text/javascript" src="http://platform.linkedin.com/in.js"></script>
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	var stscr = document.createElement('script'); stscr.type = 'text/javascript'; stscr.async = 'true';
	stscr.src ='http://www.stumbleupon.com/hostedbadge.php?s=5&r=<?php print urlencode("http://studio.bloafer.com/wordpress-plugins/share-rail/") ?>&a=1&d=shareRail_susphb';
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(stscr, s);
  })();
</script>

  </p>

