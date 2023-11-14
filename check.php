<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Get reCAPTCHA secret key (replace with your actual secret key)
$recaptchaSecret = '6LcQKwIpAAAAAMOzv8tR_9ApmbWQ1Dc5VZ5pZgnT';

// Function to verify the reCAPTCHA response
function verifyRecaptcha($secret, $response) {
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secret,
        'response' => $response
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return json_decode($result, true);
}

// Get data from the form
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['description'];
$company = $_POST['company'];
$phone = $_POST['phone'];
$recaptchaResponse = $_POST['g-recaptcha-response'];

// Verify the reCAPTCHA response
$recaptchaResult = verifyRecaptcha($recaptchaSecret, $recaptchaResponse);

if ($recaptchaResult['success']) {
    // reCAPTCHA validation passed

    // Prepare mail content
    $messagecontent = "Name = " . $name . "<br>Email = " . $email . "<br>Phone = " . $phone . "<br>Company =" . $company . "<br>Message =" . $message;

    // Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                          
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'neeraj.moorjani@petromin.in';                     
        $mail->Password   = 'mgxptbqwviyppksx';   
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;                                    

        // Recipients
        $mail->setFrom('neeraj.moorjani@petromin.in', 'Monarch');
        $mail->addAddress('deepak@bleap.in', 'Monarch');
        $mail->addAddress('deepak@bleap.in');
        $mail->addAddress('sales@monarchsizing.com');
        $mail->addAddress('abishai@bleap.in');
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Monarch New Form Submission';
        $mail->Body    = $messagecontent;

        // Send the email
        $mail->send();
        echo 'Message has been sent. We will contact you soon...';

        // Add a JavaScript script for redirection
        echo '<script>';
        echo 'setTimeout(function() {';
        echo '   window.location = "index.html";'; // Redirect to index.html
        echo '}, 3000);'; // 3000 milliseconds (3 seconds)
        echo '</script>';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    // reCAPTCHA validation failed
    echo 'reCAPTCHA verification failed. Please try again.';
}
?>
