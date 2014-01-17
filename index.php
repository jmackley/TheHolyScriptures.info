<?php
//header('Content-type: text/html');
//if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler");
?>
<!DOCTYPE html> 
<html>
  <head>
    <title>The Holy Scriptures</title>
    <link rel='shortcut icon' href='../favicon.ico' type='image/x-icon' />
    <link rel='icon' href='../favicon.ico' type='image/ico' />
    <meta name='author' content='Jay Mackley' />
    <meta name='robots' content='index, nofollow' />
    <meta name='keywords' content='Scripture, Bible, Book of Mormon, Doctrine and Covenants, Pearl of Great Price, LDS, Jesus, Jesus Christ, Messiah, Word of God, Joseph Smith, truth, God, Holy Scripture, LDS Church, The Church of Jesus Christ of Latter-day Saints' />
    <meta name='description' content='Interactive Search and Study of The Holy Scriptures.' />
    <meta name='copyright' content='&copy; 2011 Mackley Computer Services, Inc' />
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta http-equiv='Pragma' content='no-cache' /> <!-- change to 'public' when development complete -->
    <meta http-equiv='cache-control' content='no-cache' /> <!-- change to 'public' when development complete -->
    <meta http-equiv='expires' content='0' /> <!-- 0 means immediate expiration - change to date like Mon, 22 Jul 2010 11:12:01 GMT when development complete -->
    <meta http-equiv='content-language' content='en-US' />
    <link rel='stylesheet' type='text/css' href='css/accordion.css' />
    <link rel='stylesheet' type='text/css' href='css/lytebox.css' media='screen' />
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-26069935-1']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
  </head>
  <?php
    $Toc = $_GET['toc']; if ($Toc == "") $Toc = "Y";
    $Vol = $_GET['vol']; if ($Vol == "") $Vol = "0";
    $Book = $_GET['book']; if ($Book == "") $Book = "0";
    $Chapter = $_GET['chapter']; if ($Chapter == "") $Chapter = "0";
    $Verse = $_GET['verse']; if ($Verse == "") $Verse = "0";
    $Search = $_GET['search']; if ($Search == "") $Search = "0";
    $Pswd = $_GET['pswd'];
    $params = "$Toc','$Vol','$Book','$Chapter','$Verse','$Search";
    echo '<body onload="InitPage(\''.$params.'\');">'."\n";
  ?>
    <div id="tiplayer" style="position:absolute; visibility:hidden; z-index:10000;"></div>
    <table width="100%">
      <tr>
        <td width="30%">
          <span onClick="ToggleTOC('container')" id='showindicator' class="nobr"> - Hide TOC</span>
          <?php
          if ($Pswd == "jdm1234") {
            echo "<span onClick=\"alert(navigator.userAgent.toLowerCase())\"> who </span>";
          }
          ?>
        </td>
        <td width="40%" align="center">
          <img src="images/THS_logo2.png" width="526" height="60" />
        </td>
        <td width="30%" align="right">
          <table>
          <tr>
            <td colspan="2"></td>
          </tr>
          <tr>
            <td>
              <a href="http://theholyscriptures.info/ldsblog" target="_blank" style="margin-right: 50px;">
                <img src="images/ZionBlueBGSmaller.png" style="outline: none; border:0;" width="150" height="61" />
                <!-- <span style="color: white;"><small>blog</small></span> -->
              </a> 
            </td>
          </tr>
          </table>
        </td>
      </tr>
    </table>
    <!-- <h5><span></span>CSS3</h5> -->
    <div id="container" class='switchcontent'>
      <span>&nbsp;&nbsp;&nbsp;&nbsp;<a href=# class="sectionlink" onClick="ShowScriptures();">Scriptures</a></span>
      <span>&nbsp;&nbsp;<a href=# class="sectionlink" onClick="DoSearch();">Search</a></span>
      <span>&nbsp;&nbsp;<a href=# class="sectionlink" onClick="ShowComparisions();">Comparisons</a></span>
      <span>&nbsp;&nbsp;<a href=# class="sectionlink" onClick="ShowCommentaries();">Commentaries</a></span>
      <span>&nbsp;&nbsp;<a href=# class="sectionlink" onClick="ShowEssays();">Information</a></span>
      <span>&nbsp;&nbsp;<a href=# class="sectionlink" onClick="FavLinks();">Links</a></span>
      <div class="accordion_content" id="slate">
        <div id="commentary_container">
          <br />
          <span class="section ESs">Commentary List</span><br />
          <span class="ESs">
            <a href="#" onClick="Essay('There is a God');">There is a God</a>&nbsp;- 
            <a href="#" onClick="Essay('The Prime Elective');">The Prime Elective</a>&nbsp;- 
            <a href="#" onClick="Essay('Purpose of Life');">Purpose of Life</a>&nbsp;- 
            <a href="#" onClick="Essay('Nature of God');">Nature of God</a>&nbsp;-
            <a href="#" onClick="Essay('Plan of Salvation');">Plan of Salvation</a> 
            <!-- <a href="#" onClick="ZDisplay(2,1);">Matthew (yes)</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(2,27);">Revelations (no)</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(4,76);">Section 76 (no)</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(1,23);">Isaiah (no)</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(5,1);">Moses (no)</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(5,2);">Abraham (no)</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(3,11);">3 Nephi (no)</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(3,15);">Moroni (no)</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(5,5);">Articles of Faith (no)</a> -->
          </span><br /><br />
        </div>
        <div id="compare_container">
          <br />
          <span class="section OTs">Old Testament</span><br />
          <span class="OTs">
            <a href="#" onClick="ZDisplay(1,1,0,0,0,'c');">Genesis, KJV &Delta; JST</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(1,2,0,0,0,'c');">Exodus, KJV &Delta; JST</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(1,5,0,0,0,'c');">Deuteronomy, KJV &Delta; JST</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(1,9,0,0,0,'c');">1 Samuel, KJV &Delta; JST</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(1,10,0,0,0,'c');">2 Samuel, KJV &Delta; JST</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(1,13,0,0,0,'c');">1 Chronicles, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(1,14,0,0,0,'c');">2 Chronicles, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(1,19,0,0,0,'c');">Psalms, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(1,23,0,0,0,'c');">Isaiah, KJV &Delta; JST/1 Nephi/2 Nephi</a>&nbsp;-
            <a href="#" onClick="ZDisplay(1,24,0,0,0,'c');">Jeremiah, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(1,30,0,0,0,'c');">Amos, KJV &Delta; JST</a>
          </span><br /><br />
          <br />
          <span class="section NTs">New Testament</span><br />
          <span class="NTs">
            <a href="#" onClick="ZDisplay(2,1,0,0,0,'c');">Matthew, KJV &Delta; JST</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(2,2,0,0,0,'c');">Mark, KJV &Delta; JST</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(2,3,0,0,0,'c');">Luke, KJV &Delta; JST</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(2,4,0,0,0,'c');">John, KJV &Delta; JST</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(2,5,0,0,0,'c');">Acts, KJV &Delta; JST</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(2,6,0,0,0,'c');">Romans, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(2,7,0,0,0,'c');">1 Corinthian, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(2,9,0,0,0,'c');">Galatians, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(2,10,0,0,0,'c');">Ephesians, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(2,12,0,0,0,'c');">Colossians, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(2,13,0,0,0,'c');">1 Thessalonians, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(2,14,0,0,0,'c');">2 Thessalonians, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(2,15,0,0,0,'c');">1 Timothy, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(2,18,0,0,0,'c');">Philemon, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(2,19,0,0,0,'c');">Hebrews, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(2,20,0,0,0,'c');">James, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(2,21,0,0,0,'c');">1 Peter, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(2,22,0,0,0,'c');">2 Peter, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(2,23,0,0,0,'c');">1 John, KJV &Delta; JST</a>&nbsp;-
            <a href="#" onClick="ZDisplay(2,27,0,0,0,'c');">Revelation, KJV &Delta; JST</a>
          </span><br /><br />
          <span class="section BMs">Book of Mormon</span><br />
          <span class="BMs">
            <a href="#" onClick="ZDisplay(3,2,0,0,0,'c');">2 Nephi, &Delta; KJV Isaiah</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(3,11,0,0,0,'c');">3 Nephi, &Delta; KJV Isaiah</a>  
          </span><br /><br />
        </div>
        <div id="links_container">
          <br />
          <span class="section ESs">Some Important Latter-day Saint Related Websites</span><br />
          <span class="ESs">
            <a href="http://lds.org" target="_blank">The Church of Jesus Christ of Latter-day Saints</a>&nbsp;-
            <a href="http://www.mormonnewsroom.org/" target="_blank">LDS Newsroom</a>&nbsp;-
            <a href="http://www.mormon.org/" target="_blank">About Mormons</a>&nbsp;-
            <a href="http://fairlds.org" target="_blank">Foundation for Apologetic Information and Research (FAIR)</a>&nbsp;-
            <a href="http://josephsmithpapers.org" target="_blank">Joseph Smith Papers</a>&nbsp;-
            <a href="http://mormonscholarstestify.org" target="_blank">Scholars Testify</a>&nbsp;-
            <a href="http://www.mormonsbelieve.org/" target="_blank">Mormons Believe</a>&nbsp;-
            <a href="http://mi.byu.edu/" target="_blank">Neal A. Maxwell Institute</a>&nbsp;-
            <a href="http://rsc.byu.edu/" target="_blank">BYU Religious Studies Center</a>&nbsp;-
            <a href="http://lds.org/conference/languages/0,6353,310-1,00.html" target="_blank">LDS Conference</a>&nbsp;-
            <a href="http://www.lib.byu.edu/Macmillan/" target="_blank">Encyclopedia of Mormonism</a>&nbsp;-
            <a href="http://www.ldsmag.com/" target="_blank">Meridian Magazine</a>&nbsp;-
            <a href="http://tech.lds.org/" target="_blank">LDS TECH</a>
           </span><br /><br />
        </div>
        <div id="search_container">
          <br /><center class="section SSs">Search the Scriptures</center>
          <table align='center' width="100%" border="0">
            <tr>
              <td align="left" valign="top" style="padding:10px;">
                <center>
                <span class="SSs">
                  <b>Enter Search Command - &nbsp;&nbsp;&nbsp;
                  <a href="essays/SearchHelp.php" class="SSs" rel="lyteframe" title="&nbsp; &lt;span style='color: white'&gt;Search Help&lt;/span&gt;" rev="width: 660px; height: 450px; scrolling: auto;">
                  <small>?<small> Help</small></small></a></b>
                </span><br />
                <textarea name="styled-textarea" id="searchfor" cols="100%" onfocus="setSearchBG('white');" onblur="setSearchBG('#C2ECEF')"></textarea><br /><br />
                <table>
                  <tr>
                    <td>
                      <a class="sectionlink big" href="#" onClick='Search()'>SEARCH NOW</a>
                    </td>
                  </tr>
                </table>
                </center>
              </td>
              <td style="padding:5px;">
                <input id="OT_chk" type='checkbox' checked value='yes' /><span class="OTs big">Old Testament</span><br />
                <input id="NT_chk" type='checkbox' checked value='yes' /><span class="NTs big">New Testament</span><br />
                <input id="BM_chk" type='checkbox' checked value='yes' /><span class="BMs big">Book of Mormon</span><br />
                <input id="DC_chk" type='checkbox' checked value='yes' /><span class="DCs big">Doctrine&nbsp;&amp;&nbsp;Covenants</span><br />
                <input id="PP_chk" type='checkbox' checked value='yes' /><span class="PPs big">Pearl of Great Price</span><br /><br />
                <input id="SS_chk" type='checkbox' value='yes'  /><span class="SSs big">Only side-by-side comparisons</span>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="padding:5px;">
                <span id="searchresults" class="SSs">
                </span>
              </td>
            </tr>
          </table>
        </div>
        <div id="essay_container">
          <br />
          <span class="section ESs">About TheHolyScriptures.info</span><br />
          <span class="ESs">
            <a href="essays/AboutThisSite.html" rel="lyteframe" title=" About TheHolyScriptures.info " rev="width: 700px; height: 500px; scrolling: auto;">About This Site</a>&nbsp;- 
            <a href="essays/Contact.html" rel="lyteframe" title=" Send eMail " rev="width: 700px; height: 500px; scrolling: auto;">eMail</a>&nbsp;- 
            <a href="essays/Credits.html" rel="lyteframe" title=" Technical credits and development information " rev="width: 700px; height: 500px; scrolling: auto;">Technical Credits</a>&nbsp;- 
            <a href="essays/Features.html" rel="lyteframe" title=" Features and capabilities of TheHolyScriptures.info " rev="width: 700px; height: 500px; scrolling: auto;">Site Features</a>
          </span><br /><br />
          <!-- <span class="section ESs">The Meaning of Life</span><br />
          <span class="ESs">
            <a href="#" onClick="ZDisplay(5,1);">Is&nbsp;This&nbsp;for&nbsp;You?</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(5,3);">Man&nbsp;is&nbsp;Nothing</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(5,2);">The&nbsp;Prime&nbsp;Elective</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(5,4);">As&nbsp;God&nbsp;Is&nbsp;-&nbsp;The&nbsp;Great&nbsp;Plan&nbsp;of&nbsp;Happiness</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(5,5);">For&nbsp;Time&nbsp;and&nbsp;All&nbsp;Eternity</a>
          </span><br /><br />
          <span class="section ESs">Defending the Faith</span><br />
          <span class="ESs">
            <a href="#" onClick="ZDisplay(5,6);">Praise&nbsp;to&nbsp;the&nbsp;Man</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(5,7);">The&nbsp;Kingdom&nbsp;of&nbsp;God/The&nbsp;Kingdom&nbsp;of&nbsp;Heaven</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(5,8);">Traitors&nbsp;&amp;&nbsp;Fools</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(5,9);"> The&nbsp;Great&nbsp;Deceptions</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(5,10);">The&nbsp;One&nbsp;and&nbsp;Only&nbsp;True&nbsp;Church</a>
          </span><br /><br />
          <span class="section ESs">Doers of the Word</span><br />
          <span class="ESs">
            <a href="#" onClick="ZDisplay(5,11);">The&nbsp;Great&nbsp;Morality&nbsp;Play</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(5,12);">One&nbsp;Tenth&nbsp;of&nbsp;All?</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(5,13);">Born&nbsp;Again</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(5,14);">Saved&nbsp;by&nbsp;Grace</a>&nbsp;-  
            <a href="#" onClick="ZDisplay(5,15);">The&nbsp;Word&nbsp;of&nbsp;God</a>
          </span><br /><br /> -->
        </div>
        <div id="horizontal_container">
          <h3 id="H1" class="horizontal_accordion_toggle OT"></h3>
          <div class="horizontal_accordion_content">
            <p>
            <span class="section OTs">Introduction</span><br />
            <span class="OTs">
              <a href="#" onClick="ZDisplay(1,0,0,0,0,0,'KJV_Intro.jpg','William Tyndale, Rev John Rogers at the Stake, King James 1 commissions Bible, title page extracts of King James Bible');">King James Dedication</a> 
              <br />__________________________<br />
            </span><br />
            <span class="section OTs">Books of Moses (The Law)</span><br />
            <span class="OTs">
              <a href="#" onClick="ZDisplay(1,1,0,0,0,0,'Creation_Genesis.jpg','Genesis in the original King James Bible edition');">Genesis</a>&nbsp; -
              <a href="#" onClick="ZDisplay(1,2);">Exodus</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(1,3);">Leviticus</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(1,4);">Numbers</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(1,5);">Deuteronomy</a>
            </span><br /><br />
            <span class="section OTs">Historical Books</span><br />
            <span class="OTs">
              <a href="#" onClick="ZDisplay(1,6);">Joshua</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,7);">Judges</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,8);">Ruth</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,9);">1&nbsp;Samuel</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,10);">2&nbsp;Samuel</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,11);">1&nbsp;Kings</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,12);">2&nbsp;Kings</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,13);">1&nbsp;Chronicles</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,14);">2&nbsp;Chronicles</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,15);">Ezra</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,16);">Nehemiah</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,17,0,0,0,0,'BookOfEster_MoviePict.jpg','Book of Esther in Hebrew. Hadassah/Queen Esther as played by Tiffany Dupont in the 2006 movie One Night with the King');">Esther</a>
            </span><br /><br />
            <span class="section OTs">Wisdom Books</span><br />
            <span class="OTs">
              <a href="#" onClick="ZDisplay(1,18);">Job</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,19);">Psalms</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,20);">Proverbs</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,21);">Ecclesiastes</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,22);">Song&nbsp;of&nbsp;Solomon</a>
            </span><br /><br />
            <span class="section OTs">The Prophets</span><br />
            <span class="OTs">
              <a href="#" onClick="ZDisplay(1,23,0,0,0,0,'GreatIsaiahScroll.jpg','The prophet Isaiah lived around 700 BC. The Great Isaiah Scroll was found with the Dead Sea scrolls in Qumran is the oldest copy of the Book of Isaiah known to exist. It dates to 225 BC +/- 100 years.');">Isaiah</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,24);">Jeremiah</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,25);">Lamentations</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,26);">Ezekiel</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,27);">Daniel</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,28);">Hosea</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,29);">Joel</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,30);">Amos</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,31);">Obadiah</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,32);">Jonah</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,33);">Micah</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,34);">Nahum</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,35);">Habakkuk</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,36);">Zephaniah</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,37);">Haggai</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,38);">Zechariah</a>&nbsp;- 
              <a href="#" onClick="ZDisplay(1,39);">Malachi</a>
            </span>
            </p>
          </div>
          <h3 id="H2" class="horizontal_accordion_toggle NT"></h3>
          <div class="horizontal_accordion_content">
            <p>
            <span class="section NTs">The Gospels</span><br />
            <span class="NTs">
              <a href="#" onClick="ZDisplay(2,1,0,0,0,0,'ChristChild.jpg','Shepherds and wise men reverence the Christ child');">Matthew</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,2,0,0,0,0,'MarkCollage.jpg','Jesus babtized and heals the sick.');">Mark</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,3);">Luke</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,4);">John</a>
            </span><br /><br />
            <span class="section NTs">General Epistles</span><br />
            <span class="NTs">
              <a href="#" onClick="ZDisplay(2,19);">Hebrews</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,20);">James</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,21);">1&nbsp;Peter</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,22);">2&nbsp;Peter</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,23);">1&nbsp;John</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,24);">2&nbsp;John</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,25);">3&nbsp;John</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,26);">Jude</a>
            </span><br /><br />
            <span class="section NTs">Epistles of Paul</span><br />
            <span class="NTs">
              <a href="#" onClick="ZDisplay(2,6);">Romans</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,7);">1&nbsp;Corinthians</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,8);">2&nbsp;Corinthians</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,9);">Galatians</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,10);">Ephesians</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,11);">Philippians</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,12);">Colossians</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,13);">1&nbsp;Thessalonians</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,14);">2&nbsp;Thessalonians</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,15);">1&nbsp;Timothy</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,16);">2&nbsp;Timothy</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,17);">Titus</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,18);">Philemon</a>
            </span><br /><br />
            <span class="section NTs">Other Books</span><br />
            <span class="NTs">
              <a href="#" onClick="ZDisplay(2,5);">Acts</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(2,27);">Revelations</a>
            </span>
            </p>
          </div>
          <h3 id="H3" class="horizontal_accordion_toggle BM"></h3>
          <div class="horizontal_accordion_content">
            <p>
            <span class="section BMs">About</span><br />
            <span class="BMs">
              <a href="#" onClick="ZDisplay(3,0);">Preface</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(3,-4);">The Three Witnesses</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(3,-3);">The Eight Witnesses</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(3,-2);">Joseph&nbsp;Smith&nbsp;Story</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(3,-1);">Content Overview</a>
              <br />__________________________<br />
            </span><br />
            <span class="section BMs">Small Plates of Nephi</span><br />
            <span class="BMs">
              <a href="#" onClick="ZDisplay(3,1);">1&nbsp;Nephi</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(3,2);">2&nbsp;Nephi</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(3,3);">Jacob</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(3,4);">Enos</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(3,5);">Jarom</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(3,6);">Omni</a>
            </span><br /><br />
            <span class="section BMs">Large Plates of Nephi</span><br />
            <span class="BMs">
              <a href="#" onClick="ZDisplay(3,8,0,0,0,0,'Abinadi.jpg','Abinadi calls on King Noah to repent');">Mosiah</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(3,9);">Alma</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(3,10);">Helaman</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(3,11);">3&nbsp;Nephi</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(3,12);">4&nbsp;Nephi</a>
            </span><br /><br />
            <span class="section BMs">Plates of Ether</span><br />
            <span class="BMs">
              <a href="#" onClick="ZDisplay(3,14);">Ether</a>
            </span><br /><br />
            <span class="section BMs">Epilogue</span><br />
            <span class="BMs">
              <a href="#" onClick="ZDisplay(3,0);">Preface</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(3,7);">Words&nbsp;of&nbsp;Mormon</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(3,13);">Mormon</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(3,15);">Moroni</a>
            </span>
            </p>
          </div>
          <h3 id="H4" class="horizontal_accordion_toggle DC"></h3>
          <div class="horizontal_accordion_content">
            <p>
            <span class="section DCs">Sections</span><br />
            <span class="DCs">
              <a href="#" onClick="ZDisplay(4,1);">1</a> 
              <a href="#" onClick="ZDisplay(4,2);">2</a> 
              <a href="#" onClick="ZDisplay(4,3);">3</a> 
              <a href="#" onClick="ZDisplay(4,4);">4</a> 
              <a href="#" onClick="ZDisplay(4,5);">5</a> 
              <a href="#" onClick="ZDisplay(4,6);">6</a> 
              <a href="#" onClick="ZDisplay(4,7);">7</a> 
              <a href="#" onClick="ZDisplay(4,8);">8</a> 
              <a href="#" onClick="ZDisplay(4,9);">9</a> 
              <a href="#" onClick="ZDisplay(4,10);">10</a> 
              <a href="#" onClick="ZDisplay(4,11);">11</a> 
              <a href="#" onClick="ZDisplay(4,12);">12</a> 
              <a href="#" onClick="ZDisplay(4,13);">13</a> 
              <a href="#" onClick="ZDisplay(4,14);">14</a> 
              <a href="#" onClick="ZDisplay(4,15);">15</a> 
              <a href="#" onClick="ZDisplay(4,16);">16</a> 
              <a href="#" onClick="ZDisplay(4,17);">17</a> 
              <a href="#" onClick="ZDisplay(4,18);">18</a> 
              <a href="#" onClick="ZDisplay(4,19);">19</a> 
              <a href="#" onClick="ZDisplay(4,20);">20</a> 
              <a href="#" onClick="ZDisplay(4,21);">21</a> 
              <a href="#" onClick="ZDisplay(4,22);">22</a> 
              <a href="#" onClick="ZDisplay(4,23);">23</a> 
              <a href="#" onClick="ZDisplay(4,24);">24</a> 
              <a href="#" onClick="ZDisplay(4,25);">25</a> 
              <a href="#" onClick="ZDisplay(4,26);">26</a> 
              <a href="#" onClick="ZDisplay(4,27);">27</a> 
              <a href="#" onClick="ZDisplay(4,28);">28</a> 
              <a href="#" onClick="ZDisplay(4,29);">29</a> 
              <a href="#" onClick="ZDisplay(4,30);">30</a> 
              <a href="#" onClick="ZDisplay(4,31);">31</a> 
              <a href="#" onClick="ZDisplay(4,32);">32</a> 
              <a href="#" onClick="ZDisplay(4,33);">33</a> 
              <a href="#" onClick="ZDisplay(4,34);">34</a> 
              <a href="#" onClick="ZDisplay(4,35);">35</a> 
              <a href="#" onClick="ZDisplay(4,36);">36</a> 
              <a href="#" onClick="ZDisplay(4,37);">37</a> 
              <a href="#" onClick="ZDisplay(4,38);">38</a> 
              <a href="#" onClick="ZDisplay(4,39);">39</a> 
              <a href="#" onClick="ZDisplay(4,40);">40</a> 
              <a href="#" onClick="ZDisplay(4,41);">41</a> 
              <a href="#" onClick="ZDisplay(4,42);">42</a> 
              <a href="#" onClick="ZDisplay(4,43);">43</a> 
              <a href="#" onClick="ZDisplay(4,44);">44</a> 
              <a href="#" onClick="ZDisplay(4,45);">45</a> 
              <a href="#" onClick="ZDisplay(4,46);">46</a> 
              <a href="#" onClick="ZDisplay(4,47);">47</a> 
              <a href="#" onClick="ZDisplay(4,48);">48</a> 
              <a href="#" onClick="ZDisplay(4,49);">49</a> 
              <a href="#" onClick="ZDisplay(4,50);">50</a> 
              <a href="#" onClick="ZDisplay(4,51);">51</a>
              <a href="#" onClick="ZDisplay(4,52);">52</a> 
              <a href="#" onClick="ZDisplay(4,53);">53</a> 
              <a href="#" onClick="ZDisplay(4,54);">54</a> 
              <a href="#" onClick="ZDisplay(4,55);">55</a> 
              <a href="#" onClick="ZDisplay(4,56);">56</a> 
              <a href="#" onClick="ZDisplay(4,57);">57</a> 
              <a href="#" onClick="ZDisplay(4,58);">58</a> 
              <a href="#" onClick="ZDisplay(4,59);">59</a> 
              <a href="#" onClick="ZDisplay(4,60);">60</a> 
              <a href="#" onClick="ZDisplay(4,61);">61</a> 
              <a href="#" onClick="ZDisplay(4,62);">62</a> 
              <a href="#" onClick="ZDisplay(4,63);">63</a> 
              <a href="#" onClick="ZDisplay(4,64);">64</a> 
              <a href="#" onClick="ZDisplay(4,65);">65</a> 
              <a href="#" onClick="ZDisplay(4,66);">66</a> 
              <a href="#" onClick="ZDisplay(4,67);">67</a> 
              <a href="#" onClick="ZDisplay(4,68);">68</a> 
              <a href="#" onClick="ZDisplay(4,69);">69</a> 
              <a href="#" onClick="ZDisplay(4,70);">70</a> 
              <a href="#" onClick="ZDisplay(4,71);">71</a> 
              <a href="#" onClick="ZDisplay(4,72);">72</a> 
              <a href="#" onClick="ZDisplay(4,73);">73</a> 
              <a href="#" onClick="ZDisplay(4,74);">74</a> 
              <a href="#" onClick="ZDisplay(4,75);">75</a> 
              <a href="#" onClick="ZDisplay(4,76);">76</a> 
              <a href="#" onClick="ZDisplay(4,77);">77</a> 
              <a href="#" onClick="ZDisplay(4,78);">78</a> 
              <a href="#" onClick="ZDisplay(4,79);">79</a> 
              <a href="#" onClick="ZDisplay(4,80);">80</a> 
              <a href="#" onClick="ZDisplay(4,81);">81</a> 
              <a href="#" onClick="ZDisplay(4,82);">82</a> 
              <a href="#" onClick="ZDisplay(4,83);">83</a> 
              <a href="#" onClick="ZDisplay(4,84);">84</a> 
              <a href="#" onClick="ZDisplay(4,85);">85</a> 
              <a href="#" onClick="ZDisplay(4,86);">86</a> 
              <a href="#" onClick="ZDisplay(4,87);">87</a> 
              <a href="#" onClick="ZDisplay(4,88);">88</a> 
              <a href="#" onClick="ZDisplay(4,89);">89</a> 
              <a href="#" onClick="ZDisplay(4,90);">90</a> 
              <a href="#" onClick="ZDisplay(4,91);">91</a> 
              <a href="#" onClick="ZDisplay(4,92);">92</a> 
              <a href="#" onClick="ZDisplay(4,93);">93</a> 
              <a href="#" onClick="ZDisplay(4,94);">94</a> 
              <a href="#" onClick="ZDisplay(4,95);">95</a> 
              <a href="#" onClick="ZDisplay(4,96);">96</a> 
              <a href="#" onClick="ZDisplay(4,97);">97</a> 
              <a href="#" onClick="ZDisplay(4,98);">98</a> 
              <a href="#" onClick="ZDisplay(4,99);">99</a> 
              <a href="#" onClick="ZDisplay(4,100);">100</a> 
              <a href="#" onClick="ZDisplay(4,101);">101</a> 
              <a href="#" onClick="ZDisplay(4,102);">102</a> 
              <a href="#" onClick="ZDisplay(4,103);">103</a> 
              <a href="#" onClick="ZDisplay(4,104);">104</a> 
              <a href="#" onClick="ZDisplay(4,105);">105</a> 
              <a href="#" onClick="ZDisplay(4,106);">106</a> 
              <a href="#" onClick="ZDisplay(4,107);">107</a> 
              <a href="#" onClick="ZDisplay(4,108);">108</a> 
              <a href="#" onClick="ZDisplay(4,109);">109</a> 
              <a href="#" onClick="ZDisplay(4,110);">110</a> 
              <a href="#" onClick="ZDisplay(4,111);">111</a> 
              <a href="#" onClick="ZDisplay(4,112);">112</a> 
              <a href="#" onClick="ZDisplay(4,113);">113</a> 
              <a href="#" onClick="ZDisplay(4,114);">114</a> 
              <a href="#" onClick="ZDisplay(4,115);">115</a> 
              <a href="#" onClick="ZDisplay(4,116);">116</a> 
              <a href="#" onClick="ZDisplay(4,117);">117</a> 
              <a href="#" onClick="ZDisplay(4,118);">118</a> 
              <a href="#" onClick="ZDisplay(4,119);">119</a> 
              <a href="#" onClick="ZDisplay(4,120);">120</a> 
              <a href="#" onClick="ZDisplay(4,121);">121</a> 
              <a href="#" onClick="ZDisplay(4,122);">122</a> 
              <a href="#" onClick="ZDisplay(4,123);">123</a> 
              <a href="#" onClick="ZDisplay(4,124);">124</a> 
              <a href="#" onClick="ZDisplay(4,125);">125</a> 
              <a href="#" onClick="ZDisplay(4,126);">126</a> 
              <a href="#" onClick="ZDisplay(4,127);">127</a> 
              <a href="#" onClick="ZDisplay(4,128);">128</a> 
              <a href="#" onClick="ZDisplay(4,129);">129</a> 
              <a href="#" onClick="ZDisplay(4,130);">130</a> 
              <a href="#" onClick="ZDisplay(4,131);">131</a> 
              <a href="#" onClick="ZDisplay(4,132);">132</a> 
              <a href="#" onClick="ZDisplay(4,133);">133</a> 
              <a href="#" onClick="ZDisplay(4,134);">134</a> 
              <a href="#" onClick="ZDisplay(4,135);">135</a> 
              <a href="#" onClick="ZDisplay(4,136);">136</a> 
              <a href="#" onClick="ZDisplay(4,137);">137</a> 
              <a href="#" onClick="ZDisplay(4,138);">138</a>
            </span><br /><br />
          <span class="section DCs">Official Declarations</span><br />
            <span class="DCs">
            <span class="DCs">
              <a href="#" onClick="ZDisplay(4,150);">Official&nbsp;Declaration-1</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(4,151);">Official&nbsp;Declaration-2</a>
            </span>
          </p>
        </div>
        <h3 id="H5" class="horizontal_accordion_toggle PP"></h3>
        <div class="horizontal_accordion_content">
          <p>
          <span class="section PPs">Books</span><br />
            <span class="PPs">
              <a href="#" onClick="ZDisplay(5,1);">Moses</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(5,2);">Abraham</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(5,3);">Joseph&nbsp;Smith-Matthew</a>&nbsp;-  
              <a href="#" onClick="ZDisplay(5,4);">Joseph&nbsp;Smith-History</a> 
            </span><br /><br />
            <span class="section PPs">Declaration</span><br />
            <span class="PPs">
              <a href="#" onClick="ZDisplay(5,5);">Articles of Faith</a>
            </span>
            </p>
          </div>
        </div>
      </div>
      <p id="volume_book_title"></p> 
      <p id="other_title"></p>
    </div>
    <div id="bottom_container">
      <div id="vertical_container">
        <h1 id="C1" class="accordion_toggle"></h1><div id="V1" class="accordion_content parchment"></div>
        <h1 id="C2" class="accordion_toggle"></h1><div id="V2" class="accordion_content parchment"></div>
        <h1 id="C3" class="accordion_toggle"></h1><div id="V3" class="accordion_content parchment"></div>
        <h1 id="C4" class="accordion_toggle"></h1><div id="V4" class="accordion_content parchment"></div>
        <h1 id="C5" class="accordion_toggle"></h1><div id="V5" class="accordion_content parchment"></div>
        <h1 id="C6" class="accordion_toggle"></h1><div id="V6" class="accordion_content parchment"></div>
        <h1 id="C7" class="accordion_toggle"></h1><div id="V7" class="accordion_content parchment"></div>
        <h1 id="C8" class="accordion_toggle"></h1><div id="V8" class="accordion_content parchment"></div>
        <h1 id="C9" class="accordion_toggle"></h1><div id="V9" class="accordion_content parchment"></div>
        <h1 id="C10" class="accordion_toggle"></h1><div id="V10" class="accordion_content parchment"></div>
        <h1 id="C11" class="accordion_toggle"></h1><div id="V11" class="accordion_content parchment"></div>
        <h1 id="C12" class="accordion_toggle"></h1><div id="V12" class="accordion_content parchment"></div>
        <h1 id="C13" class="accordion_toggle"></h1><div id="V13" class="accordion_content parchment"></div>
        <h1 id="C14" class="accordion_toggle"></h1><div id="V14" class="accordion_content parchment"></div>
        <h1 id="C15" class="accordion_toggle"></h1><div id="V15" class="accordion_content parchment"></div>
        <h1 id="C16" class="accordion_toggle"></h1><div id="V16" class="accordion_content parchment"></div>
        <h1 id="C17" class="accordion_toggle"></h1><div id="V17" class="accordion_content parchment"></div>
        <h1 id="C18" class="accordion_toggle"></h1><div id="V18" class="accordion_content parchment"></div>
        <h1 id="C19" class="accordion_toggle"></h1><div id="V19" class="accordion_content parchment"></div>
        <h1 id="C20" class="accordion_toggle"></h1><div id="V20" class="accordion_content parchment"></div>
        <h1 id="C21" class="accordion_toggle"></h1><div id="V21" class="accordion_content parchment"></div>
        <h1 id="C22" class="accordion_toggle"></h1><div id="V22" class="accordion_content parchment"></div>
        <h1 id="C23" class="accordion_toggle"></h1><div id="V23" class="accordion_content parchment"></div>
        <h1 id="C24" class="accordion_toggle"></h1><div id="V24" class="accordion_content parchment"></div>
        <h1 id="C25" class="accordion_toggle"></h1><div id="V25" class="accordion_content parchment"></div>
        <h1 id="C26" class="accordion_toggle"></h1><div id="V26" class="accordion_content parchment"></div>
        <h1 id="C27" class="accordion_toggle"></h1><div id="V27" class="accordion_content parchment"></div>
        <h1 id="C28" class="accordion_toggle"></h1><div id="V28" class="accordion_content parchment"></div>
        <h1 id="C29" class="accordion_toggle"></h1><div id="V29" class="accordion_content parchment"></div>
        <h1 id="C30" class="accordion_toggle"></h1><div id="V30" class="accordion_content parchment"></div>
        <h1 id="C31" class="accordion_toggle"></h1><div id="V31" class="accordion_content parchment"></div>
        <h1 id="C32" class="accordion_toggle"></h1><div id="V32" class="accordion_content parchment"></div>
        <h1 id="C33" class="accordion_toggle"></h1><div id="V33" class="accordion_content parchment"></div>
        <h1 id="C34" class="accordion_toggle"></h1><div id="V34" class="accordion_content parchment"></div>
        <h1 id="C35" class="accordion_toggle"></h1><div id="V35" class="accordion_content parchment"></div>
        <h1 id="C36" class="accordion_toggle"></h1><div id="V36" class="accordion_content parchment"></div>
        <h1 id="C37" class="accordion_toggle"></h1><div id="V37" class="accordion_content parchment"></div>
        <h1 id="C38" class="accordion_toggle"></h1><div id="V38" class="accordion_content parchment"></div>
        <h1 id="C39" class="accordion_toggle"></h1><div id="V39" class="accordion_content parchment"></div>
        <h1 id="C40" class="accordion_toggle"></h1><div id="V40" class="accordion_content parchment"></div>
        <h1 id="C41" class="accordion_toggle"></h1><div id="V41" class="accordion_content parchment"></div>
        <h1 id="C42" class="accordion_toggle"></h1><div id="V42" class="accordion_content parchment"></div>
        <h1 id="C43" class="accordion_toggle"></h1><div id="V43" class="accordion_content parchment"></div>
        <h1 id="C44" class="accordion_toggle"></h1><div id="V44" class="accordion_content parchment"></div>
        <h1 id="C45" class="accordion_toggle"></h1><div id="V45" class="accordion_content parchment"></div>
        <h1 id="C46" class="accordion_toggle"></h1><div id="V46" class="accordion_content parchment"></div>
        <h1 id="C47" class="accordion_toggle"></h1><div id="V47" class="accordion_content parchment"></div>
        <h1 id="C48" class="accordion_toggle"></h1><div id="V48" class="accordion_content parchment"></div>
        <h1 id="C49" class="accordion_toggle"></h1><div id="V49" class="accordion_content parchment"></div>
        <h1 id="C50" class="accordion_toggle"></h1><div id="V50" class="accordion_content parchment"></div>
        <h1 id="C51" class="accordion_toggle"></h1><div id="V51" class="accordion_content parchment"></div>
        <h1 id="C52" class="accordion_toggle"></h1><div id="V52" class="accordion_content parchment"></div>
        <h1 id="C53" class="accordion_toggle"></h1><div id="V53" class="accordion_content parchment"></div>
        <h1 id="C54" class="accordion_toggle"></h1><div id="V54" class="accordion_content parchment"></div>
        <h1 id="C55" class="accordion_toggle"></h1><div id="V55" class="accordion_content parchment"></div>
        <h1 id="C56" class="accordion_toggle"></h1><div id="V56" class="accordion_content parchment"></div>
        <h1 id="C57" class="accordion_toggle"></h1><div id="V57" class="accordion_content parchment"></div>
        <h1 id="C58" class="accordion_toggle"></h1><div id="V58" class="accordion_content parchment"></div>
        <h1 id="C59" class="accordion_toggle"></h1><div id="V59" class="accordion_content parchment"></div>
        <h1 id="C60" class="accordion_toggle"></h1><div id="V60" class="accordion_content parchment"></div>
        <h1 id="C61" class="accordion_toggle"></h1><div id="V61" class="accordion_content parchment"></div>
        <h1 id="C62" class="accordion_toggle"></h1><div id="V62" class="accordion_content parchment"></div>
        <h1 id="C63" class="accordion_toggle"></h1><div id="V63" class="accordion_content parchment"></div>
        <h1 id="C64" class="accordion_toggle"></h1><div id="V64" class="accordion_content parchment"></div>
        <h1 id="C65" class="accordion_toggle"></h1><div id="V65" class="accordion_content parchment"></div>
        <h1 id="C66" class="accordion_toggle"></h1><div id="V66" class="accordion_content parchment"></div>
        <h1 id="C67" class="accordion_toggle"></h1><div id="V67" class="accordion_content parchment"></div>
        <h1 id="C68" class="accordion_toggle"></h1><div id="V68" class="accordion_content parchment"></div>
        <h1 id="C69" class="accordion_toggle"></h1><div id="V69" class="accordion_content parchment"></div>
        <h1 id="C70" class="accordion_toggle"></h1><div id="V70" class="accordion_content parchment"></div>
        <h1 id="C71" class="accordion_toggle"></h1><div id="V71" class="accordion_content parchment"></div>
        <h1 id="C72" class="accordion_toggle"></h1><div id="V72" class="accordion_content parchment"></div>
        <h1 id="C73" class="accordion_toggle"></h1><div id="V73" class="accordion_content parchment"></div>
        <h1 id="C74" class="accordion_toggle"></h1><div id="V74" class="accordion_content parchment"></div>
        <h1 id="C75" class="accordion_toggle"></h1><div id="V75" class="accordion_content parchment"></div>
        <h1 id="C76" class="accordion_toggle"></h1><div id="V76" class="accordion_content parchment"></div>
        <h1 id="C77" class="accordion_toggle"></h1><div id="V77" class="accordion_content parchment"></div>
        <h1 id="C78" class="accordion_toggle"></h1><div id="V78" class="accordion_content parchment"></div>
        <h1 id="C79" class="accordion_toggle"></h1><div id="V79" class="accordion_content parchment"></div>
        <h1 id="C80" class="accordion_toggle"></h1><div id="V80" class="accordion_content parchment"></div>
        <h1 id="C81" class="accordion_toggle"></h1><div id="V81" class="accordion_content parchment"></div>
        <h1 id="C82" class="accordion_toggle"></h1><div id="V82" class="accordion_content parchment"></div>
        <h1 id="C83" class="accordion_toggle"></h1><div id="V83" class="accordion_content parchment"></div>
        <h1 id="C84" class="accordion_toggle"></h1><div id="V84" class="accordion_content parchment"></div>
        <h1 id="C85" class="accordion_toggle"></h1><div id="V85" class="accordion_content parchment"></div>
        <h1 id="C86" class="accordion_toggle"></h1><div id="V86" class="accordion_content parchment"></div>
        <h1 id="C87" class="accordion_toggle"></h1><div id="V87" class="accordion_content parchment"></div>
        <h1 id="C88" class="accordion_toggle"></h1><div id="V88" class="accordion_content parchment"></div>
        <h1 id="C89" class="accordion_toggle"></h1><div id="V89" class="accordion_content parchment"></div>
        <h1 id="C90" class="accordion_toggle"></h1><div id="V90" class="accordion_content parchment"></div>
        <h1 id="C91" class="accordion_toggle"></h1><div id="V91" class="accordion_content parchment"></div>
        <h1 id="C92" class="accordion_toggle"></h1><div id="V92" class="accordion_content parchment"></div>
        <h1 id="C93" class="accordion_toggle"></h1><div id="V93" class="accordion_content parchment"></div>
        <h1 id="C94" class="accordion_toggle"></h1><div id="V94" class="accordion_content parchment"></div>
        <h1 id="C95" class="accordion_toggle"></h1><div id="V95" class="accordion_content parchment"></div>
        <h1 id="C96" class="accordion_toggle"></h1><div id="V96" class="accordion_content parchment"></div>
        <h1 id="C97" class="accordion_toggle"></h1><div id="V97" class="accordion_content parchment"></div>
        <h1 id="C98" class="accordion_toggle"></h1><div id="V98" class="accordion_content parchment"></div>
        <h1 id="C99" class="accordion_toggle"></h1><div id="V99" class="accordion_content parchment"></div>
        <h1 id="C100" class="accordion_toggle"></h1><div id="V100" class="accordion_content parchment"></div>
        <h1 id="C101" class="accordion_toggle"></h1><div id="V101" class="accordion_content parchment"></div>
        <h1 id="C102" class="accordion_toggle"></h1><div id="V102" class="accordion_content parchment"></div>
        <h1 id="C103" class="accordion_toggle"></h1><div id="V103" class="accordion_content parchment"></div>
        <h1 id="C104" class="accordion_toggle"></h1><div id="V104" class="accordion_content parchment"></div>
        <h1 id="C105" class="accordion_toggle"></h1><div id="V105" class="accordion_content parchment"></div>
        <h1 id="C106" class="accordion_toggle"></h1><div id="V106" class="accordion_content parchment"></div>
        <h1 id="C107" class="accordion_toggle"></h1><div id="V107" class="accordion_content parchment"></div>
        <h1 id="C108" class="accordion_toggle"></h1><div id="V108" class="accordion_content parchment"></div>
        <h1 id="C109" class="accordion_toggle"></h1><div id="V109" class="accordion_content parchment"></div>
        <h1 id="C110" class="accordion_toggle"></h1><div id="V110" class="accordion_content parchment"></div>
        <h1 id="C111" class="accordion_toggle"></h1><div id="V111" class="accordion_content parchment"></div>
        <h1 id="C112" class="accordion_toggle"></h1><div id="V112" class="accordion_content parchment"></div>
        <h1 id="C113" class="accordion_toggle"></h1><div id="V113" class="accordion_content parchment"></div>
        <h1 id="C114" class="accordion_toggle"></h1><div id="V114" class="accordion_content parchment"></div>
        <h1 id="C115" class="accordion_toggle"></h1><div id="V115" class="accordion_content parchment"></div>
        <h1 id="C116" class="accordion_toggle"></h1><div id="V116" class="accordion_content parchment"></div>
        <h1 id="C117" class="accordion_toggle"></h1><div id="V117" class="accordion_content parchment"></div>
        <h1 id="C118" class="accordion_toggle"></h1><div id="V118" class="accordion_content parchment"></div>
        <h1 id="C119" class="accordion_toggle"></h1><div id="V119" class="accordion_content parchment"></div>
        <h1 id="C120" class="accordion_toggle"></h1><div id="V120" class="accordion_content parchment"></div>
        <h1 id="C121" class="accordion_toggle"></h1><div id="V121" class="accordion_content parchment"></div>
        <h1 id="C122" class="accordion_toggle"></h1><div id="V122" class="accordion_content parchment"></div>
        <h1 id="C123" class="accordion_toggle"></h1><div id="V123" class="accordion_content parchment"></div>
        <h1 id="C124" class="accordion_toggle"></h1><div id="V124" class="accordion_content parchment"></div>
        <h1 id="C125" class="accordion_toggle"></h1><div id="V125" class="accordion_content parchment"></div>
        <h1 id="C126" class="accordion_toggle"></h1><div id="V126" class="accordion_content parchment"></div>
        <h1 id="C127" class="accordion_toggle"></h1><div id="V127" class="accordion_content parchment"></div>
        <h1 id="C128" class="accordion_toggle"></h1><div id="V128" class="accordion_content parchment"></div>
        <h1 id="C129" class="accordion_toggle"></h1><div id="V129" class="accordion_content parchment"></div>
        <h1 id="C130" class="accordion_toggle"></h1><div id="V130" class="accordion_content parchment"></div>
        <h1 id="C131" class="accordion_toggle"></h1><div id="V131" class="accordion_content parchment"></div>
        <h1 id="C132" class="accordion_toggle"></h1><div id="V132" class="accordion_content parchment"></div>
        <h1 id="C133" class="accordion_toggle"></h1><div id="V133" class="accordion_content parchment"></div>
        <h1 id="C134" class="accordion_toggle"></h1><div id="V134" class="accordion_content parchment"></div>
        <h1 id="C135" class="accordion_toggle"></h1><div id="V135" class="accordion_content parchment"></div>
        <h1 id="C136" class="accordion_toggle"></h1><div id="V136" class="accordion_content parchment"></div>
        <h1 id="C137" class="accordion_toggle"></h1><div id="V137" class="accordion_content parchment"></div>
        <h1 id="C138" class="accordion_toggle"></h1><div id="V138" class="accordion_content parchment"></div>
        <h1 id="C139" class="accordion_toggle"></h1><div id="V139" class="accordion_content parchment"></div>
        <h1 id="C140" class="accordion_toggle"></h1><div id="V140" class="accordion_content parchment"></div>
        <h1 id="C141" class="accordion_toggle"></h1><div id="V141" class="accordion_content parchment"></div>
        <h1 id="C142" class="accordion_toggle"></h1><div id="V142" class="accordion_content parchment"></div>
        <h1 id="C143" class="accordion_toggle"></h1><div id="V143" class="accordion_content parchment"></div>
        <h1 id="C144" class="accordion_toggle"></h1><div id="V144" class="accordion_content parchment"></div>
        <h1 id="C145" class="accordion_toggle"></h1><div id="V145" class="accordion_content parchment"></div>
        <h1 id="C146" class="accordion_toggle"></h1><div id="V146" class="accordion_content parchment"></div>
        <h1 id="C147" class="accordion_toggle"></h1><div id="V147" class="accordion_content parchment"></div>
        <h1 id="C148" class="accordion_toggle"></h1><div id="V148" class="accordion_content parchment"></div>
        <h1 id="C149" class="accordion_toggle"></h1><div id="V149" class="accordion_content parchment"></div>
        <h1 id="C150" class="accordion_toggle"></h1><div id="V150" class="accordion_content parchment"></div>
      </div>
      <textarea id="updatecomment" onblur="SaveMyComment();" name="code" rows="50" cols="42">
      </textarea>
      <?php 
        echo '<div id="commenttext" onclick="EditMyComment(event);"></div>';
      ?>
    </div>
    <center style="color:white;">2012 MCS, Inc
    <p>
