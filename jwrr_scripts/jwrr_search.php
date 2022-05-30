<?php
/*
 Name: JWRR Search Form
 URI: https://github.com/wordpress-stuff/wp-content/plugins/jwrr-search
 Description: a plugin to add an search form to a page
 Version: 0.1
 Author: jwrr
 Author URI: http://jwrr.com
 License: MIT
*/


function jwrr_search_form($atts = array(), $content = null, $tag = '')
{
  $search_handler = get_home_page_uri();
  $enable_style = false;

  $html = "

<!-- search-form -->";
  if ($enable_style) {
    $html .= <<<HEREDOC1

  <style>
  input.css-search-form-file {color:white;background-color:green; padding:0.5em; font-size:1.5em; border-radius:10px; width:75%;}
  input.css-search-form-submit  {color:white;background-color:green; padding:0.6em; font-size:1.5em; border-radius:10px;}
  div.css-search-form {margin-left:auto; margin-right: auto;text-align:center;}
  div.css-search-form h2 {margin:0; padding:0;}
  div.css-search-form-please-log-in {font-size: 2.0em; font-weight:bold;margin:1em;}
  </style>

HEREDOC1;
  }

  $search_string = get_post_search_string();
  $value = ($search_string == '') ? '' : "value=\"$search_string\"'";

  $html .= <<<HEREDOC2
  <div class="css-search-form">
  <form action="$search_handler" method="post">
    <input class="css-search-form-file" type="search" placeholder="Search" $value name="artsearch" id="artsearch">
    <input class="css-search-form-submit" type="submit" value="Art Search" name="submit">
  </form>
  </div>

HEREDOC2;

  $html .= "
<!-- end search-form -->

";

  return $html;
}

