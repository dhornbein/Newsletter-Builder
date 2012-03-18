<?php

include('functions.inc.php');

define('TITLE', 'OWS Newsletter Draft');

$newWeek = 'Tue';

if(date('D',strtotime("-1 week")) == $newWeek )
{
  $weekDate = date('n-j-y');
} else {
  $weekDate = date('n-j-y',strtotime("last $newWeek"));
}

$startTime = date('U',strtotime("last $newWeek"));
$currentTime = date('U',time());
$endTime = date('U',strtotime("next $newWeek"));
$timeLeft = $endTime - $currentTime;
$timeElapst = $currentTime - $startTime;
$timeSpan = $endTime - $startTime;
$timeLeftPercent = ($timeLeft / $timeSpan) * 100;
$timeElapstPercent = ($timeElapst / $timeSpan) * 100;

#echo "$endTime - $currentTime = $timeLeft // $endTime - $startTime = $timeSpan // $currentTime - $startTime = $timeElapst // ($timeLeft / $timeSpan) * 100 = $timeLeftPercent // ($timeElapst / $timeSpan) * 100 = $timeElapstPercent";

  $defaultName = 'public user';
  $baseURL = 'http://notes.occupy.net/';
  $basePadName = 'newsletter_' . $weekDate ;
  $arguments = array(
    'showControls' => 'false',
    'showLineNumbers' => 'false',
    'showChat' => 'true',
    'useMonospaceFont' => 'false',
    'userName' => urlencode($defaultName),
    'noColors' => 'false'
    );
  
  $padURL = $baseURL . $basePadName . '?' . http_build_query($arguments);

  $display = "<iframe id='mainPad' src='$pad'>";


$api = file_get_contents('api');
$apiURL = $baseURL . 'api';
$pad = new pad($api,$apiURL);

try {
  $padContents = $pad->getHTML($basePadName);
  $out = $padContents->html;
} catch (Exception $e) {
  // the pad already exists or something else went wrong
  $out = "\n\ngetText Failed with message ". $e->getMessage();
}

/* Example: Get revisions Count of a pad */
try {
  $revisionCount = $pad->getRevisionsCount($basePadName);
  $revisionCount = $revisionCount->revisions;
  $revisions = "Pad has $revisionCount revisions";
} catch (Exception $e) {
  // the pad already exists or something else went wrong
  $revisions =  "\n\ngetRevisionsCount Failed with message ". $e->getMessage();
}

?>

<html>
<head>
  <title><?php echo TITLE; ?></title>
  <style type="text/css">
    #mainPad {width:100%;height:400px;}
    .htmlgrab textarea {width:98%}

    #time small {border-right:2px solid #ccc;padding:0 20px; float: right; text-align:right; margin-right:25%;}
    #timeRuler {background-color:#ccc; border-bottom:1px dashed #aaa; text-align:right; clear: right; height:20px; overflow: hidden;}
    #timeElapst {background-color:#fc0; border-bottom:1px solid #aaa; float:left; padding-right:1%; height:20px; width:<?php echo (round($timeElapstPercent, 2) - 1); ?>%;}
  </style>
</head>
<body>
  <h1><?php echo TITLE; ?></h1>
  <p>Current public working draft: [<?php echo $revisions ?>]</p>
  <div id="time">
    <small>Last call for revisions</small>
    <div id="timeRuler"><div id="timeElapst"><?php echo date('n/j',time()); ?></div><?php echo date('D n/j',strtotime("next $newWeek")); ?></div>
  </div>
  <div class="pad">

  <!-- start OWS NYCGA Header -->
  <div style="background-color:#eee;">
  <center>
    <!-- // Main body \\ -->
    <table border="0" cellpadding="10" cellspacing="0" width="100%">
      <tr>
        <td valign="top" align="center">
          <div style="
          color:#505050;
        font-family:Arial;
        font-size:10px;
        line-height:100%;
        text-align:center;">
             Your inbox: occupied. News and calls to action from #occupywallstreet in NYC.
          </div>
        </td>
      </tr>
    </table>
    <!-- // Begin Template Header \\ -->
    <table border="0" cellpadding="0" cellspacing="0" width="600" height="100" id="templateHeader" style="margin: 0 auto;">
        <tr>
            <td class="headerContent" style="
            background-color:#FC0;
            color:black;
            font-family:impact;
            font-size:24px;
            text-align:center;"><img src="http://www.nycga.net/files/2012/03/occupy_mail_header.jpg" id="headerImage" alt="#OccupyWallStreet >> New York City General Assembly" /></td>
        </tr>
    </table>
    <!-- // End Template Header \\ -->
    <!-- // Begin Template content \\ -->
    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContent" style="
background-color:white;
border-left: 1px solid #FFCC00;
border-right: 1px solid #FFCC00;
border-bottom: 10px solid #FFCC00;
color: #505050;
font-family: Arial;
line-height: 125%;
margin: 0 auto;
padding:10px;
text-align: left;">
      <tr>
          <td class="mainContent">
            <!-- End OWS NYCGA Header -->
            <!-- // Begin Body content \\ -->

            <?php echo $out; ?>

            <!-- // End Body content \\ -->
            <!-- Start OWS NYCGA Footer -->
          </td>
        </tr>
        <!-- // Start Footer content \\ -->
        <tr>
          <td style="
          font-size:12px;padding-top:24px;">
            <hr style="border-color:#fc0;border-style:solid;border-width:1px 0 0 0;" />
            <a href="{action.forward}" style="background-color:#FC0;Border:1px solid #EB0;border-radius:5px;color:black;padding:10px;float:right;margin:0 0 5px 5px;text-align:center;width:150px;">Forward to a Friend</a>
            <a href="https://www.wepay.com/xo71ir" style="background-color:#000;Border:1px solid #EB0;color:#FC0;border-radius:5px;padding:10px;float:right;margin:0 0 5px 5px;text-align:center;width:150px;clear:right;">Donate to OWS</a>
You are receiving this mail because you signed up for updates from Occupy Wall Street and/or signed up at <a href="https://www.nycga.net" target="_blank">NYCGA.net</a>.
<br />
            <br />
<a href="{action.unsubscribeUrl}">To unsubscribe from mailings on this <strong>topic</strong>.</a><br />
{domain.address}<br />
<br />
<div style="text-align:right;"><a href="{action.optOut}">Opt-out of all future mailings from us.</a></div>
        </td>
      </tr>
      <!-- // End Footer content \\ -->
    </table>
      <!-- // End Template content \\ -->
    <!-- // End Main body \\ -->
  </center>
  </div>
  <!-- End OWS NYCGA Footer -->
  </div>
  <div class="htmlgrab">
    <textarea readonly=readonly cols="30" rows="40"><?php echo $out; ?></textarea>
  </div>
</body>
</html>