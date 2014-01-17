// GLOBALS
var AJAX;
var CURRCOLOR;
var VOL;
var BK;
var EVT;
var myTOP;
var CTYPE;
var CNAME;
var CVERSEID;
var CURRROW;
var CHAPTER_KEY;
var CHAPTER_VERSE="";
var VERSE_SIZE="1em";
var TOTAL_CHAPTERS;
var SEARCHWORDS = new Array();
var CURRSCRIPTURE="";
var myXML;
var PARAMS="";
var URL="";
// Standard utility functions for AJAX and XML

function getNewXMLHttpRequest() {
  var Obj = false;
  try {
    Obj = new XMLHttpRequest();
  } catch (trymicrosoft) {
    try {
      Obj = new ActiveXObject('Msxml2.XMLHTTP');
    } catch (othermicrosoft) {
      try {
        Obj = new ActiveXObject('Microsoft.XMLHTTP');
      } catch (failed) {
        try {
          AJAX = window.createRequest();
        } catch (e) {
          Obj = false;
        }
      }
    }
  }
  return Obj;
}
function XMLnewDocument(rootTagName, namespaceURL) {
  if (!rootTagName) rootTagName = "";
  if (!namespaceURL) namespaceURL = "";

  if (document.implementation && document.implementation.createDocument) {
    // This is the W3C standard way to do it
    return document.implementation.createDocument(namespaceURL, rootTagName, null);
  } else { 
    // This is the IE way to do it
    // Create an empty document as an ActiveX object. If there is no root element, this is all we have to do
    var doc = new ActiveXObject("MSXML2.DOMDocument");
    // If there is a root tag, initialize the document
    if (rootTagName) {
      // Look for a namespace prefix
      var prefix = "";
      var tagname = rootTagName;
      var p = rootTagName.indexOf(':');
      if (p != -1) {
        prefix = rootTagName.substring(0, p);
        tagname = rootTagName.substring(p+1);
      }
      // If we have a namespace, we must have a namespace prefix
      // If we don't have a namespace, we discard any prefix
      if (namespaceURL) {
        if (!prefix) prefix = "a0"; // What Firefox uses
      } else {
        prefix = "";
      }
      // Create the root element (with optional namespace) as a string of text
      var text = "<" + (prefix?(prefix+":"):"") + tagname + (namespaceURL?(" xmlns:" + prefix + '="' + namespaceURL +'"'):"") + "/>";
      // And parse that text into the empty document
      doc.loadXML(text);
    }
    return doc;
  }
}
function XMLparse(text) {
  if (typeof DOMParser != "undefined") {
    // Mozilla, Firefox, and related browsers
    return (new DOMParser()).parseFromString(text, "application/xml");
  } else if (typeof ActiveXObject != "undefined") {
    // Internet Explorer.
    var doc = XMLnewDocument( );   // Create an empty document
    doc.loadXML(text);              //  Parse text into it
    return doc;                     // Return it
  } else {
    // As a last resort, try loading the document from a data: URL
    // This is supposed to work in Safari. Thanks to Manos Batsis and
    // his Sarissa library (sarissa.sourceforge.net) for this technique.
    var url = "data:text/xml;charset=utf-8," + encodeURIComponent(text);
    var request = new XMLHttpRequest();
    request.open("GET", url, false);
    request.send(null);
    return request.responseXML;
  }
}

// Start of application functions

function EditMyComment(myEVT2) {
  if ((getURLparam('pswd') === "jdm1234") && (myEVT2.ctrlKey === true)) {
    var target = "|"+CTYPE+"|"+decodeURIComponent(CNAME)+"|"+CURRROW+"|";
    var text_no_html = document.getElementById("commenttext").innerHTML;
    text_no_html = text_no_html.substr(text_no_html.indexOf("a>")+2);
    document.getElementById("updatecomment").value = target+text_no_html;
    document.getElementById("updatecomment").style.top = myTOP+'px';
    ShowCommentEdit();
  }
  return true;
}

function SavemyComment() {
  var ctext = document.getElementById("updatecomment").value;
  var text_no_html = document.getElementById("commenttext").innerHTML;
  if (text_no_html.indexOf("CloseButton") > 0) text_no_html = text_no_html.substr(text_no_html.indexOf("a>")+2);
  if (text_no_html != ctext) {
    var commentaryText;
    var myCommands="";
    var sqlCommand="";
    var t;
    var rowPtr;
    var url;
    var lastRow;
    var Links = new Array();
    if (ctext.substr(0,1) == "+" || ctext.substr(0,1) == "-" || ctext.substr(0,1) == ":") {
      myInput = ctext.split("|");
      myCommands = myInput[0];
      if (myInput[1] !== "") CTYPE = myInput[1];
      if (myInput[2] !== "") CNAME = myInput[2];
      if (myInput[3] !== "") CURRROW = myInput[3];
      if (CURRROW.indexOf("-") != -1) {
        lastRow = Extract(CURRROW,"-",2);
        CURRROW = Extract(CURRROW,"-",1);
        myCommands="+";
      } else {
        lastRow = CURRROW;
      }
      commentaryText = myInput[4];
    } else if (ctext.substr(0,1) == "|") {
      myInput = ctext.split("|");
      commentaryText = myInput[4];
    } else {
      commentaryText = ctext;
    }
    document.getElementById("updatecomment").value = commentaryText;
    CURRROW = parseInt(CURRROW,10);
    lastRow = parseInt(lastRow,10);
    CVERSEID = "";
    for(rowPtr = CURRROW; rowPtr <= lastRow; rowPtr++) {
      t = document.getElementById("CTable_"+CHAPTER_KEY).rows[rowPtr-1];
      CVERSEID = CVERSEID+","+t.cells[4].title;
      CHAPTER_VERSE = t.cells[0].innerHTML;
      if (myCommands === "-") {
        var CellText = t.cells[4].innerHTML;
        var NewLinks = "";
        CellText = CellText.slice(1,-1);
        Links = CellText.split("> <");
        for(i = 0; i < Links.length; i++) {
          if (Links[i].indexOf(CNAME,0) == -1) {
            NewLinks = NewLinks+"<"+Links[i]+"> ";
          }
        }
        commentaryText = "";
        t.cells[4].innerHTML = NewLinks;
        sqlCommand = "remove";
      } else if (myCommands === "+") {
        if ((t.cells[4].innerHTML).indexOf(MakeLink(CVERSEID,CHAPTER_KEY,rowPtr,CTYPE,CNAME)) === -1) {
          t.cells[4].innerHTML = t.cells[4].innerHTML+MakeLink(CVERSEID,CHAPTER_KEY,rowPtr,CTYPE,CNAME);
        }
        sqlCommand = "insert";
      } else if (myCommands === ":") {
        sqlCommand = "append";
      } else {
        sqlCommand = "replace";
      }
    }
    if (CVERSEID.substr(0,1) === ",") CVERSEID = CVERSEID.substr(1);
    AJAX = getNewXMLHttpRequest();
    if (!AJAX) alert('Error initializing XMLHttpRequest! The Browser is incompatible.');
    URL = "PHP/ZSaveComment.php";
    PARAMS = "id=" + CVERSEID + "&type=" + CTYPE + "&name=" + CNAME + "&cmd=" + sqlCommand + "&comment=" + commentaryText;
    AJAX.open('POST', URL, true);
    AJAX.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    AJAX.setRequestHeader("Content-length", PARAMS.length);
    // AJAX.setRequestHeader("Connection", "close");
    AJAX.onreadystatechange = function() { ReShowCommentary(myCommands); }
    AJAX.send(PARAMS);
  }
  ShowComment();
  return true;
}

