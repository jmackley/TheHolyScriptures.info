<?php
$name	= str_replace("'","",stripslashes(strip_tags($_POST['name'])));
$email = str_replace("'","",stripslashes(strip_tags($_POST['email'])));
$subject = str_replace("'","",stripslashes(strip_tags($_POST['subject'])));
$comments = str_replace("'","",stripslashes(strip_tags($_POST['comments'])));
if (mail("Jay Mackley <info@theholyscriptures.info>", $subject, $comments, "From: $name <$email>")) {
  echo "<br /><br /><br /><center style='font:white'>Email Successfully Sent!!<br /><a href='Contact.html'>Go back</center>";
} else {
  echo "<br /><br /><br /><center style='font:white'>Email Failed!<br /><a href='Contact.html'>Try Again</a></center>";
}
?>