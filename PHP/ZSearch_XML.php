<?php
header("Content-Type: text/xml");
$lang = $_GET["lang"];
if ($lang == "") $lang = "english";
$cmd = $_GET["cmd"];
$OT = $_GET["OT"];
$NT = $_GET["NT"];
$BM = $_GET["BM"];
$DC = $_GET["DC"];
$PP = $_GET["PP"];
$SS = $_GET["SS"];
$diag = $_GET["diag"];
$limit = $_GET["limit"];
$type = $_GET["type"];
if ($type == "") $type = "find";
$detail_level = $_GET["detail"];
if ($limit == "" || $limit > 150) $limit=150;
if ($detail_level === "") $detail_level=1;
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
$VolumeSelection = $SelectOT.$SelectNT.$SelectBM.$SelectDC.$SelectPP;
if (strlen($VolumeSelection) > 4) {
  $VolumeSelection = substr($VolumeSelection,4);
} else {
  $VolumeSelection = "volume_id > 0";
}
if ($SS == "yes") {
  $SelectSS = " And (verse_compare <> '' Or verse_compare2 <> '')";
} else {
  $SelectSS = "";
}
if ($cmd == "" && $SelectSS <> "") {
  $sql  = "SELECT volume_id, book_id, verse_id, volume_title, book_title,";
  $sql .= " chapter, chapter_name, verse, verse_scripture, groupname, 0 relevance_score,";
  $sql .= " html_top, html_right, html_bottom, html_left, html_replace, verse_compare, verse_compare2";
  $sql .= " FROM lds_scriptures_verses";
  $sql .= " WHERE language = '$lang' And (".$VolumeSelection.") ".$SelectSS;
  $sql .= " ORDER BY volume_id, book_id, chapter, verse";
} else if ($searchtype == "BOOLEAN") {
  if ($type === "stats") {
    $sql  = "SELECT volume_id, book_id, volume_title, chapter_title, book_title, chapter, verse";
    $sql .= " FROM lds_scriptures_verses";
    $sql .= " WHERE language = '$lang' And ($VolumeSelection)".$SelectSS." And MATCH (verse_scripture) AGAINST ('$cmd' IN BOOLEAN MODE)";
    $sql .= " ORDER BY volume_id, book_id, chapter, verse";
  } else {
    $sql  = "SELECT det.volume_id, det.book_id, det.verse_id, det.volume_title, det.book_title,";
    $sql .= " det.chapter, det.chapter_name, det.verse, det.verse_scripture, det.groupname, tot.relevance_score,";
    $sql .= " html_top, html_right, html_bottom, html_left, html_replace, verse_compare, verse_compare2";
    $sql .= " FROM lds_scriptures_verses As det";
    $sql .= " INNER JOIN (SELECT chapter, SUM(MATCH (verse_scripture) AGAINST ('$cmd' IN BOOLEAN MODE)) relevance_score ";
    $sql .= "      FROM lds_scriptures_verses WHERE ($VolumeSelection)".$SelectSS;
    $sql .= "      GROUP BY chapter) As tot";
    $sql .= " ON det.chapter = tot.chapter";
    $sql .= " WHERE ($VolumeSelection)".$SelectSS." And MATCH (verse_scripture) AGAINST ('$cmd' IN BOOLEAN MODE)";
    $sql .= " ORDER BY tot.relevance_score DESC, volume_id, book_id, chapter, verse";
  }
} else if ($searchtype == "EXPANSION") {
  $sql  = "SELECT det.volume_id, det.book_id, det.verse_id, det.volume_title, det.book_title,";
  $sql .= " det.chapter, det.chapter_name, det.verse, det.verse_scripture, det.groupname, tot.relevance_score,";
  $sql .= " html_top, html_right, html_bottom, html_left, html_replace, verse_compare, verse_compare2";
  $sql .= " FROM lds_scriptures_verses As det";
  $sql .= " INNER JOIN (SELECT chapter, SUM(MATCH (verse_scripture) AGAINST ('$cmd' WITH QUERY EXPANSION)) relevance_score ";
  $sql .= "      FROM lds_scriptures_verses WHERE language = '$lang' And ($VolumeSelection)".$SelectSS;
  $sql .= "      GROUP BY chapter) As tot";
  $sql .= " ON det.chapter = tot.chapter";
  $sql .= " WHERE language = '$lang' And ($VolumeSelection)".$SelectSS." And MATCH (verse_scripture) AGAINST ('$cmd' WITH QUERY EXPANSION)";
  $sql .= " ORDER BY tot.relevance_score DESC, volume_id, book_id, chapter, verse";
} else if ($searchtype == "LIKE") {
  $sql  = "SELECT verse_id, volume_id, volume_title, book_id, book_title, chapter, chapter_name, verse, verse_scripture, groupname, ";
  $sql .= " '1' As relevance_score,";
  $sql .= " html_top, html_right, html_bottom, html_left, html_replace, verse_compare verse_compare2";
  $sql .= " FROM lds_scriptures_verses";
  $sql .= " WHERE language = '$lang' And groupname Like '$groupname,%'";
  $sql .= " ORDER BY volume_id, book_id, chapter, verse";
} else {
  if ($type === "stats") {
    $sql  = "SELECT volume_id, book_id, volume_title, chapter_title, book_title, chapter, verse";
    $sql .= " FROM lds_scriptures_verses";
    $sql .= " WHERE language = '$lang' And ($VolumeSelection)".$SelectSS." And MATCH (verse_scripture) AGAINST ('$cmd' IN BOOLEAN MODE)";
    $sql .= " ORDER BY volume_id, book_id, chapter, verse";
  } else {
    $sql  = "SELECT det.volume_id, det.book_id, det.chapter, det.verse_id, ";
    $sql .= " det.volume_title, det.book_title, det.chapter_name, ";
    $sql .= " det.verse, det.verse_scripture, det.groupname, tot.relevance_score,";
    $sql .= " html_top, html_right, html_bottom, html_left, html_replace, verse_compare, verse_compare2";
    $sql .= " FROM lds_scriptures_verses As det";
    $sql .= " INNER JOIN (SELECT chapter, SUM(MATCH (verse_scripture) AGAINST ('$cmd')) relevance_score ";
    $sql .= "      FROM lds_scriptures_verses WHERE language = '$lang' And ($VolumeSelection)".$SelectSS;
    $sql .= "      GROUP BY chapter) As tot";
    $sql .= " ON det.chapter = tot.chapter";
    $sql .= " WHERE language = '$lang' And ($VolumeSelection)".$SelectSS." And (MATCH (verse_scripture) AGAINST ('$cmd')";
    $sql .= " Or verse_scripture like '%later%') ORDER BY tot.relevance_score DESC,volume_id, book_id, chapter, verse";
  }
}
$result = mysql_query($sql,$DB_Connection);