function ReShowCommentary(action) {
  if (AJAX.readyState == 4) {
    /* Server is done with the task */
    if (AJAX.status == 200) {
      if (action == "insert") {
        var response = AJAX.responseText;
        document.getElementById("commenttext").innerHTML=CloseButtonStr(CHAPTER_VERSE)+response;
      } else if (action == "remove") {
        document.getElementById("commenttext").innerHTML=CloseButtonStr(CHAPTER_VERSE);
      } else {
        var updatedText = document.getElementById("updatecomment").value;
        document.getElementById("commenttext").innerHTML=CloseButtonStr(CHAPTER_VERSE)+updatedText;
      }
    }
  }
}


function ShowScriptures() {
  document.getElementById("horizontal_container").style.display = "block";
  document.getElementById("essay_container").style.display = "none";
  document.getElementById("commentary_container").style.display = "none";
  document.getElementById("search_container").style.display = "none";
  return true;
}

function ShowCommentaries() {
  document.getElementById("horizontal_container").style.display = "none";
  document.getElementById("commentary_container").style.display = "block";
  document.getElementById("essay_container").style.display = "none";
  document.getElementById("search_container").style.display = "none";
  return true;
}

function ShowEssays() {
  document.getElementById("horizontal_container").style.display = "none";
  document.getElementById("commentary_container").style.display = "none";
  document.getElementById("essay_container").style.display = "block";
  document.getElementById("search_container").style.display = "none";
  return true;
}
function DoSearch() {
  document.getElementById("horizontal_container").style.display = "none";
  document.getElementById("commentary_container").style.display = "none";
  document.getElementById("essay_container").style.display = "none";
  document.getElementById("search_container").style.display = "block";
  return true;
}

function Essay(myCNAME) {
  HideComment();
  CNAME = myCNAME;
  //CTYPE = myCTYPE;
  HideVerses();
  document.getElementById("volume_title").innerHTML = "<img src = 'js/images/search.gif'>";
  document.getElementById("book_title").innerHTML = CNAME;
  AJAX = getNewXMLHttpRequest();
  if (!AJAX) alert('Error initializing XMLHttpRequest! The Browser you are using is not compatible with this page.');
  URL = "PHP/ZEssay_XML.php?name="+CNAME;
  PARAMS = "";
  AJAX.open('GET', URL, true);
  AJAX.onreadystatechange = populateDisplay;
  AJAX.send(null);
}

function Search() {
  HideComment();
  cmd = document.getElementById("searchfor").value;
  if (document.getElementById("OT_chk").checked === true) {OT = document.getElementById("OT_chk").value;} else {OT = "no";}
  if (document.getElementById("NT_chk").checked === true) {NT = document.getElementById("NT_chk").value;} else {NT = "no";}
  if (document.getElementById("BM_chk").checked === true) {BM = document.getElementById("BM_chk").value;} else {BM = "no";}
  if (document.getElementById("DC_chk").checked === true) {DC = document.getElementById("DC_chk").value;} else {DC = "no";}
  if (document.getElementById("PP_chk").checked === true) {PP = document.getElementById("PP_chk").value;} else {PP = "no";}
  HideVerses();
  document.getElementById("volume_title").innerHTML = "<img src = 'js/images/search.gif'>";
  document.getElementById("book_title").innerHTML = "&nbsp;";
  AJAX = getNewXMLHttpRequest();
  if (!AJAX) alert('Error initializing XMLHttpRequest! The Browser is incompatible.');
  var encoded_cmd = encodeURIComponent(cmd);
  if (getURLparam('pswd') === "jdm1234") {
    URL = "PHP/ZSearch_XML.php?cmd="+encoded_cmd+"&OT="+OT+"&NT="+NT+"&BM="+BM+"&DC="+DC+"&PP="+PP+"&diag=SQL";
  } else {
    URL = "PHP/ZSearch_XML.php?cmd="+encoded_cmd+"&OT="+OT+"&NT="+NT+"&BM="+BM+"&DC="+DC+"&PP="+PP;
  }
  PARAMS = "";
  AJAX.open('GET', URL, true);
  AJAX.onreadystatechange = populateDisplay;
  AJAX.send(null);
}

