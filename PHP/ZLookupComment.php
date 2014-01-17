<?php
mb_language('uni');
mb_internal_encoding('UTF-8');
$lang = $_GET["lang"];if ($lang == "") $lang = "english";$type = $_GET["type"];
$name = $_GET["name"];
//$name = str_replace($name,"%27","'");
//$name = str_replace($name,"&#39;","'");
//$name = str_replace($name,"'","\'");

$MyPswd = file_get_contents("../js/temp.txt");
$MyPswd = str_replace("s","",str_replace("m88","",$MyPswd));
$DB_Connection = mysql_connect("localhost", "mackle2_lds", $MyPswd) or die (' I cannot connect to the database because: ' . $MyPswd . ' ' . mysql_error());
$result = mysql_query("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'",$DB_Connection);
mysql_select_db("mackle2_LDS");
if ($type == "type" || $name == "") {
  $comments = "";
} else {
  $sql = "SELECT CONVERT(comments USING utf8) As comments FROM Commentary WHERE language = '$lang' And type = '$type' And groupname = '$name'";
  //echo $sql;
  $result = mysql_query($sql,$DB_Connection);
  if ($row = mysql_fetch_object($result)) {
    $comments = $row->comments;
  } else {
    $comments = "";
  }
}
echo $comments;
?>