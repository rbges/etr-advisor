<?php

    //Import PHPMailer classes into the global namespace
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require './vendor/autoload.php';
    
    //Check the submit action of contact from index.php
	if ($_SERVER["REQUEST_METHOD"] == "POST")  { 
        
        //Filds of the form
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
                
        //Using library PHPMailer
        $mail = new PHPMailer(true); 
        try {
            //Enable SMTP debugging 
            //$mail->SMTPDebug = 3;                               
            //Set PHPMailer to use SMTP
            $mail->isSMTP();            
            //Set SMTP host name                          
            $mail->Host = 'smtp.gmail.com';
            //Set this to true if SMTP host requires authentication to send email
            $mail->SMTPAuth = true;                          
            //Provide username and password     
            $mail->Username = 'easyread.advisor@gmail.com';                 
            $mail->Password = 'advisor.easyread';                           
            //If SMTP requires TLS encryption then set it
            $mail->SMTPSecure = 'tls';                           
            //Set TCP port to connect to 
            $mail->Port = 587;                                   
            
            $mail->From = $email;
            $mail->FromName = $name;
            
            $mail->addAddress('easyread.advisor@gmail.com');
            
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = "Mensaje nuevo de <b>$name</b>, con email <b>$email</b> en Easy-to-Read Advisor<br><br> -Mensaje:<br> $message";
            
            if(!$mail->send()){
                //echo "Mailer Error: " . $mail->ErrorInfo;
            } 
            else{
            //Reloading index and sending ok message
            $confirmacion = "** Mensaje enviado correctamente. Gracias por su interés **";
            echo "<script>"; 
                echo "if(alert('$confirmacion'));";  
                    echo "window.location = './index.php';"; 
            echo "</script>"; 
            }
        } 
        catch (phpmailerException $e) { //echo $e->errorMessage();
        } 
        catch (Exception $e) { //echo $e->getMessage();
        }
    }
    else{
        echo 'Input fail';
    }
?>