<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


function jwrr_session_path()
{
  $session_path = realpath($_SERVER['DOCUMENT_ROOT'] . '/../sessions');
  return $session_path;
}


function jwrr_session_cookie_name()
{
  return 'tuna_cookie_meow';
}


function jwrr_session_cookie_is_valid_session($cookie_name='')
{
  if ($cookie_name == '') {
    $cookie_name = jwrr_session_cookie_name();
  }
  if (!isset($_COOKIE[$cookie_name])) {
    return false;
  }
  $session_path = jwrr_session_path();
  $session_name = $session_path . '/sess_' . $_COOKIE[$cookie_name];
  $session_exists = file_exists($session_name);
  return $session_exists;
}

function jwrr_session_start($start_new_session = false, $cookie_name = '')
{

  if ($cookie_name == '') {
    $cookie_name = jwrr_session_cookie_name();
  }

  $session_path = jwrr_session_path();
  $start_session = jwrr_session_cookie_is_valid_session() || $start_new_session;
  if (!$start_session) {
    return;
  }
  ini_set('session.save_path', $session_path);
  ini_set("session.use_strict_mode", 1);
  ini_set("session.cookie_secure", 1);
  ini_set("session.cookie_httponly", 1);
  ini_set("session.use_cookies", 1);
  ini_set("session.use_only_cookies", 1);
  ini_set("session.use_trans_sid", 0);
  ini_set("session.sid_length", 64);
  ini_set("session.sid_bits_per_character", 6);
  session_name($cookie_name);
  session_set_cookie_params([
    'lifetime' => 60*60*24*2,
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => true,
    'httponly' => true,
    'samesite' => 'lax']);
  if ($start_new_session) {
    session_start();
  } else { // already open
    session_start(['read_and_close'=>1]);
  }
} // jwrr_session_start


function jwrr_session_new($username)
{
  jwrr_session_start(true);
  $_SESSION['username'] = $username;
  session_commit();
  return $username;
}


function jwrr_session_resume()
{
  jwrr_session_start(false);
}


function jwrr_session_is_signed_in()
{
  return isset($_SESSION['username']);
}


function jwrr_session_username()
{
  $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
  return $username;
}

