<!--

var httpReq;
var httpReq2;
var jobtypes = '~';
var jobtypecnt = 42;
var ResultMsg = 'Request Recorded';
var undefined;

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
          httpReq = window.createRequest();
        } catch (e) {
          Obj = false;
        }           
      }
    }
  }
  return Obj;
}

function ClickCheckBox(MyBox) {
  if (jobtypes == '') {
    jobtypes = '~';
  }
  if (MyBox.checked == true) {
    if (jobtypes.indexOf('~' + MyBox.value + '~') == -1) {
      jobtypes = jobtypes + MyBox.value + '~';
    }
  } else {
    if (jobtypes.indexOf('~' + MyBox.value + '~') != -1) {
      jobtypes = jobtypes.replace('~' + MyBox.value + '~','~');
    }
  }
}

function generatePassword(length) {
  var password = '';
  var possible = '0123456789bcdfghjkmnpqrstvwxyz';
  var i = 0;
  var mychar; 
  var random_num
  // add random characters to $password until $length is reached
  while (i < 6) { 
    random_num = (Math.round((Math.random()*30)+1));
    //alert(random_num);
    mychar = possible.substr(random_num, 1); // pick a random character from the possible ones
    // We don't want this character if it's already in the password
    if (password.indexOf(mychar) == -1) {
      password = password + mychar;
      i++;
    }
  }
  return password;
}
function NowTime() {
  var mydate=new Date();
  var year=mydate.getYear();
  if (year < 1000)  year+=1900;
  var month=mydate.getMonth()+1;
  if (month<10) month="0"+month;
  //var days=mydate.getDay();
  //if (days<10) days="0"+days;
  var daym=mydate.getDate();
  if (daym<10) daym="0"+daym;
  var hours=mydate.getHours();
  if (hours<10) hours="0"+hours;
  var minutes=mydate.getMinutes();
  if (minutes<10) minutes="0"+minutes;
  var seconds=mydate.getSeconds();
  if (seconds<10) seconds="0"+daym;
  return year+"-"+month+"-"+daym+" "+hours+":"+minutes+":"+seconds;
}
-->