<!--
    <a href="http://validator.w3.org/check?uri=referer">
      <img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" />
    </a>
    <a href="http://digg.com/submit?url=http://news.netcraft.com/archives/2008/11/05/hosting_provider_switching_analysis.html" title="Digg This!"><img src="images/digg.png" alt="Digg" /> Digg</a>
    <a href="http://slashdot.org/bookmark.pl?url=http://news.netcraft.com/archives/2008/11/05/hosting_provider_switching_analysis.html" title="Submit to Slashdot"><img src="images/slashdot.png" alt="Slashdot" /> Slashdot</a>
    <a href="http://reddit.com/submit?url=http://news.netcraft.com/archives/2008/11/05/hosting_provider_switching_analysis.html" title="Submit to Reddit"><img src="images/reddit.gif" alt="Reddit" /> Reddit</a>
    <a href="http://www.stumbleupon.com/submit?url=http://news.netcraft.com/archives/2008/11/05/hosting_provider_switching_analysis.html" title="Stumble This!"><img src="images/stumbleupon.png" alt="StumbleUpon" /> StumbleUpon</a>
    <a href="http://del.icio.us/post?url=http://news.netcraft.com/archives/2008/11/05/hosting_provider_switching_analysis.html" title="Bookmark on Delicious"><img src="images/delicious.png" alt="Delicious" /> Delicious</a>
    <a href="http://technorati.com/faves/?add=http://news.netcraft.com/archives/2008/11/05/hosting_provider_switching_analysis.html" title="Add to Technorati Faves"><img src="images/technorati.png" alt="Technorati" /> Technorati</a>
    </p>
    </center>
-->
    <script type="text/javascript" src="js/Libraries.js"></script>
    <script type="text/javascript" src="js/Zajax.js"></script>
  </body>
</div>
</html>