$xmlDoc = new DomDocument('1.0','ISO-8859-1'); //add root - <scriptures> 
$scriptures = $xmlDoc->appendChild($xmlDoc->createElement('scriptures')); 
$scriptures->setAttribute("type",$type);
$scriptures->setAttribute("title","The Holy Scriptures");
$scriptures->setAttribute("language",$lang);       
IF ($diag == "") {
  $scriptures->setAttribute("sql","");
} else {
  if ($diag == "echo") echo "  ".$sql."  ";
  $scriptures->setAttribute("sql",$sql);
}
$BookCommentaryCnt = 0;
$ChapterCommentaryCnt = 0;
$AllVolumeCnt = 0;
$AllBookCnt = 0;
$AllChapterCnt = 0;
$AllVerseCnt = 0;
$AllVolumeTot = 0;
$AllBookTot = 0;
$AllChapterTot = 0;
$AllVerseTot = 0;
$VolBookTot = 0;
$VolChapterTot = 0;
$VolVerseTot = 0;
$ChapChapterTot = 0;
$ChapVerseTot = 0;
$VerVerseTot = 0;
$UniqueBookGroups = "";
$UniqueChapterGroups = "";
$CurrVolume = "";
$CurrBook = "";
$CurrChapter = "";
$volume = "";
while ($row = mysql_fetch_object($result)) {
  if ($type === "stats") {
   if ($row->volume_id !== $CurrVolume) {
      $AllVolumeCnt++;
      $AllVolumeTot++;
      $CurrVolume = $row->volume_id;
      $CurrBook = "";
      if ($detail_level > 1) {
        if ($VolBookTot !== 0) $volume->setAttribute("books",$VolBookTot);
        if ($VolChapterTot !== 0) $volume->setAttribute("chapters",$VolChapterTot);
        if ($VolVerseTot !== 0) $volume->setAttribute("verses",$VolVerseTot);
        $volume = $scriptures->appendChild($xmlDoc->createElement('volume')); 
        $volume->setAttribute("count",$AllVolumeCnt);
        $volume->setAttribute("title",$row->volume_title);
      }
      $AllBookCnt = 0;
      $AllChapterCnt = 0;
      $VolBookTot = 0;
      $VolChapterTot = 0;
      $VolVerseTot = 0;
    }
    if ($row->book_id !== $CurrBook) {
      $AllBookCnt++;
      $AllBookTot++;
      $VolBookTot++;
      $CurrBook = $row->book_id;
      $CurrChapter = "";
      if ($detail_level > 2) {
        if ($ChapChapterTot !== 0) $book->setAttribute("chapters",$ChapChapterTot);
        if ($ChapVerseTot !== 0) $book->setAttribute("verses",$ChapVerseTot);
        $book = $volume->appendChild($xmlDoc->createElement('book')); 
        $book->setAttribute("count",$AllBookCnt);
        $book->setAttribute("title",$row->book_title);
      }
      $AllChapterCnt = 0;
      $ChapChapterTot = 0;
      $ChapVerseTot = 0;
    }
    $ChapterName = $row->book_title." ".$row->chapter;
    if ($CurrChapter !== $ChapterName) {
      $AllChapterCnt++;
      $AllChapterTot++;
      $VolChapterTot++;
      $ChapChapterTot++;
      $CurrChapter = $ChapterName;
      if ($detail_level > 3) {
        if ($VerVerseTot !== 0) $chapter->setAttribute("verses",$VerVerseTot);
        $chapter = $book->appendChild($xmlDoc->createElement('chapter')); 
        $chapter->setAttribute("num",$row->chapter);
        $chapter->setAttribute("count",$AllChapterCnt);
        $chapter->setAttribute("title",$ChapterName);
      }
      $AllVerseCnt = 0;
      $VerVerseTot = 0;
    }
    $AllVerseCnt++;
    if ($detail_level > 4) {
      $verse = $chapter->appendChild($xmlDoc->createElement('verse')); 
      $verse->setAttribute("num",$row->verse);
      $verse->setAttribute("count",$AllVerseCnt);
      $verse->setAttribute("title",$ChapterName.":".$row->verse);
    }
    $AllVerseTot++;
    $VolVerseTot++;
    $ChapVerseTot++;
    $VerVerseTot++;
    //$verse = $chapter->appendChild($xmlDoc->createElement('verse')); 
  } else {
    if ($row->verse_compare == "" && $row->verse_compare2 == "") {
      // No verse to compare to
      $compare_verse_text = "";
     } else {
      if ($row->verse_compare2 == "") {
        $CompareVerse = split("[|.]+", $row->verse_compare);
      } else {
        $CompareVerse = split("[|.]+", $row->verse_compare2);
      }
      $cbook_title = $CompareVerse[0]; // Comparison book title
      $cvol_id = $CompareVerse[1];     // Comparison volume
      $cbook_id = $CompareVerse[2];    // Comparison book
      $cchapter_id = $CompareVerse[3]; // Comparison chapter
      $cverse_id = $CompareVerse[4];   // Comparison verse
      $cversion = $CompareVerse[5];     // Version of scripture (e.g. LDS or JST or KJV etc)
      // Query the comparison verse
      $sql3 = "SELECT verse_scripture, html_top, html_right, html_bottom, html_left, html_replace ";
      $sql3 .= "FROM lds_scriptures_verses ";
      $sql3 .= "WHERE language = '$lang'  And version = '$cversion' And volume_id = $cvol_id And book_id = $cbook_id  And chapter = $cchapter_id  And verse = $cverse_id ";
      $result3 = mysql_query($sql3,$DB_Connection);
      if ($row3 = mysql_fetch_object($result3)) {
        if ($row3->html_replace != "") {
          $compare_verse_text = $row3->html_replace;
        } else {
          $compare_verse_text = str_replace($CRLF,"<br>",$row3->verse_scripture);
          $compare_verse_text = $row3->html_top.$row3->html_left.$compare_verse_text.$row3->html_right.$row3->html_bottom;
        }
        $compare_verse_text = utf8_encode($compare_verse_text);
      } else {
        $compare_verse_text = "";
      }
    }
    if ($row->volume_id != $CurrVolume) {
      $CurrVolume = $row->volume_id;
      $AllVolumeCnt++;
      $AllVolumeTot++;
      $CurrBook = "";
      $CurrChapter = "";
      $volume = $scriptures->appendChild($xmlDoc->createElement('volume')); 
      $volume->setAttribute("num",$CurrVolume);
      $volume->setAttribute("title",$row->volume_title);
      //$VolumeCnt++;
    }
    if ($row->book_id != $CurrBook) {
      $CurrBook = $row->book_id;
      $AllChapterCnt++;
      $AllChapterTot++;
      $VolChapterTot++;
      $ChapChapterTot++;
      $CurrChapter = "";
      $book = $volume->appendChild($xmlDoc->createElement('book'));        
      $book->setAttribute("num",$CurrBook);
      $book->setAttribute("title",$row->book_title);
      //$BookCnt++;
    }
    if ($row->chapter != $CurrChapter) {
      $CurrChapter = $row->chapter;
      $AllChapterCnt++;
      $AllChapterTot++;
      $VolChapterTot++;
      $ChapChapterTot++;
      $chapter = $book->appendChild($xmlDoc->createElement('chapter'));        
      $chapter->setAttribute("num",$row->chapter);
      $chapter->setAttribute("title",$row->book_title." ".$row->chapter_name);
      $ChapterCommentaryCnt = 0;
      $UniqueChapterGroups = "";
    }
    if ($compare_verse_text != "") {
      $chapter->setAttribute("compare",$cbook_title." ".$cchapter_id);
    }
    $i = 0;
    $VerseCommentary = "";
    if ($row->html_replace !== "") {
      $verse_text = $row->html_replace;
    } else {
      $verse_text = str_replace($CRLF,"<br>",$row->verse_scripture);
      $verse_text = $row->html_top.$row->html_left.$verse_text.$row->html_right.$row->html_bottom;
    }
    $verse_text = utf8_encode($verse_text); // must do or otherwise $xmlDoc->saveXML() crashes with extended character set
    $verse = $chapter->appendChild($xmlDoc->createElement('verse'));
    $verse->appendChild($xmlDoc->createTextNode($verse_text));
    $GroupName = explode(",",$row->groupname);
    while ($GroupName[$i] !== "" ) {
      if (!strstr($UniqueBookGroups." "," ".$GroupName[$i]." ")) {$BookCommentaryCnt++; $UniqueBookGroups.=" ".$GroupName[$i];}
      if (!strstr($UniqueChapterGroups." "," ".$GroupName[$i]." ")) {$ChapterCommentaryCnt++; $UniqueChapterGroups.=" ".$GroupName[$i];}
      // $mygroupname = str_replace($GroupName[$i],"'","\'");
      $sql2 = "SELECT type FROM Commentary WHERE language = '$lang' And groupname = '$GroupName[$i]'";
      // IF ($diag == "Y") echo "  ".$sql2."  ";
      $result2 = mysql_query($sql2,$DB_Connection);
      while ($row2 = mysql_fetch_object($result2)) {
        $comment = $verse->appendChild($xmlDoc->createElement('comment'));
        $comment->setAttribute("type",$row2->type);
        $comment->setAttribute("name",$GroupName[$i]);
        //$comment->appendChild($xmlDoc->createTextNode(" "));
        //$comment->appendChild($xmlDoc->createTextNode($GroupName[$i]));
      }
      $i++;
    }
    $chapter->setAttribute("comments",$ChapterCommentaryCnt);
    $verse->setAttribute("id",$row->verse_id);
    $verse->setAttribute("num",$row->verse);
    $verse->setAttribute("score",$row->relevance_score);
    if ($compare_verse_text !== "") {
      $compare = $verse->appendChild($xmlDoc->createElement('compare'));
      $compare->setAttribute("ref",$cbook_title." ".$cchapter_id.":".$cverse_id);
      $compare->setAttribute("lookahead",$lookahead);
      $compare->appendChild($xmlDoc->createTextNode($compare_verse_text));
    }
  }
}
$scriptures->setAttribute("volumes",$AllVolumeTot);
$scriptures->setAttribute("books",$AllBookTot);
$scriptures->setAttribute("chapters",$AllChapterTot);
$scriptures->setAttribute("verses",$AllVerseTot);
if ($volume !== "") {
  if ($detail_level > 1) {
    $volume->setAttribute("books",$VolBookTot);
    $volume->setAttribute("chapters",$VolChapterTot);
    $volume->setAttribute("verses",$VolVerseTot);
    if ($detail_level > 2) {
      $book->setAttribute("books",$ChapBookTot);
      $book->setAttribute("verses",$ChapVerseTot);
      if ($detail_level > 3) {
        $chapter->setAttribute("verses",$VerVerseTot);
        //if ($detail_level > 4) {
        //  $chapter->setAttribute("verses",$VerVerseTot);
        //}
      }
    }
  }
  //$volume->setAttribute("books",1);
  //$book->setAttribute("title",$row->book_title);
  //$book->setAttribute("longtitle",$row->book_title_long);
  //$book->setAttribute("comments",$BookCommentaryCnt);
  //$book->setAttribute("chapters",$row->num_chapters);
}

echo $xmlDoc->saveXML();
mysql_close($DB_Connection);
?>