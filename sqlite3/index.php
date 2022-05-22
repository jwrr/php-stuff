<?php


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

$html_home_page .= <<<HEREDOC_HOME_PAGE
<h3>Home Page</h3>
<hr>
<a href="index.php?do=join">Join</a> |
<a href="index.php?do=signin">Sign In</a>
HEREDOC_HOME_PAGE;

$html_home_page .= home_footer();

return $html_home_page;
} // home_page


function home_pagexxxx()
{
$html_home_page = <<<HEREDOC_HOME_PAGE
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
</head>
<body>
<h3 class="text-primary">Home Page</h3>
<hr style="border-top:1px dotted #ccc;"/>
<a href="index.php?do=join"> Join</a> |
<a href="index.php?do=signin"> Sign In</a>
</body>
</html>
HEREDOC_HOME_PAGE;
return $html_home_page;
} // home_page


// ============================================================================
// ============================================================================


session_start();
if (ISSET($_SESSION['success'])) {
  unset($_SESSION['success']);
}

if (ISSET($_REQUEST['do'])) {
  require_once 'db_member.php';
  $conn = db_member_open_database('db_member');

  if ($_REQUEST['do'] == 'signin_request') {
    db_member_signin_request($conn);
    exit;
  } else if ($_REQUEST['do'] == 'join_request') {
    db_member_join_request($conn);
    exit;
  } else if ($_REQUEST['do'] == 'signin') {
    $html = signin_form();
  } else if ($_REQUEST['do'] == 'join') {
    $html = join_form();
  }
} else {
  $html = home_page();
}

echo $html;


