<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function db_member_open_database($db_name='db', $db_folder='')
{

  if ($db_folder == '') {
    $db_folder =  realpath($_SERVER['DOCUMENT_ROOT'] . "/..") . "/db";
  } else {
    $db_folder = realpath($db_folder);
  }

  $db_fullpath = "$db_folder/$db_name.sqlite3";
  $db_fullname = "sqlite:$db_fullpath";

  // make folder if it doesn't exist
  if (!file_exists($db_folder)) {
    mkdir($db_folder, 0777, true);
  }

  // if the folder still doesn't exist then abort
  if (!file_exists($db_folder)) {
    return NULL;
  }

  if (is_file($db_fullpath)) {
    $pdo = new PDO($db_fullname);
    return $pdo;
  } 

  // make the database file since it doesn't exist
  file_put_contents($db_fullpath, NULL);

  // if database file still doesn't exist then abort
  if (!is_file($db_fullpath)) {
    return NULL;
  }

  try {
    $pdo = new PDO($db_fullname);
  } catch (PDOException $e) {
    return NULL;
  }

  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $query = "CREATE TABLE IF NOT EXISTS member(mem_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username TEXT, password TEXT, firstname TEXT, lastname TEXT)";
  $pdo->exec($query);

  return $pdo;
}


function db_member_join_request($conn)
{
  // Setting variables
  $username = $_POST['username'];
  $password = $_POST['password'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  
  // Insertion Query
  $query = "INSERT INTO `member` (username, password, firstname, lastname) VALUES(:username, :password, :firstname, :lastname)";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':password', $password);
  $stmt->bindParam(':firstname', $firstname);
  $stmt->bindParam(':lastname', $lastname);
  
  // Check if the execution of query is success
  if($stmt->execute()){
    //setting a 'success' session to save our insertion success message.
      $_SESSION['success'] = "Successfully created an account";
  
    //redirecting to the index.php
    header('location: index.php');
  }
}


function db_member_signin_request($conn)
{
  // Setting variables
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  // Select Query for counting the row that has the same value of the given username and password. This query is for checking if the access is valid or not.
  $query = "SELECT COUNT(*) as count FROM `member` WHERE `username` = :username AND `password` = :password";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':password', $password);
  $stmt->execute();
  $row = $stmt->fetch();
  
  $count = $row['count'];
  if($count > 0) {
    header('location:index.php');
  } else {
    $_SESSION['error'] = "Invalid username or password";
    header('location:index.php?do=signin');
  }
}


