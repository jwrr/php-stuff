<?php
  require_once('jwrr_session.php');
  require_once 'jwrr_members.php';


function home_header()
{
$html_home_header = <<<HEREDOC_HOME_HEADER
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
</head>
<body>
<div class="main">
HEREDOC_HOME_HEADER;
return $html_home_header;
}


function home_footer()
{
$html_home_footer = <<<HEREDOC_HOME_FOOTER
</div>
</body>
</html>
HEREDOC_HOME_FOOTER;
return $html_home_footer;
}


function signin_form()
{

  $html_signin_form = home_header();
  $html_signin_form .= <<<HEREDOC_SIGNIN_FORM
<h3>Sign In</h3>
<hr>
<a href="index.php?do=join">Not a member yet? Join here</a>
<div>
<form method="POST" action="index.php">
<input type="hidden" id="do" name="do" value="signin_request">
<div>
<label>Username</label>
<input type="text" name="username" class="form-control" required="required"/>
</div>
<div>
<label>Password</label>
<input type="password" name="password" class="form-control" required="required"/>
</div>
<button name="SignIn">Sign In</button>
</form>
</div>
HEREDOC_SIGNIN_FORM;
  $html_signin_form .= home_footer();

  return $html_signin_form;
} // signin_form


function join_form()
{
$html_join_form = home_header();
$html_join_form .= <<<HEREDOC_JOIN_FORM
<h3>Join</h3>
<hr>
<a href="index.php?do=signin">Already a member? Sign in here</a>
<div>
<form method="POST" action="index.php?do=join_request">
<div>
<label>Username</label>
<input type="text" name="username" class="form-control" required="required"/>
</div>
<div>
<label>Password</label>
<input type="password" name="password" class="form-control" required="required"/>
</div>
<div>
<label>Firstname</label>
<input type="text" name="firstname" class="form-control" required="required"/>
</div>
<div>
<label>Lastname</label>
<input type="text" name="lastname" class="form-control" required="required"/>
</div>
<button name="join">Join</button>
</form>
</div>
HEREDOC_JOIN_FORM;
  $html_join_form .= home_footer();
return $html_join_form;
} // join_form


function home_page()
{
$html_home_page = home_header();

if (jwrr_session_is_signed_in()) {

print_r($_SESSION);

$html_home_page .= <<<HEREDOC_HOME_PAGE
<h3>Home Page</h3>
<hr>
<a href="index.php?do=signout">Sign Out</a>
HEREDOC_HOME_PAGE;

} else {

$html_home_page .= <<<HEREDOC_HOME_PAGE
<h3>Home Page</h3>
<hr>
<a href="index.php?do=join">Join</a> |
<a href="index.php?do=signin">Sign In</a>
HEREDOC_HOME_PAGE;

}


$html_home_page .= home_footer();

return $html_home_page;
} // home_page


// ============================================================================
// ============================================================================

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

jwrr_session_resume();

//** if ( isset( $_SESSION['counter'] ) ) {
//**    $_SESSION['counter'] += 1;
//**    $msg = "You have visited this page ".  $_SESSION['counter'];
//**    $msg .= "in this session.";
//**    echo $msg;
//**    print_r(session_get_cookie_params());
//** } else {
//**   echo "not logged in";
//** }

//** exit;

//** $expires = time() + 60*60*24*30;
//** $arr_cookie_options = array (
//**   'expires' => time() + 60*60*24*30, // 30 days
//**   'domain' => '', // leading dot for compatibility or use subdomain
//**   'secure' => true,     // or false
//**   'httponly' => true,    // or false
//**   'samesite' => 'Lax' // None || Lax  || Strict
//**   );
//**
//** $r = base64_encode(random_bytes(128));
//** echo strlen($r) . ' ' . $expires . $r;
//**
//**
//** if (!isset($_SESSION['cookie_key_sodium'])) {
//**   $_SESSION['cookie_key_sodium'] = sodium_crypto_aead_xchacha20poly1305_ietf_keygen();
//** }
//** echo '<hr> key - ';
//** echo base64_encode($_SESSION['cookie_key_sodium']);
//**
//** if (!isset($_SESSION['cookie_nonce_sodium'])) {
//**   $_SESSION['cookie_nonce_sodium'] = \random_bytes(\SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES);
//** }
//** echo '<hr>nonce = ';
//** echo base64_encode($_SESSION['cookie_nonce_sodium']);
//**
//** echo '<hr>original message = ';
//** $message = 'Hello World';
//** echo $message;
//** $encrypted_text = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt($message, '', $_SESSION['cookie_nonce_sodium'], $_SESSION['cookie_key_sodium']);
//** echo '<hr>encrypted_text = ';
//** echo strlen($encrypted_text). ' ' . base64_encode($encrypted_text);
//**
//** $decrypted_text = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($encrypted_text, '', $_SESSION['cookie_nonce_sodium'], $_SESSION['cookie_key_sodium']);
//** echo '<hr>decrypted text = ';
//** echo $decrypted_text;
//**
//** exit;

//***
//*** setcookie('random', 'The Cookie Value', $arr_cookie_options);




if (ISSET($_REQUEST['do'])) {
  $conn = jwrr_members_open_database('jwrr_members');

  if ($_REQUEST['do'] == 'signin_request') {
    jwrr_members_signin_request($conn);
    exit;
  } else if ($_REQUEST['do'] == 'join_request') {
    jwrr_members_join_request($conn);
    exit;
  } else if ($_REQUEST['do'] == 'signin') {
    $html = signin_form();
  } else if ($_REQUEST['do'] == 'signout') {
    session_start();
    session_destroy();
    header('location:index.php');
    exit;
  } else if ($_REQUEST['do'] == 'join') {
    $html = join_form();
  }
} else {
  $html = home_page();
}

echo $html;


