<?php
//mb_language('uni');
//mb_internal_encoding('UTF-8');
function GetTypes($GroupNames,$Connect,$lang) {
  $GroupName = explode(",",$GroupNames);
  $i = 0;
  while ($GroupName[$i] !== "" ) {
    //if (!strstr($UniqueBookGroups." "," ".$GroupName[$i]." ")) {$BookCommentaryCnt++; $UniqueBookGroups.=" ".$GroupName[$i];}
    //if (!strstr($UniqueChapterGroups." "," ".$GroupName[$i]." ")) {$ChapterCommentaryCnt++; $UniqueChapterGroups.=" ".$GroupName[$i];}
    $sql2 = "SELECT type FROM Commentary WHERE language = '$lang' And groupname = '$GroupName[$i]'";
    IF ($diag == "Y") echo "  ".$sql2."  ";
    $result2 = mysql_query($sql2,$Connect);
    while ($row2 = mysql_fetch_object($result2)) {
      $GroupTypes .= $GroupName[$i]."~".$row2->type."|";
    }
    $i++;
  }
  return $GroupTypes;
}
$lang = $_GET["lang"];
if ($lang == "") $lang = "english";
$diag = $_GET["diag"];
if ($diag == "Y") {
  $volume_id = $_GET["volume"];
  $book_id = $_GET["book"];
  $chapter = $_GET["chapter"];
} else {
  $volume_id = urldecode($_POST["volume"]);
  $book_id = urldecode($_POST["book"]);
  $chapter = urldecode($_POST["chapter"]);
}
$MyPswd = file_get_contents("../js/temp.txt");
$MyPswd = str_replace("s","",str_replace("m88","",$MyPswd));
$DB_Connection = mysql_connect("localhost", "mackle2_lds", $MyPswd) or die (' I cannot connect to the database because: ' . $MyPswd . ' ' . mysql_error());
mysql_select_db("mackle2_LDS");

$Chapter = "";
$sql = "SELECT verse_id, verse, verse_scripture, groupname FROM lds_scriptures_verses WHERE language = '$lang' And volume_id = $volume_id And book_id = $book_id And chapter = $chapter";
//echo $sql;
$result = mysql_query($sql,$DB_Connection);
while ($row = mysql_fetch_object($result)) {
  $Chapter .= "^".$row->verse_id."|".$row->verse."|".$row->verse_scripture."|".GetTypes($row->groupname,$DB_Connection,$lang);
}

echo $Chapter;

?>