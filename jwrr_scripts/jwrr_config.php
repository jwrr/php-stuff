<?php


function get_home_page_uri()
{
  $uri = "/tst/";
  $uri = "/";
  return $uri;
}



function get_home_page_when_logged_in_uri()
{
  
  $uri = get_home_page_uri() . "b.php";
  return $uri;
}



function is_home_page()
{
  $uri = $_SERVER['REQUEST_URI'];
  $is_home_page = $uri == get_home_page_uri();
  return $is_home_page;
}



function is_home_page_when_logged_in()
{
  $uri = $_SERVER['REQUEST_URI'];
  $is_home_page_when_logged_in = str_contains($uri, get_home_page_when_logged_in_uri());
  return $is_home_page_when_logged_in;
}

