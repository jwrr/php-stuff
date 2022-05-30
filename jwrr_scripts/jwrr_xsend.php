<?php
function jwrr_xsendfile($file='')
{
  $uri = trim($_SERVER['REQUEST_URI'], '/');
  $pieces = explode('/', $uri);
  if (count($pieces) != 4) return;
  if ($pieces[0] != 'catartists-images') return;

  $user = _wp_get_current_user();
  $is_logged_in = $user->exists();
  $art_path = '/' . basename(jwrr_hidden_art_path());
  $artist_name = preg_replace('/[^a-z0-9-]/', '-', $pieces[1]);
  $artwork_size = preg_replace('/[^a-z0-9]/', '', $pieces[2]);
  $artwork_name = preg_replace('/.jpg$/', '', $pieces[3]);
  $artwork_name = preg_replace('/[^a-z0-9-]/', '-', $artwork_name);
  $image_file = "$art_path/$artist_name/$artwork_size/$artwork_name.jpg";
  header('X-LiteSpeed-Location:' . $image_file);
  exit();
}

