<?php
/*
 Name: JWRR Social
 URI: http://jwrr.com/wp/plugins/jwrr_youtube
 Description: a plugin to create follow-me buttons for social media sites.
 Version: 0.1
 Author: jwrr
 Author URI: http://jwrr.com
 License: GPL3
*/

add_shortcode('jwrr-social', 'jwrr_social');
function jwrr_social()
{
	$theme_social_links = array(
		'Email'    =>  'mailto:rachelarmington@gmail.com',
		'Twitter'  => 'https://twitter.com/rachelarmington',
		'Instagram' =>'https://www.instagram.com/rachelarmington6052/?hl=en',
		'YouTube'  => 'https://www.youtube.com/channel/UCQ7Eosyn2nYbNbkokKrmPcw/videos', // https://www.youtube.com/channel/UCQ7Eosyn2nYbNbkokKrmPcw',
		'Amazon'   => 'https://www.amazon.com/Rachel-Armington/e/B015GRMR8O/ref=dp_byline_cont_book_1',
		'Facebook' => 'https://www.facebook.com/pages/Rachel-M-Brown-Paintings/1396112717307475',
		'Pinterest'=> 'https://www.pinterest.com/CatPaintings/',			
		'Zazzle'   => 'https://www.zazzle.com/rachel_armington_art',
	);

	$theme_social_titles = array(
		'Email' => "Send me an email",
		'Twitter'  => "My Tweets",
		'Instagram'=> "Comment on my photos on Instagram",
		'YouTube'  => 'See my tutorials on YouTube',
		'Amazon'   => "My Books on Amazon",
		'Facebook' => "Follow me on Facebook",
		'Pinterest'=> 'Pin me',			
		'Zazzle'   => 'My gift ideas at Zazzle',
	);

	$alt_text = 'Follow me on';
	$css_id = 'jwrr_social_left';
	$enable_echo = False;

	// DO NOT MODIFY BELOW
	if (count($theme_social_links)==0) return;
	$indent = str_repeat(' ', 1);

	$plugin_url = plugin_dir_url( __FILE__ );
	$plugin_url = preg_replace("/\/$/", '', $plugin_url);
	$plugin_images_url = "$plugin_url/images";

        $upload_dir = wp_upload_dir();
	$upload_path = $upload_dir['basedir'];
	$upload_url = $upload_dir['baseurl'];

	$images_url = $plugin_images_url;
	$html = "\n$indent<!-- plugin: jwrr_social -->\n" .
                "$indent<div id='$css_id'>\n" . 
                "$indent<g:plusone></g:plusone>\n" .
                "$indent <ul>\n";

        foreach ($theme_social_links as $key => $value) {
		$title_exists = array_key_exists($key, $theme_social_titles);
		$alt = $title_exists ? $theme_social_titles[$key] : "$alt_text $key";
		$image_name = str_replace(' ','-',strtolower($key)) . '.png';
		$uploaded_image = "$upload_path/$image_name";
		// $upload_image_path = find_file($upload_path, $image_name);
		$uploaded_image_exists = file_exists($uploaded_image);
		$images_url = $uploaded_image_exists ? $upload_url : $plugin_images_url;
		$img_url = "$images_url/$image_name";
		$html .= "$indent  <li><a href='$value' title='$alt'><img src='$img_url' alt='$alt'></a></li>\n";
	}
	$html .= "$indent </ul>\n$indent</div>\n\n";
	if ($enable_echo) echo $html;
	return $html;
}

function find_file($dir, $filename)
{
	$max = 5;
	$search = "$dir/*";
	$done = False;
	$i = 0;
	while (!$done) {
		$files = glob($search);
		$all_files = array_merge($all_files, $files);
		$search = "$search/*";
		$done = (count($files) == 0) || ($i >= $max);
		$i++;
	}
	$matches  = preg_grep ("/$filename$/", $haystack);
	$filepath = count($matches) ? $matches[0] : ''; 
	return $filepath;
}

