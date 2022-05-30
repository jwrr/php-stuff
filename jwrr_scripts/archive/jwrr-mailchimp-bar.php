<?php
/*
 Name: JWRR Mailchimp Bar
 URI: https://github.com/wordpress-stuff/wp-content/plugins/jwrr-mailchimp_bar
 Description: a plugin to add a Mailchimp signup bar at the top of the page
 Version: 0.1
 Author: jwrr
 Author URI: http://jwrr.com
 License: MIT
*/

add_shortcode('mailchimp', 'jwrr_mailchimp_bar');

function jwrr_mailchimp_bar($atts = array(), $content = null, $tag = '')
{
  $enable_style = false;
  extract( shortcode_atts( array('id' => 'undefined'), $atts ) );
  $user = "bf74ebf3a5bc81e8babb65a92";
  $id   = "cf5b05c87c";
  $name = "b_{$user}_{$id}";
  $signup_text = "Enter your email for our free newsletter";
  $go_text = "Sign Up";
  $go_color = "#007000";
  $html = '';
  
  if ($enable_style)
  {
    $html = <<<HEREDOC

<!-- jwrr-mailchimp-bar -->
<style>
.jwrr_mail_chimp {position:absolute;left:70px;width:100%;height:2.7em;background-color:black;color:white;max-width:100%;}
#css-main {top:2.7em;}
.buttonleft {float:left; font-size:1.8em;border-radius:10px;padding:0em 1em 0.1em 1em;margin: 3px 0 3px 0.2em;background-color:$go_color;color:oldlace;text-decoration: none;}
a.buttonleft:link {color: oldlace; text-decoration: none;}
a.buttonleft:visited {color: gray; text-decoration: none;}
.buttonright {float:right; font-size:1.8em;border-radius:10px;padding:0em 1em 0.1em 1em;margin: 3px 0.2em 0 3px;background-color:$go_color;color:oldlace;text-decoration: none;}
a.buttonright:link {color: oldlace; text-decoration: none;}
a.buttonright:visited {color: gray; text-decoration: none;}
</style>
HEREDOC;
}


  $html .= <<<HEREDOC
<div class="jwrr_mail_chimp">
<!--
<form action="https://Cat-Paintings.us10.list-manage.com/subscribe/post?u=$user&amp;id=$id" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
  <div id="mc_embed_signup_scroll" style="margin-top:2px;margin-left:2%;margin-right:auto;">
   <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="$signup_text" 
          style="width:75%;max-width:400px;font-size:1.5em;border-radius:10px 10px 10px 10px;padding-left:0.5em;" required>
   <input type="submit" value="$go_text" name="subscribe" id="mc-embedded-subscribe" class="button" 
         style="font-size:1.5em;border-radius:10px;padding:0em 1em 0.1em 1em;margin: 0em 0 0 0;background-color:$go_color;color:oldlace;">
   <input type="hidden" name="$name" value="">
  </div>
</form>
-->
   <a class="buttonleft" href="/">Home</a>
   <a class="buttonright" href="/join">Join</a>
   <a class="buttonright" href="/signin">Sign In</a>
   <a class="buttonright" href="/upload">Upload</a>
</div>
<!-- end jwrr-mailchip-bar -->

HEREDOC;
	return $html;
}

