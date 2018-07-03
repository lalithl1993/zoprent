<?php 
session_start();
date_default_timezone_set('Asia/Calcutta');
include 'admin/config.php';
$weekday=strtolower(date("l"));
GLOBAL $weekday;
GLOBAL $uids;
$uids=$_GET['uid'];
$subs=$_GET['sub'];
$cit=$_GET['city'];

//making banner
$ban_qrys=mysql_query("select id from sub_category where name='$subs'");
$ban_ress=mysql_fetch_array($ban_qrys);
$sub_id=$ban_ress['id'];
$ban_qry=mysql_query("select main_category from sub_category where name='$subs'");
$ban_res=mysql_fetch_array($ban_qry);
$main_id=$ban_res['main_category'];
$ban_qry1=mysql_query("select banner_image from categories where id='$main_id'");
$ban_res1=mysql_fetch_array($ban_qry1);
$banner_img=$ban_res1['banner_image'];
if($banner_img=="")
{
$banner_img="assets/bg2.png";
}
//end making banner

//generating new booking id
$sql=mysql_query("select booking_id from booking_details where booking_id !='' order by id DESC");
$res=mysql_fetch_array($sql);
$pre_book=$res['booking_id'];
if($pre_book !="")
{
$get_id=explode("-",$pre_book);
$a=$get_id[0];
$b=$get_id[1]+1;
$new_id=$a."-".$b;
}
if($pre_book=="")
{
$new_id="BK-1";
}
$_SESSION['booking_id']=$new_id;
//end generating booking id

function getWorkingDays($startDate, $endDate)
{
$begin = strtotime($startDate);
$end   = strtotime($endDate);
if ($begin > $end) {
return 0;
} else {
$no_days  = 0;

while ($begin <= $end) {
$what_day = date("N", $begin);
if (!in_array($what_day, [4,5,6]) ) // 6 and 7 are weekend
$no_days++;
$begin += 86400; // +1 day
};

return $no_days;
}
}

//setting sessions if not set(delete probobly)
if(!isset($_SESSION['from_date']) or !isset($_SESSION['to_date']) )
{
$_SESSION['from_date']=date("d-m-Y");
$_SESSION['db_f_date']=date("Y-m-d");

$_SESSION['to_date']=date("d-m-Y", strtotime("+1 day"));
$_SESSION['db_t_date']=date("Y-m-d", strtotime("+1 day"));

$f_date=$_SESSION['db_f_date'];
$t_date=$_SESSION['db_t_date'];




$datetime1 = new DateTime($f_date);
$datetime2 = new DateTime($t_date);
$interval = $datetime1->diff($datetime2);
$day=$interval->format('%a');
$total_day=$day;
if($total_day==0)
{
$total_day=1;
}

$_SESSION['day']=$total_day;
$startDate=$from_date;
$endDate=$to_date;
$week_days=getWorkingDays($startDate, $endDate);
$_SESSION['days']=$week_days;

}
//end sessions