function populateDisplay() {
  if (AJAX.readyState == 4) {
    if (AJAX.status == 200) {
      var searchType="";
      var sidebar="";
      var pswd = getURLparam("pswd");
      document.getElementById("volume_title").style.color = CURRCOLOR;
      myXML = XMLparse(AJAX.responseText);
      //myXML.parse(AJAX.responseText);
      var scripture = myXML.getElementsByTagName('scriptures');
      for (var scr = 0; scr < scripture.length; scr++) {
        if (pswd === "jdm1234") {
          document.getElementById("searchresults").innerHTML = URL+PARAMS+scripture[scr].getAttribute("sql")+"   ";
        } else {
          document.getElementById("searchresults").innerHTML = "";
        }
        SEARCHWORDS.length = 0;
        if (scripture[scr].getAttribute("type") === "find") {
          mySearch = document.getElementById("searchfor").value;
          if (mySearch.count('"') % 2 === 0) {
            var ExactPhrases = new Array();
            ExactPhrases = mySearch.split('"');
            var i = 0;
              // string includes literal phrases of matching quotes
            for (var phrase = 0; phrase < ExactPhrases.length; phrase++) {
              ExactPhrases[phrase] = ExactPhrases[phrase].replace(/^\s*|\s*$|[\+\-<>\(\)\*]/g,"");
              if (ExactPhrases[phrase] !== "") {
                if (phrase % 2 === 0) {
                  for (var w = 0; w <= ExactPhrases[phrase].count(" "); w++) {
                    SEARCHWORDS[i] = Extract(ExactPhrases[phrase]," ",w+1);
                    i++;
                  }
                } else {
                  SEARCHWORDS[i] = ExactPhrases[phrase];
                  i++;
                }
              }
            }
          } else {
            mySearch = strReplace(mySearch,'"','');
            SEARCHWORDS = mySearch.split(" ");
          }
        }
        if (scripture.length < 1) {
          if (scripture[scr].getAttribute("type") === "find") {
            document.getElementById("volume_title").innerHTML = "No match verses were found.";
            searchType = "find";
          } else {
            document.getElementById("volume_title").innerHTML = "Missing Verses "+VOL+", "+BK;
            searchType = "list";
          }
        } else {
          document.getElementById("bottom_container").style.display = "block";
          document.getElementById("bottom_container").style.visibility = "visible";
          document.getElementById("vertical_container").style.visibility = "visible";
          document.getElementById("book_title").style.color = CURRCOLOR;
          document.getElementById("volume_title").innerHTML = ""; 
          document.getElementById("book_title").innerHTML = "";
          TOTAL_CHAPTERS = 0;
          var drop_cnt = 0;
          var verse_cnt = 0;
          var volume = scripture[scr].getElementsByTagName('volume');
          for (var vol = 0; vol < volume.length; vol++) {
            var volume_name = volume[vol].getAttribute("title");
            var volume_num = volume[vol].getAttribute("num");
            switch(volume[vol].getAttribute("num")) {
              case "1":  VolColor = "#E6BE85";  break;    
              case "2":  VolColor = "#66B985";  break;
              case "3":  VolColor = "#76A5F3";  break;
              case "4":  VolColor = "#F098F9";  break;
              default:   VolColor = "#F0F1F3";  break;
            }
            var mytext = new Array();
            var book = volume[vol].getElementsByTagName('book');
            for (var bk = 0; bk < book.length; bk++) {
              TOTAL_CHAPTERS = TOTAL_CHAPTERS + book[bk].childNodes.length;
              if (scripture[scr].getAttribute("type") === "find" || scripture[scr].getAttribute("type") === "Commentary Results") {
                searchType = "find";
              } else if (scripture[scr].getAttribute("type") === "List") {
                document.getElementById("volume_title").innerHTML = "The " + volume[scr].getAttribute("title"); 
                if (book[0].getAttribute("comments") == null) {
                  commentary_cnt = 0;
                } else {
                  commentary_cnt = book[0].getAttribute("comments");
                }
                document.getElementById("book_title").innerHTML = book[bk].getAttribute("title") + "&nbsp;&nbsp;&nbsp;&nbsp;("+TOTAL_CHAPTERS+" Chapters, "+commentary_cnt+" Commentaries)";
                SEARCHWORDS[0]="";
                searchType = "list";
              }
              var book_name = book[bk].getAttribute("title");
              var book_num = book[bk].getAttribute("num");
              var chapter = book[bk].getElementsByTagName('chapter');
              for(var ch = 0; ch < chapter.length; ch++) {
                drop_cnt++;
                var chapter_num = chapter[ch].getAttribute("num");
                var num_chapter_comments = chapter[ch].getAttribute("comments");
                var chapter_name = chapter[ch].getAttribute("title");
                var compare_to = chapter[ch].getAttribute("compare");
                if (compare_to == null || compare_to === " ") {
                  compare_to = "";
                } else {
                  compare_to = book_name+" "+chapter_num+" &Delta; " + compare_to;
                }
                var chapter_key = volume_num+"_"+book_num+"_"+chapter_num;
                mytext.length = 0;
                mytext[0] = ChapterControlPanel(volume_num,book_num,chapter_num,drop_cnt,searchType,compare_to);
                mytext[0] += "<table style=\"font-size:"+VERSE_SIZE+"; display: block;\" id=\"CTable_"+chapter_key+"\">";
                //mytext[0] += "<colgroup span='2'></colgroup><colgroup span='2'></colgroup><colgroup></colgroup>";
                var verse = chapter[ch].getElementsByTagName("verse");
                for(var v = 0; v < verse.length; v++) {
                   verse_cnt++;
                  var VerseId = verse[v].getAttribute("id");
                  var ScriptureVerse = verse[v].getAttribute("num");
                  var ScriptureMark = verse[v].getAttribute("mark");
                  if (ScriptureMark == null) {
                    ScriptureMark = "";
                  } else {
                    ScriptureMark = " "+ScriptureMark;
                  }
                  var RelevanceScore = verse[v].getAttribute("score");
                  var ScriptureText = verse[v].childNodes[0].nodeValue;
                  if (SEARCHWORDS[0] !== "") {
                    ScriptureText = Highlight(ScriptureText,SEARCHWORDS);
                  }
                  sidebar = "";
                  var comment = verse[v].getElementsByTagName("comment");
                  for(var c=0; c < comment.length; c++) {
                    mytype = comment[c].getAttribute("type");
                    myname = comment[c].getAttribute("name");
                    if (mytype == null) mytype = "";
                    if (myname == null) myname = "";
                    sidebar += MakeLink(VerseId,chapter_key,v+1,mytype,myname);
                  }
                  if ((pswd === "jdm1234")) {
                    sidebar += MakeLink(VerseId,chapter_key,v+1,"type","name");
                  }
                  var compare_text = verse[v].getElementsByTagName("compare");
                  var CompareText = "";
                  var myref = "";
                  if (compare_text.length > 0) {
                    var lookahead;
                    for(var vc=0; vc < compare_text.length; vc++) {
                      myref = compare_text[vc].getAttribute("ref");
                      lookahead = compare_text[vc].getAttribute("lookahead");
                      if (lookahead == null || lookahead === "") {lookahead = 20;} else {lookahead = parseInt(lookahead,10);}
                      CompareText = compare_text[vc].childNodes[0].nodeValue;
                    }
                  }
                  if (CompareText === "") {
                    mytext[v+1]  = "<tr><td class='p_no'>"+ScriptureVerse+"</td><td class='script"+ScriptureMark+"'>";
                    mytext[v+1] += ScriptureText+"</td><td class='delta'></td>";
                    mytext[v+1] += "<td class='delta'></td>";
                    mytext[v+1] += "<td class='ref' title='"+VerseId+"' name='"+VerseId+"'>"+sidebar+"</td></tr>";
                  } else {
                    mytext[v+1]  = "<tr><td class='p_no'>"+ScriptureVerse+"</td><td class='script"+ScriptureMark+"'>";
                    mytext[v+1] += ScriptureText+"</td><td class='delta'><b><u>"+myref+"</u></b> "+CompareText+"</td>";
                    mytext[v+1] += "<td class='delta'> &Delta; <b><u>"+myref+"</u></b> "+CompareText.compare(ScriptureText)+"</td>";
                    mytext[v+1] += "<td class='ref' title='"+VerseId+"' name='"+VerseId+"'>"+sidebar+"</td></tr>";
                  }
                }
                mytext[v+1] = "</table>";
                document.getElementById("V" + drop_cnt).innerHTML = mytext.join(""); 
                document.getElementById("V" + drop_cnt).style.visibility = "visible";
                document.getElementById("C" + drop_cnt).style.visibility = "visible";
                document.getElementById("C" + drop_cnt).style.color = VolColor;
                document.getElementById("C" + drop_cnt).name = CHAPTER_KEY;
                if (scripture[scr].getAttribute("type") === "Search" || scripture[scr].getAttribute("type") === "Commentary Results") {
                  var RelevanceIndicator = "";
                  if (RelevanceScore !== "") {
                    RelevanceIndicator = "["+(parseFloat(RelevanceScore)).toFixed(1)+"] ";
                  }
                  document.getElementById("C" + drop_cnt).innerHTML = RelevanceIndicator+"<b>"+book_name+" </b>"+" (Verses="+verse.length+", "+num_chapter_comments+") - "+chapter_name;
                } else {
                  document.getElementById("C" + drop_cnt).innerHTML = volume_name+", "+book_name+":"+chapter_num+" &nbsp;&nbsp;&nbsp;&nbsp;("+verse.length+" Verses , "+num_chapter_comments+")";
                }
                mytext.length = 0;
              }
              if (scripture[scr].getAttribute("type") === "Search") {
                document.getElementById("volume_title").innerHTML = verse_cnt+" Verses found"; 
                document.getElementById("book_title").innerHTML = "in "+TOTAL_CHAPTERS+" Chapters";
              }
              for (var bc = drop_cnt+1; bc <= 150; bc++) {
                document.getElementById("C" + bc).style.visibility = "hidden";
              }
            }
          }
        }
      }
    } else {
      alert('Error: status code is ' + AJAX.status);
    }
  }
}

