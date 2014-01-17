<?php 
$lang = $_GET["lang"];
if ($lang == "") $lang = "english";
$groupname = $_GET["name"];
$diag = $_GET["diag"];
if ($diag == "Y") { header("Content-Type: text/plain");} else {header("Content-Type: text/xml");}
$searchtype = $_GET["searchtype"];
$MyPswd = file_get_contents("../js/temp.txt");
$MyPswd = str_replace("s","",str_replace("m88","",$MyPswd));
$DB_Connection = mysql_connect("localhost", "mackle2_lds", $MyPswd) or die (' I cannot connect to the database because: ' . $MyPswd . ' ' . mysql_error());
//$result = mysql_query("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'",$DB_Connection);
mysql_select_db("mackle2_LDS");
//$sql = "SELECT keywords FROM Commentary WHERE groupname = '$groupname'";
//IF ($diag == "Y") echo "  ".$sql."           "; 
//$result = mysql_query($sql,$DB_Connection);
//$keywords = mysql_result($result, 0);

$sql  = "SELECT volume_id, book_id, verse_id, volume_title, book_title,";
$sql .= " chapter, chapter_name, verse, verse_scripture, groupname,";
$sql .= " html_top, html_right, html_bottom, html_left, html_replace";
$sql .= " FROM lds_scriptures_verses";
$sql .= " WHERE language = '$lang' And groupname Like '%$groupname,%'";
$sql .= " ORDER BY volume_id, book_id, chapter, verse DESC";
  
$result = mysql_query($sql,$DB_Connection);

$xmlDoc = new DomDocument('1.0','ISO-8859-1'); //add root - <scriptures> 
$scriptures = $xmlDoc->appendChild($xmlDoc->createElement('scriptures')); 
$scriptures->setAttribute("language",$lang);       
$scriptures->setAttribute("type","Search");
$scriptures->setAttribute("title","The Holy Scriptures");
IF ($diag == "") {
  $scriptures->setAttribute("sql","");
} else {
  if ($diag == "echo") echo "  ".$sql."  ";
  $scriptures->setAttribute("sql",$sql);
}
IF ($diag == "Y") echo "  ".$sql."           "; 
$BookCommentaryCnt = 0;
$ChapterCommentaryCnt = 0;
$UniqueBookGroups = "";
$UniqueChapterGroups = "";
$CurrVolume = "";
$CurrBook = "";
$CurrChapter = "";
$ChapterCnt = 0;
while (($row = mysql_fetch_object($result)) && ($ChapterCnt <= 150)) {
  if ($row->volume_id != $CurrVolume) {
    $CurrVolume = $row->volume_id;
    $CurrBook = "";
    $CurrChapter = "";
    $volume = $scriptures->appendChild($xmlDoc->createElement('volume')); 
    $volume->setAttribute("num",$CurrVolume);
    $volume->setAttribute("title",$row->volume_title);
    //$VolumeCnt++;
  }
  if ($row->book_id != $CurrBook) {
    $CurrBook = $row->book_id;
    $CurrChapter = "";
    $book = $volume->appendChild($xmlDoc->createElement('book'));        
    $book->setAttribute("num",$CurrBook);
    $book->setAttribute("title",$row->book_title);
    //$BookCnt++;
  }
  if ($row->chapter != $CurrChapter) {
    $CurrChapter = $row->chapter;
    $chapter = $book->appendChild($xmlDoc->createElement('chapter'));        
    $chapter->setAttribute("num",$row->chapter);
    $chapter->setAttribute("title",$row->chapter_name);
    $ChapterCommentaryCnt = 0;
    $UniqueChapterGroups = "";
    $ChapterCnt++;
  }
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
  $i = 0;
  while ($GroupName[$i] !== "" ) {
    if (!strstr($UniqueBookGroups." "," ".$GroupName[$i]." ")) {$BookCommentaryCnt++; $UniqueBookGroups.=" ".$GroupName[$i];}
    if (!strstr($UniqueChapterGroups." "," ".$GroupName[$i]." ")) {$ChapterCommentaryCnt++; $UniqueChapterGroups.=" ".$GroupName[$i];}
    $sql3 = "SELECT type FROM Commentary WHERE language = '$lang' And groupname = '$GroupName[$i]'";
    IF ($diag == "Y") echo "  ".$sql3."  ";
    $result3 = mysql_query($sql3,$DB_Connection);
    while ($row2 = mysql_fetch_object($result3)) {
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
}
//$volume->setAttribute("books",1);
//$book->setAttribute("title",$row->book_title);
//$book->setAttribute("longtitle",$row->book_title_long);
//$book->setAttribute("comments",$BookCommentaryCnt);
//$book->setAttribute("chapters",$row->num_chapters);

echo $xmlDoc->saveXML();
mysql_close($DB_Connection);
?>