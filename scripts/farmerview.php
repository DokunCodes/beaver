<?php

@session_start();

error_reporting(0);

//$_SESSION['hdgdd']='kayode.shobalaje@aledingroup.com';



//adedokun.oluwaseyi@aledingroup.com



require "../api/backbone.php";


$con=Agromall::conn();

if(!isset($_SESSION['agro_userid']) AND !isset($_SESSION['state_userid']))
{
    header('location: ./');
}

if (!isset($_GET['id'])){

    header('Location: farmer');

}
?>

<link href="assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css" />

<style>

    .records_title{

        font-weight: bold;

        font-size: 15px;

    }

    .check-with-label:checked + .label-for-check {
        font-weight: bold;
    }
    textarea {max-width:95%;}


    .contentbox{

        border-top-left-radius: 10px;

        border-bottom-right-radius: 10px;

        margin-bottom: 20px

        box-shadow: 0 2px 5px rgba(0, 0, 0, .1);

        -webkit-box-shadow: 0 2px 5px rgba(0, 0, 0, .1);

        padding: 5px;

        padding-left: 16px;

    }
    .small{

        display: block;
        max-width:75%;
        width: auto;
        height: auto;

    }

    .passport{

        display: block;
        max-width:75%;
        width: auto;
        height: auto;

    }
    .finger{

        display: inline;
        width:  50px;
        height: auto;

    }

    .sign{

        display: inline;
        max-width:75%;
        width:  auto;
        height: auto;

    }

    .magnify {width: auto; margin: 0 auto; position: relative; cursor: none}

    /*Lets create the magnifying glass*/
    .large {
        width: 300px; height: 300px;
        position: absolute;
        border-radius: 100%;

        /*Multiple box shadows to achieve the glass effect*/
        box-shadow: 0 0 0 7px rgba(255, 255, 255, 0.85),
        0 0 7px 7px rgba(0, 0, 0, 0.25),
        inset 0 0 40px 2px rgba(0, 0, 0, 0.25);

        /*hide the glass by default*/
        display: none;
    }

    [type=checkbox]:checked+label:before {
        top: -4px;
        left: -5px;
        width: 12px;
        height: 22px;
        border-top: 2px solid transparent;
        border-left: 2px solid transparent;
        border-right: 2px solid #3ba403;
        border-bottom: 2px solid #3ba403;
        -webkit-transform: rotate(40deg);
        -ms-transform: rotate(40deg);
        transform: rotate(40deg);
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-transform-origin: 100% 100%;
        -ms-transform-origin: 100% 100%;
        transform-origin: 100% 100%}


</style>

<?php


$id=$_GET['id'];

@$mobile = $_GET['phone'];


$nokstate='';
$noklga='';

$data=Agromall::fetch_farmer_new($id);


$agentnumber=Agromall::get_agent_number($data[0]['created_by']);


//$data[0]['date_of_birth']

$dob=$data[0]['dob'];
$nokdob = $data[0]['nok_dob'];

$farmerid=$data[0]['reg_no'];

$fulcrumid=$data[0]['farmer_id'];
$state=$data[0]['state'];

$phonenumber = $data[0]['mobile_no'];

$farmdata=Agromall::fetch_farm_new($fulcrumid);


$reviewdata=Agromall::get_reviewed_comments($fulcrumid);

$reviewer = str_replace("."," ",substr($reviewdata[0]['reviewer'], 0, strpos($reviewdata[0]['reviewer'], '@')));

$rid=$data[0]['fulcrum_id'];
$project_id=$data[0]['project_id'];

$famersfname = $data[0]['surname'].' '.$data[0]['first_name'];


$nokstate = Agromall::get_state_name($data[0]['nok_state'],$con);
$noklga = Agromall::get_local_gov_name($data[0]['nok_lga']);

if(isset($_SESSION['agro_userid'])) {
    echo '<br> <a class="nav-link btn-success" role="tab" target="_blank" style="color: #ffffff; float: right;" href="editfarmer?famerid=' . $fulcrumid . '" > Edit</a>';

}
echo '<br><center><h3>'.$data[0]['surname'].'  '.$data[0]['middle_name'].' '.$data[0]['first_name'].'</h3></center><br>';



echo '<div class="row" id="exportto">';//start of row