function setSearchBG(color) {
  document.getElementById("searchfor").style.background=color;
}

function Highlight(myText, myWords) {
  var max=myWords.length;
  var wordProper;
  for(var w = 0; w < max; w++) {
    if (myWords[w].toLowerCase() === myWords[w]) {
      wordProper = myWords[w].substr(0,1).toUpperCase()+myWords[w].substr(1);
    } else {
      wordProper = myWords[w];
    }
     if (myText.indexOf(wordProper) != -1 && myWords[w].length > 1) {
      myText = strReplace(myText,wordProper,"<span class='mark'>"+wordProper+"</span>");
    } else if (myText.indexOf(" "+myWords[w]+" ") != -1) {
      myText = strReplace(myText," "+myWords[w]+" "," <span class='mark'>"+myWords[w]+"</span> ");
    } else if (myText.indexOf(" "+myWords[w]+".") != -1) {
      myText = strReplace(myText," "+myWords[w]+"."," <span class='mark'>"+myWords[w]+"</span>.");
    } else if (myText.indexOf(" "+myWords[w]+",") != -1) {
      myText = strReplace(myText," "+myWords[w]+","," <span class='mark'>"+myWords[w]+"</span>,");
    } else if (myText.indexOf(" "+myWords[w]+":") != -1) {
      myText = strReplace(myText," "+myWords[w]+":"," <span class='mark'>"+myWords[w]+"</span>:");
    } else if (myText.indexOf(" "+myWords[w]+";") != -1) {
      myText = strReplace(myText," "+myWords[w]+";"," <span class='mark'>"+myWords[w]+"</span>;");
    } else if (myText.indexOf(" "+myWords[w]+"-") != -1) {
      myText = strReplace(myText," "+myWords[w]+"-"," <span class='mark'>"+myWords[w]+"</span>-");
    }
  }
  return myText;
}

function ClearChapter(volume_num, book_num, chapter_num, chapter_cnt) {
  document.getElementById("V" + chapter_cnt).innerHTML = CURRSCRIPTURE;
}

function FillChapter(volume_num, book_num, chapter_num, chapter_cnt) {
  //document.getElementById("volume_title").innerHTML = "<img src = 'js/images/search.gif'>";
  //document.getElementById("book_title").innerHTML = CNAME;
  AJAX = getNewXMLHttpRequest();
  if (!AJAX) alert('Error initializing XMLHttpRequest! The Browser is incompatible.');
  PARAMS = "volume="+volume_num+"&book="+book_num+"&chapter="+chapter_num;
  URL = "PHP/ZLookupChapter.php";
  AJAX.open('POST', URL, true);
  AJAX.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  AJAX.setRequestHeader("Content-length", PARAMS.length);
  // AJAX.setRequestHeader("Connection", "close");
  AJAX.onreadystatechange = function() { UpdateChapterDisplay(volume_num, book_num, chapter_num, chapter_cnt); }
  AJAX.send(PARAMS);
}

function UpdateChapterDisplay(volume_num, book_num, chapter_num, chapter_cnt) {
  if (AJAX.readyState == 4) {
    if (AJAX.status == 200) {
      var myverses = AJAX.responseText.split("^");
      var mytext = new Array();
      searchType = "DeSelect";
      CURRSCRIPTURE = document.getElementById("V" + chapter_cnt).innerHTML;
      CHAPTER_KEY = volume_num+"_"+book_num+"_"+chapter_num;
      compare_to = "";
      mytext[0] = ChapterControlPanel(volume_num,book_num,chapter_num,chapter_cnt,searchType,compare_to)+"<table style=\"font-size:"+VERSE_SIZE+";\" id=\"CTable"+CHAPTER_KEY+"\">";
      for (var i=1; i<myverses.length; i++) {
        var t=0;
        var sidebar="";
        var Scripture = myverses[i].split("|");
        var c= 3;
        while (Scripture[c] !== "") {
          var linkdata = Scripture[c].split("~");
          sidebar += MakeLink(Scripture[0],CHAPTER_KEY,Scripture[1],linkdata[1],linkdata[0]);
          c++;
        }
        if (CURRSCRIPTURE.indexOf(">"+Scripture[1]+"<") === -1) {
          mytext[i] = "<tr><td class='p_no dim'>"+Scripture[1]+"</td><td class='script dim' width='100%' valign='top'>"+Scripture[2]+"</td><td class='ref' name='"+Scripture[0]+"' title='"+Scripture[0]+"' valign='top'>"+sidebar+"</td></tr>";
        } else {
          mytext[i] = "<tr><td class='p_no'>"+Scripture[1]+"</td><td class='script' width='100%' valign='top'>"+Highlight(Scripture[2],SEARCHWORDS)+"</td><td class='ref' name='"+Scripture[0]+"' title='"+Scripture[0]+"' valign='top'>"+sidebar+"</td></tr>";
        }
      }
      mytext[i] = "</table>";
      document.getElementById("V" + chapter_cnt).innerHTML = mytext.join("");
    }
  }
}

