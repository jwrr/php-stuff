<?php

// members.db
// member_idx, first-last, email

// links.db
// member_idx, page, url, description

// pabe.db
// member_idx, page, url, title, h1, h2, h3, meta, description




// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once('jwrr_session.php');

function jwrr_members_open_database($db_name='db', $db_folder='')
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
  $query = "CREATE TABLE IF NOT EXISTS member(id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username TEXT, password TEXT, email TEXT)";
  $pdo->exec($query);
  return $pdo;
}


function jwrr_members_member_exists($conn, $username)
{
  $query = "SELECT COUNT(*) as count FROM `member` WHERE `username` = :username";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  $row = $stmt->fetch();
  $count = $row['count'];
  return ($count > 0);
}