//col8

echo '<div class="col-md-8">';//start col8

echo '<div style="color: white; background-color: #6E716C"> <h4 style="padding-left:10px;padding-top:5px ;padding-bottom:5px ;">Bio Data</h4></div>';
echo '<div class="row">';//start of row

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">REG NO: </h4><span>'.strtoupper($data[0]['reg_no']).'</span></div>';
echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">BVN: </h4><span>'.$data[0]['bvn'].'</span></div>';


echo '</div><br/>';//close of row


echo '<div class="row">';//start of row

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">Full Name:  </h4> <span id="fname">'.$data[0]['surname'].'  '.$data[0]['middle_name'].' '.$data[0]['first_name'].'</span></div>';

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">Date of Birth: </h4><span>'.date("F j, Y",strtotime($data[0]['dob'])).'</span></div>';

echo '</div>';//close of row



echo '<br><div class="row">';//start of row

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">Gender: </h4><span>'.(($data[0]['gender']=='')?'&nbsp;':$data[0]['gender']).'</span></div>';

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">Nationality: </h4><span>'.(($data[0]['nationality']=='')?'&nbsp;':$data[0]['nationality']).'</span></div>';

echo '</div>';//close of row



echo '<br><div class="row">';//start of row

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">Occupation: </h4><span>'.(($data[0]['occupation']=='')?'&nbsp;':$data[0]['occupation']).'</span></div>';

echo '</div>';//close of row



echo '<br><div class="row">';//start of row

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">Marital Status: </h4><span>'.(($data[0]['marital_status']=='')?'&nbsp;':$data[0]['marital_status']).'</span></div>';

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">Spouse Name: </h4><span>'.(($data[0]['spouse_name']=='')?'&nbsp;':$data[0]['spouse_name']).'</span></div>';

echo '</div>';//close of row



echo '<br><div class="row">';//start of row

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">Email Address: </h4><span>'.$data[0]['email_address'].'</span></div>';

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">Phone Number: </h4><span>'.(($data[0]['mobile_no']=='')?'&nbsp;':$data[0]['mobile_no']).'</span></div>';

echo '</div>';//close of row



echo '<br><div class="row">';//start of row

echo '<div class="col-md-12"><h4 class="records_title" style="display: inline">House Address: </h4><span>'.$data[0]['city'].', '.$data[0]['address'].'</span></div>';

echo '</div>';//close of row



echo '<br><div class="row">';//start of row

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">ID Type: </h4><span>'.(($data[0]['id_type']=='')?'&nbsp;':$data[0]['id_type']).'</span></div>';

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">ID Number: </h4><span>'.$data[0]['id_no'].'</span></div>';

echo '</div>';//close of row

//$time = strtotime($data[0]['issue_date']);
//$newformat = date('d-m-Y',$time);

echo '<br><div class="row">';//start of row

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">ID Issue Date: </h4><span>'.(($data[0]['issue_date']=='')?'&nbsp;':date('d-m-Y',strtotime($data[0]['issue_date']))).'</span></div>';

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">ID Expiry Date: </h4><span>'.(($data[0]['expiry_date']=='')?'&nbsp;':date('d-m-Y',strtotime($data[0]['expiry_date']))).'</span></div>';

echo '</div>';//close of row



echo '<br><div style="color: white; background-color: #6E716C"> <h4 style="padding-left:10px;padding-top:5px ;padding-bottom:5px ;">Next of Kin Details</h4></div>';



echo '<br><div class="row">';//start of row

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">Full Name: </h4><span>'.$data[0]['nok_surname'].' '.$data[0]['nok_first_name'].'</span></div>';

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">Relationship: </h4><span>'.$data[0]['nok_relationship'].'</span></div>';

echo '</div>';//close of row



echo '<br><div class="row">';//start of row

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">Date of Birth: </h4><span>'.date("F j, Y",strtotime($data[0]['nok_dob'])).'</span></div>';

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">Address: </h4><span>'.$data[0]['nok_city'].', '.$data[0]['nok_address'].'</span></div>';

echo '</div>';//close of row


echo '<br><div class="row">';//start of row

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">L.G.A & State: </h4><span>'.$noklga.', '.$nokstate.'</span></div>';

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">Phone Number: </h4><span>'.$data[0]['nok_mobile_no'].'</span></div>';

