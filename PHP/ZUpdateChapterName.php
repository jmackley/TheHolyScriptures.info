<?php
//mb_language('uni');
//mb_internal_encoding('UTF-8');
$name = $_GET["name"];
$volume = $_GET["volume"];
$book = $_GET["book"];
$chapter = $_GET["chapter"];
$lang = $_GET["lang"];
if ($lang == "") $lang = "english";
$MyPswd = file_get_contents("../js/temp.txt");
$MyPswd = str_replace("s","",str_replace("m88","",$MyPswd));
$DB_Connection = mysql_connect("localhost", "mackle2_lds", $MyPswd) or die (' I cannot connect to the database because: ' . $MyPswd . ' ' . mysql_error());
//$result = mysql_query("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'",$DB_Connection);
//$result = mysql_query("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'",$DB_Connection);
mysql_select_db("mackle2_LDS");

///$sql = "UPDATE lds_scriptures_verses SET chapter_name = CONVERT('$name' USING utf8) WHERE language = '$lang' And volume_id = $volume And book_id = $book And chapter = $chapter";
$sql = "UPDATE lds_scriptures_verses SET chapter_name = '$name' WHERE language = '$lang' And volume_id = $volume And book_id = $book And chapter = $chapter";
//echo $sql;
$result = mysql_query($sql,$DB_Connection);
//echo $sql;
//echo $result;
 
?>