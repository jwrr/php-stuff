<?php

function custom_default_page($pagename)
{
  $search_form = jwrr_search_form();
  $html = '';
  if (is_home_page() || is_home_page_when_logged_in() || $pagename == 'signout') {  
    $search_string = get_post_search_string();
    if ($search_string == "") {
      $img = "";
      $html .= "<img class=\"css-main-image\" src= '/catartists-images/home-banner.jpg' width='800' height='460' alt='Cat Artists Banner'>\n";
    }
    $html .= $search_form;
    $html .= search_and_show_images();
  } else {
    $html .= jwrr_show_images();
  }
  return $html;
}



function custom_homepage()
{

  jwrr_signout_if_uri_contains('signout.php');
  
  $button_bar = jwrr_button_bar();
  $page_title = get_page_title();
  $css = custom_css();
  $html = <<<HEREDOC_HEADER
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width">
$page_title
$css
</head>
<body>
  <div id='css-outer'>
  $button_bar
   <div id='css-main'>
HEREDOC_HEADER;

  $uri = $_SERVER['REQUEST_URI'];
  $pagename = basename($uri, ".php");
  switch ($pagename) {
  case "signin":
    $html .= jwrr_signin_form();
    break;
  case "signin_request":
    jwrr_signin_request();
    exit;
    break;
  case "join":
    $html .= jwrr_join_form();
    break;
  case "join_request":
    $html .= jwrr_join_request();
    $html .= jwrr_join_form();
    break;
  case "upload":
    $html .= jwrr_upload_form();
    break;
  case "upload_request":
    $html .= jwrr_upload_request();
    exit;
  default:
    $html .= custom_default_page($pagename);
  } // switch
  
$html .= "
  </div>
 </div>
</body>
</html>
";

return $html;  
}

