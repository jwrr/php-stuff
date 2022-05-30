<?php
/*
 Name: JWRR Button Bar
 URI: https://github.com/wordpress-stuff/wp-content/plugins/jwrr_button_bar
 Description: a plugin to add a button bar at the top of the page
 Version: 0.1
 Author: jwrr
 Author URI: http://jwrr.com
 License: MIT
*/


function jwrr_button_bar()
{
  $enable_style = false;
  $style = "";
  if ($enable_style) {
    $style .=
'
<style>
#css-main {position:static;}
.css-button-bar {position:static; width:100%; min-height: 3.3em; background-color:black; color:white; max-width:100%; text-align: center;}
.css-button-bar span {margin:0; padding:0; font-size:1.6em; }
.css-button {font-size:1.3em;border-radius:10px;padding:0.5em 0.2em 0.5em 0.2em;margin: 3px 0.15em 0 3px;background-color:green;color:white;text-decoration: none; width: 3.4em; overflow: hidden; white-space: nowrap; }
a.css-button:link {color: white; text-decoration: none;}
a.css-button:visited {color: white; text-decoration: none;}
.css-right {float: right;}
.css-left  {float: left;}
.css-button-bar span {white-space: nowrap;}
</style>
';
  }

  $user = jwrr_session_username();  //  _wp_get_current_user();
  $is_logged_in = jwrr_session_is_signed_in(); // $user->exists();

  $buttons = "";
  $home_page_uri = get_home_page_uri();
  if ($is_logged_in) {
    $firstname = ucwords(jwrr_get_firstname());
    $fullname_with_dash = jwrr_get_fullname('', '-');
    $uri = $_SERVER['REQUEST_URI'];
    if (str_contains($uri, "/show/$fullname_with_dash")) {
      $buttons .= '<a class="css-button css-right" href="${home_page_uri}/join.php">' . 'Account' . "</a>\n";
    } else {
      $buttons .= '<a class="css-button css-right" href="' . $home_page_uri . 'show.php/b/' . $fullname_with_dash . '">' . 'My Art'. "</a>\n";
    }

    $buttons .= <<<HEREDOC_LOGGED_IN
   <a class="css-button css-right" href="${home_page_uri}signout.php">Sign Out</a>
   <a class="css-button css-left" href="${home_page_uri}upload.php">Upload</a>
HEREDOC_LOGGED_IN;

  } else {
    $buttons .= <<<HEREDOC_LOGGED_OUT
   <a class="css-button css-right" href="${home_page_uri}signin.php">Sign In</a>
   <a class="css-button css-right" href="${home_page_uri}join.php">Join</a>
HEREDOC_LOGGED_OUT;
    
  }


  $a = jwrr_parse_img_path();
  
  $artist_username = empty($a['username']) ? '' : $a['username'];
  $art_title = empty($a['title']) ? '' : $a['title'];

  if (is_home_page() || is_home_page_when_logged_in()) {
    $artist_fullname = '';
  } else {
    $artist_fullname = empty($a['fullname']) ? '' : $a['fullname'];
  }

  $name = $artist_fullname=='' ? 'CATARTISTS.ORG' :  "Artwork by $artist_fullname";


  $home_url = $home_page_uri;
  if (jwrr_is_logged_in()) {
    $home_url = "${home_url}b.php";
  }

  $html = <<<HEREDOC

<!-- button_bar -->
$style

<div class="css-button-bar">
   <a class="css-button css-left" href="$home_url">Home</a>
   $buttons
   <span>$name</span>
</div>
<!-- end button_bar -->

HEREDOC;
	return $html;
}




function jwrr_change_page_form($delete_button='')
{
  $username_required = 'Must be lowercase letters or hyphen and at least 4 letters. For example: cat-artists';
  $username_readonly = '';
  $password_required = 'Required';
  $submit_value = "Register";
  if (jwrr_is_logged_in()) {
    $username_readonly = 'readonly="readonly"';
    $username_required = 'Locked';
    $password_required = 'Leave blank if you do not want to change your password';
    $submit_value      = 'Rename Title';

//fixme    $userdata    = jwrr_get_userdata();
    if (empty($link))  $link   = "fixme link"; // $userdata->link;
    if (empty($title)) $title  = "fixme_title"; // ""$userdata->title;
  }

  $link_placeholder = (empty($link) || $link=='') ? 'placeholder="zazzle.com/store/rachel_armington_art"' : '';
  $title = (empty($title) || $title=='') ? 'placeholder="abc-def-ghi"' : '';
  $html = '';

    $a = jwrr_parse_img_path();
    $title = ucwords( strtolower(preg_replace('/[^a-z0-9]+/iu', ' ', $a['title'] )) );

    $uri = $_SERVER['REQUEST_URI'];
    if (jwrr_count_images() == 0) return "<h2>Welcome to Cat Artists! Click the 'Upload' button to send us your cats!</h2>";
    
    $rename_uri = preg_replace('/rename\/?$/', '', $uri);
    $rename_uri = rtrim($rename_uri, '/');
    $html .=  <<<HEREDOC
    <form action="${rename_uri}/rename" method="post">

    <div class="css-oneliner">
    <label for="title">Title</label>
    <input type="text" name="newname" value="$title">
    </div>

<!--
    <div class="css-oneliner">
    <label for="link">Merchant Link</label>
    <input type="text" name="link" $link_placeholder value="$link">
    </div>
-->
<div>
    $delete_button
    <div class="css-oneliner" style = "float:left;padding:0.15em; width:46.5em; max-width:50%;">
    <input style="padding:0.6em;" type="submit" name="submit" value="$submit_value"/>
    </div>
</div>
<div style="clear:both;" ></div>
    </form>
HEREDOC;
    return $html;
}





function jwrr_buybar($buy_platform, $buy_platform_icon, $buy_url)
{
  $logged_in_artist_fullname_with_dash = jwrr_get_fullname('', '-');
  $request_uri = ($_SERVER['REQUEST_URI']);
  $is_owner = str_contains($request_uri, "/$logged_in_artist_fullname_with_dash/");
  $delete_button = '';
  if ($is_owner && !str_contains($request_uri, '/delete')) {
    $delete_uri = $request_uri . '/delete';
    $delete_button = "<a class=\"css-button css-left\" style=\"background-color: red; width:5em; padding:1em; margin:auto 1em auto 1em;\" href=\"$delete_uri\">Delete Page</a>\n";
    $change_form = jwrr_change_page_form($delete_button);
    $buy_button = '';
  } else {
    $change_form = '';
    $buy_button = <<<BUYBUTTON
    <div class="css-pod-item">
      <a href="$buy_url"><img src="$buy_platform_icon"></a>
      <div><a href="$buy_url">See my art on $buy_platform</a></div>
    </div>
BUYBUTTON;
  }
  $html = <<<HEREDOC
  <div class="css-pod-bar">
    <hr>
    </div>
    $change_form
    $buy_button
    <hr>
  </div>
HEREDOC;
return $html;
}


