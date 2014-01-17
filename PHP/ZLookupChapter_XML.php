<?php

$MyPswd = file_get_contents("../js/temp.txt");
$MyPswd = str_replace("s","",str_replace("m88","",$MyPswd));
$DB_Connection = mysql_connect("localhost", "mackle2_lds", $MyPswd) or die ("Cannot connect to database: ".mysql_error());
mysql_select_db("mackle2_LDS");

$SQL = $_GET["SQL"];
$lang = $_GET["lang"];
if ($lang == "") $lang = "english";
$volume_id = mysql_real_escape_string($_GET["volume"]);
$book_id = mysql_real_escape_string($_GET["book"]);
$chapter = mysql_real_escape_string($_GET["chapter"]);

header("Content-Type: text/xml; charset=utf-8");
// Query for volume and book
$sql  = "SELECT volume_title, num_chapters, book_title, book_title_long FROM lds_scriptures_books WHERE ";
$sql .= "language = '$lang' And volume_id = $volume_id And book_id = $book_id";
$result = mysql_query($sql,$DB_Connection);

if ($row = mysql_fetch_object($result)) {
  
  //Create XML document using the DOM 
  $xmlDoc = new DomDocument('1.0', 'UTF-8'); //add root as scriptures
  
  // Define XML root
  $scriptures = $xmlDoc->appendChild($xmlDoc->createElement('scriptures')); 
  $scriptures->setAttribute("language",$lang);       
  $scriptures->setAttribute("type","Fill");
  $scriptures->setAttribute("title","The Holy Scriptures");
  if ($SQL == "Y") {$scriptures->setAttribute("sql",$sql2);} // Used for diagnostics in admin mode
  
  // Create volume sub-node                 
  $volume = $scriptures->appendChild($xmlDoc->createElement('volume')); 
  $volume->setAttribute("num","1");
  $volume->setAttribute("title",$row->volume_title);
  
  // Create book sub-node
  $book = $volume->appendChild($xmlDoc->createElement('book'));        
  $book->setAttribute("num","1");
  $book->setAttribute("title",$row->book_title);
  
  // Query for chapter and verses
  $sql2 = "SELECT chapter, chapter_name, verse_id, verse, verse_scripture, html_top, html_right, html_bottom,";
  $sql2 .= " html_left, html_replace, groupname FROM lds_scriptures_verses ";
  $sql2 .= " WHERE language = '$lang' And volume_id = $volume_id And book_id = $book_id And chapter = $chapter";
  $result2 = mysql_query($sql2,$DB_Connection);
  $FirstTime = true;
  while ($row2 = mysql_fetch_object($result2)) {
	if ($FirstTime == true) {
      // Create the chapter sub-node. We're only doing one chapter of verses.
      $chapter = $book->appendChild($xmlDoc->createElement('chapter')); 
      $chapter->setAttribute("num",$row2->chapter);
      $chapter->setAttribute("title",$row2->chapter_name);
      $chapter->setAttribute("comments","");
	  $FirstTime = false;
    }
    if ($row2->html_replace !== "") {
      // Assign the special formatted verse,  rather than the raw text verse used for searching.
      $verse_text = $row2->html_replace;
    } else {
      // Format the standard version with formatting as defined, if any
      $verse_text = str_replace("\r\n","<br>",$row2->verse_scripture);
      $verse_text = $row2->html_top.$row2->html_left.$verse_text.$row2->html_right.$row2->html_bottom;
    }
    // Create the chapter verse sub-node and attributes
    $verse = $chapter->appendChild($xmlDoc->createElement('verse'));
    $verse->appendChild($xmlDoc->createTextNode($verse_text));
    $verse->setAttribute("id",$row2->verse_id);
    $verse->setAttribute("num",$row2->verse);
  }
  // Send results back to JavaScript Client
  echo $xmlDoc->saveXML();
  // Close the connection
  mysql_close($DB_Connection);
}
?>