echo '</div>';//close of row





echo '<br><div style="color: white; background-color: #6E716C"> <h4 style="padding-left:10px;padding-top:5px ;padding-bottom:5px ;">Other Account Information</h4></div>';


echo '<div class="row">';//start of row

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">Bank Name: </h4><span>'.$data[0]['bank_name'].'</span></div>';

echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">Account Type: </h4><span>'.$data[0]['account_type'].'</span></div>';


echo '</div>';//close of row



echo '<br><div class="row">';//start of row


echo '<div class="col-md-6"><h4 class="records_title" style="display: inline">Account Number: </h4><span>'.$data[0]['account_no'].'</span></div>';

echo '</div>';//close of row



echo '</div>';//close of col8









//col4

echo '<div class="col-md-4">';//start col4

//passport

echo '<h5 style="font-weight:bold">Passport Photo</h5>';

$passport_photo=$data[0]['passport_photo'];



    echo '<img src="'.$passport_photo.'" class="passport" alt="Image not available">';



//passport

echo '<h5 style="font-weight:bold">ID Image</h5>';

$id_photo=$data[0]['id_image'];



    //read to file

    echo '
       <div class="magnify">
    <div class="large"></div>
    <img src="'.$id_photo.'" class="small" alt="Image not available">
    </div>
    ';



//fingerprint

echo '<h5 style="font-weight:bold">Fingerprints</h5>';

$fingerp=$data[0]['fingerprint'];



    //read to file
    $fimage = explode(';',$fingerp);


    $j=0;

    while ($j<count($fimage))
    {
        if(!empty($fimage[$j])){
            echo '<img src="'.$fimage[$j].'" class="finger" alt="Image not available">';
        }
        $j++;
    }







//signature

echo '<br><br><h5 style="font-weight:bold;display: inline">Signature</h5>';

$signature=$data[0]['signature'];


    //read to file

    echo '
  
   <br><img src="'.$signature.'" class="sign" alt="Image not available">

  ';






echo '</div>';//close of col4







echo '</div>
<div id="editor"></div>

';//close of row



echo '<br><div style="color: white; background-color: #6E716C"> <h4 style="padding-left:10px;padding-top:5px ;padding-bottom:5px ;">Farm Map</h4></div>';


