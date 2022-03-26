<?php

$con=mysqli_connect("localhost","root","","beaver");

$zid=$_GET['zid'];
$q=mysqli_query($con,"select hq from lga where zone_id='$zid'");
$n=mysqli_num_rows($q).$zid;
//echo $n;

if ($n>0){
    while ($f=mysqli_fetch_assoc($q)){
        echo '<option value="'.$f['hq'].'" data-lga="'.$f['hq'].'">'.$f['hq'].'</option>';
    }
}
else{
    echo ''.mysqli_error($con);
}
