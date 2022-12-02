<?php

$name   = $_POST['name'];
$email   = $_POST['email'];
$phone   = $_POST['phone'];
$sub   = $_POST['subject'];
$comment  = $_POST['msg'];
  
$to ='example@example.com';
$subject = "Query from Codezion";

 
$message = "
<html>
<head>
<title>Query from Codezion</title>
</head>
<body>
<p>Query from Codezion</p>
<table style='width:100%;text-align:center' border='1' cellspacing='0' cellpadding='10'>
<tr>
<th>Fullname</th>
<th>Email</th>
<th>Phone</th>
<th>Subject</th>
<th>Message</th>
</tr>
<tr>
<td>".$name ."</td>
<td>".$email ."</td>
<td>".$phone ."</td>
<td>".$sub ."</td>
<td>".$comment ."</td>
</tr>
</table>
</body>
</html>
";

 
 
 // Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <no-reply@example.com>' . "\r\n";
$headers .= 'Cc: ' . "\r\n";

$res=mail($to,$subject,$message,$headers);
if($res)
{
?>
<script language="javascript">
alert("Thank you for submitting your query. Our team will get back you soon");
window.location.href="index.html";
</script>
<?php } else { ?>
<script language="javascript">
alert("Sorry! Form Not Submited.");
window.location.href="index.html";
</script>
<?php } 
 ?>