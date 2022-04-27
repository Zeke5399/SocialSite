<?php

class mailer {
    public static function sendMail($email, $vkey)
    {
        $to = $email;
        $subject = "";
        $message = "<a href='http://localhost/register/verify.php?vkey=$vkey'>"
                . "Register Account</a>";
        $headers = "From: email \r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
        mail($to, $subject, $message, $headers);
        
        header("./register.php");
    }
}
//Review this video
//https://www.youtube.com/watch?v=YtNraQxUTM0

//https://www.youtube.com/watch?v=LXQfEFEfFcM