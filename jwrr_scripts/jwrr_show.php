<?php
/*
 Name: JWRR Show
 URI: https://github.com/wordpress-stuff/wp-content/plugins/jwrr-show-images
 Description: a plugin to show gallery of images in a page
 Version: 0.1
 Author: jwrr
 Author URI: http://jwrr.com
 License: MIT
*/



function jwrr_show_images($img='')
{
  $enable_style = false;
  $a = jwrr_parse_img_path($img);
  $artist_fullname_with_dash = $a['username'];
  
  $art_title = $a['title'];
  $artist_fullname_with_space = $a['fullname'];
  $logged_in_artist_fullname_with_dash = jwrr_session_username();
  $request_uri = $_SERVER['REQUEST_URI'];
  $is_owner = ($logged_in_artist_fullname_with_dash == $artist_fullname_with_dash);
  $art_delete = $is_owner && str_ends_with($request_uri, '/delete');
  $art_rename = $is_owner && str_ends_with($request_uri, '/rename');
  
  $hidden_art_path = jwrr_hidden_art_path();

  $orig_partial_path = "o/$artist_fullname_with_dash";
  $big_partial_path = "b/$artist_fullname_with_dash";
  $med_partial_path = "m/$artist_fullname_with_dash";
  $small_partial_path = "s/$artist_fullname_with_dash";
  $tile_partial_path = "t/$artist_fullname_with_dash";

  $orig_full_path = "$hidden_art_path/$orig_partial_path";
  $big_full_path = "$hidden_art_path/$big_partial_path";
  $med_full_path = "$hidden_art_path/$med_partial_path";
  $small_full_path = "$hidden_art_path/$small_partial_path";
  $tile_full_path = "$hidden_art_path/$tile_partial_path";

  $big_image_url = "$big_partial_path/$art_title.jpg";
  $med_image_url = "$med_partial_path/$art_title.jpg";
  $small_image_url = "$small_partial_path/$art_title.jpg";
  $small_tile_image_url = "$tile_partial_path/${art_title}_small.jpg";
  $med_tile_image_url = "$tile_partial_path/${art_title}_med.jpg";
  $big_tile_image_url = "$tile_partial_path/${art_title}_big.jpg";

  $orig_image_fullname = "$orig_full_path/$art_title.jpg";
  $big_image_fullname = "$big_full_path/$art_title.jpg";
  $med_image_fullname = "$med_full_path/$art_title.jpg";
  $small_image_fullname = "$small_full_path/$art_title.jpg";
  $small_tile_image_fullname = "$tile_full_path/${art_title}_small.jpg";
  $med_tile_image_fullname = "$tile_full_path/${art_title}_med.jpg";
  $big_tile_image_fullname = "$tile_full_path/${art_title}_big.jpg";

  $big_image_exists = file_exists($big_image_fullname);
  $img_html = '';
  $some_more = "some";
  $html = '';
  if ($big_image_exists) {
    if ($art_rename) {
      $newname = empty($_REQUEST['newname']) ? '' : $_REQUEST['newname'];
      $newname = jwrr_clean_title_lower($newname);
      if ($newname != '') {
        $newname_orig_image_fullname = "$orig_full_path/$newname.jpg";
        $newname_big_image_fullname = "$big_full_path/$newname.jpg";
        $newname_med_image_fullname = "$med_full_path/$newname.jpg";
        $newname_small_image_fullname = "$small_full_path/$newname.jpg";
        $newname_small_tile_image_fullname = "$tile_full_path/${newname}_small.jpg";
        $newname_med_tile_image_fullname = "$tile_full_path/${newname}_med.jpg";
        $newname_big_tile_image_fullname = "$tile_full_path/${newname}_big.jpg";
        rename($orig_image_fullname, $newname_orig_image_fullname);
        rename($big_image_fullname, $newname_big_image_fullname);
        rename($med_image_fullname, $newname_med_image_fullname);
        rename($small_image_fullname, $newname_small_image_fullname);
        if (file_exists($small_tile_image_fullname)) rename($small_tile_image_fullname, $newname_small_tile_image_fullname);
        if (file_exists($med_tile_image_fullname)) rename($med_tile_image_fullname, $newname_med_tile_image_fullname);
        if (file_exists($big_tile_image_fullname)) rename($big_tile_image_fullname, $newname_big_tile_image_fullname);
        $html .= "<h2>Page '$art_title' renamed to '$newname'</h2>";
      }
    }  else if ($art_delete) {
      unlink($orig_image_fullname);
      unlink($big_image_fullname);
      unlink($med_image_fullname);
      unlink($small_image_fullname);
      if (file_exists($small_tile_image_fullname)) unlink($small_tile_image_fullname);
      if (file_exists($med_tile_image_fullname)) unlink($med_tile_image_fullname);
      if (file_exists($big_tile_image_fullname)) unlink($big_tile_image_fullname);
      $html .= "<h2>Page '$art_title' deleted</h2>";
    } else if ($is_owner) {
      touch($orig_image_fullname);
      touch($big_image_fullname);
      touch($med_image_fullname);
      touch($small_image_fullname);
      if (file_exists($small_tile_image_fullname)) touch($small_tile_image_fullname);
      if (file_exists($med_tile_image_fullname)) touch($med_tile_image_fullname);
      if (file_exists($big_tile_image_fullname)) touch($big_tile_image_fullname);
    }
  }

  $background2 = "style=\"background-image:url('/cat-artwork/$med_image_url');background-repeat:repeat;padding-bottom:100em;\"";

  $background_style = <<<HD1
  <style>
    div.seamless {background-image:url('/cat-artwork/$med_tile_image_url');background-repeat:repeat;padding-bottom:100em;}
    @media(max-width: 800px) {div.seamless {background-image:url('/cat-artwork/$small_tile_image_url');}}
  </style>
HD1;


  $background = '';
  $tile_image_exists = file_exists($med_tile_image_fullname);
  if ($tile_image_exists) {
    $background = "style=\"background-image:url('/cat-artwork/$med_tile_image_url');background-repeat:repeat;padding-bottom:100em;@media(max-width: 600px) {background-image:url('/cat-artwork/$small_tile_image_url');}\"";
  }

  $buy_platform = "Zazzle";
  // ln -s wp-content/themes/catartists1 catartists1
  $home_page_uri = get_home_page_uri();
  $buy_platform_icon = "${home_page_uri}images/zazzle.png";
  $buy_url = "https://www.zazzle.com/store/rachel_armington_art/products";

  if ($big_image_exists) {
//     $big_image_url = str_replace('/', '/', $big_image_url);
//     $big_image_url = str_replace('.jpg', '', $big_image_url);
//     $img_html = '<img class="css-main-image" src="/catartists-images/' . $big_image_url . '.jpg">';

//     if (!jwrr_is_logged_in()) {
//       $big_image_fullname = str_replace('/b/' , '/m/', $big_image_fullname);
//     }

    $image_fullname = $med_image_fullname;
    if (jwrr_is_logged_in()) {
      $image_fullname = $big_image_fullname;
    };
    $lazy_loading = false;
    $img_html = jwrr_display_image($image_fullname, 'css-main-image', $buy_url, $lazy_loading);
    $some_more = "more";
  }
  
  $copyright = jwrr_copyright("2022", $artist_fullname_with_space);
  $buybar = jwrr_buybar($buy_platform, $buy_platform_icon, $buy_url);

  if ($art_delete || $art_rename || !$big_image_exists) {
    $big_image_html = '';
  } else {
    $big_image_html = "$buybar $img_html $copyright";
  }

  $more_art_by_artist_html = jwrr_get_art_by_artist($artist_fullname_with_dash, $copyright, "<h2>Here is $some_more of my art</h2>", 0);

  $html .= "\n\n<!-- show_images -->\n";

  $html .= <<<HEREDOC_DIV
  <div class="css-show-images-main">
    $big_image_html
    <hr>

    $more_art_by_artist_html
<div $background2></div>
$background_style
<div class="seamless"></div>
  </div>

<!-- end show_images -->

HEREDOC_DIV;

  return $html;
}

