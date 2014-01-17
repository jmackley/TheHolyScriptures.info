<?php
$groupname = $_GET["name"];
$diag = $_GET["diag"];
$searchtype = $_GET["searchtype"];
$MyPswd = file_get_contents("../js/temp.txt");
$MyPswd = str_replace("s","",str_replace("m88","",$MyPswd));
$DB_Connection = mysql_connect("localhost", "mackle2_lds", $MyPswd) or die (' I cannot connect to the database because: ' . $MyPswd . ' ' . mysql_error());
//$result = mysql_query("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'",$DB_Connection);
mysql_select_db("mackle2_LDS");
$sql = "SELECT keywords FROM Commentary WHERE groupname = '$groupname'";
IF ($diag == "Y") echo "  ".$sql."           "; 
$result = mysql_query($sql,$DB_Connection);
$keywords = mysql_result($result, 0);
IF ($diag == "Y") echo "     ---------k=".$keywords." ------------  "; 
if ($searchtype == "LIKE") {
  $sql  = "SELECT verse_id, volume_id, volume_title, book_id, book_title, chapter, chapter_name, verse, verse_scripture, groupname, ";
  $sql .= "'1' As relevance_score ";
  $sql .= "FROM lds_scriptures_verses ";
  $sql .= "WHERE groupname Like '$groupname,%' ";
  $sql .= "GROUP BY volume_id,chapter ORDER BY relevance_score DESC, volume_id, book_id, chapter, verse LIMIT 0,150";
} else if ($searchtype == "BOOLEAN") {
  $sql  = "SELECT det.volume_id, det.book_id, det.verse_id, det.volume_title, det.book_title,";
  $sql .= " det.chapter, det.chapter_name, det.verse, det.verse_scripture, det.groupname, tot.relevance_score";
  $sql .= " FROM lds_scriptures_verses As det";
  $sql .= " INNER JOIN (SELECT chapter, SUM(MATCH (verse_scripture) AGAINST ('".$keywords."' IN BOOLEAN MODE)) relevance_score ";
  $sql .= "      FROM lds_scriptures_verses WHERE groupname Like '%$groupname,%'";
  $sql .= "      GROUP BY chapter) As tot";
  $sql .= " ON det.chapter = tot.chapter";
  $sql .= " WHERE groupname Like '%$groupname,%'";
  $sql .= " ORDER BY tot.relevance_score DESC, volume_id, book_id, chapter, verse LIMIT 0,150";
} else if ($searchtype == "EXPANSION") {
  $sql  = "SELECT det.volume_id, det.book_id, det.verse_id, det.volume_title, det.book_title,";
  $sql .= " det.chapter, det.chapter_name, det.verse, det.verse_scripture, det.groupname, tot.relevance_score";
  $sql .= " FROM lds_scriptures_verses As det";
  $sql .= " INNER JOIN (SELECT chapter, SUM(MATCH (verse_scripture) AGAINST ('".$keywords."' WITH QUERY EXPANSION)) relevance_score ";
  $sql .= "      FROM lds_scriptures_verses WHERE groupname Like '%$groupname,%'";
  $sql .= "      GROUP BY chapter) As tot";
  $sql .= " ON det.chapter = tot.chapter";
  $sql .= " WHERE groupname Like '%$groupname,%'";
  $sql .= " ORDER BY tot.relevance_score DESC, volume_id, book_id, chapter, verse LIMIT 0,150";
  //$sql  = "SELECT verse_id, volume_id, volume_title, book_id, book_title, chapter, chapter_name, verse, verse_scripture, groupname, ";
  //$sql .= "SUM((MATCH (verse_scripture) AGAINST ('$keywords' WITH QUERY EXPANSION))) As relevance_score ";
  //$sql .= "FROM lds_scriptures_verses ";
  //$sql .= "WHERE groupname Like '$groupname,%' ";
  //$sql .= "GROUP BY volume_id,chapter ORDER BY relevance_score DESC, volume_id, book_id, chapter, verse LIMIT 0,150";
} else if ($searchtype == "NATURAL" || $searchtype == "") {
  $sql  = "SELECT det.volume_id, det.book_id, det.verse_id, det.volume_title, det.book_title,";
  $sql .= " det.chapter, det.chapter_name, det.verse, det.verse_scripture, det.groupname, tot.relevance_score";
  $sql .= " FROM lds_scriptures_verses As det";
  $sql .= " INNER JOIN (SELECT chapter, SUM(MATCH (verse_scripture) AGAINST ('".$keywords."')) relevance_score ";
  $sql .= "      FROM lds_scriptures_verses WHERE groupname Like '%$groupname,%'";
  $sql .= "      GROUP BY chapter) As tot";
  $sql .= " ON det.chapter = tot.chapter";
  $sql .= " WHERE groupname Like '%$groupname,%'";
  $sql .= " ORDER BY tot.relevance_score DESC, volume_id, book_id, chapter, verse LIMIT 0,150";
}
IF ($diag == "Y") echo "  ".$sql; 
//FLUSH QUERY CACHE;
$CurrVolume = "";
$CurrChapter = "";
$CurrBook = "";
$BookCommentaryCnt = 0;
$cnt_chapters = 0;
$UniqueBookGroups = "";
$result = mysql_query($sql,$DB_Connection);
if ($result) {
  $cnt_records = mysql_num_rows($result);
} else {
  $cnt_records = 0;
}
if ($cnt_records > 0) {
  while ($row = mysql_fetch_object($result)) {
    if ($cnt_chapters < 150) {
      //echo "****".$CurrChapter."/".$row->chapter." ".$CurrBook."/".$row->book_id." ".$CurrVolume."/".$row->volume_id."*";
      if ($row->chapter != $CurrChapter || $row->book_id != $CurrBook || $row->volume_id != $CurrVolume) {
        $Chapters .= "^".$row->chapter_name."~".$ChapterCommentaryCnt."~".$row->volume_id."~".$row->book_id."~".$row->chapter."~".$row->volume_title."~".$row->book_title."~";
        $CurrChapter = $row->chapter;
        $ChapterCommentaryCnt = 0;
        $UniqueChapterGroups = "";
        $cnt_chapters++;
        if ($row->book_id != $CurrBook || $row->volume_id != $CurrVolume) {
          $CurrBook = $row->book_id;
          $cnt_books++;
          if ($row->volume_id != $CurrVolume) {
            $CurrVolume = $row->volume_id;
            $cnt_volumes++;
          }
        }
      }
      $cnt_verses++;
      $VerseCommentary = "";
      $i = 0;
      $GroupName = explode(",",$row->groupname);
      $VerseCommentary = "";
      while ($GroupName[$i] !== "" ) {
        if (!strstr($UniqueBookGroups." "," ".$GroupName[$i]." ")) {$BookCommentaryCnt++; $UniqueBookGroups.=" ".$GroupName[$i];}
        if (!strstr($UniqueChapterGroups." "," ".$GroupName[$i]." ")) {$ChapterCommentaryCnt++; $UniqueChapterGroups.=" ".$GroupName[$i];}
        $sql2 = "SELECT type FROM Commentary WHERE groupname = '$GroupName[$i]'";
        IF ($diag == "Y") echo "  ".$sql3."  ";
        $result2 = mysql_query($sql2,$DB_Connection);
        while ($row2 = mysql_fetch_object($result2)) {
          $VerseCommentary .= "~".substr($row2->type,0,1)."~".$GroupName[$i]."~".$row2->type."~";
        }
        $i++;
      }
      $Chapters .= "|".$row->verse_id."~".$row->verse."~".$row->verse_scripture."~".$row->relevance_score.$VerseCommentary;
    }
  }
  //if ($diag == "Y") echo "  ".$sql3."  ".$searchwords;
  if ($diag == "Y") echo "  ".$searchwords;
  $Header .= $cnt_chapters."|Commentary Results||".$cnt_volumes."|".$cnt_books."|".$cnt_chapters."|".$cnt_verses."|".$searchwords."|";
  if ($diag=="SQL") $Header.=$sql;
  $Chapters .= "^"."~".$ChapterCommentaryCnt."||||||||";
  echo $Header.$Chapters;
} else {
  echo "0";
  IF ($diag == "Y") echo "\n$cnt_verses\n".$searchwords;
  if ($diag=="SQL") echo "|Commentary  Results|||||||".$sql."^";
}
mysql_close($DB_Connection);
?>