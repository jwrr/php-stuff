<?php
/*
 Name: JWRR Upload
 URI: https://github.com/wordpress-stuff/wp-content/plugins/jwrr-upload-form
 Description: a plugin to add an upload form to a page
 Version: 0.1
 Author: jwrr
 Author URI: http://jwrr.com
 License: MIT
*/

add_shortcode('jwrr_upload_form', 'jwrr_upload_form');

function jwrr_upload_form($atts = array(), $content = null, $tag = '')
{
  $MAX_IMAGES = 30;
  $upload_handler = "/upload-handler";
  $enable_style = false;
  $please_log_in_msg = "Please Log In";
  $select_file_msg = "Select file to upload";
  $num_images = jwrr_count_images();
  $limit_reached = $num_images >= $MAX_IMAGES;
  if ($limit_reached) {
    $html = "<h2 style='color:red;'>Congratulations! You have reached the Max File Quota</h2><div>You can't upload more files until we increase the quota or you delete some artwork.";
    return $html;
  }

  $html = "

<!-- upload-form -->";
  if ($enable_style) {
    $html .= <<<HEREDOC1
<style>
  input.css-upload-form_file {color:white;background-color:green; padding:0.5em; font-size:1.5em; border-radius:10px; width:75%;}
  div.css-upload-form h2 {margin:0; padding:0;}
  div.css-upload-form-please-log-in {font-size: 2.0em; font-weight:bold;margin:1em;}

  div.css-oneliner {padding: 1em 0 0 1em; font-size:1.5em;}
  div.css-oneliner label {display:block; margin-left:0.5em;}
  div.css-oneliner input[type=submit] {margin-left:0em; background-color:green; color:white;width:6em;}
  div.css-oneliner input {font-size:1.5em;border-color:gray;border-radius:10px;padding:0.3em;width:68%;}
  div.css-oneliner textarea {font-size:1.5em;border-color:gray;border-radius:10px;padding:0.3em;width:68%;}
  div.css-oneliner select {display:block; margin-left:0em; font-size:1.1em;border-color:gray;border-radius:10px;padding:0.3em;}
  div.css-checkboxes {display:block; margin-left:1.5em; font-size:1.5em;border-color:gray;border-radius:10px;padding:0.3em;}
  div.css-checkbox {display:inline; padding-right:3em;}
  div.css-checkbox input {width:2em; height: 2em;}
  .forgetmenot {margin:1em;}
</style>

HEREDOC1;
  }

  $user = _wp_get_current_user();
  $is_logged_in = $user->exists();
  if (!$is_logged_in) {
    $html .= "<div class=\"css-upload-form-please-log-in\">$please_log_in_msg</div>";
  } else {
    $html .= <<<HEREDOC2
  <div class="css-upload-form">
  <form action="$upload_handler" method="post" enctype="multipart/form-data">
      <div class=css-oneliner>
        <label for "upload_filename">$select_file_msg</label>
        <input class="css-upload-form_file" type="file" name="upload_filename" id="upload_filename">
        <input class="jwrr-submit" type="submit" value="Upload" name="submit">
      </div>
  </form>
  </div>

HEREDOC2;
  }

$save = <<<HEREDOC_SAVE
      <div class=css-oneliner>
        <label for="copyright">Choose a Copyright Notice:</label>
        <select class="css-upload-form_select" id="copyright" name="copyright">
          <option value="all" selected>All rights reserved</option>
          <option value="none">None</option>
          <option value="BY-NC-ND">BY-NC-ND Needs Attribution, non-commercial and no derivatives</option>
          <option value="BY-ND">BY-ND Needs Attribution and no derivatives</option>
          <option value="CC0">CC0 Free content with no restrictions</option>
        </select><br>
      </div>

      <div class=css-checkboxes>
        <div class="css-checkbox">
          <label>Add Watermark</label> <input type="checkbox" name="watermark" id="watermark" value="yes" checked="true">
        </div>
        <div class="css-checkbox">
          <label>Shred it like your cat would</label><input type="checkbox" name="shred" id="shred" value="yes" checked="true">
        </div>
      </div>

      <div class=css-oneliner>
      </div>
      <div class=css-oneliner>
        <label for="title">Title (Optional)</label>
        <input class="css-upload-form_title" type="text" name="title" id="title" cols="60" style="font-size:1.3em;"><br>
      </div>

      <div class=css-oneliner>
        <label for="description">Description (Optional))</label>
        <textarea name="description" id="description" cols="111" rows="10"></textarea><br>
      </div>
