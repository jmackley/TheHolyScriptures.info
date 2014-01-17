<?php
error_reporting(0);
// Connect to database. We're going to return an entire book of scripture text.
$MyPswd = file_get_contents("../js/temp.txt");
$MyPswd = str_replace("s","",str_replace("m88","",$MyPswd));
$DB_Connection = mysql_connect("localhost", "mackle2_lds", $MyPswd) 
                or die (' I cannot connect to the database because: ' . $MyPswd . ' ' . mysql_error());
mysql_select_db("mackle2_LDS");

// Get query parameters. Use mysql_real_escape_string to prevent SQL injection attacks.
$lang = $_GET["lang"];
if ($lang == "") $lang = "english";
$vol_id = mysql_real_escape_string($_GET["vol"]);
if ($vol_id == "") {
  $vol_id = mysql_real_escape_string($_GET["volume"]);
}
$book_id = mysql_real_escape_string($_GET["book"]);
$version = mysql_real_escape_string($_GET["version"]);
$flag = mysql_real_escape_string($_GET["flag"]);
//if ($version == "") $version = "LDS";
$chapter_no = mysql_real_escape_string($_GET["chapter"]);
if ($chapter_no == "") {
  $chapters = "";
} else {
  $chapters = " And chapter = ".$chapter_no;
}
$verses = mysql_real_escape_string($_GET["verse"]);
if (strstr($verses,"-")) {
  $verse_beg = substr($verses,0,strpos($verses,"-"));
  $verse_end = substr($verses,strpos($verses,"-")+1);
  $verses = " And verse >= ".$verse_beg." And verse <= ".$verse_end;
} else {
  if ($verses !== "") {
    $verses = " And verse In (".$verses.")";
  }
}
$mark = mysql_real_escape_string($_GET["mark"]);
$SQL = $_GET["SQL"];      // If Y then send back SQL for diagnostics
$CRLF = chr(13).chr(10);

// Let browser know the output is XML unicode
header("Content-Type: text/xml; charset=utf-8"); 

// Create XML document using the DOM 
$xmlDoc = new DomDocument('1.0','ISO-8859-1');
// Add root - <scriptures> 
$scriptures = $xmlDoc->appendChild($xmlDoc->createElement('scriptures')); 
// Add attributes to <scriptures>
$scriptures->setAttribute("language",$lang);       
$scriptures->setAttribute("type","List");
$scriptures->setAttribute("title","The Holy Scriptures");
// Add volume child element to <scriptures>
$volume = $scriptures->appendChild($xmlDoc->createElement('volume')); 
// Add attribute to <volume>
$volume->setAttribute("num",1);
// Add volume child element to <volume>
$book = $volume->appendChild($xmlDoc->createElement('book'));        

