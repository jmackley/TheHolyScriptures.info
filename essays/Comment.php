<?php
$subject = str_replace("'","",stripslashes(strip_tags($_POST['subject'])));
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
<head>
  <!-- <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'> -->
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <meta http-equiv='Pragma' content='no-cache' />
  <meta http-equiv='expires' content='0' />
  <title>Comment</title>
  <style type='text/css'>
    body {
      margin: 5px 5px 5px 5px;
      font: 12px Verdana;
      background: url(images/bg_gradient.png);
      font-size:90%;
    }
    input, textarea {
      border: 1px solid #999999;
      padding: 1px 1px 1px 1px;
      font: 12px Verdana;
      margin: 2px 0 0 2px;
      color: #555555;
    }
    .submit {
      background-color: #eeeeee;
      font: 1.1em Verdana;
      font-weight: bold;
      border: 3px solid #5F89D8;
      color: #000000;
    }
    .red {
      color: red; font-weight: bold;
    }
    .light {
      color: #EBFFB4; font-weight: bold;
    }
    .gold {
      color: #EBFFB4;
      padding: 0px 60px 5px 60px;
      font: 1.3em Arial;
      font-weight: bold;
    }
  </style>
  
  <script type='text/javascript' language='javascript'>
    function validateFields(frm) {
      var bSubmit = true;
      var reEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;  // regular expression for a valid email address
      
      if (frm.email.value == '' || !reEmail.test(frm.email.value)) {
        alert('Please enter a valid e-mail address.');
        frm.email.focus();
        bSubmit = false;
      } else if (frm.name.value == '' || frm.name.value.indexOf(' ') > 0) {
        alert('Please enter your full real name.');
        frm.subject.focus();
        bSubmit = false;
      } else if (frm.subject.value == '') {
        alert('Please enter a subject.');
        frm.subject.focus();
        bSubmit = false;
      } else if (frm.comments.value == '') {
        alert('Please enter comments, information, or scripture commentary.');
        frm.comments.focus();
        bSubmit = false;
      }
      return bSubmit;
    }
  </script>
</head>
<body style='background-color: #2D2D30;'>
  <form action='Contact.php?'" + $subject + " method='post' onsubmit='return validateFields(this);'>
    <input type='hidden' name='process' value='true' />
    <br />
    <table border='0'>
      <tr>
        <td align='left' colspan='2' class='gold'>
         If you have questions about TheHolyScriptures.info or 
         would like to comment on the site please fill out the following form.<br />
        </td>
      </tr>
      <tr>
        <td align='right' class='light'> Full Name:</td>
        <td><input type='text' name='name' size='50' /></td>
      </tr>
      <tr>
        <td align='right' class='light'>E-mail:</td>
        <td><input type='text' name='email' size='50' /></td>
      </tr>
      <tr>
        <td align='right' class='light'> Subject:</td>
        <td><input type='text' name='subject' size='50' /></td>
      </tr>
      <tr>
        <td align='right' valign='top' class='light'> Comments:</td>
        <td><textarea name='comments' cols='80' rows='20'></textarea></td>
      </tr>
      <tr>
        <td align='right' valign='top'>&nbsp;</td>
        <td><input align='center' class='submit' type='submit' value='Submit' /></td>
      </tr>
    </table>
  </form>
</body>
</html>";
?>