function ShowComparisons(chapter_key) {
  var maxrows = document.getElementById(chapter_key).rows.length;
  for (var i = 0; i < maxrows; i++) {
    if (document.getElementById(chapter_key).rows[i].cells[1].className !== "scriptnarrow") {
      document.getElementById(chapter_key).rows[i].cells[1].className = "scriptnarrow";
      document.getElementById(chapter_key).rows[i].cells[2].className = "deltaShow";
      document.getElementById(chapter_key).rows[i].cells[3].className = "deltaShow";
    } else {
      document.getElementById(chapter_key).rows[i].cells[1].className = "script";
      document.getElementById(chapter_key).rows[i].cells[2].className = "delta";
      document.getElementById(chapter_key).rows[i].cells[3].className = "delta";
    }
  }
  return(false);
}
function ChapterControlPanel(volume_num,book_num,chapter_num,chapter_cnt,mode,compareto) {
  var chapter_key = volume_num+"_"+book_num+"_"+chapter_num;
  var panel = "<table cellspacing='0' cellpadding='0' border='0' style='width: 100%'>";
  panel += "<tr><td class='ChapterPanel'>";
  panel += "<a href=\"javascript:void(0);\" class=\"Adjust Small\" onclick=\"Adjust('id','CTable_"+chapter_key+"','em',-.1,.6);\">A</a>&nbsp;";
  panel += "<a href=\"javascript:void(0);\" class=\"Adjust Big\" onclick=\"Adjust('id','CTable_"+chapter_key+"','em',.1,1.6);\">A</a>";
  if (mode === "find") {
    panel += " &nbsp; <a href=\"javascript:void(0);\" class=\"Adjust Big\" onclick=\"FillChapter("+volume_num+","+book_num+","+chapter_num+","+chapter_cnt+");\">+</a>";
  } else if (mode === "DeSelect") {
    panel += " &nbsp; <a href=\"javascript:void(0);\" class=\"Adjust Big\" onclick=\"ClearChapter("+volume_num+","+book_num+","+chapter_num+","+chapter_cnt+");\">-</a>";
  }
  if (compareto !== "") {
    panel += " &nbsp; <a href=\"javascript:void(0);\" class=\"Adjust BigDelta\" onclick=\"ShowComparisons('CTable_"+chapter_key+"');\">";
    panel += "<span style='text-align: center'>"+compareto+"</span></a>";
  }
  panel += "</td></tr></table>";
  return panel;
}

function Adjust(elementType,element,unit,amt,limit) {
  var element_cnt=0;
  var s;
  var ds;
  var ele;
  var i;
  if (unit=="px") {
    ds=12;
  } else {
    ds=1;
  }
  ele = document.getElementById(element);
  if (elementType == "id") {
    element_cnt = 1;
  } else if (elementType == "tag") {
    element_cnt = ele.length;
  } else if (elementType == "name") {
    element_cnt = ele.length;
  }
  for (i=0;i<element_cnt;i++) {
    if (elementType == "id") {
      s = ele.style.fontSize;
      if (s==="") {
        s = ds;
      } else {
        s = ele.style.fontSize.replace(unit,"");
      }
    } else if (ele[i].style.fontSize) {
      s = ele[i].style.fontSize;
      if (s==="") {
        s = ds;
      } else {
        s = ele[i].style.fontSize.replace(unit,"");
      }
    } else {
      s = ds;
    }
    s = parseFloat(s);
    if ((amt<0 && s>=limit) || (amt>0 && s<=limit)) {
       s += amt;
    }
    if (elementType == "id") {
      ele.style.fontSize = s.toFixed(1)+unit;
      VERSE_SIZE = s.toFixed(1)+unit;
      for (i=1;i<=TOTAL_CHAPTERS;i++) {
        var chapterData = document.getElementByName("C" + i).name.split("_");
        var volume_num = chapterData[0];
        var book_num = chapterData[1];
        var chapter_num = chapterData[2];
        var chapter_key = volume_num+"_"+book_num+"_"+chapter_num;
        document.getElementById("CTable_"+chapter_key).style.fontSize = VERSE_SIZE;
        document.getElementById("CTable_"+chapter_key).style.display = "block";
        document.getElementById("CTable_"+chapter_key).style.width = "100%";
      }
    } else {
      ele[i].style.fontSize = s.toFixed(1)+unit;
    }
  }
  return(false);
}
// This compare routine takes two similar texts and returns
// the difference with <ins> and <del> markup.
String.prototype.compare = function(compareTo) {
  // Author: Jay Mackley - 2009, TheHolyScriptures.info. For public use with attribution.
  function Compare(mySource, myTarget, lookAhead) {
    // First clean up and normalize the text.
    //
    // Trim spaces front and back. Make sure it's all one line per verse.
    mySource = mySource.replace(/^\s*|\s*$|[\n\r]/g,"");
    myTarget = myTarget.replace(/^\s*|\s*$|[\n\r]/g,"");
    // Remove all markup tags
    mySource = mySource.replace(/<(.|\n)*?>/g,"");
    myTarget = myTarget.replace(/<(.|\n)*?>/g,"");
    // Remove extra spaces and treat long dashes as a word separator.
    // Include soft hyphen (00AD), figure dash (2012), em dash (2013), en dash (2014)
    mySource = mySource.replace(/\s+|(--)|[\u00AD\u2012\u2013\u2014]/g," ");
    myTarget = myTarget.replace(/\s+|(--)|[\u00AD\u2012\u2013\u2014]/g," ");
    // Move cleaned text into arrays that still contain word punctuation.
    // These arrays are used to build the final result but not for comparison.
    var cleanSourceArray = mySource.split(" ");
    var cleanTargetArray = myTarget.split(" ");
    //
    // Remove all other punctuation and caps so only plain words are left to compare.
    // Create these arrays for making the actual text comparisons word by word
    var sourceWords = mySource.replace(/[,:?!.;]/g,"").toLowerCase().split(" ");
    var targetWords = myTarget.replace(/[,:?!.;]/g,"").toLowerCase().split(" ");
    //
    var myDelta = "";   // Holds the comparison results text with markup
    var bDone;          // Set to true when all words have been examined
    var aMax;           // Maximum words in source array
    var bMax;           // Maximum words in target array
    var aLookAhead;     // How many source words to look ahead for comparison
    var bLookAhead;     // How many target words to look ahead for comparison
    var aFound;         // Indicates a word match in source
    var bFound;         // Indicates a word match in target
    var a = 0;          // Source array pointer
    var b = 0;          // Target array pointer
    var la;             // Source array pointer
    var lb;             // Target array pointer

    bDone = false;
    while (bDone === false) {
      if (sourceWords[b] === targetWords[a]) {
        myDelta = myDelta+cleanTargetArray[a]+" ";
        b++;
        a++;
      } else {
        if ((b + lookAhead) > cleanSourceArray.length-1) {
          bLookAhead = cleanSourceArray.length-1;
        } else {
          bLookAhead = b + lookAhead;
        }
        if ((a + lookAhead) > cleanTargetArray.length-1) {
          aLookAhead = cleanTargetArray.length-1;
        } else {
          aLookAhead = a + lookAhead;
        }
        bFound = false;
        aFound = false;
        for (lb = b; lb <= bLookAhead; lb++) {
          if (targetWords[a] === sourceWords[lb]) {
            bFound = true;
            break;
          }
        }
        for (la = a; la <= aLookAhead; la++) {
          if (sourceWords[b] === targetWords[la]) {
            aFound = true;
            break;
          }
        }
        if (bFound && aFound) {
          if ((lb - b) > (la - a)) {
            for (i = a; i < la; i++) {
              myDelta = myDelta+"<ins>"+cleanTargetArray[i]+"</ins> ";
            }
            a = la;
          } else {
            for (i = b; i < lb; i++) {
              myDelta = myDelta+"<del>"+cleanSourceArray[i]+"</del> ";
            }
            b = lb;
          }
        } else if (bFound === true) {
          for (i = b; i < lb; i++) {
            myDelta = myDelta+"<del>"+cleanSourceArray[i]+"</del> ";
          }
          b = lb;
        } else if (aFound === true) {
          for (i = a; i < la; i++) {
            myDelta = myDelta+"<ins>"+cleanTargetArray[i]+"</ins> ";
          }
          a = la;
        } else {
          if ((b >= cleanSourceArray.length-1) && (a < cleanTargetArray.length-1)) {
            myDelta = myDelta+"<ins>"+cleanTargetArray[a]+"</ins> ";
            b = cleanSourceArray.length-1;
            a++;
          } else {
            if ((a >= cleanTargetArray.length-1) && (b < cleanSourceArray.length-1)) {
              myDelta = myDelta+"<del>"+cleanSourceArray[b]+"</del> ";
              a = cleanTargetArray.length-1;
              b++;
            } else {
              myDelta = myDelta+"<ins>"+cleanTargetArray[a]+"</ins> ";
              myDelta = myDelta+"<del>"+cleanSourceArray[b]+"</del> ";
              a++;
              b++;
            }
          }
        }
      }
      if ((b > cleanSourceArray.length-1) || (a > cleanTargetArray.length-1)) bDone = true;
    }
    if ((cleanSourceArray.length < cleanTargetArray.length) && (cleanSourceArray[cleanSourceArray.length-1] !== cleanTargetArray[cleanTargetArray.length-1])) {
      // The target text has words remaining, so add them on the end as insertions
      for (i = a; i < cleanTargetArray.length; i++) {
        myDelta += "<ins>"+cleanTargetArray[i]+"</ins> ";
      }
    } else if ((cleanTargetArray.length < cleanSourceArray.length) && (cleanSourceArray[cleanSourceArray.length - 1] !== cleanTargetArray[cleanTargetArray.length - 1])) {
      // The source text has words remaining, so add them on the end as deletions.
      for (i = b; i < cleanSourceArray.length; i++) {
        myDelta += "<del>"+cleanSourceArray[i]+"</del> ";
      }
    }
    return myDelta;
  } // end of Compare function
  var sourceMax = this.count(" ");
  var targetMax = compareTo.count(" ");
  var max;
  if (targetMax > sourceMax) {
    max = targetMax;
  } else {
    max = sourceMax;
  }
  var bestCnt = max*2;
  var currCnt;
  var bestLookAhead = 1;
  // Examine all possibilities to determine the best lookahead value
  for (var testLookAhead = 1; testLookAhead <= max; testLookAhead++) {
    currCnt = Compare(this, compareTo, testLookAhead).count("</");
    if (currCnt < bestCnt) {
      bestCnt = currCnt;
      bestLookAhead = testLookAhead;
    }
  }
	// Put the final best result into the words array
	var words = Compare(this, compareTo, bestLookAhead).split(" ");
	// Finally, just for the sake of efficiency, remove redundant tags
	var state = "";
	var prevState = "";
	for (var p = 1; p < words.length; p++) {
	  prevState = state;
	  if (words[p].left(4) === "<ins") {
      state = "ins";
		} else if (words[p].left(4) === "<del") {
		  state = "del";
		} else {
		  state = ""
		}
		if ((state === "ins" && prevState === "ins") || (state === "del" && prevState === "del")) {
			words[p-1] = words[p-1].substr(0,words[p-1].length-6)
			words[p] = words[p].substr(5,words[p].length-5)
		}
	}
  return words.join(" ");
}
// Include the count function in this listing for completeness
String.prototype.count=function(myString) {
  var regexp = new RegExp(myString, "g");
  return this.replace(regexp, myString+"*").length - this.length;
}

