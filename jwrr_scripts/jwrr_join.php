<?php
/*
 Name: JWRR Pack
 URI: http://jwrr.com/wp/plugins/jwrr-pack
 Description: contains may small plugins and shortcodes
 Version: 0.1
 Author: jwrr
 Author URI: http://jwrr.com
 License: GPL3
*/


function jwrr_join_form_after_validate( $username, $password, $email, $website, $first_name, $last_name, $bio) // $social1, $social2, $social3 )
{
  $username_required = 'Must be lowercase letters or hyphen and at least 4 letters. For example: cat-artists';
  $readonly = '';
  $password_required = 'Required';
  $submit_value = "Register";
  $firstname_autofocus = ' autofocus ';
  $email_autofocus = '';
  $name_required_locked = 'Required';
  if (jwrr_is_logged_in()) {
    $readonly = 'readonly="readonly"';
    $username_required = 'Locked';
    $password_required = 'Leave blank if you do not want to change your password';
    $submit_value      = 'Update';
    $firstname_autofocus = '';
    $email_autofocus = ' autofocus ';
  $name_required_locked = 'Locked';

    $userdata    = jwrr_get_userdata();
    $username    = $userdata->user_login;
    if (empty($email))      $email       = $userdata->user_email;
    if (empty($website))    $website     = $userdata->user_url;
    if (empty($first_name)) $first_name  = $userdata->first_name;
    if (empty($last_name))  $last_name   = $userdata->last_name;
    if (empty($bio))        $bio         = $userdata->description;
  }

  $website_placeholder = (empty($website) || $website=='') ? 'placeholder="widgetbluesky.com"' : '';
  $social1_placeholder = (empty($social1) || $social1=='') ? 'placeholder="facebook.com/tickles"' : '';
  $social2_placeholder = (empty($social2) || $social2=='') ? 'placeholder="pinterest.com/nikos"' : '';
  $social3_placeholder = (empty($social3) || $social3=='') ? 'placeholder="twitter.com/maurina"' : '';

  $action_uri = get_home_page_uri() . 'join_request.php';
  echo '
    <form action="' . $action_uri . '" method="post">
    <div class="css-oneliner">
    <label for="firstname">First Name (' . $name_required_locked . ')</label>
    <input type="text" name="firstname" value="' . $first_name . '" ' . $firstname_autofocus . $readonly . '>
    </div>

    <div class="css-oneliner">
    <label for="lastname">Last Name (' . $name_required_locked . ')</label>
    <input type="text" name="lastname" value="' . $last_name . '" ' . $readonly . '>
    </div>

    <div class="css-oneliner">
    <label for="email">Email (Required). We need this to contact you. Your privacy is imporant and we don\'t share your info with anyone.</label>
    <input type="text" name="email" value="' . $email . '"' . $email_autofocus  .'>
    </div>

    <div class="css-oneliner">
    <label for="password">Password (' . $password_required .  ') Passwords are encrypted so even we can\'t see what they are</label>
    <input type="password" name="password" value="' . $password .'">
    </div>

    <div class="css-oneliner">
    <input type="submit" name="submit" value="' . $submit_value  . '"/>
    </div>
    </form>
    ';
}

function jwrr_join_validation( $username, $password, $email, $website, $first_name, $last_name, $bio) // , $social1, $social2, $social3 )
{
  $html = '';
  $error_count = 0;
  $is_logged_in = jwrr_is_logged_in();
  if ($is_logged_in) {
    if ($username != jwrr_get_username()) {
      $html .= '<p>The username is not correct</p>';
      $error_count++;
    }
  }
  echo $html;
  return ($error_count > 0);
}

function jwrr_join_wrapper() {
  $new_account_successfully_created = false;
  $_POST['firstname']    = empty($_POST['firstname']) ? '' : $_POST['firstname'];
  $_POST['lastname']    = empty($_POST['lastname']) ? '' : $_POST['lastname'];
  $_POST['username'] = strtolower($_POST['firstname'] . '-' . $_POST['lastname']);
  $_POST['password'] = empty($_POST['password']) ? '' : $_POST['password'];
  $_POST['email']    = empty($_POST['email'])    ? '' : $_POST['email'];
  $_POST['website']  = empty($_POST['website'])  ? '' : $_POST['website'];
  $_POST['bio']      = empty($_POST['bio'])      ? '' : $_POST['bio'];

  if (isset($_POST['submit'])) {
      global $username, $password, $email, $website, $first_name, $last_name, $bio, $social1, $social2, $social3;
      $username   =   jwrr_is_logged_in() ? jwrr_get_username() : $_POST['username'] ;
      $password   =   $_POST['password'];
      $email      =   $_POST['email'];
      $website    =   $_POST['website'];
      $first_name =   $_POST['firstname'];
      $last_name  =   $_POST['lastname'];
      $bio        =   $_POST['bio'];
  }

  if (!$new_account_successfully_created) {
    jwrr_join_form_after_validate(
      $_POST['username'],
      $_POST['password'],
      $_POST['email'],
      $_POST['website'],
      $_POST['firstname'],
      $_POST['lastname'],
      $_POST['bio']);
  }

}



function jwrr_join_form() {
  ob_start();
  jwrr_join_wrapper();
  return ob_get_clean();
}



function err_msg($msg)
{
  return '<p class="css-error">' . $msg . '</p>';
}

function success_msg($msg)
{
  return '<p class="css-success">' . $msg . '</p>';
}


function jwrr_join_request($db_name='jwrr_members')
{
  $html = '';
  if (!isset($_POST['firstname'])) $html .= err_msg('Missing Firstname');
  $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
  if ($firstname == '') $html .= err_msg('Your Firstname is missing');
  $firstname = preg_replace('/[^a-zA-Z]/', '', $_POST['firstname']);
  if ($firstname != $_POST['firstname']) $html .= err_msg('Firstname can only have letters');

  if (!isset($_POST['lastname'])) $html .= err_msg('Missing Lastname');
  $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
  if ($lastname == '') $html .= err_msg('Your Lastname is missing');
  $lastname = $_POST['lastname'];
  $lastname = preg_replace('/[^a-zA-Z]/', '', $_POST['lastname']);
  if ($lastname != $_POST['lastname']) $html .= err_msg('Lastname can only have letters');

  $email = isset($_POST['email']) ? $_POST['email'] : "";
  $valid_email = (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === FALSE);
  if (!$valid_email) $html .= err_msg('Your Email address looks funny');

  $password = isset($_POST['password']) ? $_POST['password'] : '';
  if (strlen($password) < 8) $html .= err_msg('Your password must be at least 8 characters long');
  if (strlen($password) > 32) $html .= err_msg('Your password must be less than 32 characters long');

  if ($html != '') return $html;

  $username = trim(strtolower("$firstname-$lastname"));

  $conn = jwrr_members_open_database($db_name);
  if ($conn == NULL) $html .= err_msg('Error 1');
  if ($html != '') return $html;

  $user_exists = jwrr_members_member_exists($conn, $username);
  if ($user_exists) $html .= err_msg('Sorry, we already have an account with your name');
  if ($html != '') return $html;

  // Insertion Query
  $query = "INSERT INTO `member` (username, password, email) VALUES(:username, :password, :email)";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':username', $username);
  
  $password_hash = password_hash($password, PASSWORD_DEFAULT);
  $stmt->bindParam(':password', $password_hash);
  $stmt->bindParam(':email', $email);

  $success = false;
  if ($stmt->execute()) {
    $html .= success_msg('Success! Your account has been created');
  } else {
    $html .= err_msg('Error 2');
  }
  return $html;
}

