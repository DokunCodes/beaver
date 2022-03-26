<?php

require_once "Mail.php"; // PEAR Mail package
require_once ('Mail/mime.php'); // PEAR Mail_Mime packge

session_start();
if(!isset($_SESSION['user_id']))
{
    header('location: ./');
}

if(isset($_POST['submit']))
{
    $t_phone = $_POST['c_phone'];
    $t_email = $_POST['c_email'];
    $cc_email = $_POST['cc_email'];
    $msg = $_POST['msg'];

    if(!empty($t_email))
    {
        $status_sms= sendsms($t_phone,$msg);
        $status_mail = sendmail($msg,$t_email,$cc_email);

    }

}

function sendsms($to,$message){
	$url="https://jusibe.com/smsapi/send_sms";
	$username="112901b775aa635fea50541a7f49d186";
	$password="9a150104388954a424de9e4326158b7a";

	$data = array(
			"to" => $to,
			"from" => "Beaver Home",
			"message" => $message,
	);



	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);



	$response = curl_exec($ch);

	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$header = substr($response, 0, $header_size);
	$body = substr($response, $header_size);

	curl_close($ch);

    $resp = json_decode($response,true);
    
    return $resp['status'];


}


function sendmail($html, $rec, $cc)
{

    $from = "app@beaver.ng"; //enter your email address
    $to = $rec; //enter the email address of the contact your sending to

    $headers = array ('From' => $from,'To' => $to, 'Subject' => "Beaver Homes", 'Cc'=> $cc);


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
     
        return "success";

    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Beaver | Manager </title>
   
        <link rel="shortcut icon" href="../images/icons/favicon.png">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>

        <!-- Begin page -->
        <div id="wrapper">
        <div class="row">
        <div class="col-lg-3">

</div>
                            <div class="col-lg-6">
                                <div class="card m-t-20 m-b-20">
                                    <?php if(isset($status_sms)){ ?>
                                        <div class="alert alert-success bg-success text-white" role="alert">
                                                <strong>Sent!</strong> Message successfully sent.
                                            </div>
                                    <?php } ?>
                                    <div class="card-body">
        
                                        <h4 class="mt-0 header-title text-center">Send SMS/Email To Technician/Client</h4>
                                        <p class="text-muted m-b-30 text-center">Fill in the form appropriately. All fields marked (*) are compulsory. <br>Click the generate button to generate access code</p>
        
                                        <form class="" method="post" action="">
                                            <div class="form-group">
                                                <label>Phone *</label>
                                                <input type="number" name="c_phone" class="form-control" required placeholder=""/>
                                            </div>

                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" name="c_email" class="form-control" parsley-type="email" placeholder="Enter a valid e-mail"/>
                                            </div>

                                            <div class="form-group">
                                                <label>CC: Email </label>
                                                <input type="email" name="cc_email" class="form-control" parsley-type="email" value="info@beaver.ng" placeholder="Enter a valid e-mail"/>
                                            </div>

                                             <div class="form-group">
                                             <div class="col-6" style="display:inline-block">
                                             <label>Access Code</label>
                                                <input type="number" name="access_code" id="accessCode" disabled class="form-control" />
                                             </div>
                                             <div class="col-6" style="display:inline">
                                             <button type="button" id="genBtn" class="btn btn-primary waves-effect waves-light" >
                                                        Generate
                                                    </button>
                                             </div>
                                
                                                
                                               
                                            </div>
        
    
                                            <div class="form-group">
                                                <label>Message (Max: 160 Chars)</label>
                                                <div>
                                                    <textarea required maxlength="160" class="form-control" rows="5" name="msg"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <center>                      
                                                <div>
                                                    <button type="submit" name="sendsms" class="btn btn-primary waves-effect waves-light">
                                                        Submit
                                                    </button>
                                                    <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                        Cancel
                                                    </button>
                                                </div>
                                                </center>
                                            </div>
                                        </form>
        
                                    </div>
                                </div>
                            </div> <!-- end col -->
        
                                    <div class="col-lg-3">
            
</div>
                        </div> <!-- end row -->        

        </div>
        <!-- END wrapper -->
            
        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/metisMenu.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/waves.min.js"></script>

        <script src="assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

        <!-- Parsley js -->
        <script src="assets/plugins/parsleyjs/parsley.min.js"></script>
        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <script>
            $(document).ready(function() {
                    $('form').parsley();

                $('#genBtn').click(function(){
                    var val = Math.floor(1000 + Math.random() * 9000);

                    $('#accessCode').val(val);
                        
                    });
            });
        </script>

    </body>

</html>