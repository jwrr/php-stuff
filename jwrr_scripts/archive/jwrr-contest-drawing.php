<?php
/*
 Name: JWRR Contest Drawing
 URI: http://jwrr.com/wp/plugins/jwrr-contest-drawing
 Description: a plugin to randomly select drawing winners
 Version: 0.1
 Author: jwrr
 Author URI: http://jwrr.com
 License: GPL3
*/

add_shortcode('contest', 'jwrr_contest_drawing');

function jwrr_contest_drawing($atts = array(), $content = null, $tag = '')
{
	extract( shortcode_atts( array('date' => 'undefined', 'winners' => 1, 'contestants' => 10, 'url' => '/contests/enter'), $atts ) );
	$num_winners = $winners;
	$num_contestants = $contestants;
	$drawing_date = $date;
	$signup_url = $url;
	$today = date("Y-m-d");
	if ($today < $drawing_date) {
		$html = "<p>The drawing ends soon. <a href='$signup_url'>Enter now!</a></p>";
		return $html;
	}
	$url = get_permalink();   // $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	$seed_string = "$url$num_contestants";
	$seed = sha1($seed_string,$true);
	srand($seed);
	$winners = array();
	$i = 0;
	while ($i < $num_winners) {
		$w = rand() % $num_contestants;
		if (in_array($w, $winners)) continue;
		$winners[$i] = $w;
		$i++;
	}
	$s = ($num_winners > 1) ? 's are' : ' is';
	$html = "<p>The winner$s: ";
	for ($i=0; $i<$num_winners; $i++) {
		$punc = ($i == $num_winners - 1) ? '!!!' : ', ';
		$html .= $winners[$i]+1 . $punc;
	}
	$html .= "</p>\n<p>Don't miss the next drawing. <a href='$signup_url'>Enter now!</a></p>";
	
	return $html;
}

