<?php
//mb_language('uni');
//mb_internal_encoding('UTF-8');
$title = $_GET["title"];
$volume = $_GET["volume"];
$book = $_GET["book"];
$chapter = $_GET["chapter"];
$verse = $_GET["verse"];
$lang = $_GET["lang"];
if ($lang == "") $lang = "english";
$MyPswd = file_get_contents("../js/temp.txt");
$MyPswd = str_replace("s","",str_replace("m88","",$MyPswd));
$DB_Connection = mysql_connect("localhost", "mackle2_lds", $MyPswd) or die (' I cannot connect to the database because: ' . $MyPswd . ' ' . mysql_error());
//$result = mysql_query("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'",$DB_Connection);
mysql_select_db("mackle2_LDS");
$compare = $title."|".$volume."|".$book."|".$chapter."|".$verse;
$sql = "UPDATE lds_scriptures_verses SET compare_verse = '$compare' WHERE language = '$lang' And volume_id = $volume And book_id = $book And chapter = $chapter and verse = $verse";
echo $sql;
//$result = mysql_query($sql,$DB_Connection);
echo $result;
//ZUpdateCompareVerse.php?title=2 Nephi&volume=3&book=2&chapter=7&verse=14
?>