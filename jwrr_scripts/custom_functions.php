<?php


function get_bloginfo($field)
{
  if ($field == 'name') return "Cat Artists";
  return "get_blockinfo field='$field'";
}



function get_slug()
{
  $p = $_SERVER['REQUEST_URI'];
  $larr = explode("/",$p);
  $slug = array_pop($larr);
  if ($slug == '' && count($larr) > 0) {
    $slug = array_pop($larr);
  }
  return $slug;
}
 


function get_page_title() {
  $slug = get_slug();
  $title = '';
  if (is_home_page()) {
    $title = "<title>" . get_bloginfo( 'name' ) . "</title>\n";
  } else {
    $title = "<title>" . "Cat Artists" . "</title>\n";
  }
  return $title;
}