HEREDOC_SAVE;

  $html .= "
<!-- end upload-form -->

";

  return $html;
}


// ========================================================================
// ========================================================================


add_shortcode('jwrr_upload_handler', 'jwrr_upload_handler');

function jwrr_upload_handler()
{

  if (!jwrr_is_logged_in()) return "";
  if (!isset($_POST["submit"])) return "";

//  $username = jwrr_get_username();
  $username = jwrr_get_fullname('', '-');

  $hidden_art_path = jwrr_hidden_art_path();
  $orig_dir = "$hidden_art_path/o/$username/";
  $success = jwrr_mkdir($orig_dir);

  $upload_filename = htmlspecialchars($_FILES["upload_filename"]["name"]);
  $upload_filename = str_replace(' ', '-', $upload_filename);
  $orig_basename = jwrr_clean_filename_lower(basename($upload_filename));
  $orig_full_filename = $orig_dir . $orig_basename;
  $upload_good = 1;
  $upload_filetype = strtolower(pathinfo($orig_full_filename,PATHINFO_EXTENSION));
  $msg = "";
  $check = getimagesize($_FILES["upload_filename"]["tmp_name"]);
  if($check !== false) {
    $upload_good = 1;
  } else {
    $msg .= "Sorry, something looks wrong with the file.'";
    $upload_good = 0;
  }

  // Check if file already exists
  if (file_exists($orig_full_filename)) {
    $msg .=  "Sorry, the file already exists.";
    $upload_good = 0;
  }
  $max_file_size = 10000000;

  // Check file size
  if ($_FILES["upload_filename"]["size"] > $max_file_size) {
    $msg .= "Sorry, the file is too big. ";
    $upload_good = 0;
  }

  // Allow certain file formats
  if($upload_filetype != "jpg" ) {
    $msg .=  "Sorry, only JPG files are allowed (filetype is '$upload_filetype'). ";
    $upload_good = 0;
  }


  // Check if $upload_good is set to 0 by an error
  if ($upload_good == 0) {
    $msg .= "Sorry, your file was not uploaded. ";
echo $msg;
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["upload_filename"]["tmp_name"], $orig_full_filename)) {
       $big_dir = "$hidden_art_path/b/$username";
       $tile_dir = "$hidden_art_path/t/$username";
       $med_dir = "$hidden_art_path/m/$username";
       $small_dir = "$hidden_art_path/s/$username";
       jwrr_mkdir($big_dir);
       jwrr_mkdir($tile_dir);
       jwrr_mkdir($med_dir);
       jwrr_mkdir($small_dir);
       $qq = '65';
       exec("mogrify -strip -interlace Plane -resize 1024x -quality $qq -path $big_dir $orig_full_filename", $exec_output, $exec_retval);
       exec("mogrify -strip -interlace Plane -resize x440  -quality $qq -path $med_dir $orig_full_filename", $exec_output, $exec_retval);
       exec("mogrify -strip -interlace Plane -resize x200  -quality $qq -path $small_dir $orig_full_filename", $exec_output, $exec_retval);

$fullname = ucwords(jwrr_get_fullname());
$big_filename = $big_dir . '/' . basename($orig_full_filename);
$med_filename = $med_dir . '/' . basename($orig_full_filename);
$small_filename = $small_dir . '/' . basename($orig_full_filename);


$tile_filename = $tile_dir . '/' . basename($orig_full_filename);
$big_tile_filename = str_replace('.jpg', '_big.jpg', $tile_filename);
$med_tile_filename = str_replace('.jpg', '_med.jpg', $tile_filename);
$small_tile_filename = str_replace('.jpg', '_small.jpg', $tile_filename);


$watermark = <<<HEREDOC_WATERMARK1
convert -size 600x200 xc:none -pointsize 25 -font Helvetica-BoldOblique  \
-fill "#8003" -gravity NorthWest -draw "text 50,25 '$fullname'" \
-fill "#0883" -gravity Center -draw "text 1,1 '$fullname'" \
-fill "#8083" -gravity SouthEast -draw "text 50,25 '$fullname'" \
-background none -rotate -10  miff:- | \
composite -tile - $big_filename -quality 65 $big_filename
HEREDOC_WATERMARK1;
exec($watermark, $exec_output, $exec_retval);



// $watermark = <<<HEREDOC_WATERMARK1SMALL
// convert -size 350x200 xc:none -pointsize 20 -font Helvetica-BoldOblique  \
// -fill "#8003" -gravity NorthWest -draw "text 0,0 '$fullname'" \
// -fill "#0803" -gravity Center -draw "text 0,0 '$fullname'" \
// -fill "#0083" -gravity SouthEast -draw "text 0,0 '$fullname'" \
// -background "#8888" -rotate -10  miff:- | \
// composite -tile - $small_filename -quality 65 $small_filename
// HEREDOC_WATERMARK1SMALL;
// exec($watermark, $exec_output, $exec_retval);


$watermark = <<<HEREDOC_WATERMARKMED
convert -size 350x200 xc:none -pointsize 20 -font Helvetica-BoldOblique  \
-fill "#8003" -gravity NorthWest -draw "text 0,0 '$fullname'" \
-fill "#0803" -gravity Center -draw "text 0,0 '$fullname'" \
-fill "#0083" -gravity SouthEast -draw "text 0,0 '$fullname'" \
-background none -rotate -10  miff:- | \
composite -tile - $med_filename -quality 65 $med_filename
HEREDOC_WATERMARKMED;
exec($watermark, $exec_output, $exec_retval);


$watermark = <<<HEREDOC_WATERMARK1SMALL
convert -size 350x200 xc:none -pointsize 20 -font Helvetica-BoldOblique  \
-fill "#8003" -gravity NorthWest -draw "text 0,0 '$fullname'" \
-fill "#0803" -gravity Center -draw "text 0,0 '$fullname'" \
-fill "#0083" -gravity SouthEast -draw "text 0,0 '$fullname'" \
-background none -rotate -10  miff:- | \
composite -tile - $small_filename -quality 65 $small_filename
HEREDOC_WATERMARK1SMALL;
exec($watermark, $exec_output, $exec_retval);


$watermark = <<<HEREDOC_WATERMARK2
convert -size 1024x100 xc:none -pointsize 60 -font Helvetica-BoldOblique -undercolor '#0006' \
-fill "#fff6" -gravity North -annotate 0 '.                        $fullname                        .' \
 miff:- | composite - $big_filename $big_filename
HEREDOC_WATERMARK2;
exec($watermark, $exec_output, $exec_retval);


$tile = <<<HEREDOCTILE
gimp -i -b '(seamless "$big_filename" "$big_tile_filename")' -b '(gimp-quit 0)'
HEREDOCTILE;
exec($tile, $exec_output, $exec_retval);

$tile = <<<HEREDOCTILE
gimp -i -b '(seamless "$med_filename" "$med_tile_filename")' -b '(gimp-quit 0)'
HEREDOCTILE;
exec($tile, $exec_output, $exec_retval);

$tile = <<<HEREDOCTILE
gimp -i -b '(seamless "$small_filename" "$small_tile_filename")' -b '(gimp-quit 0)'
HEREDOCTILE;
exec($tile, $exec_output, $exec_retval);

       $orig_basename = str_replace('.jpg', '', $orig_basename);
       $img_url = "/b/$username/$orig_basename";
       $html = jwrr_show_images($img_url);
       return $html;
    }
  }
  return "";
 }

