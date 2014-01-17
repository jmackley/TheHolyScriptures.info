<?php
$cmd = $_GET["cmd"];
$OT = $_GET["OT"];
$NT = $_GET["NT"];
$BM = $_GET["BM"];
$DC = $_GET["DC"];
$PP = $_GET["PP"];
$diag = $_GET["diag"];
$limit = $_GET["limit"];
if ($limit == "" || $limit > 150) $limit=150;
$searchtype = $_GET["searchtype"];
//$searchwords = split('[+-()<>"*]', $cmd);
if ($searchtype == "") {
  if (strrpos($cmd,"%") > -1) {
   $searchtype = "LIKE";
  } else if (strrpos($cmd,"+") > -1 || strrpos($cmd,"-") > -1 || strrpos($cmd,"*") > -1 || strrpos($cmd,'"') > -1) {
   $searchtype = "BOOLEAN";
  } else if (strrpos($cmd,"+") > -1 || strrpos($cmd,"-") > -1 || strrpos($cmd,"*") > -1 || strrpos($cmd,'"') > -1) {
   $searchtype = "BOOLEAN";
  } else {
   $searchtype = "NATURAL";
  }
}
$searchwords = str_replace("+"," ",$cmd);
$searchwords = str_replace("-"," ",$searchwords);
$searchwords = str_replace("("," ",$searchwords);
$searchwords = str_replace(")"," ",$searchwords);
$searchwords = str_replace("<"," ",$searchwords);
$searchwords = str_replace(">"," ",$searchwords);
$searchwords = str_replace('"',' ',$searchwords);
$searchwords = str_replace("*"," ",$searchwords);
$searchwords = str_replace("\\","",$searchwords);
$searchwords = str_replace("  "," ",$searchwords);
$searchwords = str_replace("  "," ",$searchwords);
$searchwords = str_replace("  "," ",$searchwords);
$searchwords = trim($searchwords);
$MyPswd = file_get_contents("../js/temp.txt");
$MyPswd = str_replace("s","",str_replace("m88","",$MyPswd));
$DB_Connection = mysql_connect("localhost", "mackle2_lds", $MyPswd) or die (' I cannot connect to the database because: ' . $MyPswd . ' ' . mysql_error());
//$result = mysql_query("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'",$DB_Connection);
mysql_select_db("mackle2_LDS");
if ($OT == "yes") {$SelectOT = " Or volume_id = 1";} else {$SelectOT = "";}
if ($NT == "yes") {$SelectNT = " Or volume_id = 2";} else {$SelectNT = "";}
if ($BM == "yes") {$SelectBM = " Or volume_id = 3";} else {$SelectBM = "";}
if ($DC == "yes") {$SelectDC = " Or volume_id = 4";} else {$SelectDC = "";}
if ($PP == "yes") {$SelectPP = " Or volume_id = 5";} else {$SelectPP = "";}
$VolumeSelection = substr($SelectOT.$SelectNT.$SelectBM.$SelectDC.$SelectPP,4);
if ($searchtype == "BOOLEAN") {
  $sql  = "SELECT det.volume_id, det.book_id, det.verse_id, det.volume_title, det.book_title,";
  $sql .= " det.chapter, det.chapter_name, det.verse, det.verse_scripture, det.groupname, tot.relevance_score";
  $sql .= " FROM lds_scriptures_verses As det";
  $sql .= " INNER JOIN (SELECT chapter, SUM(MATCH (verse_scripture) AGAINST ('$cmd' IN BOOLEAN MODE)) relevance_score ";
  $sql .= "      FROM lds_scriptures_verses WHERE ($VolumeSelection)";
  $sql .= "      GROUP BY chapter) As tot";
  $sql .= " ON det.chapter = tot.chapter";
  $sql .= " WHERE ($VolumeSelection) And MATCH (verse_scripture) AGAINST ('$cmd' IN BOOLEAN MODE)";
  $sql .= " ORDER BY tot.relevance_score DESC, volume_id, book_id, chapter, verse LIMIT 0,150";
} else if ($searchtype == "EXPANSION") {
  $sql  = "SELECT det.volume_id, det.book_id, det.verse_id, det.volume_title, det.book_title,";
  $sql .= " det.chapter, det.chapter_name, det.verse, det.verse_scripture, det.groupname, tot.relevance_score";
  $sql .= " FROM lds_scriptures_verses As det";
  $sql .= " INNER JOIN (SELECT chapter, SUM(MATCH (verse_scripture) AGAINST ('$cmd' WITH QUERY EXPANSION)) relevance_score ";
  $sql .= "      FROM lds_scriptures_verses WHERE ($VolumeSelection)";
  $sql .= "      GROUP BY chapter) As tot";
  $sql .= " ON det.chapter = tot.chapter";
  $sql .= " WHERE ($VolumeSelection) And MATCH (verse_scripture) AGAINST ('$cmd' WITH QUERY EXPANSION)";
  $sql .= " ORDER BY tot.relevance_score DESC, volume_id, book_id, chapter, verse LIMIT 0,150";
} else if ($searchtype == "LIKE") {
  $sql  = "SELECT verse_id, volume_id, volume_title, book_id, book_title, chapter, chapter_name, verse, verse_scripture, groupname, ";
  $sql .= " '1' As relevance_score";
  $sql .= " FROM lds_scriptures_verses";
  $sql .= " WHERE groupname Like '$groupname,%'";
  $sql .= " ORDER BY volume_id, book_id, chapter, verse LIMIT 0,150";
} else {
  $sql  = "SELECT det.volume_id, det.book_id, det.verse_id, det.volume_title, det.book_title,";
  $sql .= " det.chapter, det.chapter_name, det.verse, det.verse_scripture, det.groupname, tot.relevance_score";
  $sql .= " FROM lds_scriptures_verses As det";
  $sql .= " INNER JOIN (SELECT chapter, SUM(MATCH (verse_scripture) AGAINST ('$cmd')) relevance_score ";
  $sql .= "      FROM lds_scriptures_verses WHERE ($VolumeSelection)";
  $sql .= "      GROUP BY chapter) As tot";
  $sql .= " ON det.chapter = tot.chapter";
  $sql .= " WHERE ($VolumeSelection) And MATCH (verse_scripture) AGAINST ('$cmd')";
  $sql .= " ORDER BY tot.relevance_score DESC, volume_id, book_id, chapter, verse LIMIT 0,150";
}
$result2 = mysql_query($sql,$DB_Connection);
$CurrVolume = "";
$CurrChapter = "";
$CurrBook = "";
IF ($diag == "Y") echo "  ".$sql."  ";
$BookCommentaryCnt = 0;
$cnt_chapters = 0;
$UniqueBookGroups = "";
$cnt_records = mysql_num_rows($result2);
if ($cnt_records > 0) {
  while ($row2 = mysql_fetch_object($result2)) {
    if ($cnt_chapters < 150) {
      //if ($row2->chapter != $CurrChapter || ($row2->volume_id == 4 && $row2->book_id != $CurrBook)) {
      if ($row2->chapter != $CurrChapter || $row2->book_id != $CurrBook || $row2->volume_id != $CurrVolume) {
        $Chapters .= "^".$row2->chapter_name."~".$ChapterCommentaryCnt."~".$row2->volume_id."~".$row2->book_id."~".$row2->chapter."~".$row2->volume_title."~".$row2->book_title."~";
        $CurrChapter = $row2->chapter;
        $ChapterCommentaryCnt = 0;
        $UniqueChapterGroups = "";
        $cnt_chapters++;
        if ($row2->book_id != $CurrBook || $row2->volume_id != $CurrVolume) {
          $CurrBook = $row2->book_id;
          $cnt_books++;
          if ($row2->volume_id != $CurrVolume) {
            $CurrVolume = $row2->volume_id;
            $cnt_volumes++;
          }
        }
      }
      $cnt_verses++;
      $VerseCommentary = "";
      $i = 0;
      $GroupName = explode(",",$row2->groupname);
      $VerseCommentary = "";
      while ($GroupName[$i] !== "" ) {
        if (!strstr($UniqueBookGroups." "," ".$GroupName[$i]." ")) {$BookCommentaryCnt++; $UniqueBookGroups.=" ".$GroupName[$i];}
        if (!strstr($UniqueChapterGroups." "," ".$GroupName[$i]." ")) {$ChapterCommentaryCnt++; $UniqueChapterGroups.=" ".$GroupName[$i];}
        $sql2 = "SELECT type FROM Commentary WHERE groupname = '$GroupName[$i]'";
        IF ($diag == "Y") echo "  ".$sql2."  ";
        $result3 = mysql_query($sql2,$DB_Connection);
        while ($row3 = mysql_fetch_object($result3)) {
          $VerseCommentary .= "~".substr($row3->type,0,1)."~".$GroupName[$i]."~".$row3->type."~";
        }
        $i++;
      }
      $Chapters .= "|".$row2->verse_id."~".$row2->verse."~".$row2->verse_scripture."~".$row2->relevance_score.$VerseCommentary;
    }
  }
  //if ($diag == "Y") echo "  ".$sql2."  ".$searchwords;
  if ($diag == "Y") echo "  ".$searchwords;
  $Header .= $cnt_chapters."|Search Results||".$cnt_volumes."|".$cnt_books."|".$cnt_chapters."|".$cnt_verses."|".$searchwords."|";
  if ($diag=="SQL") $Header.=$sql;
  $Chapters .= "^"."~".$ChapterCommentaryCnt."||||||||";
  echo $Header.$Chapters;
} else {
  echo "0";
  IF ($diag == "Y") echo "\n$cnt_verses\n".$searchwords;
  if ($diag=="SQL") echo "|Search Results|||||||".$sql."^";
}
?>