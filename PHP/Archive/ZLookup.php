<?php

$vol_id = $_GET["vol"];
$book_id = $_GET["book"];
$diag = $_GET["diag"];

function my_file_put_contents($filename, $data, $flags = 0, $f = FALSE) {
  if(($f===FALSE) && (($flags%2)==1)) $f=fopen($filename, 'a'); else if($f===FALSE) $f=fopen($filename, 'w');
  if(round($flags/2)==1) while(!flock($f, LOCK_EX)) { /* lock */ }
  if(is_array($data)) $data=implode('', $data);
  fwrite($f, $data);
  if(round($flags/2)==1) flock($f, LOCK_UN);
  fclose($f);
}
$MyPswd = file_get_contents("../js/temp.txt");
$MyPswd = str_replace("s","",str_replace("m88","",$MyPswd));
$DB_Connection = mysql_connect("localhost", "mackle2_lds", $MyPswd) or die (' I cannot connect to the database because: ' . $MyPswd . ' ' . mysql_error());
mysql_select_db("mackle2_LDS");

$sql  = "SELECT volume_title, num_chapters, book_title_long FROM lds_scriptures_books WHERE ";
$sql .= "volume_id = $vol_id And book_id = $book_id";
IF ($diag == "Y") echo "  ".$sql."  ";
$result = mysql_query($sql,$DB_Connection);

//$row->volume_title
//$row->book_title_long
//my_file_put_contents("sql.txt",$sql);
if ($row = mysql_fetch_object($result)) {
  $num_chapters = $row->num_chapters;
  $Header = $num_chapters."|".$row->volume_title."|".$row->book_title_long."|";
  $sql2 = "SELECT verse_id, volume_id, book_id, chapter, chapter_name, verse, verse_scripture, groupname FROM lds_scriptures_verses WHERE ";
  $sql2 .= "volume_id = $vol_id And book_id = $book_id ORDER BY chapter, verse";
//echo $sql;
  $result2 = mysql_query($sql2,$DB_Connection);
  $CurrChapter = "";
  IF ($diag == "Y") echo "  ".$sql2."  ";
  $BookCommentaryCnt = 0;
  $UniqueBookGroups = "";
  while ($row2 = mysql_fetch_object($result2)) {
    if ($row2->chapter != $CurrChapter) {
      $Chapters .= "^".$row2->chapter_name."~".$ChapterCommentaryCnt."~".$row2->volume_id."~".$row2->book_id."~".$row2->chapter."~~~";
      $CurrChapter = $row2->chapter;
      $ChapterCommentaryCnt = 0;
      $UniqueChapterGroups = "";
    }
    $VerseCommentary = "";
    $i = 0;
    $GroupName = explode(",",$row2->groupname);
    $VerseCommentary = "";
    while ($GroupName[$i] !== "" ) {
      if (!strstr($UniqueBookGroups." "," ".$GroupName[$i]." ")) {$BookCommentaryCnt++; $UniqueBookGroups.=" ".$GroupName[$i];}
      if (!strstr($UniqueChapterGroups." "," ".$GroupName[$i]." ")) {$ChapterCommentaryCnt++; $UniqueChapterGroups.=" ".$GroupName[$i];}
      $sql3 = "SELECT type FROM Commentary WHERE groupname = '$GroupName[$i]'";
      IF ($diag == "Y") echo "  ".$sql3."  ";
      $result3 = mysql_query($sql3,$DB_Connection);
      while ($row3 = mysql_fetch_object($result3)) {
        $VerseCommentary .= "~".substr($row3->type,0,1)."~".$GroupName[$i]."~".$row3->type."~";
      }
      $i++;
    }
    $Chapters .= "|".$row2->verse_id."~".$row2->verse."~".$row2->verse_scripture."~".$VerseCommentary;
  }
  //if ($i == 1) $SendData = $Chapters;
  $Chapters .= "^"."~".$ChapterCommentaryCnt;
}
$Header .= "|||".$BookCommentaryCnt."|";
echo $Header.$Chapters;

?>