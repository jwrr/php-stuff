<?php
/*
 Name: JWRR Signin Form
 URI: https://github.com/wordpress-stuff/wp-content/plugins/jwrr-login-form
 Description: a plugin to add an login form to a page
 Version: 0.1
 Author: jwrr
 Author URI: http://jwrr.com
 License: MIT
*/

// add_shortcode('jwrr_login_form', 'jwrr_login_form');

function jwrr_signin_form()
{
  $enable_style = false;
  $login_page = "/catartists-login2.php";
  $lost_page = "/catartists-login2.php?action=lostpassword";
  $redirect_page = "/b/";
  $login_button_msg = "Sign In";
  $lost_password_msg = "Lost your password?";

  $html = "

<!-- jwrr_login_form -->";
  if ($enable_style) {
    $html .= <<<HEREDOC1

  <style>
    div.css-user-name-wrap {margin:1em;}
    div.css-user-pass-wrap {margin:1em;}
    div.catartist-usr input {font-size:1.5em;border-color:gray;border-radius:10px;padding:0.3em;width:40%;}
    div.catartist-pwd input {font-size:1.5em;border-color:gray;border-radius:10px;padding:0.3em;width:40%;}
    .forgetmenot {margin:1em;}
    #catartist-submit {font-size:1.5em;padding:0.5em 1em 0.5em 1em;margin-left:0.8em;border-color:gray;border-radius:10px;background-color:green;color:white;}
    h2.whoops {margin-left:05em; color:red;}
  </style>

HEREDOC1;
  }

$whoops = empty($_REQUEST['whoops']) ? '' : '<h2 class="whoops">Whoooops... Try again</h2>';

$home_page_uri = get_home_page_uri();
$html .= <<<HEREDOC2
$whoops
<div id="css-login">
  <form name="loginform" action="${home_page_uri}signin_request.php" method="post">
    <div class="css-oneliner">
      <label for="user_login">Your Full Name (For example: Tickles Badcat)</label>
      <input type="text" name="username" required="required" placeholder="First Last" value="" autofocus>
    </div>

    <div class="css-oneliner">
      <label for="css-input-password">Password</label>
      <input type="password" name="password" id="css-input-password" placeholder="Your Password" value="" style="background-image:none; background-repeat:no-repeat;background-position:right;background-size:contain;">
    </div>
    <div class="css-checkbox">
      <input type="checkbox" onclick="jsShowHide()">Show Password 
    </div>
    <!--
    <div class="css-checkbox">
      <input name="rememberme" type="checkbox" id="rememberme" value="forever">
      <label for="rememberme">Remember Me</label>
    </div> -->

    <div class="css-oneliner">
      <input type="submit" name="catartist-submit" id="catartist-submit" value="$login_button_msg">
    </div>
    <input type="hidden" name="redirect_to" value="$redirect_page">
    <input type="hidden" name="testcookie" value="1">
  </form>

  <p id="nav">
    <a href="$lost_page">$lost_password_msg</a>
  </p>
</div>

<script>
function jsShowHide() {
  var x = document.getElementById("css-input-password");
  if (x.type === "password") {
    x.type = "text";
    x.style.backgroundImage = "url('/catartists-images/cateye4.svg')";
  } else {
    x.type = "password";
    x.style.backgroundImage = "none";
  }
} 
</script>


HEREDOC2;



  $html .= "
<!-- end jwrr_login_form -->

";

  return $html;
}




function jwrr_signin_request($db_name = 'jwrr_members')
{
  $error = 0;
  $username = trim($_POST['username']);
  $username = preg_replace('/[^a-zA-Z ]/', '', $_POST['username']);
  if ($username != $_POST['username']) $error = 1;

  $password = $_POST['password'];
  $password_len = strlen($password);
  if ($password_len < 8 || $password_len > 32) $error += 2;

  if ($error) {
    header("location: ${home_page_uri}signin.php?whoops=1");
    exit;
  }

  $username = strtolower($username);
  $username = preg_replace('/ /', '-', $username);

  $query = "SELECT password FROM `member` WHERE `username` = :username";
  $conn = jwrr_members_open_database($db_name);
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  $row = $stmt->fetch();
  $password_hash = $row[0];
  $password_good = password_verify($password, $password_hash);

  if ($password_good) {
    jwrr_session_new($username);
    $home_page_uri = get_home_page_uri();
    header("location: $home_page_uri");
    exit;
  } else {
    header("location: ${home_page_uri}signin.php?whoops=1");
    exit;
  }
}



function jwrr_signout_if_uri_contains($signout_uri = 'signout.php')
{
  $uri = $_SERVER['REQUEST_URI'];
  if (str_contains($uri, $signout_uri)) {
    session_start();
    session_destroy();
    unset($_SESSION);
  }
}