if(empty($farmdata))
{
    echo '<br><div class="row">';//start of row

    echo '<div class="col-md-12">No farm records yet</div>';

    echo '</div>';//close of row

}
else {


    ?>
    <ul class="nav nav-tabs" role="tablist">
        <?php
        for($j=0;$j<count($farmdata);$j++){?>
            <li class="nav-item">
                <a class="nav-link btn-success" role="tab" style="color: #ffffff;"  href="api/farmview.php?id=<?php echo $farmdata[$j]['farm_id']?>" target="_blank"><?php echo $farmdata[$j]['farm_name']. " Farm"?></a>
            </li>
        <?php }?>

    </ul>



    <?php

}
if(isset($_SESSION['agro_userid'])) {
    echo '<br><div style="color: white; background-color: #6E716C"> <h4 style="padding-left:10px;padding-top:5px ;padding-bottom:5px ;">Review Info</h4></div>';
    if (empty($reviewdata)) {
        if (empty($reviewdata)) {
            echo '<div class="row">';//start of row

            echo '<div class="col-md-12"><center id="rv">No review yet</center></div>';

            echo '</div>';//close of row
            if ($_SESSION['role'] != 2 && $_SESSION['role'] != 4 && $_SESSION['role'] != 5 && $_SESSION['role'] != 6 && $_SESSION['role'] != 7 && $_SESSION['role'] != 8) {
                echo
                    '
        <form id="reviewcomments" role="form">
        <div class="row">
        <div class="col-md-6">
          <h5>Category</h5>
          <input type="checkbox" id="test_data" name="test_data" value="true" class="check-with-label cat" />
         <label for="test_data" class="label-for-check">Test Data</label><br>
        <input type="checkbox" id="bio" name="cat[]" value="Bio Data" class="check-with-label cat" />
         <label for="bio" class="label-for-check">Bio Data</label><br>
          <input type="checkbox" id="passport" name="cat[]" value="Passport Photo" class="check-with-label cat" />
         <label for="passport" class="label-for-check">Passport Photo</label><br>
          <input type="checkbox" id="idcard" name="cat[]" value="ID Image" class="check-with-label cat"  />
         <label for="idcard" class="label-for-check">ID Image</label><br>
          <input type="checkbox" id="finger" name="cat[]" value="Fingerprints Image" class="check-with-label cat" />
         <label for="finger" class="label-for-check">Fingerprints Image</label><br>
            
           <input type="checkbox" id="farminfo" name="cat[]" value="Farm Details" class="check-with-label cat" />
         <label for="farminfo" class="label-for-check">Farm Details</label><br>
           <input type="checkbox" id="gps" name="cat[]" value="GPS Coordinates" class="check-with-label cat" />
         <label for="gps" class="label-for-check">GPS Coordinates</label><br>
         <input type="checkbox" id="noissues" name="no_issues" value="true" class="check-with-label cat" />
         <label for="noissues" class="label-for-check">No Issues</label><br>
         <input type="hidden" name="project" value="'.$project_id.'">
         </div>
        <div class="col-md-6">
        <h5>Comment </h5>
        <div style="color: red; font-size: 12px">(120 Character Max - <span style="color: red;" id="charNum"></span>)</div>
        
       <input type="hidden" name="fulcrumid" value="' . $fulcrumid . '"/>
       <input type="hidden" name="farmername" value="' . $famersfname . '"/>
       <input type="hidden" name="regno" value="' . $farmerid . '"/>
       <input type="hidden" name="agentinvolved" value="' . $agentnumber . '"/>
       <input type="hidden" name="state" value="' . $state . '"/>
        <textarea cols="40" rows="5" id="comment" name="comments" placeholder="Type in the agent action here" required></textarea>
       
        <br>
        
        <div id="loader" style="display: none;">Processing, Please Wait...</div>
        <input type="submit" id="sbmbtn" class="btn btn-success" name="reviewc">
        </div>
        
        </div>
        </form>
        
        ';
            }

        }

    } else {

        echo '<br><div class="row">';//start of row

        echo '<div class="col-md-3">
            
         <h4 class="records_title">Issues Group: </h4><span>' . $reviewdata[0]['category'] . '</span>
            
            </div>
            
            <div class="col-md-3">
            
         <h4 class="records_title">Comments: </h4><span>' . $reviewdata[0]['comment'] . '</span>
         
             <h4 class="records_title">Reviewer: </h4><span>' . ucwords($reviewer) . '</span>
            </div>
            <div class="col-md-3">
            
          <h4 class="records_title">Date Reviewed: </h4><span>' . $reviewdata[0]['date_created'] . '</span>
            
            </div>';
        if (($reviewdata[0]['reviewer'] == $_SESSION['agro_userid']) || $_SESSION['role'] == 2) {
            echo '
               <div class="col-md-3">
               <form id="deletereview" role="form">
               
               <input type="hidden" name="fid" value="' . $fulcrumid . '"/>
               <div id="loader2" style="display: none;">Processing, Please Wait...</div>
               <input type="submit" name="deleterbtn"  id="deleterbtn"  class="btn btn-danger"  value="Delete Review" />
                   </form>      
            </div>
            
            
            ';
        }

        echo '</div>';//close of row


    }


    echo '<br><br>
';
}
?>

<script src="assets/plugins/bootstrap-sweetalert/sweet-alert.min.js" type="text/javascript"></script>

<script>
    function countChar(val) {
        var len = val.value.length;
        if (len > 120) {
            val.value = val.value.substring(0, 120);
        } else {
            $('#charNum').text(120 - len);
            $('#rv').html('');
        }
    };


</script>