function MakeLink(myVerseId,myChapterKey,myRow,myType,myName) {
  link = "<nobr><a name=\"\" class=\"commentlink\" onclick=\"ReadCommentary(event,'"+myVerseId+"','"+myChapterKey+"','"+myRow+"','"+myType+"','"+myName+"');return(false);\">"+myType+"="+myName+"</a></nobr> ";
  return link;
}

function ReadCommentary(myEVT,myverseid,mychapterkey,myrow,CTYPE_orig,CNAME_orig) {
  var chapterData = mychapterkey.split("_");
  var volume_num = chapterData[0];
  var book_num = chapterData[1];
  var chapter_num = chapterData[2];
  if (getURLparam("pswd") === "jdm1234" && myEVT.altKey === true) {
    var currChapterText = document.getElementById("CTable_"+mychapterkey).innerHTML;
    var currChapterName = currChapterText.substr(0,currChapterText.indexOf("&nbsp;"));
    var newChapterName = prompt ("Enter new chapter header",currChapterName);
    if (newChapterName !== "") {
      URL = "PHP/ZUpdateChapterName.php?name="+escape(newChapterName)+"&volume="+escape(volume_num)+"&book="+escape(book_num)+"&chapter="+escape(chapter_num);
      AJAX.open('GET', url, true);
      AJAX.onreadystatechange = function() { UpdateChapterName(currChapterText,currChapterName,newChapterName,mychapterkey); }
      AJAX.send(null);
    }
  } else {
    CTYPE = escape(CTYPE_orig);
    CNAME = escape(CNAME_orig);
    CURRROW = myrow;
    t = document.getElementById("CTable_"+mychapterkey).rows[CURRROW-1];
    CHAPTER_VERSE = t.cells[0].innerHTML;
    EVT = myEVT;
    URL = "PHP/ZLookupComment.php?type=" + CTYPE + "&name=" + CNAME;
    PARAMS = "";
    AJAX.open('GET', URL, true);
    AJAX.onreadystatechange = GetCommentary;
    AJAX.send(null);
  }
  CHAPTER_KEY = volume_num+"_"+book_num+"_"+chapter_num;
}
function UpdateChapterName(currChapterText,currChapterName,newChapterName,mychapterkey) {
  if (AJAX.readyState == 4) {
    if (AJAX.status == 200) {
      document.getElementById("CTable_"+mychapterkey).innerHTML = strReplace(currChapterText,currChapterName,newChapterName);
    }
  }
}

