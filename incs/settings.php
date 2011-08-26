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
    <p>The settings here are fairly straight forward so have a play find what works best. If you are having any problems using this plugin, please do not rate this plugin as 1 star on wordpress, visit our site for help (<a href="http://studio.bloafer.com/wordpress-plugins/share-rail/" target="_blank">Bloafer</a>), you can post a comment and we will work on addressing the issue. If you need to change the look and feel of the Share Rail you visit our site and use our <a href="http://studio.bloafer.com/wordpress-plugins/share-rail/share-rail-custom-css-engine/" target="_blank">CSS engine</a> to produce custom CSS for the box below.</p>
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
            <textarea cols="30" rows="5" id="<?php print $editField ?>" name="<?php print $editField ?>"><?php echo stripslashes($$editField); ?></textarea>
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
  <table>
    <tr>
      <td><a href="http://twitter.com/share" data-url="http://studio.bloafer.com/wordpress-plugins/share-rail/" data-count="vertical" data-via="Bloafer" data-text="Im using Share Rail for Wordpress, its cool" data-counturl="http://studio.bloafer.com/wordpress-plugins/share-rail/" class="twitter-share-button">Tweet</a></td>
      <td><g:plusone size="tall" count="true" href="http://studio.bloafer.com/wordpress-plugins/share-rail/"></g:plusone></td>
      <td><fb:like href="http://studio.bloafer.com/wordpress-plugins/share-rail/" layout="box_count"></fb:like></td>
      <td><div id="shareRail_susphb"></div></td>
      <td><script type="in/share" data-url="http://studio.bloafer.com/wordpress-plugins/share-rail/" data-counter="top"></script></td>
    </tr>
  </table>
  <div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
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