<script type="text/javascript">
    $(document).ready(function(){

        function checkreview()
        {
            var status=false;
            if ($("#reviewcomments input:checkbox:checked").length <= 0)
            {
                status=true;
            }

            return status;
        }


        var native_width = 0;
        var native_height = 0;
        $(".large").css("background","url('" + $(".small").attr("src") + "') no-repeat");

        //Now the mousemove function
        $(".magnify").mousemove(function(e){
            //When the user hovers on the image, the script will first calculate
            //the native dimensions if they don't exist. Only after the native dimensions
            //are available, the script will show the zoomed version.
            if(!native_width && !native_height)
            {
                //This will create a new image object with the same image as that in .small
                //We cannot directly get the dimensions from .small because of the
                //width specified to 200px in the html. To get the actual dimensions we have
                //created this image object.
                var image_object = new Image();
                image_object.src = $(".small").attr("src");

                //This code is wrapped in the .load function which is important.
                //width and height of the object would return 0 if accessed before
                //the image gets loaded.
                native_width = image_object.width;
                native_height = image_object.height;
            }
            else
            {
                //x/y coordinates of the mouse
                //This is the position of .magnify with respect to the document.
                var magnify_offset = $(this).offset();
                //We will deduct the positions of .magnify from the mouse positions with
                //respect to the document to get the mouse positions with respect to the
                //container(.magnify)
                var mx = e.pageX - magnify_offset.left;
                var my = e.pageY - magnify_offset.top;

                //Finally the code to fade out the glass if the mouse is outside the container
                if(mx < $(this).width() && my < $(this).height() && mx > 0 && my > 0)
                {
                    $(".large").fadeIn(100);
                }
                else
                {
                    $(".large").fadeOut(100);
                }
                if($(".large").is(":visible"))
                {
                    //The background position of .large will be changed according to the position
                    //of the mouse over the .small image. So we will get the ratio of the pixel
                    //under the mouse pointer with respect to the image and use that to position the
                    //large image inside the magnifying glass
                    var rx = Math.round(mx/$(".small").width()*native_width - $(".large").width()/2)*-1;
                    var ry = Math.round(my/$(".small").height()*native_height - $(".large").height()/2)*-1;
                    var bgp = rx + "px " + ry + "px";

                    //Time to move the magnifying glass with the mouse
                    var px = mx - $(".large").width()/2;
                    var py = my - $(".large").height()/2;
                    //Now the glass moves with the mouse
                    //The logic is to deduct half of the glass's width and height from the
                    //mouse coordinates to place it with its center at the mouse coordinates

                    //If you hover on the image now, you should see the magnifying glass in action
                    $(".large").css({left: px, top: py, backgroundPosition: bgp});
                }
            }
        });


        var bio = $('#bio');
        var passport = $('#passport');
        var gps = $('#gps');
        var idcard = $('#idcard');
        var finger = $('#finger');
        var farm = $('#farminfo');


        $('#bio').on('click',function () {
            if (bio.is(':checked')) {
                $( "#comment" ).prop( "disabled", false  );
            }
            else if (checkreview()===true){$( "#comment" ).prop( "disabled", true  );}
        });
        $('#passport').on('click',function () {
            if (passport.is(':checked')) {
                $( "#comment" ).prop( "disabled", false  );
            }
            else if (checkreview()===true){$( "#comment" ).prop( "disabled", true  );}
        });
        $('#gps').on('click',function () {
            if (gps.is(':checked')) {
                $( "#comment" ).prop( "disabled", false  );
            }
            else if (checkreview()===true){$( "#comment" ).prop( "disabled", true  );}
        });
        $('#idcard').on('click',function () {
            if (idcard.is(':checked')) {
                $( "#comment" ).prop( "disabled", false  );
            }
            else if (checkreview()===true){$( "#comment" ).prop( "disabled", true  );}
        });
        $('#farminfo').on('click',function () {
            if (farm.is(':checked')) {
                $( "#comment" ).prop( "disabled", false  );
            }
            else if (checkreview()===true){$( "#comment" ).prop( "disabled", true  );}
        });
        $('#finger').on('click',function () {
            if (finger.is(':checked')) {
                $( "#comment" ).prop( "disabled", false  );
            }
            else if (checkreview()===true){$( "#comment" ).prop( "disabled", true  );}
        });



        $('#reviewcomments').on('submit', function (e){
            e.preventDefault();

            var count = $("[type='checkbox']:checked").length;

            //var $inputs = $form.find("input, select, button, textarea");
            //$inputs.prop("disabled", true);

            if(count >= 1)
            {
                $('#sbmbtn').hide();
                $('#loader').show();

                setTimeout(function(){
                    $.ajax({
                        type: 'post',
                        url: 'api/review.php',
                        data: $('#reviewcomments').serialize(),
                        success: function(response2) {
                            var result2 = $.parseJSON(response2);
                            $('#loader').hide();


                            if(result2[0]==="success")
                            {
                                $("#reviewcomments").trigger('reset');
                                swal("Reviewed", result2[1], "success");

                            }
                            else if(result2[0]==="error")
                            {
                                console.log(response2);

                                swal("Oops...", result2[1], "error");
                                $('#sbmbtn').show();


                            }
                        },
                        error: function(response2){
                            alert('Connection Time out. Try again later.');

                        }
                    });
                },2000);
            }
            else
            {
                swal("Error",'No review category selected' ,"error");
            }





            return false;
        });

        $('#deletereview').on('submit', function (e){
            e.preventDefault();

            //var $inputs = $form.find("input, select, button, textarea");
            //$inputs.prop("disabled", true);

            $('#deleterbtn').hide();
            $('#loader2').show();

            setTimeout(function(){
                $.ajax({
                    type: 'post',
                    url: 'api/review.php',
                    data: $('#deletereview').serialize(),
                    success: function(response2) {
                        var result2 = $.parseJSON(response2);
                        $('#loader2').hide();


                        if(result2[0]==="success")
                        {

                            swal("Reviewed", result2[1], "success");

                        }
                        else if(result2[0]==="error")
                        {
                            swal("Oops...", result2[1], "error");
                            $('#deleterbtn').show();


                        }
                    },
                    error: function(response2){
                        alert('Connection Time out. Try again later.');

                    }
                });
            },2000);



            return false;
        });



        var ckbox = $('#noissues');




        $('#noissues').on('click',function () {
            if (ckbox.is(':checked')) {

                $( "#comment" ).prop( "disabled", true );
                $( "#test_data" ).prop( "disabled", true );
                $('#comment').val('');
                $('#comment').prop('checked',false);
                $( "#bio" ).prop( "disabled", true );
                $('#bio').prop('checked',false);
                $( "#passport" ).prop( "disabled", true );
                $('#passport').prop('checked',false);
                $( "#idcard" ).prop( "disabled", true );
                $('#idcard').prop('checked',false);
                $( "#finger" ).prop( "disabled", true );
                $('#finger').prop('checked',false);
                $( "#farminfo" ).prop( "disabled", true );
                $('#farminfo').prop('checked',false);
                $( "#gps" ).prop( "disabled", true );
                $('#gps').prop('checked',false);
            } else {

                $( "#comment" ).prop( "disabled", false  );
                $( "#test_data" ).prop( "disabled", false  );
                $( "#bio" ).prop( "disabled", false  );
                $( "#passport" ).prop( "disabled", false  );
                $( "#idcard" ).prop( "disabled", false  );
                $( "#finger" ).prop( "disabled", false  );
                $( "#farminfo" ).prop( "disabled", false  );
                $( "#gps" ).prop( "disabled", false );
            }
        });


        $('#test_data').on('click',function () {
            if ( $('#test_data').is(':checked')) {

                $( "#comment" ).prop( "disabled", true );
                $("#noissues" ).prop( "disabled", true );
                $('#comment').val('');
                $('#comment').prop('checked',false);
                $( "#bio" ).prop( "disabled", true );
                $('#bio').prop('checked',false);
                $( "#passport" ).prop( "disabled", true );
                $('#passport').prop('checked',false);
                $( "#idcard" ).prop( "disabled", true );
                $('#idcard').prop('checked',false);
                $( "#finger" ).prop( "disabled", true );
                $('#finger').prop('checked',false);
                $( "#farminfo" ).prop( "disabled", true );
                $('#farminfo').prop('checked',false);
                $( "#gps" ).prop( "disabled", true );
                $('#gps').prop('checked',false);
            } else {

                $( "#comment" ).prop( "disabled", false  );
                $( "#noissues" ).prop( "disabled", false  );
                $( "#bio" ).prop( "disabled", false  );
                $( "#passport" ).prop( "disabled", false  );
                $( "#idcard" ).prop( "disabled", false  );
                $( "#finger" ).prop( "disabled", false  );
                $( "#farminfo" ).prop( "disabled", false  );
                $( "#gps" ).prop( "disabled", false );
            }
        });






    })
</script>
