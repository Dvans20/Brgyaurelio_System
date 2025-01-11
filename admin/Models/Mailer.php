<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../../vendor/autoload.php';

// email
// brgyaurelio@gmail.com

// password
// brgyAurelio12_2

// pin 
// 1202


// xiad ahpf xnms tpbr


// sms recovery code code
// KVBB9KU9GRUZAZL8CWDFMRFB

class Mailer {

    public $isHTML = false;

    public $recipientAddress;

    public $subject;
    public $body;

    private $appEMail = "support@brgyaurelio.online"; // Hostinger email

    public function send()
    {
        $mail = new PHPMailer(true); // Create a new PHPMailer instance

        try {
            // Server settings
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = 'smtp.hostinger.com'; // Hostinger SMTP server
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = $this->appEMail; // Hostinger email address
            $mail->Password = '3veneZ3r@'; // Hostinger email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $mail->Port = 587; // Port for TLS (use 465 if SSL is preferred)

            // Recipients
            $mail->setFrom($this->appEMail, 'Support Team'); // Sender email and name
            $mail->addAddress($this->recipientAddress); // Add a recipient

            // Content
            $mail->isHTML($this->isHTML); // Set email format to HTML
            $mail->Subject = $this->subject;
            $mail->Body    = $this->body;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            // Uncomment for debugging or success message
            // echo 'Email has been sent';
        } catch (Exception $e) {
            // Log or echo the error for debugging
            error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