function GetCommentary() {
  if (AJAX.readyState == 4) {
    if (AJAX.status == 200) {
      var response = AJAX.responseText;
      var e = EVT || window.event;
      myTOP = MouseY(e); //-15;
      MoveVersesLeft();
      ShowComment();
      var o=document.getElementById("commenttext");
      if (myTOP == null) {
        // Because IE8 messes up here...
        myTOP = '550';
        o.style.width = '38%';
      }
      o.style.top = myTOP + 'px';
      o.innerHTML = CloseButtonStr(CHAPTER_VERSE)+response;
      o.style.borderWidth = '1px';
      o.style.display = 'none';
      o.style.visibility = 'visible';
      Effect.Combo('commenttext');
    }
  }
}
function MouseY(mouse_event) {
  if (typeof(mouse_event.pageY) != "undefined") {
    return mouse_event.pageY;
  } else if (mouse_event.clientY) {
    return mouse_event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
    //return mouse_event.clientY ? mouse_event.clientY + (document.documentElement.scrollTop || document.body.scrollTop) : mouse_event.pageY;
  } else {
    return null;
  }

}
function CloseButtonStr(verse_no) {
  if (verse_no === "") {
    return '<a href="javascript:void(0)" class="CloseButton" onclick="HideComment();"><b>CLOSE&nbsp; &nbsp;<big>X</big></b></a>';
  } else {
    return '<a href="javascript:void(0)" class="CloseButton" onclick="HideComment();"><b>'+verse_no+'&nbsp; &nbsp;CLOSE <big>X</big></b></a>';
  }
}

function HideVerses() {
  document.getElementById("vertical_container").style.visibility = "hidden";
  document.getElementById("bottom_container").style.display = "none";
  for(var i = 1; i <= 150; i++) {
    document.getElementById("C" + i).style.visibility = "hidden";
    document.getElementById("V" + i).style.visibility = "hidden";
  }
}

function MoveVersesCenter() {
  document.getElementById("bottom_container").style.marginLeft="40px";
  document.getElementById("bottom_container").style.width="95%";
}

function MoveVersesLeft() {
  document.getElementById("bottom_container").style.marginLeft="40px";
  document.getElementById("bottom_container").style.width="50%";
  if ( document.all ) {
    // Adjust for IE
    document.getElementById("commenttext").style.width="76%";
    document.getElementById("updatecomment").style.width="76%";
  }
}

function HideComment() {
  //document.body.style.overflow = "hidden";
  document.getElementById("commenttext").style.display = "none";
  document.getElementById("updatecomment").style.display = "none";
  //document.body.style.overflow = "visible";
  //document.getElementById("commenttext").style.visible = "hidden";
  //document.getElementById("updatecomment").style.visible = "hidden";
  MoveVersesCenter();
}

function ShowComment() {
  document.getElementById("commenttext").style.display = "block";
  document.getElementById("updatecomment").style.display = "none";
  //document.getElementById("commenttext").style.visible = "visible";
  //document.getElementById("updatecomment").style.visible = "hidden";
  //MoveVersesCenter();
}

function ShowCommentEdit() {
  document.getElementById("commenttext").style.display = "none";
  document.getElementById("updatecomment").style.display = "block";
  //document.getElementById("commenttext").style.visible = "hidden";
  //document.getElementById("updatecomment").style.visible = "visible";
  //MoveVersesLeft();
}
function ToggleTOC(cid){
  if (document.getElementById(cid).style.display != 'block') {
    document.getElementById("showindicator").innerHTML = "<nobr> - Hide TOC</nobr>";
    document.getElementById(cid).style.display = 'block';
  } else {
    document.getElementById("showindicator").innerHTML = "<nobr> + Show TOC</nobr>";
    document.getElementById(cid).style.display = 'none';
  }
  document.getElementById("commenttext").style.display = 'none';
}
function InitPage(Toc,Vol,Book,Chapter,Verse,Mark) {
  if (Vol == null) Vol = 0;
  if (Book == null) Book = 0;
  if (Chapter == null) Chapter = 0;
  VOL = Vol;
  BK = Book;
  if (Vol > 0 && Book > 0) {
    if (Verse == null) {loadAccordions();} else {loadAccordions(0);}
    ZDisplay(Vol,Book,Chapter,Verse,Mark);
    //Effect.OpenUp("C1");
    //bottomAccordion.activate($$('#bottom_container .accordion_toggle')[0]);
    //bottomAccordion.activate($$('#vertical_container .accordion_toggle')[0]);
    //document.getElementById("C1").click();
    //obj = document.getElementById("C1");
    //FireEvent(obj,"click");
  } else {
    loadAccordions();
	  //Event.observe(window, 'load', loadAccordions, false);
		// HideVerses();
  }
  if (Toc == null) Toc = "Y";
  if (Toc === "Y") {
    document.getElementById("container").style.display = "block";
    document.getElementById("container").style.visibility = "visible";
  } else {
    document.getElementById("container").style.display = "none";
    document.getElementById("container").style.visibility = "hidden";
	}
}

function ZDisplay(volume,book,chapter,verse,mark) {
  HideComment();
  if      (volume == 1) {CURRCOLOR = "#E6BE85";}
  else if (volume == 2) {CURRCOLOR = "#66B985";}
  else if (volume == 3) {CURRCOLOR = "#76A5F3";}
  else if (volume == 4) {CURRCOLOR = "#F098F9";}
  else                   {CURRCOLOR = "#F0F1F3";}
  VOL = volume;
  BK = book;
  HideVerses();
  document.getElementById("volume_title").innerHTML = "<img src = 'js/images/volume" + volume + ".gif'>";
  document.getElementById("book_title").innerHTML = "&nbsp;";
  AJAX = getNewXMLHttpRequest();
  if (!AJAX) alert('Error initializing XMLHttpRequest! The Browser you are using is not compatible with this page.');
  URL = 'PHP/ZLookup_XML.php?vol=' + escape(volume) + "&book=" + escape(book);
  if (chapter == null || chapter === "") chapter = 0;
  if (verse == null || chapter === "") verse = 0;
  if (chapter > 0) URL += "&chapter=" + escape(chapter);
  if (verse > 0) URL += "&verse=" + escape(verse);
  if (mark != null) URL += "&mark=" + escape(mark);
  PARAMS = '';
  AJAX.open('GET', URL, true);
  AJAX.onreadystatechange = populateDisplay;
  AJAX.send(null);
}
//
//  In case I want to load them onload, this is how.
// 
//Event.observe(window, 'load', loadAccordions, false);

