<?php
mb_language('uni');
mb_internal_encoding('UTF-8');
$diag = $_GET["diag"];
if ($diag == "Y") {
  $type = $_GET["type"];
  $name = $_GET["name"];
  $comment = $_GET["comment"];
  $id = $_GET["id"];
  $cmd = $_GET["cmd"];
  $lang = $_GET["lang"];
  if ($lang == "") $lang = "english";
} else {
  $type = urldecode($_POST["type"]);
  $name = urldecode($_POST["name"]);
  $comment = trim(urldecode($_POST["comment"])); // decode for unicode
  $id = urldecode($_POST["id"]);
  $cmd = urldecode($_POST["cmd"]);
  $lang = urldecode($_POST["lang"]);
  if ($lang === "") $lang = "english";
}
$MyPswd = file_get_contents("../js/temp.txt");
$MyPswd = str_replace("s","",str_replace("m88","",$MyPswd));
$DB_Connection = mysql_connect("localhost", "mackle2_lds", $MyPswd) or die (' I cannot connect to the database because: ' . $MyPswd . ' ' . mysql_error());
$result = mysql_query("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'",$DB_Connection);
mysql_select_db("mackle2_LDS");

if ($cmd == "insert") {
  $sql = "UPDATE lds_scriptures_verses SET groupname = CONCAT(groupname,'$name,') WHERE verse_id In ($id) And groupname Not Like '%$name,%';";
  if ($diag == "Y") { echo $sql."   ";}
  $result = mysql_query($sql,$DB_Connection);
  if ($comment <> "") {
    $sql  = "INSERT INTO Commentary (groupname, type, comments) ";
    $sql .= "VALUES ('$name', '$type', CONVERT('$comment' USING utf8)) ";
    if ($diag == "Y") { echo $sql." \n";}
    //$sql .= "ON DUPLICATE KEY UPDATE ";
    //$sql .= "groupname = '$name', ";
    //$sql .= "type = '$type', ";
    //$sql .= "comments = CONVERT('$comment' USING utf8); ";
    $result = mysql_query($sql,$DB_Connection);
  }
  $sql = "SELECT comments FROM Commentary WHERE language = '$lang' And groupname = '$name' And type = '$type';";
} else if ($cmd == "remove") {
  $sql = "UPDATE lds_scriptures_verses SET groupname = REPLACE(groupname,'$name,','') WHERE verse_id = $id";
} else if ($cmd == "append") {
  $sql = "UPDATE Commentary set comments = concat(comments, CONVERT('$comment' USING utf8)) WHERE language = '$lang' And type = '$type' And groupname = '$name'";
} else {
  $sql = "UPDATE Commentary set comments = CONVERT('$comment' USING utf8) WHERE language = '$lang' And type = '$type' And groupname = '$name'";
}
//sSql = "DELETE FROM Commentary WHERE groupname = groupname = '$name' And type = '$type'";
//echo "cmd=".$cmd;
//echo "type=".$type;
//echo $cmd."-<br>";
//
//echo $sql;
if ($diag == "Y") {
 echo $sql."   ";
 echo $type." ".$name." ".$comment."   ";
}
$result = mysql_query($sql,$DB_Connection);
if ($cmd == "insert") {
  $row = mysql_fetch_object($result);
  echo $row->comments;
} else {
  echo $result;
}

?>