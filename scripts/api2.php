<?php

require_once "Mail.php"; // PEAR Mail package
require_once ('Mail/mime.php'); // PEAR Mail_Mime packge


    //http://stackoverflow.com/questions/18382740/cors-not-working-php
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }


    //http://stackoverflow.com/questions/15485354/angular-http-post-to-php-and-undefined
    $postdata = file_get_contents("php://input");
    if (isset($postdata)) {
        $request = json_decode($postdata);

        $propType = $request->propertyType;
         $propsize = $request->size;
        $fullname = $request->fullname;
        $phone = $request->phone;
        $email = $request->email;
        $floors = $request->floors;
        $location = $request->location;
        $choices = $request->choice;
         $details = $request->details;

        if ($propType != "" && $fullname !="" && $phone !="" && $email !="" && $location !="" ) {

          $subject = "New Quote Request"; // subject of your email


          $html = "<html><body style='font-size: 14px'>
                      <h3>You have received a new quote request. Find details below:  </h3>
                      <p><strong>Source: </strong> Mobile App</p>
                      <p><strong>Property Type: </strong> $propType</p>
                       <p><strong>Property Size: </strong> $propsize</p>
                         <p><strong>Floors: </strong> $floors</p>
                      <p><strong>Fullname: </strong> $fullname</p>
                      <p><strong>Phone: </strong> $phone</p>
                      <p><strong>Email: </strong> $email</p>
                      <p><strong>Selected Choice: </strong> $choices</p>
                      <p><strong>Choice Details: </strong> $details</p>
                      <p><strong>Location: </strong> $location</p>
          
                   </body></html>"; // html versions of email.
      
      
          sendmail($html,$subject);
        }
        else {
            echo "Supply value to all required fields";
        }
    }
    else {
        echo "Supply value to all required fields";
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
?>