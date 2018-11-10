<?
date.timezone="UTC"
$ab=date_default_timezone_get();
date_default_timezone_set($ab);
$today=date("j:m");
echo "helo today is " . $today;
?>
