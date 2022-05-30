<?php
/*
 Name: JWRR Breadcrumbs
 URI: http://jwrr.com/wp/plugins/jwrr_breadcrumbs
 Description: a plugin to create breadcrumbs for navigation
 Version: 0.1
 Author: jwrr
 Author URI: http://jwrr.com
 License: GPL3
*/

/**
 * Creates breadcrumbs navigation table
 *
 * @parameter bool $enable_echo Echo breadcrumbs when True.
 */
function jwrr_breadcrumbs(	$enable_echo = True,
				$css_id = "theme_breadcrumbs",
				$home_text = "Home",
				$indent_level = 2)
{
	$non_links = array('tag', 'category');
	$indent = str_repeat(' ', $indent_level);
	$html = "\n$indent<!-- plugin: jwrr_breadcrumbs -->\n" . 
		"$indent<ul id='theme_breadcrumbs'>\n";
	$uri = get_uri(); // format: /asdf/asdf/asdf/asdf/
	$uri_parts = explode("/",$uri); // first and last items are ''
	array_pop($uri_parts); // remove last item because it's ''
        $is_home = count($uri_parts) <= 1;
	if ($is_home) {
		$html .= "<li>&nbsp;</li>\n</ul>\n";
		if ($enable_echo) echo $html;
		return $html;
	}
	$anchor_link='';
	foreach ($uri_parts as $uri_part) {
		$anchor_link .= "$uri_part/";
		$is_first = $uri_part === reset($uri_parts);
		$is_last = $uri_part === end($uri_parts);
		$is_non_link  = in_array($uri_part, $non_links);
		$anchor_text = $is_first ? $home_text : $uri_part;
		$anchor_text = ucwords( str_replace('-', ' ', $anchor_text) );
		$anchor_text = str_replace(' A ', ' a ', $anchor_text);
		$anchor_text = str_replace(' The ', ' the ', $anchor_text);
		$separator = $is_first ? "" : " &nbsp;&#9656;&nbsp; ";
                $insert_anchor = !$is_last && !$is_non_link; 
		$html .= $indent;
		$html .=  $insert_anchor ?
		" <li>$separator<a href=\"$anchor_link\">$anchor_text</a></li>\n" :   
               	" <li>$separator$anchor_text</li>\n";
	}
	$html .= $indent . "</ul>\n\n";
	if ($enable_echo) echo $html;
	return $html;
}

function jwrr_uri()
{
	return $_SERVER['REQUEST_URI'];
}

