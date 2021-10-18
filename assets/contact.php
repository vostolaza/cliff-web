<?php

 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\SMTP;
 use PHPMailer\PHPMailer\Exception;
 
 require  __DIR__ .'/../vendor/autoload.php';

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $phone =  trim($_POST["phone"]);
        $message = trim($_POST["massage"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR empty($phone)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "jorge.vasquez@utec.edu.pe";

        // Set the email subject.
        $subject = "New contact from $name";

        // Build the email content.
        $email_content = "First Name: $name\n";
        $email_content .= "Phone: $phone\n\n";
        $email_content .= "Message:\n$message\n";

        // Build the email headers.
        $email_headers = "From: $name <$phone>";

        // Send the email.
        // if (mail($recipient, $subject, $email_content, $email_headers)) {
        //     // Set a 200 (okay) response code.
        //     http_response_code(200);
        //     echo "Thank You! Your message has been sent.";
        // } else {
        //     // Set a 500 (internal server error) response code.
        //     http_response_code(500);
        //     echo "Oops! Something went wrong and we couldn't send your message.";
        // }

        $mail = new PHPMailer(true);
        try{
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
        
            $mail->Username = 'cliff.dev.2021@gmail.com'; // YOUR gmail email
            $mail->Password = 'bikaclif'; // YOUR gmail password
            $mail->setFrom('cliffdev@gmail.com', 'Cliff dev');
            $mail->addAddress('cliff.dev.2021@gmail.com', 'Cliff');
            $mail->IsHTML(true);
            $mail->Subject = $subject;
            $mail->Body =  $email_content;
            $mail->send();
            echo "Thank You! Your message has been sent.";
        }catch( Exception $e){
            echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>

