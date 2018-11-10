#!/usr/bin/php
<?
$file_name = "iplschedule.csv";

//$fp = fopen('write.txt', 'w');

if (($handle = fopen($file_name, "r")) !== FALSE) {
while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
//echo $data[0] . " " . $data[1] . " "  .$data[2] ;
$newdate=$data[4]."-2018";
 $newstr = "insert into iplschedule (srno, team1, team2, matchdate, iplday) values ($data[0],'$data[1]','$data[2]',cast('$newdate' as date),$data[5]); \n";
echo $newstr;
 //$infos array containing comma separated values
//     fwrite($fp, $newstr);


//echo $newstr ;
//more code
}
fclose($handle);
}

// fclose($fp);
?>
