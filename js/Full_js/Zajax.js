var CurrColor;
var vol;
var bk;
var evt;
//var evt2;
var myTop;
var ctype;
var cname;
var cverseId;
var currRow;
var currChapter;

function MakeVisible() {
  document.getElementById("container").style.visibility = "visible";
  return true;
}
function EditMyComment(myevt2,pswd) {
  if (pswd === "jdm1234" && myevt2.ctrlKey === true) {
    document.getElementById("commenttext").style.display = "none";
    var target = "|"+ctype+"|"+cname+"|"+currRow+"|";
    document.getElementById("updatecomment").value = target+document.getElementById("commenttext").innerHTML;
    document.getElementById("updatecomment").style.top = myTop+'px';
    document.getElementById("updatecomment").style.display = "block";
  }
  return true;
}

function SaveMyComment() {
  var ctext = document.getElementById("updatecomment").value;
  if (document.getElementById("commenttext").innerHTML != ctext) {
    var commentaryText;
    var myCommands;
    var t;
    var rowPtr;
    var url;
    if (ctext.substr(0,1) == "+" || ctext.substr(0,1) == "-" || ctext.substr(0,1) == ":") {
      myInput = ctext.split("|");
      myCommands = myInput[0];
      if (myInput[1] !== "") ctype = myInput[1];
      if (myInput[2] !== "") cname = myInput[2];
      if (myInput[3] !== "") currRow = myInput[3];
      commentaryText = myInput[4];
    } else if (ctext.substr(0,1) == "|") {
      myInput = ctext.split("|");
      commentaryText = myInput[4];
    } else {
      commentaryText = ctext;
    }
    document.getElementById("updatecomment").value = commentaryText;
    var Links = new Array();
    rowPtr = parseInt(currRow,10)-1;
    t = document.getElementById("Chapter"+currChapter).rows[rowPtr].cells[2];
    cverseId = t.title;
    if (myCommands === "-") {
      var CellText = t.innerHTML;
      var NewLinks = "";
      CellText = CellText.slice(1,-1);
      Links = CellText.split("> <");
      for(i = 0; i < Links.length; i++) {
        if (Links[i].indexOf(cname,0) == -1) {
          NewLinks = NewLinks+"<"+Links[i]+"> ";
        }
      }
      commentaryText = "";
      t.innerHTML = NewLinks;
      myCommands = "remove";
    } else if (myCommands === "+") {
      t.innerHTML = t.innerHTML+MakeLink(currChapter,rowPtr,ctype,cname);
      myCommands = "insert";
    } else if (myCommands === ":") {
      myCommands = "append";
    } else {
      myCommands = "replace";
    }
    url = "ZSaveComment.php";
    //params = "id=" + escape(cverseId) + "&type=" + escape(ctype) + "&name=" + escape(cname) + "&cmd=" + escape(myCommands) + "&comment=" + encodeURIComponent(commentaryText);
    params = "id=" + cverseId + "&type=" + ctype + "&name=" + cname + "&cmd=" + myCommands + "&comment=" + commentaryText;
    //params = encodeURIComponent(params);
    httpReq.open('POST', url, true);
    httpReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    httpReq.setRequestHeader("Content-length", params.length);
    httpReq.setRequestHeader("Connection", "close");
    httpReq.onreadystatechange = ReShowCommentary;
    httpReq.send(params);
  }
  document.getElementById("updatecomment").style.display = "none";
  document.getElementById("commenttext").style.display = "block";
  return true;
}
function Search() {
  alert("Search called");
}
function ReShowCommentary() {
  if (httpReq.readyState == 4) {
    /* Server is done with the task */
    if (httpReq.status == 200) {
      //var response = httpReq.responseText;
      document.getElementById("commenttext").innerHTML = document.getElementById("updatecomment").value;
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

function ZDisplay(volume,book) {
  //var email = document.getElementById('email').value.toLowerCase();
  //for(i = 1; i <= 67; i++) {
  //  document.getElementById("C" + i).style.visibility = "hidden";
  //  //alert(i);
  //}
  if (volume == 1) {
    CurrColor = "#E6BE85";
  } else if (volume == 2) {
    CurrColor = "#66B985";
  } else if (volume == 3) {
    CurrColor = "#76A5F3";
  } else if (volume == 4) {
    CurrColor = "#F098F9";
  } else {
    CurrColor = "#F0F1F3";
  }
  vol = volume;
  bk = book;
  for(i = 1; i <= 150; i++) {
    document.getElementById("C" + i).style.visibility = "hidden";
  }
  //document.getElementById("volume_title").backgroundImage = "url(images/volume" + volume + ".gif)";
  document.getElementById("vertical_container").style.visibility = "hidden";
  document.getElementById("volume_title").innerHTML = "<img src = 'js/images/volume" + volume + ".gif'>";
  document.getElementById("book_title").innerHTML = "&nbsp;";
  var url = 'ZLookup.php?vol=' + escape(volume) + "&book=" + escape(book);
  httpReq = getNewXMLHttpRequest();
  if (!httpReq) alert('Error initializing XMLHttpRequest! The Browser you are using is not compatible with this page.');
  httpReq.open('GET', url, true);
  httpReq.onreadystatechange = UpdateBookDisplay;
  httpReq.send(null);
}

function UpdateBookDisplay() {
  if (httpReq.readyState == 4) {
    /* Server is done with the task */
    if (httpReq.status == 200) {
      var sidebar;
      var response = httpReq.responseText.split("^");
      document.getElementById("volume_title").style.color = CurrColor;
      document.getElementById("commenttext").style.display = "none";
      if (response[0].length < 3) {
        document.getElementById("vertical_container").style.visibility = "hidden";
        document.getElementById("volume_title").innerHTML = "Missing Books "+vol+", "+bk;
      } else if (response[1].length < 3) {
        document.getElementById("vertical_container").style.visibility = "hidden";
        document.getElementById("volume_title").innerHTML = "Missing Verses "+vol+", "+bk;
      } else {
        document.getElementById("vertical_container").style.visibility = "visible";
        var header = response[0].split("|");
        var num_chapters = header[0];
        var num_book_comments = header[3];
        document.getElementById("volume_title").innerHTML = "The " + header[1].toUpperCase();
        //document.getElementById("volume_title").style.backgroundImage = "url(none)";
        document.getElementById("book_title").innerHTML = header[2] + "&nbsp;&nbsp;&nbsp;&nbsp;("+num_chapters+" Chapters, "+num_book_comments+" Commentaries)";
        document.getElementById("book_title").style.color = CurrColor;
        var mytext = new Array();
        for(i = 1; i <= num_chapters; i++) {
          mytext[0] = "<table id=\"Chapter"+i+"\">";
          var verses = response[i].split("|");
          var num_verses = verses.length;
          var verses_next = response[i+1].split("|");
          var chapter_info = verses[0].split("~");
          var chapter_info_next = verses_next[0].split("~");
          var chapter_name = chapter_info[0];
          var volume_num = chapter_info[2];
          var book_num = chapter_info[3];
          var chapter_num = chapter_info[4];
          var num_chapter_comments = chapter_info_next[1];
          for(v = 1; v < num_verses; v++) {
            num_verse_sections = verses[v].length;
            verses[v] = verses[v]+"~~~~~~~~~~~~~~~~~";
            var commentary = verses[v].split("~");
            var VerseId = commentary[0];
            var ScriptureText = commentary[1];
            //CText = commentary[4];
            sidebar = "";
            for(var c=3; c < 84; c=c+4) {
              if (commentary[c] === "" && getURLparam('pswd') === "jdm1234") {
                mytype = "type";
                mycomments = " ";
                sidebar += MakeLink(i,v,mytype,mycomments)+"<br>";
                c=85;
              } else if (commentary[c] === "") {
                c=85;
              } else {
                mytype = commentary[c+1];
                mycomments = commentary[c];
                sidebar += MakeLink(i,v,mytype,mycomments)+"<br>";
              }
            }
            mytext[v] = "<tr><td class='p_no'>"+v+"</td><td class='script' valign='top'>"+ScriptureText+"</td><td class='ref' title='"+VerseId+"' valign='top'>"+sidebar+"</td></tr>";
          }
          mytext[v] = "</table>";
          document.getElementById("V" + i).innerHTML = mytext.join(""); 
          document.getElementById("C" + i).style.visibility = "visible";
          document.getElementById("C" + i).style.color = CurrColor;
          document.getElementById("C" + i).name = volume_num+"~"+book_num+"~"+chapter_num;
          num_verses--;
          document.getElementById("C" + i).innerHTML = chapter_name+" -&nbsp;&nbsp;&nbsp;&nbsp;("+num_verses+" Verses , "+num_chapter_comments+" Commentaries)";
          verses.length = 0;
          mytext.length = 0;
        }
        num_chapters++;
        for(i = num_chapters; i <= 150; i++) {
          document.getElementById("C" + i).style.visibility = "hidden";
        }
      }
    } else {
      alert('Error: status code is ' + httpReq.status);
    }
  }
}

function MakeLink(myChapter,MyRow,MyType,MyName) {
  link = "<a name=\"\" class=\"commentlink\" onclick=\"ReadCommentary(event,'"+myChapter+"','"+MyRow+"','"+MyType+"','"+MyName+"');return(false);\">"+MyType+"="+MyName.replace(" ","&nbsp;")+"</a> ";
  return link;
}
function UpdateChapterName(currChapterText,currChapterName,newChapterName) {
  if (httpReq.readyState == 4) {
    if (httpReq.status == 200) {
      document.getElementById("C" + currChapter).innerHTML = currChapterText.replace(currChapterName,newChapterName);
    }
  }
}

function ReadCommentary(myevt,mychapter,myrow,ctype_orig,cname_orig) {
  if (getURLparam("pswd") === "jdm1234" && myevt.altKey === true) {
    currChapterText = document.getElementById("C" + currChapter).innerHTML;
    currChapterName = currChapterText.substr(0,currChapterText.indexOf("&nbsp;"));
    chapterData = document.getElementById("C" + currChapter).name.split("~");
    volume_num = chapterData[0];
    book_num = chapterData[1];
    chapter_num = chapterData[2];
    newChapterName = prompt ("Enter new chapter header",currChapterName);
    if (newChapterName !== "") {
      url = "ZUpdateChapterName.php?name="+escape(newChapterName)+"&volume="+escape(volume_num)+"&book="+escape(book_num)+"&chapter="+escape(chapter_num);
      httpReq.open('GET', url, true);
      httpReq.onreadystatechange = function() { UpdateChapterName(currChapterText,currChapterName,newChapterName); };
      httpReq.send(null);
    }
  } else {
    ctype = ctype_orig;
    cname = cname_orig;
    currRow = myrow;
    currChapter = mychapter;
    evt = myevt;
    url = "ZLookupComment.php?type=" + escape(ctype) + "&name=" + escape(cname);
    httpReq.open('GET', url, true);
    httpReq.onreadystatechange = GetCommentary;
    httpReq.send(null);
  }
}

//function ShowLightBox() {
  //alert("Here am I");
  //document.getElementById("updatecomment").style.display = "none";
  //document.getElementById("commenttext").style.display = "block";
  //myLytebox.start(myElement, false, false);
  //alert("Here am I again");
  //return false;
//}

function GetCommentary() {
  if (httpReq.readyState == 4) {
    /* Server is done with the task */
    if (httpReq.status == 200) {
      var response = httpReq.responseText;
      var e = evt || window.event;
      myTop = mouseY(e);
      var o=document.getElementById("commenttext");
      if (Math.abs(parseInt(o.style.top,10) - myTop) > 15) {
        o.style.display = "none";
      }
      o.style.top = myTop+'px';
      o.innerHTML = response;
      o.style.borderWidth = '1px';
      o.style.display = 'none';
      o.style.visibility = 'visible';
      Effect.Combo('commenttext');
    }
  }
}

Effect.OpenUp = function(element) {
   element = $(element);
   new Effect.BlindDown(element, arguments[1] || {});
};

Effect.CloseDown = function(element) {
   element = $(element);
   new Effect.BlindUp(element, arguments[1] || {});
};

Effect.Combo = function(element) {
   element = $(element);
   if(element.style.display == 'none') { 
     new Effect.OpenUp(element, arguments[1] || {}); 
   }else { 
     new Effect.CloseDown(element, arguments[1] || {}); 
   }
};

function mouseY(evt) {
  if (evt.pageY) {
    return evt.pageY;
  } else if (evt.clientY) {
    return evt.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
  } else {
    return null;
  }
}
function TextReplace(argvalue, x, y) {

  if ((x == y) || (parseInt(y.indexOf(x),10) > -1)) {
    errmessage = "replace function error: \n";
    errmessage += "Second argument and third argument could be the same ";
    errmessage += "or third argument contains second argument.\n";
    errmessage += "This will create an infinite loop as it's replaced globally.";
    alert(errmessage);
    return false;
  }
    
  while (argvalue.indexOf(x) != -1) {
    var leading = argvalue.substring(0, argvalue.indexOf(x));
    var trailing = argvalue.substring(argvalue.indexOf(x) + x.length, 
	argvalue.length);
    argvalue = leading + y + trailing;
  }

  return argvalue;

}
function getURLparam( name ) {
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var tmpURL = window.location.href;
  var results = regex.exec( tmpURL );
  if ( results === null )
    return "";
  else
    return results[1];
}
