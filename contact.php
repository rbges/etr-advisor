<?php
    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    //Fields of the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                         // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'easyread.advisor@gmail.com';     // SMTP username          
        $mail->Password = 'advisor.easyread';                 // SMTP password
        $mail->SMTPSecure = 'tls';                       // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('easyread.advisor@gmail.com', 'Easy to Read');
        $mail->addAddress('easyread.advisor@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "Mensaje nuevo de <b>$name</b>, con email <b>$email</b> en Easy-to-Read Advisor<br><br> -Mensaje:<br> $message";

        $mail->send();
        if(!$mail->send()){
            //Reloading index and sending not ok message
        $errorSending = "** El mensaje no ha sido enviado **";
        echo "<script>"; 
            echo "if(alert('$errorSending'));";  
                echo "window.location = './index.php';"; 
        echo "</script>";
        } 
        else{
        //Reloading index and sending ok message
        $confirmacion = "** Mensaje enviado correctamente **";
        echo "<script>"; 
            echo "if(alert('$confirmacion'));";  
                echo "window.location = './index.php';"; 
        echo "</script>";
        }
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
?>
