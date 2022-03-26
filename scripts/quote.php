<?php

require_once "Mail.php"; // PEAR Mail package
require_once ('Mail/mime.php'); // PEAR Mail_Mime packge


if ($_POST['propertyType']){

    @$prop = $_POST['propertyType']; // form field
    @$propsize = $_POST['propertySize']; // form field
    @$floors = $_POST['floors']; // form field
    @$name = $_POST['name']; // form field
    @$phone = $_POST['phone']; // form field
    @$email = $_POST['email']; // form field
    @$location = $_POST['location']; // form field
    @$coverage = $_POST['coverage']; // form field
    @$note = $_POST['note']; // form field
    @$cover = '';

    if(isset($coverage))
    {
        foreach ($coverage as $cov)
        {
            $cover .= $cov . '<br>';
        }
    }


    $subject = "New Custom Plan Subscription"; // subject of your email


    $html = "<html><body style='font-size: 14px'>
                <h3>You have received new Custom Plan Subscription request. Find details below:  </h3>
                <p><strong>Source: </strong> Web</p>
                <p><strong>Name: </strong> $name</p>
                <p><strong>Phone: </strong> $phone</p>
                <p><strong>Email: </strong> $email</p>
                <p><strong>Location: </strong> $location</p>
                <p><strong>Property Type: </strong> $prop</p>
                <p><strong>Property Size: </strong> $propsize</p>
                <p><strong>Floors: </strong> $floors</p>
                <p><strong>Coverage: </strong> $cover</p>
                <p><strong>Details of selected coverage: </strong> $note</p>
             </body></html>"; // html versions of email.


    sendmail($html,$subject);


}



if ($_POST['title']){

    @$title = $_POST['title']; // form field
    @$fname = $_POST['fname']; // form field
    @$surname = $_POST['surname']; // form field
    @$phone = $_POST['phone']; // form field
    @$email = $_POST['email']; // form field
    @$shelter = $_POST['shelter']; // form field
    @$plan = $_POST['plan']; // form field
    @$location = $_POST['location']; // form field

    $subject = "New ".$plan." Plan Subscription"; // subject of your email


    $html = "<html><body style='font-size: 14px'>
                <h3>You have received a new Plan Subscription request. Find details below:  </h3>
                <p><strong>Source: </strong> Web</p>
                <p><strong>Title: </strong> $title</p>
                <p><strong>Surname: </strong> $surname</p>
                <p><strong>Firstname: </strong> $fname</p>
                <p><strong>Phone: </strong> $phone</p>
                <p><strong>Email: </strong> $email</p>
                <p><strong>Shelter Size: </strong> $shelter</p>
                <p><strong>Plan: </strong> $plan</p>
                <p><strong>Location: </strong> $location</p>
    
             </body></html>"; // html versions of email.


    sendmail($html,$subject);


}


if ($_POST['news_email']){

    @$email = $_POST['news_email']; // form field


    $subject = "Newsletter Subscription"; // subject of your email


    $html = "<html><body style='font-size: 14px'>
                <h3>You have received a new Newsletter Subscription. Find details below:  </h3>
                <p><strong>Source: </strong> Web</p>
                <p><strong>Email: </strong> $email</p>
             
             </body></html>"; // html versions of email.


    sendmail($html,$subject);


}



function sendmail($html, $subject)
{

    $from = "app@beaver.ng"; //enter your email address
    $to = "info@beaver.ng"; //enter the email address of the contact your sending to

    $headers = array ('From' => $from,'To' => $to, 'Subject' => $subject);


    $text = ''; // text versions of email.
    $crlf = "\n";

    $mime = new Mail_mime($crlf);
    $mime->setTXTBody($text);
    $mime->setHTMLBody($html);

//do not ever try to call these lines in reverse order
    $body = $mime->get();
    $headers = $mime->headers($headers);

    $host = "localhost"; // all scripts must use localhost
    $username = "app@beaver.ng"; //  your email address (same as webmail username)
    $password = "fgV8KtW9ObVH"; // your password (same as webmail password)

    $smtp = Mail::factory('smtp', array ('host' => $host, 'auth' => true,
        'username' => $username,'password' => $password));

    $mail = $smtp->send($to, $headers, $body);

    if (PEAR::isError($mail)) {
        echo $mail->getMessage();
    }
    else {
        echo "success";

    }
}