//
//  Set up all accordions
//
function loadAccordions(OpenNo) {
  var topAccordion = new accordion('horizontal_container', {
    classNames : {
      toggle : 'horizontal_accordion_toggle',
      toggleActive : 'horizontal_accordion_toggle_active',
      content : 'horizontal_accordion_content'
    },
    defaultSize : {
      width : 725
    },
    direction : 'horizontal'
  });
  
  var bottomAccordion = new accordion('vertical_container');
  
//  var nestedVerticalAccordion = new accordion('vertical_nested_container', {
//    classNames : {
//      toggle : 'vertical_accordion_toggle',
//      toggleActive : 'vertical_accordion_toggle_active',
//      content : 'vertical_accordion_content'
//    }
//  });
  
  // Open first one
  if (OpenNo != null) {
    bottomAccordion.activate($$('#vertical_container .accordion_toggle')[OpenNo]);
  }
     // Open second one
     //topAccordion.activate($$('#horizontal_container .horizontal_accordion_toggle')[2]);
// topAccordion.activate($$('#horizontal_container .horizontal_accordion_toggle')[0]);
}
//function FireEvent(element,event){
//  if (document.createEventObject){
//    // For IE
//    document.getElementById(element).click();
//    //var evt = document.createEventObject();
//    //return element.fireEvent('on'+event,evt)
//  } else {
//    HTMLElement.prototype.click = function() {
//      var evt = this.ownerDocument.createEvent('MouseEvents');
//      evt.initMouseEvent('click', true, true, this.ownerDocument.defaultView, 1, 0, 0, 0, 0, false, false, false, false, 0, null);
//      this.dispatchEvent(evt);
//    }
//    document.getElementById(element).click();
//    // For firefox + others
//    //var evt = document.createEvent("HTMLEvents");
//    //evt.initEvent(event, true, true ); // event type,bubbling,cancellable
//    //return !element.dispatchEvent(evt);
//  }
//}

function strReplace(haystack, needle, replacement) {
  var regexp = new RegExp(needle, "g");
  return haystack.replace(regexp,replacement);
  //var temp = haystack.split(needle);
  //return temp.join(replacement);
}

Effect.OpenUp = function(element) {
   element = $(element);
   new Effect.BlindDown(element, arguments[1] || {});
}

Effect.CloseDown = function(element) {
   element = $(element);
   new Effect.BlindUp(element, arguments[1] || {});
}

Effect.Combo = function(element) {
   element = $(element);
   if(element.style.display == 'none') { 
     new Effect.OpenUp(element, arguments[1] || {}); 
   }else { 
     new Effect.CloseDown(element, arguments[1] || {}); 
   }
}

function TextReplace(argvalue, x, y) {

  if ((x == y) || (parseInt(y.indexOf(x),10) > -1)) {
    var errmessage = "replace function error: \n";
    errmessage += "Second argument and third argument could be the same ";
    errmessage += "or third argument contains second argument.\n";
    errmessage += "This will create an infinite loop as it's replaced globally.";
    alert(errmessage);
    return false;
  }
    
  while (argvalue.indexOf(x) != -1) {
    var leading = argvalue.substring(0, argvalue.indexOf(x));
    var trailing = argvalue.substring(argvalue.indexOf(x) + x.length, argvalue.length);
    argvalue = leading + y + trailing;
  }

  return argvalue;

}
function getURLparam( name ) {
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var tmpURL = window.location.href;
  var results = regex.exec(tmpURL);
  if (!results)
    return "";
  else
    return results[1];
}
function Extract(Original, Delimeter, FieldCnt) {
  //Extracts substrings by field. jdm
  //Example: If Text is "aaa,bbb,ccc" then Extract(Text, ",", 0) is ""
  //         If Text is "aaa,bbb,ccc" then Extract(Text, ",", 1) is "aaa"
  //         If Text is "aaa,bbb,ccc" then Extract(Text, ",", 2) is "bbb"
  //         If Text is "aaa,bbb,ccc" then Extract(Text, ",", 3) is "ccc"
  //         If Text is "aaa,bbb,ccc" then Extract(Text, ",", 4) is ""
  //         If Text is "aaa,bbb,ccc" then Extract(Text, ",", -1) is "ccc"
  var i = 0;
  var pos = 0;
  var p = 0;
  var Text = "";
  if (FieldCnt < 0)  {
    var cnt = countText(Original, Delimeter) + 1;
    FieldCnt = cnt - (FieldCnt * -1) + 1;
  }
  pos = 1;
  while (!(i === FieldCnt || pos === 0)) {
    i = i + 1;
    pos = Original.indexOf(Delimeter);
    if (pos < 0) {
      if (FieldCnt > i) {
       Text = "";
      } else {
       Text = Original;
      }
    } else {
      if (i == FieldCnt) {
        Text = Original.substring(0, pos); 
      } else {
        p = Original.indexOf(Delimeter);
        Original = Original.substring(p+1);
      }
    }
  }
  return Text;
}

function countText(source, search) {
  var regexp = new RegExp(search, "g");
  return source.replace(regexp, search+"*").length - source.length;
}

String.prototype.trim = function() {
  return this.replace(/^\s+|\s+$/g,"");
}

String.prototype.ltrim = function() {
  return this.replace(/^\s+/,"");
}

String.prototype.rtrim = function() {
  return this.replace(/\s+$/,"");
}

String.prototype.left = function(p) {
  if (this.length < p) {
    return this;
  } else {
    return this.substr(0,p);
  }
}

String.prototype.right = function(p) {
  if (this.length < p) {
    return this;
  } else {
    return this.substr(this.length-1-p,p);
  }
}

String.prototype.mid = function(s,p) {
  if (this.length < s + p) {
    return this;
  } else {
    return this.substr(s-1, p);
  }
}

String.prototype.extract=function(Original, Delimeter, FieldCnt) {
  //Extracts substrings by field. jdm
  //Example: If Text is "aaa,bbb,ccc" then Extract(Text, ",", 0) is ""
  //         If Text is "aaa,bbb,ccc" then Extract(Text, ",", 1) is "aaa"
  //         If Text is "aaa,bbb,ccc" then Extract(Text, ",", 2) is "bbb"
  //         If Text is "aaa,bbb,ccc" then Extract(Text, ",", 3) is "ccc"
  //         If Text is "aaa,bbb,ccc" then Extract(Text, ",", 4) is ""
  //         If Text is "aaa,bbb,ccc" then Extract(Text, ",", -1) is "ccc"
  var i = 0;
  var pos = 0;
  var p = 0;
  var Text = "";
  if (FieldCnt < 0)  {
    var cnt = countText(Original, Delimeter) + 1;
    FieldCnt = cnt - (FieldCnt * -1) + 1;
  }
  pos = 1;
  while (!(i === FieldCnt || pos === 0)) {
    i = i + 1;
    pos = Original.indexOf(Delimeter);
    if (pos < 0) {
      if (FieldCnt > i) {
       Text = "";
      } else {
       Text = Original;
      }
    } else {
      if (i == FieldCnt) {
        Text = Original.substring(0, pos); 
      } else {
        p = Original.indexOf(Delimeter);
        Original = Original.substring(p+1);
      }
    }
  }
  return Text;
}

