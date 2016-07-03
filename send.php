 
<?php


require 'PHPMailer/PHPMailerAutoload.php';

$name="";
$email="";
$phone="";
$comments="";
$location="";
$nameErr="";
$mailErr="";
$phoneErr="";
$locErr="";


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) 
    {
        $nameErr = "Only letters and white space allowed in the name field!";
    }
    
    $location = test_input($_POST["location"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$location)) 
    {
      $locErr = "Only letters and white space allowed in the location field!";
    }

  

    
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
      $mailErr = "Invalid email format!";
    }

    $phone = test_input($_POST["phone"]);
    // check if name only contains letters and whitespace
     if (!preg_match("/^\+?[0-9]*[ \-]?\d{5} ?\d{5}/",$phone)) 
     {
      $phoneErr = "Enter a valid Contact Number along with country code in the format!";
     }


if (empty($_POST["comments"])) 
{
    $comments = "No comments!";
}
else 
{
    $comments = test_input($_POST["comments"]);
}

//Create a new PHPMailer instance
$content= "Name: $name\n\n$comments\n\nContact Number: $phone\nLocation: $location\n$email ";

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Debugoutput = 'html';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tsl';
$mail->SMTPAuth = true;
$mail->Username = "";
$mail->Password = "";
$mail->setFrom($email, $name." (DSNL Query)");
$mail->addReplyTo($email, $name);
$mail->addAddress('youremail@gmail.com', 'XYZ');
$mail->Subject = 'DSNL Query Forum';
$mail->Body = $content;


if(empty($nameErr) && empty($mailErr) && empty($phoneErr) && empty($locErr) && $mail->send() )
{
	$res= "Thank you for contacting us. We will get back to you as soon as possible.";
	header('Location: thanks.php');

}
 else if(!empty($nameErr) || !empty($mailErr) || !empty($phoneErr) && empty($locErr))
{
//do nothing 
}
 
else
{
    header('Location: error.php');
     
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    
    <title>Status</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="images/icon.png"> 
    <link rel="stylesheet" href="css/animate.css" type="text/css">

    <link href="css/style.css" rel="stylesheet">
</head>

<body id="status">
<i class="fa fa-times logo"  style="color:red;margin-left:35%;" aria-hidden="true"></i>
 
<h4  style="color:#ffffff;"><?php echo nl2br("$nameErr \n $locErr \n $mailErr \n $phoneErr");?></h4>
</body>
</html>