//on click of book_now(insert in db, 2mails,2sms)
if(isset($_POST['book_now']))
{
$from_time=$_POST['from_time'];
$to_time=$_POST['to_time'];
$from_date=$_POST['from_date'];
$to_date=$_POST['to_date'];

$result1=explode("-",$from_date);
$db_from_date=$result1[2]."-".$result1[1]."-".$result1[0];

$result2=explode("-",$to_date);
$db_to_date=$result2[2]."-".$result2[1]."-".$result2[0];


$user_id=$_SESSION['user_id'];

$new_ven_id=$_POST['location_user'];
$sub_category=$sub_id;
$booking_id=$_SESSION['booking_id'];
$day=$_SESSION['day'];
$days=$_SESSION['days'];
$name=$_POST['name'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$address=$_POST['address'];

$today_date=date("Y-m-d");
$current_time=date("H:i:s");


$total_price=$_SESSION['totals'];

$ins=mysql_query
("INSERT INTO booking_details(booking_id,user_id,booked_date,booked_time,name,email,phone,city,address,vendor_id,sub_category,from_date,to_date,total_price,status) 
VALUES ('$booking_id', '$user_id', '$today_date', '$current_time', '$name', '$email', '$phone', '$cit', '$address', '$new_ven_id', '$sub_category', '$db_from_date', '$db_to_date', '$total_price', 'Success')");			

$sub_qry2=mysql_query("select name from sub_category where id='$sub_category'");
$sub_res2=mysql_fetch_array($sub_qry2);
$pro_name=$sub_res2['name'];

$sub_qry3=mysql_query("select vendor_name,vendor_location from vendor where id='$new_ven_id'");
$sub_res3=mysql_fetch_array($sub_qry3);
$ven_name=$sub_res3['vendor_name'];
$ven_loc=$sub_res3['vendor_location'];

$to = 'zoprentcs@gmail.com'; 
//$to = "zoprentcs@gmail.com\r\n";
$subject = "New Request\n";
$message = "Booking Detail.\n";
$message .= "Name   : ".$name."\n";
$message .= "Email  : ".$email."\n";
$message .= "Phone  : ".$phone."\n";
$message .= "Grand Total  : Rs. ".$total_price."\n";
	$message .= "From Date  : ".$from_date."\n";
	$message .= "To Date  : ".$to_date."\n";
	$message .= "Product Name  : ".$pro_name."\n";
	$message .= "Vendor Name  : ".$ven_name."\n";
	$message .= "Vendor Location  : ".$ven_loc."\n";
$from = 'zoprent@gmail.com';
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);

$to = 'zoprent@gmail.com'; 
//$to = "zoprentcs@gmail.com\r\n";
$subject = "New Request\n";
$message = "Booking Detail.\n";

$message .= "Name   : ".$name."\n";
$message .= "Email  : ".$email."\n";
$message .= "Phone  : ".$phone."\n";
$message .= "Grand Total  : Rs. ".$total_price."\n";
	$message .= "From Date  : ".$from_date."\n";
	$message .= "To Date  : ".$to_date."\n";
	$message .= "Product Name  : ".$pro_name."\n";
	$message .= "Vendor Name  : ".$ven_name."\n";
	$message .= "Vendor Location  : ".$ven_loc."\n";
$from = 'zoprent@gmail.com';
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);

/*----------SMS START For Admin----------------------*/
	//$mobls='7338295505';
	$mobl1='7338295909';
	//$mobls='8073951672';
		
	$message  = "New Request\n";
	$message .= "Name   : ".$name."\n";
	$message .= "Email  : ".$email."\n";
	$message .= "Phone  : ".$phone."\n";
	$message .= "Grand Total  : Rs. ".$total_price."\n";
	$message .= "From Date  : ".$from_date."\n";
	$message .= "To Date  : ".$to_date."\n";
	$message .= "Product Name  : ".$pro_name."\n";
	$message .= "Vendor Name  : ".$ven_name."\n";
	$message .= "Vendor Location  : ".$ven_loc."\n";
	
	$msg=$message;
	$msg_body_final=urlencode($msg);
	
	//$URL = "mindappssms.in/submitsms.jsp?user=rentraja&key=458e7a768eXX&mobile=".$mobl."&message=".$msg_body_final."&senderid=RNTRAJ&accusage=1";
	//$URL ="http://login.jupitersms.in/api/mt/SendSMS?user=zoprent&password=Codezop3&senderid=ZOPRNT&channel=Trans&DCS=0&flashsms=0&number=".$mobl."&text=".$msg_body_final."&route=6";
$URL="http://roundsms.com/api/sendhttp.php?authkey=OTFmM2Y1ZDJkNDd&mobiles=".$mobl1."&message=".$msg_body_final."&sender=ZOPRNT&type=1&route=2";
//$URL="http://api.roundsms.in/api/SendSMS?api_id=API2072419998&api_password=zop54321&sms_type=O&encoding=T&sender_id=ZOPRNT&phonenumber=".$mobl1.",".$mobls."&textmessa$msg_body_final."";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $URL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_exec($ch);
	curl_close($ch);
	
	
	
		/*-----------SMS END Admin---------------------*/			
		
		/*----------SMS START For User----------------------*/
	
	$message="Dear ".$name."\n";
	$message .= "We have received your request. Our team will get in touch with you soon.\n";
	$message .= "www.zoprent.com";
	$msg=$message;
	$msg_body_final=urlencode($msg);
	
	//$URL = "mindappssms.in/submitsms.jsp?user=rentraja&key=458e7a768eXX&mobile=+91".$phone."&message=".$msg_body_final."&senderid=RNTRAJ&accusage=1";
	//$URL ="http://login.jupitersms.in/api/mt/SendSMS?user=zoprent&password=Codezop3&senderid=ZOPRNT&channel=Trans&DCS=0&flashsms=0&number=".$phone."&text=".$msg_body_final."&route=6";
	$URL="http://roundsms.com/api/sendhttp.php?authkey=OTFmM2Y1ZDJkNDd&mobiles=".$phone."&message=".$msg_body_final."&sender=ZOPRNT&type=1&route=2";
//$URL="http://api.roundsms.in/api/SendSMS?api_id=API2072419998&api_password=zop54321&sms_type=O&encoding=T&sender_id=ZOPRNT&phonenumber=".$mobl1."&textmessage=".$msg_body_final."";

$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $URL);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_exec($ch);
	curl_close($ch);
	
		/*-----------SMS END User---------------------*/




