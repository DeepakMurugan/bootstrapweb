<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//get data from form

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$company = $_POST['company'];
$phone = $_POST['phone'];

// preparing mail content

$messagecontent ="Name = ". $name . "<br>Email = " . $email . "<br>Phone = " . $phone . "<br>Company =" . $company . "<br>Message =" . $message ;

// $messagecontent ="Name = ". $name . "<br>Email = " . $email . "<br>Message =" . $message;


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'neeraj.moorjani@petromin.in';                     //SMTP username
    $mail->Password   = 'mgxptbqwviyppksx';   
    $mail->SMTPSecure = 'ssl';
    //SMTP password
   // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('neeraj.moorjani@petromin.in', 'Monarch ');
    $mail->addAddress('deepak@bleap.in', 'Monarch'); // Add the original recipient
    $mail->addAddress('deepak@bleap.in'); // Name is optional
    $mail->addAddress('deepakm1600@gmail.com'); // Add an extra recipient
    $mail->addAddress('deepak@dtechgrow.com'); // Add another extra recipient
    $mail->addReplyTo('deepak@bleap.in', 'Information');
    $mail->addCC('deepak@bleap.in');
    $mail->addBCC('deepak@bleap.in');




    // $mail->setFrom('neeraj.moorjani@petromin.in', 'Mailer');
    // $mail->addAddress('deepak@bleap.in', 'Dee User');     //Add a recipient
    // $mail->addAddress('deepak@bleap.in');               //Name is optional
    // $mail->addReplyTo('deepak@bleap.in', 'Information');
    // $mail->addCC('deepak@bleap.in');
    // $mail->addBCC('deepak@bleap.in');

    //Attachments

    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
   // $mail->addAttachment('photo.jpeg', 'photo.jpeg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Monarch New Form Submission ';
    $mail->Body    = $messagecontent;
    

    $mail->send();
    echo 'Message has been sent we will Contact You Soon ......';

     // Add a JavaScript script for redirection
     echo '<script>';
     echo 'setTimeout(function() {';
     echo '   window.location = "index.html";'; // Redirect to index.html
     echo '}, 8000);'; // 5000 milliseconds (5 seconds)
     echo '</script>';




} catch (Exception $e) {
   echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}