// Execute query for volume and book
$sql  = "SELECT volume_title, num_chapters, book_title, book_title_long, version";
$sql .= " FROM lds_scriptures_books";
$sql .= " WHERE language = '$lang'";
if ($version != "") {
  $sql .= " And version = '$version'";
}
if ($vol_id != "") {
	$sql .= " And volume_id = $vol_id";
}
if ($book_id != "") {
	$sql .= " And book_id = $book_id ";
}
$result = mysql_query($sql,$DB_Connection);
if ($row = mysql_fetch_object($result)) {
  // We've got results for the query so assign the title name
  $volume->setAttribute("title",$row->volume_title);
  $volume->setAttribute("version",$row->version);
  // Execute the next query to get the chapter and verse information
  $sql2 = "SELECT verse_id, volume_id, book_id, chapter, chapter_name, verse, verse_scripture, ";
  $sql2 .= "html_top, html_right, html_bottom, html_left, html_replace, groupname, verse_compare, verse_compare2 ";
  $sql2 .= "FROM lds_scriptures_verses ";
  $sql2 .= "WHERE language = '$lang' ";
  if ($version != "") {
    $sql2 .= "And version = '$version' ";
  }
  if ($vol_id != "") {
    $sql2 .= "And volume_id = $vol_id ";
  }
  if ($book_id != "") {
    $sql2 .= "And book_id = $book_id ";
  }
  $sql2 .= "$chapters $verses ";
  if ($flag === "c") {
    $sql2 .= "And (verse_compare <> '' Or verse_compare2 <> '')";
  }
  $sql2 .= "ORDER BY chapter, verse";
  $result2 = mysql_query($sql2,$DB_Connection);
  // Set sql attribute for diagnostics, in admin mode
  IF ($SQL === "Y") {
    $scriptures->setAttribute("sql",$sql2);
  } else {
    $scriptures->setAttribute("sql","");
  }
  $BookCommentaryCnt = 0;
  $ChapterCommentaryCnt = 0;
  $UniqueBookGroups = "";
  $UniqueChapterGroups = "";
  $CurrVolume = "";
  $CurrBook = "";
  $CurrChapter = "";
  // echo $sql2;
  while ($row2 = mysql_fetch_object($result2)) {
    if ($row2->verse_compare == "" && $row2->verse_compare2 == "") {
    // No verse to compare to
      $compare_verse_text = "";
    } else {
    // There is a comparison verse, so include it in the XML. 
    // The the client side this will get picked up and displayed
    // side by side with the original verse with the differences highlighted.
      if ($row2->verse_compare2 == "") {
        $CompareVerse = preg_split("/[|.]+/", $row2->verse_compare);
      } else {
        $CompareVerse = preg_split("/[|.]+/", $row2->verse_compare2);
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
      // Id query is successful then add comparison version to XML
      if ($row3 = mysql_fetch_object($result3)) {
        // Check for special formatted text. This is the rare exception.
        if ($row3->html_replace != "") {
          $compare_verse_text = $row3->html_replace;
        } else {
          // Most scripture verses are raw text (for accurate searching) but in a very few cases, there is a <br>
          // If a <br> is found then replace it with CRLF
          $compare_verse_text = str_replace("\r\n","<br>",$row3->verse_scripture);
          // Final result is to include the unformatted text with special before and after formatting codes.
          $compare_verse_text = $row3->html_top.$row3->html_left.$compare_verse_text.$row3->html_right.$row3->html_bottom;
          if (trim($compare_verse_text) === "") $compare_verse_text = "[deleted]";
        }
        $compare_verse_text = utf8_encode($compare_verse_text);
      } else {
        $compare_verse_text = "";
      }
    }
    if ($row2->volume_id != $CurrVolume) {
      $CurrVolume = $row2->volume_id;
      $CurrBook = "";
      $CurrChapter = "";
      $volume->setAttribute("num",$CurrVolume);
      $volume->setAttribute("title",$row->volume_title);
    }
    if ($row2->book_id != $CurrBook) {
      $CurrBook = $row2->book_id;
      $CurrChapter = "";
      $book->setAttribute("num",$CurrBook);
      $book->setAttribute("title",$row->book_title);
      $book->setAttribute("longtitle",$row->book_title_long);
      $book->setAttribute("chapters",$row->num_chapters);
     }
    if ($row2->chapter != $CurrChapter) {
      $chapter = $book->appendChild($xmlDoc->createElement('chapter'));        
      $chapter->setAttribute("num",$row2->chapter);
      $chapter->setAttribute("title",$row2->chapter_name);
      $CurrChapter = $row2->chapter;
      $ChapterCommentaryCnt = 0;
      $UniqueChapterGroups = "";
    }
    if ($compare_verse_text != "") {
      $chapter->setAttribute("compare",$cbook_title." ".$cchapter_id." (".$cversion.")");
    }
    $VerseCommentary = "";
    $i = 0;
    $GroupName = explode(",",$row2->groupname);
    $VerseCommentary = "";
    if ($row2->html_replace !== "") {
      $verse_text = $row2->html_replace;
    } else {
      $verse_text = str_replace("\r\n","<br>",$row2->verse_scripture);
      $verse_text = $row2->html_top.$row2->html_left.$verse_text.$row2->html_right.$row2->html_bottom;
    }
    $verse_text = utf8_encode($verse_text); // must do or otherwise $xmlDoc->saveXML() crashes with extended character set
    $verse = $chapter->appendChild($xmlDoc->createElement('verse'));
    $verse->appendChild($xmlDoc->createTextNode($verse_text));
    while ($GroupName[$i] !== "" ) {
      if (!strstr($UniqueBookGroups." "," ".$GroupName[$i]." ")) {$BookCommentaryCnt++; $UniqueBookGroups.=" ".$GroupName[$i];}
      if (!strstr($UniqueChapterGroups." "," ".$GroupName[$i]." ")) {$ChapterCommentaryCnt++; $UniqueChapterGroups.=" ".$GroupName[$i];}
      //$mygroupname = str_replace($GroupName[$i],"'","\'");
      //echo $GroupName[$i];
      //echo $mygroupname;
      //$sql3 = "SELECT type FROM Commentary WHERE groupname = '$mygroupname'";
      $sql3 = "SELECT type FROM Commentary WHERE groupname = '$GroupName[$i]'";
      //echo $sql3;
      $result3 = mysql_query($sql3,$DB_Connection);
      while ($row3 = mysql_fetch_object($result3)) {
        $comment = $verse->appendChild($xmlDoc->createElement('comment'));
        $comment->setAttribute("type",$row3->type);
        $comment->setAttribute("name",$GroupName[$i]);
      }
      $i++;
    }
    $chapter->setAttribute("comments",$ChapterCommentaryCnt);
    $verse->setAttribute("id",$row2->verse_id);
    $verse->setAttribute("num",$row2->verse);
    if (strstr("|".$mark."|","|".$row2->verse."|")) {
      $verse->setAttribute("mark","yellow");
    } else {
      $verse->setAttribute("mark","");
    }
    $verse->setAttribute("score","");
    if ($compare_verse_text != "") {
      $compare = $verse->appendChild($xmlDoc->createElement('compare'));
      $compare->setAttribute("ref",$cbook_title." ".$cchapter_id.":".$cverse_id);
      $compare->setAttribute("version",$cversion);
      $compare->appendChild($xmlDoc->createTextNode($compare_verse_text));
    }
  }
}
echo $xmlDoc->saveXML();
mysql_close($DB_Connection);

?>