/**************Admin Email End*****************************/
/**************User Email Start*****************************/




header('location:thankyou.php');

}
//End book now
?>

<!DOCTYPE html>
<html lang="en">

<?php $category=$_SESSION['category'];?>
<body class="res layout-subpage">
<
<?php include 'menu1.php';?>

<h1 style="color:#fff;font-family:ab2;">Your  <?php 
//display purpose
if($category=='Bikes'){
echo 'ZopRent Bike';
}
elseif($category=='Cars'){
echo 'ZopRent Car';
}
else  {
echo 'ZopRent Stay';
}
?>  is here!</h1> 
<h5>Enjoy the journey!!</h5>



<?php

$day=$_SESSION['day'];
$days=$_SESSION['days'];
$city_id=$uids;
$db_date_from=$_SESSION['db_f_date'];
$db_date_to=$_SESSION['db_t_date'];


$i=1;
$id=array();
$ven_value="";
//$qry1=null;
//if($weekday=="friday"||$weekday=="saturday" || $weekday=="sunday"){
$qry1=mysql_query("select * from product_details where sub_category='$sub_id' and vendor_city='$city_id' order by oneday_price asc");
//}
//else
//$qry1=mysql_query("select * from product_details where sub_category='$sub_id' and vendor_city='$city_id' order by oneday_price asc");
while($res1=mysql_fetch_array($qry1))
{
$day=$_SESSION['day'];
$days=$_SESSION['days'];
$vendor_id1=$res1['vendor_id'];
$sub_id2=$res1['sub_category'];
$qty=$res1['qty'];

$sub_qry=mysql_query("select id from booking_details where (sub_category='$sub_id2' and vendor_id='$vendor_id1' )
and ((from_date between '$db_date_from' and '$db_date_to') or (to_date between '$db_date_from' and '$db_date_to')) and status='Success'");
$booked_count=mysql_num_rows($sub_qry);		
$diff=$qty-$booked_count;

if(!($diff >=1))
{
	$id[]=$vendor_id1;
}	
$i++;	
}
if(count($id)>=1)
{
$ven_value .=" vendor_id != ".implode(' and vendor_id!= ',$id)." ";
//$sub_qry2=null;
//if($weekday=="friday"||$weekday=="saturday" || $weekday=="sunday"){

$test_qry="select * from product_details where (sub_category='$sub_id' and vendor_city='$city_id') and $ven_value order by oneday_price asc";
//}	
//else					 
//$test_qry="select * from product_details where (sub_category='$sub_id' and vendor_city='$city_id') and $ven_value order by oneday_price asc";								
}
else
{
//$sub_qry2=null;
//if($weekday=="friday"||$weekday=="saturday" || $weekday=="sunday"){
$test_qry="select * from product_details where (sub_category='$sub_id' and vendor_city='$city_id') order by oneday_price asc";
//}
//else
//$test_qry="select * from product_details where (sub_category='$sub_id' and vendor_city='$city_id') order by oneday_price asc";
	}
$test=mysql_query($test_qry);
$count=mysql_num_rows($test);
$res=mysql_fetch_array($test);
$pro_id=$res['id'];
$pricen=$res['oneday_price'];
$pricew=$res['weekend'];
if($weekday=="friday"||$weekday=="saturday" || $weekday=="sunday"){
$price=$res['weekend'];
}
else
$price=$res['oneday_price'];


$terms=$res['terms_conditions'];
$tots=$day-$days;
$price1=$tots*$pricew;
$price2=$days*$pricen;
$total_price=$price1+$price2;
//$total_price=$day*$price;

$sql=mysql_query("select * from sub_category where id='$sub_id'");
$row=mysql_fetch_array($sql);
$pro_name=$row['name'];
$image=$row['image'];
$description=$row['description'];


?>

<form action="" method="POST">
<h3 ><?php echo $pro_name;?></h3>
	
		<center><img src="admin/<?php echo $image;?>" alt="Canon EOS 5D"></center>


					<p><?php echo $description;?></p>
					<?php 
				
					if($city_id ==1 || $city_id == 9 || $city_id == 20 || $city_id == 16 )
					{	
							}
							else if($city_id==10 && $category=='Cars'){
							}
							else if($city_id==11 && $category=='Cars'){
							}
							else if($city_id==19 && $category=='Cars'){
							}
							else if($city_id==22 && $category=='Cars'){
							}
							else if($city_id==21 && $category=='Bikes'){
							}
							else{
								echo '<br/><p style="color:green"><strong>* Booking for a single day? Vehicle should be return on same day.</strong></p>';
							}
							
							
							?>
					 <h3>Select Date & Location </h3>
							<?php
							
						?>
			
							
							<fieldset id="account" style="margin-left:0px;">
							<form action="" method="POST">
							  
								<label for="input-payment-firstname" class="control-label" style="font-family: ab2;color: #606062;">From Date</label>
								<input type="text" class="form-control" id="from_date" placeholder="From Date" value="<?php echo $_SESSION['from_date'];?>" name="from_date" onchange="change_date();">
							  
							 
								<label for="input-payment-firstname" class="control-label" style="font-family: ab2;color: #606062;">To Date</label>
									<input type="text" class="form-control" id="to_date" placeholder="To Date" value="<?php echo $_SESSION['to_date'];?>" name="to_date" onchange="change_date();">
								  <label>from time</label><input type="text" name="from_time"/>
								  <label>to time</label><input type="text" name="to_time"/>
							 
							</form>
							</fieldset>
						
				
				
						<?php 
			if($count>=1)
			{
						echo '
						 
			<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
					
				<div class="col-md-12" style="padding-top: 1%;font-family: ab2;">
						<div class="form-group ">
				<label for="input-payment-firstname" class="control-label"  style="font-family: ab2;font-size: 16px;color: #004066;">Select Location</label>
																				
						<select class="form-control boxs" id="loc_'.$sub_id.'_'.$pro_id.'"  name="location_user"  onchange="change_location(this.id);" 
						style="border: 1px solid #004066;font-family:ab2;width: 97%;">';
						
		$qry1=mysql_query("select * from product_details where sub_category='$sub_id' and vendor_city='$city_id' order by oneday_price asc");
		
						
						while($res1=mysql_fetch_array($qry1))
						{
							$day=$_SESSION['day'];
							$days=$_SESSION['days'];
							$vendor_id=$res1['vendor_id'];
							$sub_id1=$res1['sub_category'];
							$qty=$res1['qty'];
							
					$sub_qry=mysql_query("select id from booking_details where (sub_category='$sub_id1' and vendor_id='$vendor_id')
						and ((from_date between '$db_date_from' and '$db_date_to') or (to_date between '$db_date_from' and '$db_date_to')) and status='Success'");
					
					$booked_count=mysql_num_rows($sub_qry);		
					
					$diff=$qty-$booked_count;
						
						 $ven_prices=$res1['weekend'];
							
							
							$ven_pricew=$res1['oneday_price'];
							
							$qry2=mysql_query("select * from vendor where id='$vendor_id'");
							$res2=mysql_fetch_array($qry2);
							$ven_name=$res2['vendor_name'];
							$ven_loc=$res2['vendor_location'];
							$tots=$day-$days;
							$price1=$tots*$ven_prices;
							$price2=$days*$ven_pricew;
							$ven_total_price=$price1+$price2;
							
							if($diff>=1)
							{
								echo '<option value="'.$vendor_id.'">'.$ven_loc.'- Rs. '.$ven_total_price.' (Available)</option>';
							}
							else
							{
								echo '<option value="'.$vendor_id.'" disabled>'.$ven_loc.'- Rs. '.$ven_total_price.' (Not Available)</option>';
							}													
							
						}												
							  
						echo'</select>
					</div>
					</div>
					</div>
					</div>
					<div class="row">
					<div class="container">
								<div class="col-md-12 col-sm-12 col-xs-12">
										<div class="col-md-6">
										
											  
											<h5 style="font-size: 15px; font-weight: bold; color: #004066;">Daily Price</h5>
											<h5 style="font-size: 20px;font-weight: bold;"><i class="fa fa-inr"></i> '.$price.' / day</h5>
											
										</div>
										
										<div class="col-md-6">
											<h5 style="font-size: 15px; font-weight: bold;color: #004066;">Amount Payable</h5>
											<h5 style="font-size: 20px;font-weight: bold;"><i class="fa fa-inr"></i> '.$total_price.'</h5>
										</div>
							
								
								<a href="#terms" target="_self" style="color: #004066;font-family:ab2;font-weight:bold;">
							<input type="button" class="btn btn-info" style=" margin-top: 6%; border-radius: 4px;" value="Terms & Condition">
							</a>
						</div>
						</div>
						</div>
						';
						$_SESSION['totals']=$total_price;
						
			}
			
			else if($count<=0)
			{	
						echo '
						
			<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 ">
					
				<div class="col-md-12" style="padding-top: 1%;font-family: ab2;">
						<div class="form-group ">
					<label for="input-payment-firstname" class="control-label" style="font-family: ab2;color: #606062;">Select Location</label>
																				
						<select class="form-control" id="loc_'.$sub_id.'_'.$pro_id.'"  name="location_user"  onchange="change_location(this.id);" 
						style="border: 1px solid #004066;font-family:ab2;width: 97%;">';
						echo '<option value="">Not Available</option>';
						
		$qry1=mysql_query("select * from product_details where sub_category='$sub_id' and vendor_city='$city_id' order by oneday_price asc");
		
						
						while($res1=mysql_fetch_array($qry1))
						{
							$day=$_SESSION['day'];
							$days=$_SESSION['days'];
							$vendor_id=$res1['vendor_id'];
							$sub_id1=$res1['sub_category'];
							$qty=$res1['qty'];
							
					$sub_qry=mysql_query("select id from booking_details where (sub_category='$sub_id1' and vendor_id='$vendor_id')
						and ((from_date between '$db_date_from' and '$db_date_to') or (to_date between '$db_date_from' and '$db_date_to')) and status='Success'");
					
					$booked_count=mysql_num_rows($sub_qry);		
					
					$diff=$qty-$booked_count;
							
							$ven_prices=$res1['weekend'];
							
							$ven_pricew=$res1['oneday_price'];
							
							$qry2=mysql_query("select * from vendor where id='$vendor_id'");
							$res2=mysql_fetch_array($qry2);
							$ven_name=$res2['vendor_name'];
							$ven_loc=$res2['vendor_location'];
							$tots=$day-$days;
							$price1=$tots*$ven_prices;
							$price2=$days*$ven_pricew;
							$ven_total_price=$price1+$price2;
							
							if($diff>=1)
							{
								echo '<option value="'.$vendor_id.'">'.$ven_loc.' - Rs. '.$ven_total_price.' (Available)</option>';
							}
							else
							{
								echo '<option value="'.$vendor_id.'" disabled>'.$ven_loc.' - Rs. '.$ven_total_price.' (Not Available)</option>';
							}													
							
						}												
							  
						echo'</select>
					</div>
					</div>
					</div>
					</div>';
			}
				?>			
				
		<!-- end box info product -->
	

	
<h4 >For Booking</h4>

<br/>
<h4>Give us a missed call at <span>+91-7338295909</span><br/><br/>
		Or</h4><br/>
		<h4 class="panel-title" style="font-weight: bold;text-align:center;
		font-family: ab2;"><i class="fa fa-user"></i> Your Personal Details</h4>

				<fieldset id="account">
				 
					<label for="input-payment-firstname" class="control-label"> Name</label>
					<input type="text" class="form-control" placeholder="Name" name="name" id="name" required>
				
				   
				
					<label for="input-payment-email" class="control-label">E-Mail</label>
					<input type="email" class="form-control" id="input-payment-email" placeholder="E-Mail" name="email" required>
			
				  
				
					<label for="input-payment-telephone" class="control-label">Phone</label>
					<input type="text" class="form-control" placeholder="Phone" maxlength="10" id= "phone" name="phone" required style="display:block;">
					
			
				 
				
					<label for="input-payment-fax" class="control-label">Address</label>
			<textarea rows="2" class="form-control" id="address" name="address"  placeholder="Address"></textarea>	
		<br>
		<label class="control-label" for="confirm_agree">
				  <input type="checkbox"  value="1" required="" class="validate required" id="confirm_agree" name="confirm agree">
				  <span>I have read and agree to the <a class="agree" href="#terms" required=""><b>Terms &amp; Conditions</b></a></span> </label>
				  
					<?php
					if($count>=1)
					{
						echo '<input type="submit" class="btn btn-primary" id="book_now" name="book_now" value="Confirm Order">';
					}
					else
					{
						echo '<input type="button" class="btn btn-primary" id="book_now" name="book_now" value="Confirm Order" onclick="not_available();">';
					}
					
					?>
					
				

			
				</fieldset>

</form>



</body>

</html>
