#!/usr/bin/php
<?
require_once '../LeagueFunctions.php';
//leagueCleanUp("dumbo");
echo "calling league exists func";
$retVal = findLeagueExists("dumbo");
echo $retVal;
if ($retVal=="good to go , leaguename is new, proceed to add") {
  insertNewLeague("dumbo","avadhut");
  echo " inserted the league";
}
echo $retVal;

?>
