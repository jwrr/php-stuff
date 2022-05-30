<?php

function jwrr_sendfile($file='')
{
  
  if ($file == '' && !empty($_REQUEST['catart'])) {
    $file = $_REQUEST['catart'];
  }

  if ($file == '') return;

  $mime = 'video/mp4';
  $mime = 'image/jpeg';
  header('X-LiteSpeed-Location:' . $file);
  exit();
}


