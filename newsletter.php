<?php

define('TITLE', 'OWS Newsletter Draft');

$newWeek = 'Tue';

if(date('D',strtotime("-1 week")) == $newWeek )
{
  $weekDate = date('n-j-y');
} else {
  $weekDate = date('n-j-y',strtotime("last $newWeek"));
}
  

  $defaultName = 'public user';
  $baseURL = 'http://notes.occupy.net/p/';
  $basePadName = 'newsletter_' . $weekDate ;
  $arguments = array(
    'showControls' => 'false',
    'showLineNumbers' => 'false',
    'showChat' => 'true',
    'useMonospaceFont' => 'false',
    'userName' => urlencode($defaultName),
    'noColors' => 'false'
    );
  
  $pad = $baseURL . $basePadName . '?' . http_build_query($arguments);

  $display = "<iframe id='mainPad' src='$pad'>";
?>

<!DOCTYPE>
<html>
<head>
  <title><?php echo TITLE; ?></title>
  <style type="text/css">
    #mainPad {width:100%;height:400px;}
  </style>
</head>
<body>
  <h1><?php echo TITLE; ?></h1>
  <p>Current public working draft</p>
  <?php echo $display . "\n"; ?>
</body>
</html>